<?php
/* --------------------------------------------------------------
   function.gm_gprint.php 2009-11-19 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

function smarty_function_gm_gprint($params, &$smarty)
{
	$t_output = '';
	$t_products_id = 0;
	
	$coo_gm_gprint_configuration = new GMGPrintConfiguration($_SESSION['languages_id']);
	$coo_gm_gprint_product_manager = new GMGPrintProductManager();
	
	if(isset($_GET['info']))
	{
		$t_site = explode('_', $_GET['info']);
		$t_products_id = (int) str_replace('p', '', $t_site[0]);
	}
	elseif(isset($_GET['products_id']))
	{
		$t_products_id = (int)xtc_get_prid($_GET['products_id']);
	}
		
	if($params['position'] == $coo_gm_gprint_configuration->get_configuration('POSITION')
		&& $coo_gm_gprint_product_manager->get_surfaces_groups_id($t_products_id) !== false)	
	{
		$coo_gm_gprint_smarty = new Smarty();
		
		if(strpos($_GET['info'], '}') !== false && is_array($_SESSION['coo_gprint_cart']->v_elements))
		{
			foreach($_SESSION['coo_gprint_cart']->v_elements AS $t_products_id => $t_value)
			{
				$t_new_products_id = $_SESSION['coo_gprint_cart']->check_cart($t_products_id, 'cart');
				
				if((strpos($_GET['info'], $t_products_id) !== false || strpos($_GET['info'], $t_new_products_id) !== false) && strpos($_GET['info'], '{') !== false)
				{
					$t_gm_random = preg_replace('/(.*)\{([0-9]{6})\}0(.*)/', "$2", $_GET['info']);
				}
			}
		}	
		elseif(strpos($_GET['products_id'], '}') !== false && is_array($_SESSION['coo_gprint_wishlist']->v_elements))
		{
			foreach($_SESSION['coo_gprint_wishlist']->v_elements AS $t_products_id => $t_value)
			{
				$t_new_products_id = $_SESSION['coo_gprint_wishlist']->check_wishlist($t_products_id, 'wishList');
				
				if((strpos($_GET['products_id'], $t_products_id) !== false || strpos($_GET['products_id'], $t_new_products_id) !== false) && strpos($_GET['products_id'], '{') !== false)
				{
					$t_gm_random = preg_replace('/(.*)\{([0-9]{6})\}0(.*)/', "$2", $_GET['products_id']);
				}
			}
		}
		else
		{
			$t_gm_random = rand(100000, 999999);
		}
		
		if(empty($t_gm_random))
		{
			$t_gm_random = rand(100000, 999999);
		}
		
		$coo_gm_gprint_smarty->assign('GM_GPRINT_RANDOM', $t_gm_random);		
		$coo_gm_gprint_smarty->assign('MARGIN_LEFT', $params['margin_left']);
	
		$t_output = $coo_gm_gprint_smarty->fetch(CURRENT_TEMPLATE . '/module/gm_gprint.html');
	}	
	
	return $t_output;
}

?>