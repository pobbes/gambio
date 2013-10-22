<?php
/* --------------------------------------------------------------
   configuration.php 2012-12-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

	require('includes/application_top.php');
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_update_group_check.inc.php');

	// BEGIN SKRILL
	$classic_skrill_modules = array('skrill_cc', 'skrill_elv', 'skrill_giropay', 'skrill_sft');
	$other_skrill_modules = array('skrill_cgb', 'skrill_csi', 'skrill_ideal', 'skrill_mae', 'skrill_netpay', 'skrill_psp', 'skrill_pwy', 'skrill_wlt', 'skrill_payinv', 'skrill_payins');
	$all_skrill_modules = array_merge($classic_skrill_modules, $other_skrill_modules);
	if($_GET['gID'] == '32') {
		$active_skrill_modules = array();
		$active_skrill_query = "SELECT configuration_key FROM configuration WHERE configuration_key LIKE 'MODULE_PAYMENT_SKRILL_%_STATUS'";
		$active_skrill_result = xtc_db_query($active_skrill_query);
		while($as_row = xtc_db_fetch_array($active_skrill_result)) {
			$active_module = strtolower(preg_replace('/MODULE_PAYMENT_(.*)_STATUS/', '$1', $as_row['configuration_key']));
			$active_skrill_modules[] = $active_module;
		}
	}
	// END SKRILL
	if ($_GET['action'])
	{
		switch ($_GET['action'])
		{
			
			case 'save':
				/* BOF GM STYLEEDIT */
				if((int)$_GET['gID'] == 1)
				{
					@unlink(DIR_FS_CATALOG . 'cache/__dynamics.css');
				}
				/* BOF GM STYLEEDIT */

				/* BOF GM MONEYBOOKERS/SKRILL */
				if ($_GET['gID']=='31' || $_GET['gID']=='32')
				{
					if(isset($_POST['_PAYMENT_MONEYBOOKERS_EMAILID'])) {
						$email_id = $_POST['_PAYMENT_MONEYBOOKERS_EMAILID'];
					}
					else if(isset($_POST['_PAYMENT_SKRILL_EMAILID'])) {
						$email_id = $_POST['_PAYMENT_SKRILL_EMAILID'];
					}
					// email check
					if(!empty($email_id))
					{
						$url = 'https://www.moneybookers.com/app/email_check.pl?email='.$email_id.'&cust_id=8644877&password=1a28e429ac2fcd036aa7d789ebbfb3b0';

						$ch = curl_init();
						curl_setopt($ch, CURLOPT_URL, $url);
						curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
						curl_setopt($ch, CURLOPT_HEADER, 0);
						curl_setopt($ch, CURLOPT_TIMEOUT, 30);
						curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);

						$result = curl_exec($ch);
						$cprefix = $_GET['gID'] == '31' ? 'MB' : 'SKRILL';
						if ($result=='NOK')
						{
							$messageStack->add_session(constant($cprefix.'_ERROR_NO_MERCHANT'), 'error');
						}

						if (strstr($result,'OK,'))
						{
							$data = explode(',',$result);
							if($_GET['gID'] == '31') {
							$_POST['_PAYMENT_MONEYBOOKERS_MERCHANTID'] = $data[1];
							}
							else {
								$_POST['_PAYMENT_SKRILL_MERCHANTID'] = $data[1];
							}
							$messageStack->add_session(sprintf(constant($cprefix.'_MERCHANT_OK'),$data[1]), 'success');
						}
					}
				}
				/* EOF GM MONEYBOOKERS/SKRILL */

				// BOF save multilingual mail subject
				if($_GET['gID'] == '12' && isset($_POST['EMAIL_BILLING_SUBJECT_ORDER']) && is_array($_POST['EMAIL_BILLING_SUBJECT_ORDER']))
				{
					foreach($_POST['EMAIL_BILLING_SUBJECT_ORDER'] AS $t_languages_id => $t_subject)
					{
						gm_set_content('EMAIL_BILLING_SUBJECT_ORDER', $t_subject, $t_languages_id);
					}
					
					unset($_POST['EMAIL_BILLING_SUBJECT_ORDER']);
				}
				// EOF save multilingual mail subject
				
				$configuration_query = xtc_db_query("													SELECT
														configuration_key,
														configuration_id,
														configuration_value,
														use_function,
														set_function
													FROM " .
														TABLE_CONFIGURATION . "
													WHERE
														configuration_group_id = '" . (int)$_GET['gID'] . "'
													ORDER BY
														sort_order
													");

				while ($configuration = xtc_db_fetch_array($configuration_query))
				{
					// BEGIN SKRILL
					if($configuration['configuration_key'] == '_PAYMENT_SKRILL_MODULES') {
						foreach($all_skrill_modules as $sm) {
							require DIR_FS_CATALOG .'includes/modules/payment/'.$sm.'.php';
							$skrill_pm = new $sm;
							if(isset($_POST[$sm])) {
								if(!in_array($sm, $active_skrill_modules)) {
									$skrill_pm->install();
								}
							}
							else {
								$skrill_pm->remove();
							}
						}
						// let GMModulesManager sort out MODULE_PAYMENT_INSTALLED
						require_once(DIR_FS_ADMIN . 'gm/classes/GMModulesManager.php');	
						$coo_module_manager = new GMModuleManager('payment');
						$coo_module_manager->repair();
						$_POST['_PAYMENT_SKRILL_MODULES'] = 'dummy value';
					}
					// END SKRILL
					// BOF GM_MOD
					// if configuration key not set, don't save it
					if(!isset($_POST[$configuration['configuration_key']])) {
						continue;
					}

					// forbid admin or guest as DEFAULT_CUSTOMERS_STATUS_ID
					if(isset($_POST['DEFAULT_CUSTOMERS_STATUS_ID']) && ($_POST['DEFAULT_CUSTOMERS_STATUS_ID'] == '0' || $_POST['DEFAULT_CUSTOMERS_STATUS_ID'] == '1'))
					{
						continue;
					}

					if($configuration['configuration_key'] == 'SEARCH_ENGINE_FRIENDLY_URLS')
					{
						if(
								gm_get_conf('GM_SEO_BOOST_PRODUCTS') == 'true'
							||
								gm_get_conf('GM_SEO_BOOST_PRODUCTS') == 'true'
							||
								gm_get_conf('GM_SEO_BOOST_PRODUCTS') == 'true'
						)
						{
							$_POST[$configuration['configuration_key']] = 'false';
						}
					}
					// EOF GM_MOD

					xtc_db_query("
									UPDATE " .
										TABLE_CONFIGURATION . "
									SET
										configuration_value ='" . $_POST[$configuration['configuration_key']] . "'
									WHERE
										configuration_key ='". $configuration['configuration_key']."'
								");

					// BOF GM_MOD
					if((int)$_GET['gID'] == 17 && $configuration['configuration_key'] == 'GROUP_CHECK')
					{
						gm_update_group_check($configuration['configuration_value'], $_POST[$configuration['configuration_key']]);
					}
					// EOF GM_MOD
				}

				if((int)$_GET['gID'] == 1)
				{
					$coo_cached_directory = new CachedDirectory('');
					$coo_cached_directory->rebuild_cache();
				}
				elseif((int)$_GET['gID'] == 753 && isset($_POST['GAMBIO_SHOP_KEY']))
				{
					//clear ADMIN-Cache
					$coo_cache =& DataCache::get_instance();
					$coo_cache->clear_cache_by_tag('ADMIN');
					gm_set_conf('CHECK_SHOP_KEY', '1');
				}

				xtc_redirect(FILENAME_CONFIGURATION. '?gID=' . (int)$_GET['gID']);
			break;

		}
	}

	$cfg_group_query = xtc_db_query("
										SELECT
											configuration_group_title
										FROM " .
											TABLE_CONFIGURATION_GROUP . "
										WHERE
											configuration_group_id = '" . (int)$_GET['gID'] . "'
										");

	$cfg_group = xtc_db_fetch_array($cfg_group_query);
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
<script type="text/javascript">
$(document).ready(function() {
	$('input[name="PAYPAL_MODE"]').click(function() {
		if($(this).val() == 'sandbox') {
			$('.pp_sandbox').show();
			$('.pp_live').hide();
		} else {
			$('.pp_sandbox').hide();
			$('.pp_live').show();
		}
	});
	if($('input[value="sandbox"]').attr('checked')) {
		$('.pp_live').hide();
	} else {
		$('.pp_sandbox').hide();
	}
});
</script>

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
		<div class="pageHeading" style="background-image:url(images/gm_icons/meinshop.png)"><?php /* BOF GM_MOD */ echo constant('BOX_CONFIGURATION_' . $_GET['gID']); /* EOF GM_MOD */ ?></div>
		<br>
		</td>
      </tr>
      <tr>
        <td class="main"><table border="0" width="100%" cellspacing="0" cellpadding="0">
        <?php
                /* BOF GM MONEYBOOKERS */
         	switch ($_GET['gID']) {
         		case 25:
                            ?>
                            <div id="paypal_result" class="main"></div>
                            <script type="text/javascript" src="gm/javascript/PayPalApiCheck.js"></script>
                            <script type="text/javascript">
                                $(document).ready(function(){
                                    var coo_api_check = new PayPalApiCheck();
                                    coo_api_check.do_request('paypal');
                                });
                            </script>
                            <?php
         			echo '<table border="0" width="100%" cellspacing="0" cellpadding="0">
            				<tr>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=32', 'NONSSL').'">Skrill</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=31', 'NONSSL').'">Moneybookers.com</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL').'">Afterbuy</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL').'">Google Conversion</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL').'">Paypal</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=26', 'NONSSL').'">brickfox</a>
                			</td>								
            				</tr>
        					</table>';
         			break;
         		case 21:
         		case 19:
         		case 24:
         		case 31:
         		case 32:
				case 26:
					echo '<table border="0" width="100%" cellspacing="0" cellpadding="0">
            				<tr>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=32', 'NONSSL').'">Skrill</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=31', 'NONSSL').'">Moneybookers.com</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=21', 'NONSSL').'">Afterbuy</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=19', 'NONSSL').'">Google Conversion</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=25', 'NONSSL').'">Paypal</a>
                			</td>
                			<td width="150" align="center" class="dataTableHeadingContent">
                			<a href="'.xtc_href_link(FILENAME_CONFIGURATION, 'gID=26', 'NONSSL').'">brickfox</a>
                			</td>							
            				</tr>
        					</table>';
         			break;
			/*
            case 12:
              echo '
                     <span class="messageStackError" style="text-align: center; display: block; margin-bottom: 8px;">' . CONF_LETTR_EXISTS . '</span>
                    ';
            break;         	
			*/
			}
		/* EOF GM MONEYBOOKERS */
         	?>


          <tr>
            <td valign="top" align="right">
          
<?php echo xtc_draw_form('configuration', FILENAME_CONFIGURATION, 'gID=' . (int)$_GET['gID'] . '&action=save'); ?>
<?php
$configuration_query = xtc_db_query("select configuration_key,configuration_id, configuration_value, use_function,set_function from " . TABLE_CONFIGURATION . " where configuration_group_id = '" . (int)$_GET['gID'] . "' order by sort_order");

  $gm_row_cnt = 0;
  while ($configuration = xtc_db_fetch_array($configuration_query)) {
	if ($_GET['gID'] == 6) {
      switch ($configuration['configuration_key']) {
        case 'MODULE_PAYMENT_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $payment_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($payment_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/payment/' . $payment_installed[$i]);
            }
          }
          break;

        case 'MODULE_SHIPPING_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $shipping_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($shipping_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/shipping/' . $shipping_installed[$i]);
            }
          }
          break;

        case 'MODULE_ORDER_TOTAL_INSTALLED':
          if ($configuration['configuration_value'] != '') {
            $ot_installed = explode(';', $configuration['configuration_value']);
            for ($i = 0, $n = sizeof($ot_installed); $i < $n; $i++) {
              include(DIR_FS_CATALOG_LANGUAGES . $language . '/modules/order_total/' . $ot_installed[$i]);
            }
          }
          break;
      }
    }
    if (xtc_not_null($configuration['use_function'])) {
      $use_function = $configuration['use_function'];
      if (strpos($use_function, '->') !== false) {
        $class_method = explode('->', $use_function);
        if (!is_object(${$class_method[0]})) {
          include(DIR_WS_CLASSES . $class_method[0] . '.php');
          ${$class_method[0]} = new $class_method[0]();
        }
        $cfgValue = xtc_call_function($class_method[1], $configuration['configuration_value'], ${$class_method[0]});
      } else {
        $cfgValue = xtc_call_function($use_function, $configuration['configuration_value']);
      }
    } else {
      $cfgValue = $configuration['configuration_value'];
    }

    if (((!$_GET['cID']) || (@$_GET['cID'] == $configuration['configuration_id'])) && (!$cInfo) && (substr($_GET['action'], 0, 3) != 'new')) {
      $cfg_extra_query = xtc_db_query("select configuration_key,configuration_value, date_added, last_modified, use_function, set_function from " . TABLE_CONFIGURATION . " where configuration_id = '" . $configuration['configuration_id'] . "'");
      $cfg_extra = xtc_db_fetch_array($cfg_extra_query);

      $cInfo_array = xtc_array_merge($configuration, $cfg_extra);
      $cInfo = new objectInfo($cInfo_array);
    }
	// BEGIN SKRILL
	if($configuration['configuration_key'] == '_PAYMENT_SKRILL_MODULES') {
		$value_field = '<strong>'._PAYMENT_SKRILL_CLASSIC_MODULES.'</strong><br>';
		foreach($classic_skrill_modules as $sm) {
			include DIR_FS_LANGUAGES . $_SESSION['language'] .'/modules/payment/'.$sm.'.php';
			$checked = (in_array($sm, $active_skrill_modules) ? ' checked="checked"' : '');
			$value_field .= '<input type="checkbox" name="'.$sm.'" value="1" id="'.$sm.'" style="vertical-align:middle;"'.$checked.'>';
			$value_field .= '<label for="'.$sm.'">'.constant('MODULE_PAYMENT_'.strtoupper($sm).'_TEXT_TITLE').'</label><br>';
		}
		$value_field .= '<br><strong>'._PAYMENT_SKRILL_OTHER_MODULES.'</strong><br>';
		foreach($other_skrill_modules as $sm) {
			include DIR_FS_LANGUAGES . $_SESSION['language'] .'/modules/payment/'.$sm.'.php';
			$checked = (in_array($sm, $active_skrill_modules) ? ' checked="checked"' : '');
			$value_field .= '<input type="checkbox" name="'.$sm.'" value="1" id="'.$sm.'" style="vertical-align:middle;"'.$checked.'>';
			$value_field .= '<label for="'.$sm.'">'.constant('MODULE_PAYMENT_'.strtoupper($sm).'_TEXT_TITLE').'</label><br>';
		}
	}
	// END SKRILL
	else {
		if ($configuration['set_function']) {
        eval('$value_field = ' . $configuration['set_function'] . '"' . htmlspecialchars_wrapper($configuration['configuration_value']) . '");');
		  } else {
		    $value_field = xtc_draw_input_field($configuration['configuration_key'], $configuration['configuration_value'],'size=40');
		  }
	   // add

	   if (strstr($value_field,'configuration_value')) $value_field=str_replace('configuration_value',$configuration['configuration_key'],$value_field);
	}

   if(($gm_row_cnt++ % 2) == 0) $gm_row_bg='#d6e6f3'; else $gm_row_bg='#f7f7f7';

	/* bof gm */
	if($configuration['configuration_key'] == 'ACCOUNT_COMPANY_VAT_LIVE_CHECK') {
		if (!function_exists('curl_init') && !function_exists('fsockopen')) {
			$gm_vat_live_check = GM_LIVE_CHECK_NOT_READY;
		} 
	} 
	/* eof gm */
	$table_class = '';
    // by paypal config, show just live or sandbox input
	if($_GET['gID'] == 25) {
		if(strstr($configuration['configuration_key'], 'PAYPAL_API_SANDBOX_')) {
			$table_class = ' class="pp_sandbox"';
			$gm_row_cnt++;
		}

		if(strstr($configuration['configuration_key'], 'PAYPAL_API_')
			&& !strstr($configuration['configuration_key'], 'PAYPAL_API_SANDBOX_')) {
			$table_class = ' class="pp_live"';
		}
	}

	$t_show_option = true;

	// disable DB-Cache option
	if($_GET['gID'] == 11 && ($configuration['configuration_key'] == 'DB_CACHE' && $configuration['configuration_value'] == 'false') ||
		($configuration['configuration_key'] == 'DB_CACHE_EXPIRE' && isset($t_hide_db_cache) && $t_hide_db_cache === true) )
	{
		$t_show_option = false;
		$t_hide_db_cache = true;
	}
	// disable DEFAULT_CUSTOMERS_STATUS_ID_ADMIN option
	if($_GET['gID'] == '1' && ($configuration['configuration_key'] == 'DEFAULT_CUSTOMERS_STATUS_ID_ADMIN' && $configuration['configuration_value'] == '0'))
	{
		$t_show_option = false;
		$gm_row_cnt--;
	}
	// disable DEFAULT_CUSTOMERS_STATUS_ID_GUEST option
	if($_GET['gID'] == '1' && ($configuration['configuration_key'] == 'DEFAULT_CUSTOMERS_STATUS_ID_GUEST' && $configuration['configuration_value'] == '1'))
	{
		$t_show_option = false;
		$gm_row_cnt--;
	}

	// BOF Shop-Key information
	$t_shop_key_textarea = '';
	if((int)$_GET['gID'] == 753)
	{
		require_once(DIR_FS_CATALOG . 'release_info.php');
		require_once(DIR_FS_CATALOG . 'gm/classes/JSON.php');
		
		$t_shop_key_textarea_value = 'shop_version=' . $gx_version . "\n";
		$t_shop_key_textarea_value .= 'shop_url=' . HTTP_SERVER . DIR_WS_CATALOG . "\n";
		$t_shop_key_textarea_value .= 'shop_key=' . GAMBIO_SHOP_KEY . "\n";
		$t_shop_key_textarea_value .= 'language=' . $_SESSION['language_code'] . "\n";
		
		$coo_version_info = MainFactory::create_object('VersionInfo');
		$coo_json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
		$t_shop_key_textarea_value .= 'version_info=' . $coo_json->encodeUnsafe($coo_version_info->get_shop_versioninfo());
		
		$t_shop_key_textarea .= xtc_draw_textarea_field('shop_key_data', false, 70, 10, $t_shop_key_textarea_value, 'readonly="readonly"');
		$t_shop_key_textarea .= '<script>
									$(\'input[name="GAMBIO_SHOP_KEY"]\').change(function(){
										$("#shop_key_data").html($("#shop_key_data").html().replace(/shop_key=.*?\nlanguage/g, "shop_key=" + $(this).val() + "\nlanguage"));
									});
									$(\'input[name="GAMBIO_SHOP_KEY"]\').keyup(function(){
										$("#shop_key_data").html($("#shop_key_data").html().replace(/shop_key=.*?\nlanguage/g, "shop_key=" + $(this).val() + "\nlanguage"));
									});
								</script>';
	}
	// EOF Shop-Key information

	if($t_show_option)
	{
		// BOF multilingual mail subject
		if($_GET['gID'] == '12' && $configuration['configuration_key'] == 'EMAIL_BILLING_SUBJECT_ORDER')
		{
			$value_field = '';
			$t_languages_array = xtc_get_languages();
			foreach($t_languages_array as $t_language_array)
			{
				$value_field .= xtc_draw_input_field('EMAIL_BILLING_SUBJECT_ORDER[' . $t_language_array['id'] . ']', gm_get_content('EMAIL_BILLING_SUBJECT_ORDER', $t_language_array['id']), 'size=40') . ' <img src="../lang/' . $t_language_array['directory'] . '/admin/images/icon.gif" border="0" /><br /><br />';
			}						
		}
		// EOF multilingual mail subject
		
		 echo '<table'.$table_class.' width="100%" border="0" cellspacing="0" cellpadding="4" style="border-bottom: 1px dotted #5a5a5a">
					<tr valign="top" bgcolor="'.$gm_row_bg.'">
						<td class="dataTableContent_gm" width="300"><b>'.constant(strtoupper($configuration['configuration_key'].'_TITLE')).'</b></td>
						<td class="dataTableContent_gm">
							<table width="100%" border="0" cellspacing="0" cellpadding="2">
								<tr>
									<td class="dataTableContent_gm">'.$value_field.'</td>
								</tr>
							</table>
							<br />'.constant(strtoupper( $configuration['configuration_key'].'_DESC')) . $gm_vat_live_check . $t_shop_key_textarea .
						'</td>
					</tr>
				</table>';
	}
  
	/* bof gm */
	if($configuration['configuration_key'] == 'ACCOUNT_COMPANY_VAT_LIVE_CHECK') {
		$gm_vat_live_check = '';	
	} 
	/* eof gm */
  }
?>
<?php echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?></form>
            </td>

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