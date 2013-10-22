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
 * $Id: SimplePrice.php 1340 2011-10-31 10:04:25Z derppst $
 *
 * (c) 2010 RedGecko GmbH -- http://www.redgecko.de
 *     Released under the GNU General Public License v2 or later
 * -----------------------------------------------------------------------------
 */

class SimplePrice {
	private $price = 0.0;
	private $actualCurr = '';
	private $currencies = array();
	
	private $isSpecialPrice = false;
	private $isGroupPrice   = false;
	
	private $addedTax = 0;

	public function __construct($price = null, $actualCurr = null) {
		$currencies_query = MagnaDB::gi()->query('SELECT * FROM '.TABLE_CURRENCIES);
		while ($currency = MagnaDB::gi()->fetchNext($currencies_query)) {
			$this->currencies[$currency['code']] = array (
				'title' => $currency['title'],
				'symbol_left' => fixHTMLUTF8Entities($currency['symbol_left']),
				'symbol_right' => fixHTMLUTF8Entities($currency['symbol_right']),
				'decimal_point' => $currency['decimal_point'],
				'thousands_point' => $currency['thousands_point'],
				'decimal_places' => (int)$currency['decimal_places'],
				'value' => (float)$currency['value']
			);
		}
		if ($actualCurr != null) {
			$this->setCurrency($actualCurr);
			if ($price != null) {
				$this->setPrice((float)$price);
			}
		}
	}

	private function triggerError($msg) {
		if (MAGNA_DEBUG) {
			echo print_m(prepareErrorBacktrace(2));
		}
		trigger_error($msg);
		return null;
	}

	public function currencyExists($cur) {
		return array_key_exists($cur, $this->currencies);
	}

	public function setCurrency($actualCurr) {
		if (empty($actualCurr)) {
			return $this;
		}
		if (!$this->currencyExists($actualCurr)) {
			return $this->triggerError(__METHOD__.': This currency ('.$actualCurr.') is not yet available in your shop.');
		}
		$this->actualCurr = $actualCurr;
		return $this;
	}

	public function setPrice($price) {
		if ($this->actualCurr == null) {
			return $this->triggerError(__METHOD__.': Please set the currency first.');
		}
		$this->isSpecialPrice = false;
		$this->isGroupPrice   = false;

		$this->price = (float)$price;
		return $this;
	}

	public function setPriceAndCurrency($price, $actualCurr) {
		$this->isSpecialPrice = false;
		$this->isGroupPrice   = false;

		$this->setCurrency($actualCurr);
		$this->setPrice((float)$price);
		return $this;
	}

	public function getCurrency() {
		return $this->actualCurr;
	}

	public function getGroupPrice($groupID, $productID) {
		if (!MagnaDB::gi()->tableExists(TABLE_PERSONAL_OFFERS_BY.$groupID)) {
			return 0.0;
		}
		return (float)MagnaDB::gi()->fetchOne('
		    SELECT personal_offer FROM '.TABLE_PERSONAL_OFFERS_BY.$groupID.' 
		     WHERE products_id = \''.$productID.'\' 
		           AND quantity=1
		  ORDER BY price_id
		     LIMIT 1
		');
	}

	public function getSpecialOffer($pID) {
		return (float)MagnaDB::gi()->fetchOne('
		    SELECT specials_new_products_price 
		      FROM '.TABLE_SPECIALS.'
		     WHERE products_id=\''.$pID.'\'
		           AND status=1
		');
	}

	public function setPriceFromDB($pID, $mpID, $extra = '') {
		if ($this->actualCurr == null) {
			$this->setCurrency(getCurrencyFromMarketplace($mpID));
		}
		$this->isSpecialPrice = false;
		$this->isGroupPrice   = false;

		$mp = magnaGetMarketplaceByID($mpID);
		# extra name extensions like 'chinese' or 'fixed' for eBay
		if (!empty($extra)) {
			$extra = '.'.trim($extra, '.');
		}
		if (getDBConfigValue(array($mp.$extra.'.price.usespecialoffer', 'val'), $mpID, false)
		    && (($price = $this->getSpecialOffer($pID)) > 0)
		) {
			$this->price = $price;
			$this->isSpecialPrice = true;
			return $this;
		}

		if (((int)getDBConfigValue($mp.$extra.'.price.group', $mpID, 0) > 0)
		    && (($price = $this->getGroupPrice((int)getDBConfigValue($mp.$extra.'.price.group', $mpID, 0), $pID)) > 0)
		) {
			$this->price = $price;
			$this->isGroupPrice = true;
			return $this;
		}

		$this->price = (float)MagnaDB::gi()->fetchOne('
		    SELECT products_price 
		      FROM '.TABLE_PRODUCTS.'
		     WHERE products_id=\''.$pID.'\'
		');
		return $this;
	}

	public function finalizePrice($pID, $mpID, $extra = '') {
		$mp = magnaGetMarketplaceByID($mpID);
		if (!empty($extra)) {
			$extra = '.'.trim($extra, '.');
		}
		$this->addTaxByPID($pID)->calculateCurr();
		if (getDBConfigValue($mp.$extra.'.price.addkind', $mpID) == 'percent') {
			$this->addTax((float)getDBConfigValue($mp.$extra.'.price.factor', $mpID));
		} else if (getDBConfigValue($mp.$extra.'.price.addkind', $mpID) == 'addition') {
			$this->addLump((float)getDBConfigValue($mp.$extra.'.price.factor', $mpID));
		} else if (getDBConfigValue($mp.$extra.'.price.addkind', $mpID) == 'constant') {
			$this->price = (float)getDBConfigValue($mp.$extra.'.price.factor', $mpID);
		}
		$this->roundPrice()->makeSignalPrice(getDBConfigValue($mp.$extra.'.price.signal', $mpID, ''));
		return $this;
	}

	public function setFinalPriceFromDB($pID, $mpID, $extra = '') {
		$this->setPriceFromDB($pID, $mpID, $extra)->finalizePrice($pID, $mpID, $extra);
		return $this;
	}

	public function isSpecialPrice() {
		return $this->isSpecialPrice;
	}

	public function isGroupPrice() {
		return $this->isGroupPrice;
	}

	public function addTax($tax) {
		$this->addedTax = (float)$tax;
		if ($this->addedTax == 0.0) {
			return $this;
		}
		$this->price = $this->price + $this->price / 100 * $tax;
		return $this;
	}

	public function getTaxValue($tax) {
		return $this->price / 100 * $tax;
	}

	public function removeTax($tax = false) {
		if ($tax === false) {
			$tax = $this->addedTax;
		}
		$this->addedTax = 0.0;
		if ($tax == 0.0) {
			return $this;
		}
		$this->price = ($this->price / (($tax + 100) / 100));
		return $this;
	}

	public static function getTaxByClassID($taxClassID, $countryID = -1) {
		if ($countryID == -1) {
			# Fallback to shop default
			$countryID = (int)MagnaDB::gi()->fetchOne('
				SELECT configuration_value FROM '.TABLE_CONFIGURATION.'
				 WHERE configuration_key=\'STORE_COUNTRY\'
			');
		}
		$taxRate = MagnaDB::gi()->fetchOne(eecho('
			SELECT MAX(tax_rate)
			  FROM '.TABLE_TAX_RATES.' tr, '.TABLE_ZONES_TO_GEO_ZONES.' zgz 
			 WHERE tr.tax_class_id=\''.$taxClassID.'\'
			       AND tr.tax_zone_id=zgz.geo_zone_id
			       AND zgz.zone_country_id=\''.$countryID.'\'
			 LIMIT 1
		', false));
		//echo var_dump_pre($taxRate);
		if (($taxRate === false) || ($taxRate === null)) {
			// Fallback for shops with broken zgz <--> tr tables
			$taxRate = MagnaDB::gi()->fetchOne(eecho('
				SELECT MAX(tax_rate)
				  FROM '.TABLE_TAX_RATES.' tr
				 WHERE tr.tax_class_id=\''.$taxClassID.'\'
				 LIMIT 1
			', false));
		}
		return (float)$taxRate;
	}

	public function addTaxByTaxID($taxClassID) {
		return $this->addTax(
			self::getTaxByClassID($taxClassID)
		);
	}

	public function removeTaxByTaxID($taxClassID) {
		return $this->removeTax(
			self::getTaxByClassID($taxClassID)
		);
	}

	public static function getTaxByPID($pID) {
		$taxClassID = MagnaDB::gi()->fetchOne('
			SELECT products_tax_class_id
			  FROM '.TABLE_PRODUCTS.' p
			 WHERE products_id=\''.$pID.'\'
			 LIMIT 1
		');
		if (($taxClassID === false) || ($taxClassID === null)) {
			return 0;
		}
		return self::getTaxByClassID($taxClassID);
	}

	public function addTaxByPID($pID) {
		return $this->addTax(
			self::getTaxByPID($pID)
		);
	}

	public function removeTaxByPID($pID) {
		return $this->removeTax(
			self::getTaxByPID($pID)
		);
	}

	public function addLump($add) {
		$this->price += (float)$add;
		return $this;
	}
	
	public function subLump($sub) {
		$this->price += (float)$sub;
		return $this;
	}

	public function addAttributeSurcharge($aID) {
		if ((int)$aID <= 0) {
			return $this;
		}
		$attr = MagnaDB::gi()->fetchRow('
			SELECT options_values_price AS price,
			       price_prefix AS prefix
			  FROM '.TABLE_PRODUCTS_ATTRIBUTES.'
			 WHERE products_attributes_id=\''.$aID.'\'
		');
		if (!is_array($attr)) return $this;
		
		$tmpTax = $this->addedTax;
		$this->removeTax();

		if ($attr['prefix'] == '+') {
			$this->addLump($attr['price']);
		} else {
			$this->subLump($attr['price']);
		}

		$this->addTax($tmpTax);
		
		return $this;
	}

	/**
	 * Geht immer von DEFAULT_CURRENCY mit Umrechnungsfaktor == 1.0 aus
	 */
	public function calculateCurr() {
		$this->price = $this->currencies[$this->actualCurr]['value'] * $this->price;
		return $this;
	}

	/**
	 * Geht immer von DEFAULT_CURRENCY mit Umrechnungsfaktor == 1.0 aus
	 */	
	public function updateCurrency($val) {
		if (empty($this->actualCurr)) {
			return $this->triggerError(__METHOD__.': Please set the currency first.');
		}
		$val = (float)$val;
		if ($val <= 0) {
			return $this;
		}

		MagnaDB::gi()->update(TABLE_CURRENCIES, array(
			'value' => $val,
		), array (
			'code' => $this->actualCurr
		));
		$this->currencies[$this->actualCurr]['value'] = $val;
		return $this;
	}
	
	public function updateCurrencyByService(&$success = false) {
		if (empty($this->actualCurr)) {
			return $this->triggerError(__METHOD__.': Please set the currency first.');
		}
		if ($this->actualCurr == DEFAULT_CURRENCY) {
			$success = true;
			return $this;
		}
		try {
			$result = MagnaConnector::gi()->submitRequest(array(
				'ACTION' => 'GetExchangeRate',
				'SUBSYSTEM' => 'Core',
				'FROM' => strtoupper(DEFAULT_CURRENCY),
				'TO' => strtoupper($this->getCurrency()),
			));
			if ($result['EXCHANGERATE'] > 0) {
				$this->updateCurrency($result['EXCHANGERATE']);
			}
		} catch (MagnaException $e) { 
			$success = false;
			return $this;
		}
		$success = true;
		return $this;
	}
	
	public function getCurrencyValue() {
		if (empty($this->actualCurr)) {
			return $this->triggerError(__METHOD__.': Please set the currency first.');
		}
		return $this->currencies[$this->actualCurr]['value'];
	}
	

	public function roundPrice() {
		$this->price = round($this->price, $this->currencies[$this->actualCurr]['decimal_places']);
		return $this;
	}

	public function makeSignalPrice($decimalDigits) {
		if (empty($decimalDigits) || !ctype_digit($decimalDigits)) {
			return $this;
		}
		$this->price = floor($this->price) + (int)$decimalDigits/100;
		return $this;
	}

	public function getPrice() {
		return $this->price;
	}

	public function format($default = false) {
		return trim(
			$this->currencies[$default ? DEFAULT_CURRENCY : $this->actualCurr]['symbol_left'].
			' '.$this->formatWOCurrency($default).' '.
			$this->currencies[$default ? DEFAULT_CURRENCY : $this->actualCurr]['symbol_right']
		);
	}

	public function formatWOCurrency($default = false) {
		$format = $this->getFormatOptions($default);
		return trim(number_format($this->price, $format[0], $format[1], $format[2]));
	}

	public function getFormatOptions($default = false) {
		return array (
			$this->currencies[$default ? DEFAULT_CURRENCY : $this->actualCurr]['decimal_places'],
			$this->currencies[$default ? DEFAULT_CURRENCY : $this->actualCurr]['decimal_point'],
			$this->currencies[$default ? DEFAULT_CURRENCY : $this->actualCurr]['thousands_point']
		);
	}
}
