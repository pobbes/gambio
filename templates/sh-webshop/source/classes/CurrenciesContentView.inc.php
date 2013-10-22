<?php
/* --------------------------------------------------------------
   CurrenciesContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
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

// include functions
require_once(DIR_FS_INC . 'xtc_hide_session_id.inc.php');

class CurrenciesContentView extends ContentView
{
	function CurrenciesContentView()
	{
		$this->set_content_template('boxes/box_currencies.html');
	}
	
	function get_html($p_request_type, $p_get_array)
	{
		$coo_xtc_price = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);

		#TODO: $p_get_array verursacht in dieser Funktion einen Fehler, wenn es leer ist. Darum Abbruch mit return.
		//	return;
		if(is_array($p_get_array) == false) return;

		$currencies_count = 0;
		$t_html_output = '';


		$t_hidden_get_variables = '';
		reset($p_get_array);
		$t_hidden_get_variables_array = array();
		$t_get_variables = '';
		
		while(list($t_key, $t_value) = each($p_get_array))
		{
			$c_key = htmlentities_wrapper($t_key);
			if(is_array($t_value) == false) $c_value = htmlentities_wrapper($t_value); else $c_value = $t_value;

			if(	$c_key != 'currency'
				&& $c_key != xtc_session_name()
				&& $c_key != 'x'
				&& $c_key != 'y' )
			{
				$t_hidden_get_variables .= xtc_draw_hidden_field($c_key, $c_value);
				$t_hidden_get_variables_array[] = array('KEY' => $c_key, 'VALUE' => $c_value);
				$t_get_variables .= '&' . htmlspecialchars_wrapper((string)$c_key) . '=' . htmlspecialchars_wrapper((string)$c_value);
			}
		}

        reset($coo_xtc_price->currencies);
		$t_currencies_array = array();
		while(list($t_key, $t_value) = each($coo_xtc_price->currencies))
		{
			$c_key = htmlentities_wrapper($t_key);
			$currencies_count++;
			$currencies_array[] = array('id' => $c_key,
										'text' => htmlentities_wrapper($t_value['title']),
										'link' => xtc_href_link(basename(gm_get_env_info('PHP_SELF')), 'currency=' . $c_key . $t_get_variables, $p_request_type));
		}		

		// dont show box if there's only 1 currency
		if($currencies_count > 1 )
		{
			$t_box_content = xtc_draw_form('currencies', xtc_href_link(basename(gm_get_env_info('PHP_SELF')), '', $p_request_type, false, true, true), 'get')
								. xtc_draw_pull_down_menu('currency', $currencies_array, $_SESSION['currency'], 'onchange="this.form.submit();" class="input-select lightbox_visibility_hidden"')
								. $t_hidden_get_variables . xtc_hide_session_id().'</form>';

			$this->set_content_data('FORM', $t_box_content, 1);
			$this->set_content_data('FORM_ID', 'currencies');
			$this->set_content_data('FORM_ACTION_URL', xtc_href_link(basename(gm_get_env_info('PHP_SELF')), '', $p_request_type, false, true, true));
			$this->set_content_data('FORM_METHOD', 'get');
			$this->set_content_data('hidden_get_variables_data', $t_hidden_get_variables_array);
			$this->set_content_data('SESSION_ID', xtc_session_id());
			$this->set_content_data('CURRENT_CURRENCY', $_SESSION['currency']);
			$this->set_content_data('currencies_data', $currencies_array);

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}
?>