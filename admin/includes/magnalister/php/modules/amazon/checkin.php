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
 * $Id: checkin.php 1131 2011-07-06 21:25:39Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/CheckinManager.php');
require_once(DIR_MAGNALISTER_MODULES.'amazon/classes/CheckinCategoryView.php');
require_once(DIR_MAGNALISTER_MODULES.'amazon/classes/AmazonSummaryView.php');
require_once(DIR_MAGNALISTER_MODULES.'amazon/classes/AmazonCheckinSubmit.php');


$cm = new CheckinManager(array(
	'summaryView' => 'AmazonSummaryView',
	'checkinView' => 'AmazonCheckinCategoryView',
	'checkinSubmit' => 'AmazonCheckinSubmit'
));
try {
	$result = MagnaConnector::gi()->submitRequest(array(
		'ACTION' => 'GetPublicDir',
		'SUBSYSTEM' => 'Amazon',
	));
	$cm->extendTopFormHtml('
		<a class="button" target="_blank" title="'.ML_LABEL_HISTORY.'" href="'.$result['DATA'].'">'.ML_LABEL_HISTORY.'</a>
	');	
} catch (MagnaException $e) { }

echo $cm->mainRoutine();