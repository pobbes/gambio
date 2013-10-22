<?php

/* --------------------------------------------------------------
   skrill_info.php 2012-05 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_cod_fee.php 1003 2005-07-10 18:58:52Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

/**
 * This is a dummy module for Skrill. Its only purpose is to provide an entry point to the real configuration page for the Skrill modules. 
 */
class skrill_info_ORIGIN {
	var $code, $title, $description, $enabled;
	
	function skrill_info_ORIGIN() {
		$this->code = 'skrill_info';
		$this->title = '<img src="'.DIR_WS_CATALOG.'images/icons/skrill/skrillfuture-logo.jpg" style="max-width:100px;">&nbsp;'.MODULE_PAYMENT_SKRILL_INFO_TEXT_TITLE;
		$styles = '<style>';
		$styles .= 'td.infoBoxContent a.button { display: none; }';
		$styles .= 'a.skrill_cfg { display: block; width: 10em; margin: 0 auto; padding: 10px; background: #fff; ';
		$styles .= 'color: #852064; text-align: center; font-size: 1.2em; font-weight: bold; text-transform: uppercase; border-radius: 1em; box-shadow: 0 0 3px #852064; }';
		$styles .= '</style>';
		$config_url = DIR_WS_ADMIN.'configuration.php?gID=32';
		$this->description = MODULE_PAYMENT_SKRILL_INFO_TEXT_DESCRIPTION.$styles;
		$this->description = strtr($this->description, array(
			':config_url' => $config_url,
		));
	}
	
	function check() {
		return false;
	}
	
	function keys() { 
		return array();
	}
	
	function install() { }
	function remove() { }
	
}

MainFactory::load_origin_class('skrill_info');
