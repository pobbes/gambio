<?php
/* --------------------------------------------------------------
   hermes_order.php 2011 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License
   --------------------------------------------------------------
*/
?><?php
/* --------------------------------------------------------------
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com
   (c) 2003	 nextcommerce ( start.php,v 1.6 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: credits.php 1263 2005-09-30 10:14:08Z mz $)


   Released under the GNU General Public License
   --------------------------------------------------------------*/

// ALTER TABLE `admin_access` ADD `hermes_order` INT( 1 ) NOT NULL DEFAULT '0'
// update admin_access set hermes_order = 1

require('includes/application_top.php');
require DIR_FS_CATALOG .'/includes/classes/hermes.php';
require DIR_FS_CATALOG .'/admin/includes/classes/order.php';
require DIR_FS_CATALOG .'/admin/includes/classes/messages.php';

function makeLink($options = null, $hrefmode = false) {
	global $orders_id, $orderno;
	$options = is_array($options) ? $options : array();
	$urloptions = array_merge(array('orders_id' => $orders_id, 'orderno' => $orderno), $options);
	$url = HTTP_SERVER.DIR_WS_ADMIN.basename(__FILE__).'?';
	$oparts = array();
	foreach($urloptions as $key => $value) {
		$oparts[] = $key.'='.$value;
	}
	$amp = $hrefmode ? '&amp;' : '&';
	$url .= implode($amp, $oparts);
	return $url;
}

function setOrdersStatus($orders_id, $orders_status_id, $orders_status_history_comment = '') {
	$orders_query = "UPDATE orders SET orders_status = :orders_status, last_modified = now() WHERE orders_id = :orders_id";
	$orders_query = strtr($orders_query, array(':orders_id' => $orders_id, ':orders_status' => $orders_status_id));
	xtc_db_query($orders_query);
	
	$orders_sh_query = "INSERT INTO orders_status_history (orders_id, orders_status_id, date_added, comments) ".
			"VALUES (:orders_id, :orders_status_id, now(), ':comments')";
	$orders_sh_query = strtr($orders_sh_query, array(':orders_id' => $orders_id, ':orders_status_id' => $orders_status_id,
			':comments' => xtc_db_input($orders_status_history_comment)));
	xtc_db_query($orders_sh_query);
}


$hermes = new Hermes();
$messages = new Messages('hermes_messages');

if(isset($_REQUEST['ajax']) && $_REQUEST['ajax'] == 'checkavailability') {
	ob_clean();
	if($hermes->checkAvailability() == true) {
		echo '<span class="available">Hermes Webservice ist verf&uuml;gbar</span>';
	}
	else {
		echo '<span class="unavailable">Hermes Webservice ist <strong>NICHT</strong> verf&uuml;gbar</span>';
	}
	exit;
}

if(isset($_POST['orderprintlabel'])) {
	$orders_id = $_POST['orders_id'];
	$orderno = $_POST['orderno'];
	$printpos = $_POST['printpos'];
	$order = new HermesOrder($orderno);
	$hermes->orderPrintLabel($order, $printpos);
	$labelfile = $hermes->makeLabelFileName($order, $printpos);
	header('Content-Type: application/pdf');
	header('Content-Disposition: attachment; filename='.basename($labelfile));
	readfile($labelfile);
	gm_set_conf('HERMES_LASTPRINTPOS', $printpos - 1);
	$os_afterlabel = $hermes->getOrdersStatusAfterLabel();
	if($os_afterlabel !== '-1') {
		setOrdersStatus($orders_id, $os_afterlabel, 'Hermes-Versandlabel abgerufen');
	}
	exit;
}

if(!isset($_GET['orders_id'])) {
	xtc_redirect(FILENAME_ORDERS);
}
$orders_id = (int)$_GET['orders_id'];
$gm_order = new order($orders_id);

if(empty($_GET['orderno']) || $_GET['orderno'] == 'new') {
	$orderno = false;
}
else {
	$orderno = $_GET['orderno'];
}


if(isset($_POST['ordersave'])) {
	$order = new HermesOrder();
	$order->fillFromArray($_POST);
	$saveresult = $hermes->orderSave($order);
	if($saveresult !== true) {
		$messages->addMessage('FEHLER: '. $saveresult['code'] .' '. $saveresult['message']);
	}
	$os_aftersave = $hermes->getOrdersStatusAfterSave();
	if($os_aftersave !== '-1') {
		setOrdersStatus($orders_id, $os_aftersave, 'Hermes-Versandauftrag gespeichert');
	}
	xtc_redirect(makeLink(array('orders_id' => $order->orders_id, 'orderno' => $order->orderno)));
	exit;
}

if(isset($_POST['ordercancel'])) {
	$order = new HermesOrder($_POST['orderno']);
	//$order->fillFromArray($_POST);
	$cancelresult = $hermes->orderCancel($order);
	if($cancelresult !== true) {
		$messages->addMessage($cancelresult['code'] .' '. $cancelresult['message']);
	}
	xtc_redirect(makeLink(array('orders_id' => $order->orders_id, 'orderno' => '', 'debug' => '1')));
	exit;
}

$shipper = $hermes->getPripsShipper();

if(isset($_POST['pripsprint'])) {
	$newshipper = array();
	foreach($_POST as $key => $value) {
		if(preg_match('/shipper_(.*)/', $key, $matches) == 1) {
			$newshipper[$matches[1]] = $value;
		}
	}
	//die(print_r($newshipper, true));
	$hermes->setPripsShipper($newshipper);

	$orderno = $_POST['orderno'];
	try {
		$order = new HermesOrder($orderno);
	}
	catch(Exception $e) {
		// not found, i.e. new
		$order = new HermesOrder();
	}
	$order->order_type = 'prips';
	$order->fillFromArray($_POST);
	$order->saveToDb();
	$hermes->sendPripsOrder($order);
	xtc_redirect(makeLink(array('orders_id' => $order->orders_id, 'orderno' => $order->orderno)));
	exit;
}

$hermesorders = HermesOrder::getOrders((int)$_GET['orders_id']);
if(count($hermesorders) == 1 && $orderno === false && !($_GET['orderno'] == 'new')) {
	xtc_redirect(makeLink(array('orderno' => $hermesorders[0]->orderno)));
	exit;
}

if($orderno !== false) {
	$order = new HermesOrder($orderno);
}
else {
	$order = new HermesOrder();
	if(is_numeric($orders_id)) {
		$order->fillFromOrder($orders_id);
	}
}

$barcode = (!empty($order->shipping_id)) ? $order->shipping_id : false;

$label_liabilitylimit = $hermes->getLabelAcceptanceLiabilityLimit();
$label_tac = $hermes->getLabelAcceptanceTermsAndConditions();
$url_tac = $hermes->getUrlTermsAndConditions();

$pclasses = $hermes->getPackageClasses();

$countries = Hermes::getCountries();
$scquery = xtc_db_query("SELECT * FROM countries WHERE countries_iso_code_3 IN ('". implode("','", $countries) ."')");
$shopcountries = array();
while($scrow = xtc_db_fetch_array($scquery)) {
	$shopcountries[$scrow['countries_iso_code_3']] = $scrow;
}

$romode = $order->isMutable() ? '' : 'readonly';

$printpos = gm_get_conf('HERMES_LASTPRINTPOS');
if(!is_numeric($printpos)) {
	$printpos = 0;
}
else {
	$printpos = ($printpos + 1) % 4;
}


/* ------- ProPSOrders -------- */

//$propsorders = $hermes->getPropsOrders();

/* messages */
$session_messages = $messages->getMessages();
$messages->reset();


?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
		<title><?php echo TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		<style>
		hr { clear: both; margin: 1em 0; }
		.hermesorder { font-family: sans-serif; font-size: 0.8em; }
		.hermesorder h1 { padding: 0; }
		.hermesorder h2 { font-size: 1em; }
		.hermesorder ul a:link { font: inherit; }
		.hermesorder a.current { font-style: italic; }
		.hermesorder form { display: block; overflow: auto; } 
		.hwfloat { float: left; width: 47%; margin: 1ex 2px; }
		.fright { float: right; margin: 0 2em; clear: right; }
		.cl { clear: left; }
		.prips #fsbuttons { margin-top: 1.7em; }
		span.neworder { margin: 0 1ex; padding: 0 1ex; background: #FFD6D9; border: 1px solid #D35B63; }
		dl.form { overflow: auto; }
		dl.form dt, dl.form dd { float: left; margin: 1px 0; }
		dl.form dt { clear: left; font-weight: bold; width: 10em; }
		dl.form dd { }
		fieldset { border: none; background: #dddddd; margin: 1em 0; }
		legend { background: #C7E8F8; padding: 1ex 1em; box-shadow: 0 0 2px #000000; }
		.hermesorder input.button { width: auto; display: inline; margin: 4px 2px; }
		.hermesorder input[readonly] { color: #555; border: none; background: #eee;}
		/* .hermesorder div.label { margin: 3em 1em 0; text-align: center; } */
		.hermesorder div.label a.button { display: inline; padding: 1em 2em; }
		.availability { float: right; width: 25em; border: 1px solid #888; background: #eee; padding: 0.5ex 0.5em; }
		p.message { background: #ffa; border: 1px solid #faa; padding: 1ex 1em; }
		.orderlabel * { vertical-align: middle; }
		.printpos { display: inline-block; margin-bottom: -4px; }
		.printpos input { vertical-align: middle; margin: 0; }
		.cb { clear: both; }
		.overlay { position: absolute; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); color: #fff; text-align: center; padding-top: 15em; font-family: sans-serif; }
		</style>
	</head>
	<body>
		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		<!-- header_eof //-->

		<!-- body //-->
		<table border="0" width="100%" cellspacing="2" cellpadding="2">
			<tr>
				<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
					<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">

						<!-- left_navigation //-->
						<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
						<!-- left_navigation_eof //-->

					</table>
				</td>

				<!-- body_text //-->
				<td class="boxCenter hermesorder <?php echo strtolower($hermes->getService()) ?>" width="100%" valign="top">
					<div class="availability">
						Verfügbarkeit der Schnittstelle wird überprüft &hellip;
					</div>
					<h1 class="pageHeading">Hermes-Versandauftragserfassung</h1>
					
					<?php foreach($session_messages as $msg): ?>
					<p class="message"><?php echo $msg ?></p>
					<?php endforeach ?>

					<p class="fright">
					<a class="button" href="<?php echo HTTP_SERVER.DIR_WS_ADMIN.'orders.php?action=edit&oID='.$orders_id ?>">zur Bestellung</a>
					</p>

					<?php if(!empty($hermesorders)): ?>
					<h2>Erfasste Sendungen zu dieser Bestellung:</h2>
					<?php if($orderno !== false): ?>
					<p class="fright">
					<a class="button" href="<?php echo xtc_href_link(basename(__FILE__), 'orders_id='.$orders_id.'&orderno=new') ?>">neuer Auftrag</a>
					</p>
					<?php endif ?>
					<ul>
						<?php foreach($hermesorders as $ho): ?>
						<li>
							<a href="<?php echo xtc_href_link(basename(__FILE__), 'orders_id='.$ho->orders_id.'&orderno='.$ho->orderno) ?>" class="<?php echo $orderno == $ho->orderno ? 'current' : '' ?>">
							<?php echo $ho->orderno ?> (<?php echo $ho->state ?>)
							</a>
						</li>
						<?php endforeach ?>
					</ul>
					<?php endif ?>
					
					
					<form action="<?php echo makeLink(array('orderno' => $order->orderno), true) ?>" method="post" class="cb">
						<input type="hidden" name="orders_id" value="<?php echo $order->orders_id ?>">
						<?php if($hermes->getService() == 'PriPS'): ?>
						<fieldset class="hwfloat" id="fsshipper">
							<legend>Absender</legend>
							<dl id="shipper" class="form">
								<dt><label for="shippertype">Absenderstatus:</label></dt>
								<dd>
									<?php if($order->isMutable()): ?>
									<select id="shippertype" name="shipper_shipperType">
										<option value="PRIVATE" <?php echo $shipper['shipperType'] == 'PRIVATE' ? 'selected' : '' ?>>Privatperson</option>
										<option value="COMMERCIAL" <?php echo $shipper['shipperType'] == 'COMMERCIAL' ? 'selected' : '' ?>>Unternehmer</option>
									</select>
									<?php else: ?>
									<?php echo $shipper['shipperType'] ?>
									<?php endif ?>
								</dd>
								<dt><label for="shipper_firstname">Vorname:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_firstname" id="shipper_firstname" value="<?php echo $shipper['firstname'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_lastname">Nachname:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_lastname" id="shipper_lastname" value="<?php echo $shipper['lastname'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_addressadd">Adresszusatz:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_addressAdd" id="shipper_addressadd" value="<?php echo $shipper['addressAdd'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_street">Straße:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_street" id="shipper_street" value="<?php echo $shipper['street'] ?>" size="27" maxlength="27"></dd>
								<dt><label for="shipper_housenumber">Hausnummer:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_houseNumber" id="shipper_housenumber" value="<?php echo $shipper['houseNumber'] ?>" size="5" maxlength="5"></dd>
								<dt><label for="shipper_postcode">Postleitzahl:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_postcode" id="shipper_postcode" value="<?php echo $shipper['postcode'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_city">Stadt:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_city" id="shipper_city" value="<?php echo $shipper['city'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_district">Bezirk:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_district" id="shipper_district" value="<?php echo $shipper['district'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_countrycode">Land:</label></dt>
								<dd>
									<?php if($order->isMutable()): ?>
									<select <?php echo $romode ?> name="shipper_countryCode" id="shipper_countrycode" size="1">
										<?php foreach($countries as $ccode): ?>
										<option value="<?php echo $ccode ?>" <?php echo $shipper['countryCode'] == $ccode ? 'selected' : ''?>><?php echo $shopcountries[$ccode]['countries_name'] ?></option>
										<?php endforeach ?>
									</select>
									<?php else: ?>
									<?php echo $shopcountries[$shipper['countryCode']]['countries_name'] ?>
									<?php endif ?>
								</dd>
								<dt><label for="shipper_telephonenumber">Telefon:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_telephoneNumber" id="shipper_telephonenumber" value="<?php echo $shipper['telephoneNumber'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_telephoneprefix">Telefonvorwahl:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_telephonePrefix" id="shipper_telephoneprefix" value="<?php echo $shipper['telephonePrefix'] ?>" size="25" maxlength="25"></dd>
								<dt><label for="shipper_email">E-Mail:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="shipper_email" id="shipper_email" value="<?php echo $shipper['email'] ?>" size="25" maxlength="25"></dd>
							</dl>
						</fieldset>
						<?php endif ?>
						<fieldset class="hwfloat" id="fsreceiver">
							<legend>Empfänger</legend>
							<dl id="neworder" class="form">
								<dt><label for="firstname">Vorname:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_firstname" id="firstname" value="<?php echo $order->receiver_firstname ?>" size="25" maxlength="25"></dd>
								<dt><label for="lastname">Nachname:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_lastname" id="lastname" value="<?php echo $order->receiver_lastname ?>" size="25" maxlength="25"></dd>
								<dt><label for="street">Straße:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_street" id="street" value="<?php echo $order->receiver_street ?>" size="27" maxlength="27"></dd>
								<dt><label for="housenumber">Hausnummer:</label></dt>
								<dd>
									<input <?php echo $romode ?> type="text" name="receiver_housenumber" id="housenumber" value="<?php echo $order->receiver_housenumber ?>" size="5" maxlength="5">
									<em>kann auch bei Straße angegeben werden</em>
								</dd>
								<dt><label for="addressadd">Adresszusatz:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_addressadd" id="addressadd" value="<?php echo $order->receiver_addressadd ?>" size="25" maxlength="25"></dd>
								<dt><label for="postcode">Postleitzahl:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_postcode" id="postcode" value="<?php echo $order->receiver_postcode ?>" size="25" maxlength="25"></dd>
								<dt><label for="city">Stadt:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_city" id="city" value="<?php echo $order->receiver_city ?>" size="30" maxlength="30"></dd>
								<dt><label for="district">Bezirk:</label></dt>
								<dd>
									<input <?php echo $romode ?> type="text" name="receiver_district" id="district" value="<?php echo $order->receiver_district ?>" size="25" maxlength="25">
									<em>für Irland</em>
								</dd>
								<dt><label for="countrycode">Land:</label></dt>
								<dd>
									<?php if($order->isMutable()): ?>
									<select <?php echo $romode ?> name="receiver_countrycode" id="countrycode" size="1">
										<?php foreach($countries as $ccode): ?>
										<option value="<?php echo $ccode ?>" <?php echo $order->receiver_countrycode == $ccode ? 'selected' : ''?>><?php echo $shopcountries[$ccode]['countries_name'] ?></option>
										<?php endforeach ?>
									</select>
									<?php else: ?>
									<?php echo $shopcountries[$order->receiver_countrycode]['countries_name'] ?>
									<?php endif ?>
								</dd>
								<dt><label for="email">E-Mail:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_email" id="email" value="<?php echo $order->receiver_email ?>" size="50" maxlength="250"></dd>
								<dt><label for="telephonenumber">Telefon:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_telephonenumber" id="telephonenumber" value="<?php echo $order->receiver_telephonenumber ?>" size="32" maxlength="32"></dd>
								<dt><label for="telephoneprefix">Telefonvorwahl:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="receiver_telephoneprefix" id="telephoneprefix" value="<?php echo $order->receiver_telephoneprefix ?>" size="25" maxlength="25"></dd>
							</dl>
						</fieldset>
						<fieldset class="hwfloat <?php echo $hermes->getService() == "PriPS" ? 'cl' : '' ?>" id="fsorderdata">
							<legend>Sendungsdaten</legend>
							<dl id="orderdata" class="form">
								<dt><label for="orderno">Auftragsnummer:</label></dt>
								<dd>
									<input type="text" name="orderno" id="orderno" value="<?php echo $order->orderno ?>" readonly>
									<?php if($orderno === false): ?>
									<span class="neworder">NEUER AUFTRAG</span>
									<?php endif ?>
								</dd>
								<dt><label for="state">Status:</label></dt>
								<dd>
									<div style="display: none">
										<select name="state" size="1">
											<?php foreach(HermesOrder::getValidStates() as $vstate): ?>
											<option value="<?php echo $vstate ?>" <?php echo $vstate == $order->state ? 'selected' : '' ?>><?php echo $vstate ?></option>
											<?php endforeach ?>
										</select>
									</div>
									<?php echo HermesOrder::getStateName($order->state) ?>
								</dd>
								<dt><label for="clientreferencenumber">Referenznummer:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="clientreferencenumber" id="clientreferencenumber" value="<?php echo $order->clientreferencenumber ?>"></dd>
								<?php if($hermes->getService() == "ProPS"): ?>
								<dt><label for="parcelclass">Paketklasse:</label></dt>
								<dd>
									<?php if($order->isMutable()): ?>
									<select name="parcelclass" id="parcelclass">
										<?php foreach($pclasses as $pclass => $pcinfo): ?>
										<option value="<?php echo $pclass ?>" <?php echo $pclass == $order->parcelclass ? 'selected' : '' ?>>
											<?php echo $pcinfo['name'] .' - '. $pcinfo['desc'] ?>
										</option>
										<?php endforeach ?>
									</select>
									<?php else: ?>
									<?php echo $order->parcelclass ?>
									<?php endif ?>
								</dd>
								<?php else: // Service == PriPS ?>
								<dt><label for="parcelclass">Paketklassen:</label></dt>
								<dd>
									Anzahl Pakete:
									<table>
										<?php foreach($pclasses as $pclass => $pcinfo): ?>
										<tr>
											<td class="parcelclasslabel">
												<?php echo $pcinfo['name'] ?>
											</td>
											<td>
												<input <?php echo $romode ?> name="<?php echo 'parcelclasses['.$pclass.']' ?>" type="text" size="3" maxlength="3" value="<?php echo $order->getParcelclasses($pclass) ?>">
											</td>
										</tr>
										<?php endforeach ?>
									</table>
								</dd>
								<?php endif ?>
								<?php if($hermes->getService() == "ProPS"): ?>
								<dt><label for="amountcashondeliveryeurocent">Nachnahmebetrag:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="amountcashondeliveryeurocent" id="amountcashondeliveryeurocent" value="<?php echo number_format($order->amountcashondeliveryeurocent / 100, 2, '.', '') ?>"> EUR</dd>
								<?php endif ?>
								<?php if($hermes->getService() == "PriPS"): ?>
								<dt><label for="handovermode">Abgabeart:</label></dt>
								<dd>
									<select name="handovermode" id="handovermode" size="1">
										<option value="PS" <?php echo $order->hand_over_mode == 'PS' ? 'selected' : '' ?>>Abgabe am Paketshop, Lieferung an Empfänger</option>
										<option value="S2S" <?php echo $order->hand_over_mode == 'S2S' ? 'selected' : ''?>>Abgabe und Lieferung an Paketshops</option>
										<option value="COL" <?php echo $order->hand_over_mode == 'COL' ? 'selected' : '' ?>>Abholung an Haustür, Lieferung an Empfänger</option>
									</select>
								</dd>
								<dt><label for="paket_shop_id">Paket-Shop-ID:</label></dt>
								<dd><input <?php echo $romode ?> type="text" name="paket_shop_id" id="paket_shop_id" value="<?php echo $order->paket_shop_id ?>"></dd>
								<?php endif ?>
								<?php if($barcode !== false): ?>
								<dt><label for="shippingid">Barcode:</label></dt>
								<dd class="shippingid"><?php echo $barcode ?></dd>
								<dt><label for="shipmentstatus">Sendungsstatus:</label></dt>
								<dd id="shipmentstatus">wird geladen ...</dd>
								<?php endif ?>
							</dl>
						</fieldset>
						<fieldset class="hwfloat" id="fsbuttons">
							<?php if($hermes->getService() == 'ProPS'): ?>
								<?php if($order->isMutable()): ?>
								<input type="submit" name="ordersave" value="Auftrag speichern + senden" class="button showwork">
								<?php endif ?>
								<?php if($orderno !== false && $order->isMutable()): ?>
								<input type="submit" name="ordercancel" value="Auftrag stornieren/löschen" class="button confirm showwork">
								<?php endif ?>
								<?php if($order->state == 'sent' || $order->state == 'printed'): ?>
								<div class="orderlabel">
									<input type="submit" name="orderprintlabel" value="Paketschein anfordern" class="button">
									<div class="printpos">
										<input type="radio" name="printpos" value="1" title="Position 1" <?php echo $printpos == 0 ? 'checked="checked"' : '' ?>>
										<input type="radio" name="printpos" value="2" title="Position 2" <?php echo $printpos == 1 ? 'checked="checked"' : '' ?>><br>
										<input type="radio" name="printpos" value="3" title="Position 3" <?php echo $printpos == 2 ? 'checked="checked"' : '' ?>>
										<input type="radio" name="printpos" value="4" title="Position 4" <?php echo $printpos == 3 ? 'checked="checked"' : '' ?>>
									</div>
								</div>
								<?php endif ?>
							<?php else: // PriPS ?>
								<input type="checkbox" name="acceptanceliabilitylimit" id="accliab" value="1">
								<label for="accliab"><?php echo $label_liabilitylimit ?></label><br>
								<input type="checkbox" name="acceptancetac" id="acctac" value="1">
								<label for="acctac"><?php echo $label_tac ?></label>
								<a class="newwindow" href="<?php echo $url_tac ?>">(anzeigen)</a>
								<br>
								<input type="submit" name="pripsprint" value="Paketschein anfordern" class="button" id="pripsprint">
							<?php endif ?>
						</fieldset>
					</form>
					
					<a class="button" href="<?php echo HTTP_SERVER.DIR_WS_ADMIN.'orders.php?action=edit&oID='.$orders_id ?>">zur Bestellung</a>
					
				</td>
				<!-- body_text_eof //-->
				
			</tr>
		</table>
		<!-- body_eof //-->

		<!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		<!-- footer_eof //-->
		<script>
			$(function() {
				$('a.newwindow').click(function(e) {
					e.preventDefault();
					window.open($(this).attr('href'));
				});
				$('.confirm').click(function(e) {
					return window.confirm('Wirklich löschen?');
				});
				$('.showwork').click(function(e) {
					$('body').prepend($('<div class="overlay">in Arbeit &hellip;</div>'));
				});
				
				$('#pripsprint').click(function(e) {
					if(!($('#accliab:checked').val() == '1' && $('#acctac:checked').val() == '1')) {
						e.preventDefault();
						alert("Aufträge können nur übermittelt werden,\nwenn Sie die Haftungsbeschränkungen und\nAGB ausdrücklich bestätigen.");
					}
				});
				
				$('#shipmentstatus').load('hermes_list.php', { 'shipmentstatus': $('.shippingid').text() });
				
				$('.availability').load('hermes_order.php', { 'ajax': 'checkavailability' });
			});
		</script>
	</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
