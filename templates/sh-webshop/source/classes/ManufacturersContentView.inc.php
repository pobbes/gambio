<?php
/* --------------------------------------------------------------
   ManufacturersContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(manufacturers.php,v 1.18 2003/02/10); www.oscommerce.com
   (c) 2003	 nextcommerce (manufacturers.php,v 1.9 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: manufacturers.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed funtions
require_once (DIR_FS_INC.'xtc_hide_session_id.inc.php');
require_once (DIR_FS_INC.'xtc_draw_form.inc.php');
require_once (DIR_FS_INC.'xtc_draw_pull_down_menu.inc.php');

class ManufacturersContentView extends ContentView
{
	function ManufacturersContentView()
	{
		$this->set_content_template('boxes/box_manufacturers.html');
	}
	
	function get_html($p_manufacturers_id)
	{
		$t_sql = "SELECT DISTINCT
						m.manufacturers_id, 
						m.manufacturers_name 
					FROM 
						".TABLE_MANUFACTURERS." AS m, 
						".TABLE_PRODUCTS." AS p 
					WHERE m.manufacturers_id = p.manufacturers_id 
					ORDER BY m.manufacturers_name";
		$t_result = xtDBquery($t_sql);
		if(xtc_db_num_rows($t_result, true) <= MAX_DISPLAY_MANUFACTURERS_IN_A_LIST)
		{
			// Display a list
			$t_manufacturers_list = '';
			while($t_result_array = xtc_db_fetch_array($t_result, true))
			{
				$t_manufacturers_name = ((strlen($t_result_array['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($t_result_array['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $t_result_array['manufacturers_name']);
				if(isset($p_manufacturers_id) && ($p_manufacturers_id == $t_result_array['manufacturers_id']))
				{
					$t_manufacturers_name = '<strong>'.$t_manufacturers_name.'</strong>';
				}
				$t_manufacturers_list .= '<a href="' . xtc_href_link(FILENAME_DEFAULT, 'manufacturers_id=' . $t_result_array['manufacturers_id']) . '">' . $t_manufacturers_name . '</a><br />';
			}
			$t_box_content = $t_manufacturers_list;
		}
		else
		{
			// Display a drop-down
			$t_manufacturers_array = array();
			if(MAX_MANUFACTURERS_LIST < 2)
			{
				$t_manufacturers_array[] = array('id' => '', 'text' => PULL_DOWN_DEFAULT);
			}

			while($t_result_array = xtc_db_fetch_array($t_result, true))
			{
				$t_manufacturers_name = ((strlen($t_result_array['manufacturers_name']) > MAX_DISPLAY_MANUFACTURER_NAME_LEN) ? substr($t_result_array['manufacturers_name'], 0, MAX_DISPLAY_MANUFACTURER_NAME_LEN) . '..' : $t_result_array['manufacturers_name']);
				$t_manufacturers_array[] = array ('id' => $t_result_array['manufacturers_id'], 'text' => $t_manufacturers_name);
			}

			$t_box_content = xtc_draw_form('manufacturers', xtc_href_link(FILENAME_DEFAULT, '', 'NONSSL', false, true, true), 'get') . xtc_draw_pull_down_menu('manufacturers_id', $t_manufacturers_array, (int)$p_manufacturers_id, 'onchange="if(this.value!=\'\'){this.form.submit();}" size="'.MAX_MANUFACTURERS_LIST.'" class="lightbox_visibility_hidden input-select"') . xtc_hide_session_id() . '</form>';
		}
		
		$this->set_content_data('CONTENT', $t_box_content);

		$t_html_output = $this->build_html();
		
		return $t_html_output;
	}
}
?>