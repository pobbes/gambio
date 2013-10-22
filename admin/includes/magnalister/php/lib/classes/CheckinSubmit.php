<?php
/**
 * 888888ba                 dP  .88888.                    dP                
 * 88    `8b                88 d8'   `88                   88                
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b. 
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88 
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88 
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P' 
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id: CheckinSubmit.php 1594 2012-03-21 23:43:46Z MaW $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once (DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');

abstract class CheckinSubmit {
	protected $mpID = 0;
	protected $marketplace = '';
	protected $_magnasession = array();
	protected $_magnashopsession = array();
	protected $magnaConfig = array();
	protected $url = array();
	
	protected $settings = array();
	
	protected $selection = array();
	protected $badItems = array();
	protected $disabledItems = array();
	
	protected $submitSession = array();
	protected $initSession = array();
	
	protected $ajaxReply = array();
	
	protected $simpleprice = null;
	
	protected $ignoreErrors = false;
	
	private $_timer;

	protected $summaryAddText = ''; # extra Text, je nach Plattform (momentan nur bei eBay belegt)

	public function __construct($settings = array()) {
		global $_MagnaSession, $_MagnaShopSession, $magnaConfig, $_magnaQuery, $_url;
		
		$this->_timer = microtime(true);
		
		$this->mpID = $_MagnaSession['mpID'];
		$this->marketplace = $settings['marketplace'];
		
		$this->settings = array_merge(array(
			'itemsPerBatch'   => 50,
			'selectionName'   => 'checkin',
			'language'        => $_SESSION['languages_id'],
			'currency'        => DEFAULT_CURRENCY,
		), $settings);
		
		$tLang = getDBConfigValue($settings['marketplace'].'.lang', $_MagnaSession['mpID'], false);
		if ($tLang !== false) {
			$this->settings['language'] = $tLang;
		}

		$this->_magnasession = &$_MagnaSession;
		$this->_magnashopsession = &$_MagnaShopSession;
		$this->magnaConfig = &$magnaConfig;
		$this->url = $_url;
		$this->realUrl = array (
			'mp' => $this->mpID,
			'mode' => $_magnaQuery['mode'],
			'view' => $_magnaQuery['view']
		);
		
		$this->simpleprice = new SimplePrice();
		/* /!\ Muss in erbenden Klassen entsprechend des Marketplaces gesetzt werden! /!\ */
		$this->simpleprice->setCurrency($this->settings['currency']);
		
		initArrayIfNecessary($this->_magnasession, array($this->mpID, 'submit'));
		$this->submitSession = &$this->_magnasession[$this->mpID]['submit'];
		initArrayIfNecessary($this->_magnasession, array($this->mpID, 'init'));
		$this->initSession = &$this->_magnasession[$this->mpID]['init'];
	}
	
	public function init($mode, $items = -1) {
		if ($items == -1) {
			$items = (int)MagnaDB::gi()->fetchOne('
				SELECT count(*)
				  FROM '.TABLE_MAGNA_SELECTION.'
				 WHERE mpID=\''.$this->mpID.'\' AND
				       selectionname=\''.$this->settings['selectionName'].'\' AND
				       session_id=\''.session_id().'\'
			  GROUP BY selectionname
			');
		}

		/* Init all resources needed */
		$this->submitSession = array();
		$this->submitSession['state'] = array (
			'total' => $items,
			'submitted' => 0,
			'success' => 0,
			'failed' => 0
		);
		$this->submitSession['proceed'] = true;
		$this->submitSession['mode'] = $mode;
		$this->submitSession['initialmode'] = $mode;
	}
	
	abstract public function makeSelectionFromErrorLog();
	
	protected function initSelection($offset, $limit) {
		$newSelectionResult = MagnaDB::gi()->query('
			SELECT pID, data
			  FROM '.TABLE_MAGNA_SELECTION.'
			 WHERE mpID=\''.$this->mpID.'\' AND
			       selectionname=\''.$this->settings['selectionName'].'\' AND
			       session_id=\''.session_id().'\'
		  ORDER BY pID ASC
			 LIMIT '.$offset.','.$limit.'
		');
		$this->selection = array();
		while ($row = MagnaDB::gi()->fetchNext($newSelectionResult)) {
			$this->selection[$row['pID']] = unserialize($row['data']);
		}
	}
	
	private function deleteSelection() {
		foreach ($this->selection as $pID => &$data) {
			$this->badItems[] = $pID;
		}
		$this->badItems = array_merge(
			$this->badItems,
			$this->disabledItems
		);
		if (!empty($this->badItems)) {
			MagnaDB::gi()->delete(
				TABLE_MAGNA_SELECTION, 
				array(
					'mpID' => $this->mpID,
					'selectionname' => $this->settings['selectionName'],
					'session_id' => session_id()
				),
				'AND pID IN ('.implode(', ', $this->badItems).')'
			);
		}
	}
	
	protected function populateSelectionWithData() {
		foreach ($this->selection as $pID => &$data) {
			if (!isset($data['submit']) || !is_array($data['submit'])) {
				$data['submit'] = array();
			}
			
			$product = MagnaDB::gi()->getProductById($pID, $this->settings['language']);
			$mpID = $this->mpID;
			$marketplace = $this->marketplace;

			/* {Hook} "CheckinSubmit_AppendData": Enables you to extend or modify the product data.<br>
			   Variables that can be used: 
			   <ul><li>$pID: The ID of the product (Table <code>products.products_id</code>).</li>
			       <li>$product: The data of the product (Tables <code>products</code>, <code>products_description</code>,
			           <code>products_images</code> and <code>products_vpe</code>).</li>
			       <li>$data: The data of the product from the preparation tables of the marketplace.</li>
			       <li>$mpID: The ID of the marketplace.</li>
			       <li>$marketplace: The name of the marketplace.</li>
			   </ul>
			   <code>$product</code> and <code>$data</code> will be used to generate the <code>AddItems</code> request.
			 */
			if (($hp = magnaContribVerify('CheckinSubmit_AppendData', 1)) !== false) {
				require($hp);
			}
			
			$this->appendAdditionalData($pID, $product, $data);

			/* {Hook} "CheckinSubmit_PostAppendData": Enables you to extend or modify the product data, after our data processing.<br>
			   Variables that can be used: same as for CheckinSubmit_AppendData.
			 */
			if (($hp = magnaContribVerify('CheckinSubmit_PostAppendData', 1)) !== false) {
				require($hp);
			}
		}
	}

	protected function requirementsMet($product, $requirements, &$failed) {
		if (!is_array($product) || empty($product) || !is_array($requirements) || empty($requirements)) {
			$failed = true;
			return false;
		}
		$failed = array();
		foreach ($requirements as $req => $needed) {
			if (!$needed) continue;
			if (empty($product[$req]) && ($product[$req] !== '0')) {
				$failed[] = $req;
			}
		}
		return empty($failed);
	}
	
	abstract protected function appendAdditionalData($pID, $product, &$data);
	abstract protected function filterSelection();

	abstract protected function generateRequestHeader();
	
	abstract protected function generateRedirectURL($state);

	protected function processException($e) {}

	protected function sendRequest($abort = false) {
		$retResponse = array ();
		
		$request = $this->generateRequestHeader();
		$request['DATA'] = array();
		
		foreach ($this->selection as $pID => &$data) {
			$request['DATA'][] = $data['submit'];
		}
		arrayEntitiesToUTF8($request['DATA']);
		
		$this->preSubmit($request);
		
		$this->ajaxReply['ignoreErrors'] = true;
		
		try {
			/* Hau raus! :D */
			if ($abort) {
				die(print_m(json_indent(json_encode($request))));
				die(var_export_pre($request, '$request'));
			}
			#file_put_contents(dirname(__FILE__).'/submit.log', var_dump_pre($request, '$request', true));
			$checkInResult = MagnaConnector::gi()->submitRequest($request);
			//$checkInResult = array('BATCHID' => rand(623442334, 827584823));
			//$this->ajaxReply['result'] = $checkInResult;
			
			$this->processSubmitResult($checkInResult);
			$this->submitSession['state']['success'] += count($this->selection);
			$this->submitSession['state']['failed']  += count($this->badItems);
			
			if (isset($this->submitSession['api'])) {
				unset($this->submitSession['api']);
			}
			$retResponse = $checkInResult;

		} catch (MagnaException $e) {
			$this->submitSession['state']['failed']  += count($this->badItems) + count($this->selection);

			$this->ajaxReply['exception'] = $e->getMessage();
			$eA = $this->submitSession['api']['exception'] = $e->getErrorArray();
			
			$subsystem = $e->getSubsystem();
			if (($subsystem != 'Core') || ($subsystem != 'PHP')) {
				$this->ajaxReply['ignoreErrors'] = $this->ignoreErrors;
			} else {
				$this->ajaxReply['ignoreErrors'] = false;
			}
			
			//$this->ajaxReply['request'] = $this->submitSession['api']['exception']['REQUEST'];
			if (is_array($this->submitSession['api']['exception']) && array_key_exists('REQUEST', $this->submitSession['api']['exception'])) {
				unset($this->submitSession['api']['exception']['REQUEST']);
			}
			$this->ajaxReply['redirect'] = toURL(array(
				'mp' => $this->realUrl['mp'],
				'mode'   => $this->realUrl['mode']
			));
			$retResponse = $this->submitSession['api']['exception'];
			
			$this->processException($e);
		}
		return $retResponse;
	}
	
	protected function preSubmit(&$request) {}
	
	abstract protected function postSubmit();
	abstract protected function processSubmitResult($result);

	protected function generateCustomErrorHTML() {
		return false;
	}

	public function submit($abort = false) {
		$this->initSelection(0, $this->settings['itemsPerBatch']);
		$this->ajaxReply['itemsPerBatch'] = $this->settings['itemsPerBatch'];

		/* Spaetestens beim 2. Durchgang muessen die Artukel hinzugefuegt werden,
		   da sie sonst die Artikel des 1. Durchganges zuvor loeschen wuerden. */
		if ($this->submitSession['state']['submitted'] > 0) {
			$this->submitSession['mode'] = 'ADD';
		}
		
		$this->submitSession['state']['submitted'] += count($this->selection);
		
		$this->populateSelectionWithData();
		$this->filterSelection();
		
		/* Wenn Artikel deaktiviert wurden (nicht fehlgeschlagen, z. B. Artikelanzahl == 0), 
		   werden sie nicht mit uebermittelt */
		$this->submitSession['state']['total'] -= count($this->disabledItems);
		$this->submitSession['state']['submitted'] -= count($this->disabledItems);
		/*
		echo print_m($this->selection);
		die();
		*/

		if (!empty($this->selection)) {
			MagnaConnector::gi()->setTimeOutInSeconds(600);
			@set_time_limit(600);
			$this->sendRequest($abort || isset($_GET['abort']));
			MagnaConnector::gi()->resetTimeOut();
		} else {
			$this->submitSession['state']['failed']  += count($this->badItems);
		}
		
		if (isset($this->submitSession['selectionFromErrorLog']) && !empty($this->submitSession['selectionFromErrorLog'])) {
			$this->submitSession['selectionFromErrorLog'] = array_diff($this->submitSession['selectionFromErrorLog'], $this->badItems);
		}

		//$this->ajaxReply['debug'] = print_m($this->submitSession, 'submitSession');
		$this->ajaxReply['state'] = $this->submitSession['state'];

		if (!empty($this->submitSession['api'])) {
			$this->ajaxReply['proceed'] = $this->submitSession['proceed'] = $this->ajaxReply['ignoreErrors'];
			$this->ajaxReply['api'] = $this->submitSession['api'];
			/* Firstly let us process the exceptions. If we analyse them and decide, that some of them are not
			 * critical, they'll not apper... */
			$this->ajaxReply['api']['customhtml'] = $this->generateCustomErrorHTML();
			/* ... in the following list. */
			$this->ajaxReply['api']['html'] = MagnaError::gi()->exceptionsToHTML(false);
			
			#print_r($this->ajaxReply['api']['exception']);
		}

		if (empty($this->submitSession['api']) || $this->ajaxReply['ignoreErrors']) {
			$this->deleteSelection();

			if ($this->submitSession['state']['submitted'] >= $this->submitSession['state']['total']) {
				$this->ajaxReply['proceed'] = $this->submitSession['proceed'] = false;
				/* Auswertung... */
				if ($this->submitSession['state']['success'] != $this->submitSession['state']['total']) {
					/* Irgendwelche Fehler sind aufgetreten */
					$this->ajaxReply['redirect'] = $this->generateRedirectURL('fail');
				} else {
					$this->ajaxReply['redirect'] = $this->generateRedirectURL('success');
				}
				
				if ($this->submitSession['state']['success'] > 0) {
					$this->postSubmit();
					if (isset($this->submitSession['selectionFromErrorLog'])) {
						unset($this->submitSession['selectionFromErrorLog']);
					}
				}
				$this->ajaxReply['finaldialogs'] = $this->getFinalDialogs();
			} else {
				$this->ajaxReply['proceed'] = $this->submitSession['proceed'] = true;
			}
		}

		//header('Content-Type: text/plain; charset=utf-8');

		$this->ajaxReply['timer'] = microtime2human(microtime(true) -  $this->_timer);
		$this->ajaxReply['memory'] = memory_usage();
		
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Thu, 01 Jan 1970 00:00:00 GMT');
		header('Content-type: application/json');
		return json_encode($this->ajaxReply);
	}
	
	protected function getFinalDialogs() {
		/* Example:
		return array (
			array (
				'headline' => 'Eine Ueberschrift',
				'message' => 'Der Inhalt'
			),
			...
		);
		*/
		return array();
	}
	
	public function renderBasicHTMLStructure() {
		//$this->initSelection(0, $this->settings['itemsPerBatch']);
		//$this->populateSelectionWithData();		
		
		//$html = print_m($this->selection, '$this->selection').'
		$html = '
			<div id="checkinSubmit">
				<h1 id="threeDots">
					<span id="headline">'.ML_HEADLINE_SUBMIT_PRODUCTS.'</span><span class="alldots"
						><span class="dot">.</span><span class="dot">.</span><span class="dot">.</span>&nbsp;
					</span>
				</h1>
				<hr/>
				<p>'.ML_NOTICE_SUBMIT_PRODUCTS.'</p>
				<div id="apiException" style="display:none;"><p class="errorBox">'.ML_ERROR_SUBMIT_PRODUCTS.'</p></div>
				<p id="checkinSubmitStatus" class="paddingBottom"></p>
				<div style="display:none;text-align:left;" id="checkinSubmitDebug">'.print_m($this->submitSession, 'submitSession').'</div>
				<div id="dialogContainer">
					<div id="infodiag" class="dialog2" title="'.ML_LABEL_INFORMATION.'"></div>
				</div>
			</div>
		';
		if (isset($_GET['abort'])) {
			$this->realUrl['abort'] = 'true';
		}
		ob_start();?>
<script type="text/javascript">/*<![CDATA[*/
function processDialogs(dialogs) {
	dialogContainer = $('#dialogContainer');
	for (i = 0; i < dialogs.length; ++i) {
		myConsole.log(dialogs[i]);
		dialogContainer.append('<div id="infodiag'+i+'" class="dialog2"></div>');
		$('#infodiag'+i).html(dialogs[i].message).jDialog({
			modal: false,
			title: dialogs[i].headline
		});
	}
}
function runSubmitBatch() {
	jQuery.ajax({
		type: 'GET',
		url: '<?php echo toURL($this->realUrl, array('kind' => 'ajax'), true); ?>',
		success: function(data) {
			myConsole.log(data);
<?php if (isset($_GET['abort'])) { ?>
			$('#checkinSubmitDebug').html(
				'<a href="<?php echo toURL($this->realUrl, array('kind' => 'ajax'), true); ?>" target="_blank">Rerun</a>\n\n'
				+data
			).css({'display': 'block'});
			return true;
<?php } ?>
			if (typeof data != "object") {
				btn = $('<button class="button">+</button>').click(function () {
					$('#checkinSubmitDebug').css({'display': 'block'});
				});
				$('#checkinSubmitStatus').html(
					'<?php echo ML_ERROR_CREATING_REQUEST; ?>'
				);
				$('#checkinSubmitStatus').append(btn);
				$('#checkinSubmitDebug').html(data);
				stopAnimations();
				return false;
			}
			$('#checkinSubmitStatus').html(strformat(
				'<?php echo ML_STATUS_SUBMIT_PRODUCTS; ?>', 
				data.state.success+'', data.state.submitted+'', data.state.total+''
			));
			if (typeof data.api != 'undefined') {
				$('#magnaErrors div:first').append(data.api.html);
				if (data.api.html != '') {
					$('#magnaErrors').css({'display':'block'});
					$('#apiException').css({'display':'block'});
				}
				if ($('#magnaErrorsCustom').length == 0) {
					$('<div id="magnaErrorsCustom"></div>').insertAfter('#magnaErrors');
				}
				if (typeof data.api.customhtml == 'string') {
					$('#magnaErrorsCustom').append(data.api.customhtml);
				}
			}
			if (data.proceed) {
				runSubmitBatch();
			} else {
				stopAnimations();
				if ((typeof data.api == 'undefined') || (data.ignoreErrors == true)) {
					$('#infodiag').html(strformat(
						'<?php echo str_replace(array("\n\r", "\r", "\n"), '\\n', ML_STATUS_SUBMIT_PRODUCTS_SUMMARY.$this->summaryAddText); ?>', 
						data.state.success+'', data.state.total+''
					)).attr('title', '<?php echo ML_LABEL_INFORMATION; ?>').jDialog({
						buttons: {
							'<?php echo ML_BUTTON_LABEL_OK; ?>': function() {
								if (data.redirect != undefined) {
									window.location.href = data.redirect;
									$.blockUI(blockUILoading);
									$(this).dialog('close');
								} else {
									$(this).dialog('close');
								}
							}
						}
					});
					if (data.finaldialogs.length > 0) {
						processDialogs(data.finaldialogs);
					}
				}
			}
			myConsole.log(data);
		}
	});
}

/**
 * Pulse plugin for jQuery 
 * ---
 * @author James Padolsey (http://james.padolsey.com)
 * @version 0.2
 * @updated 16-DEC-09
 * ---
 * Note: In order to animate color properties, you need
 * the color plugin from here: http://plugins.jquery.com/project/color
 * ---
 * @info http://james.padolsey.com/javascript/simple-pulse-plugin-for-jquery/
 *
 * Small modifications by Alexander Papst (http://derpapst.eu)
 */
jQuery.fn.pulse = function( settings ) {
    settings = jQuery.extend({
		prop: {
			opacity: [0.2, 1]
		},
		speed: 1000,
		times: -1,
		easing: 'linear',
		callback: function() {}
	}, settings);
    
    var optall = jQuery.speed(settings.speed, settings.easing, settings.callback),
        queue = optall.queue !== false,
        largest = 0;
        
    var prop = settings.prop;
    
    for (var p in prop) {
        largest = Math.max(prop[p].length, largest);
    }
    
    optall.times = optall.times || settings.times;
    
    return this[queue?'queue':'each'](function(){
        
        var counts = {},
            opt = jQuery.extend({}, optall),
            self = jQuery(this);
            
        pulse();
        
        function pulse() {
            
            var propsSingle = {},
                doAnimate = false;
            
            for (var p in prop) {
                
                // Make sure counter is setup for current prop
                counts[p] = counts[p] || {runs:0,cur:-1};
                
                // Set "cur" to reflect new position in pulse array
                if ( counts[p].cur < prop[p].length - 1 ) {
                    ++counts[p].cur;
                } else {
                    // Reset to beginning of pulse array
                    counts[p].cur = 0;
                    ++counts[p].runs;
                }
                
                if ( prop[p].length === largest ) {
                    doAnimate = (opt.times > counts[p].runs) || (opt.times == -1);
                }
                
                propsSingle[p] = prop[p][counts[p].cur];
                
            }
            
            opt.complete = pulse;
            opt.queue = false;
            
            if (doAnimate) {
                self.animate(propsSingle, opt);
            } else {
                optall.complete.call(self[0]);
            }
        }
    });
};
function fadeDots() {
    if ($("#threeDots span.dot:hidden:first").length == 1) {
    	$("#threeDots span.dot:hidden:first").fadeIn(900);
    } else {
    	$("#threeDots span.dot").fadeOut(800, function() {
    		$("#threeDots span.dot").css({'display':'none'});
    	});
    }
}
function stopAnimations() {
	clearInterval(threeDotsIntervall);
	$('#threeDots').stop().css({'opacity': 1});	
}

var threeDotsIntervall = null;
$(document).ready(function() {
	$('#checkinSubmitStatus').html(strformat(
		'<?php echo ML_STATUS_SUBMIT_PRODUCTS; ?>', 
		'0', '0', '<?php echo $this->submitSession['state']['total']; ?>'
	));
	
	threeDotsIntervall = setInterval(function () {
		fadeDots();
    }, 1000);
    
	$('#threeDots').pulse({
		prop: {
			opacity: [0.4, 1]
		}
	});
	
	runSubmitBatch();
});
/*]]>*/</script>
<?php
		$html .= ob_get_contents();	
		ob_end_clean();
		return $html;
	}
}
