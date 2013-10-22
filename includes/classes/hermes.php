<?php

/* --------------------------------------------------------------
   hermes.php 2012 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account.php 1124 2005-07-28 08:50:04Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

class Hermes {
	const ENDPOINTURL_SANDBOX = 'https://sandboxapi.hlg.de/Hermes_API_Web/1_3/services/ProPS';
	//const ENDPOINTURL = 'https://hermesapi2.hlg.de/Hermes_API_Web/services/1_0/ProPS';
	const ENDPOINTURL = 'https://hermesapi2.hlg.de/Hermes_API_Web/1_3/services/ProPS';
	const WSDLFILE = 'ProPS.wsdl';
	const WSDLFILE_SANDBOX = 'ProPS-sandbox.wsdl';
	const API_NAMESPACE = 'http://props.hermes_api.service.hlg.de';
	const PARTNERTOKEN_LIFETIME = 7200; // 120 minutes
	const USERTOKEN_LIFETIME = 15552000; // 180 days
	
	/**
	 * directory containing local copies of shipping labels
	 * cannot be 'const' b/c PHP doesn't allow use of define()'d consts in values for class consts
	 */
	protected static $_DIR_LABELS;
	
	protected $partnerID;
	protected $partnerPwd;
	protected $partnerToken;
	protected $username;
	protected $password;
	protected $userToken;
	
	protected $labelpos;
	protected $service; // PriPS/ProPS
	
	protected $soapClient;
	protected $endpoint;
	protected $soap_params;
	protected $wsdlfile;
	
	protected $_prips_lop; // cache for PriPS List Of Products
	
	protected $_debug = false;
	protected $_sandboxmode = false;
	protected $_logger;
	
	public function __construct() {
		$this->_logger = new FileLog('hermes', true);
		self::$_DIR_LABELS = DIR_FS_CATALOG .'/admin/images/hermes_labels';
		$this->getConfig();
	}
	
	protected function _log($message) {
		$ts = date('YmdHis');
		$this->_logger->write($ts.' '.$message."\n");
	}
	
	protected function getConfig() {
		$cfgquery = xtc_db_query("SELECT configuration_key, configuration_value FROM configuration WHERE configuration_key LIKE 'MODULE_SHIPPING_HERMESPROPS_%'");
		$cfg = array();
		while($row = xtc_db_fetch_array($cfgquery)) {
			$key = $row['configuration_key'];
			$value = $row['configuration_value'];
			$cfg[$key] = $value;
		}
		/*
		$this->partnerID = $cfg['MODULE_SHIPPING_HERMESPROPS_PARTNERID'];
		$this->partnerPwd = $cfg['MODULE_SHIPPING_HERMESPROPS_APIPASSWORD'];
		 */
		$this->partnerID = 'EXT000147';
		$this->partnerPwd = '90213787c3365489134b17f911332563';
		/*
		$this->username = $cfg['MODULE_SHIPPING_HERMESPROPS_USERNAME'];
		$this->password = $cfg['MODULE_SHIPPING_HERMESPROPS_PASSWORD'];
		 */
		$this->username = gm_get_conf('HERMES_PROPS_USERNAME');
		$this->password = gm_get_conf('HERMES_PROPS_PASSWORD');
		$this->_sandboxmode = gm_get_conf('HERMES_PROPS_SANDBOXMODE') == true;
		//$this->labelpos = $cfg['MODULE_SHIPPING_HERMESPROPS_LABELPOS'];
		//$this->service = $cfg['MODULE_SHIPPING_HERMESPROPS_SERVICE'];
		$this->service = 'ProPS';
		//if($cfg['MODULE_SHIPPING_HERMESPROPS_MODE'] == 'True') {
		if($this->_sandboxmode) {
			$this->endpoint = self::ENDPOINTURL_SANDBOX;
			$this->wsdlfile = dirname(__FILE__).'/'.self::WSDLFILE_SANDBOX;
			$this->soap_params = array(
				'trace' => true,
				'exceptions' => true,
				'cache_wsdl' => WSDL_CACHE_NONE,
				'user_agent' => 'Gambio GX2',
			);
		}
		else {
			$this->endpoint = self::ENDPOINTURL;
			$this->wsdlfile = dirname(__FILE__).'/'.self::WSDLFILE;
			$this->soap_params = array(
				'trace' => true,
				'exceptions' => true,
				'cache_wsdl' => WSDL_CACHE_MEMORY,
				'user_agent' => 'Gambio GX2',
			);
		}
		$this->soap_params['encoding'] = 'iso-8859-1';
		$this->soap_params['soap_version'] = SOAP_1_1;
		$this->soap_params['features'] = SOAP_USE_XSI_ARRAY_TYPE|SOAP_SINGLE_ELEMENT_ARRAYS;
	}
	
	public function setUsername($username) {
		gm_set_conf('HERMES_PROPS_USERNAME', $username);
		$this->username = $username;
	}
	
	public function getUsername() {
		return $this->username;
	}

	public function setPassword($password) {
		gm_set_conf('HERMES_PROPS_PASSWORD', $password);
		$this->password = $password;
	}
	
	public function getPassword() {
		return $this->password;
	}
	
	public function setSandboxmode($sbmode) {
		if($sbmode == true) {
			gm_set_conf('HERMES_PROPS_SANDBOXMODE', 1);
		}
		else {
			gm_set_conf('HERMES_PROPS_SANDBOXMODE', 0);
		}
		$this->_sandboxmode = $sbmode == true;
	}
	
	public function getSandboxmode() {
		return $this->_sandboxmode;
	}
	
	public function setOrdersStatusAfterSave($os_id) {
		gm_set_conf('HERMES_PROPS_OSAFTERSAVE', $os_id);
	}
	
	public function getOrdersStatusAfterSave() {
		return gm_get_conf('HERMES_PROPS_OSAFTERSAVE');
	}
	
	public function setOrdersStatusAfterLabel($os_id) {
		gm_set_conf('HERMES_PROPS_OSAFTERLABEL', $os_id);
	}
	
	public function getOrdersStatusAfterLabel() {
		return gm_get_conf('HERMES_PROPS_OSAFTERLABEL');
	}


	public function getService() {
		if(strtoupper($this->service) == 'PROPS') {
			return 'ProPS';
		}
		else {
			return 'PriPS';
		}
	}
	
	public function getPripsShipper() {
		$shipper = array(
			'configuration_id' => false,
			'shipperType' => 'COMMERCIAL',
			'firstname' => 'Vorname',
			'lastname' => 'Nachname',
			'addressAdd' => 'Adresszusatz',
			'street' => 'Straße',
			'houseNumber' => '42',
			'postcode' => '12345',
			'city' => 'Stadt',
			'district' => 'Stadtteil',
			'countryCode' => 'DEU',
			'telephonePrefix' => '+49123',
			'telephoneNumber' => '123123123',
			'email' => 'max@example.com',
			'referenceAuctionNumber' => '',
		);
		$query = "SELECT * FROM configuration WHERE configuration_key = 'MODULE_SHIPPING_HERMESPROPS_SHIPPER'";
		$result = xtc_db_query($query);
		if(xtc_db_num_rows($result) > 0) {
			$row = xtc_db_fetch_array($result);
			$sdata = unserialize($row['configuration_value']);
			$shipper = array_merge($shipper, $sdata);
			$shipper['configuration_id'] = $row['configuration_id'];
		}
		return $shipper;
	}
	
	public function setPripsShipper(array $newshipper) {
		$shipper = $this->getPripsShipper();
		if(!isset($shipper['configuration_id']) || $shipper['configuration_id'] === false) {
			$cfg_id = false;
		}
		else {
			$cfg_id = $shipper['configuration_id'];
		}
		unset($shipper['configuration_id']);
		$shipper = array_merge($shipper, $newshipper);
		$data = mysql_real_escape_string(serialize($shipper));

		if(!is_numeric($cfg_id)) {
			$query = "INSERT INTO configuration (configuration_key, configuration_value, configuration_group_id, last_modified, date_added)
					VALUES ('MODULE_SHIPPING_HERMESPROPS_SHIPPER', '". $data ."', 6, now(), now())";
		}
		else {
			$query = "UPDATE configuration SET configuration_value='".$data."', last_modified=now() WHERE configuration_id='".$cfg_id."'";
		}
		//die($query);
		xtc_db_query($query);			
	}
	
	public function getSoapClient() {
		if(!($this->soapClient instanceof SoapClient)) {
			try {
				$this->soapClient = new SoapClient($this->wsdlfile, $this->soap_params);
				$header_partner_id = new SoapHeader(self::API_NAMESPACE, 'PartnerId', $this->partnerID);
				$header_partner_pwd = new SoapHeader(self::API_NAMESPACE, 'PartnerPwd', $this->partnerPwd);
				$headers = array($header_partner_id, $header_partner_pwd);
				$this->soapClient->__setSoapHeaders($headers);
				$loginarguments = array(
					'login' => array(
						'benutzername' => $this->username,
						'kennwort' => $this->password,
					)
				);
				$user_login_response = $this->soapClient->propsUserLogin($loginarguments);
				
				// extract partner token from header (trace mode is required for this to work!)
				$soap_response = $this->soapClient->__getLastResponse();
				$this->_log("UserLogin Response:\n".	$soap_response);
				/*
				$this->partnerToken = preg_replace('_.*?PartnerToken.*?>(.*?)<.*_s', '$1', $soap_response);
				$this->_log("PartnerToken: ". $this->partnerToken);
				$headers[] = new SoapHeader(self::API_NAMESPACE, 'PartnerToken', $this->partnerToken);
				*/
				$this->userToken = trim($user_login_response->propsUserLoginReturn);
				$this->_log("User Token: ". $this->userToken);
				$headers[] = new SoapHeader(self::API_NAMESPACE, 'UserToken', $this->userToken);
				$this->soapClient = new SoapClient($this->wsdlfile, $this->soap_params);
				if(!$this->soapClient->__setSoapHeaders($headers)) {
					die('setting SOAP headers failed!');
				}
			}
			catch(SoapFault $sf) {
				if($this->_debug) {
					$soap_responseheaders = $this->soapClient->__getLastResponseHeaders();
					$soap_response = $this->soapClient->__getLastResponse();
					$soap_requestheaders = $this->soapClient->__getLastRequestHeaders();
					$soap_request = $this->soapClient->__getLastRequest();
					$log = "SoapFault in getSoapClient:\n";
					$log .= "ResponseHeaders:\n\n";
					$log .= $soap_responseheaders;
					$log .= "\n\nResponse:\n\n";
					$log .= formatXmlString($soap_response);
					$log .= "\n\nRequestHeaders:\n\n";
					$log .= $soap_requestheaders;
					$log .= "\n\nRequest:\n\n";
					$log .= formatXmlString($soap_request);
					$log .= "\n\nSoapFault:\n\n";
					$log .= print_r($sf, true) ."\n";
					$this->_logger->write($log);
				}
				$errorCode = $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorCode;
				$errorMessage = $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage;
				$this->_logger->write("FEHLER: $errorCode - $errorMessage\n");
				return false;
				//die("\n\nSOAP Exception at ". $this->endpoint);
				//die($sf);
			}
		}
		return $this->soapClient;
	}
	
	public function getPackageClasses() {
		$classes = array(
			'XS' => array(
				'size' => 0,
				'name' => 'XS',
				'desc' => 'a+b = max. 30 cm',
				'bulkoption' => true,
			),
			'S' => array(
				'size' => 1,
				'name' => 'S',
				'desc' => 'a+b = max. 50 cm',
				'bulkoption' => true,
			),
			'M' => array(
				'size' => 2,
				'name' => 'M',
				'desc' => 'a+b = max. 80 cm',
				'bulkoption' => true,
			),
			'L' => array(
				'size' => 3,
				'name' => 'L',
				'desc' => 'a+b = max. 120 cm',
				'bulkoption' => true,
			),
			'XL' => array(
				'size' => 4,
				'name' => 'XL',
				'desc' => 'a+b = max. 150 cm',
				'bulkoption' => false,
			),
			/* // NB: XXL is not allowed anymore
			'XXL' => array(
				'size' => 5,
				'name' => 'XXL',
				'desc' => 'a+b = max. 310 cm, c = max. 50 cm',
				'bulkoption' => false,
			),
			 */
		);
		return $classes;
	}
	
	public function getMinimumPackageClass() {
		return 'XS';
	}
	
	public static function getCountries() {
		return array('BEL', 'DNK', 'DEU', 'EST', 'FIN', 'FRA', 'IRL', 'ITA', 'LVA', 'LIE', 'LTU', 'LUX', 'MCO',
			'NLD', 'POL', 'AUT', 'PRT', 'SWE', 'CHE', 'SVK', 'SVN', 'ESP', 'CZE', 'HUN', 'GBR');
	}
	
	public function getProductOptions($products_id) {
		$hermes_query = xtc_db_query("SELECT * FROM products_hermesoptions WHERE products_id = ". (int)$products_id);
		if(xtc_db_num_rows($hermes_query) == 1) {
			$hermes_options = xtc_db_fetch_array($hermes_query);
		}
		else {
			$hermes_options = false;
		}
		return $hermes_options;
	}
	
	public function setProductsOptions($data) {
		if(!isset($data['products_id'])) {
			die('poot.');
		}
		$hermes_data = $this->getProductOptions($data['products_id']);
		if($hermes_data === false) {
			xtc_db_perform('products_hermesoptions', $data);
		}
		else {
			xtc_db_query("UPDATE products_hermesoptions SET min_pclass = '".$data['min_pclass']."' WHERE products_id = ". (int)$hermes_data['products_id']);
		}
	}
	
	/* ----------------------------------------------------------- */
	
	public function checkAvailability() {
		try {
			$time_start = microtime(true);
			$sc = $this->getSoapClient();
			if($sc === false) {
				return false;
			}
			$result = $sc->propsCheckAvailability();
			if(!empty($result->propsCheckAvailabilityReturn)) {
				return true;
			}
			else {
				return false;
			}
		}
		catch(SoapFault $sf) {
			if(false && $this->_debug) {
				$this->_log("CheckAvailability: SOAP Fault:\n". print_r($sf, true));
			}
			else {
				$this->_log("CheckAvailability: SOAP Fault:\n". $sf->getMessage());
			}
			return false;
		}		
	}
	
	public function getInfo() {
		try {
			$sc = $this->getSoapClient();
			$result = $sc->propsListOfProductsATG();
			if(isset($result->propsListOfProductsATGReturn)) {
				return $result->propsListOfProductsATGReturn;
			}
			else {
				return false;
			}
		}
		catch(SoapFault $sf) {
			return false;
		}
	}
	
	public function orderSave(HermesOrder $order) {
		if($order->isTemporary()) {
			$order->saveToDb();
		}
		$propsorder = $order->getPropsOrder();
		$sc = $this->getSoapClient();
		try {
			$response = $sc->propsOrderSave(array('propsOrder' => $propsorder));
			$new_orderno = $response->propsOrderSaveReturn;
			if($order->isTemporary()) {
				$order->deleteFromDb();
			}
			$order->orderno = $new_orderno;
			$order->state = 'sent';
			$order->saveToDb();
			if($this->_debug) { print_r($response); }
		}
		catch(Exception $e) {
			header('Content-Type: text/plain');
			var_dump($e);
			die('SOAP FAULT');

			$saveresult = array(
				'code' => $e->detail->ServiceException->exceptionItems->ExceptionItem->errorCode,
				'message' => $e->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage,
			);
			return $saveresult;
		}
		return true;
	}
	
	public function orderCancel(HermesOrder $order) {
		if($order->state != 'not_sent') {
			$sc = $this->getSoapClient();
			try {
				$response = $sc->propsOrderDelete(array('orderNo' => $order->orderno));
				$deleted = $response->propsOrderDeleteReturn;
			}
			catch(SoapFault $e) {
				$cancelresult = array(
					'code' => $e->detail->ServiceException->exceptionItems->ExceptionItem->errorCode,
					'message' => $e->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage,
				);
				//die(print_r($cancelresult, true));
				return $cancelresult;
			}
		}
		else {
			// locally saved order, OK to delete
			$deleted = true;
		}
		if($deleted) {
			$order->deleteFromDb();
		}
		return true;
	}

	public function makeLabelFileName($order, $printpos) {
		if(!($order instanceof HermesOrder) && is_numeric($order)) {
			$order = new HermesOrder($order);
		}
		$labelfile = self::$_DIR_LABELS .'/'. $order->orderno .'_'. $printpos .'.pdf';
		return $labelfile;
	}

	public function makeLabelsFileName() {
		$labelfile = self::$_DIR_LABELS .'/batchlabels.pdf';
		return $labelfile;
	}

	
	public function orderPrintLabel(HermesOrder $order, $printpos = 1, $forcefetch = false) {
		//$labelfile = self::$_DIR_LABELS .'/'. $order->orderno .'_'. $printpos .'.pdf';
		$labelfile = $this->makeLabelFileName($order, $printpos);
		if(!is_file($labelfile) || $forcefetch == true) {
			$sc = $this->getSoapClient();
			try {
				/*
				$response = $sc->propsOrderPrintLabelPdf(array('orderNo' => $order->orderno, 'printPosition' => $this->labelpos));
				$pdfreturn = $response->propsOrderPrintLabelPdfResponse->propsOrderPrintLabelPdfReturn;
				$pdfb64 = $pdfreturn->pdfData;
				*/
				$pdfdata = $this->getLabelPdf($order->orderno, $printpos);
				if(!empty($pdfdata)) {
					file_put_contents($labelfile, $pdfdata);
					$orderdata = $this->getOrder($order->orderno);
					if($orderdata !== false) {
						$order->shipping_id = $orderdata->shippingId;
					}
					$order->state = 'printed';
					$order->saveToDb();
				}
			}
			catch(Exception $e) {
				die($e);
			}
		}
	}
	
	public function getLabelPdf($orderno, $printpos = 1) {
		$sc = $this->getSoapClient();
		try {
			$oplp = $sc->propsOrderPrintLabelPdf(array('orderNo' => $orderno, 'printPosition' => $printpos));
		}
		catch(SoapFault $sf) {
			echo "soapFault!\n";
			var_dump($sf);
			echo "\n\n";
		}
		
		return $oplp->propsOrderPrintLabelPdfReturn->pdfData;
	}
	
	public function getLabelsPdf($ordernumbers) {
		$sc = $this->getSoapClient();
		try {
			$oplp = $sc->propsOrdersPrintLabelsPdf(array('requestedOrderNumbers' => array('orderNumbers' => $ordernumbers)));
			$pdfdata = $oplp->propsOrdersPrintLabelsPdfReturn->pdfData;
			$orderRes = $oplp->propsOrdersPrintLabelsPdfReturn->orderRes;
			return array(
				'pdfdata' => $pdfdata,
				'orderres' => $orderRes,
			);
		}
		catch(SoapFault $sf) {
			echo "soapFault!\n";
			var_dump($sf);
			echo "\n\n";
		}
		return false;
	}
	
	public function getLabelUrl($orderno) {
		if(!defined('DIR_WS_ADMIN')) {
			return false;
		}
		if($orderno instanceof HermesOrder) {
			$orderno = $orderno->orderno;
		}
		$url = HTTP_SERVER . DIR_WS_ADMIN .'/images/hermes_labels';
		$filename = $orderno.'.pdf';
		if(is_file(self::$_DIR_LABELS .'/'.$filename)) {
			return $url .'/'. $filename;
		}
		else {
			return false;
		}
	}
	
	public function getLabelsUrl() {
		$url = HTTP_SERVER . DIR_WS_ADMIN .'/images/hermes_labels/batchlabels.pdf';
		return $url;
	}
	
	public function getPropsOrders($search_criteria = array()) {
		$search_criteria_default = array(
			'orderNo' => null,
			'identNo' => null,
			'from' => null,
			'to' => null,
			'lastname' => null,
			'city' => null,
			'postcode' => null,
			'countryCode' => null,
			'clientReferenceNumber' => null,
			'ebayNumber' => null,
			'status' => null,
		);
		$search_criteria = array_merge($search_criteria_default, $search_criteria);
		$sc = $this->getSoapClient();
		try {
			$gpo = $sc->propsGetPropsOrders(array('searchCriteria' => $search_criteria));
			$orders = $gpo->propsGetPropsOrdersReturn->orders->PropsOrderShort; // array of stdClass
			if($orders === null) {
				$orders = array();
			}
		}
		catch(SoapFault $sf) {
			//var_dump($sf);
			//die('SOAP FAULT');
			return array(
				'code' => $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorCode,
				'message' => $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage
			);
		}
		return $orders;
	}
	
	public function getShipmentStatus($shipping_id) {
		$sc = $this->getSoapClient();
		try {
			// get ProPS status
			$shipstatus = $sc->propsReadShipmentStatus(array('shippingId' => $shipping_id));
			$status = array(
				'text' => $shipstatus->propsReadShipmentStatusReturn->statusText,
				//'text' => '<pre>'.print_r($shipstatus, true).'</pre>',
				'datetime' => $shipstatus->propsReadShipmentStatusReturn->statusDateTime,
			);
		}
		catch(Exception $e) {
			$status = array(
				'text' => 'Status kann nicht ermittelt werden',
				'datetime' => date('Y-m-d H:i:s'),
			);
		}
		return $status;
	}
	
	public function getOrder($orderno = false, $shipping_id = false) {
		if($orderno === false && $shipping_id === false) {
			die('invalid call of getOrder');
		}
		$sc = $this->getSoapClient();
		try {
			$orderreturn = $sc->propsGetPropsOrder(array('orderNo' => $orderno, 'shippingId' => $shipping_id));
		}
		catch(SoapFault $sf) {
			return false;
		}
		return $orderreturn->propsGetPropsOrderReturn;
	}
	
	public function addPropsCollectionRequest($datetime, $packets) {
		$collection_order = array(
			'collectionDate' => $datetime,
		);
		foreach($packets as $pclass => $number) {
			$collection_order['numberOfParcelsClass_'.$pclass] = $number;
		}
		$collection_order['numberOfParcelsClass_XLwithBulkGoods'] = 0;
		$sc = $this->getSoapClient();
		try {
			$collreqreturn = $sc->propsCollectionRequest(array('collectionOrder' => $collection_order));
		}
		catch(SoapFault $sf) {
			header('Content-Type: text/plain');
			var_dump($sf);
			die('SOAP FAULT');
			return array(
				'code' => $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorCode,
				'message' => $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage
			);
		}
		return $collreqreturn->propsCollectionRequestReturn;
	}
	
	public function collectionCancel($datetime) {
		$sc = $this->getSoapClient();
		try {
			$cancelreturn = $sc->propsCollectionCancel(array('collectionDate' => $datetime));
		}
		catch(SoapFault $sf) {
			return array(
				'code' => $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorCode,
				'message' => $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage
			);
		}
		return true;
	}
	
	public function getCollectionOrders() {
		$sc = $this->getSoapClient();
		try {
			$cordersreturn = $sc->propsGetCollectionOrders(array('collectionDateFrom' => null, 'collectionDateTo' => null, 'onlyMoreThan2ccm' => false));
			$corders = $cordersreturn->propsGetCollectionOrdersReturn->orders->PropsCollectionOrderLong;
			return $corders;
		}
		catch(SoapFault $sf) {
			/*
			header('Content-Type: text/plain');
			var_dump($sf);
			die('SOAP FAULT');
			 */
			if(isset($sf->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage)) {
				return $sf->detail->ServiceException->exceptionItems->ExceptionItem->errorMessage;
			}
			else {
				return false;
			}
		}
	}
	
	/*****
	 * PriPS
	 *****/
	
	public function sendPripsOrder(HermesOrder $order) {
		// STUB CODE
		//$order->state = 'printed';
		$order->shipping_id = 'sid_'.uniqid();
		$order->saveToDb();
		$orderreturn = new StdClass();
		return $orderreturn;
	}
	
	public function getLabelAcceptanceLiabilityLimit() {
		// PriPS List of Products contains required data
		$prips_lop = $this->getPripsListOfProductsExDeu();
		return $prips_lop->labelAcceptanceLiabilityLimit;
	}
	
	public function getLabelAcceptanceTermsAndConditions() {
		// PriPS List of Products contains required data
		$prips_lop = $this->getPripsListOfProductsExDeu();
		return $prips_lop->labelAcceptanceTermsAndConditions;
	}
	
	public function getUrlTermsAndConditions() {
		$prips_lop = $this->getPripsListOfProductsExDeu();
		return $prips_lop->urlTermsAndConditions;
	}
	
	public function getPripsListOfProductsExDeu() {
		// STUB CODE
		if($this->_prips_lop == null) {
			$lop = new StdClass();
			$lop->products = array();
			$lop->labelAcceptanceLiabilityLimit = 'Label Liability Limit';
			$lop->labelAcceptanceTermsAndConditions = 'Label Terms And Conditions';
			$lop->urlTermsAndConditions = 'http://www.google.com/';
			$this->_prips_lop = $lop;
		}
		return $this->_prips_lop;
	}

}


/*********************************/

class HermesOrder {
	public $orderno;
	public $order_type;
	public $orders_id;
	public $receiver_firstname;
	public $receiver_lastname;
	public $receiver_street;
	public $receiver_housenumber;
	public $receiver_addressadd;
	public $receiver_postcode;
	public $receiver_city;
	public $receiver_district;
	public $receiver_countrycode;
	public $receiver_email;
	public $receiver_telephonenumber;
	public $receiver_telephoneprefix;
	public $clientreferencenumber;
	public $parcelclass;
	protected $_parcelclasses;
	public $amountcashondeliveryeurocent;
	protected $state;
	public $shipping_id;
	public $paket_shop_id;
	public $hand_over_mode;
	public $collection_desired_date;
	
	const TEMP_PREFIX = 'tmpid_';
	
	public function __construct($orderno = false) {
		$this->orderno = uniqid(self::TEMP_PREFIX);
		$this->order_type = 'props';
		$this->receiver_firstname = 'test';
		$this->receiver_housenumber = '';
		$this->receiver_countrycode = 'DEU';
		$this->parcelclass = '';
		$this->setState('not_sent');
		if($orderno !== false) {
			$this->getFromDb($orderno);
		}
	}
	
	public function __set($name, $value) {
		$methodname = 'set'.ucfirst($name);
		if(method_exists($this, $methodname)) {
			$this->$methodname($value);
		}
		else {
			if(property_exists(get_class(), $name)) {
				$this->$name = $value;
			}
		}
	}
	
	public function __get($name) {
		$methodname = 'get'.ucfirst($name);
		if(method_exists($this, $methodname)) {
			return $this->$methodname();
		}
		else {
			return null;
		}
	}
	
	public static function getKeys() {
		return array('orderno', 'order_type', 'orders_id', 'receiver_firstname', 'receiver_lastname', 'receiver_street', 'receiver_housenumber',
			'receiver_addressadd', 'receiver_postcode', 'receiver_city', 'receiver_district', 'receiver_countrycode', 'receiver_email',
			'receiver_telephonenumber', 'receiver_telephoneprefix', 'clientreferencenumber', 'parcelclass', 'amountcashondeliveryeurocent',
			'state', 'shipping_id', 'paket_shop_id', 'hand_over_mode', 'collection_desired_date');
	}
	
	public static function getValidStates() {
		$valid_states = array('not_sent', 'sent', 'printed');
		return $valid_states;
	}
	
	public function isTemporary() {
		return (strpos($this->orderno, self::TEMP_PREFIX) !== false);
	}
	
	public function getState() {
		return $this->state;
	}
	
	public function setState($new_state) {
		$valid_states = self::getValidStates();
		if(in_array($new_state, $valid_states)) {
			$this->state = $new_state;
		}
		else {
			throw new Exception('Invalid state for HermesOrder');
		}
	}
	
	public function setAmountcashondeliveryeurocent($amount) {
		// $amount is in Euros, convert to cents
		$this->amountcashondeliveryeurocent = round($amount * 100);
	}
	
	public function getParcelclasses($class) {
		if(isset($this->_parcelclasses[$class])) {
			return $this->_parcelclasses[$class];
		}
		else {
			return ''; // false;
		}
	}
	
	public function setParcelclasses($class, $number) {
		$this->_parcelclasses[$class] = $number;
	}
	
	public static function getStateName($state, $lang = 'de') {
		$statenames = array(
			'de' => array(
				'not_sent' => 'nicht übertragen',
				'sent' => 'übertragen',
				'printed' => 'Paketschein erzeugt',
			),
			'en' => array(
				'not_sent' => 'not transmitted',
				'sent' => 'transmitted',
				'printed' => 'label created',
			)
		);
		return $statenames[$lang][$state];
	}
	
	public function isMutable() {
		return $this->state != 'printed';
	}
	
	public function fillFromOrder($orders_id) {
		$query = "SELECT `customers_email_address`, `customers_telephone`, `delivery_name` , `delivery_firstname` , `delivery_lastname` , `delivery_company` , `delivery_street_address` ,
			`delivery_suburb` , `delivery_city` , `delivery_postcode` , `delivery_state` , `delivery_country` , `delivery_country_iso_code_2` , c.countries_iso_code_3,
			payment_method, ot.value
			FROM `orders` , countries c, orders_total ot
			WHERE orders.delivery_country_iso_code_2 = c.countries_iso_code_2 AND orders.orders_id = ". (int)$orders_id ."
			AND ot.orders_id = orders.orders_id AND ot.class = 'ot_total'";
		$result = xtc_db_query($query);
		if(xtc_db_num_rows($result) > 0) {
			$row = xtc_db_fetch_array($result);
			$this->orders_id = (int)$orders_id;
			$this->clientreferencenumber = $orders_id;
			$this->receiver_firstname = $row['delivery_firstname'];
			$this->receiver_lastname = $row['delivery_lastname'];
			$this->receiver_addressadd = $row['delivery_company'];
			$this->receiver_street = $row['delivery_street_address'];
			$this->receiver_district = $row['delivery_suburb'];
			$this->receiver_postcode = $row['delivery_postcode'];
			$this->receiver_city = $row['delivery_city'];
			$this->receiver_countrycode = $row['countries_iso_code_3'];
			$this->receiver_email = $row['customers_email_address'];
			$this->receiver_telephonenumber = $row['customers_telephone'];
			if($row['payment_method'] == 'cod') {
				$this->amountcashondeliveryeurocent = floor(round($row['value'] * 100));
			}
			
			$pclasses = array('XS', 'S', 'M', 'L', 'XL'); // , 'XXL'
			$fpclasses = array_flip($pclasses);
			$min_pclass = 'XS';
			$pclass_query = xtc_db_query("SELECT min_pclass FROM products_hermesoptions ph, orders_products op
				WHERE op.products_id = ph.products_id AND op.orders_id = ".$orders_id);
			while($pcrow = xtc_db_fetch_array($pclass_query)) {
				if($fpclasses[$pcrow['min_pclass']] > $fpclasses[$min_pclass]) {
					$min_pclass = $pcrow['min_pclass'];
				}
			}
			$this->parcelclass = $min_pclass;
			return true;
		}
		else {
			return false;
		}
	}
	
	public function fillFromArray(array $input) {
		foreach(self::getKeys() as $key) {
			if(isset($input[$key])) {
				$methodname = 'set'.ucfirst($key);
				if(method_exists($this, $methodname)) {
					$this->$methodname($input[$key]);
				}
				else {
					$this->$key = $input[$key];
				}
			}
		}
		if(isset($input['parcelclasses']) && is_array($input['parcelclasses'])) {
			$this->_parcelclasses = $input['parcelclasses'];
		}
	}
	
	public function getPropsOrder() {
		$propsorder = array(
			'orderNo' => $this->orderno,
			'receiver' => array(
				'firstname' => $this->receiver_firstname,
				'lastname' => $this->receiver_lastname,
				'street' => $this->receiver_street,
				'houseNumber' => $this->receiver_housenumber,
				'addressAdd' => $this->receiver_addressadd,
				'postcode' => $this->receiver_postcode,
				'city' => $this->receiver_city,
				'district' => $this->receiver_district,
				'countryCode' => $this->receiver_countrycode,
				'email' => $this->receiver_email,
				'telephoneNumber' => $this->receiver_telephonenumber,
			),
			'clientReferenceNumber' => $this->clientreferencenumber,
			'parcelClass' => $this->parcelclass,
			'withBulkGoods' => false,
		);
		
		if($this->amountcashondeliveryeurocent > 0) {
			$propsorder['amountCashOnDeliveryEurocent'] = $this->amountcashondeliveryeurocent;
			$propsorder['includeCashOnDelivery'] = true;
		}
		else {
			$propsorder['includeCashOnDelivery'] = false;
		}
		
		if($this->state == 'not_sent') {
			// orderNo in db is only temporary, not an official Hermes orderNo
			$propsorder['orderNo'] = '';
		}
		
		return $propsorder;
	}

	protected function getFromDb($orderno) {
		$query = xtc_db_query("SELECT * FROM orders_hermes WHERE orderno = '". xtc_db_input($orderno) ."'");
		if(xtc_db_num_rows($query) == 1) {
			$row = xtc_db_fetch_array($query);
			foreach($row as $key => $value) {
				$this->$key = $value;
			}
			if(!in_array($this->parcelclass, array_keys(Hermes::getPackageClasses()))) {
				// PriPS data
				$this->_parcelclasses = unserialize($this->parcelclass);
				$this->parcelclass = '';
			}
		}
		else {
			throw new Exception("Order not found: ". $orderno);
		}
	}
	
	public function saveToDb() {
		$dbdata = array();
		foreach(self::getKeys() as $key) {
			$dbdata[$key] = $this->$key;
		}
		if(!empty($this->_parcelclasses)) {
			$dbdata['parcelclass'] = serialize($this->_parcelclasses);
		}
		$query = "REPLACE INTO orders_hermes SET ";
		$queryparts = array();
		foreach($dbdata as $col => $value) {
			$queryparts[] = "`".$col."` = '". mysql_real_escape_string($value) ."'";
		}
		$query .= implode(',', $queryparts);
		//die($query);
		return xtc_db_query($query);
	}
	
	public function deleteFromDb() {
		xtc_db_query("DELETE FROM orders_hermes WHERE orderno = '". xtc_db_input($this->orderno) ."'");
		$this->orderno = uniqid();
	}
	
	public static function getOrders($orders_id) {
		$query = xtc_db_query("SELECT orderno FROM orders_hermes WHERE orders_id = ". (int)$orders_id ." ORDER BY orderno DESC");
		$orders = array();
		while($row = xtc_db_fetch_array($query)) {
			$orders[] = new HermesOrder($row['orderno']);
		}
		return $orders;
	}
}



/* ======================================================== */
/* ================ FOR DEBUGGING ONLY ==================== */
/* ======================================================== */

function formatXmlString($xml) {  
  
  // add marker linefeeds to aid the pretty-tokeniser (adds a linefeed between all tag-end boundaries)
  $xml = preg_replace('/(>)(<)(\/*)/', "$1\n$2$3", $xml);
  
  // now indent the tags
  $token      = strtok($xml, "\n");
  $result     = ''; // holds formatted version as it is built
  $pad        = 0; // initial indent
  $matches    = array(); // returns from preg_matches()
  
  // scan each line and adjust indent based on opening/closing tags
  while ($token !== false) : 
  
    // test for the various tag states
    
    // 1. open and closing tags on same line - no change
    if (preg_match('/.+<\/\w[^>]*>$/', $token, $matches)) : 
      $indent=0;
    // 2. closing tag - outdent now
    elseif (preg_match('/^<\/\w/', $token, $matches)) :
      $pad--;
    // 3. opening tag - don't pad this one, only subsequent tags
    elseif (preg_match('/^<\w[^>]*[^\/]>.*$/', $token, $matches)) :
      $indent=1;
    // 4. no indentation needed
    else :
      $indent = 0; 
    endif;
    
    // pad the line with the required number of leading spaces
    $line    = str_pad($token, strlen($token)+$pad, ' ', STR_PAD_LEFT);
    $result .= $line . "\n"; // add to the cumulative result, with linefeed
    $token   = strtok("\n"); // get the next token
    $pad    += $indent; // update the pad size for subsequent lines    
  endwhile; 
  
  return $result;
}
