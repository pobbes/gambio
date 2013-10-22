<?php
/* --------------------------------------------------------------
   stats_campaigns.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(stats_sales_report.php,v 1.6 2002/03/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (stats_sales_report.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2005 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: stats_campaigns.php 1118 2005-07-25 21:11:34Z mz $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Campaign Report');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Statistics');
// EOF GM_MOD

define('REPORT_TYPE_YEARLY', 'Annually');
define('REPORT_TYPE_MONTHLY', 'Monthly');
define('REPORT_TYPE_WEEKLY', 'Weekly');
define('REPORT_TYPE_DAILY', 'Daily');
define('REPORT_START_DATE', 'from date');
define('REPORT_END_DATE', 'to date (inclusive)');

define('REPORT_ALL', 'All');
define('REPORT_STATUS_FILTER', 'Order Status:');
define('REPORT_CAMPAIGN_FILTER', 'Campaign');

define('HEADING_TOTAL', 'Total:');
define('HEADING_LEADS', 'Leads');
define('HEADING_SELLS', 'Sells');
define('HEADING_HITS','Hits');
define('HEADING_LATESELLS', 'Late Sells');
define('HEADING_SUM', 'Sum');
define('TEXT_REFERER', 'Referrer:');
?>