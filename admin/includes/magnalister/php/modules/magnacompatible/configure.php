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
 * $Id$
 *
 * (c) 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/Configurator.php');
include_once(DIR_MAGNALISTER_INCLUDES.'lib/configFunctions.php');

class MagnaCompatibleConfigure extends MagnaCompatibleBase {
	protected $marketplace = '';
	protected $marketplaceTitle = '';
	protected $mpID = 0;
	protected $lang = '';
	protected $isAjax = false;
	protected $authConfigKeys = array();
	protected $missingConfigKeys = array();

	protected $form = array ();
	protected $boxes = '';
	
	public function __construct(&$params) {
		global $_modules, $_lang;
		
		parent::__construct($params);
		$this->marketplaceTitle = $_modules[$this->marketplace]['title'];
		
		$this->lang = $_lang;
	}
	
	protected function formExists($name) {
		$path = '%s/%s.form';
		$lpath = sprintf($path, strtolower($this->marketplace), $name);
		if (file_exists(DIR_MAGNALISTER.'config/'.$this->lang.'/'.$lpath)) {
			return $lpath;
		}
		$lpath = sprintf($path, 'modules', $name);
		if (file_exists(DIR_MAGNALISTER.'config/'.$this->lang.'/'.$lpath)) {
			return $lpath;
		}
		return false;
	}
	
	protected function getFormFiles() {
		return array (
			'login', 'prepare', 'checkin', 
			'price', 'inventorysync', 'orders'
		);
	}
	
	protected function getForms($files = array()) {
		if (empty($files)) {
			$files = $this->getFormFiles();
		}
		$forms = array();
		foreach ($files as $f) {
			if (($f = $this->formExists($f)) === false) continue;
			$forms[$f] = array();
		}
		return $forms;
	}
	
	protected function loadConfigFormFile($file, $replace = array(), $unset = array()) {
		$fC = file_get_contents($file);
		if (!empty($replace)) {
			$fC = str_replace(array_keys($replace), array_values($replace), $fC);
		}
		$fC = json_decode($fC, true);
		if (!empty($unset)) {
			foreach ($unset as $key) {
				unset($fC[$key]);
			}
		}
		return $fC;
	}

	protected function loadConfigForm($files, $replace = array()) {
		$form = array();
		foreach ($files as $file => $options) {
			$fC = $this->loadConfigFormFile(
				DIR_MAGNALISTER.'config/'.$this->lang.'/'.$file,
				$replace,
				array_key_exists('unset', $options) ? $options['unset'] : array()
			);
			$form = array_merge_recursive_simple($form, $fC);
		}
		return $form;
	}

	protected function loadChoiseValues() {
		if (isset($this->form['prepare']['fields']['lang'])) {
			getLanguages($this->form['prepare']['fields']['lang']);
		}
		if (isset($this->form['price']['fields']['whichprice'])) {
			getCustomersStatus($this->form['price']['fields']['whichprice'], false);
			if (!empty($this->form['price']['fields']['whichprice'])) {
				$this->form['price']['fields']['whichprice']['values']['0'] = ML_LABEL_SHOP_PRICE;
				ksort($this->form['price']['fields']['whichprice']['values']);
			} else {
				unset($this->form['price']['fields']['whichprice']);
			}
		}
		if (isset($this->form['orders']['fields']['openstatus'])) {
			getOrderStatus($this->form['orders']['fields']['openstatus']);
			getCustomersStatus($this->form['orders']['fields']['customersgroup']);	
		}
		if (isset($this->form['orders']['fields']['defaultshipping'])) {
			getShippingModules($this->form['orders']['fields']['defaultshipping']);
		}
		if (isset($this->form['orders']['fields']['defaultpayment'])) {
			getPaymentModules($this->form['orders']['fields']['defaultpayment']);
		}
	}

	protected function renderAuthError() {
		$authError = getDBConfigValue($this->marketplace.'.autherror', $this->mpID, '');
		$mpTimeOut = false;
		$errors = array();
		if (is_array($authError) && !empty($authError) 
			&& isset($authError['ERRORS']) && !empty($authError['ERRORS'])
		) {
			foreach ($authError['ERRORS'] as $err) {
				$errors[] = $err['ERRORMESSAGE'];
				if (isset($err['ERRORCODE']) && ($err['ERRORCODE'] == 'MARKETPLACE_TIMEOUT')) {
					$mpTimeOut = true;
				}
			}
		}
		if ($mpTimeOut) {
			return '<p class="errorBox">
				<span class="error bold larger">'.ML_ERROR_LABEL.':</span>
				'.ML_ERROR_MARKETPLACE_TIMEOUT.'
			</p>';
		}
	    return '<p class="errorBox">
	     	<span class="error bold larger">'.ML_ERROR_LABEL.':</span>
	     	'.sprintf(ML_MAGNACOMPAT_ERROR_ACCESS_DENIED, $this->marketplaceTitle).(
	     		(!empty($errors))
	     			? '<br /><br />'.implode('<br />', $errors)
	     			: ''
	     	).'</p>';
	}
	
	protected function processPasswordFromPost($key, $val) {
		/* password already saved */
		if (empty($val) && (getDBConfigValue($this->marketplace.'.'.$key, $this->mpID) == '__saved__')) {
			return '__saved__';
		}
		/* Invalid passwords */
		if (empty($val)
		    /*               Windows                                Mac                */
			|| (strpos($val, '&#9679;') !== false) || (strpos($val, '&#8226;') !== false)
		) {
			return false;
		}

		return $val;
	}

	protected function getAuthValuesFromPost() {
		$nUser = trim($_POST['conf'][$this->marketplace.'.username']);
		$nPass = trim($_POST['conf'][$this->marketplace.'.password']);
		$nPass = $this->processPasswordFromPost('password', $nPass);
		
		if (empty($nUser)) {
			unset($_POST['conf'][$this->marketplace.'.username']);
		}
		if ($nPass === false) {
			unset($_POST['conf'][$this->marketplace.'.password']);
			return false;
		}
		return array (
			'USERNAME' => $nUser,
			'PASSWORD' => $nPass,
		);
	}

	private function processAuth() {
		$auth = getDBConfigValue($this->marketplace.'.authed', $this->mpID, false);
		if ((!is_array($auth) || !$auth['state']) &&
			allRequiredConfigKeysAvailable($this->authConfigKeys, $this->mpID) && 
			!(
				array_key_exists('conf', $_POST) && 
				allRequiredConfigKeysAvailable($this->authConfigKeys, $this->mpID, $_POST['conf'])
			)
		) {
		    $this->boxes .= $this->renderAuthError($authError);
		}		

		if (!array_key_exists('conf', $_POST)) {
			return;
		}
	    $nUser = trim($_POST['conf'][$this->marketplace.'.username']);
	    $nPass = trim($_POST['conf'][$this->marketplace.'.password']);
	
		if (!empty($nUser) && (getDBConfigValue($this->marketplace.'.password', $this->mpID) == '__saved__') 
		    && empty($nPass)
		) {
			$nPass = '__saved__';
		}
	
		if (($request = $this->getAuthValuesFromPost()) !== false) {
			setDBConfigValue($this->marketplace.'.authed', $this->mpID, array (
				'state' => false,
				'expire' => time()
			), true);
			foreach ($request as $v) {
				if (empty($v)) return;
			}

			$request['ACTION'] = 'SetCredentials';
	        try {
	            $result = MagnaConnector::gi()->submitRequest($request);
	            $this->boxes .= '
	                <p class="successBox">'.ML_GENERIC_STATUS_LOGIN_SAVED.'</p>
	            ';
	        } catch (MagnaException $e) {
	            $this->boxes .= '
	                <p class="errorBox">'.ML_GENERIC_STATUS_LOGIN_SAVEERROR.'</p>
	            ';
	        }
			try {
				MagnaConnector::gi()->submitRequest(array(
					'ACTION' => 'IsAuthed',
				));
				$auth = array (
					'state' => true,
					'expire' => time() + 60 * 30
				);
				setDBConfigValue($this->marketplace.'.authed', $this->mpID, $auth, true);
			} catch (MagnaException $e) {
				$e->setCriticalStatus(false);
				$boxes .= $this->renderAuthError($e->getErrorArray());
			}

		} else {
	        $this->boxes .= '
	            <p class="errorBox">'.ML_ERROR_INVALID_PASSWORD.'</p>
	        ';
		}
	
	}
	
	/* Can be extendet by extending classes */
	protected function finalizeForm() { }

	public function process() {
		$this->form = $this->loadConfigForm(
			$this->getForms(), 
			array(
				'_#_platform_#_' => $this->marketplace,
				'_#_platformName_#_' => $this->marketplaceTitle
			)
		);
		$this->loadChoiseValues();	
		$this->processAuth();
		$this->finalizeForm();
		
		$cG = new Configurator($this->form, $this->mpID, 'conf_magnacompat');
		$cG->setRenderTabIdent(true);
		$allCorrect = $cG->processPOST($keysToSubmit);

		if ($this->isAjax) {
			echo $cG->processAjaxRequest();
		} else {
			echo $this->boxes;
			if (array_key_exists('sendTestmail', $_POST)) {
				if ($allCorrect) {
					if (sendTestMail($this->mpID)) {
						echo '<p class="successBox">'.ML_GENERIC_TESTMAIL_SENT.'</p>';
					} else {
						echo '<p class="successBox">'.ML_GENERIC_TESTMAIL_SENT_FAIL.'</p>';
					}
				} else {
					echo '<p class="noticeBox">'.ML_GENERIC_NO_TESTMAIL_SENT.'</p>';
				}
			}
			echo $cG->renderConfigForm();
		}
	}
}