<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/
require ('includes/application_top.php');

$returnvalue=$_POST['PROCESSING_RESULT'];
if ($returnvalue){
	include_once(DIR_WS_CLASSES.'class.heidelpay.php');
	$hp = new heidelpay();
	$params = '';
	if ($_POST['PAYMENT_CODE'] == 'PP.PA'){
		$params = '&pcode='.$_POST['PAYMENT_CODE'].'&';
		foreach($hp->importantPPFields AS $k => $v){
			$params.= $v.'='.$_POST[$v].'&';
		}
	} else {
		$params.= '&code='.$_POST['PAYMENT_CODE'];
	}
	$payType = substr(strtolower($_POST['PAYMENT_CODE']), 0, 2);
	if ($payType == 'va') $payType = 'ppal'; // PayPal Special
	$payCode = strtoupper($payType);
	if ($payCode == 'OT') $payCode = $hp->getPayCodeByChannel($_POST['TRANSACTION_CHANNEL']);
	$TID = str_replace(' ', '', $_POST['IDENTIFICATION_TRANSACTIONID']);
	$orderID = (int)preg_replace('/User.*Order(\d*)/', '$1', $TID);
	$customerID = (int)preg_replace('/User(\d*).*/', '$1', $TID);
	#echo $_POST['IDENTIFICATION_TRANSACTIONID'].'<br>';
	#echo $orderID.'<br>';
	#echo $customerID.'<br>'; exit();
	$comment = 'ShortID: '.$_POST['IDENTIFICATION_SHORTID'];
	$hp->saveShortId($orderID, $_POST['IDENTIFICATION_SHORTID']);
	$base = GM_HTTP_SERVER.DIR_WS_CATALOG;
	if (strstr($returnvalue,"ACK")) {
		if (strpos($_POST['PAYMENT_CODE'], 'RG') === false){
			$status = constant('MODULE_PAYMENT_HP'.$payCode.'_PROCESSED_STATUS_ID');
			$hp->addHistoryComment($orderID, $comment, $status);
			$hp->setOrderStatus($orderID, $status);
		} else {
			$status = constant('MODULE_PAYMENT_HP'.$payCode.'_PENDING_STATUS_ID');
			$hp->addHistoryComment($orderID, $comment, $status);
			$hp->setOrderStatus($orderID, $status);
		}
		if (MODULE_PAYMENT_HPCC_SAVE_REGISTER == 'True' && $_POST['PAYMENT_CODE'] == 'CC.RG' && $_POST['ACCOUNT_NUMBER'] != ''){
			$hp->saveMEMO($customerID, 'heidelpay_last_ccard', $_POST['ACCOUNT_NUMBER']);
			$hp->saveMEMO($customerID, 'heidelpay_last_ccard_reference', $_POST['IDENTIFICATION_UNIQUEID']);
			$hp->saveMEMO($customerID, 'heidelpay_last_ccard_expire_month', $_POST['ACCOUNT_EXPIRY_MONTH']);
			$hp->saveMEMO($customerID, 'heidelpay_last_ccard_expire_year', $_POST['ACCOUNT_EXPIRY_YEAR']);
		} else if (MODULE_PAYMENT_HPDC_SAVE_REGISTER == 'True' && $_POST['PAYMENT_CODE'] == 'DC.RG' && $_POST['ACCOUNT_NUMBER'] != ''){
			$hp->saveMEMO($customerID, 'heidelpay_last_debitcard', $_POST['ACCOUNT_NUMBER']);
			$hp->saveMEMO($customerID, 'heidelpay_last_debitcard_reference', $_POST['IDENTIFICATION_UNIQUEID']);
			$hp->saveMEMO($customerID, 'heidelpay_last_debitcard_expire_month', $_POST['ACCOUNT_EXPIRY_MONTH']);
			$hp->saveMEMO($customerID, 'heidelpay_last_debitcard_expire_year', $_POST['ACCOUNT_EXPIRY_YEAR']);
		}
		if ($_POST['PROCESSING_STATUS_CODE'] == '90' && $_POST['AUTHENTICATION_TYPE'] == '3DSecure'){
			print $base."heidelpay_3dsecure_return.php?order_id=".$_POST['IDENTIFICATION_TRANSACTIONID'].'&'.session_name().'='.session_id();
		} else {
			print $base."heidelpay_redirect.php?order_id=".$_POST['IDENTIFICATION_TRANSACTIONID'].'&uniqueId='.$_POST['IDENTIFICATION_UNIQUEID'].$params.'&'.session_name().'='.session_id();
		}
	} else if ($_POST['FRONTEND_REQUEST_CANCELLED'] == 'true'){
		$status = constant('MODULE_PAYMENT_HP'.$payCode.'_CANCELED_STATUS_ID');
		$comment.= ' Cancelled by User';
		$hp->addHistoryComment($orderID, $comment, $status);
		$hp->setOrderStatus($orderID, $status);
		print $base."heidelpay_redirect.php?payment_error=hp".$payType."&error=Cancelled by User".'&'.session_name().'='.session_id();
	} else {
		$status = constant('MODULE_PAYMENT_HP'.$payCode.'_CANCELED_STATUS_ID');
		$comment.= ' '.$_POST['PROCESSING_RETURN'];
		$hp->addHistoryComment($orderID, $comment, $status);
		$hp->setOrderStatus($orderID, $status);
		print $base."heidelpay_redirect.php?payment_error=hp".$payType."&error=".$_POST['PROCESSING_RETURN'].'&'.session_name().'='.session_id();
	}
} else {
	echo 'FAIL';
}
?>
