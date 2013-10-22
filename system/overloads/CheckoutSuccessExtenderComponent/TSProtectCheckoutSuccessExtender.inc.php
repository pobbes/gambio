<?php
/* --------------------------------------------------------------
   TSProtectCheckoutSuccessExtender.inc.php 2012-01-16 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

class TSProtectCheckoutSuccessExtender extends TSProtectCheckoutSuccessExtender_parent
{
	function proceed()
	{
		parent::proceed();
		
		if( gm_is_valid_trusted_shop_id(gm_get_conf('TRUSTED_SHOP_ID')) == true
			&& isset($this->v_data_array['orders_id'])
			&& !empty($this->v_data_array['orders_id'])
			&& isset($this->v_data_array['coo_order'])
			&& is_object($this->v_data_array['coo_order']) )
		{
			$trusted_amount = round($this->v_data_array['coo_order']->info['pp_total'], 2);

			if($_SESSION['language'] == 1) {
				$trusted_block = '
					<table width=400 border="0" cellspacing="0" cellpadding="4">
					<tr>
						<td width="90">
							<form name="formSiegel" method="post" action="https://www.trustedshops.com/shop/certificate.php" target="_blank">
							<input type="image" border="0" src="images/trusted_siegel.gif" title="Trusted Shops seal of approval - Click to verify.">
							<input name="shop_id" type="hidden" value="'.gm_get_conf('TRUSTED_SHOP_ID').'">
							</form>
						</td>
						<td align="justify">
							<form id="formTShops" name="formTShops" method="post" action="https://www.trustedshops.com/shop/protection.php" target="_blank">
							<input name="_charset_" 	type=hidden>
							<input name="shop_id"	 		type=hidden value="'.gm_get_conf('TRUSTED_SHOP_ID').'">
							<input name="email" 			type=hidden value="'.$this->v_data_array['coo_order']->customer['email_address'].'">
							<input name="first_name" 	type=hidden value="'.$this->v_data_array['coo_order']->customer['firstname'].'">
							<input name="last_name" 	type=hidden value="'.$this->v_data_array['coo_order']->customer['lastname'].'">
							<input name="street" 			type=hidden value="'.$this->v_data_array['coo_order']->customer['street_address'].'">
							<input name="zip" 		type=hidden value="'.$this->v_data_array['coo_order']->customer['postcode'].'">
							<input name="city" 		type=hidden value="'.$this->v_data_array['coo_order']->customer['city'].'">
							<input name="country" type=hidden value="'.$this->v_data_array['coo_order']->customer['country'].'">
							<input name="phone" 	type=hidden value="'.$this->v_data_array['coo_order']->customer['telephone'].'">
							<input name="amount" 	type=hidden value="'.$trusted_amount	.'">
							<input name="curr" 		type=hidden value="'.$this->v_data_array['coo_order']->info['currency'].'">
							<input name="KDNR" 		type=hidden value="'.$this->v_data_array['coo_order']->customer['csID'].'">
							<input name="ORDERNR" type=hidden value="'.$this->v_data_array['orders_id'].'">

							<font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" color="#000000">
							As a Trusted Shops member, we offer the additional service
							of the buyer protection backed by the Atradius Insurance
							Group. We pay all costs for the guarantee. You only have to
							register!<br><br>
							</font>
							<input type="submit" id="btnProtect" name="btnProtect" value="Register for buyer protection...">
							</form>
						</td>
					</tr>
					</table>
				';
			}
			else
			{
				$trusted_block = '
					<table width=400 border="0" cellspacing="0" cellpadding="4">
					<tr>
						<td width="90">
							<form name="formSiegel" method="post" action="https://www.trustedshops.com/shop/certificate.php" target="_blank">
							<input type="image" border="0" src="images/trusted_siegel.gif" title="Trusted Shops G&uuml;tesiegel - Bitte hier klicken.">
							<input name="shop_id" type="hidden" value="'.gm_get_conf('TRUSTED_SHOP_ID').'">
							</form>
						</td>
						<td align="justify">
							<form id="formTShops" name="formTShops" method="post" action="https://www.trustedshops.com/shop/protection.php" target="_blank">
							<input name="_charset_" 	type=hidden>
							<input name="shop_id"	 		type=hidden value="'.gm_get_conf('TRUSTED_SHOP_ID').'">
							<input name="email" 			type=hidden value="'.$this->v_data_array['coo_order']->customer['email_address'].'">
							<input name="first_name" 	type=hidden value="'.$this->v_data_array['coo_order']->customer['firstname'].'">
							<input name="last_name" 	type=hidden value="'.$this->v_data_array['coo_order']->customer['lastname'].'">
							<input name="street" 			type=hidden value="'.$this->v_data_array['coo_order']->customer['street_address'].'">
							<input name="zip" 		type=hidden value="'.$this->v_data_array['coo_order']->customer['postcode'].'">
							<input name="city" 		type=hidden value="'.$this->v_data_array['coo_order']->customer['city'].'">
							<input name="country" type=hidden value="'.$this->v_data_array['coo_order']->customer['country'].'">
							<input name="phone" 	type=hidden value="'.$this->v_data_array['coo_order']->customer['telephone'].'">
							<input name="amount" 	type=hidden value="'.$trusted_amount	.'">
							<input name="curr" 		type=hidden value="'.$this->v_data_array['coo_order']->info['currency'].'">
							<input name="KDNR" 		type=hidden value="'.$this->v_data_array['coo_order']->customer['csID'].'">
							<input name="ORDERNR" type=hidden value="'.$this->v_data_array['orders_id'].'">

							<font size="2" face="Arial,Helvetica,Geneva,Swiss,SunSans-Regular" color="#000000">
							Als zus&auml;tzlichen Service bieten wir Ihnen den Trusted Shops K&auml;uferschutz an. 
							Wir &uuml;bernehmen alle Kosten dieser Garantie, Sie m&uuml;ssen sich lediglich
							anmelden.<br><br>
							</font>
							<input type="submit" id="btnProtect" name="btnProtect" value="Anmeldung zum Trusted Shops K&auml;uferschutz">
							</form>
						</td>
					</tr>
					</table>
				';
			}

			$this->v_output_buffer['TRUSTED_BLOCK'] = $trusted_block;
		}		
	}
}
?>