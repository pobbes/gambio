<?php
/* --------------------------------------------------------------
   banner_statistics.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(banner_statistics.php,v 1.3 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (banner_statistics.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: banner_statistics.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Banner Statistics');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Tools');
// EOF GM_MOD

define('TABLE_HEADING_SOURCE', 'Source');
define('TABLE_HEADING_VIEWS', 'Views');
define('TABLE_HEADING_CLICKS', 'Clicks');

define('TEXT_BANNERS_DATA', 'D<br />a<br />t<br />a');
define('TEXT_BANNERS_DAILY_STATISTICS', '%s Daily Statistics For %s %s');
define('TEXT_BANNERS_MONTHLY_STATISTICS', '%s Monthly Statistics For %s');
define('TEXT_BANNERS_YEARLY_STATISTICS', '%s Annual Statistics');

define('STATISTICS_TYPE_DAILY', 'Daily');
define('STATISTICS_TYPE_MONTHLY', 'Monthly');
define('STATISTICS_TYPE_YEARLY', 'Annually');

define('TITLE_TYPE', 'Type:');
define('TITLE_YEAR', 'Year:');
define('TITLE_MONTH', 'Month:');

define('ERROR_GRAPHS_DIRECTORY_DOES_NOT_EXIST', 'Error: Graphs directory does not exist. Please create a \'graphs\' directory in \'images\'.');
define('ERROR_GRAPHS_DIRECTORY_NOT_WRITEABLE', 'Error: Graphs directory is not writeable.');
?>