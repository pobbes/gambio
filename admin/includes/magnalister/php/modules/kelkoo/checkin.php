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
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/ComparisonShoppingSummaryView.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/ComparisonShopping/ComparisonShoppingCategoryView.php');
require_once(DIR_MAGNALISTER_MODULES.'kelkoo/classes/KelkooCheckinSubmit.php');
require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/CheckinManager.php');

class PreissuchmaschineSummaryView extends ComparisonShoppingSummaryView {
	protected function getAdditionalProductNameStuff($prod) {
		return '
			<a class="right gfxbutton magnifier" target="_blank" '.
			  'href="http://www.kelkoo.de/ctl/do/search?siteSearchQuery='.urlencode($prod['products_name']).'" '.
			  'title="'.ML_KELKOO_SAME_PRODUCT_THERE.'"></a>';
	}
}

$cm = new CheckinManager(
	array(
		'summaryView'   => 'PreissuchmaschineSummaryView',
		'checkinView'   => 'ComparisonShoppingCategoryView',
		'checkinSubmit' => 'KelkooCheckinSubmit'
	), array(
		'marketplace' => $_Marketplace
	)
);

echo $cm->mainRoutine();