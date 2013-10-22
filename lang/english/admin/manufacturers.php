<?php
/* --------------------------------------------------------------
   manufacturers.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.14 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (manufacturers.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: manufacturers.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Manufacturers');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Catalog');
// EOF GM_MOD

define('TABLE_HEADING_MANUFACTURERS', 'Manufacturers');
define('TABLE_HEADING_ACTION', 'Action');
define('TEXT_MARKED_ELEMENTS','Marked Element');
define('TEXT_HEADING_NEW_MANUFACTURER', 'New Manufacturer');
define('TEXT_HEADING_EDIT_MANUFACTURER', 'Edit Manufacturer');
define('TEXT_HEADING_DELETE_MANUFACTURER', 'Delete Manufacturer');

define('TEXT_MANUFACTURERS', 'Manufacturers:');
define('TEXT_DATE_ADDED', 'Date Added:');
define('TEXT_LAST_MODIFIED', 'Last Modified:');
define('TEXT_PRODUCTS', 'Products:');
define('TEXT_IMAGE_NONEXISTENT', 'IMAGE DOES NOT EXIST');

define('TEXT_NEW_INTRO', 'Please enter the following information for the new manufacturer');
define('TEXT_EDIT_INTRO', 'Please make any necessary changes');

define('TEXT_MANUFACTURERS_NAME', 'Manufacturer Name:');
define('TEXT_MANUFACTURERS_IMAGE', 'Manufacturer Image:');
define('TEXT_MANUFACTURERS_URL', 'Manufacturer URL:');

define('TEXT_DELETE_INTRO', 'Are you sure you want to delete this manufacturer?');
define('TEXT_DELETE_IMAGE', 'Delete manufacturers image?');
define('TEXT_DELETE_PRODUCTS', 'Delete products from this manufacturer (including product reviews, products on special, expected products)?');
define('TEXT_DELETE_WARNING_PRODUCTS', '<b>IMPORTANT:</b> There are %s products still linked to this manufacturer!');

define('ERROR_DIRECTORY_NOT_WRITEABLE', 'Error: I cannot write to this directory. Please set the correct user permissions for this directory: %s');
define('ERROR_DIRECTORY_DOES_NOT_EXIST', 'Error: Directory does not exist: %s');
?>