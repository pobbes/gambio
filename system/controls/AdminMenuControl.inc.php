<?php
/* --------------------------------------------------------------
   AdminMenuControl.inc.php 2012-01-02 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/


class AdminMenuControl
{
  function get_menu_array( $p_customers_id )
  {
	$t_cache_key = 'AdminMenuSource_'.(int)$_SESSION['languages_id'];
	$coo_cache =& DataCache::get_instance();
	if($coo_cache->key_exists($t_cache_key, true))
	{
		#use cached object
		$coo_menu = $coo_cache->get_data($t_cache_key);
	}
	else
	{
		#build and init new object
		$coo_menu = MainFactory::create_object('AdminMenuSource', array(false));
		$coo_menu->init_structure_array();

		#write object to cache
		$coo_cache->set_data($t_cache_key, $coo_menu, true);
	}
    $t_groups = $coo_menu->get_groups_array();

    $coo_permissions = MainFactory::create_object('AdminPermSource', array(false));
    $coo_permissions->init_structure_array();
    
    $coo_favorites = MainFactory::create_object('AdminFavoritesSource', array(false));
    $coo_favorites->init_structure_array();
    $t_favorites_array = $coo_favorites->get_favorites($p_customers_id);
    
    $t_groups_array = array();
    $t_favorites_items_array = array();
    $t_fav_group_id = 0;
	$t_fav_counter = 0;
    foreach($t_groups as $key => $t_group){
		if($t_group['id'] != ""){
		  if($t_group['title'] == "FAVS"){
			$t_fav_group_id = $t_fav_counter;
		  }
		  $t_items = $coo_menu->get_group_items_array($t_group['id']);
		  $t_items_array = array();
		  foreach($t_items as $key => $t_item){
			$customer_is_permitted = $coo_permissions->is_permitted($p_customers_id, $t_item['link']);
			if($customer_is_permitted)
			{
				$t_session_id = xtc_session_id();
				$t_item['link'] = xtc_href_link($t_item['link'], $t_item['link_param']);
				$t_item['id'] = "id_".md5($t_item['link']);
				if(strpos($t_item['link'], xtc_session_name()) !== false)
				{		
					$t_link = str_replace('?' . xtc_session_name() . '=' . $t_session_id, '', $t_item['link']);
					$t_link = str_replace('&' . xtc_session_name() . '=' . $t_session_id, '', $t_link);	 
					$t_link = str_replace('.php&', '.php?', $t_link);
					$t_item['id'] = 'id_'.md5($t_link);
				}
				$t_items_array[] = $t_item;
				if(in_array($t_item['id'], $t_favorites_array))
				{
					$t_fav_key = array_keys($t_favorites_array, $t_item['id']);
					$t_favorites_items_array[$t_fav_key[0]] = $t_item;
				}
			}
		  }

		  $t_groups_array[] = array("id" => $t_group['id'], "title" => $t_group['title'], "background" => $t_group['background'], "menuitems" => $t_items_array);
		  $t_fav_counter++;
		}
    }
    ksort($t_favorites_items_array);
    $t_groups_array[$t_fav_group_id]['menuitems'] = $t_favorites_items_array;
    return $t_groups_array;
  } 
}
?>