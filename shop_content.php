<?php
/* --------------------------------------------------------------
   shop_content.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(conditions.php,v 1.21 2003/02/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (shop_content.php,v 1.1 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: shop_content.php 1303 2005-10-12 16:47:31Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

/* bof gm */
if (GROUP_CHECK == 'true') {
	$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";
}

$shop_content_query = xtc_db_query("SELECT
                     content_id,
                     content_title,
                     content_heading,
                     content_text,
                     content_file
                     FROM ".TABLE_CONTENT_MANAGER."
                     WHERE content_group='".(int) $_GET['coID']."' ".$group_check."
                     AND languages_id='".(int) $_SESSION['languages_id']."'");
$shop_content_data = xtc_db_fetch_array($shop_content_query);

$SEF_parameter = '';
if($gmSEOBoost->boost_content) {
	$gm_seo_content_link = xtc_href_link($gmSEOBoost->get_boosted_content_url($shop_content_data['content_id'], $_SESSION['languages_id']));
} else {
	if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
		$SEF_parameter = '&content=' . xtc_cleanName($shop_content_data['content_title']);
	}
	$gm_seo_content_link = xtc_href_link(FILENAME_CONTENT, 'coID=' . (int)$_GET['coID'] . $SEF_parameter);
}

$breadcrumb->add($shop_content_data['content_title'], $gm_seo_content_link);
/* eof gm */

// create smarty elements
$smarty = new Smarty;
// include boxes


require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_validate_email.inc.php');


if ($_GET['coID'] != 7) {
	require (DIR_WS_INCLUDES.'header.php');
}
if ($_GET['coID'] == 7 && $_GET['action'] == 'success') {
	require (DIR_WS_INCLUDES.'header.php');
}

$smarty->assign('CONTENT_HEADING', $shop_content_data['content_heading']);

if ($_GET['coID'] == 7) {

	$error = false;
	if (isset ($_GET['action']) && ($_GET['action'] == 'send')) {
		// BOF GM_MOD
		//start vvcode 
		if ( ( isset ($_POST['vvcode_input']) && isset ($_SESSION['vvcode']) && (strcasecmp($_POST['vvcode_input'], $_SESSION['vvcode']) == 0) ) || gm_get_conf('GM_CONTACT_VVCODE') == 'false') { 
		//end vvcode
		// EOF GM_MOD
			if (xtc_validate_email(trim($_POST['email']))) {
	
				// BOF GM_MOD
				$t_gm_userdata = 'Name: ' . $_POST['name'] . "\n" . 'E-Mail: ' . $_POST['email'] . "\n\n";
				xtc_php_mail(CONTACT_US_EMAIL_ADDRESS, CONTACT_US_NAME, CONTACT_US_EMAIL_ADDRESS, CONTACT_US_NAME, CONTACT_US_FORWARDING_STRING, $_POST['email'], $_POST['name'], '', '', CONTACT_US_EMAIL_SUBJECT, nl2br($t_gm_userdata.$_POST['message_body']), $t_gm_userdata.$_POST['message_body']);
				// EOF GM_MOD

				if (!isset ($mail_error)) {
					xtc_redirect(xtc_href_link(FILENAME_CONTENT, 'action=success&coID='.(int) $_GET['coID']));
				} else {
					$smarty->assign('error_message', $mail_error);
	
				}
			} else {
				// error report hier einbauen
				$smarty->assign('error_message', ERROR_MAIL);
				$error = true;
			}
		// BOF GM_MOD
		//start vvcode 
		} else { 
			$smarty->assign('error_message', GM_CONTACT_ERROR_WRONG_VVCODE); $error = true; 
		} 
		//end vvcode
		// EOF GM_MOD
	}

	$smarty->assign('CONTACT_HEADING', $shop_content_data['content_heading']);
	if (isset ($_GET['action']) && ($_GET['action'] == 'success')) {
		$smarty->assign('success', '1');
		$smarty->assign('BUTTON_CONTINUE', '<a href="'.xtc_href_link(FILENAME_DEFAULT).'">'.xtc_image_button('button_continue.gif', IMAGE_BUTTON_CONTINUE).'</a>');

	} else {
		if ($shop_content_data['content_file'] != '') {
			ob_start();
			if (strpos($shop_content_data['content_file'], '.txt')) echo '<pre>';
			include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
			if (strpos($shop_content_data['content_file'], '.txt')) echo '</pre>';
		$contact_content = ob_get_contents();
		ob_end_clean();
		} else {
			$contact_content = $shop_content_data['content_text'];
		}
		require (DIR_WS_INCLUDES.'header.php');
		$smarty->assign('CONTACT_CONTENT', $contact_content);
		$smarty->assign('FORM_ACTION', xtc_draw_form('contactus', xtc_href_link(FILENAME_CONTENT, 'action=send&coID='.(int) $_GET['coID'], 'NONSSL', true, true, true)));
		$smarty->assign('FORM_ID', 'contactus');
		$smarty->assign('FORM_ACTION_URL', xtc_href_link(FILENAME_CONTENT, 'action=send&coID='.(int) $_GET['coID'], 'NONSSL', true, true, true));
		$smarty->assign('FORM_METHOD', 'post');
		$smarty->assign('INPUT_NAME', xtc_draw_input_field('name', ($error ? htmlentities_wrapper($_POST['name']) : $first_name)));
		$smarty->assign('INPUT_NAME_NAME', 'name');
		$smarty->assign('INPUT_NAME_VALUE', ($error ? htmlentities_wrapper($_POST['name']) : $first_name));
		$smarty->assign('INPUT_EMAIL', xtc_draw_input_field('email', ($error ? htmlentities_wrapper($_POST['email']) : $email_address)));
		$smarty->assign('INPUT_EMAIL_NAME', 'email');
		$smarty->assign('INPUT_EMAIL_VALUE', ($error ? htmlentities_wrapper($_POST['email']) : $email_address));
		$smarty->assign('INPUT_TEXT', xtc_draw_textarea_field('message_body', 'soft', 50, 15, htmlentities_wrapper($_POST['message_body'])));
		$smarty->assign('INPUT_TEXT_NAME', 'message_body');
		$smarty->assign('INPUT_TEXT_VALUE', htmlentities_wrapper($_POST['message_body']));
		$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
		// BOF GM_MOD
		//start captcha 
		$smarty->assign('GM_CONTACT_VVCODE', gm_get_conf('GM_CONTACT_VVCODE'));
		$smarty->assign('CAPTCHA', '<img src="' . xtc_href_link(FILENAME_DISPLAY_VVCODES, '', 'SSL', true) . '" alt="" title="" />');
		$smarty->assign('CAPTCHA_URL', xtc_href_link(FILENAME_DISPLAY_VVCODES, '', 'SSL', true));
		$smarty->assign('INPUT_CAPTCHA',xtc_draw_input_field('vvcode_input'));
		$smarty->assign('INPUT_CAPTCHA_NAME', 'vvcode_input');
		//end captcha
		// EOF GM_MOD

		/* BOF GM PRIVACY LINK */	
		$smarty->assign('GM_PRIVACY_LINK', gm_get_privacy_link('GM_CHECK_PRIVACY_CONTACT')); 
		/* EOF GM PRIVACY LINK */

		$smarty->assign('FORM_END', '</form>');
	}

	$smarty->assign('language', $_SESSION['language']);

	$smarty->caching = 0;
	$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/contact_us.html');

} else {

	if ($shop_content_data['content_file'] != '') {

		ob_start();

		if (strpos($shop_content_data['content_file'], '.txt')) echo '<pre>';
		include (DIR_FS_CATALOG.'media/content/'.$shop_content_data['content_file']);
		if (strpos($shop_content_data['content_file'], '.txt')) echo '</pre>';
		$smarty->assign('file', ob_get_contents());
		ob_end_clean();

	} else {
		$content_body = $shop_content_data['content_text'];
	}
	$smarty->assign('CONTENT_BODY', $content_body);

	$smarty->assign('BUTTON_CONTINUE', '<a href="javascript:history.back(1)">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
	$smarty->assign('language', $_SESSION['language']);

	// set cache ID
	 if (!CacheCheck()) {
		$smarty->caching = 0;
		$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/content.html');
	} else {
		$smarty->caching = 1;
		$smarty->cache_lifetime = CACHE_LIFETIME;
		$smarty->cache_modified_check = CACHE_CHECK;
		$cache_id = $_SESSION['language'].$shop_content_data['content_id'];
		$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/content.html', $cache_id);
	}

}

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>