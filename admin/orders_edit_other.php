<?php
/* --------------------------------------------------------------
   orders_edit_other.php 2009-04-24 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: orders_edit.php,v 1.0

   XTC-Bestellbearbeitung:
   http://www.xtc-webservice.de / Matthias Hinsche
   info@xtc-webservice.de

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com 
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders.php,v 1.27 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (orders.php,v 1.7 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 

   To do: Erweitern auf Artikelmerkmale, Rabatte und Gutscheine
   --------------------------------------------------------------*/
?>

<!-- Sprachen Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" colspan="3"><b><?php echo TEXT_LANGUAGE; ?></b></td>
</tr>

<?php
  echo xtc_draw_form('lang_edit', FILENAME_ORDERS_EDIT, 'action=lang_edit', 'post'); 
  
 $lang_query = xtc_db_query("select languages_id, name, directory from " . TABLE_LANGUAGES . " ");
  while($lang = xtc_db_fetch_array($lang_query)){

?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left" width="30%"><?php echo $lang['name'];?></td>
<td class="dataTableContent" align="left" width="30%">
<?php
if ($lang['directory']==$order->info['language']){
 echo xtc_draw_radio_field('lang', $lang['languages_id'], 'checked');
}else{
 echo xtc_draw_radio_field('lang', $lang['languages_id']);	
}	
?>
</td>
<td class="dataTableContent" align="left">&nbsp;</td>
</tr>
<?php } ?>

<tr class="dataTableRow">
<td class="dataTableContent" align="left" colspan="3">
<?php
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?></td>
</tr>

</form>
</table>

<!-- Sprachen Ende //-->


<br /><br />


<!-- W�hrungen Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" colspan="3"><b><?php echo TEXT_CURRENCIES; ?></b></td>
</tr>

<?php
  echo xtc_draw_form('curr_edit', FILENAME_ORDERS_EDIT, 'action=curr_edit', 'post'); 
  
 $curr_query = xtc_db_query("select currencies_id, title, code, value from " . TABLE_CURRENCIES . " ");
  while($curr = xtc_db_fetch_array($curr_query)){

?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left" width="30%"><?php echo $curr['title'];?></td>
<td class="dataTableContent" align="left" width="30%">
<?php
if ($curr['code']==$order->info['currency']){
 echo xtc_draw_radio_field('currencies_id', $curr['currencies_id'], 'checked');
}else{
 echo xtc_draw_radio_field('currencies_id', $curr['currencies_id']);	
}	
?>
</td>
<td class="dataTableContent" align="left">&nbsp;</td>
</tr>
<?php } ?>

<tr class="dataTableRow">
<td class="dataTableContent" align="left" colspan="3">
<?php
echo xtc_draw_hidden_field('old_currency', $order->info['currency']);
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?></td>
</tr>

</form>
</table>

<!-- W�hrungen Ende //-->


<br /><br />


<!-- Zahlung Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" colspan="4"><b><?php echo TEXT_PAYMENT; ?></td>
</tr>

<?php
  $payments = explode(';', MODULE_PAYMENT_INSTALLED);
  for ($i=0; $i<count($payments); $i++){
  
  require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/' . $payments[$i]);	
  
  $payment = substr($payments[$i], 0, strrpos($payments[$i], '.'));	
  $payment_text = constant(MODULE_PAYMENT_.strtoupper($payment)._TEXT_TITLE);
  
  $payment_array[] = array('id' => $payment,
                           'text' => $payment_text);
  }
  
  $order_payment = $order->info['payment_class'];
  
  require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/payment/' . $order_payment .'.php');	
  $order_payment_text = constant(MODULE_PAYMENT_.strtoupper($order_payment)._TEXT_TITLE);  
  
echo xtc_draw_form('payment_edit', FILENAME_ORDERS_EDIT, 'action=payment_edit', 'post');
?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left" width="30%">
<?php
echo TEXT_ACTUAL . $order_payment_text;
?></td>
<td class="dataTableContent" align="left" width="30%">
<?php
echo TEXT_NEW . xtc_draw_pull_down_menu('payment', $payment_array);
?></td>
<td class="dataTableContent" align="left">
<?php
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?></td>
</tr>


</form>
</table>

<!-- Zahlung Ende //-->


<br /><br />


<!-- Versand Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" colspan="4"><b><?php echo TEXT_SHIPPING; ?></td>
</tr>

<?php
  $shippings = explode(';', MODULE_SHIPPING_INSTALLED);
  for ($i=0; $i<count($shippings); $i++){
  
  if (isset($shippings[$i]) && is_file(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $shippings[$i])) {
  require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $shippings[$i]);	
  
  $shipping = substr($shippings[$i], 0, strrpos($shippings[$i], '.'));	
  $shipping_text = constant(MODULE_SHIPPING_.strtoupper($shipping)._TEXT_TITLE);
  
  $shipping_array[] = array('id' => $shipping,
                            'text' => $shipping_text);
  }
  }
  
  $order_shipping = explode('_', $order->info['shipping_class']);
  $order_shipping = $order_shipping[0];
  if (is_file(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $order_shipping .'.php')) {
  require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/shipping/' . $order_shipping .'.php');	
  $order_shipping_text = constant(MODULE_SHIPPING_.strtoupper($order_shipping)._TEXT_TITLE);  
  }
  
echo xtc_draw_form('shipping_edit', FILENAME_ORDERS_EDIT, 'action=shipping_edit', 'post');
?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left" width="30%">
<?php
echo TEXT_ACTUAL . $order_shipping_text;
?></td>
<td class="dataTableContent" align="left" width="30%">
<?php
echo TEXT_NEW . xtc_draw_pull_down_menu('shipping', $shipping_array);
?></td>
<td class="dataTableContent" align="left">
<?php
$order_total_query = xtc_db_query("select value from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_GET['oID'] . "' and class = 'ot_shipping' ");
$order_total = xtc_db_fetch_array($order_total_query);
echo TEXT_PRICE . ': ' . xtc_draw_input_field('value', $order_total['value']); // BOF GM_MOD EOF
?>
</td>
<td class="dataTableContent" align="left">
<?php
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?></td>
</tr>


</form>
</table>

<!-- Versand Ende //-->


<br /><br />


<!-- OT Module Anfang //-->

<table border="0" width="100%" cellspacing="0" cellpadding="2">
<tr class="dataTableHeadingRow">
<td class="dataTableHeadingContent" colspan="5"><b><?php echo TEXT_ORDER_TOTAL; ?></b></td>
</tr>


<?php
  $totals = explode(';', MODULE_ORDER_TOTAL_INSTALLED);
  for ($i=0; $i<count($totals); $i++){
  
  require(DIR_FS_LANGUAGES . $order->info['language'] . '/modules/order_total/' . $totals[$i]);	
  
  $total = substr($totals[$i], 0, strrpos($totals[$i], '.'));
  $total_name = str_replace('ot_','',$total);  
  $total_text = constant(MODULE_ORDER_TOTAL_.strtoupper($total_name)._TITLE);
  
   $ototal_query = xtc_db_query("select orders_total_id, title, value, class from " . TABLE_ORDERS_TOTAL . " where orders_id = '" . $_GET['oID'] . "' and class = '" . $total . "' ");
	// BOF GM_MOD
	while($ototal = xtc_db_fetch_array($ototal_query)){  
	// EOF GM_MOD
	
//if (($total != 'ot_subtotal')&&($total != 'ot_subtotal_no_tax')&&($total != 'ot_total')&&($total != 'ot_tax')){  
//if ($total != 'ot_shipping'){  

  echo xtc_draw_form('ot_edit', FILENAME_ORDERS_EDIT, 'action=ot_edit', 'post');   
?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left"><?php echo $total_text; ?></td>
<td class="dataTableContent" align="left"><?php echo xtc_draw_input_field('title', $ototal['title'], 'size=20'); ?></td>
<td class="dataTableContent" align="left"><?php echo xtc_draw_input_field('value', $ototal['value']); ?></td>
<td class="dataTableContent" align="left">
<?php
echo xtc_draw_hidden_field('class', $total);
echo xtc_draw_hidden_field('sort_order', constant(MODULE_ORDER_TOTAL_.strtoupper($total_name)._SORT_ORDER));
echo xtc_draw_hidden_field('oID', $_GET['oID']);
// BOF GM_MOD:
echo xtc_draw_hidden_field('otID', $ototal['orders_total_id']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?>
</form>
</td>
<td>
<?php
echo xtc_draw_form('ot_delete', FILENAME_ORDERS_EDIT, 'action=ot_delete', 'post');
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo xtc_draw_hidden_field('otID', $ototal['orders_total_id']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>';
?>
</form>
</td>
</tr>

<?php 
 }
 if(xtc_db_num_rows($ototal_query) == 0){
 	  echo xtc_draw_form('ot_edit', FILENAME_ORDERS_EDIT, 'action=ot_edit', 'post');   
?>
<tr class="dataTableRow">
<td class="dataTableContent" align="left"><?php echo $total_text; ?></td>
<td class="dataTableContent" align="left"><?php echo xtc_draw_input_field('title', $ototal['title'], 'size=20'); ?></td>
<td class="dataTableContent" align="left"><?php echo xtc_draw_input_field('value', $ototal['value']); ?></td>
<td class="dataTableContent" align="left">
<?php
echo xtc_draw_hidden_field('class', $total);
echo xtc_draw_hidden_field('sort_order', constant(MODULE_ORDER_TOTAL_.strtoupper($total_name)._SORT_ORDER));
echo xtc_draw_hidden_field('oID', $_GET['oID']);
// BOF GM_MOD:
echo xtc_draw_hidden_field('otID', $ototal['orders_total_id']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>';
?>
</form>
</td>
<td>
<?php
echo xtc_draw_form('ot_delete', FILENAME_ORDERS_EDIT, 'action=ot_delete', 'post');
echo xtc_draw_hidden_field('oID', $_GET['oID']);
echo xtc_draw_hidden_field('otID', $ototal['orders_total_id']);
echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/>';
?>
</form>
</td>
</tr>
<?php
 }
 unset($ototal);
}
?>


</table>