<?php
/* --------------------------------------------------------------
   tax_rates.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(tax_rates.php,v 1.9 2003/03/13); www.oscommerce.com 
   (c) 2003	 nextcommerce (tax_rates.php,v 1.4 2003/08/1); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: tax_rates.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Tax Rates');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Zone / Tax');
define('HEADING_WARNING', '');
// EOF GM_MOD

define('TABLE_HEADING_TAX_RATE_PRIORITY', 'Priority');
define('TABLE_HEADING_TAX_CLASS_TITLE', 'Tax Class');
define('TABLE_HEADING_COUNTRIES_NAME', 'Country');
define('TABLE_HEADING_ZONE', 'Zone');
define('TABLE_HEADING_TAX_RATE', 'Tax Rate');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_DATE_ADDED', 'Date added:');
define('TEXT_INFO_LAST_MODIFIED', 'Last modified:');
define('TEXT_INFO_CLASS_TITLE', 'Tax class title:');
define('TEXT_INFO_COUNTRY_NAME', 'Country:');
define('TEXT_INFO_ZONE_NAME', 'Zone:');
define('TEXT_INFO_TAX_RATE', 'Tax rate (%):');
define('TEXT_INFO_TAX_RATE_PRIORITY', 'Tax rates at the same priority are added, other rates are compounded.<br /><br />Priority:');
define('TEXT_INFO_RATE_DESCRIPTION', 'Description:');
define('TEXT_INFO_INSERT_INTRO', 'Please enter the new tax rate with its related data');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this tax rate?');
define('TEXT_INFO_HEADING_NEW_TAX_RATE', 'New Tax Rate');
define('TEXT_INFO_HEADING_EDIT_TAX_RATE', 'Edit Tax Rate');
define('TEXT_INFO_HEADING_DELETE_TAX_RATE', 'Delete Tax Rate');
?>