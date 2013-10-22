<?php
/* --------------------------------------------------------------
   RecreateOrder.php 2012-04-19 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

require_once(DIR_FS_INC.'xtc_format_price_order.inc.php');
require_once(DIR_FS_CATALOG.'gm/inc/gm_prepare_number.inc.php');
require_once(DIR_FS_CATALOG.'gm/inc/gm_save_order.inc.php');
require_once(DIR_FS_INC.'xtc_get_attributes_model.inc.php');
	
class RecreateOrder
{
	/**
	 * @var int order id
	 */
	var $v_order_id = 0;
	
	/**
	 * @var string html of the order
	 */
	var $v_html = '';
	
	/**
     * constructor
	 * 
	 * check order exists
	 * 
	 * @access public
	 * @param int $p_orders_id order id
	 * @return bool OK:true | ERROR:false
     */
    function RecreateOrder($p_orders_id)
    {
		// manage params
		$this->v_order_id = (int)$p_orders_id;
		
		// get send order status and orders id
		$t_query = xtc_db_query("
								SELECT
									gm_send_order_status,
									orders_id
								FROM " .
									TABLE_ORDERS . "
								WHERE
									orders_id= '" . $this->v_order_id . "'
								LIMIT 1
		");

		// if order status exists
		if(xtc_db_num_rows($t_query) <= 0) {
			return false;
		}
		
		$t_order_status = xtc_db_fetch_array($t_query);
		$this->createOrder($t_order_status);
		
		return true;
    }
	
	/**
	 * create the order
	 * 
	 * @access private
	 * @return bool OK:true | Error:false
	 */
	function createOrder($t_row)
	{
		// recreate order
		$smarty = new Smarty;

		$t_order = new order($t_row['orders_id']);

		$t_order_query = xtc_db_query("
									SELECT
										products_id,
										orders_products_id,
										products_model,
										products_name,
										final_price,
										products_quantity
									FROM " .
										TABLE_ORDERS_PRODUCTS . "
									WHERE
										orders_id= '" . (int)$t_row['orders_id'] . "'
		");

		$t_order_data = array();

		while ($t_order_data_values = xtc_db_fetch_array($t_order_query)) {
			$t_attributes_query = xtc_db_query("
												SELECT
													products_options,
													products_options_values,
													price_prefix,
													options_values_price
												FROM " .
													TABLE_ORDERS_PRODUCTS_ATTRIBUTES . "
												WHERE
													orders_products_id	= '" . $t_order_data_values['orders_products_id']	. "'
												AND
													orders_id			= '" . (int)$t_row['orders_id']							. "'
			");

			$t_attributes_data	= '';
			$t_attributes_model	= '';

			while($t_attributes_data_values = xtc_db_fetch_array($t_attributes_query)) {
				$t_attributes_data	.= '<br />' . $t_attributes_data_values['products_options'] . ':' . $t_attributes_data_values['products_options_values'];
				$t_attributes_model	.= '<br />' . xtc_get_attributes_model(
																			$t_order_data_values['products_id'],
																			$t_attributes_data_values['products_options_values'],
																			$t_attributes_data_values['products_options']
																		);
			}

			// BOF GM_MOD GX-Customizer:
			require(DIR_FS_CATALOG . 'gm/modules/gm_gprint_admin_gm_send_order.php');

			$t_order_data[] = array(
				'PRODUCTS_MODEL'			=> $t_order_data_values['products_model'],
				'PRODUCTS_NAME'				=> $t_order_data_values['products_name'],
				'PRODUCTS_ATTRIBUTES'		=> $t_attributes_data,
				'PRODUCTS_ATTRIBUTES_MODEL' => $t_attributes_model,
				'PRODUCTS_SINGLE_PRICE'		=> xtc_format_price_order(
																		$t_order_data_values['final_price']/$t_order_data_values['products_quantity'],
																		1,
																		$t_order->info['currency']
											),
				'PRODUCTS_PRICE'			=> xtc_format_price_order(
																		$t_order_data_values['final_price'],
																		1,
																		$t_order->info['currency']
											),
				'PRODUCTS_QTY'				=> gm_prepare_number($t_order_data_values['products_quantity'], ',')
			);
		}

		$t_oder_total_query=xtc_db_query("
										SELECT
											title,
											text,
											class,
											value,
											sort_order
										FROM " .
											TABLE_ORDERS_TOTAL . "
										WHERE
											orders_id = '" . (int)$t_row['orders_id'] . "'
										ORDER BY
											sort_order
										ASC
		");

		$t_order_total = array();

		while ($t_oder_total_values = xtc_db_fetch_array($t_oder_total_query)) {
			$t_order_total[] = array(
				'TITLE'		=> $t_oder_total_values['title'],
				'CLASS'		=> $t_oder_total_values['class'],
				'VALUE'		=> $t_oder_total_values['value'],
				'TEXT'		=> $t_oder_total_values['text']
			);

			if($t_oder_total_values['class'] = 'ot_total') {
				$total = $t_oder_total_values['value'];
			}
		}


		if ($t_order->info['payment_method'] != '' && $t_order->info['payment_method']!= 'no_payment') {
			include(DIR_FS_CATALOG . 'lang/' . $_SESSION['language'] . '/modules/payment/' . $t_order->info['payment_method'] . '.php');
			$payment_method=constant(strtoupper('MODULE_PAYMENT_'.$t_order->info['payment_method'].'_TEXT_TITLE'));
			$smarty->assign('PAYMENT_METHOD',$payment_method);
			$smarty->assign('PAYMENT_MODUL', $t_order->info['payment_method']);
		}

		$smarty->assign('language',					$_SESSION['language']);
		$smarty->assign('csID',						$t_order->customer['csID']);
		$smarty->assign('oID',						$t_row['orders_id']);
		$smarty->assign('COMMENTS',					$t_order->info['comments']);
		$smarty->assign('DATE',						xtc_date_long($t_order->info['date_purchased']));
		$smarty->assign('NAME',						$t_order->customer['name']);
		$smarty->assign('COMMENTS',					$t_order->info['comments']);
		$smarty->assign('EMAIL',					$t_order->customer['email_address']);
		$smarty->assign('PHONE',					$t_order->customer['telephone']);
		$smarty->assign('order_data',				$t_order_data);
		$smarty->assign('order_total',				$t_order_total);
		$smarty->assign('address_label_customer',	xtc_address_format($t_order->customer['format_id'],	$t_order->customer, 1,	'', '<br />'));
		$smarty->assign('address_label_shipping',	xtc_address_format($t_order->delivery['format_id'],	$t_order->delivery, 1,	'', '<br />'));
		$smarty->assign('address_label_payment',	xtc_address_format($t_order->billing['format_id'],	$t_order->billing, 1,	'', '<br />'));

		$smarty->caching		= false;
		$smarty->template_dir	= DIR_FS_CATALOG . 'templates';
		$smarty->compile_dir	= DIR_FS_CATALOG . 'templates_c';
		$smarty->config_dir		= DIR_FS_CATALOG . 'lang';

		// EU Bank Transfer
		if ($order->info['payment_method'] == 'eustandardtransfer')
		{
			$smarty->assign('PAYMENT_INFO_HTML',	MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION);
			$smarty->assign('PAYMENT_INFO_TXT',		str_replace("<br />", "\n", MODULE_PAYMENT_EUTRANSFER_TEXT_DESCRIPTION));
		}

		// MONEYORDER
		if ($order->info['payment_method'] == 'moneyorder')
		{
			$smarty->assign('PAYMENT_INFO_HTML',	MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION);
			$smarty->assign('PAYMENT_INFO_TXT',		str_replace("<br />", "\n", MODULE_PAYMENT_MONEYORDER_TEXT_DESCRIPTION));
		}

		/* MAIL LOGO */
		$t_logo_mail = MainFactory::create_object('GMLogoManager', array("gm_logo_mail"));
		if($t_logo_mail->logo_use == '1') {
			$smarty->assign('gm_logo_mail', $t_logo_mail->get_logo());
		}

		//$smarty->display(CURRENT_TEMPLATE.'/mail/'.$_SESSION['language'].'/order_mail.html');
		$this->v_html = $smarty->fetch(CURRENT_TEMPLATE.'/mail/' . $_SESSION['language'] . '/order_mail.html');
		$t_txt	= $smarty->fetch(CURRENT_TEMPLATE.'/mail/' . $_SESSION['language'] . '/order_mail.txt');

		/* save order to DB */
		gm_save_order($t_row['orders_id'], $this->v_html, $t_txt, $t_row['gm_send_order_status']);

		return true;
	}
	
	/**
	 * get html of the order
	 * 
	 * @access public
	 * @return string $this->v_html html of the order
	 */
	function getHtml()
	{
		return $this->v_html;
	}
}
?>