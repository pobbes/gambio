<?php
/* --------------------------------------------------------------
   newsletter.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: newsletter.php,v 1.0 

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   -----------------------------------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce www.oscommerce.com 
   (c) 2003	 nextcommerce www.nextcommerce.org
   
   XTC-NEWSLETTER_RECIPIENTS RC1 - Contribution for XT-Commerce http://www.xt-commerce.com
   by Matthias Hinsche http://www.gamesempire.de
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

// create smarty elements
$smarty = new Smarty;
$breadcrumb->add(NAVBAR_TITLE_NEWSLETTER, xtc_href_link(FILENAME_NEWSLETTER, '', 'NONSSL'));

// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_render_vvcode.inc.php');
require_once (DIR_FS_INC.'xtc_random_charcode.inc.php');
require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
require_once (DIR_FS_INC.'xtc_validate_password.inc.php');

$t_form_send = false;

if (isset ($_GET['action']) && ($_GET['action'] == 'process')) {
	$vlcode = xtc_random_charcode(32);
	// BOF GM_MOD:
	$link = xtc_href_link(FILENAME_NEWSLETTER, 'action=activate&email='.rawurlencode($_POST['email']).'&key='.$vlcode, 'NONSSL');

	// assign language to template for caching
	$smarty->assign('language', $_SESSION['language']);
	$smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
	$smarty->assign('logo_path', HTTP_SERVER.DIR_WS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/img/');

	// assign vars
	$smarty->assign('EMAIL', htmlentities_wrapper($_POST['email']));
	$smarty->assign('LINK', $link);
	// dont allow cache
	$smarty->caching = false;
	// bof gm
	$gm_logo_mail = MainFactory::create_object('GMLogoManager', array("gm_logo_mail"));
	if($gm_logo_mail->logo_use == '1') {
		$smarty->assign('gm_logo_mail', $gm_logo_mail->get_logo());
	} 
	// eof gm
	if(defined('EMAIL_SIGNATURE')) {
		$smarty->assign('EMAIL_SIGNATURE_HTML', nl2br(EMAIL_SIGNATURE));
		$smarty->assign('EMAIL_SIGNATURE_TEXT', EMAIL_SIGNATURE);
	}
	// create mails
	$html_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/newsletter_mail.html');
	// BOF GM_MOD:
	$smarty->assign('LINK', str_replace('&amp;', '&', $link));
	$txt_mail = $smarty->fetch(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/newsletter_mail.txt');

	// Check if email exists 
	// BOF GM doesn't matter if capital or small letters 
	if ((strtoupper($_POST['vvcode']) == $_SESSION['vvcode'])) {
	// EOF GM doesn't matter if capital or small letters 
		
		if( $_POST['check'] == 'inp' )
		{
			$check_mail_query = xtc_db_query("select customers_email_address, mail_status from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input($_POST['email'])."'");
			if (!xtc_db_num_rows($check_mail_query)) {

				if (isset ($_SESSION['customer_id'])) {
					$customers_id = $_SESSION['customer_id'];
					$customers_status = $_SESSION['customers_status']['customers_status_id'];
					$customers_firstname = $_SESSION['customer_first_name'];
					$customers_lastname = $_SESSION['customer_last_name'];
				} else {

					$check_customer_mail_query = xtc_db_query("select customers_id, customers_status, customers_firstname, customers_lastname, customers_email_address from ".TABLE_CUSTOMERS." where customers_email_address = '".xtc_db_input($_POST['email'])."'");
					if (!xtc_db_num_rows($check_customer_mail_query)) {
						$customers_id = '0';
						$customers_status = '1';
						$customers_firstname = TEXT_CUSTOMER_GUEST;
						$customers_lastname = '';
					} else {
						$check_customer = xtc_db_fetch_array($check_customer_mail_query);
						$customers_id = $check_customer['customers_id'];
						$customers_status = $check_customer['customers_status'];
						$customers_firstname = $check_customer['customers_firstname'];
						$customers_lastname = $check_customer['customers_lastname'];
					}

				}

				$sql_data_array = array ('customers_email_address' => xtc_db_input($_POST['email']), 'customers_id' => xtc_db_input($customers_id), 'customers_status' => xtc_db_input($customers_status), 'customers_firstname' => xtc_db_input($customers_firstname), 'customers_lastname' => xtc_db_input($customers_lastname), 'mail_status' => '0', 'mail_key' => xtc_db_input($vlcode), 'date_added' => 'now()');
				xtc_db_perform(TABLE_NEWSLETTER_RECIPIENTS, $sql_data_array);

				$info_message = TEXT_EMAIL_INPUT;
                                
                                $t_form_send = true;

				// BOF GM_MOD:
				xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, xtc_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail);

			} else {
				$check_mail = xtc_db_fetch_array($check_mail_query);

				if ($check_mail['mail_status'] == '0') {

					$info_message = TEXT_EMAIL_EXIST_NO_NEWSLETTER;

					// BOF GM_MOD:
					xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, xtc_db_input($_POST['email']), '', '', EMAIL_SUPPORT_REPLY_ADDRESS, EMAIL_SUPPORT_REPLY_ADDRESS_NAME, '', '', TEXT_EMAIL_SUBJECT, $html_mail, $txt_mail);

				} else {
					$info_message = TEXT_EMAIL_EXIST_NEWSLETTER;
				}

			}
		}
		elseif( $_POST['check'] == 'del' )
		{
			$check_mail_query = xtc_db_query("select customers_email_address from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input($_POST['email'])."'");
			if (!xtc_db_num_rows($check_mail_query)) {
				$info_message = TEXT_EMAIL_NOT_EXIST;
			} else {
				$del_query = xtc_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address ='".xtc_db_input($_POST['email'])."'");
				// BOF GM_MOD:
				xtc_db_query("update ".TABLE_CUSTOMERS." set customers_newsletter = '0' where customers_email_address = '".xtc_db_input($_POST['email'])."'");
				$info_message = TEXT_EMAIL_DEL;
                                $t_form_send = true;
			}
		}
		else
		{
			$info_message = TEXT_NO_CHOICE;
		}
	} 
	else 
	{
		$info_message = TEXT_WRONG_CODE;
	}
}

// Accountaktivierung per Emaillink
if (isset ($_GET['action']) && ($_GET['action'] == 'activate')) {
	$check_mail_query = xtc_db_query("select mail_key from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input(urldecode($_GET['email']))."'");
	if (!xtc_db_num_rows($check_mail_query)) {
		$info_message = TEXT_EMAIL_NOT_EXIST;
	} else {
		$check_mail = xtc_db_fetch_array($check_mail_query);
		// BOF GM_MOD:
		if ($check_mail['mail_key'] != $_GET['key']) {
			$info_message = TEXT_EMAIL_ACTIVE_ERROR;
		} else {
			xtc_db_query("update ".TABLE_NEWSLETTER_RECIPIENTS." set mail_status = '1' where customers_email_address = '".xtc_db_input(urldecode($_GET['email']))."'");
			// BOF GM_MOD:
			xtc_db_query("update ".TABLE_CUSTOMERS." set customers_newsletter = '1' where customers_email_address = '".xtc_db_input(urldecode($_GET['email']))."'");
			$info_message = TEXT_EMAIL_ACTIVE;
		}
	}
	$t_form_send = true;
}

// Accountdeaktivierung per Emaillink
if (isset ($_GET['action']) && ($_GET['action'] == 'remove')) {
	$check_mail_query = xtc_db_query("select customers_email_address, mail_key from ".TABLE_NEWSLETTER_RECIPIENTS." where customers_email_address = '".xtc_db_input(urldecode($_GET['email']))."' and mail_key = '".xtc_db_input($_GET['key'])."'");
	if (!xtc_db_num_rows($check_mail_query)) {
		$info_message = TEXT_EMAIL_NOT_EXIST;
	} else {
		$check_mail = xtc_db_fetch_array($check_mail_query);
		// BOF GM_MOD:
		if ($check_mail['mail_key'] != $_GET['key']) {
			$info_message = TEXT_EMAIL_DEL_ERROR;
		} else {
			$del_query = xtc_db_query("delete from ".TABLE_NEWSLETTER_RECIPIENTS." where  customers_email_address ='".xtc_db_input(urldecode($_GET['email']))."' and mail_key = '".xtc_db_input($_GET['key'])."'");
			// BOF GM_MOD:
			xtc_db_query("update ".TABLE_CUSTOMERS." set customers_newsletter = '0' where customers_email_address = '".xtc_db_input(urldecode($_GET['email']))."'");
			$info_message = TEXT_EMAIL_DEL;
		}
	}
	$t_form_send = true;
}


require (DIR_WS_INCLUDES.'header.php');

$smarty->assign('VVIMG', '<img src="'.xtc_href_link(FILENAME_DISPLAY_VVCODES).'" alt="Captcha" />');
$smarty->assign('VVIMG_URL', xtc_href_link(FILENAME_DISPLAY_VVCODES));
$smarty->assign('text_newsletter', TEXT_NEWSLETTER);
$smarty->assign('info_message', $info_message);
$smarty->assign('FORM_ACTION', xtc_draw_form('sign', xtc_href_link(FILENAME_NEWSLETTER, 'action=process', 'NONSSL', true, true, true)));
$smarty->assign('FORM_ID', 'sign');
$smarty->assign('FORM_ACTION_URL', xtc_href_link(FILENAME_NEWSLETTER, 'action=process', 'NONSSL', true, true, true));
$smarty->assign('FORM_METHOD', 'post');
$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', htmlentities_wrapper($_POST['email'])));
$smarty->assign('INPUT_EMAIL_NAME', 'email');
$smarty->assign('INPUT_EMAIL_VALUE', htmlentities_wrapper($_POST['email']));
$smarty->assign('INPUT_CODE', xtc_draw_input_field('vvcode', '', 'size="6" maxlength="6"', 'text', false));
$smarty->assign('INPUT_CODE_NAME', 'vvcode');
$smarty->assign('CHECK_INP', xtc_draw_radio_field('check', 'inp'));
$smarty->assign('CHECK_DEL', xtc_draw_radio_field('check', 'del'));
$smarty->assign('INPUT_RADIO_NAME', 'check');
$smarty->assign('INPUT_SUBSCRIBE_VALUE', 'inp');
$smarty->assign('INPUT_UNSUBSCRIBE_VALUE', 'del');
$smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_BACK_LINK', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$smarty->assign('BUTTON_BACK_NL_LINK', xtc_href_link('newsletter.php', '', 'SSL'));
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_send.gif', IMAGE_BUTTON_LOGIN));
$smarty->assign('FORM_END', '</form>');
$smarty->assign('language', $_SESSION['language']);
$smarty->assign('form_send', $t_form_send);

/* BOF GM PRIVACY LINK */	
	$smarty->assign('GM_PRIVACY_LINK', gm_get_privacy_link('GM_CHECK_PRIVACY_ACCOUNT_NEWSLETTER')); 
/* EOF GM PRIVACY LINK */

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/newsletter.html');
$smarty->assign('main_content', $main_content);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>