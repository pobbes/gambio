<?php
/* --------------------------------------------------------------
   paypal.php 2009-12-16 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

*
 * Project:   	xt:Commerce - eCommerce Engine
 * @version $Id   
 *
 * xt:Commerce - Shopsoftware
 * (c) 2003-2007 xt:Commerce (Winger/Zanier), http://www.xt-commerce.com
 *
 * xt:Commerce ist eine gesch�tzte Handelsmarke und wird vertreten durch die xt:Commerce GmbH (Austria)
 * xt:Commerce is a protected trademark and represented by the xt:Commerce GmbH (Austria)
 *
 * @copyright Copyright 2003-2007 xt:Commerce (Winger/Zanier), www.xt-commerce.com
 * @copyright based on Copyright 2002-2003 osCommerce; www.oscommerce.com
 * @copyright Porttions Copyright 2003-2007 Zen Cart Development Team
 * @copyright Porttions Copyright 2004 DevosC.com
 * @license http://www.xt-commerce.com.com/license/2_0.txt GNU Public License V2.0
 * 
 * For questions, help, comments, discussion, etc., please join the
 * xt:Commerce Support Forums at www.xt-commerce.com
 * 
 */

require ('includes/application_top.php');

define('FILENAME_PAYPAL', 'paypal.php');
define('TABLE_PAYPAL', 'paypal');

// load classes
require ('../includes/classes/paypal_checkout.php');
require ('includes/classes/class.paypal.php');

$paypal = new paypal_admin();

// refunding
switch ($_GET['view']) {

	case 'refund' :
		if (isset ($_GET['paypal_ipn_id'])) {
			$query = "SELECT * FROM paypal WHERE paypal_ipn_id = '" . (int) $_GET['paypal_ipn_id'] . "'";
			$query = xtc_db_query($query);
			$ipn_data = xtc_db_fetch_array($query);
		}

		if ($_GET['action'] == 'perform') {
			// refunding
			$txn_id = xtc_db_prepare_input($_POST['txn_id']);
			$ipn_id = xtc_db_prepare_input($_POST['ipn_id']);
			$amount = xtc_db_prepare_input($_POST['amount']);
			$note = xtc_db_prepare_input($_POST['refund_info']);
			$refund_amount = xtc_db_prepare_input($_POST['refund_amount']);

			$query = "SELECT * FROM paypal WHERE paypal_ipn_id = '" . (int) $ipn_id . "'";
			$query = xtc_db_query($query);
			$ipn_data = xtc_db_fetch_array($query);

			$response = $paypal->RefundTransaction($txn_id, $ipn_data['mc_currency'], $amount, $refund_amount, $note);

			if ($response['ACK'] == 'Success') {
				xtc_redirect(xtc_href_link(FILENAME_PAYPAL, 'err=refund_Success'));
			} else {
				xtc_redirect(xtc_href_link(FILENAME_PAYPAL, 'view=refund&paypal_ipn_id=' . (int) $ipn_id . '&err=error_' . $response['L_ERRORCODE0']));
			}
		}
		break;
	
	case 'search' :
		 $date = array();
		 $date['actual']['tt'] = date('d');
		 $date['actual']['mm'] = date('m');
		 $date['actual']['yyyy'] = date ('Y');


		 $last_month  = mktime(0, 0, 0, date("m")-1, date("d"),   date("Y"));
		 $date['last_month']['tt'] = date('d',$last_month);
		 $date['last_month']['mm'] = date('m',$last_month);
		 $date['last_month']['yyyy'] = date ('Y',$last_month);
	
		if ($_GET['action'] == 'perform') {
			$response = $paypal->TransactionSearch($_POST);
	//		echo '<pre>';
	//		print_r ($response);
	//		echo '</pre>';
		}
		break;

	case 'capture' :
		//if (PAYPAL_COUNTRY_MODE!='uk') xtc_redirect(xtc_href_link(FILENAME_PAYPAL));
		if (isset ($_GET['paypal_ipn_id'])) {
			$query = "SELECT * FROM paypal WHERE paypal_ipn_id = '" . (int) $_GET['paypal_ipn_id'] . "'";
			$query = xtc_db_query($query);
			$ipn_data = xtc_db_fetch_array($query);
		}

		if ($_GET['action'] == 'perform') {
			// refunding
			$txn_id = xtc_db_prepare_input($_POST['txn_id']);
			$ipn_id = xtc_db_prepare_input($_POST['ipn_id']);
			$amount = xtc_db_prepare_input($_POST['amount']);
			$note = xtc_db_prepare_input($_POST['refund_info']);
			$capture_amount = round(xtc_db_prepare_input((double)$_POST['capture_amount']), 2);

			$query = "SELECT txn_id, mc_currency, mc_authorization, mc_captured FROM paypal WHERE paypal_ipn_id = '" . (int) $ipn_id . "'";
			$query = xtc_db_query($query);
			$ipn_data = xtc_db_fetch_array($query);

			$remain_amount = ($ipn_data['mc_authorization']-$ipn_data['mc_captured']);

			$response = $paypal->DoCapture($txn_id, $ipn_data['mc_currency'], $remain_amount, $capture_amount, $note);

			if ($response['ACK'] == 'Success') {
				$response = $paypal->GetTransactionDetails($ipn_data['txn_id']);
				
				$data = array();
				$data['paypal_ipn_id'] = $ipn_id;
				$data['txn_id'] = $txn_id;
				$data['payment_status'] ='Pending';
				$data['pending_reason'] = 'partial-capture';
				$data['mc_amount'] = $capture_amount;
				$data['date_added']='now()';
				
				if($response['PAYMENTSTATUS'] == 'Completed') {
					$data['payment_status'] = 'Completed';
					$data['pending_reason'] = 'completed-capture';
					xtc_db_query("UPDATE paypal SET payment_status='Completed',pending_reason='',mc_gross=mc_authorization WHERE paypal_ipn_id='".$ipn_id."'");
				}
				
				// update captured amount
				xtc_db_query("UPDATE paypal SET mc_captured = (mc_captured+".$capture_amount.") WHERE paypal_ipn_id='".$ipn_id."'");
				// save capture in DB
				xtc_db_perform('paypal_status_history',$data);
				// update transaction
				xtc_redirect(xtc_href_link(FILENAME_PAYPAL, 'err=capture_Success&view=detail&paypal_ipn_id='.$_GET['paypal_ipn_id']));
			} else {
				xtc_redirect(xtc_href_link(FILENAME_PAYPAL, 'view=capture&paypal_ipn_id=' . (int) $ipn_id . '&amount='.$amount.'&err=error_' . $response['L_ERRORCODE0']));
			}

		}
		break;
		
	case 'void' :
		//if (PAYPAL_COUNTRY_MODE!='uk') xtc_redirect(xtc_href_link(FILENAME_PAYPAL));
		if (isset ($_GET['paypal_ipn_id'])) {
			$query = "SELECT * FROM paypal WHERE paypal_ipn_id = '" . (int) $_GET['paypal_ipn_id'] . "'";
			$query = xtc_db_query($query);
			$ipn_data = xtc_db_fetch_array($query);
		}

		if ($_GET['action'] == 'perform') {
			// refunding
			$txn_id = xtc_db_prepare_input($_POST['txn_id']);
			$ipn_id = xtc_db_prepare_input($_POST['ipn_id']);
			$note = xtc_db_prepare_input($_POST['refund_info']);

			$query = "SELECT * FROM paypal WHERE paypal_ipn_id = '" . (int) $ipn_id . "'";
			$query = xtc_db_query($query);
			$ipn_data = xtc_db_fetch_array($query);

			$response = $paypal->DoVoid($txn_id, $note);

			if ($response['ACK'] == 'Success') {
				$response = $paypal->GetTransactionDetails($ipn_data['txn_id']);
				
				$data = array();
				$data['paypal_ipn_id'] = $ipn_id;
				$data['txn_id'] = $txn_id;
				$data['payment_status'] = $response['PAYMENTSTATUS'];
				$data['pending_reason'] = $response['PENDINGREASON'];
				//$data['pending_reason'] = 'partial-capture';
				//$data['mc_amount'] = $capture_amount;
				$data['date_added']='now()';
				
//				$data['payment_status'] = 'Completed';
//				$data['pending_reason'] = 'completed-capture';
				xtc_db_query(
					"UPDATE paypal SET
						payment_status = '".$data['payment_status']."',
						pending_reason = '".$data['pending_reason']."',
						mc_gross = mc_authorization
					WHERE paypal_ipn_id = '".$ipn_id."'");
				
				// update transaction
				xtc_db_perform('paypal_status_history',$data);
				
				xtc_redirect(xtc_href_link(FILENAME_PAYPAL, 'err=void_Success'));
			} else {
				xtc_redirect(xtc_href_link(FILENAME_PAYPAL, 'view=void&paypal_ipn_id=' . (int) $ipn_id . '&err=error_' . $response['L_ERRORCODE0']));
			}

		}
		break;
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%">
				<div class="pageHeading" style="float:left;background-image:url(images/gm_icons/module.png)"><?php echo HEADING_TITLE; ?></div>
<!-- 			  <tr>
				<td width="100" rowspan="2"><img src="https://www.paypal.com/de_DE/DE/i/logo/logo_110x35.gif"></td>
				<td class="pageHeading"><?php echo HEADING_TITLE; ?></td>
			  </tr>
			  <tr>
				<td class="main" valign="top">xt:Commerce Tools</td>
			  </tr>
 -->  <?php if (!isset($_GET['view'])) { ?>
    <a style="float:right" class="button" href="<?php echo xtc_href_link(FILENAME_PAYPAL, 'view=search'); ?>"><?php echo BUTTON_SEARCH; ?></a>
  <?php } ?>
</td>
      </tr>
      <tr>
        <td><br />
<?php


// errors 
if (isset ($_GET['err'])) {
	if($_GET['err'] == 'capture_Success') {
		$error = CAPTURE_SUCCESS;
	} elseif($_GET['err'] == 'void_Success') {
		$error = VOID_SUCCESS;
	} elseif($_GET['err'] == 'refund_Success') {
		$error = REFUND_SUCCESS;
	} else {
		$error = $paypal->getErrorDescription($_GET['err']);
	}
}

switch ($_GET['view']) {

	case 'detail' :
		include (DIR_WS_MODULES . 'paypal_transactiondetail.php');
		break;

	case 'refund' :
		include (DIR_WS_MODULES . 'paypal_refundtransaction.php');
		break;

	case 'capture' :
		include (DIR_WS_MODULES . 'paypal_capturetransaction.php');
		break;
		
	case 'search' :
		include (DIR_WS_MODULES . 'paypal_searchtransaction.php');
		break;

	case 'auth' :
		include (DIR_WS_MODULES . 'paypal_authtransaction.php');
		break;

	case 'void' :
		include (DIR_WS_MODULES . 'paypal_voidtransaction.php');
		break;

	default :
		include (DIR_WS_MODULES . 'paypal_listtransactions.php');
		break;

}
?>        
        </td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>