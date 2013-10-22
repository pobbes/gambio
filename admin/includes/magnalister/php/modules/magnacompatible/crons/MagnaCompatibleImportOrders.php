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

require_once(DIR_MAGNALISTER_MODULES.'magnacompatible/crons/MagnaCompatibleCronBase.php');

abstract class MagnaCompatibleImportOrders extends MagnaCompatibleCronBase {
	protected $hasNext = true;
	protected $offset = array();
	protected $beginImportDate = false;
	
	protected $db = null;
	protected $dbCharSet = '';
	
	protected $simplePrice = null;
	
	/* specific to one order only */
	protected $cur = array();
	protected $o = array(); /* the current order */
	protected $p = array(); /* the current product */
	protected $taxValues = array(); /* tax values for the current order */
	protected $mailOrderSummary = array();
	protected $comment = '';
	
	/* specific to all orders */
	protected $syncBatch = array(); /* sync batch for other marketplaces */
	protected $allCurrencies = array(); /* list of different currencies */
	
	/* For acknowledging */
	protected $processedOrders = array ();
	protected $lastOrderDate = false;
	
	protected $verbose = false;
	
	public function __construct($mpID, $marketplace) {
		parent::__construct($mpID, $marketplace);

		$this->initImport();
	}
	
	protected function initImport() {
		if (isset($_GET['MLDEBUG']) && ($_GET['MLDEBUG'] == 'true')) {
			require_once(DIR_MAGNALISTER_INCLUDES . 'lib/MagnaTestDB.php');
			$this->db = MagnaTestDB::gi();
		} else {
			$this->db = MagnaDB::gi();
		}

		$this->dbCharSet = MagnaDB::gi()->mysqlVariableValue('character_set_client');
		$this->verbose = (
				(MAGNA_CALLBACK_MODE == 'STANDALONE') 
				|| (defined('MAGNALISTER_PLUGIN') && (MAGNALISTER_PLUGIN == true))
			) && (get_class($this->db) == 'MagnaTestDB');
		
		require_once(DIR_MAGNALISTER_INCLUDES.'lib/classes/SimplePrice.php');
		$this->simplePrice = new SimplePrice();
	}
	
	protected function getConfigKeys() {
		return array (
			'UpdateExchangeRate' => array (
				'key' => array('exchangerate', 'update'),
				'default' => false,
			),
			'LastImport' => array (
				'key' => 'orderimport.lastrun',
				'default' => 0,
			),
			'FirstImportDate' => array (
				'key' => 'preimport.start',
				'default' => '1970-01-01',
			),
			'CustomerGroup' => array (
				'key' => 'CustomerGroup',
				'default' => 1
			),
			'MwStFallback' => array (
				'key' => 'mwst.fallback',
				'default' => 0
			),
			'MwStShipping' => array (
				'key' => 'mwst.shipping',
				'default' => 0
			),
			'StockSync.FromMarketplace' => array (
				'key' => 'stocksync.frommarketplace',
				'default' => 'no'
			),
			'MailSend' => array (
				'key' => 'mail.send',
				'default' => 'false',
			),
			'ShippingMethod' => array (
				'key' => 'orderimport.shippingmethod',
				'default' => 'textfield',
			),
			'ShippingMethodName' => array (
				'key' => 'orderimport.shippingmethod.name',
				'default' => 'marketplace',
			),
			'PaymentMethod' => array (
				'key' => 'orderimport.paymentmethod',
				'default' => 'textfield',
			),
			'PaymentMethodName' => array (
				'key' => 'orderimport.paymentmethod.name',
				'default' => 'marketplace',
			),
		);
	}
	
	protected function initConfig() {
		$this->config['CIDAssignment'] = getDBConfigValue('customers_cid.assignment', '0', 'none');

		parent::initConfig();
		#echo print_m($this->config);
		if ($this->config['ShippingMethod'] == 'textfield') {
			$this->config['ShippingMethod'] = trim($this->config['ShippingMethodName']);
		}
		if (empty($this->config['ShippingMethod'])) {
			$k = $this->getConfigKeys();
			$this->config['ShippingMethod'] = $k['ShippingMethodName']['default'];
		}
		if ($this->config['PaymentMethod'] == 'textfield') {
			$this->config['PaymentMethod'] = trim($this->config['PaymentMethodName']);
		}
		if (empty($this->config['PaymentMethod'])) {
			$k = $this->getConfigKeys();
			$this->config['PaymentMethod'] = $k['PaymentMethodName']['default'];
		}
		#echo var_dump_pre($this->config['PaymentMethod'], 'PaymentMethod');
		#echo var_dump_pre($this->config['ShippingMethod'], 'ShippingMethod');
	}

	/**
	 * How many hours, days, weeks or whatever we go back in time to request older orders?
	 * @return time in seconds
	 */ 
	protected function getPastTimeOffset() {
		return 60 * 60 * 24 * 7;
	}

	protected function getBeginDate() {
		if ($this->beginImportDate !== false) {
			return $this->beginImportDate;
		}
		$begin = strtotime($this->config['FirstImportDate']);
		if ($begin > time()) {
			if ($this->verbose) echo "Date in the future --> no import\n";
			return false;
		}

		$lastImport = $this->config['LastImport'];
		if (preg_match('
				/^([1-2][0-9]{3})-(0[1-9]|1[0-2])-(0[1-9]|[1-2][0-9]|3[0-1])\s'.
				'([0-1][0-9]|2[0-4]):([0-5][0-9]):([0-5][0-9])$/',
				$lastImport
		)) {
			# Since we only request non acknowledged orders, we go back in time by 7 days.
			$lastImport = strtotime($lastImport.' +0000') - $this->getPastTimeOffset();
		} else {
			$lastImport = 0;
		}
	
		if ( ($lastImport > 0) && ($begin < $lastImport) ) {
			$begin = $lastImport;
		}
		return $this->beginImportDate = gmdate('Y-m-d H:i:s', $begin);
	}

	protected function buildRequest() {
		if (empty($this->offset)) {
			$this->offset = array (
				'COUNT' => 200,
				'START' => 0,
			);
		}
		return array (
			'ACTION' => 'GetOrdersForDateRange',
			'SUBSYSTEM' => $this->marketplace,
			'MARKETPLACEID' => $this->mpID,
			'BEGIN' => $this->getBeginDate(),
			'OFFSET' => $this->offset,
		);
	}

	protected function getOrders() {
		if ($this->hasNext != true) {
			return false;
		}
		$request = $this->buildRequest();
		if ($this->verbose) {
			echo print_m($request, '$request');
		}
		if ($request['BEGIN'] === false) {
			if ($this->verbose) echo "No BEGIN Date has been set, so no import yet.\n";
			return false;
		}
		try {
			$res = MagnaConnector::gi()->submitRequest($request);
		} catch (MagnaException $e) {
			if ((MAGNA_CALLBACK_MODE == 'STANDALONE') || $this->verbose) {
				echo print_m($e->getErrorArray(), 'Error: '.$e->getMessage());
			}
			if (MAGNA_DEBUG && ($e->getMessage() == ML_INTERNAL_API_TIMEOUT)) {
				$e->setCriticalStatus(false);
			}
			return false;
		}
		if (!array_key_exists('DATA', $res) || empty($res['DATA'])) {
			if ($this->verbose) echo "No Data.\n";
			return false;
		}
		$this->hasNext = $res['HASNEXT'];
		$this->offset['START'] += $this->offset['COUNT'];
		
		$orders = $res['DATA'];
		$res['DATA'] = 'Cleaned';
		
		if ($this->verbose) echo print_m($res, '$res');

		if (!is_array($orders)) return false;

		# ggf. Zeichensatz korrigieren
		if ($this->dbCharSet != 'utf8') {
			arrayEntitiesToLatin1($orders);
		}

		return $orders;
	}
	
	protected function updateOrderCurrency($currency) {
		# Gibts die Waehrung auch im Shop?
		if (!$this->simplePrice->currencyExists($currency)) {
			if ($this->verbose) echo "Currency does not exist.\n";
			return false;
		}
		#if ($this->verbose) echo 'Set Currency to: ['.$currency."]\n";
		$this->simplePrice->setCurrency($currency);

		if (array_key_exists($currency, $this->allCurrencies)) {
			return true;
		}

		if ($this->config['UpdateExchangeRate']) {
			$this->simplePrice->updateCurrencyByService();
		}

		$currencyValue = $this->simplePrice->getCurrencyValue();
		if ((float)$currencyValue <= 0.0) {
			if ($this->verbose) echo "CurrencyValue <= 0.\n";
			return false;
		}
		$this->allCurrencies[$currency] = $currencyValue;
		return true;
	}
	
	protected function getCountryByISOCode($code) {
		$c = MagnaDB::gi()->fetchRow('
			SELECT countries_id as ID, countries_name AS Name
			  FROM '.TABLE_COUNTRIES.'
			 WHERE countries_iso_code_2=\''.$code.'\' 
			 LIMIT 1
		');
		if (!is_array($c)) {
			$c = array (
				'ID' => 0,
				'Name' => $code,
			);
		}
		return $c;
	}

	protected function getAddressFormatID($country) {
		$ret = (int)MagnaDB::gi()->fetchOne('
			SELECT address_format_id 
			  FROM '.TABLE_COUNTRIES.'
			 WHERE countries_id=\''.$country['ID'].'\'
		');
		if ($ret < 1) {
			return 1;
		}
		return $ret;
	}

	protected function getCustomer($email) {
		$fields = array('customers_id as ID');
		if (($this->config['CIDAssignment'] != 'none') &&
			MagnaDB::gi()->columnExistsInTable('customers_cid', TABLE_CUSTOMERS)	
		) {
			$fields[] = 'customers_cid as CID';
		}
		$c = MagnaDB::gi()->fetchRow('
		    SELECT '.implode(',', $fields).'
		      FROM '.TABLE_CUSTOMERS.' 
	 	     WHERE customers_email_address=\''.$email.'\' 
	 	     LIMIT 1
		');
		if (!is_array($c)) {
			return false;
		}
		return $c;	
	}

	protected function insertCustomer() {
		$customer = array();
		$customer['Password'] = randomString(10);
		$this->o['customer']['customers_password'] = md5($customer['Password']);
		
		if (SHOPSYSTEM != 'oscommerce') {
			$this->o['customer']['customers_status'] = $this->config['CustomerGroup'];
			$this->o['customer']['account_type'] = '0';
		}
		$this->db->insert(TABLE_CUSTOMERS, $this->o['customer']);
		$cupdate = array();
		
		# Kunden-ID herausfinden
		$customer['ID'] = $this->db->getLastInsertID();
		# customers_cid bestimmen
		if (MagnaDB::gi()->columnExistsInTable('customers_cid', TABLE_CUSTOMERS)) {
			switch ($this->config['CIDAssignment']) {
				case 'sequential': {
					$customer['CID'] = MagnaDB::gi()->fetchOne('
			  			SELECT MAX(CAST(IFNULL(customers_cid,0) AS SIGNED))+1
			  		      FROM '.TABLE_CUSTOMERS
			  		);
					break;
				}
				case 'customers_id': {
					$customer['CID'] = $customer['ID'];
					break;
				}
			}
			if (isset($customer['CID'])) {
				$cupdate['customers_cid'] = $customer['CID'];
			}
		}
		
		# Infodatensatz erzeugen
		$this->db->insert(TABLE_CUSTOMERS_INFO, array(
			'customers_info_id' => $customer['ID'],
			'customers_info_date_account_created' => gmdate('Y-m-d H:i:s')
		));
		// echo 'DELETE FROM '.TABLE_CUSTOMERS_INFO.' WHERE customers_info_id=\''.$customersId.'\';'."\n\n";

		# Adressbuchdatensatz ergaenzen.
		$country = magnaGetCountryFromISOCode($this->o['adress']['entry_country_id']);
		$this->o['adress']['customers_id'] = $customer['ID'];
		$this->o['adress']['entry_country_id'] = $this->cur['BuyerCountry']['ID'];

		$this->db->insert(TABLE_ADDRESS_BOOK, $this->o['adress']);

		# Adressbuchdatensatz-Id herausfinden.
		$abId = $this->db->getLastInsertID();
		// echo 'DELETE FROM '.TABLE_ADDRESS_BOOK.' WHERE customers_id=\''.$customersId.'\';'."\n\n";

		# Kundendatensatz updaten.
		$cupdate['customers_default_address_id'] = $abId;
		$this->db->update(TABLE_CUSTOMERS, $cupdate, array (
			'customers_id' => $customer['ID']
		));

		return $customer;
	}

	protected function processCustomer() {
		$customer = $this->getCustomer($this->o['customer']['customers_email_address']);
		if (!is_array($customer)) {
			return $this->insertCustomer($this->o);
		}
		switch ($this->o['orderInfo']['BuyerCountryISO']) {
			case 'AT':
			case 'DE': {
				$customer['Password'] = '(wie bekannt)';
				break;
			}
			default: {
				$customer['Password'] = '(as known)';
				break;
			}
		}
		return $customer;
	}

	/**
	 * Load some basic info, e.g. country etc from DB
	 */
	protected function prepareOrderInfo() {
		$this->cur['BuyerCountry'] = $this->getCountryByISOCode($this->o['orderInfo']['BuyerCountryISO']);
		$this->cur['ShippingCountry'] = $this->getCountryByISOCode($this->o['orderInfo']['ShippingCountryISO']); 
	}
	/**
	 * Returns the marketplace specific order ID from $this->o.
	 *
	 * @return	OrderID of the marketplace used in magnalister_orders.special (Database)
	 */
	protected abstract function getMarketplaceOrderID();

	protected function orderExists($orderInfo) {
		$mOID = $this->getMarketplaceOrderID();
		$oID = MagnaDB::gi()->fetchOne('
			SELECT orders_id
			  FROM '.TABLE_MAGNA_ORDERS.'
			 WHERE mpID=\''.$mpID.'\'
			       AND special=\''.MagnaDB::gi()->escape($mOID).'\'
		');
		if ($oID === false) {
			return false;
		}
		if ($this->verbose) echo 'orderExists('.$mOID.')'."\n";
		/* Ack again */
		$this->processedOrders[] = array (
			'MOrderID' => $mOID,
			'ShopOrderID' => $oID,
		);
		return true;
	}
	
	/**
	 * Returns the status that the order should have as string.
	 * Use $this->o['order'].
	 *
	 * @return String	The order status for the currently processed order.
	 */
	protected abstract function getOrdersStatus();
	
	/**
	 * Returns the comment for orders.comment (Database). 
	 * E.g. the comment from the customer or magnalister related information.
	 * Use $this->o['order'].
	 *
	 * @return String	The comment for the order.
	 */
	protected abstract function generateOrderComment();
	
	/**
	 * Returns the comment for orders_status.comment (Database). 
	 * E.g. the comment from the customer or magnalister related information.
	 * May differ from self::generateOrderComment()
	 * Use $this->o['order'].
	 *
	 * @return String	The comment for the order.
	 */
	protected abstract function generateOrdersStatusComment();
	
	/**
	 * In child classes this method can be used to extend the data for the DB-table
	 * orders before it is inserted.
	 * Use $this->o['order'].
	 */
	protected function doBeforeInsertOrder() {
		/* Do nothing here. */
	}

	/**
	 * In child classes this method can be used to extend the data for the DB-table
	 * magnalister_orders before it is inserted.
	 *
	 * @return Array	Associative array that will be stored serialized 
	 * 					in magnalister_orders.internaldata (Database)
	 */
	protected function doBeforeInsertMagnaOrder() {
		/* Do nothing here. */
		return array();
	}

	/**
	 * In child classes this method can be used to extend the data for the DB-table
	 * orders_history before it is inserted.
	 * Use $this->o['orderStatus']
	 */
	protected function doBeforeInsertOrderHistory() {
		/* Do nothing here. */
	}

	protected function insertOrder() {
		$this->comment = $this->o['order']['comments'];
		$this->o['order']['customers_id'] = $this->cur['customer']['ID'];

		$this->o['order']['customers_address_format_id'] = 
				$this->o['order']['billing_address_format_id'] = 
				magnaGetAddressFormatID($this->cur['BuyerCountry']['ID']);
		$this->o['order']['delivery_address_format_id'] = 
				$this->getAddressFormatID($this->cur['ShippingCountry']['ID']);

		$this->o['order']['orders_status'] = $this->getOrdersStatus();

		$this->o['order']['customers_country'] = $this->cur['BuyerCountry']['Name'];
		$this->o['order']['delivery_country'] = $this->cur['ShippingCountry']['Name'];
		$this->o['order']['billing_country'] = $this->cur['BuyerCountry']['Name'];

		if (SHOPSYSTEM != 'oscommerce') {
			if (isset($this->cur['customer']['CID'])) {
				$this->o['order']['customers_cid'] = $this->cur['customer']['CID'];
			}
			$this->o['order']['customers_status'] = $this->config['CustomerGroup'];
			$this->o['order']['language'] = $this->language;
			$this->o['order']['comments'] = $this->generateOrderComment();
		}

		/* Change Shipping and Payment Methods */
		$this->o['order']['payment_method'] = $this->config['PaymentMethod'];
		if (SHOPSYSTEM != 'oscommerce') {
			$this->o['order']['payment_class'] = $this->o['order']['payment_method'];
			$this->o['order']['shipping_class'] = $this->o['order']['shipping_method'] = $this->config['ShippingMethod'];		
		}

		$this->doBeforeInsertOrder();
		$this->db->insert(TABLE_ORDERS, $this->o['order']);

		# OrderId merken
		$this->cur['OrderID'] = $this->db->getLastInsertID();
		// echo 'DELETE FROM '.TABLE_ORDERS.' WHERE orders_id=\''.$this->cur['OrderID'].'\';'."\n\n";

		/* Bestellung in unserer Tabelle registrieren */
		$internalData = $this->doBeforeInsertMagnaOrder();
		$this->db->insert(TABLE_MAGNA_ORDERS, array(
			'mpID' => $this->mpID,
			'orders_id' => $this->cur['OrderID'],
			'orders_status' => $this->o['order']['orders_status'],
			'data' => serialize($this->o['magnaOrders']),
			'internaldata' => is_array($internalData) ? serialize($internalData) : '',
			'special' => $this->getMarketplaceOrderID(),
			'platform' => $this->marketplace
		));
		// echo 'DELETE FROM '.TABLE_MAGNA_ORDERS.' WHERE orders_id=\''.$this->cur['OrderID'].'\';'."\n\n";

		# Statuseintrag fuer Historie vornehmen.
		$this->o['orderStatus']['orders_id'] = $this->cur['OrderID'];
		$this->o['orderStatus']['orders_status_id'] = $this->o['order']['orders_status'];
		
		$this->o['orderStatus']['comments'] = $this->generateOrdersStatusComment();

		$this->doBeforeInsertOrderHistory();		
		$this->db->insert(TABLE_ORDERS_STATUS_HISTORY, $this->o['orderStatus']);
		// echo 'DELETE FROM '.TABLE_ORDERS_STATUS_HISTORY.' WHERE orders_id=\''.$this->cur['OrderID'].'\';'."\n\n";	
	}
	
	/**
	 * Converts whatever the API has submitted in $this->p['products_tax'] to a
	 * real tax value.
	 * Here it just returns the parameter. Child Clases however may override this
	 * mehtod and convert the parameter.
	 *
	 * @parameter mixed $tax	Something that represents a tax value
	 * @return float			The actual tax value
	 */
	protected function getTaxValue($tax) {
		return $tax;
	}

	/**
	 *
	 */
	protected function insertProduct() {
		$this->mailOrderSummary[] = array(
			'quantity' => $this->p['products_quantity'],
			'name' => $this->p['products_name'],
			'price' => $this->simplePrice->setPrice($this->p['products_price'])->format(),
			'finalprice' => $this->simplePrice->setPrice($this->p['final_price'])->format(),
		);
		if (array_key_exists($this->p['products_id'], $this->syncBatch)) {
			$this->syncBatch[$this->p['products_id']]['NewQuantity']['Value'] += (int)$this->p['products_quantity'];
		} else {
			$this->syncBatch[$this->p['products_id']] = array (
				'SKU' => $this->p['products_id'],
				'NewQuantity' => array (
					'Mode' => 'SUB',
					'Value' => (int)$this->p['products_quantity']
				),
			);
		}

		$this->p['orders_id'] = $this->cur['OrderID'];
		/* Attribute Values ermitteln aus der SKU, nicht aus dem Hauptprodukt.
		   Daher bevor products_id ermittelt wird. */
		$attrValues = magnaSKU2pOpt($this->p['products_id'], $this->o['orderInfo']['BuyerCountryISO']);
		$this->p['products_id'] = magnaSKU2pID($this->p['products_id']);

		$tax = false;
		if (isset($this->p['products_tax'])) {
			$tax = $this->getTaxValue($this->p['products_tax']);
		}

		if (!MagnaDB::gi()->recordExists(TABLE_PRODUCTS, array('products_id' => (int)$this->p['products_id']))) {
			$this->p['products_id'] = 0;
			if ($tax === false) {
				$tax = (float)$this->config['MwStFallback'];
			}
		} else {
			/* Lagerbestand reduzieren */
			if ($this->config['StockSync.FromMarketplace'] != 'no') {
				$this->db->query('
					UPDATE '.TABLE_PRODUCTS.'
					   SET products_quantity = products_quantity - '.(int)$this->p['products_quantity'].' 
					 WHERE products_id='.(int)$this->p['products_id'].'
				');
				/* Varianten-Bestand reduzieren, falls Produkt mit Varianten (gibt es bei osCommerce nicht) */
				if (!empty($attrValues['options_name'])
				    && (SHOPSYSTEM != 'oscommerce')
				) {
					$this->db->query('
						UPDATE '.TABLE_PRODUCTS_ATTRIBUTES.'
						   SET attributes_stock = attributes_stock - '.(int)$this->p['products_quantity'].'
						 WHERE products_id='.(int)$this->p['products_id'].' 
						       AND options_id='.(int)$attrValues['options_id'].' 
						       AND options_values_id='.(int)$attrValues['options_values_id'].'
					');
				}
			}
			/* Steuersatz und Model holen */
			$row = MagnaDB::gi()->fetchRow('
				SELECT products_tax_class_id, products_model 
				  FROM '.TABLE_PRODUCTS.' 
				 WHERE products_id=\''.(int)$this->p['products_id'].'\'
			');
			if ($row !== false) {
				$tax = SimplePrice::getTaxByClassID((int)$row['products_tax_class_id'], (int)$this->cur['BuyerCountry']['ID']);
				$this->p['products_model'] = $row['products_model'];
			} else {
				if ($tax === false) {
					$tax = (float)$this->config['MwStFallback'];
				}
			}
		}
		$this->p['products_tax'] = $tax;

		$priceWOTax = $this->simplePrice->setPrice($this->p['products_price'])->removeTax($tax)->getPrice();

		if (!isset($this->taxValues[$tax])) {
			$this->taxValues[$tax] = 0.0;
		}
		$this->taxValues[$tax] += $priceWOTax * (int)$this->p['products_quantity'];

		if (SHOPSYSTEM != 'oscommerce') {
			$this->p['allow_tax'] = 1;
		} else {
			$this->p['products_price'] = $priceWOTax;
			$this->p['final_price'] = $this->p['products_price'];
		}

		# Produktdatensatz in Tabelle "orders_products".					
		$this->db->insert(TABLE_ORDERS_PRODUCTS, $this->p);
		$ordersProductsId = $this->db->getLastInsertID();

		// orders_products_attributes:
		$prodOrderAttrData = array(
			'orders_id' => $this->p['orders_id'],
			'orders_products_id' => $ordersProductsId,
			'products_options' => $attrValues['options_name'],
			'products_options_values' => $attrValues['options_values_name'],
			'options_values_price' => 0.0,
			'price_prefix' => ''
		);
		if (!empty($attrValues['options_name'])) {
			$this->db->insert(TABLE_ORDERS_PRODUCTS_ATTRIBUTES, $prodOrderAttrData);
		}
	}

	protected function proccessShippingTax() {
		if (($this->config['MwStShipping'] <= 0) 
			|| !array_key_exists('Shipping', $this->o['orderTotal'])
		) {
			return;
		}

		if (!isset($this->taxValues[$this->config['MwStShipping']])) {
			$this->taxValues[$this->config['MwStShipping']] = 0.0;
		}
		$this->taxValues[$this->config['MwStShipping']] += $this->simplePrice->setPrice(
			$this->o['orderTotal']['Shipping']['value']
		)->removeTax($this->config['MwStShipping'])->getPrice();
		
	}
	
	protected function addTaxValuesToOrdersTotal() {
		if (empty($this->taxValues)) return;
		if (!defined('MODULE_ORDER_TOTAL_TAX_STATUS') || (MODULE_ORDER_TOTAL_TAX_STATUS != 'true')) {
			return;
		}
		$otc = 60;
		foreach ($this->taxValues as $tax => $value) {
			$this->o['orderTotal']['Tax'.$tax] = array (
				'title' => round($tax, 2).'% '.MAGNA_LABEL_ORDERS_TAX,
				'value' => $this->simplePrice->setPrice($value)->getTaxValue($tax),
				'class' => 'ot_tax',
				'sort_order' => $otc
			);
		}
	}

	/**
	 * This method prepares and inserts data for orders_total.
	 * Child-Classes may extend this method. However this method should be called
	 * at the end to do the actual inertion of data in the database.
	 * parent::insertOrdersTotal(); as last statement.
	 */
	protected function insertOrdersTotal() {
		#echo print_m($this->o['orderTotal']);
		foreach ($this->o['orderTotal'] as $key => &$entry) {
			$entry['orders_id'] = $this->cur['OrderID'];
			if (defined($entry['title'])) {
				$entry['title'] = constant($entry['title']);
			}
			$entry['text'] = $this->simplePrice->setPrice($entry['value'])->format();
			$this->db->insert(TABLE_ORDERS_TOTAL, $entry);
		}
		// echo 'DELETE FROM '.TABLE_ORDERS_TOTAL.' WHERE orders_id=\''.$this->cur['OrderID'].'\';'."\n\n";	
	}
	
	protected function sendPromoMail() {
		if ($this->config['MailSend'] != 'true') return;
		sendSaleConfirmationMail(
			$this->mpID,
			$this->o['customer']['customers_email_address'],
			array (
				'#FIRSTNAME#' => $this->o['customer']['customers_firstname'],
				'#LASTNAME#' => $this->o['customer']['customers_lastname'],
				'#EMAIL#' => $this->o['customer']['customers_email_address'],
				'#PASSWORD#'  => $this->cur['customer']['Password'],
				'#ORDERSUMMARY#' => $this->mailOrderSummary,
				'#MARKETPLACE#' => $this->marketplaceTitle,
				'#SHOPURL#' => HTTP_SERVER.DIR_WS_CATALOG,
			)
		);
	}

	protected function processSingleOrder() {
		//if ($this->verbose) echo print_m($this->o, 'order');
		if (!$this->updateOrderCurrency($this->o['order']['currency'])) {
			/* Currency is not available in this shop or 
			   the currency value can't be determined. */
			if ($this->verbose) echo '!updateOrderCurrency'."\n";
			return;
		}
		/* Reset order specific class atributes */
		$this->cur = array();
		$this->taxValues = array();
		$this->mailOrderSummary = array();
		
		/* Prepare order specific informations */
		$this->prepareOrderInfo();

		$this->cur['customer'] = $this->processCustomer();
		#echo print_m($this->cur['customer'], '$customer');
		
		if ($this->orderExists($this->o['orderInfo'])) {
			return;
		}
		$this->insertOrder();
		$this->processedOrders[] = array (
			'MOrderID' => $this->getMarketplaceOrderID(),
			'ShopOrderID' => $this->cur['OrderID'],
		);

		foreach ($this->o['products'] as $p) {
			$this->p = $p;
			$this->insertProduct();
		}
		//echo 'DELETE FROM '.TABLE_ORDERS_PRODUCTS.' WHERE orders_id=\''.$this->cur['OrderID'].'\';'."\n\n";
		
		$this->proccessShippingTax();
		
		$this->addTaxValuesToOrdersTotal();
		
		$this->insertOrdersTotal();
		
		$this->sendPromoMail();
		
		$this->lastOrderDate = $this->o['order']['date_purchased'];
	}
	
	protected function acknowledgeImportedOrders() {
		if (empty($this->processedOrders)) return;
		/* Acknowledge imported orders */
		$request = array(
			'ACTION' => 'AcknowledgeImportedOrders',
			'SUBSYSTEM' => $this->marketplace,
			'MARKETPLACEID' => $this->mpID,
			'DATA' => $this->processedOrders,
		);
		if (get_class($this->db) == 'MagnaTestDB') {
			if ($this->verbose) echo print_m($request);
			$this->processedOrders = array();
			return;
		}
		try {
			$res = MagnaConnector::gi()->submitRequest($request);
			$this->processedOrders = array();
		} catch (MagnaException $e) {
			if ((MAGNA_CALLBACK_MODE == 'STANDALONE') || $this->verbose) {
				echo print_m($e->getErrorArray(), 'Error: '.$e->getMessage(), true);
			}
			if ($e->getCode() == MagnaException::TIMEOUT) {
				$e->saveRequest();
				$e->setCriticalStatus(false);
			}
		}

	}

	final public function process() {
		while (($orders = $this->getOrders()) !== false) {
			#if ($this->verbose) echo print_m($orders, 'orders');
			foreach ($orders as $order) {
				$this->cur = array();
				$this->o = $order;
				$this->processSingleOrder();
			}
			$this->acknowledgeImportedOrders();
		}
		if ($this->lastOrderDate !== false) {

		}
	}

}
