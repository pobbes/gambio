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
 * $Id$
 *
 * (c) 2010 - 2011 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

abstract class MagnaCompatibleCronBase {
	protected $mpID = 0;
	protected $marketplace = '';
	protected $marketplaceTitle = '';
	protected $language = '';
	
	protected $config = array(); 
	
	public function __construct($mpID, $marketplace) {
		global $_magnaLanguage, $_modules;

		$this->mpID = $mpID;
		$this->marketplace = $marketplace;
		$this->marketplaceTitle = $_modules[$marketplace]['title'];
		
		$this->language = $_magnaLanguage;
		
		$this->initConfig();
	}
	
	abstract protected function getConfigKeys();
	
	protected function initConfig() {
		$ckeys = $this->getConfigKeys();
		foreach ($ckeys as $k => $o) {
			if (is_array($o['key'])) {
				$o['key'][0] = $this->marketplace.'.'.$o['key'][0];
			} else {
				$o['key'] = $this->marketplace.'.'.$o['key'];
			}
			$this->config[$k] = getDBConfigValue($o['key'], $this->mpID, isset($o['default']) ? $o['default'] : null);
		}
	}
	
	abstract public function process();
}
