<?php
/* --------------------------------------------------------------
   address_book_details.php 2008-06-26 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(address_book_details.php,v 1.9 2003/05/22); www.oscommerce.com
   (c) 2003	 nextcommerce (address_book_details.php,v 1.9 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: address_book_details.php 1239 2005-09-24 20:09:56Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------/-----*/

// include needed functions
$module_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
include_once('inc/xtc_get_zone_name.inc.php');
include_once('inc/xtc_get_country_list.inc.php');


if (!isset($process)) $process = false;

$t_form_data_array = array();

if(ACCOUNT_GENDER == 'true')
{
	$male = ($entry['entry_gender'] == 'm') ? true : false;
	$female = ($entry['entry_gender'] == 'f') ? true : false;

	$module_smarty->assign('gender','1');
	$module_smarty->assign('INPUT_MALE',xtc_draw_radio_field(array('name'=>'gender','suffix'=>MALE.'&nbsp;'), 'm',$male));
	$module_smarty->assign('INPUT_FEMALE',xtc_draw_radio_field(array('name'=>'gender','suffix'=>FEMALE.'&nbsp;','text'=>(xtc_not_null(ENTRY_GENDER_TEXT) ? '<span class="inputRequirement">&nbsp;' . ENTRY_GENDER_TEXT . '</span>': '')), 'f',$female));

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


$module_smarty->assign('INPUT_FIRSTNAME',xtc_draw_input_fieldNote(array('name'=>'firstname','text'=>'&nbsp;' . (xtc_not_null(ENTRY_FIRST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_FIRST_NAME_TEXT . '</span>': '')),$entry['entry_firstname']));
$t_form_data_array['firstname']['name'] = 'firstname';
$t_form_data_array['firstname']['value'] = $entry['entry_firstname'];
$t_form_data_array['firstname']['required'] = 0;
$t_form_data_array['firstname']['required_symbol'] = ENTRY_FIRST_NAME_TEXT;
if((int)ENTRY_FIRST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['firstname']['required'] = 1;
}

$module_smarty->assign('INPUT_LASTNAME',xtc_draw_input_fieldNote(array('name'=>'lastname','text'=>'&nbsp;' . (xtc_not_null(ENTRY_LAST_NAME_TEXT) ? '<span class="inputRequirement">' . ENTRY_LAST_NAME_TEXT . '</span>': '')),$entry['entry_lastname']));
$t_form_data_array['lastname']['name'] = 'lastname';
$t_form_data_array['lastname']['value'] = $entry['entry_lastname'];
$t_form_data_array['lastname']['required'] = 0;
$t_form_data_array['lastname']['required_symbol'] = ENTRY_LAST_NAME_TEXT;
if((int)ENTRY_LAST_NAME_MIN_LENGTH > 0)
{
	$t_form_data_array['lastname']['required'] = 1;
}

if(ACCOUNT_COMPANY == 'true')
{
	$module_smarty->assign('company','1');
	$module_smarty->assign('INPUT_COMPANY',xtc_draw_input_fieldNote(array('name'=>'company','text'=>'&nbsp;' . (xtc_not_null(ENTRY_COMPANY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COMPANY_TEXT . '</span>': '')), $entry['entry_company']));

	$t_form_data_array['company']['name'] = 'company';
	$t_form_data_array['company']['value'] = $entry['entry_company'];
	$t_form_data_array['company']['required'] = 0;
	$t_form_data_array['company']['required_symbol'] = ENTRY_COMPANY_TEXT;
	/*
	if((int)ENTRY_COMPANY_MIN_LENGTH > 0)
	{
		$t_form_data_array['company']['required'] = 1;
	}
	*/
}


$module_smarty->assign('INPUT_STREET',xtc_draw_input_fieldNote(array('name'=>'street_address','text'=>'&nbsp;' . (xtc_not_null(ENTRY_STREET_ADDRESS_TEXT) ? '<span class="inputRequirement">' . ENTRY_STREET_ADDRESS_TEXT . '</span>': '')), $entry['entry_street_address']));
$t_form_data_array['street_address']['name'] = 'street_address';
$t_form_data_array['street_address']['value'] = $entry['entry_street_address'];
$t_form_data_array['street_address']['required'] = 0;
$t_form_data_array['street_address']['required_symbol'] = ENTRY_STREET_ADDRESS_TEXT;
if((int)ENTRY_STREET_ADDRESS_MIN_LENGTH > 0)
{
	$t_form_data_array['street_address']['required'] = 1;
}

 if(ACCOUNT_SUBURB == 'true')
{
	$module_smarty->assign('suburb','1');
	$module_smarty->assign('INPUT_SUBURB',xtc_draw_input_fieldNote(array('name'=>'suburb','text'=>'&nbsp;' . (xtc_not_null(ENTRY_SUBURB_TEXT) ? '<span class="inputRequirement">' . ENTRY_SUBURB_TEXT . '</span>': '')), $entry['entry_suburb']));

	$t_form_data_array['suburb']['name'] = 'suburb';
	$t_form_data_array['suburb']['value'] = $entry['entry_suburb'];
	$t_form_data_array['suburb']['required'] = 0;
	$t_form_data_array['suburb']['required_symbol'] = ENTRY_SUBURB_TEXT;
}

$module_smarty->assign('INPUT_CODE',xtc_draw_input_fieldNote(array('name'=>'postcode','text'=>'&nbsp;' . (xtc_not_null(ENTRY_POST_CODE_TEXT) ? '<span class="inputRequirement">' . ENTRY_POST_CODE_TEXT . '</span>': '')), $entry['entry_postcode']));
$t_form_data_array['postcode']['name'] = 'postcode';
$t_form_data_array['postcode']['value'] = $entry['entry_postcode'];
$t_form_data_array['postcode']['required'] = 0;
$t_form_data_array['postcode']['required_symbol'] = ENTRY_POST_CODE_TEXT;
if((int)ENTRY_POSTCODE_MIN_LENGTH > 0)
{
	$t_form_data_array['postcode']['required'] = 1;
}

$module_smarty->assign('INPUT_CITY',xtc_draw_input_fieldNote(array('name'=>'city','text'=>'&nbsp;' . (xtc_not_null(ENTRY_CITY_TEXT) ? '<span class="inputRequirement">' . ENTRY_CITY_TEXT . '</span>': '')), $entry['entry_city']));
$t_form_data_array['city']['name'] = 'city';
$t_form_data_array['city']['value'] = $entry['entry_city'];
$t_form_data_array['city']['required'] = 0;
$t_form_data_array['city']['required_symbol'] = ENTRY_CITY_TEXT;
if((int)ENTRY_CITY_MIN_LENGTH > 0)
{
	$t_form_data_array['city']['required'] = 1;
}

if(ACCOUNT_STATE == 'true')
{
	$module_smarty->assign('state','1');

	$t_form_data_array['state']['required'] = 0;
	$t_form_data_array['state']['required_symbol'] = ENTRY_STATE_TEXT;
	if((int)ENTRY_STATE_MIN_LENGTH > 0)
	{
		$t_form_data_array['state']['required'] = 1;
	}
	
	if($process == true)
	{
		if($entry_state_has_zones == true)
		{
			$zones_array = array();
			$zones_query = xtc_db_query("select zone_name from " . TABLE_ZONES . " where zone_country_id = '" . xtc_db_input($country) . "' order by zone_name");
			while ($zones_values = xtc_db_fetch_array($zones_query)) {
				$zones_array[] = array('id' => $zones_values['zone_name'], 'text' => $zones_values['zone_name']);
			}
			$state_input= xtc_draw_pull_down_menuNote(array('name'=>'state','text'=>'&nbsp;' .(xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>': '')), $zones_array);

			$t_form_data_array['state']['name'] = 'state';
			$t_form_data_array['state']['type'] = 'selection';
			$t_form_data_array['state']['value'] = $state;
			
			$module_smarty->assign('zones_data', $zones_array);

		}
		else
		{
			$state_input= xtc_draw_input_fieldNote(array('name'=>'state','text'=>'&nbsp;' .(xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>': '')));

			$t_form_data_array['state']['name'] = 'state';
			$t_form_data_array['state']['value'] = '';
			$t_form_data_array['state']['type'] = 'input';

		}
	}
	else
	{
		$state_input= xtc_draw_input_fieldNote(array('name'=>'state','text'=>'&nbsp;' .(xtc_not_null(ENTRY_STATE_TEXT) ? '<span class="inputRequirement">' . ENTRY_STATE_TEXT . '</span>': '')), xtc_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']));

		$t_form_data_array['state']['name'] = 'state';
		$t_form_data_array['state']['value'] = xtc_get_zone_name($entry['entry_country_id'], $entry['entry_zone_id'], $entry['entry_state']);
		$t_form_data_array['state']['type'] = 'input';
	}

	$module_smarty->assign('INPUT_STATE',$state_input);
}

if($_POST['country'])
{
	$t_selected = htmlentities_wrapper($_POST['country']);
}
else
{
	$t_selected = $entry['entry_country_id'];
}

$t_form_data_array['country']['name'] = 'country';
$t_form_data_array['country']['value'] = $t_selected;
$t_form_data_array['country']['required'] = 1;
$t_form_data_array['country']['required_symbol'] = ENTRY_STATE_TEXT;

$module_smarty->assign('countries_data', xtc_get_countriesList());

$module_smarty->assign('SELECT_COUNTRY',xtc_get_country_list(array('name'=>'country','text'=>'&nbsp;' . (xtc_not_null(ENTRY_COUNTRY_TEXT) ? '<span class="inputRequirement">' . ENTRY_COUNTRY_TEXT . '</span>': '')), $t_selected));

if ((isset($_GET['edit']) && ($_SESSION['customer_default_address_id'] != $_GET['edit'])) || (isset($_GET['edit']) == false) ) {
	$module_smarty->assign('new','1');
	$module_smarty->assign('CHECKBOX_PRIMARY',xtc_draw_checkbox_field('primary', 'on', false, 'id="primary"'));
	$t_checkbox_primary_array = array();
	$t_checkbox_primary_array = array(	'NAME' => 'primary',
										'VALUE' => 'on',
										'ID' => 'primary');
	$module_smarty->assign('checkbox_primary_data', $t_checkbox_primary_array);
}

$module_smarty->assign('form_data', $t_form_data_array);

$back_link = xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL');
$module_smarty->assign('BUTTON_BACK', '<a href="'.$back_link.'">'.xtc_image_button('button_back.gif', IMAGE_BUTTON_BACK).'</a>');
$module_smarty->assign('BUTTON_BACK_LINK', $back_link);
$module_smarty->assign('HIDDEN_FIELD_NAME', 'action');
if (isset ($_GET['edit']) && is_numeric($_GET['edit'])) {
	$module_smarty->assign('BUTTON_UPDATE', xtc_draw_hidden_field('action', 'update').xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE), 1);
	$module_smarty->assign('HIDDEN_FIELD_VALUE', 'update');
} else {
	$module_smarty->assign('BUTTON_UPDATE', xtc_draw_hidden_field('action', 'process').xtc_image_submit('button_continue.gif', IMAGE_BUTTON_CONTINUE), 1);
	$module_smarty->assign('HIDDEN_FIELD_VALUE', 'process');
}


if (isset ($_GET['delete'])) {
	$smarty->assign('delete', '1');
}
  
  $module_smarty->assign('language', $_SESSION['language']);
  $module_smarty->caching = 0;

/* BOF GM PRIVACY LINK */
	$module_smarty->assign('GM_PRIVACY_LINK', gm_get_privacy_link('GM_CHECK_PRIVACY_ACCOUNT_ADDRESS_BOOK'));
/* EOF GM PRIVACY LINK */


  $main_content=$module_smarty->fetch(CURRENT_TEMPLATE . '/module/address_book_details.html');
  $smarty->assign('MODULE_address_book_details',$main_content);
?>