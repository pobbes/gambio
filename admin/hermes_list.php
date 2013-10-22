<?php
/* --------------------------------------------------------------
   hermes_list.php 2011 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License
   --------------------------------------------------------------
*/

/* --------------------------------------------------------------
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com
   (c) 2003	 nextcommerce ( start.php,v 1.6 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: credits.php 1263 2005-09-30 10:14:08Z mz $)


   Released under the GNU General Public License
   --------------------------------------------------------------*/

// ALTER TABLE `admin_access` ADD `hermes_list` INT( 1 ) NOT NULL DEFAULT '0'
// update admin_access set hermes_list = 1

ob_start();
require('includes/application_top.php');
require DIR_FS_CATALOG .'/admin/includes/classes/messages.php';
require DIR_FS_CATALOG .'/includes/classes/hermes.php';

defined('GM_HTTP_SERVER') OR define('GM_HTTP_SERVER', HTTP_SERVER);
define('PAGE_URL', GM_HTTP_SERVER.DIR_WS_ADMIN.basename(__FILE__));

$hermes = new Hermes();
$messages = new Messages('hermes_messages');

if(isset($_GET['showbatch'])) {
	$labelsfile = $hermes->makeLabelsFileName();
	if(file_exists($labelsfile)) {
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment;filename=hermes_batch_'.time().'.pdf');
		readfile($labelsfile);
		exit;
	}
	else {
		xtc_redirect(PAGE_URL);
	}
}


if(isset($_REQUEST['loadlist'])) {
	ob_clean();
	if($hermes->getService() !== 'ProPS') {
		echo '<p>Der Abruf der Auftragsdaten ist nur bei Nutzung des ProfiPaketService möglich.</p>';
		exit;
	}
	$start = microtime(true);
	$propsorders = $hermes->getPropsOrders();
	if(is_array($propsorders) && isset($propsorders['code']) && isset($propsorders['message'])) {
		echo '<p class="message">'. $propsorders['code'] .' '. $propsorders['message'] .'</p>';
		ob_flush();
		exit;
	}
	//print_r($propsorders); exit();
	//<form action="" method="post">
	echo '<br><form action="" method="post" id="batchlabels">';
	echo '<button id="sel_all_top">alle ausw&auml;hlen</button>';
	echo '<button id="sel_none_top">alle abw&auml;hlen</button>';
	echo '<button id="sel_unprinted_top">ungedruckte ausw&auml;hlen</button><br>';
	echo '<input type="submit" value="Labels für alle selektierten Aufträge abrufen">';
	echo '<button id="refresh_top" style="float:right">aktualisieren</button>';
	echo '</form>';
	?>
	<table class="propsorders" id="propsorders">
		<tr>
			<th>&nbsp;</th>
			<th>Auftr.-Nr.</th>
			<th>Barcode</th>
			<th title="Datum der Auftragserzeugung">Datum</th>
			<th>Paketklasse</th>
			<th>Status</th>
			<th>Empfänger</th>
			<th>&nbsp;</th>
		</tr>
	<?php
	foreach($propsorders as $po) {
		try {
			$ho = new HermesOrder($po->orderNo);
			$ho_ordersid = $ho->orders_id;
		}
		catch(Exception $e) {
			// order not found
			$ho_ordersid = false;
		}
		$labelurl = $hermes->getLabelUrl($ho);
		echo '<tr>';
		echo '<td><input type="checkbox" name="selected['.$po->orderNo .']" value="'.$po->orderNo .'" class="orderselect"></td>';
		echo '<td class="orderno">';
		if($ho_ordersid !== false) {
			echo '<a href="'. xtc_href_link('hermes_order.php', 'orderno='.$po->orderNo.'&orders_id='.$ho_ordersid) .'">'. $po->orderNo .'</a>';
		}
		else {
			echo $po->orderNo;
		}
		echo '</td>';
		echo '<td class="shippingid" title="Klicken für Sendungsstatus"><span class="sid">'. $po->shippingId .'</span><div class="sstatus"></div></td>';
		echo '<td>'. $po->creationDate .'</td>';
		echo '<td>'. $po->parcelClass .'</td>';
		echo '<td class="status">'. $po->status .' '. $po->status_text .'</td>';
		echo '<td>'. $po->lastname .', '. $po->firstname ."<br>". $po->postcode .' '. $po->city .' ('. $po->countryCode .')</td>';
		//echo '<td><a href="'.xtc_href_link(basename(__FILE__), 'printlabel='.$po->orderNo, 'NONSSL').'">Label abrufen</a></td>';
		/*
		if($labelurl !== false) {
			echo '<td><a class="newwindow" href="'.$labelurl.'">Versandlabel</a></td>';
		}
		else {
			echo '<td></td>';
		}
		*/
		if($ho_ordersid !== false) {
			echo '<td>';
			echo '<form action="'.xtc_href_link('hermes_order.php').'" method="post" class="orderlabel">';
			echo '<input type="hidden" name="orderno" value="'.$po->orderNo.'">';
			echo '<input type="submit" name="orderprintlabel" value="Label abrufen">';
			//echo '<button class="orderprintlabel">Label abrufen</button>';
			echo '<div class="printpos">
							<input type="radio" name="printpos" value="1" title="Position 1" checked="checked">
							<input type="radio" name="printpos" value="2" title="Position 2"><br>
							<input type="radio" name="printpos" value="3" title="Position 3">
							<input type="radio" name="printpos" value="4" title="Position 4">
						</div>';
			echo '</form>';
			echo '</td>';
		}
		else {
			echo '<td></td>';
		}
		echo '</tr>';
	}	
	echo "</table>";
	echo '<br><form action="" method="post" id="batchlabels">';
	echo '<button id="sel_all">alle ausw&auml;hlen</button>';
	echo '<button id="sel_none">alle abw&auml;hlen</button>';
	echo '<button id="sel_unprinted">ungedruckte ausw&auml;hlen</button><br>';
	echo '<input type="submit" value="Labels für alle selektierten Aufträge abrufen">';
	echo '<button id="refresh" style="float:right">aktualisieren</button>';
	echo '</form>';
	//echo "<p>".(microtime(true) - $start)."s</p>";
	ob_flush();
	exit;
}

if(isset($_REQUEST['shipmentstatus'])) {
	ob_clean();
	$shipping_id = $_REQUEST['shipmentstatus'];
	try {
		$sstatus = $hermes->getShipmentStatus($shipping_id);
		echo $sstatus['text'] .'<br>' . $sstatus['datetime'];
	}
	catch(Exception $e) {
		echo 'Status kann nicht ermittelt werden.';
	}
	ob_flush();
	exit;
}

if(isset($_REQUEST['printlabel'])) {
	die('do not use this');
	$pdfdata = $hermes->getLabelPdf($_REQUEST['printlabel']);
	if(empty($pdfdata)) {
		die('Error retrieving label data');
	}
	header('Content-Type: application/pdf');
	header('Content-Disposition: attachment; filename=hermes_'.$_REQUEST['printlabel'].'.pdf');
	echo $pdfdata;
	exit;
}

if(!empty($_POST['selected'])) {
	$labelsreturn = $hermes->getLabelsPdf($_POST['selected']);
	if($labelsreturn !== false && !empty($labelsreturn['pdfdata'])) {
		/*
		header('Content-Type: application/pdf');
		header('Content-Disposition: attachment; filename=hermes_labels.pdf');
		echo $labelsreturn['pdfdata'];
		*/
		file_put_contents($hermes->makeLabelsFileName(), $labelsreturn['pdfdata']);
		foreach($labelsreturn['orderres']->OrderResponse as $or) {
			$eitems = (array)($or->exceptionItems);
			if(!empty($eitems)) {
				$messages->addMessage('Label für Auftrag '.$or->orderNo.' konnte nicht erzeugt werden.');
			}
		}
		xtc_redirect(HTTP_SERVER.DIR_WS_ADMIN.basename(__FILE__).'?showbatch=1');
		exit;
	}
	else {		
		header('Content-Type: text/plain');
		die(print_r($_POST, true));
	}
}

if(!empty($_REQUEST['messages'])) {
	foreach($messages->getMessages() as $msg) {
		echo '<p class="message">'.$msg.'</p>';
	}
	$messages->reset();
	exit;
}


/* messages */
$session_messages = $messages->getMessages();
$messages->reset();

/*
if(isset($_GET['showbatch'])) {
	header('refresh:1;'.$hermes->getLabelsUrl());
}
*/


?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
		<title><?php echo TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		<style>
		.hermesorder { font-family: sans-serif; font-size: 0.8em; }
		.hermesorder h1 { padding: 0; }
		.hermesorder a:link { font-size: inherit; text-decoration: underline; }
		.propsorders { background: #eeeeee; width: 100%; margin: auto; border-collapse: collapse; margin: 1em 0; }
		.propsorders td { }
		.propsorders td, .propsorders th { padding: .1ex .5ex; }
		.propsorders td.shippingid { cursor: pointer; width: 8em; }
		.propsorders th { background: #ccc; }
		.propsorders tr:hover { background: #ffffee !important; }
		.propsorders tr:nth-child(even) { background: #ddd; }
		.availability { float: right; width: 25em; border: 1px solid #555; background: #eee; padding: 1ex 1em; }
		.printpos { display: inline-block; margin-bottom: -4px; }
		.printpos input { vertical-align: middle; margin: 0; }
		.orderlabel * { vertical-align: middle; }
		p.message { background: #ffa; border: 1px solid #faa; padding: 1ex 1em; }
		button, input[type="submit"] { font-size: 1.0em; }
		</style>
	</head>
	<body>
		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		<!-- header_eof //-->

		<!-- body //-->
		<table border="0" width="100%" cellspacing="2" cellpadding="2">
			<tr>
				<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
					<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">

						<!-- left_navigation //-->
						<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
						<!-- left_navigation_eof //-->

					</table>
				</td>

				<td class="boxCenter hermesorder" width="100%" valign="top">
				<!-- body_text //-->
					<div class="availability">
						Verfügbarkeit der Schnittstelle wird überprüft &hellip;
					</div>
					
					<div id="messages">
					<?php foreach($session_messages as $msg): ?>
					<p class="message"><?php echo $msg ?></p>
					<?php endforeach ?>
					</div>
					
					<h2>Erfasste Aufträge</h2>
					<p>Aufträge der letzten 90 Tage. Es werden maximal 500 Aufträge angezeigt.</p>
					
					<div id="propsorders">
						Daten werden geladen ...
					</div>

				</td>
				<!-- body_text_eof //-->
				
			</tr>
		</table>
		<!-- body_eof //-->

		<!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		<!-- footer_eof //-->
		<script>
			$(function() {
				$('a.newwindow').click(function(e) {
					e.preventDefault();
					window.open($(this).attr('href'));
				});
				$('.confirm').click(function(e) {
					return window.confirm('Wirklich löschen?');
				});
				
				$('.availability').load('hermes_order.php', { 'ajax': 'checkavailability' }, function() {
						var afterlistload = function() {
							<?php if(isset($_GET['showbatch'])): ?>
							window.location = '<?php echo $hermes->getLabelsUrl() ?>';
							<?php endif ?>
						}
						if($('span.available').length > 0) {
							$('#propsorders').load('hermes_list.php', { 'loadlist': 1 }, afterlistload);
						}
						else {
							$('#propsorders').html('Daten k&ouml;nnen nicht geladen werden!');
						}
					});
				
				$('td.shippingid').live('click', function(e) {
					var sid = $('span.sid', this).text();
					var orderno = $('.orderno', $(this).parent()).text();
					if(sid != '') {
						$('div.sstatus', this).text('lade Sendungsstatus ...');
						$('div.sstatus', this).load('hermes_list.php', { 'shipmentstatus': sid } );
					}
				});
								
				$('#propsorders input.orderselect').live('change', function(e) {
					if($('#propsorders input.orderselect:checked').length > 40) {
						alert('Maximal 40 Aufträge auswählbar!');
						$(this).removeAttr('checked');
					}
				});
				
				$('#batchlabels').live('submit', function(e) {
					$('#propsorders input.orderselect:checked').each(function() {
						var orderno = $(this).val();
						$('#batchlabels').prepend($('<input type="hidden" name="selected[]" value="'+orderno+'">'));
						setTimeout(function() { $('#propsorders').load('hermes_list.php', { 'loadlist': 1 }); }, 10);
					});
				});
				
				$('#sel_all, #sel_all_top').live('click', function(e) {
					e.preventDefault();
					$('.propsorders input[type="checkbox"]').attr('checked', 'checked');
				});

				$('#sel_none, #sel_none_top').live('click', function(e) {
					e.preventDefault();
					$('.propsorders input[type="checkbox"]').removeAttr('checked');
				});

				$('#sel_unprinted, #sel_unprinted_top').live('click', function(e) {
					e.preventDefault();
					var count = 0;
					$('.propsorders tr').each(function() {
						var status = $('td.status', this).text();
						var status_no = status.replace(/(-?\d+).*/, '$1');
						switch(status_no) {
							case '2':
							case '4':
								$('input[type="checkbox"]', this).attr('checked', 'checked');
								break;
						}
					});
				});
				
				$('#refresh, #refresh_top').live('click', function(e) {
					e.preventDefault();
					$('#propsorders').html('aktualisiere &hellip;');
					$('#propsorders').load('hermes_list.php', { 'loadlist': 1 });
				});
			});
		</script>
	</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
