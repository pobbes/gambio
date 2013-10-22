<?php
/* --------------------------------------------------------------
   shipping_status.php 2013-02-28 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2013 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(orders_status.php,v 1.19 2003/02/06); www.oscommerce.com
   (c) 2003	 nextcommerce (orders_status.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: shipping_status.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  switch ($_GET['action']) {
    case 'insert':
    case 'save':
      $shipping_status_id = xtc_db_prepare_input($_GET['oID']);

      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $shipping_status_name_array = $_POST['shipping_status_name'];
        $language_id = $languages[$i]['id'];

        // BOF GM_MOD:
		// BOF GM_MOD products_shippingtime:
		$auto_shipping_status = gm_get_conf('GM_AUTO_SHIPPING_STATUS');
		$sql_data_array = array('shipping_status_name' => xtc_db_prepare_input($shipping_status_name_array[$language_id]),
							    'number_of_days' => (int)$_POST['number_of_days']);
		// BOF GM_MOD products_shippingtime:
		if($auto_shipping_status == 'true' && ACTIVATE_SHIPPING_STATUS == 'true' && STOCK_LIMITED == 'true') {
			$sql_data_array['shipping_quantity'] =  (int)$_POST['shipping_quantity'];
		}
		// BOF GM_MOD products_shippingtime:
        if ($_GET['action'] == 'insert') {
          if (!xtc_not_null($shipping_status_id)) {
            $next_id_query = xtc_db_query("select max(shipping_status_id) as shipping_status_id from " . TABLE_SHIPPING_STATUS . "");
            $next_id = xtc_db_fetch_array($next_id_query);
            $shipping_status_id = $next_id['shipping_status_id'] + 1;
          }

          $insert_sql_data = array('shipping_status_id' => $shipping_status_id,
                                   'language_id' => $language_id);
          $sql_data_array = xtc_array_merge($sql_data_array, $insert_sql_data);
          xtc_db_perform(TABLE_SHIPPING_STATUS, $sql_data_array);

		  if(isset($_POST['google_export_availability_id']))
		  {
			  $c_google_export_availability_id = (int)$_POST['google_export_availability_id'];
			  if($c_google_export_availability_id > 0)
			  {
				  xtc_db_perform('shipping_status_to_google_availability', array('shipping_status_id' => $shipping_status_id, 'google_export_availability_id' => $c_google_export_availability_id), 'replace');
			  }
		  }

        } elseif ($_GET['action'] == 'save') {
          xtc_db_perform(TABLE_SHIPPING_STATUS, $sql_data_array, 'update', "shipping_status_id = '" . xtc_db_input($shipping_status_id) . "' and language_id = '" . $language_id . "'");
        
		  if(isset($_POST['google_export_availability_id']))
		  {
			  $c_google_export_availability_id = (int)$_POST['google_export_availability_id'];
			  if($c_google_export_availability_id > 0)
			  {
				  xtc_db_perform('shipping_status_to_google_availability', array('shipping_status_id' => (int)$shipping_status_id, 'google_export_availability_id' => $c_google_export_availability_id), 'replace');
			  }
			  else
			  {
				  xtc_db_query("DELETE FROM shipping_status_to_google_availability WHERE shipping_status_id = '" . xtc_db_input($shipping_status_id) . "'");
			  }
		  }
		}
      }

      if ($shipping_status_image = &xtc_try_upload('shipping_status_image',DIR_WS_ICONS)) {
        xtc_db_query("update " . TABLE_SHIPPING_STATUS . " set shipping_status_image = '" . $shipping_status_image->filename . "' where shipping_status_id = '" . xtc_db_input($shipping_status_id) . "'");
      }

      if ($_POST['default'] == 'on') {
        xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . xtc_db_input($shipping_status_id) . "' where configuration_key = 'DEFAULT_SHIPPING_STATUS_ID'");
      }

      xtc_redirect(xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $shipping_status_id));
      break;

	// BOF GM_MOD products_shippingtime:
    case 'saveautoshipping':
		$autoshipping = 'false';
		if($_POST['autoshipping'] == 'true') {
			$autoshipping = 'true';
		}
		gm_set_conf('GM_AUTO_SHIPPING_STATUS', xtc_db_prepare_input($autoshipping));
		break;
	// BOF GM_MOD products_shippingtime:
    case 'deleteconfirm':
      $oID = xtc_db_prepare_input($_GET['oID']);

      $shipping_status_query = xtc_db_query("select configuration_value from " . TABLE_CONFIGURATION . " where configuration_key = 'DEFAULT_SHIPPING_STATUS_ID'");
      $shipping_status = xtc_db_fetch_array($shipping_status_query);
      if ($shipping_status['configuration_value'] == $oID) {
        xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '' where configuration_key = 'DEFAULT_SHIPPING_STATUS_ID'");
      }

      xtc_db_query("delete from " . TABLE_SHIPPING_STATUS . " where shipping_status_id = '" . xtc_db_input($oID) . "'");
	  xtc_db_query("DELETE FROM shipping_status_to_google_availability WHERE shipping_status_id = '" . xtc_db_input($oID) . "'");

      xtc_redirect(xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page']));
      break;

    case 'delete':
      $oID = xtc_db_prepare_input($_GET['oID']);


      $remove_status = true;
      if ($oID == DEFAULT_SHIPPING_STATUS_ID) {
        $remove_status = false;
        $messageStack->add(ERROR_REMOVE_DEFAULT_SHIPPING_STATUS, 'error');
      } else {

      }
      break;
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td>		
		<div class="pageHeading" style="background-image:url(images/gm_icons/meinshop.png)"><?php echo BOX_SHIPPING_STATUS; ?></div>
		<br>
		</td>
      </tr>
      <tr>
        <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
              <td class="dataTableHeadingContent" width="1"><?php echo TABLE_HEADING_SHIPPING_STATUS; ?></td>
                <td class="dataTableHeadingContent" width="100%"><?php echo TABLE_HEADING_SHIPPING_TIME; ?>&nbsp;</td>
                <td class="dataTableHeadingContent" align="right">&nbsp;</td>
              </tr>
<?php
  // BOF GM_MOD:
  // BOF GM_MOD products_shippingtime:
  $auto_shipping_status = gm_get_conf('GM_AUTO_SHIPPING_STATUS');
  $shipping_status_query_raw = "select shipping_status_id, shipping_status_name,shipping_status_image, number_of_days, shipping_quantity from " . TABLE_SHIPPING_STATUS . " where language_id = '" . $_SESSION['languages_id'] . "' order by shipping_status_id";
  // BOF GM_MOD products_shippingtime:
  $shipping_status_split = new splitPageResults($_GET['page'], '20', $shipping_status_query_raw, $shipping_status_query_numrows);
  $shipping_status_query = xtc_db_query($shipping_status_query_raw);
  while ($shipping_status = xtc_db_fetch_array($shipping_status_query)) {
    if (((!$_GET['oID']) || ($_GET['oID'] == $shipping_status['shipping_status_id'])) && (!$oInfo) && (substr($_GET['action'], 0, 3) != 'new')) {

		if(gm_get_conf('GM_GOOGLE_SHOPPING_STATUS') == '1')
		{
			$t_google_availability_sql = "SELECT 
												stg.google_export_availability_id,
												g.availability
											FROM 
												shipping_status_to_google_availability stg,
												google_export_availability g
											WHERE 
												stg.shipping_status_id = '" . (int)$shipping_status['shipping_status_id'] . "' AND
												stg.google_export_availability_id = g.google_export_availability_id";
			$t_google_availability_result = xtc_db_query($t_google_availability_sql);
			if(xtc_db_num_rows($t_google_availability_result) == 1)
			{
				$t_google_availability_result_array = xtc_db_fetch_array($t_google_availability_result);
				$shipping_status = array_merge($shipping_status, $t_google_availability_result_array);
			}
		}

      $oInfo = new objectInfo($shipping_status);
    }

    if ( (is_object($oInfo)) && ($shipping_status['shipping_status_id'] == $oInfo->shipping_status_id) ) {
      echo '                  <tr class="dataTableRowSelected" onmouseover="this.style.cursor=\'hand\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id . '&action=edit') . '\'">' . "\n";
    } else {
      echo '                  <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $shipping_status['shipping_status_id']) . '\'">' . "\n";
    }

    if (DEFAULT_SHIPPING_STATUS_ID == $shipping_status['shipping_status_id']) {
        echo '<td class="dataTableContent" align="left">';
     if ($shipping_status['shipping_status_image'] != '') {
       echo xtc_image(DIR_WS_ICONS . $shipping_status['shipping_status_image'] , IMAGE_ICON_INFO);
     }
     echo '&nbsp;</td>';
      echo '                <td class="dataTableContent"><b>' . $shipping_status['shipping_status_name'] . ' (' . TEXT_DEFAULT . ')</b></td>' . "\n";
    } else {

      			echo '<td class="dataTableContent" align="left">';
                       if ($shipping_status['shipping_status_image'] != '') {
                           echo xtc_image(DIR_WS_ICONS . $shipping_status['shipping_status_image'] , IMAGE_ICON_INFO);
                           }
                           echo '&nbsp;</td>';
      echo '                <td class="dataTableContent">' . $shipping_status['shipping_status_name'] . '</td>' . "\n";
    }
?>
                <td class="dataTableContent" align="right"><?php if ( (is_object($oInfo)) && ($shipping_status['shipping_status_id'] == $oInfo->shipping_status_id) ) { echo xtc_image(DIR_WS_IMAGES . 'icon_arrow_right.gif', ''); } else { echo '<a href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $shipping_status['shipping_status_id']) . '">' . xtc_image(DIR_WS_IMAGES . 'icon_info.gif', IMAGE_ICON_INFO) . '</a>'; } ?>&nbsp;</td>
              </tr>
<?php
  }
?>
              <tr>
                <td colspan="3"><table border="0" width="100%" cellspacing="0" cellpadding="2">
                  <tr>
                    <td class="smallText" valign="top"><?php echo $shipping_status_split->display_count($shipping_status_query_numrows, '20', $_GET['page'], TEXT_DISPLAY_NUMBER_OF_SHIPPING_STATUS); ?></td>
                    <td class="smallText" align="right"><?php echo $shipping_status_split->display_links($shipping_status_query_numrows, '20', MAX_DISPLAY_PAGE_LINKS, $_GET['page']); ?></td>
                  </tr>
<?php
  if (substr($_GET['action'], 0, 3) != 'new' && $_GET['action'] != 'shippingconfig') {
?>
                  <tr>
                    <td colspan="2" align="right">
						<?php
						echo '<a class="button" style="width: 200px;" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&action=new') . '">' . BUTTON_INSERT_SHIPPING . '</a>';
						// BOF GM_MOD products_shippingtime:
						if(STOCK_LIMITED == 'true' && ACTIVATE_SHIPPING_STATUS == 'true') {
							echo '<a class="button" style="width: 200px;" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&action=shippingconfig') . '">'.BUTTON_CONFIG_SHIPPING.'</a>';
						}
						// BOF GM_MOD products_shippingtime:
						?>
					</td>
                  </tr>
<?php
  }
?>
                </table></td>
              </tr>
            </table></td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'new':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_NEW_SHIPPING_STATUS . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&action=insert', 'post', 'enctype="multipart/form-data"'));
      $contents[] = array('text' => TEXT_INFO_INSERT_INTRO);

      $shipping_status_inputs_string = '';
      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $shipping_status_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('shipping_status_name[' . $languages[$i]['id'] . ']');
      }
      $contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_IMAGE . '<br />' . xtc_draw_file_field('shipping_status_image', true, 10));
      $contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_NAME . $shipping_status_inputs_string);
      // BOF GM_MOD:      
      $contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_DAYS . ' ' . xtc_draw_input_field('number_of_days',  $oInfo->number_of_days, 'size="2"'));
	  // BOF GM_MOD products_shippingtime:
      if($auto_shipping_status == 'true') {
		$contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_QUANTITY . ' ' . xtc_draw_input_field('shipping_quantity',  $oInfo->shipping_quantity, 'size="4"'));
	  }
	  // BOF GM_MOD products_shippingtime:

		if(gm_get_conf('GM_GOOGLE_SHOPPING_STATUS') == '1')
		{
			$t_google_export_availability_array[] = array('id' => '', 'text' => '' );

			$t_availability_sql = "SELECT google_export_availability_id, availability FROM google_export_availability ORDER BY google_export_availability_id";
			$t_availability_result = xtc_db_query($t_availability_sql);
			while($t_availability_result_array = xtc_db_fetch_array($t_availability_result))
			{
				$t_google_export_availability_array[] = array('id' => $t_availability_result_array['google_export_availability_id'], 'text' => $t_availability_result_array['availability'] );
			}

			$contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_GOOGLE_AVAILABILITY . ' ' . xtc_draw_pull_down_menu('google_export_availability_id', $t_google_export_availability_array, $oInfo->google_export_availability_id, 'style="width: 130px"'));
		}
	  
	  $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
      $contents[] = array('align' => 'center', 'text' => '<br /><div align="center"><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_INSERT . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page']) . '">' . BUTTON_CANCEL . '</a></div>');
      break;

    case 'edit':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_EDIT_SHIPPING_STATUS . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id  . '&action=save', 'post', 'enctype="multipart/form-data"'));
      //$contents[] = array('text' => TEXT_INFO_EDIT_INTRO);

      $shipping_status_inputs_string = '';
      $languages = xtc_get_languages();
      for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
        $shipping_status_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_draw_input_field('shipping_status_name[' . $languages[$i]['id'] . ']', xtc_get_shipping_status_name($oInfo->shipping_status_id, $languages[$i]['id']));
      }
      $contents[] = array('text' => '<br /><strong>' . TEXT_INFO_SHIPPING_STATUS_IMAGE . '</strong><br />' . xtc_draw_file_field('shipping_status_image',$oInfo->shipping_status_image, 10));
      $contents[] = array('text' => '<br /><strong>' . TEXT_INFO_SHIPPING_STATUS_NAME . '</strong>' . $shipping_status_inputs_string);
      $contents[] = array('text' => '<br /><strong>' . TEXT_INFO_SHIPPING_STATUS_DAYS . '</strong> ' . xtc_draw_input_field('number_of_days', $oInfo->number_of_days, 'size="2"'));
      
	  if($auto_shipping_status == 'true' && ACTIVATE_SHIPPING_STATUS == 'true' && STOCK_LIMITED == 'true') {
		$contents[] = array('text' => '<br /><strong>'.TEXT_INFO_SHIPPING_STATUS_QUANTITY.'</strong> ' . xtc_draw_input_field('shipping_quantity',  (double)$oInfo->shipping_quantity, 'size="5"') . '<br /><br />' . TEXT_INPUT_SHIPPING_STATUS_QUANTITY);
	  }
	  
	  if (DEFAULT_SHIPPING_STATUS_ID != $oInfo->shipping_status_id) $contents[] = array('text' => '<br />' . xtc_draw_checkbox_field('default') . ' ' . TEXT_SET_DEFAULT);
	  
		if(gm_get_conf('GM_GOOGLE_SHOPPING_STATUS') == '1')
		{
			$t_google_export_availability_array[] = array('id' => '', 'text' => '' );

			$t_availability_sql = "SELECT google_export_availability_id, availability FROM google_export_availability ORDER BY google_export_availability_id";
			$t_availability_result = xtc_db_query($t_availability_sql);
			while($t_availability_result_array = xtc_db_fetch_array($t_availability_result))
			{
				$t_google_export_availability_array[] = array('id' => $t_availability_result_array['google_export_availability_id'], 'text' => $t_availability_result_array['availability'] );
			}

			$contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_GOOGLE_AVAILABILITY . ' ' . xtc_draw_pull_down_menu('google_export_availability_id', $t_google_export_availability_array, $oInfo->google_export_availability_id, 'style="width: 130px"'));
		}

      $contents[] = array('align' => 'center', 'text' => '<br /><div align="center"><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id) . '">' . BUTTON_CANCEL . '</a></div>');
      break;

    case 'delete':
      $heading[] = array('text' => '<b>' . TEXT_INFO_HEADING_DELETE_SHIPPING_STATUS . '</b>');

      $contents = array('form' => xtc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id  . '&action=deleteconfirm'));
      $contents[] = array('text' => TEXT_INFO_DELETE_INTRO);
      $contents[] = array('text' => '<br /><b>' . $oInfo->shipping_status_name . '</b>');
      if ($remove_status) $contents[] = array('align' => 'center', 'text' => '<br /><div align="center"><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_DELETE . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id) . '">' . BUTTON_CANCEL . '</a></div>');
      break;

	// BOF GM_MOD products_shippingtime:
	case 'shippingconfig':
		$auto_shipping_checked = false;
		if($auto_shipping_status == 'true') {
			$auto_shipping_checked = true;
		}
		$heading[] = array('text' => '<b>'.HEADING_CONFIG_SHIPPING.'</b>');

		$contents = array('form' => xtc_draw_form('status', FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&action=saveautoshipping'));
		$contents[] = array('text' => '<br />' . TEXT_CONFIG_SHIPPING . xtc_draw_checkbox_field('autoshipping', 'true', $auto_shipping_checked));
		$contents[] = array('align' => 'center', 'text' => '<br /><div align="center"><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id) . '">' . BUTTON_CANCEL . '</a></div>');
		break;
	// BOF GM_MOD products_shippingtime:

    default:
      if (is_object($oInfo)) {
        $heading[] = array('text' => '<b>' . $oInfo->shipping_status_name . '</b>');

        $contents[] = array('align' => 'center', 'text' => '<div align="center"><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id . '&action=edit') . '">' . BUTTON_EDIT . '</a> <a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_SHIPPING_STATUS, 'page=' . $_GET['page'] . '&oID=' . $oInfo->shipping_status_id . '&action=delete') . '">' . BUTTON_DELETE . '</a></div>');

        $shipping_status_inputs_string = '';
        $languages = xtc_get_languages();
        for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
          $shipping_status_inputs_string .= '<br />' . xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']) . '&nbsp;' . xtc_get_shipping_status_name($oInfo->shipping_status_id, $languages[$i]['id']);
        }
	    // BOF GM_MOD products_shippingtime:
        $contents[] = array('text' => $shipping_status_inputs_string . '<br /><br />' . TEXT_INFO_SHIPPING_STATUS_DAYS . ' ' . $oInfo->number_of_days);
        if(!empty($oInfo->shipping_quantity) && $auto_shipping_status == 'true' && ACTIVATE_SHIPPING_STATUS == 'true' && STOCK_LIMITED == 'true') {
			$contents[] = array('text' => TEXT_INFO_SHIPPING_STATUS_QUANTITY . ' ' . (double)$oInfo->shipping_quantity);
		}
		// BOF GM_MOD products_shippingtime:

		if(gm_get_conf('GM_GOOGLE_SHOPPING_STATUS') == '1')
		{
			$contents[] = array('text' => '<br />' . TEXT_INFO_SHIPPING_STATUS_GOOGLE_AVAILABILITY . ' ' . $oInfo->availability);
		}

      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>