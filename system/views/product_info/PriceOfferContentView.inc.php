<?php
/* --------------------------------------------------------------
   PriceOfferContentView.inc.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_navigator.php 1292 2005-10-07 16:10:55Z mz $) 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

// include needed functions
require_once(DIR_FS_CATALOG . 'gm/inc/gm_prepare_number.inc.php');
require_once(DIR_FS_INC . 'xtc_validate_email.inc.php');
require_once(DIR_FS_INC . 'xtc_random_charcode.inc.php');
require_once(DIR_FS_CATALOG . 'gm/classes/GMAttributesCalculator.php');

class PriceOfferContentView extends ContentView
{
	function PriceOfferContentView()
	{
		$this->set_content_template('module/gm_price_offer.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html()
	{
		$xtPrice = new xtcPrice($_SESSION['currency'], $_SESSION['customers_status']['customers_status_id']);
		$main = new main();
		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');

		$session_vvcode = $_SESSION['vvcode'];

		$visual_verify_code = xtc_random_charcode(6);
		$_SESSION['vvcode'] = $visual_verify_code;

		$products_id = (int)$_GET['products_id'];

		$product_data = xtc_db_query("SELECT 
										  pd.products_name,
										  pd.products_short_description,
										  p.products_image,
										  p.products_price,
										  p.products_tax_class_id
										FROM
											products_description pd,
											products p
										WHERE
											p.products_id = '" . (int)$products_id . "'
											AND pd.products_id = '" . (int)$products_id . "'
											AND pd.language_id = '" . (int)$_SESSION['languages_id'] . "'");
		if(xtc_db_num_rows($product_data) == 1){
			$product = xtc_db_fetch_array($product_data);

			$this->set_content_data('PRODUCT_NAME', $product['products_name']);
			$products_short_description = str_replace('<br />', " ", $product['products_short_description']);
			$products_short_description = str_replace('<br>', " ", $product['products_short_description']);
			$products_short_description = strip_tags($products_short_description);
			$this->set_content_data('PRODUCT_SHORT_DESCRIPTION', trim($products_short_description));

			if($product['products_image'] != '')	$image = DIR_WS_THUMBNAIL_IMAGES . $product['products_image'];
			$this->set_content_data('PRODUCT_IMAGE', $image);
			$this->set_content_data('PRODUCT_POPUP_LINK', 'javascript:popupWindow(\'' . xtc_href_link(FILENAME_POPUP_IMAGE, 'pID=' . $products_id.$connector . 'imgID=0') . '\')');

			$gmAttrCalc = new GMAttributesCalculator($products_id, $attributes, $product['products_tax_class_id']);
			$product_price =  $gmAttrCalc->calculate($products_data['products_qty'], true);

			// price incl tax
			$tax_rate = $xtPrice->TAX[$product['products_tax_class_id']];
			$tax_info = $main->getTaxInfo($tax_rate);
			$this->set_content_data('PRODUCTS_TAX_INFO', $tax_info);
			$this->set_content_data('PRODUCTS_SHIPPING_LINK', $main->getShippingLink(true));

			if(!empty($products_id)){
				$attributes_price = array();
				$attributes_name = '';
				if(is_array($_GET['id'])){
					foreach($_GET['id'] as $key => $unit) {
					$attributes[] = array('option' => (int)$key,
										  'value' => (int)$unit);

						$get_attributes = mysql_query("SELECT 
															pa.options_values_price, 
															pa.price_prefix,
															po.products_options_name,
															pov.products_options_values_name 
														FROM 
															products_attributes pa,
															products_options po,
															products_options_values pov
														WHERE 
															pa.products_id = '" . (int)$products_id . "'
															AND pa.options_id = '" . (int)$key . "'
															AND pa.options_values_id = '" . (int)$unit . "'
															AND pa.options_id = po.products_options_id
															AND pov.products_options_values_id = pa.options_values_id
															AND pov.language_id = '" . (int)$_SESSION['languages_id'] . "'
															AND po.language_id = '" . (int)$_SESSION['languages_id'] . "'");
						while($row = xtc_db_fetch_array($get_attributes)){
							$attributes_price[] = round(($row['price_prefix'] . $row['options_values_price']) * (1 + ($tax_rate / 100)), 2);
							$attributes_name .= $row['products_options_name'] . ": " . $row['products_options_values_name'] . "<br />";
						}		
					}
				}
				$this->set_content_data('ATTRIBUTES', $attributes_name);
			}

			if(isset($_POST['name']) 
				&& (	
							(	empty($_POST['name']) 
								|| empty($_POST['email']) 
								|| empty($_POST['link'])
							)
						|| 
							( strtoupper($_POST['vvcode']) != $session_vvcode 
								&& gm_get_conf('GM_PRICE_OFFER_VVCODE') == 'true'
							)
						)
				){
				if(strtoupper($_POST['vvcode']) != $session_vvcode && gm_get_conf('GM_PRICE_OFFER_VVCODE') == 'true'){
					$this->set_content_data('VVCODE_ERROR', GM_PRICE_OFFER_WRONG_CODE);
				}
				if(empty($_POST['name']) || empty($_POST['email']) || empty($_POST['link'])){
					$this->set_content_data('ERROR', GM_PRICE_OFFER_ERROR);
				}
				$this->set_content_data('INPUT_NAME', htmlentities_wrapper($_POST['name']));
				$this->set_content_data('INPUT_EMAIL', htmlentities_wrapper($_POST['email']));
				$this->set_content_data('INPUT_TELEPHONE',htmlentities_wrapper( $_POST['telephone']));
				$this->set_content_data('INPUT_PRICE', htmlentities_wrapper($_POST['price']));
				$this->set_content_data('INPUT_OFFERER', htmlentities_wrapper($_POST['offerer']));
				$this->set_content_data('INPUT_LINK', htmlentities_wrapper($_POST['link']));
				$this->set_content_data('INPUT_MESSAGE', htmlentities_wrapper($_POST['message']));

			}

			elseif(isset($_POST['name'])){

				/* bof gm SEO */
				if($coo_seo_boost->boost_products) {
					$gm_product_link = xtc_href_link($coo_seo_boost->get_boosted_product_url($products_id, $product['products_name']));
				} else {
					$gm_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products_id, $product['products_name']));
				}
				/* eof gm SEO */

				$message = gm_prepare_string($_POST['message']);

				$text = GM_PRICE_OFFER_MAIL_CUSTOMER . $_POST['name']
							. "\n". GM_PRICE_OFFER_MAIL_EMAIL . $_POST['email']
							. "\n" . GM_PRICE_OFFER_MAIL_TELEPHONE . $_POST['telephone']
							. "\n\n" . $product['products_name'] . " (" . trim(strip_tags($product_price)) . "): " . $gm_product_link
							. "\n" . str_replace("<br />", "\n", $attributes_name)
							. "\n\n" . GM_PRICE_OFFER_MAIL_LINK . ' ' . $_POST['link']
							. "\n" . GM_PRICE_OFFER_MAIL_PRICE . ' ' . $_POST['price']
							. "\n" . GM_PRICE_OFFER_MAIL_OFFERER . ' ' . $_POST['offerer']
							. "\n\n" . GM_PRICE_OFFER_MAIL_MESSAGE . "\n" . $message;

				// send mail
				xtc_php_mail($_POST['email'], $_POST['name'], STORE_OWNER_EMAIL_ADDRESS, STORE_NAME, '', $_POST['email'], $_POST['name'], '', '', GM_PRICE_OFFER_MAIL_SUBJECT . $product['products_name'], nl2br(htmlentities_wrapper($text)), $text);	
				$this->set_content_data('MAIL_OUT', GM_PRICE_OFFER_MAIL_OUT);
			}
		}

		$this->set_content_data('PRICE_OFFER_TITLE', GM_PRICE_OFFER_TITLE);
		$this->set_content_data('TEXT', GM_PRICE_OFFER_TEXT);
		$this->set_content_data('OUR_PRICE', GM_PRICE_OFFER_OUR_PRICE);
		$this->set_content_data('NECESSARY_INFO', GM_PRICE_OFFER_NECESSARY_INFO);
		$this->set_content_data('NAME', GM_PRICE_OFFER_NAME);
		$this->set_content_data('INPUT_NAME', $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name']);
		$this->set_content_data('EMAIL', GM_PRICE_OFFER_EMAIL);
		$this->set_content_data('TELEPHONE', GM_PRICE_OFFER_TELEPHONE);
		$this->set_content_data('PRICE', GM_PRICE_OFFER_PRICE);
		$this->set_content_data('OFFERER', GM_PRICE_OFFER_OFFERER);
		$this->set_content_data('LINK', GM_PRICE_OFFER_LINK);
		$this->set_content_data('MESSAGE', GM_PRICE_OFFER_MESSAGE);
		
		$this->set_content_data('GM_CREATE_VVCODES', xtc_href_link('gm_create_vvcodes.php', '', 'SSL', true));
		$this->set_content_data('VALIDATION_ACTIVE', gm_get_conf('GM_PRICE_OFFER_VVCODE'));
		$this->set_content_data('VALIDATION', GM_PRICE_OFFER_VALIDATION);
		$this->set_content_data('SID', xtc_session_id());

		$get_params = '';
		foreach($_GET as $key => $unit) {
			if(is_array($unit)){
				foreach($unit as $key2 => $unit2) {
					$get_params .= htmlspecialchars_wrapper($key) . rawurlencode('[') . htmlspecialchars_wrapper($key2) . rawurlencode(']') . '=' . htmlspecialchars_wrapper($unit2) . '&';
				}
			}
			else $get_params.= htmlspecialchars_wrapper($key) . '=' . htmlspecialchars_wrapper($unit) . '&';
		}
		$get_params = substr($get_params, 0, -1);

		$this->set_content_data('FORM_ACTION', xtc_draw_form('gm_price_offer', xtc_href_link('gm_price_offer.php', $get_params, 'NONSSL', true, true, true), 'post', ''), 1);
		$this->set_content_data('FORM_ID', 'gm_price_offer');
		$this->set_content_data('FORM_ACTION_URL', xtc_href_link('gm_price_offer.php', $get_params, 'NONSSL', true, true, true));
		$this->set_content_data('FORM_METHOD', 'post');

		if($gmSEOBoost->boost_products)
		{
			$t_product_link = xtc_href_link($gmSEOBoost->get_boosted_product_url($products_id, $product['products_name']) );
		}
		else
		{
			$t_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($products_id, $product['products_name']));
		}

		$this->set_content_data('BUTTON_BACK', '<a href="product_info.php?products_id='.$products_id.'">'.xtc_image_button('button_back.gif',IMAGE_BUTTON_BACK).'</a>', 1);
		$this->set_content_data('BUTTON_BACK_LINK', $t_product_link);
		$this->set_content_data('BUTTON_SUBMIT', xtc_image_submit('button_send.gif', IMAGE_BUTTON_CONTINUE));
		$this->set_content_data('FORM_END', '</form>', 1);
		$this->set_content_data('PRODUCT_PRICE', $product_price);
		$this->set_content_data('language', $_SESSION['language'], 1);

		/* BOF GM PRIVACY LINK */	
		$this->set_content_data('GM_PRIVACY_LINK', gm_get_privacy_link('GM_CHECK_PRIVACY_FOUND_CHEAPER')); 
		/* EOF GM PRIVACY LINK */

		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}

?>