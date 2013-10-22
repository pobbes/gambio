<?php
/* --------------------------------------------------------------
   TellAFriendContentView.inc.php 2010-10-06 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_navigator.php 1292 2005-10-07 16:10:55Z mz $) 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once (DIR_FS_INC.'xtc_validate_email.inc.php');
require_once (DIR_FS_INC.'xtc_random_charcode.inc.php');

class TellAFriendContentView extends ContentView
{
	function TellAFriendContentView()
	{
		$this->set_content_template('module/gm_tell_a_friend.html');
		$this->set_flat_assigns(true);
	}
	
	function get_html($p_products_id)
	{
		$c_products_id = (int)$p_products_id;

		$coo_seo_boost = MainFactory::create_object('GMSEOBoost');

		$session_vvcode = $_SESSION['vvcode'];

		$gm_get_product = xtc_db_query("SELECT products_name
										FROM products_description
										WHERE
											products_id = '" . $c_products_id . "'
											AND language_id = '" . (int)$_SESSION['languages_id'] . "'");
		if(xtc_db_num_rows($gm_get_product) == 1){
			$gm_product = xtc_db_fetch_array($gm_get_product);
			$this->set_content_data('PRODUCTS_NAME', $gm_product['products_name']);
			$this->set_content_data('SEND', xtc_image_button('button_send.gif', GM_TELL_A_FRIEND_SEND, 'id="gm_send_tell_a_friend" class="cursor_pointer" onclick="var tell_a_friend = new GMTellAFriend(); tell_a_friend.send_form();"'));

			if(!empty($_SESSION['customer_id'])){
				$get_customers_mail = xtc_db_query("SELECT customers_email_address
													FROM customers
													WHERE customers_id = '" . (int)$_SESSION['customer_id'] . "'");
				if(xtc_db_num_rows($get_customers_mail) == 1){
					$customer = xtc_db_fetch_array($get_customers_mail);

					$email = $customer['customers_email_address'];
					if(!empty($_POST['name'])) $sender = $_POST['name'];
					else $sender = STORE_NAME;
					$this->set_content_data('INPUT_NAME', $_SESSION['customer_first_name'] . ' ' . $_SESSION['customer_last_name']);
				}
			}
			else{
				$email = STORE_OWNER_EMAIL_ADDRESS;
				if(!empty($_POST['name'])) $sender = $_POST['name'];
				else $sender = STORE_NAME;
			}
			$this->set_content_data('IMG', 'templates/' . CURRENT_TEMPLATE . '/icons/anmerkungen.gif');
			$this->set_content_data('TELL_A_FRIEND_TITLE', GM_TELL_A_FRIEND_TITLE);
			$this->set_content_data('NAME', GM_TELL_A_FRIEND_SENDER);
			$this->set_content_data('EMAIL', GM_TELL_A_FRIEND_EMAIL);
			$this->set_content_data('MESSAGE', GM_TELL_A_FRIEND_MESSAGE);
			$this->set_content_data('INPUT_MESSAGE', GM_TELL_A_FRIEND_MESSAGE_INPUT);

			if(!empty($_POST) && ((strtoupper($_POST['vvcode']) == $session_vvcode && gm_get_conf('GM_TELL_A_FRIEND_VVCODE') == 'true') || gm_get_conf('GM_TELL_A_FRIEND_VVCODE') == 'false')){
				if(empty($_POST['email'])){
					$this->set_content_data('ERROR', GM_TELL_A_FRIEND_ERROR);
				}
				else{

					/* bof gm SEO */
					if($coo_seo_boost->boost_products) {
						$gm_product_link = xtc_href_link($coo_seo_boost->get_boosted_product_url($c_products_id, $gm_product['products_name']));
					} else {
						$gm_product_link = xtc_href_link(FILENAME_PRODUCT_INFO, xtc_product_link($c_products_id, $gm_product['products_name']));
					}
					/* eof gm SEO */

					$message = gm_prepare_string($_POST['message']);
					$message = str_replace('%u20AC', 'EUR', $message);
					$text = $sender . GM_TELL_A_FRIEND_RECOMMENDS_1 . '"' . STORE_NAME . '"' . GM_TELL_A_FRIEND_RECOMMENDS_2
									. "\n". $gm_product_link
									. "\n\n" . GM_TELL_A_FRIEND_MESSAGE . "\n" . $message;

					$text_html = htmlentities_wrapper($sender) . htmlentities_wrapper(GM_TELL_A_FRIEND_RECOMMENDS_1) . '"' . htmlentities_wrapper(STORE_NAME) . '"' . htmlentities_wrapper(GM_TELL_A_FRIEND_RECOMMENDS_2)
									. '<br /><a href="' . $gm_product_link . '" target="_blank">' . htmlentities_wrapper($gm_product_link) . '</a>'
									. '<br /><br />' . htmlentities_wrapper(GM_TELL_A_FRIEND_MESSAGE) . '<br />' . htmlentities_wrapper($message);

					// send mail
					xtc_php_mail($email, $sender, $_POST['email'], $_POST['email'], '', $email, $sender, '', '', GM_TELL_A_FRIEND_SUBJECT_1 . '"' . STORE_NAME . '"' . GM_TELL_A_FRIEND_SUBJECT_2, $text_html, html_entity_decode($text));
					$this->set_content_data('MAIL_OUT', GM_TELL_A_FRIEND_MAIL_OUT);
				}
			}
			elseif(!empty($_POST) && strtoupper($_POST['vvcode']) != $session_vvcode && gm_get_conf('GM_TELL_A_FRIEND_VVCODE') == 'true'){
				$this->set_content_data('VVCODE_ERROR', GM_TELL_A_FRIEND_WRONG_CODE);
			}

			$visual_verify_code = xtc_random_charcode(6);
			$_SESSION['vvcode'] = $visual_verify_code;

			$this->set_content_data('CREATE_VVCODES', xtc_href_link('gm_create_vvcodes.php', 'rand='.rand()));
			$this->set_content_data('VALIDATION_ACTIVE', gm_get_conf('GM_TELL_A_FRIEND_VVCODE'));
			$this->set_content_data('VALIDATION', GM_TELL_A_FRIEND_VALIDATION);

		}

		/* BOF GM PRIVACY LINK */
		$this->set_content_data('GM_PRIVACY_LINK', gm_get_privacy_link('GM_CHECK_PRIVACY_TELL_A_FRIEND'));
		/* EOF GM PRIVACY LINK */

		$t_html_output = $this->build_html();

		return $t_html_output;
	}
}

?>