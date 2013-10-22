<?php
/* --------------------------------------------------------------
   clickandbuy_v2.php 2012-02-09 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

clickandbuy.php

  xt:Commerce ClickandBuy Payment Module
  (c) 2008-2009 Matthias Bauer / Trust in Dialog <http://www.trustindialog.de/>

  based in part on:
    xt:Commerce ClickandBuy Contribution, v1.2e
    Copyright (c) 2005 by Julius Firl | jfirl@fotocommunity.com | fotocommunity.de | v 1.0
    Copyright (c) 2006 by Johannes Teitge | info@tmedia.de | www.oscommerce-admin.de | v 1.1, v 1.1.1

  @author Matthias Bauer <m.bauer@trustindialog.de>
  @copyright (c) 2008-2009 Matthias Bauer / Trust in Dialog
  @version $Revision$
  @license GPLv2

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

*/

require_once (DIR_FS_INC.'xtc_get_customers_country.inc.php');

//echo "<pre>";
//print_r($_SERVER);
//echo "</pre>";


function _clickandbuy_v2_str_shuffle($str)
{
  for ($i = 0; $i <= strlen($str); $i++)
  {
    $nary[] = substr($str, $i, 1);
  }
  shuffle ($nary);
  $output = '';
  while (list (, $number) = each ($nary)) { $output .= $number; }
  return $output;
}

class clickandbuy_v2_ORIGIN
{
  var $data;
  var $_check;

  function clickandbuy_v2_ORIGIN()
  {
    $this->code = 'clickandbuy_v2';
    $this->href = MODULE_PAYMENT_CLICKANDBUY_V2_ID;
    $this->title = MODULE_PAYMENT_CLICKANDBUY_V2_TEXT_TITLE;
    $this->description = MODULE_PAYMENT_CLICKANDBUY_V2_TEXT_DESCRIPTION;
    $this->sort_order = MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER;
    $this->enabled = ((MODULE_PAYMENT_CLICKANDBUY_V2_STATUS == 'true') ? true : false);
    $this->order_status = MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID;

    $this->country_locale_map = array(
      'DE' => array('region' => 'DE', 'lang' => 'de'),
      'US' => array('region' => 'US', 'lang' => 'en'),
      'EN' => array('region' => 'UK', 'lang' => 'en'),
      'ES' => array('region' => 'ES', 'lang' => 'es'),
      'FR' => array('region' => 'FR', 'lang' => 'fr'),
      'NL' => array('region' => 'NL', 'lang' => 'nl'),
      'IT' => array('region' => 'IT', 'lang' => 'it'),
      'DK' => array('region' => 'DK', 'lang' => 'da'),
      'NO' => array('region' => 'NO', 'lang' => 'no'),
      'FI' => array('region' => 'FI', 'lang' => 'fi'),
      'SE' => array('region' => 'SE', 'lang' => 'sv'),
      'PT' => array('region' => 'EU', 'lang' => 'pt'),
      'TR' => array('region' => 'EU', 'lang' => 'tr'),
      'GR' => array('region' => 'EU', 'lang' => 'el'),
    );

    $user_country_id = xtc_get_customers_country($_SESSION['customer_id']);
    $lang_query = xtc_db_query("SELECT countries_iso_code_2 AS country FROM ".TABLE_COUNTRIES." WHERE countries_id='".$user_country_id."'");
    $qa = xtc_db_fetch_array($lang_query);
    $user_country = strtoupper($qa['country']);
    $user_locale_data = (isset($this->country_locale_map[$user_country])
      ? $this->country_locale_map[$user_country]
      : $this->country_locale_map['EN']);
    $this->more_info_link = sprintf('http://clickandbuy.com/%s/%s/info.html', $user_locale_data['region'], $user_locale_data['lang']);

    if (defined('_VALID_XTC')) {
      // we're in admin
      $this->icons_available = xtc_image(DIR_WS_ICONS . 'clickandbuy_international_h.gif');
      // BOF GM_MOD:
      $this->description = '<div align="center">'.xtc_image(DIR_WS_ICONS . 'clickandbuy_international_w_small.gif').'</div>' . $this->description;
    }
    elseif (basename($_SERVER['PHP_SELF']) != 'checkout_process.php') {
      // here, DIR_WS_ICONS is the non-admin value(!)
      $this->title = xtc_image(DIR_WS_ICONS . '/clickandbuy_pref_180.gif').'<br>'.$this->title.' <small>(<a target="_clickandbuy" href="'.$this->more_info_link.'">'.MODULE_PAYMENT_CLICKANDBUY_V2_MORE_INFO_LINK_TITLE.'</a>)</small>';
    }

    $this->check();
    $this->refresh();
  }

  function refresh()
  {
    if (!$this->_check) return;
    global $order;

    if (is_object($order)) {
      $this->update_status();
    }
    $this->form_action_url = $this->build_action_url();
  }

  function build_action_url()
  {
    if (!$this->_check) return;
    global $order;
    if (!$order) return;

    $cZone_query = xtc_db_query("
      SELECT geo_zone_id
      FROM " . TABLE_ZONES_TO_GEO_ZONES . "
      WHERE zone_country_id = '" . $_SESSION['customer_country_id'] . "'
      ORDER BY zone_id
    ");
    if (xtc_db_num_rows($cZone_query)) {
      $cZone = xtc_db_fetch_array($cZone_query);
    }

    $zone_query = xtc_db_query("
      SELECT tax_rate
      FROM " . TABLE_TAX_RATES . "
      WHERE tax_zone_id = '".$cZone['geo_zone_id']."'
    ");
    if (xtc_db_num_rows($zone_query)) {
      $zone = xtc_db_fetch_array($zone_query);
    }

    $user_more_query = xtc_db_query("
      SELECT
        customers_email_address AS email,
        customers_telephone AS telephone,
        customers_default_address_id AS address_id
      FROM ".TABLE_CUSTOMERS."
      WHERE customers_id = '".$_SESSION['customer_id']."'
    ");
    if (xtc_db_num_rows($user_more_query)) {
      $user_more = xtc_db_fetch_array($user_more_query);
    }

    $user_query = xtc_db_query("
      SELECT
        entry_firstname AS firstname,
        entry_lastname AS lastname,
        entry_street_address AS street_address,
        entry_postcode AS postcode,
        entry_city AS city,
        entry_country_id AS country
      FROM
        ".TABLE_ADDRESS_BOOK."
      WHERE
        customers_id='".$_SESSION['customer_id']."'
        AND address_book_id='".$user_more['address_id']."'
    ");
    if (xtc_db_num_rows($user_query)) {
      $user = xtc_db_fetch_array($user_query);
    }

    $lang_query = xtc_db_query("SELECT countries_iso_code_2 AS country FROM ".TABLE_COUNTRIES." WHERE countries_id='".$user['country']."'");
    if (xtc_db_num_rows($lang_query)) {
      $user_country		= xtc_db_fetch_array($lang_query);
    }

    $tax = str_replace('.', '', $zone['tax_rate']);
    $tax_factor = '1.'.$tax;

    if (!isset($_SESSION['cartID']))
	{
		$_SESSION['cartID'] = $_SESSION['cart']->cartID;
    }
	elseif(empty($_SESSION['cart']->cartID))
	{
		$_SESSION['cart']->cartID = $_SESSION['cart']->generate_cart_id();
		$_SESSION['cartID'] = $_SESSION['cart']->cartID;
	}

    if ((MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY == 'Selected Currency') || (substr(MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY, 5) == $_SESSION['currency'])) {
      $cb_currency = $_SESSION['currency'];
      $order_total = $order->info['total'];
    }
    else {
      // allowed currency is different from selected currency
      global $xtPrice;
      $cb_currency = substr(MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY, 5);
      $target_currency_value = $xtPrice->currencies[ $cb_currency ]['value'];
      $order_total = $order->info['total'] / $order->info['currency_value'] * $target_currency_value;
    }

    // PHP/IEEE FP bug: sprintf('%03d', 5.53 * 100) = 552, therefore we round
    $clickandbuy_price = sprintf('%03d', round($order_total * 100));
    $BDRID = substr(md5(_clickandbuy_v2_str_shuffle(rand('100000', '999999'))),1,10);

    $url_host = rtrim($this->href, '/');

    $url_path = '/' . MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT;
    $url_path .= '?price='.urlencode($clickandbuy_price); // total
    $url_path .= '&userid='.urlencode($_SESSION['customer_id']); // shop userid
    $url_path .= '&TransactionID='.urlencode($_SESSION['cartID']); // session cartid and ClickandBuy TransactionID
    $url_path .= '&check='.rand('1000', '9999'); // first value for redirection-check
    $url_path .= '&b_check='.rand('100', '999'); // second value for redirection-check
    $url_path .= '&externalBDRID='.urlencode($BDRID); // ClickandBuy ExternalBDRID
    // optional parameters
    $url_path .= '&cb_currency='.urlencode($cb_currency); // set currency
    $url_path .= '&lang='.strtolower($_SESSION['language_code']);
    $url_path .= '&Nation='.strtoupper($user_country['country']);
    $url_path .= '&Email='.urlencode($user_more['email']);
    if ($order->billing['firstname'] . $order->billing['lastname'] . $order->billing['street_address'] . $order->billing['postcode'] . $order->billing['city'] . $order->billing['country']['iso_code_2'] == '') {
      $url_path .= '&FirstName='.urlencode($user['firstname']);
      $url_path .= '&LastName='.urlencode($user['lastname']);
      $url_path .= '&Street='.urlencode($user['street_address']);
      $url_path .= '&ZIP='.urlencode($user['postcode']);
      $url_path .= '&City='.urlencode($user['city']);
    }
    $url_path .= '&Phone='.urlencode($user_more['telephone']);
    $url_path .= '&Gender='.urlencode(strtoupper($order->customer['gender']));
    $url_path .= '&Company='.urlencode($order->billing['company']);
    // billing_* and shipping_* info for fraud prevention
    if ($order->billing['firstname'] . $order->billing['lastname'] . $order->billing['street_address'] . $order->billing['postcode'] . $order->billing['city'] . $order->billing['country']['iso_code_2'] != '') {
      $url_path .= '&cb_billing_FirstName='.urlencode($order->billing['firstname']);
      $url_path .= '&cb_billing_LastName='.urlencode($order->billing['lastname']);
      $url_path .= '&cb_billing_Street='.urlencode($order->billing['street_address']);
      $url_path .= '&cb_billing_Street2='.urlencode($order->billing['suburb']);
      $url_path .= '&cb_billing_ZIP='.urlencode($order->billing['postcode']);
      $url_path .= '&cb_billing_City='.urlencode($order->billing['city']);
      $url_path .= '&cb_billing_Nation='.urlencode(strtoupper($order->billing['country']['iso_code_2']));
    }
    if ($order->delivery['firstname'] . $order->delivery['lastname'] . $order->delivery['street_address'] . $order->delivery['postcode'] . $order->delivery['city'] . $order->delivery['country']['iso_code_2'] != '') {
      $url_path .= '&cb_shipping_FirstName='.urlencode($order->delivery['firstname']);
      $url_path .= '&cb_shipping_LastName='.urlencode($order->delivery['lastname']);
      $url_path .= '&cb_shipping_Street='.urlencode($order->delivery['street_address']);
      $url_path .= '&cb_shipping_Street2='.urlencode($order->delivery['suburb']);
      $url_path .= '&cb_shipping_ZIP='.urlencode($order->delivery['postcode']);
      $url_path .= '&cb_shipping_City='.urlencode($order->delivery['city']);
      $url_path .= '&cb_shipping_Nation='.urlencode(strtoupper($order->delivery['country']['iso_code_2']));
    }
    //$url_path .= '&DateOfBirth='.urlencode(strtoupper($order['customer'][''));
    // pass through any other parameters
    $url_path .= '&'.xtc_get_all_get_params(array('Bank', 'login_step', 'BLZ', 'MiddleName', 'cb_content_name_utf', 'MultipleTradeAllowed', 'cb_currency', 'Nation', 'City', 'password', 'company', 'Phone', 'CreditCard', 'prepaid', 'CreditCardNo', 'price', 'CreditCardValid', 'querykey', 'DateOfBirth', 'setlogincookie', 'Email', 'State', 'externalBDRID', 'Street', 'Fax', 'Street2', 'FirstName', 'subscriptionid', 'gender', 'usertref', 'Handynr', 'weiter.x', 'ID', 'weiter.y', 'Konto', 'x', 'lang', 'y', 'LastName', 'ZIP', 'logincookie'));
    // pass through session id
    $url_path .= ($_GET[xtc_session_name()] ? '&'.xtc_session_name().'='.urlencode($_GET[xtc_session_name()]) : '');
    // XXX does this actually do anything?
    $url_path .= '&dummy=_$$$'.preg_replace('/\?.*/', '', xtc_href_link(FILENAME_DEFAULT));

    $_SESSION['externalBDRID'] = $BDRID;
    $_SESSION['TransactionID'] = $_SESSION['cartID'];

    $clickandbuy_query = xtc_db_query("
      UPDATE
        customers_basket
      SET
        final_price = '".round($clickandbuy_price / 100, 4)."',
        clickandbuy_TransactionID = '".$_SESSION['TransactionID']."',
        clickandbuy_externalBDRID = '".$_SESSION['externalBDRID']."',
        cb_currency = '".$_SESSION['currency']."'
      WHERE customers_id = '".$_SESSION['customer_id']."'
    ");

    $return = $url_host . $url_path;
    // for fgkey (md5 digested urls), change the (0) to (1) and set your dynkey
    if (0) {
      $salt = 'your-dynkey';
      $return .= '&fgkey='.md5($salt.$url_path);
    }

    return $return;
  }

  function check()
  {
    if (!isset($this->_check)) {
      $check_query = xtc_db_query("SELECT configuration_value FROM " . TABLE_CONFIGURATION . " WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_STATUS'");
      $this->_check = xtc_db_num_rows($check_query);
    }
    return $this->_check;
  }

  function update_status()
  {
    global $order;

    $this->form_action_url = $this->build_action_url();
    if ( ($this->enabled == true) && ((int)MODULE_PAYMENT_CLICKANDBUY_V2_ZONE > 0) ) {
      $check_flag = false;
      $check_query = xtc_db_query("
        SELECT zone_id
        FROM " . TABLE_ZONES_TO_GEO_ZONES . "
        WHERE
          geo_zone_id = '" . MODULE_PAYMENT_CLICKANDBUY_V2_ZONE . "'
          AND zone_country_id = '" . $order->billing['country']['id'] . "'
        ORDER BY zone_id
      ");

      while ($check = xtc_db_fetch_array($check_query)) {
        if ($check['zone_id'] < 1 || $check['zone_id'] == $order->billing['zone_id']) {
          $check_flag = true;
          break;
        }
      }

      $this->enabled = $check_flag;
    }
  }

  function javascript_validation()
  {
    return false;
  }

  function selection()
  {
    return array(
      'id' => $this->code,
      'module' => $this->title
    );
  }

  function pre_confirmation_check()
  {
    return false;
  }

  function confirmation()
  {
    return false;
  }

  function before_process()
  {
    return false;
  }

  function after_process()
  {
    global $insert_id;

    $external = $_GET['externalBDRID'];
    if (!$external) $external = 'NULL';

    $string = $_SERVER['argv'][0];
    $pieces = explode('&', $string);

    while ($data = each($pieces)) {
      if (substr_count($data['value'], 'transaction') >= '1') {
        $transaction = substr(strrchr($data['value'], '='),1);
      }
      if (substr_count($data['value'], 'userid') >= '1') {
        $userid = substr(strrchr($data['value'], '='),1);
      }
      if (substr_count($data['value'], 'price') >= '1') {
        $price = substr(strrchr($data['value'], '='),1);
      }
    }

    $qr = xtc_db_query("
      INSERT INTO orders_clickandbuy (
        orders_id,
        f_transactionID,
        x_transactionID,
        f_externalBDRID,
        f_userid,
        x_userid,
        price,
        date)
      VALUES 	(
        '".xtc_db_prepare_input($insert_id)."',
        '".xtc_db_prepare_input($_GET['xTransaction'])."',
        '".xtc_db_prepare_input($transaction)."',
        '".xtc_db_prepare_input($external)."',
        '".xtc_db_prepare_input($_GET['xUser'])."',
        '".xtc_db_prepare_input($userid)."',
        '".xtc_db_prepare_input($price)."',
        '".date("Y-m-d H:i:s")."'
      )
    ");

    if ($qr) {
      if ($this->order_status) {
        xtc_db_query("UPDATE ".TABLE_ORDERS." SET orders_status = '".$this->order_status."' WHERE orders_id = '".$insert_id."'");
      }
      return true;
    }
    else {
      return false;
    }
  }

  function process_button()
  {
    $process_button_string =
      xtc_draw_hidden_field('return', xtc_href_link(FILENAME_CHECKOUT_PROCESS, '', 'SSL')) .
      xtc_draw_hidden_field('cancel_return', xtc_href_link(FILENAME_CHECKOUT_PAYMENT, '', 'SSL'));

    return $process_button_string;
  }

  function keys()
  {
    return array(
      'MODULE_PAYMENT_CLICKANDBUY_V2_ALLOWED',
      'MODULE_PAYMENT_CLICKANDBUY_V2_STATUS',
      'MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS',
      'MODULE_PAYMENT_CLICKANDBUY_V2_ID',
      'MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID',
      'MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD',
      'MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT',
      'MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY',
      'MODULE_PAYMENT_CLICKANDBUY_V2_ZONE',
      'MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID',
      'MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER',
    );
  }

  function install()
  {
    $qr = xtc_db_query("DESCRIBE `customers_basket` 'clickandbuy\_%'");
    $qr2 = xtc_db_query("DESCRIBE `customers_basket` 'cb_currency'");
    if (xtc_db_num_rows($qr) == 0) {
      xtc_db_query("ALTER TABLE `customers_basket` ADD `clickandbuy_TransactionID` VARCHAR(11) NOT NULL , ADD `clickandbuy_externalBDRID` VARCHAR(11) NOT NULL, , ADD `cb_currency` CHAR(3) NOT NULL");
    }
    elseif(xtc_db_num_rows($qr2) == 0) {
    	xtc_db_query("ALTER TABLE `customers_basket` ADD `cb_currency` CHAR(3) NOT NULL");
    }

    $qr = xtc_db_query("SHOW TABLES LIKE 'orders_clickandbuy'");
    if (xtc_db_num_rows($qr) == 0) {
      xtc_db_query("CREATE TABLE `orders_clickandbuy` (
        `id` INT(11) NOT NULL AUTO_INCREMENT ,
        `orders_id` INT(11) NOT NULL ,
        `f_transactionID` VARCHAR(50) NOT NULL ,
        `x_transactionID` VARCHAR(255) NOT NULL ,
        `f_externalBDRID` VARCHAR(50) NOT NULL ,
        `f_userid` INT(11) NOT NULL ,
        `x_userid` VARCHAR (255) NOT NULL ,
        `price` DECIMAL(9,2) NOT NULL default '0.0',
        `date` DATETIME NOT NULL ,
        PRIMARY KEY (`id`) ,
        INDEX (`orders_id`)
       )
      ");
    }

    $qr = xtc_db_query("SHOW TABLES LIKE 'orders_clickandbuy_ems'");
    if (xtc_db_num_rows($qr) == 0) {
      xtc_db_query("CREATE TABLE IF NOT EXISTS `orders_clickandbuy_ems` (
          `id` int(13) NOT NULL auto_increment,
          `externalBDRID` varchar(64) default NULL,
          `BDRID` int(13) default NULL,
          `crn` int(13) NOT NULL,
          `tst_received` datetime NOT NULL,
          `datetime` datetime NOT NULL,
          `action` varchar(64) NOT NULL,
          `type` varchar(64) NOT NULL,
          `xml` text NOT NULL,
          PRIMARY KEY  (`id`),
          KEY `orders_id` (`externalBDRID`)
        ) COMMENT='ClickandBuy Event Messaging Service'
      ");
    }

    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_STATUS', 'false', '6', '0', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_ID', 'http://premium-link.net/xxxxxx/', '6', '4', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID', '123456', '6', '3', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD', 'pAssw0rT', '6', '4', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_REDIRECT', 'clickandbuy_check.php', '6', '4', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_CURRENCY', 'Only EUR', '6', '6', 'xtc_cfg_select_option(array(''Selected Currency'',''Only USD'',''Only CAD'',''Only EUR'',''Only GBP'',''Only JPY''),', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_SORT_ORDER', '1', '6', '4', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_ZONE', '0', '6', '2', 'xtc_get_zone_class_title', 'xtc_cfg_pull_down_zone_classes(', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, use_function, set_function, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_ORDER_STATUS_ID', '0', '6', '0', 'xtc_get_order_status_name', 'xtc_cfg_pull_down_order_statuses(', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, set_function, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_SECONDCONFIRMATION_STATUS', 'false', '6', '0', 'xtc_cfg_select_option(array(\'true\', \'false\'), ', NOW())");
    xtc_db_query("INSERT INTO " . TABLE_CONFIGURATION . " (configuration_key, configuration_value, configuration_group_id, sort_order, date_added) VALUES ('MODULE_PAYMENT_CLICKANDBUY_V2_ALLOWED', '', '6', '0', NOW())");
  }

  function remove()
  {
    // Don't delete those
    #xtc_db_query("DROP TABLE `orders_clickandbuy`");
    #xtc_db_query("DROP TABLE `orders_clickandbuy_ems`");
    #xtc_db_query("ALTER TABLE `customers_basket` DROP `clickandbuy_TransactionID`, DROP `clickandbuy_externalBDRID`");

    xtc_db_query("DELETE FROM " . TABLE_CONFIGURATION . " WHERE configuration_key IN ('" . implode("', '", $this->keys()) . "')");
  }
}


MainFactory::load_origin_class('clickandbuy_v2');
?>