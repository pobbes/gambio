<?php
/* -----------------------------------------------------------------------------------------
   $Id: skrill_payinv.php 39 2009-01-22 15:44:52Z mzanier $

   xt:Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2009 xt:Commerce
   -----------------------------------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(skrill.php,v 1.00 2003/10/27); www.oscommerce.com

   Released under the GNU General Public License
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   skrill v1.0                       Autor:    Gabor Mate  <gabor(at)jamaga.hu>

   Released under the GNU General Public License
   
   // Version History
    * 2.0 xt:Commerce Adaption
    * 2.1 new workflow, tmp orders
    * 2.2 new modules
    * 2.3 updates
    * 2.4 major update, iframe integration
   
   
   ---------------------------------------------------------------------------------------*/

if (file_exists('includes/classes/class.skrill.php')) {
	require_once 'includes/classes/class.skrill.php';
} else {
	require_once '../includes/classes/class.skrill.php';
}

class skrill_payinv_ORIGIN extends fcnt_skrill {

	var $images='Skrill-rechnung-78x26-white.png'; //'by_ewallet_90x45.gif';

	// class constructor
	function skrill_payinv_ORIGIN() {
		global $order, $language;

		$this->_setCode('payinv','PAY');
		$this->_tid_prefix = 'PAYOLUTION_INVOICE';

		if (is_object($order))
			$this->update_status();

	}


	function selection() {

		$content = array();
		$accepted = '';
		$icons = explode(',', $this->images);
		foreach ($icons as $key => $val)
			$accepted .= xtc_image(DIR_WS_ICONS .'skrill/'. $val) . ' ';



		$content = array_merge($content, array (array ('title' => ' ','field' => $accepted)));
		

		return array (
			'id' => $this->code,
			'module' => $this->title,
			//'fields' => $content,
			'description' => $this->info
		);
	}
}

MainFactory::load_origin_class('skrill_payinv');
?>
