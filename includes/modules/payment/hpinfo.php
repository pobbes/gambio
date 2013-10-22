<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/

if (file_exists(DIR_WS_CLASSES.'class.heidelpay.php')){
	include_once(DIR_WS_CLASSES.'class.heidelpay.php');
} else {
	require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.heidelpay.php');
}

class hpinfo_ORIGIN {
	var $code, $title, $description, $enabled, $hp, $payCode, $tmpStatus;

	// class constructor
	function hpinfo_ORIGIN() /*{{{*/
	{
		global $order, $language;

		$this->payCode = 'info';
		$this->code = 'hp'.$this->payCode;
		$this->version = '1.0';
		$this->title = MODULE_PAYMENT_HPINFO_TEXT_TITLE;
		$this->description = MODULE_PAYMENT_HPINFO_TEXT_DESC;
		$this->sort_order = MODULE_PAYMENT_HPINFO_SORT_ORDER;
		$this->enabled = ((MODULE_PAYMENT_HPINFO_STATUS == 'True') ? true : false);
		$this->info = MODULE_PAYMENT_HPINFO_TEXT_INFO;
		#$this->form_action_url = 'checkout_success.php';
		$this->tmpOrders = false;
		$this->tmpStatus = MODULE_PAYMENT_HPINFO_NEWORDER_STATUS_ID;
		$this->order_status = MODULE_PAYMENT_HPINFO_NEWORDER_STATUS_ID;
		$this->hp = new heidelpay();
		$this->hp->actualPaymethod = strtoupper($this->payCode);
		/*
		 $this->icons_available = xtc_image(DIR_WS_ICONS . 'cc_amex_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_mastercard_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_visa_small.jpg') . ' ' .
		 xtc_image(DIR_WS_ICONS . 'cc_diners_small.jpg');
		 */

		if (is_object($order)) $this->update_status();


  }/*}}}*/

  function check() /*{{{*/
	{
		if (!isset ($this->_check)) {
			$check_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'MODULE_PAYMENT_HPINFO_STATUS'");
			$this->_check = xtc_db_num_rows($check_query);
		}
		return $this->_check;
  }/*}}}*/

  function keys() /*{{{*/
  {
    return array();
  }/*}}}*/

  function install() /*{{{*/
  {
    return true;
  }/*}}}*/

  function remove() /*{{{*/
  {
    return true;
  }/*}}}*/

}

MainFactory::load_origin_class('hpinfo');
?>