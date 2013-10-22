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
 * $Id: checkin.php 1174 2011-07-30 17:49:04Z derpapst $
 *
 * (c) 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

class MagnaCompatibleCheckin extends MagnaCompatibleBase {

	public function process() {
		require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/CheckinManager.php');
		
		$cCatView = $this->loadResource('checkin', 'CheckinCategoryView');
		$cSumView = $this->loadResource('checkin', 'SummaryView');
		$cSubmitView = $this->loadResource('checkin', 'CheckinSubmit');
		
		if (($cCatView === false) || ($cSumView === false) || ($cSubmitView === false)) {
			if ($this->isAjax) {
				echo '{error: \'This is not supported\'}';
			} else {
				echo 'This is not supported';
			}
			return;
		}

		$cm = new CheckinManager(
			array(
				'summaryView'   => $cSumView,
				'checkinView'   => $cCatView,
				'checkinSubmit' => $cSubmitView
			), array(
				'marketplace' => $this->marketplace,
				'hasPurge' => true,
			)
		);
		echo $cm->mainRoutine();
	}
	
}

