<?php
/* --------------------------------------------------------------
   AccountContentView.inc.php 2012-04-02
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project (earlier name of osCommerce)
   (c) 2002-2003 osCommerce (account.php,v 1.59 2003/05/19); www.oscommerce.com
   (c) 2003      nextcommerce (account.php,v 1.12 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: account.php 1124 2005-07-28 08:50:04Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_INC . 'xtc_count_customer_orders.inc.php');
require_once(DIR_FS_INC . 'xtc_date_short.inc.php');
require_once(DIR_FS_INC . 'xtc_date_long.inc.php');
require_once(DIR_FS_INC . 'xtc_get_path.inc.php');
require_once(DIR_FS_INC . 'xtc_get_product_path.inc.php');
require_once(DIR_FS_INC . 'xtc_get_products_name.inc.php');
require_once(DIR_FS_INC . 'xtc_get_products_image.inc.php');

class AccountContentView extends ContentView
{
	function AccountContentView()
	{
		$this->set_content_template('module/account.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_coo_messageStack, $p_coo_product, $p_post_action = false, $p_post_content = false)
	{
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');

		if($p_post_action == 'gm_delete_account') {
				$coo_smarty = new Smarty();

				$gm_customer_check = xtc_db_query("
													SELECT
														*
													FROM " .
														TABLE_CUSTOMERS . "
													WHERE
														customers_id = '" . $_SESSION['customer_id'] . "'
													");

				$gm_customer = xtc_db_fetch_array($gm_customer_check);

				$coo_smarty->assign('NOTIFY_COMMENTS', htmlentities_wrapper($p_post_content));
				$coo_smarty->assign('CUSTOMER', $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name'] . ' ' . $gm_customer['customers_email_address']);
				// bof gm
				$gm_logo_mail = MainFactory::create_object('GMLogoManager', array("gm_logo_mail"));
				if($gm_logo_mail->logo_use == '1') {
					$coo_smarty->assign('gm_logo_mail', $gm_logo_mail->get_logo());
				}
				// eof gm
				$html_mail	= $coo_smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/delete_account_mail.html');
				$txt_mail	= $coo_smarty->fetch(CURRENT_TEMPLATE.'/admin/mail/'.$_SESSION['language'].'/delete_account_mail.txt');

				// send mail to admin
				xtc_php_mail(EMAIL_SUPPORT_ADDRESS, EMAIL_SUPPORT_NAME, EMAIL_SUPPORT_ADDRESS, STORE_NAME, EMAIL_SUPPORT_FORWARDING_STRING, $gm_customer['customers_email_address'], $gm_customer['customers_firstname'] . ' ' . $gm_customer['customers_lastname'], '', '', GM_SUBJECT, $html_mail, $txt_mail);
				$error = false;
				$this->set_content_data('error_message',GM_SEND);
			}
		// eof

		if ($p_coo_messageStack->size('account') > 0)
			$this->set_content_data('error_message', $p_coo_messageStack->output('account'));

		$i = 0;
		$max = count($_SESSION['tracking']['products_history']);

		while ($i < $max) {
			$product_history_query = xtDBquery("select * from ".TABLE_PRODUCTS." p, ".TABLE_PRODUCTS_DESCRIPTION." pd where p.products_id=pd.products_id and pd.language_id='".(int) $_SESSION['languages_id']."' and p.products_status = '1' and p.products_id = '".$_SESSION['tracking']['products_history'][$i]."'");
			$history_product = xtc_db_fetch_array($product_history_query, true);
			$cpath = xtc_get_product_path($_SESSION['tracking']['products_history'][$i]);
			if ($history_product['products_status'] != 0) {

				/* bof gm */
				$gm_seo_cat = explode('_', $cpath);
				if($coo_seo_boost->boost_categories) {
					$gm_seo_cat_link = xtc_href_link($coo_seo_boost->get_boosted_category_url(end($gm_seo_cat), $_SESSION['languages_id']));
				} else {
					$gm_seo_cat_link = xtc_href_link(FILENAME_DEFAULT, xtc_category_link(end($gm_seo_cat)));
				}
				$history_product = array_merge($history_product,array('cat_url' => $gm_seo_cat_link));
				/* eof gm */

				$products_history[] = $p_coo_product->buildDataArray($history_product);
			}
			$i ++;
		}

		$order_content = '';
		if (xtc_count_customer_orders() > 0) {

			$orders_query = xtc_db_query("SELECT
												o.orders_id,
												o.date_purchased,
												o.delivery_name,
												o.delivery_country,
												o.billing_name,
												o.billing_country,
												ot.text as order_total,
												s.orders_status_name
											FROM
												" . TABLE_ORDERS . " o, 
												" . TABLE_ORDERS_TOTAL . " ot, 
												" . TABLE_ORDERS_STATUS . " s,
												" . TABLE_CUSTOMERS_INFO . " ci
											WHERE
												o.customers_id = '" . (int)$_SESSION['customer_id'] . "'
												AND o.orders_id = ot.orders_id
												AND ot.class = 'ot_total'
												AND o.orders_status = s.orders_status_id
												AND s.language_id = '" . (int)$_SESSION['languages_id'] . "'
												AND o.customers_id = ci.customers_info_id 
												AND o.date_purchased > ci.customers_info_date_account_created
											ORDER BY orders_id DESC
											LIMIT 2");

			while ($orders = xtc_db_fetch_array($orders_query)) {
				if (xtc_not_null($orders['delivery_name'])) {
					$order_name = $orders['delivery_name'];
					$order_country = $orders['delivery_country'];
				} else {
					$order_name = $orders['billing_name'];
					$order_country = $orders['billing_country'];
				}
				// BOF GM_MOD:
				$order_content[] = array ('ORDER_ID' => $orders['orders_id'],
											'ORDER_DATE' => xtc_date_short($orders['date_purchased']),
											'ORDER_STATUS' => $orders['orders_status_name'],
											'ORDER_TOTAL' => $orders['order_total'],
											'ORDER_LINK' => xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL'),
											'ORDER_BUTTON' => '<a href="'.xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL').'">'.xtc_image_button('small_view.gif', SMALL_IMAGE_BUTTON_VIEW).'</a>',
											'ORDER_BUTTON_LINK' => xtc_href_link(FILENAME_ACCOUNT_HISTORY_INFO, 'order_id='.$orders['orders_id'], 'SSL'),
											'downloads_data' => $this->get_download_by_orders_id($orders['orders_id']));

			}

		}

		// bof gm

		if($_SESSION['customers_status']['customers_status_id'] == DEFAULT_CUSTOMERS_STATUS_ID_GUEST){
			$this->set_content_data('NO_GUEST', 0);
		}
		else $this->set_content_data('NO_GUEST', 1);

		$this->set_content_data('LINK_DELETE_ACCOUNT', xtc_href_link('gm_account_delete.php', '', 'SSL'));

		$this->set_content_data('LINK_EDIT', xtc_href_link(FILENAME_ACCOUNT_EDIT, '', 'SSL'));
		$this->set_content_data('LINK_ADDRESS', xtc_href_link(FILENAME_ADDRESS_BOOK, '', 'SSL'));
		$this->set_content_data('LINK_PASSWORD', xtc_href_link(FILENAME_ACCOUNT_PASSWORD, '', 'SSL'));
		if (!isset ($_SESSION['customer_id']))
			$this->set_content_data('LINK_LOGIN', xtc_href_link(FILENAME_LOGIN, '', 'SSL'));
		$this->set_content_data('LINK_ORDERS', xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
		// BOF GM_MOD
		$gm_check_newsletter = xtc_db_query("SELECT box_status FROM gm_boxes WHERE box_name = 'newsletter' AND box_status = 1 AND template_name = '" . CURRENT_TEMPLATE . "' LIMIT 1");
		if(xtc_db_num_rows($gm_check_newsletter) == 1) $this->set_content_data('LINK_NEWSLETTER', xtc_href_link(FILENAME_NEWSLETTER, '', 'SSL'));
		// EOF GM_MOD
		$this->set_content_data('LINK_ALL', xtc_href_link(FILENAME_ACCOUNT_HISTORY, '', 'SSL'));
		$this->set_content_data('order_content', $order_content);
		$this->set_content_data('products_history', $products_history);
		// BOF GM_MOD:
		$this->set_content_data('TRUNCATE_PRODUCTS_NAME', gm_get_conf('TRUNCATE_PRODUCTS_NAME'));
		$this->set_content_data('also_purchased_history', $also_purchased_history);
		
		$t_html_output = $this->build_html();		

		return $t_html_output;
	}


	function get_download_by_orders_id($p_orders_id)
	{
		$c_orders_id = (int)$p_orders_id;

		$t_downloads_array = array();

		$t_sql = 'SELECT orders_status
					FROM ' . TABLE_ORDERS . '
					WHERE orders_id = "' . $c_orders_id . '"';
		$t_query = xtc_db_query($t_sql);
		if(xtc_db_num_rows($t_query))
		{
			$t_order_array = xtc_db_fetch_array($t_query);
			$t_order_status = $t_order_array['orders_status'];

			if($t_order_status >= DOWNLOAD_MIN_ORDERS_STATUS && $t_order_status != 99)
			{
				$t_sql = "SELECT
								date_format(o.date_purchased, '%Y-%m-%d') AS date_purchased_day,
								opd.download_maxdays,
								op.products_name,
								opd.orders_products_download_id,
								opd.orders_products_filename,
								opd.download_count,
								opd.download_maxdays
							FROM
								" . TABLE_ORDERS . " o,
								" . TABLE_ORDERS_PRODUCTS . " op,
								" . TABLE_ORDERS_PRODUCTS_DOWNLOAD . " opd
							WHERE
								o.customers_id = '" . (int)$_SESSION['customer_id'] . "' AND
								o.orders_id = '" . $c_orders_id  . "' AND
								o.orders_id = op.orders_id AND
								op.orders_products_id = opd.orders_products_id AND
								opd.orders_products_filename != ''";
				$t_query = xtc_db_query($t_sql);
				if(xtc_db_num_rows($t_query) > 0)
				{
					$i = 0;
					while($t_downloads_data_array = xtc_db_fetch_array($t_query))
					{
						list($t_year, $t_month, $t_day) = explode('-', $t_downloads_data_array['date_purchased_day']);
						$t_download_timestamp = mktime(23, 59, 59, $t_month, $t_day + $t_downloads_data_array['download_maxdays'], $t_year);
						$t_download_expiry = date('Y-m-d H:i:s', $t_download_timestamp);

						if(($t_downloads_data_array['download_count'] > 0)
								&& !empty($t_downloads_data_array['orders_products_filename'])
								&& file_exists(DIR_FS_DOWNLOAD . basename($t_downloads_data_array['orders_products_filename']))
								&& ($t_downloads_data_array['download_maxdays'] == 0 || $t_download_timestamp > time())
								&& $t_order_status >= DOWNLOAD_MIN_ORDERS_STATUS)
						{
							$t_downloads_array[$i]['LINK'] = xtc_href_link(FILENAME_DOWNLOAD, 'order=' . $c_orders_id . '&id=' . $t_downloads_data_array['orders_products_download_id']);
						}
						$t_downloads_array[$i]['PRODUCTS_NAME'] = $t_downloads_data_array['products_name'];
						$t_downloads_array[$i]['DATE'] = xtc_date_long($t_download_expiry);
						$t_downloads_array[$i]['DATE_SHORT'] = xtc_date_short($t_download_expiry);
						$t_downloads_array[$i]['COUNT'] = $t_downloads_data_array['download_count'];
						$i++;
					}
				}
			}
		}


		return $t_downloads_array;
	}
}
?>