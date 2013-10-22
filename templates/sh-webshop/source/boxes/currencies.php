<?php
/* --------------------------------------------------------------
   currencies.php 2010-10-20 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.16 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (currencies.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: currencies.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

$t_box_html = '';

if(isset($xtPrice) && is_object($xtPrice))
{
	$coo_currencies = MainFactory::create_object('CurrenciesContentView');
	$f_get_array = false;
	if(isset($_GET))
	{
		$f_get_array = $_GET;
	}
	$t_box_html = $coo_currencies->get_html($request_type, $f_get_array);
}


$gm_box_pos = $coo_template_control->get_menubox_position('currencies');
$smarty->assign($gm_box_pos, $t_box_html);

?>