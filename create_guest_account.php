<?php
/* --------------------------------------------------------------
   create_guest_account.php 2011-05-20 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: create_guest_account.php 1311 2005-10-18 12:30:40Z mz $) 
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(create_account.php,v 1.63 2003/05/28); www.oscommerce.com
   (c) 2003  nextcommerce (create_account.php,v 1.27 2003/08/24); www.nextcommerce.org

   Released under the GNU General Public License

   Guest account idea by Ingo T. <xIngox@web.de>
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

if (ACCOUNT_OPTIONS == 'account')
	xtc_redirect(FILENAME_DEFAULT);

if (isset ($_SESSION['customer_id'])) {
	xtc_redirect(xtc_href_link(FILENAME_ACCOUNT, '', 'SSL'));
}

$breadcrumb->add(NAVBAR_TITLE_CREATE_GUEST_ACCOUNT, xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, xtc_get_all_get_params(), 'SSL'));


// create smarty elements
$smarty = new Smarty;
// include boxes
require (DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/source/boxes.php');
// include needed functions
require_once (DIR_FS_INC.'xtc_draw_radio_field.inc.php');
require_once (DIR_FS_INC.'xtc_get_country_list.inc.php');
require_once (DIR_FS_INC.'xtc_draw_checkbox_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_password_field.inc.php');
require_once (DIR_FS_INC.'xtc_validate_email.inc.php');
require_once (DIR_FS_INC.'xtc_encrypt_password.inc.php');
require_once (DIR_FS_INC.'xtc_create_password.inc.php');
require_once (DIR_FS_INC.'xtc_draw_hidden_field.inc.php');
require_once (DIR_FS_INC.'xtc_draw_pull_down_menu.inc.php');
require_once (DIR_FS_INC.'xtc_get_geo_zone_code.inc.php');

// needs to be included earlier to set the success message in the messageStack
//  require(DIR_WS_LANGUAGES . $_SESSION['language'] . '/' . FILENAME_CREATE_ACCOUNT);

$process = false;
if (isset ($_POST['action']) && ($_POST['action'] == 'process')) {
	$process = true;

	if (ACCOUNT_GENDER == 'true')
		$gender = xtc_db_prepare_input($_POST['gender']);
	$firstname = xtc_db_prepare_input($_POST['firstname']);
	$lastname = xtc_db_prepare_input($_POST['lastname']);
	if (ACCOUNT_DOB == 'true')
		$dob = xtc_db_prepare_input($_POST['dob']);
	$email_address = xtc_db_prepare_input($_POST['email_address']);
	$email_address_confirm = xtc_db_prepare_input($_POST['email_address_confirm']);
	if(isset($_POST['email_address']) && !isset($_POST['email_address_confirm']))
	{
		$email_address_confirm = $email_address;
	}
	if (ACCOUNT_COMPANY == 'true')
		$company = xtc_db_prepare_input($_POST['company']);
	if (ACCOUNT_COMPANY_VAT_CHECK == 'true')
		$vat = xtc_db_prepare_input($_POST['vat']);
	$street_address = xtc_db_prepare_input($_POST['street_address']);
	if (ACCOUNT_SUBURB == 'true')
		$suburb = xtc_db_prepare_input($_POST['suburb']);
	$postcode = xtc_db_prepare_input($_POST['postcode']);
	$city = xtc_db_prepare_input($_POST['city']);
	$zone_id = xtc_db_prepare_input($_POST['zone_id']);
	if (ACCOUNT_STATE == 'true')
		$state = xtc_db_prepare_input($_POST['state']);
	$country = xtc_db_prepare_input($_POST['country']);
	if (ACCOUNT_TELEPHONE == 'true')
		$telephone = xtc_db_prepare_input($_POST['telephone']);
	if (ACCOUNT_FAX == 'true')
		$fax = xtc_db_prepare_input($_POST['fax']);
	//    $newsletter = xtc_db_prepare_input($_POST['newsletter']);
	$newsletter = '0';
	$password = xtc_db_prepare_input($_POST['password']);
	$confirmation = xtc_db_prepare_input($_POST['confirmation']);
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

	if (ACCOUNT_DOB == 'true' && (ENTRY_DOB_MIN_LENGTH > 0 || ($dob != '' && ENTRY_DOB_MIN_LENGTH == 0))) {
		// BOF GM_MOD:
		if (!preg_match('/^[0-9]{2}\.[0-9]{2}\.[0-9]{4}$/', $dob) || checkdate(substr(xtc_date_raw($dob), 4, 2), substr(xtc_date_raw($dob), 6, 2), substr(xtc_date_raw($dob), 0, 4)) == false ) {
			$error = true;
			$smarty->assign('error_birth_day', ENTRY_DATE_OF_BIRTH_ERROR);
			$messageStack->add('create_account', ENTRY_DATE_OF_BIRTH_ERROR);
		}
	}

// New VAT Check
	require_once(DIR_WS_CLASSES.'vat_validation.php');


	$vatID = new vat_validation($vat, '', '', $country, true);

	$customers_status = $vatID->vat_info['status'];
	$customers_vat_id_status = $vatID->vat_info['vat_id_status'];

	if($vatID->vat_info['error'] == true) {
		$error = true;
		$messageStack->add('create_account', ENTRY_VAT_ERROR);
		$smarty->assign('error_vat', ENTRY_VAT_ERROR);
	}

// New VAT CHECK END

		// xs:booster prefill (customer group)
		if($_SESSION['xtb0']['DEFAULT_CUSTOMER_GROUP']!='')
			$customers_status = $_SESSION['xtb0']['DEFAULT_CUSTOMER_GROUP'];
		// xs:booster end


	// BOF GM_MOD
	$gm_get_existing_account = xtc_db_query("SELECT
																							customers_id
																						FROM customers
																						WHERE
																							customers_email_address = '" . xtc_db_input($email_address) . "'
																							AND customers_status = '" . DEFAULT_CUSTOMERS_STATUS_ID_GUEST . "' LIMIT 1");
	if(xtc_db_num_rows($gm_get_existing_account) == 1){
		$gm_old_customer_account = xtc_db_fetch_array($gm_get_existing_account);

		xtc_db_query("delete from ".TABLE_CUSTOMERS." where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from ".TABLE_ADDRESS_BOOK." where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from ".TABLE_CUSTOMERS_INFO." where customers_info_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from customers_basket where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from customers_basket_attributes   where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from customers_ip   where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from customers_wishlist   where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from customers_wishlist_attributes   where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from customers_status_history   where customers_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from coupon_gv_customer   where customer_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from coupon_gv_queue   where customer_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from coupon_redeem_track   where customer_id = '".$gm_old_customer_account['customers_id']."'");
		xtc_db_query("delete from whos_online   where customer_id = '".$gm_old_customer_account['customers_id']."'");
	}
	// EOF GM_MOD


	if (strlen($email_address) < ENTRY_EMAIL_ADDRESS_MIN_LENGTH || $email_address != $email_address_confirm) {
		$error = true;
		$smarty->assign('error_mail', ENTRY_EMAIL_ADDRESS_ERROR);
		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR);
	}
	elseif (xtc_validate_email($email_address) == false) {
		$error = true;
		$smarty->assign('error_mail', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
		$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_CHECK_ERROR);
	} else {
		$check_email_query = xtc_db_query("select count(*) as total from ".TABLE_CUSTOMERS." where customers_email_address = '".xtc_db_input($email_address)."' and account_type = '0'");
		$check_email = xtc_db_fetch_array($check_email_query);
		if ($check_email['total'] > 0) {
			$error = true;
			$smarty->assign('error_mail', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
			$messageStack->add('create_account', ENTRY_EMAIL_ADDRESS_ERROR_EXISTS);
		}
	}

	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_street', ENTRY_STREET_ADDRESS_ERROR);
		$messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
	}

	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_post_code', ENTRY_POST_CODE_ERROR);
		$messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
	}

	if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_city', ENTRY_CITY_ERROR);
		$messageStack->add('create_account', ENTRY_CITY_ERROR);
	}

	if (is_numeric($country) == false) {
		$error = true;
		$smarty->assign('error_country', ENTRY_COUNTRY_ERROR);
		$messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
	}

	if (ACCOUNT_STATE == 'true') {
		$zone_id = 0;
		$check_query = xtc_db_query("select count(*) as total from ".TABLE_ZONES." where zone_country_id = '".(int) $country."'");
		$check = xtc_db_fetch_array($check_query);
		$entry_state_has_zones = ($check['total'] > 0);
		if ($entry_state_has_zones == true) {
			$zone_query = xtc_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and (zone_name like '".xtc_db_input($state)."%' or zone_code like '%".xtc_db_input($state)."%')");
			if (xtc_db_num_rows($zone_query) > 1) {
				$zone_query = xtc_db_query("select distinct zone_id from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' and zone_name = '".xtc_db_input($state)."'");
			}
			if (xtc_db_num_rows($zone_query) >= 1) {
				$zone = xtc_db_fetch_array($zone_query);
				$zone_id = $zone['zone_id'];
			} else {
				$error = true;
				$smarty->assign('error_state', ENTRY_STATE_ERROR_SELECT);
				$messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;
				$smarty->assign('error_state', ENTRY_STATE_ERROR);
				$messageStack->add('create_account', ENTRY_STATE_ERROR);
			}
		}
	}

	if (ACCOUNT_TELEPHONE == 'true' && strlen($telephone) < ENTRY_TELEPHONE_MIN_LENGTH) {
		$error = true;
		$smarty->assign('error_tel', ENTRY_TELEPHONE_NUMBER_ERROR);
		$messageStack->add('create_account', ENTRY_TELEPHONE_NUMBER_ERROR);
	}

	if ($customers_status == 0 || !$customers_status)
		$customers_status = DEFAULT_CUSTOMERS_STATUS_ID_GUEST;
	$password = xtc_create_password(8);

	if (!$newsletter)
		$newsletter = 0;
	if ($error == false) {
		$sql_data_array = array ('customers_vat_id' => $vat, 'customers_vat_id_status' => $customers_vat_id_status, 'customers_status' => $customers_status, 'customers_firstname' => $firstname, 'customers_lastname' => $lastname, 'customers_email_address' => $email_address, 'customers_telephone' => $telephone, 'customers_fax' => $fax, 'customers_newsletter' => $newsletter, 'account_type' => '1', 'customers_password' => xtc_encrypt_password($password));

		$_SESSION['account_type'] = '1';

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['customers_gender'] = $gender;
		if (ACCOUNT_DOB == 'true')
			$sql_data_array['customers_dob'] = xtc_date_raw($dob);

		xtc_db_perform(TABLE_CUSTOMERS, $sql_data_array);

		$_SESSION['customer_id'] = xtc_db_insert_id();

		$sql_data_array = array ('customers_id' => $_SESSION['customer_id'], 'entry_firstname' => $firstname, 'entry_lastname' => $lastname, 'entry_street_address' => $street_address, 'entry_postcode' => $postcode, 'entry_city' => $city, 'entry_country_id' => $country);

		if (ACCOUNT_GENDER == 'true')
			$sql_data_array['entry_gender'] = $gender;
		if (ACCOUNT_COMPANY == 'true')
			$sql_data_array['entry_company'] = $company;
		if (ACCOUNT_SUBURB == 'true')
			$sql_data_array['entry_suburb'] = $suburb;
		if (ACCOUNT_STATE == 'true') {
			if ($zone_id > 0) {
				$sql_data_array['entry_zone_id'] = $zone_id;
				$sql_data_array['entry_state'] = '';
			} else {
				$sql_data_array['entry_zone_id'] = '0';
				$sql_data_array['entry_state'] = $state;
			}
		}

		xtc_db_perform(TABLE_ADDRESS_BOOK, $sql_data_array);

		$address_id = xtc_db_insert_id();

		xtc_db_query("update ".TABLE_CUSTOMERS." set customers_cid = '".$_SESSION['customer_id']."', customers_default_address_id = '".$address_id."' where customers_id = '".(int) $_SESSION['customer_id']."'");

		xtc_db_query("insert into ".TABLE_CUSTOMERS_INFO." (customers_info_id, customers_info_number_of_logons, customers_info_date_account_created) values ('".(int) $_SESSION['customer_id']."', '0', now())");

		if (SESSION_RECREATE == 'True') {
			xtc_session_recreate();
		}

		$_SESSION['customer_first_name'] = $firstname;
		$_SESSION['customer_last_name'] = $lastname;
		$_SESSION['customer_default_address_id'] = $address_id;
		$_SESSION['customer_country_id'] = $country;
		$_SESSION['customer_zone_id'] = $zone_id;
		$_SESSION['customer_vat_id'] = $vat;

		// restore cart contents
		$_SESSION['cart']->restore_contents();

if (isset ($_SESSION[tracking]['refID'])){
      $campaign_check_query_raw = "SELECT *
			                            FROM ".TABLE_CAMPAIGNS."
			                            WHERE campaigns_refID = '".$_SESSION[tracking][refID]."'";
			$campaign_check_query = xtc_db_query($campaign_check_query_raw);
		if (xtc_db_num_rows($campaign_check_query) > 0) {
			$campaign = xtc_db_fetch_array($campaign_check_query);
			$refID = $campaign['campaigns_id'];
			} else {
			$refID = 0;
		            }

			 xtc_db_query("update " . TABLE_CUSTOMERS . " set
                                 refferers_id = '".$refID."'
                                 where customers_id = '".(int) $_SESSION['customer_id']."'");

			$leads = $campaign['campaigns_leads'] + 1 ;
		     xtc_db_query("update " . TABLE_CAMPAIGNS . " set
		                         campaigns_leads = '".$leads."'
                                 where campaigns_id = '".$refID."'");
}
		// BOF GM_MOD
		$t_gm_redirect = FILENAME_SHOPPING_CART;

		if(isset($_GET['checkout_started']) && $_GET['checkout_started'] == 1)
		{
			$t_gm_redirect = FILENAME_CHECKOUT_SHIPPING;
		}

		xtc_redirect(xtc_href_link($t_gm_redirect, '', 'SSL'));
		// EOF GM_MOD
	}
}

require (DIR_WS_INCLUDES.'header.php');
		// xs:booster prefill
		if(@isset($_SESSION['xtb0']['tx'][0]))
		{
			if($_SESSION['language_charset']!='utf-8')
			{
				$_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME'] = utf8_decode($_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME']);
				$_SESSION['xtb0']['tx'][0]['XTB_EBAY_STREET'] = utf8_decode($_SESSION['xtb0']['tx'][0]['XTB_EBAY_STREET']);
				$_SESSION['xtb0']['tx'][0]['XTB_EBAY_CITY'] = utf8_decode($_SESSION['xtb0']['tx'][0]['XTB_EBAY_CITY']);
			}
			$GLOBALS['gender']=			'm';
			$GLOBALS['firstname']=		substr($_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME'],0,strpos($_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME']," "));
			$GLOBALS['lastname']=		substr($_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME'],strpos($_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME']," ")+1,strlen($_SESSION['xtb0']['tx'][0]['XTB_EBAY_NAME']));
			$GLOBALS['street_address']=	$_SESSION['xtb0']['tx'][0]['XTB_EBAY_STREET'];
			$GLOBALS['postcode']=		$_SESSION['xtb0']['tx'][0]['XTB_EBAY_POSTALCODE'];
			$GLOBALS['city']=			$_SESSION['xtb0']['tx'][0]['XTB_EBAY_CITY'];
			$GLOBALS['country']=		$_SESSION['xtb0']['tx'][0]['XTB_EBAY_COUNTRYNAME'];
			$GLOBALS['email_address']=	$_SESSION['xtb0']['tx'][0]['XTB_EBAY_EMAIL'];
			$GLOBALS['email_address_confirm']=	$_SESSION['xtb0']['tx'][0]['XTB_EBAY_EMAIL'];
			$GLOBALS['telephone']=		$_SESSION['xtb0']['tx'][0]['XTB_EBAY_PHONE'];
		}
		// xs:booster end

if ($messageStack->size('create_account') > 0) {
	$smarty->assign('error', $messageStack->output('create_account'));

}

$t_checkout_started_get_param = '';
if(isset($_GET['checkout_started']) && $_GET['checkout_started'] == 1)
{
	$t_checkout_started_get_param = 'checkout_started=1';
}

$t_form_data_array = array();

$smarty->assign('FORM_ACTION', xtc_draw_form('create_account', xtc_href_link(FILENAME_CREATE_GUEST_ACCOUNT, $t_checkout_started_get_param, 'SSL'), 'post', '').xtc_draw_hidden_field('action', 'process'));

if (ACCOUNT_GENDER == 'true') {
	$smarty->assign('gender', '1');

	$smarty->assign('INPUT_MALE', xtc_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE), 'm'));
	$smarty->assign('INPUT_MALE_NAME', 'gender');
	$smarty->assign('INPUT_MALE_VALUE', 'm');
	$smarty->assign('INPUT_FEMALE', xtc_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE, 'text' => (xtc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f'));
	$smarty->assign('INPUT_FEMALE_NAME', 'gender');
	$smarty->assign('INPUT_FEMALE_VALUE', 'f');

	$t_form_data_array['gender']['name'] = 'gender';
	$t_form_data_array['gender']['m']['value'] = 'm';
	$t_form_data_array['gender']['f']['value'] = 'f';
	$t_form_data_array['gender']['m']['checked'] = '0';
	$t_form_data_array['gender']['f']['checked'] = '0';

	if($gender == 'm')
	{
		$t_form_data_array['gender']['m']['checked'] = '1';
	}
	if($gender == 'f')
	{
		$t_form_data_array['gender']['f']['checked'] = '1';
	}

	$t_form_data_array['gender']['required'] = 1;
	$t_form_data_array['gender']['required_symbol'] = ENTRY_GENDER_TEXT;

} else {
	$smarty->assign('gender', '0');
}

$smarty->assign('INPUT_FIRSTNAME', xtc_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_FIRSTNAME_NAME', 'firstname');
$t_form_data_array['firstname']['name'] = 'firstname';
$t_form_data_array['firstname']['value'] = htmlspecialchars_wrapper($firstname);
$t_form_data_array['firstname']['required'] = 0;
$t_form_data_array['firstname']['required_symbol'] = ENTRY_FIRST_NAME_TEXT;
if((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['firstname']['required'] = 1;
}

$smarty->assign('INPUT_LASTNAME', xtc_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_LASTNAME_NAME', 'lastname');
$t_form_data_array['lastname']['name'] = 'lastname';
$t_form_data_array['lastname']['value'] = htmlspecialchars_wrapper($lastname);
$t_form_data_array['lastname']['required'] = 0;
$t_form_data_array['lastname']['required_symbol'] = ENTRY_LAST_NAME_TEXT;
if((int)ENTRY_LAST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['lastname']['required'] = 1;
}

if (ACCOUNT_DOB == 'true') {
	$smarty->assign('birthdate', '1');
	// BOF GM_MOD:
	$smarty->assign('INPUT_DOB', xtc_draw_input_fieldNote(array ('name' => 'dob', 'text' => '&nbsp;'. ((ENTRY_DOB_MIN_LENGTH != 0) ? '<span class="inputRequirement">'.ENTRY_DATE_OF_BIRTH_TEXT.'</span>' : '<span class="inputRequirement">'.str_replace('* ', '', ENTRY_DATE_OF_BIRTH_TEXT).'</span>')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$smarty->assign('INPUT_DOB_NAME', 'dob');
	$t_form_data_array['birthdate']['name'] = 'dob';
	$t_form_data_array['birthdate']['value'] = htmlspecialchars_wrapper($dob);
	$t_form_data_array['birthdate']['required'] = 0;
	$t_form_data_array['birthdate']['required_symbol'] = ENTRY_DATE_OF_BIRTH_TEXT;
	if((int)ENTRY_DOB_MIN_LENGTH > 0)
	{
		$t_form_data_array['birthdate']['required'] = 1;
	}
} else {
	$smarty->assign('birthdate', '0');
}

$smarty->assign('INPUT_EMAIL', xtc_draw_input_fieldNote(array ('name' => 'email_address', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_EMAIL_NAME', 'email_address');
$t_form_data_array['email']['name'] = 'email_address';
$t_form_data_array['email']['value'] = htmlspecialchars_wrapper($email_address);
$t_form_data_array['email']['required'] = 0;
$t_form_data_array['email']['required_symbol'] = ENTRY_EMAIL_ADDRESS_TEXT;
if((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0)
{
	$t_form_data_array['email']['required'] = 1;
}

$smarty->assign('INPUT_EMAIL_CONFIRM', xtc_draw_input_fieldNote(array ('name' => 'email_address_confirm', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_EMAIL_ADDRESS_TEXT) ? '<span class="inputRequirement">'.ENTRY_EMAIL_ADDRESS_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_EMAIL_CONFIRM_NAME', 'email_address_confirm');
$t_form_data_array['email_confirm']['name'] = 'email_address_confirm';
$t_form_data_array['email_confirm']['value'] = htmlspecialchars_wrapper($email_address_confirm);
$t_form_data_array['email_confirm']['required'] = 0;
$t_form_data_array['email_confirm']['required_symbol'] = ENTRY_EMAIL_ADDRESS_TEXT;
if((int)ENTRY_EMAIL_ADDRESS_MIN_LENGTH > 0)
{
	$t_form_data_array['email_confirm']['required'] = 1;
}

if (ACCOUNT_COMPANY == 'true') {
	$smarty->assign('company', '1');
	$smarty->assign('INPUT_COMPANY', xtc_draw_input_fieldNote(array ('name' => 'company', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COMPANY_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$smarty->assign('INPUT_COMPANY_NAME', 'company');
	$t_form_data_array['company']['name'] = 'company';
	$t_form_data_array['company']['value'] = htmlspecialchars_wrapper($company);
	$t_form_data_array['company']['required'] = 0;
	$t_form_data_array['company']['required_symbol'] = ENTRY_COMPANY_TEXT;
} else {
	$smarty->assign('company', '0');
}

if (ACCOUNT_COMPANY_VAT_CHECK == 'true') {
	$smarty->assign('vat', '1');
	$smarty->assign('INPUT_VAT', xtc_draw_input_fieldNote(array ('name' => 'vat', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_VAT_TEXT) ? '<span class="inputRequirement">'.ENTRY_VAT_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$smarty->assign('INPUT_VAT_NAME', 'vat');
	$t_form_data_array['vat']['name'] = 'vat';
	$t_form_data_array['vat']['value'] = htmlspecialchars_wrapper($vat);
	$t_form_data_array['vat']['required'] = 0;
	$t_form_data_array['vat']['required_symbol'] = ENTRY_VAT_TEXT;
} else {
	$smarty->assign('vat', '0');
}

$smarty->assign('INPUT_STREET', xtc_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">'.ENTRY_STREET_ADDRESS_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_STREET_NAME', 'street_address');
$t_form_data_array['street_address']['name'] = 'street_address';
$t_form_data_array['street_address']['value'] = htmlspecialchars_wrapper($street_address);
$t_form_data_array['street_address']['required'] = 0;
$t_form_data_array['street_address']['required_symbol'] = ENTRY_STREET_ADDRESS_TEXT;
if((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0)
{
	$t_form_data_array['street_address']['required'] = 1;
}

if (ACCOUNT_SUBURB == 'true') {
	$smarty->assign('suburb', '1');
	$smarty->assign('INPUT_SUBURB', xtc_draw_input_fieldNote(array ('name' => 'suburb', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">'.ENTRY_SUBURB_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$smarty->assign('INPUT_SUBURB_NAME', 'suburb');
	$t_form_data_array['suburb']['name'] = 'suburb';
	$t_form_data_array['suburb']['value'] = htmlspecialchars_wrapper($suburb);
	$t_form_data_array['suburb']['required'] = 0;
	$t_form_data_array['suburb']['required_symbol'] = ENTRY_STREET_ADDRESS_TEXT;
} else {
	$smarty->assign('suburb', '0');
}

$smarty->assign('INPUT_CODE', xtc_draw_input_fieldNote(array ('name' => 'postcode', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_CODE_NAME', 'postcode');
$t_form_data_array['postcode']['name'] = 'postcode';
$t_form_data_array['postcode']['value'] = htmlspecialchars_wrapper($postcode);
$t_form_data_array['postcode']['required'] = 0;
$t_form_data_array['postcode']['required_symbol'] = ENTRY_POSTCODE_TEXT;
if((int)ENTRY_POSTCODE_MIN_LENGTH > 0)
{
	$t_form_data_array['postcode']['required'] = 1;
}

$smarty->assign('INPUT_CITY', xtc_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">'.ENTRY_CITY_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$smarty->assign('INPUT_CITY_NAME', 'city');
$t_form_data_array['city']['name'] = 'city';
$t_form_data_array['city']['value'] = htmlspecialchars_wrapper($city);
$t_form_data_array['city']['required'] = 0;
$t_form_data_array['city']['required_symbol'] = ENTRY_CITY_TEXT;
if((int)ENTRY_CITY_MIN_LENGTH > 0)
{
	$t_form_data_array['city']['required'] = 1;
}

if (ACCOUNT_STATE == 'true') {
	$smarty->assign('state', '1');

	$t_form_data_array['state']['required'] = 0;
	$t_form_data_array['state']['required_symbol'] = ENTRY_STATE_TEXT;
	if((int)ENTRY_STATE_MIN_LENGTH > 0)
	{
		$t_form_data_array['state']['required'] = 1;
	}

	if ($process == true) {
		if ($entry_state_has_zones == true) {
			$zones_array = array ();
			$zones_query = xtc_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".(int) $country."' order by zone_name");
			while ($zones_values = xtc_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}
			$state_input = xtc_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array);

			$t_form_data_array['state']['name'] = 'state';
			$t_form_data_array['state']['type'] = 'selection';
			$t_form_data_array['state']['value'] = htmlspecialchars_wrapper($state);
			$smarty->assign('zones_data', $zones_array);
		} else {
			$state_input = xtc_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input');

			$t_form_data_array['state']['name'] = 'state';
			$t_form_data_array['state']['value'] = '';
			$t_form_data_array['state']['type'] = 'input';
		}
	} else {
		$state_input = xtc_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input');

		$t_form_data_array['state']['name'] = 'state';
		$t_form_data_array['state']['value'] = '';
		$t_form_data_array['state']['type'] = 'input';
	}

	$smarty->assign('INPUT_STATE', $state_input);

} else {
	$smarty->assign('state', '0');
}

if ($_POST['country']) {
	$selected = htmlentities_wrapper($_POST['country']);
} else {
	$selected = htmlspecialchars_wrapper(STORE_COUNTRY);
}
$smarty->assign('SELECT_COUNTRY', xtc_get_country_list(array ('name' => 'country', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COUNTRY_TEXT.'</span>' : '')), $selected));
$t_form_data_array['country']['name'] = 'country';
$t_form_data_array['country']['value'] = $selected;
$t_form_data_array['country']['required'] = 1;
$t_form_data_array['country']['required_symbol'] = ENTRY_COUNTRY_TEXT;
$smarty->assign('countries_data', xtc_get_countriesList());
// BOF GM_MOD:
if(ACCOUNT_TELEPHONE == 'true')
{
	$smarty->assign('INPUT_TEL', xtc_draw_input_fieldNote(array ('name' => 'telephone', 'text' => '&nbsp;'. ((ENTRY_TELEPHONE_MIN_LENGTH != 0) ? '<span class="inputRequirement">'.ENTRY_TELEPHONE_NUMBER_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$smarty->assign('INPUT_TEL_NAME', 'telephone');
	$t_form_data_array['telephone']['name'] = 'telephone';
	$t_form_data_array['telephone']['value'] = htmlspecialchars_wrapper($telephone);
	$t_form_data_array['telephone']['required'] = 0;
	$t_form_data_array['telephone']['required_symbol'] = ENTRY_TELEPHONE_NUMBER_TEXT;
	if((int)ENTRY_TELEPHONE_MIN_LENGTH > 0)
	{
		$t_form_data_array['telephone']['required'] = 1;
	}
}
if(ACCOUNT_FAX == 'true')
{
	$smarty->assign('INPUT_FAX', xtc_draw_input_fieldNote(array ('name' => 'fax', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_FAX_NUMBER_TEXT) ? '<span class="inputRequirement">'.ENTRY_FAX_NUMBER_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$smarty->assign('INPUT_FAX_NAME', 'fax');
	$t_form_data_array['fax']['name'] = 'fax';
	$t_form_data_array['fax']['value'] = htmlspecialchars_wrapper($fax);
	$t_form_data_array['fax']['required'] = 0;
	$t_form_data_array['fax']['required_symbol'] = ENTRY_TELEPHONE_NUMBER_TEXT;
}
//  $smarty->assign('CHECKBOX_NEWSLETTER',xtc_draw_checkbox_field('newsletter', '1') . '&nbsp;' . (xtc_not_null(ENTRY_NEWSLETTER_TEXT) ? '<span class="inputRequirement">' . ENTRY_NEWSLETTER_TEXT . '</span>': ''));
$smarty->assign('FORM_END', '</form>');

$smarty->assign('form_data', $t_form_data_array);

$smarty->assign('language', $_SESSION['language']);
$smarty->caching = 0;

// BOF GM_MOD
$gm_query = xtc_db_query("
							SELECT
								*
							FROM
								content_manager
							WHERE
								languages_id	=	'" . (int) $_SESSION['languages_id']."'
							AND
								content_group		= '2'
						");

$gm_array = xtc_db_fetch_array($gm_query);

$SEF_parameter = '';
if (SEARCH_ENGINE_FRIENDLY_URLS == 'true') {
	$SEF_parameter = '&content=' . xtc_cleanName($gm_array['content_title']);
}
$gm_privacy_link = xtc_href_link('popup_content.php', 'lightbox_mode=1&coID=' . $gm_array['content_group'] . $SEF_parameter);

if(gm_get_conf('GM_SHOW_PRIVACY_REGISTRATION')) {
	$smarty->assign('PRIVACY_LINK', sprintf(ENTRY_SHOW_PRIVACY, $gm_privacy_link));
	$smarty->assign('show_privacy', 1);
}

$smarty->assign('LIGHTBOX', gm_get_conf('GM_LIGHTBOX_CREATE_ACCOUNT'));
$smarty->assign('BUTTON_BACK', '<a href="' . xtc_href_link(FILENAME_LOGIN, '', 'SSL') . '"><img src="templates/' . CURRENT_TEMPLATE . '/buttons/' . $_SESSION['language'] . '/button_back.gif" alt="' . IMAGE_BUTTON_BACK . '" title="' . IMAGE_BUTTON_BACK . '" border="0" /></a>');
$smarty->assign('BUTTON_BACK_LINK', xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
$smarty->assign('LINK_CLOSE', xtc_href_link(FILENAME_DEFAULT));
// EOF GM_MOD

$smarty->assign('LIGHTBOX_CLOSE', xtc_href_link(FILENAME_LOGIN, '', 'NONSSL'));

$smarty->assign('BUTTON_SUBMIT', xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE));

if(isset($_GET['checkout_started']) && $_GET['checkout_started'] == 1)
{
	$smarty->assign('CHECKOUT_STARTED', 1);
}

$main_content = $smarty->fetch(CURRENT_TEMPLATE.'/module/create_account_guest.html');

$smarty->assign('language', $_SESSION['language']);
$smarty->assign('main_content', $main_content);
$smarty->caching = 0;
if (!defined(RM))
	$smarty->load_filter('output', 'note');
$smarty->display(CURRENT_TEMPLATE.'/index.html');
include ('includes/application_bottom.php');
?>