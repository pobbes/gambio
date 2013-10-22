<?php
/* --------------------------------------------------------------
   checkout_new_address.php 2010-12-06 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(checkout_new_address.php,v 1.3 2003/05/19); www.oscommerce.com
   (c) 2003	 nextcommerce (checkout_new_address.php,v 1.8 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: checkout_new_address.php 1239 2005-09-24 20:09:56Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

$module_smarty = new Smarty;
$module_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
// include needed functions
require_once (DIR_FS_INC.'xtc_get_country_list.inc.php');
include_once('inc/xtc_get_zone_name.inc.php');
if (!isset ($process))
	$process = false;
// bof gm
if (isset ($_POST['action']) && ($_POST['action'] == 'submit')) {

	if (ACCOUNT_GENDER == 'true')
		$gender = xtc_db_prepare_input($_POST['gender']);
	if (ACCOUNT_COMPANY == 'true')
		$company = xtc_db_prepare_input($_POST['company']);
	$firstname = xtc_db_prepare_input($_POST['firstname']);
	$lastname = xtc_db_prepare_input($_POST['lastname']);
	$street_address = xtc_db_prepare_input($_POST['street_address']);
	if (ACCOUNT_SUBURB == 'true')
		$suburb = xtc_db_prepare_input($_POST['suburb']);
	$postcode = xtc_db_prepare_input($_POST['postcode']);
	$city = xtc_db_prepare_input($_POST['city']);
	$country = xtc_db_prepare_input($_POST['country']);
	if (ACCOUNT_STATE == 'true') {
		$zone_id = xtc_db_prepare_input($_POST['zone_id']);
		$state = xtc_db_prepare_input($_POST['state']);
	}

	if (ACCOUNT_GENDER == 'true') {
		if (($gender != 'm') && ($gender != 'f')) {
			$error = true;
			$module_smarty->assign('error_gender', ENTRY_GENDER_ERROR);
			$messageStack->add('create_account', ENTRY_GENDER_ERROR);
		}
	}

	if (strlen($firstname) < ENTRY_FIRST_NAME_MIN_LENGTH) {
		$error = true;
		$module_smarty->assign('error_first_name', ENTRY_FIRST_NAME_ERROR);
		$messageStack->add('create_account', ENTRY_FIRST_NAME_ERROR);
	}

	if (strlen($lastname) < ENTRY_LAST_NAME_MIN_LENGTH) {
		$error = true;
		$module_smarty->assign('error_last_name', ENTRY_LAST_NAME_ERROR);
		$messageStack->add('create_account', ENTRY_LAST_NAME_ERROR);
	}

	if (strlen($street_address) < ENTRY_STREET_ADDRESS_MIN_LENGTH) {
		$error = true;
		$module_smarty->assign('error_street', ENTRY_STREET_ADDRESS_ERROR);
		$messageStack->add('create_account', ENTRY_STREET_ADDRESS_ERROR);
	}

	if (strlen($postcode) < ENTRY_POSTCODE_MIN_LENGTH) {
		$error = true;
		$module_smarty->assign('error_post_code', ENTRY_POST_CODE_ERROR);
		$messageStack->add('create_account', ENTRY_POST_CODE_ERROR);
	}

	if (strlen($city) < ENTRY_CITY_MIN_LENGTH) {
		$error = true;
		$module_smarty->assign('error_city', ENTRY_CITY_ERROR);
		$messageStack->add('create_account', ENTRY_CITY_ERROR);
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
				$module_smarty->assign('error_state', ENTRY_STATE_ERROR_SELECT);
				$messageStack->add('create_account', ENTRY_STATE_ERROR_SELECT);
			}
		} else {
			if (strlen($state) < ENTRY_STATE_MIN_LENGTH) {
				$error = true;
				$module_smarty->assign('error_state', ENTRY_STATE_ERROR);
				$messageStack->add('create_account', ENTRY_STATE_ERROR);
			}
		}
	}

	if (is_numeric($country) == false) {
		$error = true;
		$module_smarty->assign('error_country', ENTRY_COUNTRY_ERROR);
		$messageStack->add('create_account', ENTRY_COUNTRY_ERROR);
	}
}
// eof gm

$t_form_data_array = array();

if (ACCOUNT_GENDER == 'true') {
	$male = ($gender == 'm') ? true : false;
	$female = ($gender == 'f') ? true : false;
	$module_smarty->assign('gender', '1');
	$module_smarty->assign('INPUT_MALE', xtc_draw_radio_field(array ('name' => 'gender', 'suffix' => MALE), 'm'));
	$module_smarty->assign('INPUT_FEMALE', xtc_draw_radio_field(array ('name' => 'gender', 'suffix' => FEMALE, 'text' => (xtc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">'.ENTRY_GENDER_TEXT.'</span>' : '')), 'f'));

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
// BOF GM_MOD:
$module_smarty->assign('INPUT_FIRSTNAME', xtc_draw_input_fieldNote(array ('name' => 'firstname', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_FIRST_NAME_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$t_form_data_array['firstname']['name'] = 'firstname';
$t_form_data_array['firstname']['value'] = $firstname;
$t_form_data_array['firstname']['required'] = 0;
$t_form_data_array['firstname']['required_symbol'] = ENTRY_FIRST_NAME_TEXT;
if((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['firstname']['required'] = 1;
}
$module_smarty->assign('INPUT_LASTNAME', xtc_draw_input_fieldNote(array ('name' => 'lastname', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">'.ENTRY_LAST_NAME_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$t_form_data_array['lastname']['name'] = 'lastname';
$t_form_data_array['lastname']['value'] = $lastname;
$t_form_data_array['lastname']['required'] = 0;
$t_form_data_array['lastname']['required_symbol'] = ENTRY_LAST_NAME_TEXT;
if((int)ENTRY_LAST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['lastname']['required'] = 1;
}

if (ACCOUNT_COMPANY == 'true') {
	$module_smarty->assign('company', '1');
	$module_smarty->assign('INPUT_COMPANY', xtc_draw_input_fieldNote(array ('name' => 'company', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COMPANY_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$t_form_data_array['company']['name'] = 'company';
	$t_form_data_array['company']['value'] = $company;
	$t_form_data_array['company']['required'] = 0;
	$t_form_data_array['company']['required_symbol'] = ENTRY_LAST_NAME_TEXT;
} else {
	$module_smarty->assign('company', '0');
	//  }

}
$module_smarty->assign('INPUT_STREET', xtc_draw_input_fieldNote(array ('name' => 'street_address', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">'.ENTRY_STREET_ADDRESS_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$t_form_data_array['street_address']['name'] = 'street_address';
$t_form_data_array['street_address']['value'] = $street_address;
$t_form_data_array['street_address']['required'] = 0;
$t_form_data_array['street_address']['required_symbol'] = ENTRY_STREET_ADDRESS_TEXT;
if((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0)
{
	$t_form_data_array['street_address']['required'] = 1;
}

if (ACCOUNT_SUBURB == 'true') {
	$module_smarty->assign('suburb', '1');
	$module_smarty->assign('INPUT_SUBURB', xtc_draw_input_fieldNote(array ('name' => 'suburb', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">'.ENTRY_SUBURB_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
	$t_form_data_array['suburb']['name'] = 'suburb';
	$t_form_data_array['suburb']['value'] = $suburb;
	$t_form_data_array['suburb']['required'] = 0;
	$t_form_data_array['suburb']['required_symbol'] = ENTRY_SUBURB_TEXT;
}
$module_smarty->assign('INPUT_CODE', xtc_draw_input_fieldNote(array ('name' => 'postcode', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">'.ENTRY_POST_CODE_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$t_form_data_array['postcode']['name'] = 'postcode';
$t_form_data_array['postcode']['value'] = $postcode;
$t_form_data_array['postcode']['required'] = 0;
$t_form_data_array['postcode']['required_symbol'] = ENTRY_POST_CODE_TEXT;
if((int)ENTRY_POSTCODE_MIN_LENGTH > 0)
{
	$t_form_data_array['postcode']['required'] = 1;
}

$module_smarty->assign('INPUT_CITY', xtc_draw_input_fieldNote(array ('name' => 'city', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">'.ENTRY_CITY_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input'));
$t_form_data_array['city']['name'] = 'city';
$t_form_data_array['city']['value'] = $city;
$t_form_data_array['city']['required'] = 0;
$t_form_data_array['city']['required_symbol'] = ENTRY_CITY_TEXT;
if((int)ENTRY_CITY_MIN_LENGTH > 0)
{
	$t_form_data_array['city']['required'] = 1;
}

if (ACCOUNT_STATE == 'true') {
	$module_smarty->assign('state', '1');

	$t_form_data_array['state']['required'] = 0;
	$t_form_data_array['state']['required_symbol'] = ENTRY_STATE_TEXT;
	if((int)ENTRY_STATE_MIN_LENGTH > 0)
	{
		$t_form_data_array['state']['required'] = 1;
	}

	if ($country == true) {
		if ($entry_state_has_zones == true) {

			$zones_array = array ();
			$zones_query = xtc_db_query("select zone_name from ".TABLE_ZONES." where zone_country_id = '".xtc_db_input($country)."' order by zone_name");
			while ($zones_values = xtc_db_fetch_array($zones_query)) {
				$zones_array[] = array ('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}
			$t_form_data_array['state']['name'] = 'state';
			$t_form_data_array['state']['type'] = 'selection';
			$t_form_data_array['state']['value'] = $zone_id;
			$entry_state = xtc_draw_pull_down_menuNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), $zones_array);

			$module_smarty->assign('zones_data', $zones_array);
		} else {
			$entry_state = xtc_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input');
		
			$t_form_data_array['state']['name'] = 'state';
			$t_form_data_array['state']['value'] = '';
			$t_form_data_array['state']['type'] = 'input';
		}
	} else {
		$entry_state = xtc_draw_input_fieldNote(array ('name' => 'state', 'text' => '&nbsp;'. (xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">'.ENTRY_STATE_TEXT.'</span>' : '')), '', '', 'text', true, 'gm_mb_input inactive_input');
	
		$t_form_data_array['state']['name'] = 'state';
		$t_form_data_array['state']['value'] = xtc_get_zone_name($country, $zone_id, $state);
		$t_form_data_array['state']['type'] = 'input';
	}

	$module_smarty->assign('INPUT_STATE', $entry_state);
} else {
	$module_smarty->assign('state', '0');
}

if($_POST['country'])
{
	$t_selected = htmlentities_wrapper($_POST['country']);
}
else
{
	$t_selected = STORE_COUNTRY;
}

$t_form_data_array['country']['name'] = 'country';
$t_form_data_array['country']['value'] = $t_selected;
$t_form_data_array['country']['required'] = 1;
$t_form_data_array['country']['required_symbol'] = ENTRY_STATE_TEXT;

$module_smarty->assign('form_data', $t_form_data_array);

$module_smarty->assign('countries_data', xtc_get_countriesList());
$module_smarty->assign('SELECT_COUNTRY', xtc_get_country_list('country', $t_selected).'&nbsp;'. (xtc_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">'.ENTRY_COUNTRY_TEXT.'</span>' : ''));

$module_smarty->assign('language', $_SESSION['language']);

$module_smarty->caching = 0;

$module = $module_smarty->fetch(CURRENT_TEMPLATE.'/module/checkout_new_address.html');

$smarty->assign('MODULE_new_address', $module);
?>