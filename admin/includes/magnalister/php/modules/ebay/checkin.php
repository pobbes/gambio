<?php
/**
 * 888888ba                 dP  .88888.                    dP                
 * 88    `8b                88 d8'   `88                   88                
 * 88aaaa8P' .d8888b. .d888b88 88        .d8888b. .d8888b. 88  .dP  .d8888b. 
 * 88   `8b. 88ooood8 88'  `88 88   YP88 88ooood8 88'  `"" 88888"   88'  `88 
 * 88     88 88.  ... 88.  .88 Y8.   .88 88.  ... 88.  ... 88  `8b. 88.  .88 
 * dP     dP `88888P' `88888P8  `88888'  `88888P' `88888P' dP   `YP `88888P' 
 *
 *                          m a g n a l i s t e r
 *                                      boost your Online-Shop
 *
 * -----------------------------------------------------------------------------
 * $Id: checkin.php 1 2011-01-05 00:25:01Z MaW $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/CheckinManager.php');
require_once(DIR_MAGNALISTER_MODULES.'ebay/classes/CheckinCategoryView.php');
require_once(DIR_MAGNALISTER_MODULES.'ebay/classes/eBaySummaryView.php');
require_once(DIR_MAGNALISTER_MODULES.'ebay/classes/eBayCheckinSubmit.php');


$cm = new CheckinManager(array(
        'summaryView'   => 'eBaySummaryView',
	'checkinView'   => 'eBayCheckinCategoryView',
	'checkinSubmit' => 'eBayCheckinSubmit'),
	array(
	'marketplace' => 'ebay')
);

echo $cm->mainRoutine();
