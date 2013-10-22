<?php
/* --------------------------------------------------------------
   gm_miscellaneous.php 2012-01-12 gm
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

	function gm_update_prd_table($col, $value) {

		$gm_query = xtc_db_query("
									UPDATE
										products
									SET " . 
										$col . " = '" . $value . "'									
								");
	
		return;
	}

	if(isset($_POST['go_images']) && !empty($_POST['delete_images']))
	{
		if($gm_handle = opendir(DIR_FS_CATALOG_ORIGINAL_IMAGES)){
	    $gm_deleted_images = 0;
			$gm_images_count = 0;
			while (false !== ($gm_file = readdir($gm_handle))){
       if($gm_file != '.' && $gm_file != '..' && $gm_file != 'index.html'){
					if(@unlink(DIR_FS_CATALOG_ORIGINAL_IMAGES . $gm_file)){
						$gm_deleted_images++;
						$gm_images_count++;
					}
					else $gm_images_count++;
				}
	    }
	    closedir($gm_handle);
		}
	}
	
	elseif(isset($_POST['go_cat_stock']))
	{
		if($_POST['show_cat_stock'] == 1) xtc_db_query("UPDATE categories SET gm_show_qty_info = 1");
		else xtc_db_query("UPDATE categories SET gm_show_qty_info = 0");
		
		$success = GM_CAT_STOCK_SUCCESS;
	}
	
	elseif(isset($_POST['go_product_stock']))
	{
		if($_POST['show_product_stock'] == 1) xtc_db_query("UPDATE products SET gm_show_qty_info = 1");
		else xtc_db_query("UPDATE products SET gm_show_qty_info = 0");
		
		$success = GM_PRODUCT_STOCK_SUCCESS;
	}
	
	elseif(isset($_POST['go_save']))
	{
		if($_POST['tell_a_friend']							== 1)	gm_set_conf('GM_TELL_A_FRIEND',							'true');												else gm_set_conf('GM_TELL_A_FRIEND',						'false');
		if($_POST['tax_info_tax_free']						== 1) 	gm_set_conf('TAX_INFO_TAX_FREE',						'true'); 												else gm_set_conf('TAX_INFO_TAX_FREE',						'false');
		//if($_POST['show_products_weight']					== 1) 	gm_update_prd_table('gm_show_weight',					1); 													else gm_update_prd_table('gm_show_weight',					0);
		if($_POST['show_attr_stock']						== 1) 	gm_set_conf('GM_SHOW_ATTRIBUTES_STOCK',					1); 													else gm_set_conf('GM_SHOW_ATTRIBUTES_STOCK',				0);
		if($_POST['hide_attr_out_of_stock']					== 1) 	gm_set_conf('GM_HIDE_ATTR_OUT_OF_STOCK',				1); 													else gm_set_conf('GM_HIDE_ATTR_OUT_OF_STOCK',				0);
		if($_POST['set_products_inactive']					== 1) 	gm_set_conf('GM_SET_OUT_OF_STOCK_PRODUCTS_INACTIVE',	1); 													else gm_set_conf('GM_SET_OUT_OF_STOCK_PRODUCTS_INACTIVE',	0);
		if((int)$_POST['truncate_products_name']			> 0)	gm_set_conf('TRUNCATE_PRODUCTS_NAME',					(int)$_POST['truncate_products_name']); 
		if((int)$_POST['truncate_products_name_history']	> 0)	gm_set_conf('TRUNCATE_PRODUCTS_HISTORY',				(int)$_POST['truncate_products_name_history']); 
		if((int)$_POST['truncate_flyover']					> 0)	gm_set_conf('TRUNCATE_FLYOVER',							(int)$_POST['truncate_flyover']); 
		if((int)$_POST['truncate_flyover_text']				> 0)	gm_set_conf('TRUNCATE_FLYOVER_TEXT',					(int)$_POST['truncate_flyover_text']); 
		if((int)$_POST['GM_ORDER_STATUS_CANCEL_ID']			> 0)	gm_set_conf('GM_ORDER_STATUS_CANCEL_ID',				(int)$_POST['GM_ORDER_STATUS_CANCEL_ID']); 
		if($_POST['hide_msrp'] == 1)
		{
			gm_set_conf('GM_HIDE_MSRP', '1');
	}
		else
		{
			gm_set_conf('GM_HIDE_MSRP', '0');
		}
	}
	
	elseif(isset($_POST['go_home'])) 
	{	
		
		if($_POST['GM_CHECK_PRIVACY_CALLBACK']	== 1)				{	gm_set_conf('GM_CHECK_PRIVACY_CALLBACK',				1);		} else { gm_set_conf('GM_CHECK_PRIVACY_CALLBACK',				0);	}
		if($_POST['GM_CHECK_PRIVACY_GUESTBOOK']	== 1)				{	gm_set_conf('GM_CHECK_PRIVACY_GUESTBOOK',				1);		} else { gm_set_conf('GM_CHECK_PRIVACY_GUESTBOOK',				0);	}
		if($_POST['GM_CHECK_PRIVACY_CONTACT']	== 1)				{	gm_set_conf('GM_CHECK_PRIVACY_CONTACT',					1);		} else { gm_set_conf('GM_CHECK_PRIVACY_CONTACT',				0);	}
		if($_POST['GM_CHECK_PRIVACY_TELL_A_FRIEND']	== 1)			{	gm_set_conf('GM_CHECK_PRIVACY_TELL_A_FRIEND',			1);		} else { gm_set_conf('GM_CHECK_PRIVACY_TELL_A_FRIEND',			0);	}
		if($_POST['GM_CHECK_PRIVACY_FOUND_CHEAPER']	== 1)			{	gm_set_conf('GM_CHECK_PRIVACY_FOUND_CHEAPER',			1);		} else { gm_set_conf('GM_CHECK_PRIVACY_FOUND_CHEAPER',			0);	}
		if($_POST['GM_CHECK_PRIVACY_REVIEWS']	== 1)				{	gm_set_conf('GM_CHECK_PRIVACY_REVIEWS',					1);		} else { gm_set_conf('GM_CHECK_PRIVACY_REVIEWS',				0);	}
		if($_POST['GM_CHECK_PRIVACY_ACCOUNT_CONTACT']	== 1)		{	gm_set_conf('GM_CHECK_PRIVACY_ACCOUNT_CONTACT',			1);		} else { gm_set_conf('GM_CHECK_PRIVACY_ACCOUNT_CONTACT',		0);	}
		if($_POST['GM_CHECK_PRIVACY_ACCOUNT_ADDRESS_BOOK']	== 1)	{	gm_set_conf('GM_CHECK_PRIVACY_ACCOUNT_ADDRESS_BOOK',	1);		} else { gm_set_conf('GM_CHECK_PRIVACY_ACCOUNT_ADDRESS_BOOK',	0);	}
		if($_POST['GM_CHECK_PRIVACY_ACCOUNT_NEWSLETTER']	== 1)	{	gm_set_conf('GM_CHECK_PRIVACY_ACCOUNT_NEWSLETTER',		1);		} else { gm_set_conf('GM_CHECK_PRIVACY_ACCOUNT_NEWSLETTER',		0);	}
		if($_POST['GM_CHECK_PRIVACY_CHECKOUT_SHIPPING']	== 1)		{	gm_set_conf('GM_CHECK_PRIVACY_CHECKOUT_SHIPPING',		1);		} else { gm_set_conf('GM_CHECK_PRIVACY_CHECKOUT_SHIPPING',		0);	}
		if($_POST['GM_CHECK_PRIVACY_CHECKOUT_PAYMENT']	== 1)		{	gm_set_conf('GM_CHECK_PRIVACY_CHECKOUT_PAYMENT',		1);		} else { gm_set_conf('GM_CHECK_PRIVACY_CHECKOUT_PAYMENT',		0);	}

		if($_POST['GM_WITHDRAWAL_CONTENT_ID'])			  {		gm_set_conf('GM_WITHDRAWAL_CONTENT_ID',			$_POST['GM_WITHDRAWAL_CONTENT_ID']);}
		if($_POST['GM_SHOW_PRIVACY_REGISTRATION']	== 1) {		gm_set_conf('GM_SHOW_PRIVACY_REGISTRATION',		1);				} else { gm_set_conf('GM_SHOW_PRIVACY_REGISTRATION',	0);	}
		if($_POST['GM_CHECK_WITHDRAWAL']			== 1) {		gm_set_conf('GM_CHECK_WITHDRAWAL',				1);				} else { gm_set_conf('GM_CHECK_WITHDRAWAL',				0);	}
		if($_POST['GM_SHOW_WITHDRAWAL']				== 1) {		gm_set_conf('GM_SHOW_WITHDRAWAL',				1);				} else { gm_set_conf('GM_SHOW_WITHDRAWAL',				0);	}
		if($_POST['GM_SHOW_CONDITIONS']				== 1) {		gm_set_conf('GM_SHOW_CONDITIONS',				1);				} else { gm_set_conf('GM_SHOW_CONDITIONS',				0);	}
		if($_POST['GM_CHECK_CONDITIONS']			== 1) {		gm_set_conf('GM_CHECK_CONDITIONS',				1);				} else { gm_set_conf('GM_CHECK_CONDITIONS',				0);	}
		
		if($_POST['GM_SHOW_PRIVACY_CONFIRMATION']	 == 1){		gm_set_conf('GM_SHOW_PRIVACY_CONFIRMATION',		1);				} else { gm_set_conf('GM_SHOW_PRIVACY_CONFIRMATION',	0);	}
		if($_POST['GM_SHOW_CONDITIONS_CONFIRMATION'] == 1){		gm_set_conf('GM_SHOW_CONDITIONS_CONFIRMATION',	1);				} else { gm_set_conf('GM_SHOW_CONDITIONS_CONFIRMATION',	0);	}
		if($_POST['GM_SHOW_WITHDRAWAL_CONFIRMATION'] == 1){		gm_set_conf('GM_SHOW_WITHDRAWAL_CONFIRMATION',	1);				} else { gm_set_conf('GM_SHOW_WITHDRAWAL_CONFIRMATION',	0);	}
		if($_POST['GM_LOG_IP']	== 1)					  {		gm_set_conf('GM_LOG_IP',						1);				} else { gm_set_conf('GM_LOG_IP',						0);	}
//		if($_POST['GM_SHOW_IP'] == 1)					  {		gm_set_conf('GM_SHOW_IP', 1);gm_set_conf('GM_CONFIRM_IP', 0);	}
//		if($_POST['GM_SHOW_IP'] == 0)					  {		gm_set_conf('GM_SHOW_IP', 0);gm_set_conf('GM_CONFIRM_IP', 1);	}
		if($_POST['GM_CONFIRM_IP'] == 1)				  {		gm_set_conf('GM_CONFIRM_IP',					1);				} else { gm_set_conf('GM_CONFIRM_IP',					0);	}
		if($_POST['GM_LOG_IP_LOGIN'] == 1)				  {		gm_set_conf('GM_LOG_IP_LOGIN',					1);				} else { gm_set_conf('GM_LOG_IP_LOGIN',					0);	}

		if($_POST['DISPLAY_TAX'] == 1)					  {		gm_set_conf('DISPLAY_TAX',					1);					} else { gm_set_conf('DISPLAY_TAX',					0);	}
	}
	
	elseif(isset($_POST['go_delete'])) 	{	
	
		/*
		*	-> delete stats for products_viewed
		*/
		if($_POST['products_viewed'] == 1) {	

			xtc_db_query("
							UPDATE
								products_description
							SET
								products_viewed = 0
							");
		}
	
		/*
		*	-> delete stats for products_purchased
		*/
		if($_POST['products_purchased'] == 1) {				
			xtc_db_query("
							UPDATE
								products
							SET
								products_ordered = '0'
							");
		}
	
		/*
		*	-> delete stats for vistors
		*/
		if($_POST['visitors'] == 1) {	
		
			xtc_db_query("
							DELETE							
							FROM
								gm_counter_visits	
							WHERE
								gm_counter_id != '1'
							");
		}
			
		/*
		*	-> delete stats for impressions
		*/
		if($_POST['impressions'] == 1) {	
			xtc_db_query("
							DELETE							
							FROM
								gm_counter_page
							");
			xtc_db_query("
							DELETE							
							FROM
								gm_counter_page_history
							");
		}
	
		/*
		*	-> delete stats for user_info 
		*/
		if($_POST['user_info'] == 1) {	
			xtc_db_query("
							DELETE							
							FROM
								gm_counter_info
							");
		}
	
		/*
		*	-> delete stats for intern_keywords
		*/
		if($_POST['intern_keywords'] == 1) {	
			xtc_db_query("
							DELETE							
							FROM
								gm_counter_intern_search
							");
		}
	
		/*
		*	-> delete stats for extern_keywords
		*/
		if($_POST['extern_keywords'] == 1) {	
			xtc_db_query("
							DELETE							
							FROM
								gm_counter_extern_search
							");
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
		 	<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_miscellaneous.php?content=miscellaneous"><?php echo HEADING_TITLE; ?></a></td>
		 	<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_miscellaneous.php?content=laws"><?php echo TITLE_LAW; ?></a></td>
			<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_miscellaneous.php?content=stock"><?php echo GM_TITLE_STOCK; ?></a></td>
			<td class="dataTableHeadingContentText" style="width:1%; padding-right:20px; white-space: nowrap"><a href="gm_miscellaneous.php?content=delete_images"><?php echo GM_DELETE_IMAGES_TITLE; ?></a></td>
			<td class="dataTableHeadingContentText" style="border-right: 0px"><a href="gm_miscellaneous.php?content=delete_stats"><?php echo GM_TITLE_STATS; ?></a></td>
		 </tr>
		</table>
		
		<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
			<tr class="dataTableRow">
				<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
		
					<?php 
					if(!empty($_POST['go_save'])){
						echo '<br />' . GM_MISCELLANEOUS_SUCCESS . '<br /><br />'; 
					}
					
					if(!empty($_POST['delete_images'])){
						echo '<br />' . GM_DELETE_IMAGES_MESSAGE_1 . $gm_deleted_images . GM_DELETE_IMAGES_MESSAGE_2 . $gm_images_count . GM_DELETE_IMAGES_MESSAGE_3;
						
						if($gm_images_count-$gm_deleted_images > 0){
							echo '<br />';
							if($gm_images_count-$gm_deleted_images == 1) echo $gm_images_count-$gm_deleted_images . GM_DELETE_IMAGES_ADVICE_1;
							else echo $gm_images_count-$gm_deleted_images . GM_DELETE_IMAGES_ADVICE_2;
							echo '<br />';
						}
						else echo '<br />';
					}	
					?>
					
					<?php if(empty($_GET['content']) || $_GET['content'] == 'miscellaneous'){ ?>
					
					<form name="gm_miscellaneous" action="<?php echo xtc_href_link('gm_miscellaneous.php', 'content='.$_GET['content']); ?>" method="post">
						<br />
						<strong><?php echo HEADING_TITLE; ?></strong>
						<br />
						<br />
						<input type="text" name="truncate_products_name" value="<?php echo gm_get_conf('TRUNCATE_PRODUCTS_NAME'); ?>" size="3" /> <?php echo GM_TRUNCATE_PRODUCTS_NAME; ?>
						<br />
						<br />
						<input type="text" name="truncate_products_name_history" value="<?php echo gm_get_conf('TRUNCATE_PRODUCTS_HISTORY'); ?>" size="3" /> <?php echo GM_TRUNCATE_PRODUCTS_HISTORY; ?>
						<br />
						<br />
						<input type="text" name="truncate_flyover" value="<?php echo gm_get_conf('TRUNCATE_FLYOVER'); ?>" size="3" /> <?php echo GM_TRUNCATE_FLYOVER; ?>
						<br />
						<br />
						<input type="text" name="truncate_flyover_text" value="<?php echo gm_get_conf('TRUNCATE_FLYOVER_TEXT'); ?>" size="3" /> <?php echo GM_TRUNCATE_FLYOVER_TEXT; ?>
						<br />
						<br />
						<input type="text" name="GM_ORDER_STATUS_CANCEL_ID" value="<?php echo gm_get_conf('GM_ORDER_STATUS_CANCEL_ID'); ?>" size="3" /> <?php echo GM_ORDER_STATUS_CANCEL_ID; ?>
						<br />
						<br />
						<!--
						<?php if(gm_get_conf('GM_TELL_A_FRIEND') == 'true') $gm_checked = ' checked="checked"'; else $gm_checked = '';	?>
						<input type="checkbox" name="tell_a_friend" value="1"<?php echo $gm_checked; ?> /> <?php echo GM_TELL_A_FRIEND; ?><br /><br />
						-->
						
						<?php if(gm_get_conf('TAX_INFO_TAX_FREE') == 'true') $gm_checked = ' checked="checked"'; else $gm_checked = '';	?>
						<input type="checkbox" name="tax_info_tax_free" value="1"<?php echo $gm_checked; ?> /> <?php echo GM_TAX_FREE; ?><br /><br />						
						
						<?php if(gm_get_conf('GM_HIDE_MSRP') == '1') $gm_checked = ' checked="checked"'; else $gm_checked = '';	?>
						<input type="checkbox" name="hide_msrp" value="1"<?php echo $gm_checked; ?> /> <?php echo GM_HIDE_MSRP_TEXT; ?><br /><br />

<!-- 					<input type="checkbox" name="show_products_weight" value="1" /> <?php echo GM_SHOW_PRODUCTS_WEIGHT; ?><br /><br />						
 -->
						<input style="margin-left:1px" type="submit" class="button" name="go_save" value="<?php echo BUTTON_SAVE;?>" />

					</form>
					
					<?php } elseif($_GET['content'] == 'stock'){ ?>
						<br />
						<strong><?php echo GM_TITLE_STOCK; ?></strong>
						<?php
						if(!empty($success)) echo '<br /><br /><font color="#408e2f">' . $success . '</font>';
						?>
						<br />
						<br />
					<form action="<?php echo xtc_href_link('gm_miscellaneous.php', 'content='.$_GET['content']); ?>" method="post">
						<input type="checkbox" name="show_cat_stock" value="1" /> <?php echo GM_CAT_STOCK; ?>
						<input style="margin-left:1px" type="submit" class="button" name="go_cat_stock" value="<?php echo BUTTON_EXECUTE;?>" />
						
					</form>
					
					<form action="<?php echo xtc_href_link('gm_miscellaneous.php', 'content='.$_GET['content']); ?>" method="post">
						<br />
						<br />
						<input type="checkbox" name="show_product_stock" value="1" /> <?php echo GM_PRODUCT_STOCK; ?>
						<input style="margin-left:1px" type="submit" class="button" name="go_product_stock" value="<?php echo BUTTON_EXECUTE;?>" />
						
					</form>
					
					<?php } elseif($_GET['content'] == 'delete_images'){ ?>
					
					<form action="<?php echo xtc_href_link('gm_miscellaneous.php', 'content='.$_GET['content']); ?>" method="post">
						<br />
						<strong><?php echo GM_DELETE_IMAGES_TITLE; ?></strong>
						<br />
						<br />
						<input type="checkbox" name="delete_images" value="1" /> <?php echo GM_DELETE_IMAGES; ?>
						<br /><br />
						<input style="margin-left:1px" type="submit" class="button" name="go_images" value="<?php echo BUTTON_SAVE;?>" />
						
					</form>
				
				<!-- LAW AND ORDER -->
					<?php } elseif($_GET['content'] == 'laws'){  ?>
					
					<form action="<?php echo xtc_href_link('gm_miscellaneous.php', 'content='.$_GET['content']); ?>" method="post">
					
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="main" valign="top" colspan="3">
								<br />
								<strong><?php echo TITLE_LAW; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<strong><?php echo TITLE_PRIVACY; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_SHOW_PRIVACY_REGISTRATION" value="1" <?php echo (gm_get_conf('GM_SHOW_PRIVACY_REGISTRATION') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_SHOW_REGISTRATION; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_CALLBACK" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_CALLBACK') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_CALLBACK; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_CONTACT" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_CONTACT') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_CONTACT; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_GUESTBOOK" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_GUESTBOOK') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_GUESTBOOK; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_TELL_A_FRIEND" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_TELL_A_FRIEND') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_TELL_A_FRIEND; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_FOUND_CHEAPER" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_FOUND_CHEAPER') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_FOUND_CHEAPER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_REVIEWS" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_REVIEWS') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_REVIEWS; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_ACCOUNT_CONTACT" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_ACCOUNT_CONTACT') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_ACCOUNT_CONTACT; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_ACCOUNT_ADDRESS_BOOK" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_ACCOUNT_ADDRESS_BOOK') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_ACCOUNT_ADDRESS_BOOK; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_ACCOUNT_NEWSLETTER" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_ACCOUNT_NEWSLETTER') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_ACCOUNT_NEWSLETTER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_CHECKOUT_SHIPPING" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_CHECKOUT_SHIPPING') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_CHECKOUT_SHIPPING; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="GM_CHECK_PRIVACY_CHECKOUT_PAYMENT" value="1" <?php echo (gm_get_conf('GM_CHECK_PRIVACY_CHECKOUT_PAYMENT') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_CHECKOUT_PAYMENT; ?>
							</td>
						</tr>

						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>
						
						<tr>
							<td class="main" valign="top" colspan="2">
								<strong><?php echo TITLE_CONDITIONS; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_SHOW_CONDITIONS" value="1" <?php echo (gm_get_conf('GM_SHOW_CONDITIONS') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_CONDITIONS_SHOW_ORDER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_CHECK_CONDITIONS" value="1" <?php echo (gm_get_conf('GM_CHECK_CONDITIONS') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_CONDITIONS_CHECK_ORDER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>
						
						<tr>
							<td class="main" valign="top" colspan="2">
								<strong><?php echo TITLE_WITHDRAWAL; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_SHOW_WITHDRAWAL" value="1" <?php echo (gm_get_conf('GM_SHOW_WITHDRAWAL') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_WITHDRAWAL_SHOW_ORDER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_CHECK_WITHDRAWAL" value="1" <?php echo (gm_get_conf('GM_CHECK_WITHDRAWAL') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_WITHDRAWAL_CHECK_ORDER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input size="1" type="text" name="GM_WITHDRAWAL_CONTENT_ID" value="<?php echo gm_get_conf('GM_WITHDRAWAL_CONTENT_ID'); ?>" />
								<?php echo TITLE_WITHDRAWAL_CONTENT_ID_ORDER; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>
						
						<tr>
							<td class="main" valign="top" colspan="2">
								<strong><?php echo TITLE_CONFIRMATION; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_SHOW_PRIVACY_CONFIRMATION" value="1" <?php echo (gm_get_conf('GM_SHOW_PRIVACY_CONFIRMATION') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_PRIVACY_CONFIRMATION; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_SHOW_CONDITIONS_CONFIRMATION" value="1" <?php echo (gm_get_conf('GM_SHOW_CONDITIONS_CONFIRMATION') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_CONDITIONS_CONFIRMATION; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_SHOW_WITHDRAWAL_CONFIRMATION" value="1" <?php echo (gm_get_conf('GM_SHOW_WITHDRAWAL_CONFIRMATION') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TITLE_WITHDRAWAL_CONFIRMATION; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>
						
						
						<tr>
							<td class="main" valign="top" colspan="2">
								<strong><?php echo TITLE_LOG_IP; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2" style="padding-bottom: 10px">
								<?php echo TEXT_NOTE_LOGGING ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_LOG_IP_LOGIN" value="1" <?php echo (gm_get_conf('GM_LOG_IP_LOGIN') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TEXT_LOG_IP_LOGIN; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_LOG_IP" value="1" <?php echo (gm_get_conf('GM_LOG_IP') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TEXT_LOG_IP; ?>
							</td>
						</tr>
						<!--
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="radio" name="GM_SHOW_IP" value="1" <?php echo (gm_get_conf('GM_SHOW_IP') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TEXT_SHOW_IP; ?>
							</td>
						</tr>
						-->
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="GM_CONFIRM_IP" value="1" <?php echo (gm_get_conf('GM_CONFIRM_IP') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TEXT_CONFIRM_IP; ?>
							</td>
						</tr>

						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>

						<tr>
							<td class="main" valign="top" colspan="2">
								<strong><?php echo TITLE_DISPLAY_TAX; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								<input type="checkbox" name="DISPLAY_TAX" value="1" <?php echo (gm_get_conf('DISPLAY_TAX') == 1) ? 'checked="checked"' : ''; ?> />
								<?php echo TEXT_DISPLAY_TAX; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top" colspan="2">
								&nbsp;
							</td>
						</tr>

						<tr>
							<td class="main" valign="top" colspan="2">
								<input style="margin-left:1px" type="submit" class="button" name="go_home" value="<?php echo BUTTON_SAVE;?>" />
							</td>
						</tr>
					</table>
					</form>
					
					<?php } elseif($_GET['content'] == 'delete_stats'){ ?>
					
					<form action="<?php echo xtc_href_link('gm_miscellaneous.php', 'content='.$_GET['content']); ?>" method="post">
					
					<table border="0" width="100%" cellspacing="0" cellpadding="2">
						<tr>
							<td class="main" valign="top">
								<br />
								<strong><?php echo GM_TITLE_STATS; ?></strong>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								&nbsp;
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="products_viewed" value="1" />
								<?php echo TITLE_STAT_PRODUCTS_VIEWED; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="products_purchased" value="1" />
								<?php echo TITLE_STAT_PRODUCTS_PURCHASED; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="visitors" value="1" />
								<?php echo TITLE_STAT_VISTORS; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="impressions" value="1" />
								<?php echo TITLE_STAT_IMPRESSIONS; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="user_info" value="1" />
								<?php echo TITLE_STAT_USER_INFO; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="intern_keywords" value="1" />
								<?php echo TITLE_STAT_INTERN_KEWORDS; ?>
							</td>
						</tr>
						<tr>
							<td class="main" valign="top">
								<input type="checkbox" name="extern_keywords" value="1" />
								<?php echo TITLE_STAT_EXTERN_KEWORDS; ?>
							</td>
						</tr>						
						<tr>
							<td class="main" valign="top">
								<input type="submit" class="button" name="go_delete" value="<?php echo BUTTON_SAVE;?>" />
							</td>
						</tr>
					</table>
					</form>					
					<?php } ?>
									
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