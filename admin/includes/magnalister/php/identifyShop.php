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
 * $Id: identifyShop.php 792 2011-02-24 11:57:50Z derpapst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

function identShopSystem() {
	$content = file_get_contents('includes/application_top.php', 0, null, -1, 1500);
	if (stripos($content, 'gambio') !== false) {
		define('SHOPSYSTEM', 'gambio');
	} else if (stripos($content, 'xt-commerce') !== false) {
		if (stripos(PROJECT_VERSION, 'xtcModified') !== false) {
			define('SHOPSYSTEM', 'xtcmodified');
		} else {
			define('SHOPSYSTEM', 'xtcommerce');
		}
	} else if (stripos($content, 'oscommerce') !== false) {
		define('SHOPSYSTEM', 'oscommerce');
	} else if (stripos(PROJECT_VERSION, 'deLuxe') !== false) {
		define('SHOPSYSTEM', 'xonsoft');
	} else {
		/* Shop unbekannt, aber mindestens ein osC fork */
		define('SHOPSYSTEM', 'oscommerce');
	}
}

identShopSystem();
