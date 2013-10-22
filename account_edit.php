<?php
/* --------------------------------------------------------------
   account_edit.php 2010-10-11 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(account_edit.php,v 1.63 2003/05/19); www.oscommerce.com
   (c) 2003	 nextcommerce (account_edit.php,v 1.14 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account_edit.php 1314 2005-10-20 14:00:46Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include ('includes/application_top.php');

// create smarty elements
$smarty = new Smarty;
// include boxes

$breadcrumb->add(NAVBAR_TITLE_1_ACCOUNT_EDIT, xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$breadcrumb->add(NAVBAR_TITLE_2_ACCOUNT_EDIT, xtc_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));

require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'xtc_date_short.inc.php');
require_once (DIR_FS_INC.'xtc_image_button.inc.php');
require_once (DIR_FS_INC.'xtc_validate_email.inc.php');
require_once (DIR_FS_INC.'xtc_get_geo_zone_code.inc.php');
require_once (DIR_FS_INC.'xtc_get_customers_country.inc.php');

if (!isset ($_SESSION['customer_id']))
	xtc_redirect(xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
/*
if ($_SESSION['customers_status']['customers_status_id']==0)
{
	xtc_redirect(xtc_href_link_admin(FILENAME_CUSTOMERS, 'cID='.$_SESSION['customer_id'].'&action=edit', 'SSL'));
}
*/
if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	if (ACCOUNT_GENDER == 'true')
		$gender = xtc_db_prepare_input($_POST['gender']);
	$firstname = xtc_db_prepare_input($_POST['firstname']);
	$lastname = xtc_db_prepare_input($_POST['lastname']);
	if (ACCOUNT_DOB == 'true')
		$dob = xtc_db_prepare_input($_POST['dob']);
	if (ACCOUNT_COMPANY_VAT_CHECK == 'true')
		$vat = xtc_db_prepare_input($_POST['vat']);
	$email_address = xtc_db_prepare_input($_POST['email_address']);
	$telephone = xtc_db_prepare_input($_POST['telephone']);
	$fax = xtc_db_prepare_input($_POST['fax']);
	//bof gm
	$gm_privacy = xtc_db_prepare_input($_POST['gm_privacy']);
	//eof gm

	$error = false;

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;
			$smarty->assign('error_gender', ENTRY_GENDER_ERROR);
			$messageStack->add('create_account', ENTRY_GENDER_ERROR);
		}
	}

	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_first_name', ENTRY_FIRST_NAME_ERROR);
		$messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
	}

	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_last_name', ENTRY_LAST_NAME_ERROR);
		$messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
	}

	if (ACCOUNT_DOB == 'true') {
		if (checkdate(substr(xtc_date_raw($dob), 4, 2), substr(xtc_date_raw($dob), 6, 2), substr(xtc_date_raw($dob), 0, 4)) == false) {
			$error = true;
			$smarty->assign('error_birth_day', ENTRY_DATE_OF_BIRTH_ERROR);
			$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
		}
	}

// New VAT Check
	require_once(DIR_WS_CLASSES.'vat_validation.php');
	$vatID = new vat_validation($vat, '', '', $country);

	$customers_status = $vatID->vat_info['status'];
	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];
	$error = $vatID->vat_info['error'];

	if($error==1){
	$messageStack->add('create_account', ENTRY_VAT_ERROR);
	$error = true;
	$smarty->assign('error_vat', ENTRY_VAT_ERROR);
  }

// New VAT CHECK END

	// BOF GM_MOD
	// check if email already exists
	$gm_query = xtc_db_query("
								SELECT
									customers_email_address
								FROM
									customers
								WHERE
									customers_id			!= '" . (int) $_SESSION['customer_id'] . "'
								AND
									customers_email_address	= '" . xtc_db_input($email_address) . "'
							");

	$gm_array = xtc_db_fetch_array($gm_query);

	if(xtc_db_num_rows($gm_query) == 1){
		$error = true;
		$smarty->assign('error_mail', GM_ENTRY_EMAIL_ADDRESS_ERROR);
		$messageStack->add('account_edit', GM_ENTRY_EMAIL_ADDRESS_ERROR);
	}

	// EOF GM_MOD

	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_mail', ENTRY_EMAIL_ADDRESS_ERROR);
		$messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_ERROR);
	}

	if (xtc_validate_email($email_address) == false) {
		$error = true;
		$smarty->assign('error_mail', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		$messageStack->add('account_edit', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	}

	if (strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_tel', ENTRY_TELEPHONE_NUMBER_ERROR);
		$messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
	}

	if ($error == false) {
		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_firstname' => $firstname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax,'customers_last_modified' => 'now()');

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = xtc_date_raw($dob);

		xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array, 'update', "customers_id = '".(int) $_SESSION['customer_id']."'");

		xtc_db_query("update ".TABLE_CUSTOMERS_INFO." set customers_info_date_account_last_modified = now() where customers_info_id = '".(int) $_SESSION['customer_id']."'");

		// reset the session variables
		$customer_first_name = $firstname;
		$messageStack->add_session('account', SUCCESS_ACCOUNT_UPDATED, 'success');
		xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
	}
	else {
		$account_query = xtc_db_query("select customers_gender, customers_cid, customers_vat_id, customers_vat_id_status, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_telephone, customers_fax from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
		$account = xtc_db_fetch_array($account_query);
	}
} else {
	$account_query = xtc_db_query("select customers_gender, customers_cid, customers_vat_id, customers_vat_id_status, customers_firstname, customers_lastname, customers_dob, customers_email_address, customers_telephone, customers_fax from ".TABLE_CUSTOMERS." where customers_id = '".(int) $_SESSION['customer_id']."'");
	$account = xtc_db_fetch_array($account_query);
}


require (DIR_WS_INCLUDES.'header.php');

$t_form_data_array = array();

$smarty->assign('FORM_ACTION', xtc_draw_form('account_edit', xtc_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'), 'post', '').xtc_draw_hidden_field('action', 'process'));
$smarty->assign('FORM_ID', 'account_edit');
$smarty->assign('FORM_ACTION_URL', xtc_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
$smarty->assign('FORM_METHOD', 'post');

$smarty->assign('HIDDEN_FIELD_NAME', 'action');
$smarty->assign('HIDDEN_FIELD_VALUE', 'process');

if ($messageStack->size('account_edit') > 0)
	$smarty->assign('error', $messageStack->output('account_edit'));

if (ACCOUNT_GENDER == 'true') {
	$smarty->assign('gender', '1');
	$male = ($account['customers_gender'] == 'm') ? true : false;
	$female = !$male;
	$smarty->assign('INPUT_MALE', xtc_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE.'&nbsp;'), 'm', $male));
	$smarty->assign('INPUT_FEMALE', xtc_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE.'&nbsp;', 'text' => (xtc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f', $female));

	$t_form_data_array['gender']['name'] = 'gender';
	$t_form_data_array['gender']['m']['value'] = 'm';
	$t_form_data_array['gender']['f']['value'] = 'f';
	$t_form_data_array['gender']['m']['checked'] = '0';
	$t_form_data_array['gender']['f']['checked'] = '0';
	
	if($male)
	{
		$t_form_data_array['gender']['m']['checked'] = '1';
	}
	if($female)
	{
		$t_form_data_array['gender']['f']['checked'] = '1';
	}

	$t_form_data_array['gender']['required'] = 1;
	$t_form_data_array['gender']['required_symbol'] = ENTRY_GENDER_TEXT;
}

if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
	$smarty->assign('vat', '1');
	$smarty->assign('INPUT_VAT', xtc_draw_input_fieldNote(array ('name' => 'vat', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_VAT_TEXT) ? '<span class="inputRequirement">'.ENTRY_VAT_TEXT.'</span>' : '')), $account['customers_vat_id']));
	$t_form_data_array['vat']['name'] = 'vat';
	$t_form_data_array['vat']['value'] = $account['customers_vat_id'];
	$t_form_data_array['vat']['required'] = 0;
	$t_form_data_array['vat']['required_symbol'] = ENTRY_VAT_TEXT;
} else {
	$smarty->assign('vat', '0');
}

$smarty->assign('INPUT_FIRSTNAME', xtc_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), $account['customers_firstname']));
$t_form_data_array['firstname']['name'] = 'firstname';
$t_form_data_array['firstname']['value'] = $account['customers_firstname'];
$t_form_data_array['firstname']['required'] = 0;
$t_form_data_array['firstname']['required_symbol'] = ENTRY_FIRST_NAME_TEXT;
if((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['firstname']['required'] = 1;
}

$smarty->assign('INPUT_LASTNAME', xtc_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), $account['customers_lastname']));
$t_form_data_array['lastname']['name'] = 'lastname';
$t_form_data_array['lastname']['value'] = $account['customers_lastname'];
$t_form_data_array['lastname']['required'] = 0;
$t_form_data_array['lastname']['required_symbol'] = ENTRY_LAST_NAME_TEXT;
if((int)ENTRY_LAST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['lastname']['required'] = 1;
}

$smarty->assign('csID', $account['customers_cid']);

if (ACCOUNT_DOB == 'true') {
	$smarty->assign('birthdate', '1');
	$smarty->assign('INPUT_DOB', xtc_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_DATE_OF_BIRTH_TEXT) ? '<span class="inputRequirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '')), xtc_date_short($account['customers_dob'])));
	
	$t_form_data_array['birthdate']['name'] = 'dob';
	$t_form_data_array['birthdate']['value'] = xtc_date_short($account['customers_dob']);
	$t_form_data_array['birthdate']['required'] = 0;
	$t_form_data_array['birthdate']['required_symbol'] = ENTRY_DATE_OF_BIRTH_TEXT;
	if((int)ENTRY_DOB_MIN_LENGTH > 0)
	{
		$t_form_data_array['birthdate']['required'] = 1;
	}
}

$smarty->assign('INPUT_EMAIL', xtc_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), $account['customers_email_address']));
$t_form_data_array['email']['name'] = 'email_address';
$t_form_data_array['email']['value'] = $account['customers_email_address'];
$t_form_data_array['email']['required'] = 0;
$t_form_data_array['email']['required_symbol'] = ENTRY_EMAIL_ADDRESS_TEXT;
if((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0)
{
	$t_form_data_array['email']['required'] = 1;
}

$smarty->assign('INPUT_TEL', xtc_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_TELEPHONE_NUMBER_TEXT) ? '<span class="inputRequirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), $account['customers_telephone']));
$t_form_data_array['telephone']['name'] = 'telephone';
$t_form_data_array['telephone']['value'] = $account['customers_telephone'];
$t_form_data_array['telephone']['required'] = 0;
$t_form_data_array['telephone']['required_symbol'] = ENTRY_TELEPHONE_NUMBER_TEXT;
if((int)ENTRY_TELEPHONE_MIN_LENGTH > 0)
{
	$t_form_data_array['telephone']['required'] = 1;
}

$smarty->assign('INPUT_FAX', xtc_draw_input_fieldNote(array ('name' => 'fax', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">'.ENTRY_FAX_NUMBER_TEXT.'</span>' : '')), $account['customers_fax']));
$t_form_data_array['fax']['name'] = 'fax';
$t_form_data_array['fax']['value'] = $account['customers_fax'];
$t_form_data_array['fax']['required'] = 0;
$t_form_data_array['fax']['required_symbol'] = ENTRY_FAX_NUMBER_TEXT;

$smarty->assign('BUTTON_BACK', '<a href="'.xtc_href_link(FILENAME_ACCOUNT, '', 'SSL').'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$smarty->assign('BUTTON_BACK_LINK', xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('form_data', $t_form_data_array);

$smarty->assign('language', $_SESSION['language']);

/* BOF GM PRIVACY LINK */
	$smarty->assign('GM_PRIVACY_LINK', gm_get_privacy_link('GM_CHECK_PRIVACY_ACCOUNT_CONTACT'));
/* EOF GM PRIVACY LINK */

$smarty->caching = 0;
$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/account_edit.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>