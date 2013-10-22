<?php
/* --------------------------------------------------------------
   languages.php 2010-03-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.10 2002/01/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (languages.php,v 1.5 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: languages.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Languages');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Zone / Tax');
define('HEADING_WARNING', '');

define('GM_LANGUAGE_CONFIGURATION_TITLE', 'Configuration');
define('GM_LANGUAGE_CONFIGURATION_TEXT', 'Use browser language as shop language');
define('GM_LANGUAGE_CONFIGURATION_SUCCESS', 'The changes were successfully saved!');
// EOF GM_MOD

define('TABLE_HEADING_LANGUAGE_NAME', 'Language');
define('TABLE_HEADING_LANGUAGE_CODE', 'Code');
define('TABLE_HEADING_ACTION', 'Action');

define('TEXT_INFO_EDIT_INTRO', 'Please make any necessary changes');
define('TEXT_INFO_LANGUAGE_NAME', 'Name:');
define('TEXT_INFO_LANGUAGE_CODE', 'Code:');
define('TEXT_INFO_LANGUAGE_IMAGE', 'Image:');
define('TEXT_INFO_LANGUAGE_DIRECTORY', 'Directory:');
define('TEXT_INFO_LANGUAGE_SORT_ORDER', 'Sort Order:');
define('TEXT_INFO_INSERT_INTRO', 'Please enter the new language with its related data');
define('TEXT_INFO_DELETE_INTRO', 'Are you sure you want to delete this language?');
define('TEXT_INFO_HEADING_NEW_LANGUAGE', 'New Language');
define('TEXT_INFO_HEADING_EDIT_LANGUAGE', 'Edit Language');
define('TEXT_INFO_HEADING_DELETE_LANGUAGE', 'Delete Language');
define('TEXT_INFO_LANGUAGE_CHARSET','Charset');
define('TEXT_INFO_LANGUAGE_CHARSET_INFO','meta content:');


define('ERROR_REMOVE_DEFAULT_LANGUAGE', 'Error: The default language cannot be removed. Please set another language as the default and try again.');

?>