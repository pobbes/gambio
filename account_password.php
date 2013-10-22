<?php
/* --------------------------------------------------------------
   account_password.php 2010-10-14 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_password.php,v 1.1 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (account_password.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account_password.php 1218 2005-09-16 11:38:37Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');
// create smarty elements
$smarty = new Smarty;

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_PASSWORD, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_PASSWORD, xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));


// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');

// include needed functions
require_once (DIR_FS_INC.'xtc_validate_password.inc.php');
require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');


if (!isset ($_SESSION['customer_id']))
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));

if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	
	$password_current = xtc_db_prepare_input($_POST['password_current']);
	$password_new = xtc_db_prepare_input($_POST['password_new']);
	$password_confirmation = xtc_db_prepare_input($_POST['password_confirmation']);

	$error = false;

	if (strlen($password_current) < ENTRY_PASSWORD_MIN_LENGTH) {
		
		$error = true;
		$smarty->assign('error_password', ENTRY_PASSWORD_CURRENT_ERROR);
		$messageStack->add('account_password', ENTRY_PASSWORD_CURRENT_ERROR);
	}
	elseif (strlen($password_new) < ENTRY_PASSWORD_MIN_LENGTH) {

		$error = true;
		$smarty->assign('error_new_password', ENTRY_PASSWORD_NEW_ERROR);
		$messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR);
	}
	elseif ($password_new != $password_confirmation) {
		$error = true;
		$smarty->assign('error_confirmation', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
		$messageStack->add('account_password', ENTRY_PASSWORD_NEW_ERROR_NOT_MATCHING);
	}

	if ($error == false) {
		
		$check_customer_query = xtc_db_query("select customers_password from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");

		$check_customer = xtc_db_fetch_array($check_customer_query);

		if (xtc_validate_password($password_current, $check_customer['customers_password'])) {

			xtc_db_query("UPDATE ".TABLE_CUSTOMERS." SET customers_password = '".xtc_encrypt_password($password_new)."', customers_last_modified=now() WHERE customers_id = '".(int) $_SESSION['customer_id']."'");

			xtc_db_query("UPDATE ".TABLE_CUSTOMERS_INFO." SET customers_info_date_account_last_modified = now() WHERE customers_info_id = '".(int) $_SESSION['customer_id']."'");

			$messageStack->add_session('account', SUCCESS_PASSWORD_UPDATED, 'success');

			xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
		} else {
			$error = true;
			$smarty->assign('error_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
			$messageStack->add('account_password', ERROR_CURRENT_PASSWORD_NOT_MATCHING);
		}
	}
}

require (DIR_WS_INCLUDES.'header.php');

if ($messageStack->size('account_password') > 0)
	$smarty->assign('error', $messageStack->output('account_password'));

$smarty->assign('FORM_ACTION', xtc_draw_form('account_password', xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'), 'post', '').xtc_draw_hidden_field('action', 'process'));
$smarty->assign('FORM_ID', 'account_password');
$smarty->assign('FORM_ACTION_URL', xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));
$smarty->assign('FORM_METHOD', 'post');
$smarty->assign('HIDDEN_NAME', 'action');
$smarty->assign('HIDDEN_VALUE', 'process');

$t_form_data_array = array();

$smarty->assign('INPUT_ACTUAL', xtc_draw_password_fieldNote(array ('name' => 'password_current', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_PASSWORD_CURRENT_TEXT) ? '<span class="inputRequirement">'.ENTRY_PASSWORD_CURRENT_TEXT.'</span>' : ''))));
$t_form_data_array['password_current']['name'] = 'password_current';
$t_form_data_array['password_current']['value'] = '';
$t_form_data_array['password_current']['required'] = 0;
$t_form_data_array['password_current']['required_symbol'] = ENTRY_PASSWORD_CURRENT_TEXT;
if((int)ENTRY_PASSWORD_MIN_LENGTH > 0)
{
	$t_form_data_array['password_current']['required'] = 1;
}

$smarty->assign('INPUT_NEW', xtc_draw_password_fieldNote(array ('name' => 'password_new', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_PASSWORD_NEW_TEXT) ? '<span class="inputRequirement">'.ENTRY_PASSWORD_NEW_TEXT.'</span>' : ''))));
$t_form_data_array['password_new']['name'] = 'password_new';
$t_form_data_array['password_new']['value'] = '';
$t_form_data_array['password_new']['required'] = 0;
$t_form_data_array['password_new']['required_symbol'] = ENTRY_PASSWORD_CURRENT_TEXT;
if((int)ENTRY_PASSWORD_MIN_LENGTH > 0)
{
	$t_form_data_array['password_new']['required'] = 1;
}

$smarty->assign('INPUT_CONFIRM', xtc_draw_password_fieldNote(array ('name' => 'password_confirmation', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_PASSWORD_CONFIRMATION_TEXT) ? '<span class="inputRequirement">'.ENTRY_PASSWORD_CONFIRMATION_TEXT.'</span>' : ''))));
$t_form_data_array['password_confirmation']['name'] = 'password_confirmation';
$t_form_data_array['password_confirmation']['value'] = '';
$t_form_data_array['password_confirmation']['required'] = 0;
$t_form_data_array['password_confirmation']['required_symbol'] = ENTRY_PASSWORD_CURRENT_TEXT;
if((int)ENTRY_PASSWORD_MIN_LENGTH > 0)
{
	$t_form_data_array['password_confirmation']['required'] = 1;
}

$t_form_data_array['password_hidden_action']['name'] = 'action';
$t_form_data_array['password_hidden_action']['value'] = 'process';

$smarty->assign('form_data', $t_form_data_array);
$smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_BACK_LINK', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));

$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('language', $_SESSION['language']);

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/account_password.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>