<?php
/* --------------------------------------------------------------
   gm_id_starts.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
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
	require_once('gm/classes/GMIdStarts.php');
	require_once('gm/classes/GMOrderFormat.php');
	
	$gmIdStarts = new GMIdStarts();
	$gmFormat = new GMOrderFormat();
	
	if(isset($_POST['go'])){		
		$gm_orders_success = $gmIdStarts->set_next_orders_id($_POST['gm_id_starts_orders_id']);
		$gm_customers_success = $gmIdStarts->set_next_customers_id($_POST['gm_id_starts_customers_id']);
	}


	if(isset($_POST['go_save'])){	

		gm_set_conf('GM_INVOICE_ID',	$_POST['GM_INVOICE_ID']);
		gm_set_conf('GM_PACKINGS_ID',	$_POST['GM_PACKINGS_ID']);

		if(!empty($_POST['GM_NEXT_PACKINGS_ID'])) {
			$pack_success = $gmFormat->set_next_id('GM_NEXT_PACKINGS_ID',	$_POST['GM_NEXT_PACKINGS_ID']);
		}

		if(!empty($_POST['GM_NEXT_INVOICE_ID'])) {
			$invo_success = $gmFormat->set_next_id('GM_NEXT_INVOICE_ID',	$_POST['GM_NEXT_INVOICE_ID']);
		}
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
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
			<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
			<!-- left_navigation //-->
			<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
			<!-- left_navigation_eof //-->
    	</table>
		</td>
		<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top">
		
			<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
			<br />
			
			<span class="main">
			<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableHeadingRow">
				 	<td class="dataTableHeadingContentText" style="border-right: 0px"><?php echo HEADING_TITLE; ?></td>
				</tr>
			</table>
			
			<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br /><strong><?php echo GM_TITLE_ID; ?></strong>
						<br />
						<br />
						<?php 
							echo GM_ID_STARTS_TEXT;
						?>
						<br />
						<br />
						<form name="gm_id_starts_form" action="<?php xtc_href_link('gm_id_starts.php'); ?>" method="post">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td height="20" style="font-size: 12px;"><?php echo GM_ID_STARTS_NEXT_ORDER_ID;	?>&nbsp;</td>
								<td height="20" style="font-size: 12px;"><input type="text" name="gm_id_starts_orders_id" id="gm_id_starts_orders_id" value="<?php echo $gmIdStarts->get_orders_autoindex(); ?>" size="30" /> (Minimum: <?php echo $gmIdStarts->get_last_orders_id() + 1; ?>)</td>
							</tr>
							<tr>
								<td height="20" style="font-size: 12px;"><?php echo GM_ID_STARTS_NEXT_CUSTOMER_ID; ?>&nbsp;</td>
								<td height="20" style="font-size: 12px;"><input type="text" name="gm_id_starts_customers_id" id="gm_id_starts_customers_id" value="<?php echo $gmIdStarts->get_customers_autoindex(); ?>" size="30" /> (Minimum: <?php echo $gmIdStarts->get_last_customers_id() + 1; ?>)</td>
							</tr>
						</table>
						<br />
						<?php 
						echo '<input style="margin-left:1px" type="submit" name="go" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/> '; 
						if(isset($gm_orders_success) && $gm_orders_success && $gm_customers_success) echo '<br />' . GM_ID_STARTS_SUCCESS;
						elseif(isset($gm_orders_success)){
							echo '<br />' . GM_ID_STARTS_NO_SUCCESS;
							echo '<br />';
							if(!$gm_orders_success) echo GM_ID_STARTS_ORDERS_ERROR . '<br />';
							if(!$gm_customers_success) echo GM_ID_STARTS_CUSTOMERS_ERROR . '<br />';
						}
						?>
						</form>
					
					</td>
				</tr>
				<!-- INVOICE/PACKINGSLIP -->
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br /><strong><?php echo GM_TITLE_NEXT_ID; ?></strong>
						<br />
						<br />
						<?php 
							echo GM_NEXT_ID_TEXT;
						?>
						<br />
						<br />
						<form name="gm_id_starts_form" action="<?php xtc_href_link('gm_id_starts.php'); ?>" method="post">
						<table cellpadding="0" cellspacing="0">
							<tr>
								<td height="20" style="font-size: 12px;"><?php echo GM_NEXT_INVOICE_ID;	?>&nbsp;</td>
								<td height="20" style="font-size: 12px;"><input type="text" name="GM_NEXT_INVOICE_ID" id="GM_NEXT_INVOICE_ID" value="<?php echo $gmFormat->get_next_id('GM_NEXT_INVOICE_ID'); ?>" size="30" /> (Minimum: <?php echo $gmFormat->get_act_id('GM_NEXT_INVOICE_ID')+1; ?>)</td>
							</tr>
							<tr>
								<td height="20" style="font-size: 12px;"><?php echo GM_INVOICE_ID;	?>&nbsp;</td>
								<td height="20" style="font-size: 12px;"><input type="text" name="GM_INVOICE_ID" id="GM_INVOICE_ID" value="<?php echo gm_get_conf('GM_INVOICE_ID'); ?>" size="30" /> (<?php echo GM_INVOICE_ID_PLACEMENT; ?>)</td>
							</tr>
							<tr>
								<td height="20" style="font-size: 12px;"><?php echo GM_NEXT_PACKINGS_ID; ?>&nbsp;</td>
								<td height="20" style="font-size: 12px;"><input type="text" name="GM_NEXT_PACKINGS_ID" id="GM_NEXT_PACKINGS_ID" value="<?php echo $gmFormat->get_next_id('GM_NEXT_PACKINGS_ID'); ?>" size="30" /> (Minimum: <?php echo $gmFormat->get_act_id('GM_NEXT_PACKINGS_ID')+1; ?>)</td>
							</tr>
							<tr>
								<td height="20" style="font-size: 12px;"><?php echo GM_PACKINGS_ID; ?>&nbsp;</td>
								<td height="20" style="font-size: 12px;"><input type="text" name="GM_PACKINGS_ID" id="GM_PACKINGS_ID" value="<?php echo gm_get_conf('GM_PACKINGS_ID'); ?>" size="30" /> (<?php echo GM_PACKING_ID_PLACEMENT; ?>)</td>
							</tr>
						</table>
						<br />
						<?php 
						echo '<input style="margin-left:1px" type="submit" name="go_save" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/> '; 
						if(isset($_POST['go_save'])) {	
							echo "<br />";
							if(isset($invo_success)) {
								if(!$invo_success) echo GM_NEXT_INVOICE_ID_ERROR	. '<br />'; else echo GM_NEXT_INVOICE_ID_SUCCESS. '<br />';
							}
							if(isset($pack_success)) {
								if(!$pack_success) echo GM_NEXT_PACKING_ID_ERROR	. '<br />'; else echo GM_NEXT_PACKING_ID_SUCCESS. '<br />';
							}
						}
						?>
						</form>
					
					</td>
				</tr>
			</table>
			</span>	

    </td>
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