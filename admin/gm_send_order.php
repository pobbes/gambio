<?php
/* --------------------------------------------------------------
   gm_send_order.php 2010-08-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com
   (c) 2003      nextcommerce (start.php,1.5 2004/03/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: start.php 1235 2005-09-21 19:11:43Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

	require(						'includes/application_top.php');
	require_once(DIR_FS_CATALOG		. 'includes/classes/class.phpmailer.php');
	require_once(DIR_FS_INC			. 'xtc_php_mail.inc.php');
	require_once(DIR_FS_INC			. 'xtc_get_order_data.inc.php');
	require_once(DIR_FS_INC			. 'xtc_get_attributes_model.inc.php');
	require_once(DIR_FS_INC			. 'xtc_not_null.inc.php');
	require_once(DIR_FS_INC			. 'xtc_format_price_order.inc.php');
	require_once(DIR_WS_CLASSES		. 'order.php');
	require_once(DIR_FS_CATALOG		. 'gm/inc/gm_prepare_number.inc.php');
	require_once(DIR_FS_CATALOG		. 'gm/inc/gm_save_order.inc.php');
	
	/* magnalister v1.0.1 */
	if (function_exists('magnaExecute')) magnaExecute('magnaSubmitOrderStatus', array('action' => 'gm_send_order'), array('order_details.php'));
	/* END magnalister */

	$smarty = new Smarty;

	/*
	* -> create order
	*/
	$order = new order($_GET['oID']);
	
	//sofort: include for invoice confirmation
	if(strpos(strtolower($order->info['payment_method']), 'sofortrechnung')) {
		require_once(DIR_FS_CATALOG.'callback/sofort/confirmInvoice.php');
	}
  	//sofort: end

	$order_query_check = xtc_db_query("
										SELECT
											customers_email_address,
											customers_firstname,
											customers_lastname,
											gm_order_html,
											gm_order_txt
										FROM " .
											TABLE_ORDERS . "
										WHERE
											orders_id='".(int)$_GET['oID']."'
									");

	$order_check = xtc_db_fetch_array($order_query_check);
	$smarty->assign('order_titel', TITLE_ORDER);
	$smarty->assign('order_body', $order_check['gm_order_html']);
	$smarty->assign('oID', $_GET['oID']);

	$smarty->caching = false;
	$smarty->template_dir=DIR_FS_CATALOG.'templates';
	$smarty->compile_dir=DIR_FS_CATALOG.'templates_c';
	$smarty->config_dir=DIR_FS_CATALOG.'lang';

	if($_GET['type'] == 'order') {

		echo $order_check['gm_order_html'];

	} elseif($_GET['type'] == 'recreate_order') {
		// recreate order
		$coo_recreate_order = MainFactory::create_object('RecreateOrder', array($_GET['oID']));
		$t_html = $coo_recreate_order->getHtml();

		echo $t_html;
	} elseif($_GET['type'] == 'send_order') {

		if(xtc_php_mail(
						EMAIL_FROM,
						STORE_NAME,
						$_GET['gm_mail'],
						'',
						EMAIL_BILLING_FORWARDING_STRING,
						'',
						'',
						'',
						'',
						$_GET['gm_subject'],
						$order_check['gm_order_html'],
						$order_check['gm_order_txt']
						)) {
							xtc_db_query("
											UPDATE
												" . TABLE_ORDERS . "
											SET
												gm_send_order_status		= '1',
												gm_order_send_date			= NOW()
											WHERE
												orders_id = '" . (int)$_GET['oID'] . "'
										");


							echo MAIL_SUCCESS . '<br><br><span class="button" onclick="gm_mail_close(\'ORDERS_MAIL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
						} else {
							echo MAIL_UNSUCCESS . '<br><br><span class="button" onclick="gm_mail_close(\'ORDERS_MAIL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
						}

	} elseif($_GET['type'] == 'cancel') {

		$order_updated = false;
		$gm_status = gm_get_conf('GM_ORDER_STATUS_CANCEL_ID');
		$gm_comments = xtc_db_prepare_input($_GET['gm_comments']);


		$oID = xtc_db_prepare_input($_GET['oID']);

		$check_status_query = xtc_db_query("
											SELECT
												customers_name,
												customers_email_address,
												orders_status,
												language,
												date_purchased
											FROM " .
												TABLE_ORDERS . "
											WHERE
												orders_id = '" . xtc_db_input($oID) . "'
											");

		$check_status = xtc_db_fetch_array($check_status_query);

		if ($check_status['orders_status'] != $gm_status) {

			xtc_db_query("
						UPDATE " .
							TABLE_ORDERS . "
						SET
							orders_status	= '" . $gm_status ."',
							last_modified	= now(),
							gm_cancel_date	= now()
						WHERE
							orders_id = '" . xtc_db_input($oID) . "'
						");

			if($_GET['gm_notify'] == 'on') {
				$notify_comments = '';

				if ($_GET['gm_notify_comments'] == 'on') {
					$notify_comments = $gm_comments;
				} else {
					$notify_comments = '';
				}

				// assign language to template for caching
				$smarty->assign('language', $_SESSION['language']);
				$smarty->caching = false;

				// set dirs manual
				$smarty->template_dir = DIR_FS_CATALOG.'templates';
				$smarty->compile_dir = DIR_FS_CATALOG.'templates_c';
				$smarty->config_dir = DIR_FS_CATALOG.'lang';

				$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
				$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

				$smarty->assign('NAME', $check_status['customers_name']);
				$smarty->assign('ORDER_NR', $oID);
				$smarty->assign('ORDER_LINK', xtc_catalog_href_link(FILENAME_CATALOG_ACCOUNT_HISTORY_INFO, 'order_id='.$oID, 'SSL'));
				$smarty->assign('ORDER_DATE', xtc_date_long($check_status['date_purchased']));
				$smarty->assign('NOTIFY_COMMENTS', $notify_comments);
				$smarty->assign('ORDER_STATUS', xtc_get_orders_status_name($gm_status));

				if(defined('EMAIL_SIGNATURE')) {
					$smarty->assign('EMAIL_SIGNATURE_HTML', nl2br(EMAIL_SIGNATURE));
					$smarty->assign('EMAIL_SIGNATURE_TEXT', EMAIL_SIGNATURE);
				}
				
				$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$check_status['language'].'/change_order_mail.html');
				$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$check_status['language'].'/change_order_mail.txt');

				xtc_php_mail(EMAIL_BILLING_ADDRESS, EMAIL_BILLING_NAME, $_GET['gm_mail'], $check_status['customers_name'], '', EMAIL_BILLING_REPLY_ADDRESS, EMAIL_BILLING_REPLY_ADDRESS_NAME, '', '', $_GET['gm_subject'], $html_mail, $txt_mail);

				$customer_notified = '1';

				xtc_db_query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('".xtc_db_input($oID)."', '".xtc_db_input($gm_status)."', now(), '".$customer_notified."', '".xtc_db_input($gm_comments)."')");

				$order_updated = true;

				if ($order_updated) {
					// BOF GM_MOD products_shippingtime:
					$gm_reshipp = false;
					if($_GET['gm_reshipp'] == 'on')
					{
						$gm_reshipp = true;
					}
					// BOF GM_MOD products_shippingtime:
					if($_GET['gm_restock'] == 'on')
					{
						xtc_remove_order($oID, true, true, $gm_reshipp);
					}	
					echo UPDATE_MAIL_SUCCESS . '<br /><br /><span class="button" onclick="gm_mail_close(\'CANCEL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
				} else {
					echo UPDATE_UNSUCCESS . '<br><br><span class="button" onclick="gm_mail_close(\'CANCEL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
				}

			} else {

				$customer_notified = '0';

				xtc_db_query("INSERT INTO " . TABLE_ORDERS_STATUS_HISTORY . " (orders_id, orders_status_id, date_added, customer_notified, comments) values ('".xtc_db_input($oID)."', '".xtc_db_input($gm_status)."', now(), '".$customer_notified."', '".xtc_db_input($gm_comments)."')");

				$order_updated = true;

				if ($order_updated) {
					// BOF GM_MOD products_shippingtime:
					$gm_reshipp = false;
					if($_GET['gm_reshipp'] == 'on')
					{
						$gm_reshipp = true;
					}
					// BOF GM_MOD products_shippingtime:
					if($_GET['gm_restock'] == 'on')
					{
						xtc_remove_order($oID, true, true, $gm_reshipp);
					}				
					echo UPDATE_SUCCESS . '<br><br><span class="button" onclick="gm_mail_close(\'CANCEL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
				} else {
					echo UPDATE_UNSUCCESS . '<br><br><span class="button" onclick="gm_mail_close(\'CANCEL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
				}
			}

		} else {
			echo CANCEL_UNSUCCESS . '<br><br><span class="button" onclick="gm_mail_close(\'CANCEL\')" style="cursor:pointer"><strong>' . MAIL_CLOSE . '</strong></span>';
		}
	}
?>
