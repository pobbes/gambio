<?php
/* --------------------------------------------------------------
   modules.php 2011-01-21 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(modules.php,v 1.45 2003/05/28); www.oscommerce.com 
   (c) 2003	 nextcommerce (modules.php,v 1.23 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: modules.php 1060 2005-07-21 18:32:58Z mz $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  // include needed functions (for modules)

	//Eingef�gt um Fehler in CC Modul zu unterdr�cken. 
   require(DIR_FS_CATALOG.DIR_WS_CLASSES . 'xtcPrice.php');
   $xtPrice = new xtcPrice($_SESSION['currency'],''); 
 
  switch ($_GET['set']) {
    case 'shipping':
      $module_type = 'shipping';
      $module_directory = DIR_FS_CATALOG_MODULES . 'shipping/';
      $module_key = 'MODULE_SHIPPING_INSTALLED';
      define('HEADING_TITLE', HEADING_TITLE_MODULES_SHIPPING);
      break;

    case 'ordertotal':
    case 'order_total':
      $module_type = 'order_total';
      $module_directory = DIR_FS_CATALOG_MODULES . 'order_total/';
      $module_key = 'MODULE_ORDER_TOTAL_INSTALLED';
      define('HEADING_TITLE', HEADING_TITLE_MODULES_ORDER_TOTAL);
      break;

    case 'payment':
    default:
      $module_type = 'payment';
      $module_directory = DIR_FS_CATALOG_MODULES . 'payment/';
      $module_key = 'MODULE_PAYMENT_INSTALLED';
      define('HEADING_TITLE', HEADING_TITLE_MODULES_PAYMENT);
      if (isset($_GET['error'])) {
          $messageStack->add($_GET['error'], 'error');
        }
      break;
  }

	// BOF GM_MOD
	require_once(DIR_FS_ADMIN . 'gm/classes/GMModulesManager.php');	
	require_once(DIR_FS_ADMIN . 'gm/gm_modules/gm_modules_structure.php');
	$coo_module_manager = new GMModuleManager($module_type, $t_show_installed_modules_menu, $t_display_installed_modules, $t_show_missing_modules_menu, $t_display_missing_modules_menu, $t_ignore_files_array);			
	// EOF GM_MOD		

  switch ($_GET['action']) {
    case 'save':
      while (list($key, $value) = each($_POST['configuration'])) {
        if(preg_match('/(MODULE_)\w*(_ALLOWED|_COUNTRIES_\d+)/i', $key)){
            $value = preg_replace('/[^A-Za-z,]/', '', $value);   
            $value = strtoupper($value);
            $value = trim($value, ',');
        }
        xtc_db_query("update " . TABLE_CONFIGURATION . " set configuration_value = '" . $value . "' where configuration_key = '" . $key . "'");
      }
      // BOF GM_MOD:
      $coo_module_manager->save_sort_order($coo_module_manager->get_modules_installed());
      xtc_redirect(xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $_GET['module']));
      break;

    case 'install':
    case 'remove':
      $file_extension = substr($_SERVER['PHP_SELF'], strrpos($_SERVER['PHP_SELF'], '.'));
      $class = basename($_GET['module']);
      if (file_exists($module_directory . $class . $file_extension)) {
        include($module_directory . $class . $file_extension);
        $module = new $class(0);
        if ($_GET['action'] == 'install') {
		  // clean up:
		  $module->remove();
          $module->install();
        } elseif ($_GET['action'] == 'remove') {
          $module->remove();
        }
      }
      xtc_redirect(xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $class));
      break;
  }
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<script type="text/javascript" src="gm/javascript/gm_modules.js"></script>
<?php
if(isset($_GET['module']) && ($_GET['module'] == 'paypal' || $_GET['module'] == 'paypalexpress')) {
    ?>
    <script type="text/javascript" src="gm/javascript/PayPalApiCheck.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            var coo_api_check = new PayPalApiCheck();
            coo_api_check.do_request('<?php echo $_GET['module']; ?>');
        });
    </script>
    <?php
}
?>
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
			<div class="pageHeading" style="background-image:url(images/gm_icons/module.png); float: left;"><?php echo HEADING_TITLE; ?></div>

                <?php
                if($_GET['set']=='shipping') echo '<div align="right"><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_CONFIGURATION, 'gID=7') . '">' . BOX_CONFIGURATION_7 . '</a></div>';
        ?>
            <br />
		</td>
      </tr>
      <tr>
        <td>
            <div id="paypal_result" class="main"></div>
            <table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top">
<?php 
// BOF GM_MOD
?>
	            <table border="0" width="100%" cellspacing="0" cellpadding="2">
	              <tr class="dataTableHeadingRow">
	                <td class="dataTableHeadingContent" style="border:0px"><?php echo TABLE_HEADING_MODULES . ' (' . TABLE_HEADING_FILENAME . ')'; ?></td>
	                <td class="dataTableHeadingContent" style="text-align: right"><?php echo TABLE_HEADING_SORT_ORDER; ?>&nbsp;&nbsp;</td>
	              </tr>
	            </table>
				<?php
					$coo_module_manager->repair();
					$coo_module_manager->show_modules($t_gm_structure_array);
					
					if(!empty($_GET['module']))
					{
						 $mInfo = new objectInfo($coo_module_manager->get_module_data_by_name($_GET['module']));
					}
				?>
		<div class="smallText"><br /><?php echo TEXT_MODULE_DIRECTORY . ' ' . $module_directory; ?></div>
<?php 
// EOF GM_MOD
?>
	</td>
<?php
  $heading = array();
  $contents = array();
  switch ($_GET['action']) {
    case 'edit':
      $keys = '';
      reset($mInfo->keys);
      while (list($key, $value) = each($mInfo->keys)) {
	 // if($value['description']!='_DESC' && $value['title']!='_TITLE'){ 
        $keys .= '<b>' . $value['title'] . '</b><br />' .  $value['description'].'<br />';
	//	}
        if ($value['set_function']) {
          eval('$keys .= ' . $value['set_function'] . "'" . $value['value'] . "', '" . $key . "');");
        } else {
          $keys .= xtc_draw_input_field('configuration[' . $key . ']', $value['value']);
        }
        $keys .= '<br /><br />';
      }
      $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));

      $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');

      $contents = array('form' => xtc_draw_form('modules', FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $_GET['module'] . '&action=save'));
      $contents[] = array('text' => $keys);
      $contents[] = array('align' => 'center', 'text' => '<br /><div align="center"><input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_UPDATE . '"/><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $_GET['module']) . '">' . BUTTON_CANCEL . '</a></div>');
	  $contents[] = array ('text' => '<br />');
      break;

    default:
      $heading[] = array('text' => '<b>' . $mInfo->title . '</b>');
	  $contents[] = array ('align' => 'center', 'text' => '<div style="padding-top: 5px; font-weight: bold; ">' . TEXT_MARKED_ELEMENTS . '</div><br />');           

      if ($mInfo->status == '1') {
        $keys = '';
        reset($mInfo->keys);
        while (list(, $value) = each($mInfo->keys)) {
          $keys .= '<b>' . $value['title'] . '</b><br />';
          if ($value['use_function']) {
            $use_function = $value['use_function'];
            if (strpos($use_function, '->') !== false) {
              $class_method = explode('->', $use_function);
              if (!is_object(${$class_method[0]})) {
                include(DIR_WS_CLASSES . $class_method[0] . '.php');
                ${$class_method[0]} = new $class_method[0]();
              }
              $keys .= xtc_call_function($class_method[1], $value['value'], ${$class_method[0]});
            } else {
              $keys .= xtc_call_function($use_function, $value['value']);
            }
          } else {
		  if(strlen($value['value']) > 30) {
		  $keys .=  substr($value['value'],0,30) . ' ...';
		  } else {
            $keys .=  $value['value'];
			}
          }
          $keys .= '<br /><br />';
        }
        $keys = substr($keys, 0, strrpos($keys, '<br /><br />'));
        $contents[] = array('text' => '' . $mInfo->description);
		$contents[] = array('align' => 'center', 'text' => '<div align="center"><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=remove') . '">' . BUTTON_MODULE_REMOVE . '</a><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $_GET['module'] . '&action=edit') . '">' . BUTTON_EDIT . '</a></div>');
        $contents[] = array('text' => '<br />' . $keys);
		$contents[] = array ('text' => '<br />');

      } else {
        $contents[] = array('text'  => '<br />' . $mInfo->description);
        $contents[] = array('align' => 'center', 'text' => '<div align="center"><a class="button" onClick="this.blur();" href="' . xtc_href_link(FILENAME_MODULES, 'set=' . $_GET['set'] . '&module=' . $mInfo->code . '&action=install') . '">' . BUTTON_MODULE_INSTALL . '</a></div>');
        $contents[] = array('text'  => '<br />');

      }
      break;
  }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '            <td width="25%" valign="top" id="gm_modules">' . "\n";

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