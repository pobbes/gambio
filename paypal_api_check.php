<?php
/* --------------------------------------------------------------
   paypal_log_viewer.php 2010-07-29 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License
   --------------------------------------------------------------
*/

// basic classes
require_once('includes/application_top.php');
require_once(DIR_WS_CLASSES.'paypal_checkout.php');
require_once('admin/includes/classes/class.paypal.php');

// basics
define('GM_SETTINGS_PAYPAL_ERROR_API',     'Die API Daten sind falsch, oder die SSLVERSION Angabe fehlt.');
define('GM_SETTINGS_PAYPAL_ERROR_CURL',    'Es ist ein cURL Fehler aufgetreten.');
define('GM_SETTINGS_PAYPAL_ERROR_OPENSSL', 'Es ist ein OpenSSL Fehler aufgetreten.');
define('GM_SETTINGS_PAYPAL_ERROR_NOERROR', 'Es ist kein Fehler aufgetreten.');
$check_result = '<span style="font-size:12px;color:#00cc00;" /><b>'.GM_SETTINGS_PAYPAL_ERROR_NOERROR.'</b /><br /><br /></span />';

$txn_id = trim($_POST['txn_id']);

/*
 * check API
 */
function check_api()
{
  $paypal = new paypal_checkout();
  $result_string = '';
  $error         = '';
  $result = $paypal->hash_call('SetExpressCheckout', 'CHECK_API');
  if ( empty($result) || !is_array($result) || (!empty($result) && (int) $result['L_ERRORCODE0'] == 10002) ) {
    $extensions = get_loaded_extensions();
    $error = GM_SETTINGS_PAYPAL_ERROR_API;
    if (!in_array("curl", $extensions)) {
      $error = GM_SETTINGS_PAYPAL_ERROR_CURL;
    } elseif (!in_array("openssl", $extensions)) {
    	$error = GM_SETTINGS_PAYPAL_ERROR_OPENSSL;
    }
    $result_string = '<span style="font-size:12px;color:#cc0000;" /><b>'.$error.'</b /><br /><br /></span />';
  }
  return $result_string;
}

// am i admin?
$t_i_am_admin = false;
if ($_SESSION['customers_status']['customers_status_id'] === '0') {
  $t_i_am_admin = true;
}

// get logfile 'paypal_api' data (with search params) / for admins only
if ($t_i_am_admin) {
  $result = check_api();
  if (!empty($result)) $check_result = $result;
}



	function hash_call($methodName, $nvpStr, $pp_token = '')
	{
		// BOF GM_MOD
		// if API check, no logging
		$t_check_api = false;
		if($nvpStr == 'CHECK_API') {
			$nvpStr = '';
			$t_check_api = true;
		}
		// EOF GM_MOD

		if(function_exists('curl_init')) {
			//setting the curl parameters.
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $this->API_Endpoint.$pp_token);
			curl_setopt($ch, CURLOPT_VERBOSE, 0);

			//turning off the server and peer verification(TrustManager Concept).
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
			curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
			curl_setopt($ch, CURLOPT_SSLVERSION, 3);

			curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($ch, CURLOPT_POST, 1);
			//if USE_PROXY constant set to TRUE in Constants.php, then only proxy will be enabled.
		   //Set proxy name to PROXY_HOST and port number to PROXY_PORT in constants.php
			if($this->USE_PROXY) {
				curl_setopt ($ch, CURLOPT_PROXY, PROXY_HOST.":".PROXY_PORT);
			}

			//NVPRequest for submitting to server
			$nvpreq =
				'METHOD='		.urlencode($methodName).
				'&VERSION='		.urlencode($this->version).
				'&PWD='			.urlencode($this->API_Password).
				'&USER='		.urlencode($this->API_UserName).
				'&SIGNATURE='	.urlencode($this->API_Signature).
				$nvpStr;

			//setting the nvpreq as POST FIELD to curl
			curl_setopt($ch,CURLOPT_POSTFIELDS,$nvpreq);

			//GM_MOD:
			if(!$t_check_api) {
				$this->_logAPICall($this->API_Endpoint.$pp_token .' + '. $nvpreq);
			}

			//getting response from server
			$response = curl_exec($ch);

			//GM_MOD:
			if(!$t_check_api) {
				$this->_logAPICall('RESPONSE: '.$response);
			}

			//convrting NVPResponse to an Associative Array
			$nvpResArray = $this->deformatNVP($response);
			$nvpReqArray = $this->deformatNVP($nvpreq);

			$_SESSION['nvpReqArray'] = $nvpReqArray;

			if(curl_errno($ch)) {
				// moving to display page to display curl errors
				$t_curl_error = curl_errno($ch);
				$_SESSION['curl_error_no'] = $t_curl_error;
				$_SESSION['curl_error_msg'] = $t_curl_error;
				$this->build_error_message($_SESSION['reshash']);
				// $this->payPalURL = $this->EXPRESS_CANCEL_URL;
				// return $this->payPalURL;
			}

			//closing the curl
			curl_close($ch);
		} else {
			// BOF GM_MOD
			$nvpreq =
				"METHOD="		.urlencode($methodName).
				"&VERSION="		.urlencode($this->version).
				"&PWD="			.urlencode($this->API_Password).
				"&USER="		.urlencode($this->API_UserName).
				"&SIGNATURE="	.urlencode($this->API_Signature).$nvpStr;

			$request_post = array(
				'http' => array(
					'method' => 'POST',
					'header' => "Content-type: application/x-www-form-urlencoded\r\n",
					'content' => $nvpreq));

			if(!$t_check_api) {
				$this->_logAPICall('STREAM '.$this->API_Endpoint.$pp_token .' + '. $nvpreq);
			}

			$request		= stream_context_create($request_post);
			$response		= file_get_contents($this->API_Endpoint.$pp_token, false, $request);
			$nvpResArray	= $this->deformatNVP($response);
			$nvpReqArray	= $this->deformatNVP($nvpreq);

			if(!$t_check_api) {
				$this->_logAPICall('STREAM RESPONSE: '.$response);
			}

			$_SESSION['nvpReqArray'] = $nvpReqArray;
			// EOF GM_MOD
		}

		return $nvpResArray;
	}




?>
<html>
<head>
<title>.: PAYPAL API-CHECK :.</title>
<style type="text/css">
<!--
body     {border: 0px;margin:20px;background-color:#fdf5e6;}
p, form  {border: 0px;margin: 0px;}
a        {font-family:verdana,arial,helvetica;font-size:12px;line-height:16px;color:#993333;text-decoration:none;}
.bg_head {font-family:verdana,arial,helvetica;font-size:16px;line-height:20px;background:#333333;color:#ffffff;font-weight:900;}
.main    {width:400px;border:1px solid #cccccc;background-color:#ffffff;padding:10px;}
.head    {font-family:verdana,arial,helvetica;font-size:16px;line-height:20px;font-weight:900;letter-spacing:5px;align:bottom;}
.small   {font-family:verdana,arial,helvetica;font-size:12px;line-height:16px;color:#333333;}
.tiny    {font-family:verdana,arial,helvetica;font-size: 9px;line-height:11px;color:#333333;}
.input   {font-family:verdana,arial,helvetica;font-size:12px;line-height:16px;color:#333333;width:80px;}
-->
</style>
</head>
<body>

<div class="main">
	<span class="head">Paypal API-Check</span>
	<hr size="1" noshade width="99%">
	<div class="small">
		<?php if (!$t_i_am_admin) {?>
		<span class="small">Die Daten des Log-Files k&ouml;nnen nur von einem Nutzer mit Admin Rechten eingesehen werden!</span><br>
		<?php } else { ?>
		<?php   echo $check_result; ?>
		<?php } ?>
	</div>
</div>
<br />
<br />
<div class="main">
	<span class="head">Paypal Transaction-Check</span>
	<hr size="1" noshade width="99%">
	<div class="small">
		<form method="post" action="<?php echo htmlentities_wrapper($_SERVER['PHP_SELF']); ?>">
			<label for="test">Bestellnummer:</label>&nbsp;
			<input id="test" type="text" size="12" name="txn_id"<?php echo (!empty($txn_id) ? ' value="'.$txn_id.'"' : ''); ?>>&nbsp;
			<input type="submit" value="pr&uuml;fen">
		</form>
		<?php
		if(isset($txn_id) && !empty($txn_id)) {
			echo '<br />';
			$nvpstr = '&TRANSACTIONID=' . urlencode($txn_id);
			$resArray = hash_call("getTransactionDetails", $nvpstr);
echo '<pre>'; print_r($resArray); echo '</pre>';
		}
		?>
	</div>
</div>

</body>
</html>