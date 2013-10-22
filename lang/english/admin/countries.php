<?php
/* --------------------------------------------------------------
   countries.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(countries.php,v 1.8 2002/01/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (countries.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: countries.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Countries');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Zone / Tax');
define('HEADING_WARNING', '');
// EOF GM_MOD

define('TABLE_HEADING_COUNTRY_NAME', 'Country');
define('TABLE_HEADING_COUNTRY_CODES', 'ISO Codes');
define('TABLE_HEADING_ACTION', 'Action');
define('TABLE_HEADING_STATUS', 'Status');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_COUNTRY_NAME', 'Name:');
define('TEXT_INFO_COUNTRY_CODE_2', 'ISO Code (2):');
define('TEXT_INFO_COUNTRY_CODE_3', 'ISO Code (3):');
define('TEXT_INFO_ADDRESS_FORMAT', 'Address Format:');
define('TEXT_INFO_INSERT_INTRO', 'Please enter the new country with its related data');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this country?');
define('TEXT_INFO_HEADING_NEW_COUNTRY', 'New Country');
define('TEXT_INFO_HEADING_EDIT_COUNTRY', 'Edit Country');
define('TEXT_INFO_HEADING_DELETE_COUNTRY', 'Delete Country');
define('GM_BUTTON_DACH',		'Activate Germany, Austria and Switzerland');
define('GM_BUTTON_ACTIVE',		'Activate all');
define('GM_BUTTON_INACTIVE',	'Deactivate all');
?>