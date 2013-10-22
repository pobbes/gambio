<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/
class heidelpay
{
	var $version    = 'Standard 11.07';
	var $response   = '';
	var $error      = '';

	#var $live_url   = 'https://ctpe.net/frontend/payment.prc';
	#var $demo_url   = 'https://test.ctpe.net/frontend/payment.prc';
	var $live_url   = 'https://heidelpay.hpcgw.net/sgw/gtw';
	var $demo_url   = 'https://test-heidelpay.hpcgw.net/sgw/gtw';

	var $availablePayments = array('CC','DD','DC','VA','OT','IV','PP','UA');
	var $pageURL = '';
	var $actualPaymethod = 'CC';
	var $url;

	var $importantPPFields = array(
    'PRESENTATION_AMOUNT', 
    'PRESENTATION_CURRENCY', 
    'CONNECTOR_ACCOUNT_COUNTRY', 
    'CONNECTOR_ACCOUNT_HOLDER', 
    'CONNECTOR_ACCOUNT_NUMBER', 
    'CONNECTOR_ACCOUNT_BANK',
    'CONNECTOR_ACCOUNT_BIC', 
	'CONNECTOR_ACCOUNT_IBAN',
    'IDENTIFICATION_SHORTID',
	);

	function heidelpay()/*{{{*/
	{
		ob_start();
		$this->pageURL = GM_HTTP_SERVER.'';
	}/*}}}*/

	function handleRegister($order, $payCode)/*{{{*/
	{
		$debug = false;
		$ACT_MOD_MODE = constant('MODULE_PAYMENT_HP'.strtoupper($this->actualPaymethod).'_MODULE_MODE');
		if ($ACT_MOD_MODE == 'AFTER') { return false ; };
		#echo '<pre>'.print_r($order, 1).'</pre>';
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$currency_value = $order->info['currency_value'];
		if (empty($currency_value)) $currency_value = 1.0;

		$user_id  = $_SESSION['customer_id'];
		$orderId  = 'User '.$user_id.'-'.date('YmdHis');
		$amount   = $total; // * $currency_value;
		$currency = $order->info['currency'];
		$language = $_SESSION['language_code']=='de'?'DE':'EN';
		$userData = array(
      'firstname' => $order->billing['firstname'],
      'lastname'  => $order->billing['lastname'],
      'salutation'=> ($order->customer['gender']=='f' ? 'MRS' : 'MR'),
      'street'    => $order->billing['street_address'],
      'zip'       => $order->billing['postcode'],
      'city'      => $order->billing['city'],
      'country'   => $order->billing['country']['iso_code_2'],
      'email'     => $order->customer['email_address'],
      'ip'        => $_SERVER['REMOTE_ADDR'],
		);
		$payMethod = 'RG';
		$data = $this->prepareData($orderId, $amount, $currency, $payCode, $userData, $language, $payMethod);
		if ($debug) echo '<pre>'.print_r($data, 1).'</pre>';
		$res = $this->doRequest($data);
		if ($debug) echo '<pre>resp('.print_r($this->response, 1).')</pre>';
		if ($debug) echo '<pre>'.print_r($res, 1).'</pre>';
		$res = $this->parseResult($res);
		if ($debug) echo '<pre>'.print_r($res, 1).'</pre>';
		$processingresult = $res['result'];
		$redirectURL      = $res['url'];
		$base = 'heidelpay_redirect.php?';
		$src = $base."payment_error=hp".strtolower($this->actualPaymethod).'&error='.$res['all']['PROCESSING.RETURN'].'&'.session_name().'='.session_id();
		if ($processingresult == "ACK" && strstr($redirectURL,"http")) {
			$src = $redirectURL;
		}
		if ($debug) {
			echo $src;
			exit();
		}
		$_SESSION['HEIDELPAY_FRAMEURL'] = $src ;
		$ReturnSrc = "heidelpay_iframe.php?HpReturn=1&".session_name().'='.session_id();
		return $ReturnSrc;
	}/*}}}*/

	function handleDebit($order, $payCode, $insertId = NULL)/*{{{*/
	{
		$debug = false;

		$ReturnSrc = "heidelpay_iframe.php?HpReturn=1&".session_name().'='.session_id();
		
		$ACT_MOD_MODE = @constant('MODULE_PAYMENT_HP'.strtoupper($this->actualPaymethod).'_MODULE_MODE');
		if (!in_array($ACT_MOD_MODE, array('DIRECT', 'AFTER', 'NOWPF'))) $ACT_MOD_MODE = 'AFTER';
		$ACT_PAY_MODE = @constant('MODULE_PAYMENT_HP'.strtoupper($this->actualPaymethod).'_PAY_MODE');
		if (!in_array($ACT_PAY_MODE, array('DB', 'PA'))) $ACT_PAY_MODE = 'DB';
		#echo '<pre>'.print_r($order, 1).'</pre>';

		$user_id  = $_SESSION['hpLastData']['user_id'];
		$orderId  = 'User '.$user_id.'-'.date('YmdHis');
		if ($insertId > 0) $orderId = 'User '.$user_id.' Order '.$insertId;
		$amount   = $_SESSION['hpLastData']['amount'];
		// Fix für Preisänderungen während der Bezahlung
		#if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
		#  $total = preg_replace('/[\D]*/', '', $order->info['total']) + $order->info['tax'];
		#} else {
		#  $total = preg_replace('/[\D]*/', '', $order->info['total']);
		#}
		#$amount   = sprintf('%1.2f', $total/100);
		$currency = $_SESSION['hpLastData']['currency'];
		$language = $_SESSION['hpLastData']['language'];
		$userData = $_SESSION['hpLastData']['userData'];
		if ($debug) echo '<pre>SESSION: '.print_r($_SESSION['hpLastData'], 1).'</pre>';
		$capture = false;
		if ($ACT_MOD_MODE == 'DIRECT') $capture = true;
		// Special CC Reuse
		if (!empty($_SESSION['hpUseUniqueId'])){
			$capture = true;
			$_SESSION['hpUniqueID'] = $_SESSION['hpUseUniqueId'];
		}
		$payMethod = $ACT_PAY_MODE;
		$changePayType = array('gp', 'su', 'tp', 'idl', 'eps');
		if (in_array($payCode, $changePayType)) $payCode = 'OT';
		if ($payCode == 'ppal') $payCode = 'VA';
		if (empty($payMethod)) $payMethod = 'DB';
		if ($payCode == 'OT' && $payMethod == 'DB') $payMethod = 'PA';
		if (strtoupper($payCode) == 'PP' && $payMethod == 'DB') $payMethod = 'PA'; // Vorkasse immer PA
		$data = $this->prepareData($orderId, $amount, $currency, $payCode, $userData, $language, $payMethod, $capture, $_SESSION['hpUniqueID']);
		if ($debug) echo '<pre>'.print_r($data, 1).'</pre>';
		$res = $this->doRequest($data);
		if ($debug) echo '<pre>resp('.print_r($this->response, 1).')</pre>';
		if ($debug) echo '<pre>'.print_r($res, 1).'</pre>';
		$res = $this->parseResult($res);
		if ($debug) echo '<pre>'.print_r($res, 1).'</pre>';
		$_SESSION['HEIDELPAY_IFRAME'] = false;
		$_SESSION['HEIDELPAY_FRAMEURL'] = false;
		// 3D Secure
		if ($res['all']['PROCESSING.STATUS.CODE'] == '80' && $res['all']['PROCESSING.RETURN.CODE'] == '000.200.000' && $res['all']['PROCESSING.REASON.CODE'] == '00'){
			$src = $res['all']['PROCESSING.REDIRECT.URL'];
			$hpIframe = '<iframe src="about:blank" frameborder="0" width="400" height="800" name="heidelpay_frame"></iframe>';
			$hpIframe.= '<form method="post" action="'.$src.'" target="heidelpay_frame" id="heidelpay_form">';
			$hpIframe.= '<input type="hidden" name="TermUrl" value="'.$res['all']['PROCESSING.REDIRECT.PARAMETER.TermUrl'].'">';
			$hpIframe.= '<input type="hidden" name="PaReq" value="'.$res['all']['PROCESSING.REDIRECT.PARAMETER.PaReq'].'">';
			$hpIframe.= '<input type="hidden" name="MD" value="'.$res['all']['PROCESSING.REDIRECT.PARAMETER.MD'].'">';
			$hpIframe.= '</form>';
			$hpIframe.= '<script>document.getElementById("heidelpay_form").submit();</script>';
			if (gm_get_conf('GM_LIGHTBOX_CHECKOUT')) {
				GLOBAL $smarty;
				$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CHECKOUT'));
				if($_SESSION['style_edit_mode'] == 'edit') $smarty->assign('STYLE_EDIT', 1);
				else $smarty->assign('STYLE_EDIT', 0);
				$smarty->assign('language', $_SESSION['language']);
				$smarty->assign('content', '<center>'.$hpIframe.'</center>');
				$content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_hp.html');
				$_SESSION['HEIDELPAY_IFRAME'] = $content;
				if (!$debug) header('Location: heidelpay_checkout_iframe.php?'.session_name().'='.session_id());
				exit();
			} else {
				$_SESSION['HEIDELPAY_IFRAME'] = $hpIframe;
				$_SESSION['HEIDELPAY_FRAMEURL'] = $src;
			}
			$_SESSION['hpLastPost'] = $_POST;
			if (empty($_SESSION['hpLastPost'])) $_SESSION['hpLastPost']['hp'] = 1;
			if ($debug) echo '<pre>'.print_r($_SESSION['hpLastPost'], 1).'</pre>';
			#if ($debug) echo '<pre>'.print_r($GLOBALS, 1).'</pre>';
			if (!$debug) header('Location: heidelpay_3dsecure.php?'.session_name().'='.session_id());
			exit();
		} else if ($ACT_MOD_MODE == 'AFTER') {
			#$_SESSION['hpLastPost'] = $_POST;
		}
		$processingresult = $res['result'];
		$redirectURL      = $res['url'];
		$base = 'heidelpay_redirect.php?';
		$src = $base.'payment_error=hp'.strtolower($this->actualPaymethod);
		if ($processingresult != "ACK"){
			$src.= '&error='.$res['all']['PROCESSING.RETURN'].'&'.session_name().'='.session_id();
			if (!$debug) header('Location: '.$src);
			if ($debug) echo $src;
			exit();
		} else if ($processingresult == "ACK" && strstr($redirectURL,"http")) {
			$src = $redirectURL;
		} else
		// IDeal Bestätigungs Seite
		if (!empty($res['all']['PROCESSING.REDIRECT.URL'])){
			$src = $res['all']['PROCESSING.REDIRECT.URL'];
		}
		if ($debug) echo 'Src: '.$src.'<br>';
		$hpIframe = '';
		if (in_array($payCode, array('cc', 'dc', 'dd'))
		&& ($ACT_MOD_MODE == 'DIRECT' || $ACT_MOD_MODE == 'NOWPF')
		&& ($payMethod == 'DB' || $payMethod == 'PA')
		){
			// Bei DB für CC / DC / DD keinen IFrame anzeigen
			if (!$_SESSION['HEIDELPAY_IFRAME'] && $processingresult == "ACK" && $insertId > 0){
				$comment = 'ShortID: '.$res['all']['IDENTIFICATION.SHORTID'];
				$status = constant('MODULE_PAYMENT_HP'.strtoupper($payCode).'_PROCESSED_STATUS_ID');
				$this->addHistoryComment($insertId, $comment, $status);
				$this->setOrderStatus($insertId, $status);
			}
		} else {
			if ( $this->actualPaymethod == 'SU'){
					$hpIframe = '<center><iframe src="'.$ReturnSrc.'" frameborder="0" width="700" height="650"></iframe></center>';
				
			} else {
				$hpIframe = '<center><iframe src="'.$ReturnSrc.'" frameborder="0" width="450" height="650"></iframe></center>';
			}

			if (gm_get_conf('GM_LIGHTBOX_CHECKOUT')) {
				GLOBAL $smarty;
				$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CHECKOUT'));
				if($_SESSION['style_edit_mode'] == 'edit') $smarty->assign('STYLE_EDIT', 1);
				else $smarty->assign('STYLE_EDIT', 0);
				$smarty->assign('language', $_SESSION['language']);
				$smarty->assign('content', '<center>'.$hpIframe.'</center>');
				$content = $smarty->fetch(CURRENT_TEMPLATE . '/module/checkout_payment_hp.html');
				$_SESSION['HEIDELPAY_IFRAME'] = $content;
				$_SESSION['HEIDELPAY_FRAMEURL'] = $src;
				if (!$debug) header('Location: heidelpay_checkout_iframe.php?'.session_name().'='.session_id());
				exit();
			}
			$_SESSION['HEIDELPAY_IFRAME'] = $hpIframe;
			$_SESSION['HEIDELPAY_FRAMEURL'] = $src;
			#$_SESSION['hpLastPost'] = $_POST;
				if (!$debug) header('Location: heidelpay_iframe.php?'.session_name().'='.session_id());
				if ($debug) echo 'IFrame: '.$hpIframe.'<br>';
			exit();
		}
		if ($debug) exit();
		
		return $hpIframe;
	}/*}}}*/

	function prepareData($orderId, $amount, $currency, $payCode, $userData, $lang, $mode = 'DB', $capture = false, $uniqueId = NULL)/*{{{*/
	{
		$payCode = strtoupper($payCode);
		$amount = sprintf('%1.2f', $amount);
		$currency = strtoupper($currency);
		$userData = $this->encodeData($userData);

		$ACT_MOD_MODE = @constant('MODULE_PAYMENT_HP'.strtoupper($this->actualPaymethod).'_MODULE_MODE');
		if (!in_array($ACT_MOD_MODE, array('DIRECT', 'AFTER', 'NOWPF'))) $ACT_MOD_MODE = 'AFTER';

		$parameters['SECURITY.SENDER']        = constant('MODULE_PAYMENT_HP'.$this->actualPaymethod.'_SECURITY_SENDER');
		$parameters['USER.LOGIN']             = constant('MODULE_PAYMENT_HP'.$this->actualPaymethod.'_USER_LOGIN');
		$parameters['USER.PWD']               = constant('MODULE_PAYMENT_HP'.$this->actualPaymethod.'_USER_PWD');
		$parameters['TRANSACTION.CHANNEL']    = constant('MODULE_PAYMENT_HP'.$this->actualPaymethod.'_TRANSACTION_CHANNEL');
		$parameters['TRANSACTION.MODE']       = constant('MODULE_PAYMENT_HP'.$this->actualPaymethod.'_TRANSACTION_MODE');
		$parameters['REQUEST.VERSION']        = "1.0";
		include_once('release_info.php');
		$parameters['SHOP.TYPE']        	  = "Gambio GX2 - $gx_version";
		$parameters['SHOPMODUL.VERSION']      = $this->version ;
		$parameters['IDENTIFICATION.TRANSACTIONID'] = $orderId;
		if ($capture){
			$parameters['FRONTEND.ENABLED']     = "false";
			if (!empty($uniqueId)){
				$parameters['ACCOUNT.REGISTRATION'] = $uniqueId;
			}
		} else {
			$parameters['FRONTEND.ENABLED']     = "true";
		}
		$parameters['FRONTEND.REDIRECT_TIME'] = "0";
		$parameters['FRONTEND.POPUP']         = "false";
		$parameters['FRONTEND.MODE']          = "DEFAULT";
		$parameters['FRONTEND.LANGUAGE']      = $lang;
		$parameters['FRONTEND.LANGUAGE_SELECTOR'] = "true";
		$parameters['FRONTEND.ONEPAGE']       = "true";
		$parameters['FRONTEND.NEXTTARGET']    = "location.href";
		$parameters['FRONTEND.CSS_PATH']      = $this->pageURL.DIR_WS_CATALOG."heidelpay_style.css";
		$parameters['FRONTEND.RETURN_ACCOUNT']= "true";

		if ($this->actualPaymethod == 'SU'){
			$parameters['FRONTEND.HEIGHT']        = "700";
			#$parameters['ACCOUNT.NUMBER']         = '123456';
			#$parameters['ACCOUNT.BANK']           = '12345679';
		} else if ($this->actualPaymethod == 'PPAL'){
			$parameters['ACCOUNT.BRAND']          = 'PAYPAL';
		}

		foreach($this->availablePayments as $key=>$value) {
			if ($value != $payCode) {
				$parameters["FRONTEND.PM." . (string)($key + 1) . ".METHOD"] = $value;
				$parameters["FRONTEND.PM." . (string)($key + 1) . ".ENABLED"] = "false";
			}
		}

		$parameters['PAYMENT.CODE']           = $payCode.".".$mode;
		$parameters['FRONTEND.RESPONSE_URL']  = $this->pageURL.DIR_WS_CATALOG."heidelpay_response.php".'?'.session_name().'='.session_id();
		if (strpos($_SERVER['REMOTE_ADDR'], '127.0.0') !== false) $parameters['FRONTEND.RESPONSE_URL']  = "http://testshops.heidelpay.de/JR/gambio/heidelpay_response.php".'?'.session_name().'='.session_id();
		$parameters['NAME.GIVEN']             = trim($userData['firstname']);
		$parameters['NAME.FAMILY']            = trim($userData['lastname']);
		$parameters['NAME.SALUTATION']        = $userData['salutation'];
		$parameters['ADDRESS.STREET']         = $userData['street'];
		$parameters['ADDRESS.ZIP']            = $userData['zip'];
		$parameters['ADDRESS.CITY']           = $userData['city'];
		$parameters['ADDRESS.COUNTRY']        = $userData['country'];
		$parameters['ADDRESS.STATE']          = $userData['state'];
		$parameters['CONTACT.EMAIL']          = $userData['email'];
		$parameters['CONTACT.IP']             = $userData['ip'];
		$parameters['PRESENTATION.AMOUNT']    = $amount; // 99.00
		$parameters['PRESENTATION.CURRENCY']  = $currency; // EUR
		$parameters['ACCOUNT.COUNTRY']        = $userData['country'];
		$imagePath = GM_HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/buttons/' . $_SESSION['language'] . '/';
		$parameters['FRONTEND.BUTTON.1.NAME'] = 'CANCEL';
		$parameters['FRONTEND.BUTTON.1.TYPE'] = 'IMAGE';
		$parameters['FRONTEND.BUTTON.1.LINK'] = $imagePath.'back.jpg'; // Gambio Buttons
		$parameters['FRONTEND.BUTTON.2.NAME'] = 'PAY';
		$parameters['FRONTEND.BUTTON.2.TYPE'] = 'IMAGE';
		$parameters['FRONTEND.BUTTON.2.LINK'] = $imagePath.'next.jpg'; // Gambio Buttons
		$parameters['CRITERION.SHOPSYSTEM']	  = 'Gambio';
		return $parameters;
	}/*}}}*/

	function encodeData($data)/*{{{*/
	{
		$tmp = array();
		foreach($data AS $k => $v){
			$tmp[$k] = $v;
			if (!$this->isUTF8($v)) $tmp[$k] = utf8_encode($v);
		}
		return $tmp;
	}/*}}}*/

	function isUTF8($string)/*{{{*/
	{
		if (is_array($string)) {
			$enc = implode('', $string);
			return @!((ord($enc[0]) != 239) && (ord($enc[1]) != 187) && (ord($enc[2]) != 191));
		} else {
			return (utf8_encode(utf8_decode($string)) == $string);
		}
	}/*}}}*/

	function isHTTPS()/*{{{*/
	{
		if (strpos($_SERVER['HTTP_HOST'], '.local') === false){
			if (   !isset($_SERVER['HTTPS']) || ( strtolower($_SERVER['HTTPS']) != 'on' && $_SERVER['HTTPS'] != '1') ) {
				return false;
			}
		} else {
			// Local
			return false;
		}
		return true;
	}/*}}}*/

	function doRequest($data)/*{{{*/
	{
		/*
		 $msg = urlencode('Curl Fehler');
		 $res = 'PROCESSING.RESULT=NOK&PROCESSING.RETURN='.$msg;
		 return $res;
		 */
		
		$url = $this->demo_url;
		if (constant('MODULE_PAYMENT_HP'.$this->actualPaymethod.'_TRANSACTION_MODE') == 'LIVE'){
			$url = $this->live_url;
		}
		$this->url = $url;

		// Erstellen des Strings für die Datenübermittlung
		foreach (array_keys($data) AS $key) {
			$data[$key] = utf8_decode($data[$key]);
			$$key .= $data[$key];
			$$key = urlencode($$key);
			$$key .= "&";
			$var = strtoupper($key);
			$value = $$key;
			$result .= "$var=$value";
		}
		$strPOST = stripslashes($result);

		// prüfen ob CURL existiert
		if (function_exists('curl_init')) {
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_HEADER, 0);
			curl_setopt($ch, CURLOPT_FAILONERROR, 1);
			curl_setopt($ch, CURLOPT_TIMEOUT, 60);
			curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 60);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, $strPOST);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,0);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,0);
			curl_setopt($ch, CURLOPT_USERAGENT, "php ctpepost");

			$this->response     = curl_exec($ch);
			$this->error        = curl_error($ch);
			curl_close($ch);

			$res = $this->response;
			if (!$this->response && $this->error){
				$res = 'PROCESSING.RESULT=NOK&PROCESSING.RETURN='.$this->error;
			}

		} else {
			$msg = urlencode('Curl Fehler');
			$res = 'PROCESSING.RESULT=NOK&PROCESSING.RETURN='.$msg;
		}

		return $res;
	}/*}}}*/

	function parseResult($curlresultURL)/*{{{*/
	{
		$r_arr=explode("&",$curlresultURL);
		foreach($r_arr AS $buf) {
			$temp=urldecode($buf);
			list($postatt, $postvar) = explode('=', $temp,2); // Änderung da Split ab PHP 5.3 nicht mehr unterstützt wird
			$returnvalue[$postatt]=$postvar;
		}
		$processingresult = $returnvalue['PROCESSING.RESULT'];
		if (empty($processingresult)) $processingresult = $returnvalue['POST.VALIDATION'];
		$redirectURL = $returnvalue['FRONTEND.REDIRECT_URL'];
		if (!isset($returnvalue['PROCESSING.RETURN']) && $returnvalue['POST.VALIDATION'] > 0){
			$returnvalue['PROCESSING.RETURN'] = 'Errorcode: '.$returnvalue['POST.VALIDATION'];
		}
		ksort($returnvalue);
		return array('result' => $processingresult, 'url' => $redirectURL, 'all' => $returnvalue);
	}/*}}}*/

	function addHistoryComment($order_id, $comment, $status = '', $customer_notified = '0')/*{{{*/
	{
		if (empty($order_id) || empty($comment)) return false;
		// Alten Eintrag laden
		$orderHistory = $this->getLastHistoryComment($order_id);
		// Kunde benachrichtigt
		$orderHistory['customer_notified'] = $customer_notified;
		// Timestamp korrekt erneuern
		$orderHistory['date_added'] = date('Y-m-d H:i:s');
		// Kommentar setzen
		$orderHistory['comments'] = urldecode($comment);
		// Neuer Status eintragen
		if(!empty($status)) $orderHistory['orders_status_id'] = addslashes($status);
		// Alte History ID entfernen
		unset($orderHistory['orders_status_history_id']);
		// Neue History eintragen
		return xtc_db_perform(TABLE_ORDERS_STATUS_HISTORY, $orderHistory);
	}/*}}}*/

	function hasHistoryComment($order_id, $status, $customer_notified)/*{{{*/
	{
		if (empty($order_id) || empty($status) || empty($customer_notified)) return false;
		$sql = 'SELECT * FROM `'.TABLE_ORDERS_STATUS_HISTORY.'`
      WHERE `orders_id`       = "'.addslashes($order_id).'"
      AND `orders_status_id`  = "'.addslashes($status).'"
      AND `customer_notified` = "'.addslashes($customer_notified).'"
      ';
		$orderHistoryArray = xtc_db_query($sql);
		while ($ordersHistoryTMP = xtc_db_fetch_array($orderHistoryArray)) {
			$ordersHistory[] = $ordersHistoryTMP;
		}
		return count($ordersHistory) > 0;
	}/*}}}*/

	function getLastHistoryComment($order_id)/*{{{*/
	{
		if (empty($order_id)) return array();
		$sql = 'SELECT * FROM `'.TABLE_ORDERS_STATUS_HISTORY.'`
      WHERE `orders_id` = "'.addslashes($order_id).'"
      ORDER BY `orders_status_history_id` DESC
      ';
		$orderHistoryArray = xtc_db_query($sql);
		return xtc_db_fetch_array($orderHistoryArray);
	}/*}}}*/

	function getOrderHistory($order_id)/*{{{*/
	{
		if (empty($order_id)) return array();
		$sql = 'SELECT * FROM `'.TABLE_ORDERS_STATUS_HISTORY.'`
      WHERE `orders_id` = "'.addslashes($order_id).'"
      ORDER BY `orders_status_history_id` DESC
      ';
		$orderHistoryArray = xtc_db_query($sql);
		$ordersHistory = array();
		while ($ordersHistoryTMP = xtc_db_fetch_array($orderHistoryArray)) {
			$ordersHistory[] = $ordersHistoryTMP;
		}
		return $ordersHistory;
	}/*}}}*/

	function setOrderStatus($order_id, $status, $doubleCheck = false)/*{{{*/
	{
		GLOBAL $db_link;
		// Status History laden
		$orderHistory = $this->getOrderHistory($order_id);
		if ($doubleCheck){
			// Prüfen ob Status schon mal gesetzt
			$found = false;
			foreach($orderHistory as $k => $v){
				if ($v['orders_status_id'] == $status) $found = true;
			}
			// Wenn Status schon mal gesetzt dann nichts tun
			if ($found) return false;
		}
		// Bestellstatus setzen
		$res = xtc_db_query("UPDATE `".TABLE_ORDERS."` SET `orders_status` = '".addslashes($status)."' WHERE `orders_id` = '".addslashes($order_id)."'");
		$stat = mysql_affected_rows($db_link);
		return $stat > 0;
	}/*}}}*/

	function saveShortId($order_id, $orders_ident_key)/*{{{*/
	{
		return xtc_db_query("UPDATE `".TABLE_ORDERS."` SET `orders_ident_key` = '".addslashes($orders_ident_key)."' WHERE `orders_id` = '".addslashes($order_id)."'");
	}/*}}}*/

	function checkInstall($code)/*{{{*/
	{
		return true;
	}/*}}}*/

	function saveMEMO($customerId, $key, $value)/*{{{*/
	{
		$data = $this->loadMEMO($customerId, $key);
		if (!empty($data)){
			return xtc_db_query('UPDATE `customers_memo` SET `memo_text` = "'.addslashes($value).'", `memo_date` = NOW(), `poster_id` = 1 WHERE `customers_id` = "'.addslashes($customerId).'" AND `memo_title` = "'.addslashes($key).'"');
		} else {
			return xtc_db_query('INSERT INTO `customers_memo` SET `memo_text` = "'.addslashes($value).'", `customers_id` = "'.addslashes($customerId).'", `memo_title` = "'.addslashes($key).'", `memo_date` = NOW(), `poster_id` = 1');
		}
	}/*}}}*/

	function loadMEMO($customerId, $key)/*{{{*/
	{
		$res = xtc_db_query('SELECT * FROM `customers_memo` WHERE `customers_id` = "'.addslashes($customerId).'" AND `memo_title` = "'.addslashes($key).'"');
		$res = xtc_db_fetch_array($res);
		return $res['memo_text'];
	}/*}}}*/

	function getPayCodeByChannel($TRANSACTION_CHANNEL)/*{{{*/
	{
		$otPayTypes = array('gp', 'su', 'tp', 'idl', 'eps');
		$keys = array();
		foreach($otPayTypes AS $k => $v){
			$keys[] = 'MODULE_PAYMENT_HP'.strtoupper($v).'_TRANSACTION_CHANNEL';
		}
		$sql = 'SELECT * FROM `configuration` WHERE `configuration_value` = "'.addslashes($TRANSACTION_CHANNEL).'" AND `configuration_key` IN ("'.implode('","', $keys).'") ';
		#echo $sql;
		$res = xtc_db_query($sql);
		$res = xtc_db_fetch_array($res);
		return str_replace(array('MODULE_PAYMENT_HP', '_TRANSACTION_CHANNEL'), '', $res['configuration_key']);
	}/*}}}*/

	function getCustomerState($state)/*{{{*/
	{
		$customer_state = xtc_db_query('SELECT `zone_code` FROM `'.TABLE_ZONES.'` WHERE `zone_name` = "'.$state.'" OR `zone_code` = "'.$state.'"');
		$attributes_values = xtc_db_fetch_array($customer_state);
		$cus_state = $attributes_values['zone_code'];
		return $cus_state;
	}/*}}}*/

	function getCustomerStateByZoneId($zoneId)/*{{{*/
	{
		$customer_state = xtc_db_query('SELECT `zone_code` FROM `'.TABLE_ZONES.'` WHERE `zone_id` = "'.$zoneId.'"');
		$attributes_values = xtc_db_fetch_array($customer_state);
		$cus_state = $attributes_values['zone_code'];
		return $cus_state;
	}/*}}}*/

	function getCustomerCountry($country)/*{{{*/
	{
		$country_query  = xtc_db_query('SELECT `countries_iso_code_2` FROM `'.TABLE_COUNTRIES.'` WHERE `countries_id` = "'.$country.'"');
		$country_res    = xtc_db_fetch_array($country_query);
		$cus_country    = $country_res['countries_iso_code_2'];
		return $cus_country;
	}/*}}}*/

	function rememberOrderData($order)/*{{{*/
	{
		if ($_SESSION['customers_status']['customers_status_show_price_tax'] == 0 && $_SESSION['customers_status']['customers_status_add_tax_ot'] == 1) {
			$total = $order->info['total'] + $order->info['tax'];
		} else {
			$total = $order->info['total'];
		}
		$currency_value = $order->info['currency_value'];
		if (empty($currency_value)) $currency_value = 1.0;

		$amount   = $total;// * $currency_value;
		$user_id  = $_SESSION['customer_id'];
		$currency = $order->info['currency'];
		$language = $_SESSION['language_code']=='de'?'DE':'EN';
		$userData = array(
      'firstname' => $order->billing['firstname'],
      'lastname'  => $order->billing['lastname'],
      'salutation'=> ($order->customer['gender']=='f' ? 'MRS' : 'MR'),
      'street'    => $order->billing['street_address'],
      'zip'       => $order->billing['postcode'],
      'city'      => $order->billing['city'],
      'country'   => $order->billing['country']['iso_code_2'],
      'email'     => $order->customer['email_address'],
      'state'     => $this->getCustomerStateByZoneId($order->billing['zone_id']),
      'ip'        => $_SERVER['REMOTE_ADDR'],
		);
		if (empty($userData['state'])) $userData['state'] = $userData['country']; // Wenn Bundesstaat leer dann nimm Land
		$_SESSION['hpLastData']['user_id'] = $user_id;
		$_SESSION['hpLastData']['amount'] = $amount;
		$_SESSION['hpLastData']['currency'] = $currency;
		$_SESSION['hpLastData']['language'] = $language;
		$_SESSION['hpLastData']['userData'] = $userData;
	}/*}}}*/
}
?>
