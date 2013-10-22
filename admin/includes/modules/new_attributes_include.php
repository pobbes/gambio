<?php
/* --------------------------------------------------------------
   new_attributes_include.php 2008-05-29 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(new_attributes_functions); www.oscommerce.com 
   (c) 2003	 nextcommerce (new_attributes_include.php,v 1.11 2003/08/21); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: new_attributes_include.php 901 2005-04-29 10:32:14Z novalis $)

   Released under the GNU General Public License 
   --------------------------------------------------------------
   Third Party contributions:
   New Attribute Manager v4b				Autor: Mike G | mp3man@internetwork.net | http://downloads.ephing.com

   Released under the GNU General Public License 
   --------------------------------------------------------------*/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
   // include needed functions

   require_once(DIR_FS_INC .'xtc_get_tax_rate.inc.php');
   require_once(DIR_FS_INC .'xtc_get_tax_class_id.inc.php');
   require(DIR_FS_CATALOG.DIR_WS_CLASSES . 'xtcPrice.php');
   $xtPrice = new xtcPrice(DEFAULT_CURRENCY,$_SESSION['customers_status']['customers_status_id']);
?>
	<?php
	// BOF GM_MOD	
	if(!empty($_POST['copy_product_id'])){
	?>
	<tr>
    <td class="main" colspan="8"><br /><font color="#1a8000"><strong><?php echo GM_COPY_SUCCESSFUL; ?></strong></font><br /><br /></td>
  </tr>
	<?php
	}	
	// EOF GM_MOD
	?>
<form action="<?php echo xtc_href_link("new_attributes.php"); ?>" method="post" name="SUBMIT_ATTRIBUTES" enctype="multipart/form-data"><input type="hidden" name="current_product_id" value="<?php echo $_POST['current_product_id']; ?>"><input type="hidden" name="action" value="change">
<?php
echo xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
  if ($cPath) echo '<input type="hidden" name="cPathID" value="' . $cPath . '">';

  require(DIR_WS_MODULES . 'new_attributes_functions.php');

  // Temp id for text input contribution.. I'll put them in a seperate array.
  $tempTextID = '1999043';

  // Lets get all of the possible options
  $query = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS." where products_options_id LIKE '%' AND language_id = '" . $_SESSION['languages_id'] . "'";
  $result = xtc_db_query($query);
  $matches = xtc_db_num_rows($result);

  if ($matches) {
    while ($line = xtc_db_fetch_array($result)) {
      $current_product_option_name = $line['products_options_name'];
      $current_product_option_id = $line['products_options_id'];
      // Print the Option Name
      echo "<TR class=\"dataTableHeadingRow\">";
      echo "<TD class=\"dataTableHeadingContent\"><B>" . $current_product_option_name . "</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".SORT_ORDER."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_MODEL."</B></TD>";
      // BOF GM_MOD:
      echo "<TD class=\"dataTableHeadingContent\"><B>EAN</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_STOCK."</B></TD>";
      // BOF GM_MOD
      echo "<TD class=\"dataTableHeadingContent\"><B>VPE</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_WEIGHT." - ".ATTR_PREFIXWEIGHT."</B></TD>";
      echo "<TD class=\"dataTableHeadingContent\"><B>".ATTR_PRICE." - ".ATTR_PREFIXPRICE."</B></TD>";
      // EOF GM_MOD

      echo "</TR>";

      // Find all of the Current Option's Available Values
      $query2 = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_VALUES_TO_PRODUCTS_OPTIONS." WHERE products_options_id = '" . $current_product_option_id . "' ORDER BY products_options_values_id DESC";
      $result2 = xtc_db_query($query2);
      $matches2 = xtc_db_num_rows($result2);

      if ($matches2) {
        $i = '0';
        while ($line = xtc_db_fetch_array($result2)) {
          $i++;
          $rowClass = rowClass($i);
          $current_value_id = $line['products_options_values_id'];
          $isSelected = checkAttribute($current_value_id, $_POST['current_product_id'], $current_product_option_id);
          if ($isSelected) {
            $CHECKED = ' CHECKED';
          } else {
            $CHECKED = '';
          }

          // BOF GM_MOD
          $gm_get_vpe = xtc_db_query("SELECT products_vpe_id, products_vpe_name FROM products_vpe WHERE language_id = '" . $_SESSION['languages_id'] . "'");
          $gm_vpe_data = array();
          while($gm_vpe = xtc_db_fetch_array($gm_get_vpe))
          {
          	$gm_vpe_data[] = array('ID' => $gm_vpe['products_vpe_id'], 'NAME' => $gm_vpe['products_vpe_name']);
          }
          // EOF GM_MOD
          
          $query3 = "SELECT * FROM ".TABLE_PRODUCTS_OPTIONS_VALUES." WHERE products_options_values_id = '" . $current_value_id . "' AND language_id = '" . $_SESSION['languages_id'] . "'";
          $result3 = xtc_db_query($query3);
          while($line = xtc_db_fetch_array($result3)) {
            $current_value_name = $line['products_options_values_name'];
            // Print the Current Value Name
			
			if(empty($CHECKED)) $disable = "disabled='true'";
			else $disable = '';
			
            echo "<TR class=\"" . $rowClass . "\">";
            echo "<TD class=\"main\">";
            echo "<input type=\"checkbox\" name=\"optionValues[]\" value=\"" . $current_value_id . "\"" . $CHECKED . ">&nbsp;&nbsp;" . $current_value_name . "&nbsp;&nbsp;";
            echo "</TD>";
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_sortorder\" value=\"" . $sortorder . "\" size=\"4\"></TD>";
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_model\" value=\"" . $attribute_value_model . "\" size=\"10\"></TD>";
			// BOF GM_MOD:
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_gm_ean\" value=\"" . $gm_attribute_ean . "\" size=\"10\"></TD>";
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_stock\" value=\"" . (double)$attribute_value_stock . "\" size=\"4\"></TD>";
            // BOF GM_MOD
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_vpe_value\" value=\"" . (double)$gm_attribute_vpe_value . "\" size=\"4\">";
            echo ' <select '.$disable.' name="' . $current_value_id . '_vpe_id">';
            if(empty($gm_attribute_vpe_id))
            {
            	$gm_selected = ' selected="selected"';
            }
            else
            {
            	$gm_selected = '';
            }
            echo '<option value="0"' . $gm_selected . '></option>';
            for($i = 0; $i < count($gm_vpe_data); $i++)
            {
            	if($gm_vpe_data[$i]['ID'] == $gm_attribute_vpe_id)
            	{
            		$gm_selected = ' selected="selected"';
            	}
            	else
            	{
            		$gm_selected = '';
            	}
            	echo '<option value="' . $gm_vpe_data[$i]['ID'] .  '"' . $gm_selected . '>' . $gm_vpe_data[$i]['NAME'] . '</option>';
            }
            echo '</select>';
			echo "</TD>";
            // EOF GM_MOD
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_weight\" value=\"" . $attribute_value_weight . "\" size=\"10\"> ";
            echo "<SELECT ".$disable." name=\"" . $current_value_id . "_weight_prefix\"><OPTION value=\"+\"" . $posCheck_weight . ">+<OPTION value=\"-\"" . $negCheck_weight . ">-</SELECT></TD>";

            // brutto Admin
            if (PRICE_IS_BRUTTO=='true'){
            $attribute_value_price_calculate = $xtPrice->xtcFormat(xtc_round($attribute_value_price*((100+(xtc_get_tax_rate(xtc_get_tax_class_id($_POST['current_product_id']))))/100),PRICE_PRECISION),false);
            } else {
            $attribute_value_price_calculate = xtc_round($attribute_value_price,PRICE_PRECISION);
            }
            echo "<TD class=\"main\" align=\"left\"><input ".$disable." type=\"text\" name=\"" . $current_value_id . "_price\" value=\"" . $attribute_value_price_calculate . "\" size=\"10\">";
            // brutto Admin
            if (PRICE_IS_BRUTTO=='true'){
             echo TEXT_NETTO .'<b>'.$xtPrice->xtcFormat(xtc_round($attribute_value_price,PRICE_PRECISION),true).'</b>  ';
            }

            echo " ";

              echo "<SELECT ".$disable." name=\"" . $current_value_id . "_prefix\"> <OPTION value=\"+\"" . $posCheck . ">+<OPTION value=\"-\"" . $negCheck . ">-</SELECT></TD>";



            echo "</TR>";
            // Download function start
            if(strtoupper($current_product_option_name) == 'DOWNLOADS') {
                echo "<tr>";

               // echo "<td colspan=\"2\">File: <input type=\"file\" name=\"" . $current_value_id . "_download_file\"></td>";
                echo "<td colspan=\"2\">".xtc_draw_pull_down_menu($current_value_id . '_download_file', xtc_getDownloads(), $attribute_value_download_filename, $disable)."</td>";
                echo "<td class=\"main\">&nbsp;".DL_COUNT." <input ".$disable." type=\"text\" name=\"" . $current_value_id . "_download_count\" value=\"" . $attribute_value_download_count . "\"></td>";
                echo "<td class=\"main\">&nbsp;".DL_EXPIRE." <input ".$disable." type=\"text\" name=\"" . $current_value_id . "_download_expire\" value=\"" . $attribute_value_download_expire . "\"></td>";
                echo "</tr>";
            }
            // Download function end
          }
          if ($i == $matches2 ) $i = '0';
        }
      } else {
        echo "<TR>";
        echo "<TD class=\"main\"><SMALL>No values under this option.</SMALL></TD>";
        echo "</TR>";
      }
    }
  }
?>
  <tr>
    <td colspan="10" class="main"><br>
<?php
echo xtc_button(BUTTON_SAVE, 'submit', 'style="float:right"') . '';
echo xtc_button_link(BUTTON_CANCEL, FILENAME_NEW_ATTRIBUTES, 'style="float:right"');
?>
</td>
  </tr>
</form>

<script type="text/javascript">
$(document).ready(function()
{
	$('input[type=checkbox]').click(function()
	{
		$(this).closest('tr').find('input, select').not('input[type=checkbox]').attr('disabled', !$(this).is(':checked'));
		$(this).closest('tr').next('tr').not('[class^=attributes]').find('input, select').attr('disabled', !$(this).is(':checked'));
	});
});
</script>