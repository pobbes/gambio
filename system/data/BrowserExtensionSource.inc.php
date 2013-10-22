<?php
/* --------------------------------------------------------------
   BrowserExtensionSource.inc.php 2011-11-03 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class BrowserExtensionSource
{
	
	var $v_cache_data_array = array();
	var $v_cache_file_path;
  
	function BrowserExtensionSource()
	{
		$t_session_token = xtc_session_id();
		$this->v_cache_file_path = DIR_FS_CATALOG.'cache/browser_extension_data_'.$t_session_token.'.txt';
	}
	
	function get_cache_data_array()
	{
		return $this->v_cache_data_array;
	}
	
	function set_cache_data_array($p_cache_data_array)
	{
		if(is_array($p_cache_data_array))
		{
			$this->v_cache_data_array = $p_cache_data_array;
			return true;
		}
		return false;
	}
	
	function get_cache_file_data()
	{
		if(!file_exists($this->v_cache_file_path))
		{
			return false;
		}
		
		$t_file_content = file_get_contents($this->v_cache_file_path);		
		$t_cache_data_array = unserialize($t_file_content);
		
		return $this->set_cache_data_array($t_cache_data_array);
	}
	
	function save_cache_file_data()
	{
		$t_cache_data_string = serialize($this->v_cache_data_array);

		$t_file_content = fopen($this->v_cache_file_path, 'w');
		fwrite($t_file_content, $t_cache_data_string);
		fclose($t_file_content);
		
		return true;
	}
	
	function get_extension_status()
	{
		$t_extension_active = gm_get_conf('BROWSER_EXTENSION_ACTIVE');
		
		if($t_extension_active == "true")
		{
			return true;
		}
		
		return false;
	}
	
	function get_customers_status()
	{
		$t_customers_status_id = $_SESSION['customers_status']['customers_status_id'];
		
		if($t_customers_status_id === '0')
		{
			return true;
		}
		
		return false;
	}
	
	function check_auth_token($p_token)
	{
		$t_actual_token = $this->get_auth_token();
		
		if($p_token == $t_actual_token && $t_actual_token != ""){
			return true;
		}
		
		return false;
	}
	
	function get_shop_title()
	{
		$t_shop_title = gm_get_conf('BROWSER_EXTENSION_SHOP_TITLE');
		return $t_shop_title;
	}
	
	function get_auth_token()
	{
		$t_actual_token = gm_get_conf('BROWSER_EXTENSION_SHOP_TOKEN');
		return $t_actual_token;
	}
	
	function get_order_totals($p_time_unit, $p_time_var)
	{
		$t_time_unit = (string) $p_time_unit;
		$t_time_var = (int) $p_time_var;
		$t_orders_total = 0;
		
		switch($t_time_unit){
			case "DAY":		$t_actual_timestamp = mktime ( 0, 0, 0, date("m"), date('d')-$p_time_var, date('Y'));
							break;
			case "WEEK":	$firstDayInYear=date("N",mktime(0,0,0,1,1,date('Y')));
							if ($firstDayInYear<5)
								$shift=-($firstDayInYear-1)*86400;
							else
								$shift=(8-$firstDayInYear)*86400;
							$weekInSeconds=(date('W')-$t_time_var-1)*604800;
							$t_actual_timestamp=mktime(0,0,0,1,1,date('Y'))+$weekInSeconds+$shift;
							break;
			case "MONTH":	$t_actual_timestamp = mktime ( 0, 0, 0, date("m")-$p_time_var, 1, date('Y'));
							break;
			case "YEAR":	$t_actual_timestamp = mktime ( 0, 0, 0, 1, 1, date('Y')-$p_time_var);
							break;
			default:		$t_actual_timestamp = mktime ( 0, 0, 0, date("m"), date('d'), date('Y'));
							break;
		}
		$gm_array = array();
		$gm_query = xtc_db_query("SELECT count(orders_id) AS count FROM orders WHERE date_purchased >= '".date('Y-m-d H:i:s',$t_actual_timestamp)."' AND orders_status != '" . (int)gm_get_conf('GM_ORDER_STATUS_CANCEL_ID') . "'");
		$gm_array = xtc_db_fetch_array($gm_query);
		
		$t_orders_total = $t_orders_total + $gm_array['count'];
		
		return $t_orders_total;
	}
	
	function get_amount($p_time_unit, $p_time_var)
	{
		$t_time_unit = (string) $p_time_unit;
		$t_time_var = (int) $p_time_var;
		
		switch($t_time_unit){
			case "DAY":		$t_actual_timestamp = mktime ( 0, 0, 0, date("m"), date('d')-$p_time_var, date('Y'));
							break;
			case "WEEK":	$firstDayInYear=date("N",mktime(0,0,0,1,1,date('Y')));
							if ($firstDayInYear<5)
								$shift=-($firstDayInYear-1)*86400;
							else
								$shift=(8-$firstDayInYear)*86400;
							$weekInSeconds=(date('W')-$t_time_var-1)*604800;
							$t_actual_timestamp=mktime(0,0,0,1,1,date('Y'))+$weekInSeconds+$shift;
							break;
			case "MONTH":	$t_actual_timestamp = mktime ( 0, 0, 0, date("m")-$p_time_var, 1, date('Y'));
							break;
			case "YEAR":	$t_actual_timestamp = mktime ( 0, 0, 0, 1, 1, date('Y')-$p_time_var);
							break;
			default:		$t_actual_timestamp = mktime ( 0, 0, 0, date("m"), date('d'), date('Y'));
							break;
		}
		$gm_array = array();
		$gm_query = xtc_db_query("SELECT SUM(orders_total.value / orders.currency_value) AS SUMME FROM orders_total, orders WHERE orders.orders_id = orders_total.orders_id AND orders_total.class='ot_total' AND orders.date_purchased >= '".date('Y-m-d H:i:s',$t_actual_timestamp)."'");
		$gm_array = xtc_db_fetch_array($gm_query);
		
		$t_amount = substr($gm_array['SUMME'], 0, -6);
		
		if($t_amount == ""){
			$t_amount = 0;
		}
		
		return $t_amount;
	}
	
	function get_low_products_quantity_count()
	{
		$t_low_products_quantity_count = 0;
		
		$gm_array1 = array();
		$gm_query1 = xtc_db_query("SELECT count(products_id) AS count FROM products WHERE products_quantity <= '5'");
		$gm_array1 = xtc_db_fetch_array($gm_query1);
		
		$gm_array2 = array();
		$gm_query2 = xtc_db_query("SELECT count(specials_id) AS count FROM specials WHERE specials_quantity <= '5'");
		$gm_array2 = xtc_db_fetch_array($gm_query2);

		$t_low_products_quantity_count += $gm_array1['count'];
		$t_low_products_quantity_count += $gm_array2['count'];
		
		return $t_low_products_quantity_count;
	}
	
	function get_user_online_count($p_has_account)
	{
		$t_has_account = (boolean)$p_has_account;
		
		$t_visitor_count = 0;
		
		if($t_has_account)
		{
			$gm_query1 = xtc_db_query("SELECT count(customer_id) AS count FROM whos_online WHERE customer_id > 0 GROUP BY session_id, ip_address, customer_id");
			$t_visitor_count += mysql_num_rows($gm_query1);
		}else{

			$gm_query1 = xtc_db_query("SELECT count(customer_id) AS count FROM whos_online WHERE customer_id = 0 GROUP BY session_id, ip_address");
			$t_visitor_count += mysql_num_rows($gm_query1);
		}
		
		return $t_visitor_count;
	}
}
?>