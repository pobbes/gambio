<?php
/* --------------------------------------------------------------
   clear_cache.php 2012-01-27 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com
   (c) 2003      nextcommerce (start.php,1.5 2004/03/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: start.php 1235 2005-09-21 19:11:43Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------
*/

/*
 * needed functions
 */
require_once('includes/application_top.php');


$coo_cache_control =& MainFactory::create_object('CacheControl');

# backward compatibility:
if(isset($_GET['reset_categories_index']))
{
	$coo_cache_control->clear_cache();
	$_GET['manual_categories_index'] = '1';
}

if(isset($_GET['manual_output'])) {
	$coo_cache_control->clear_content_view_cache();
	$coo_cache_control->clear_templates_c();
}
if(isset($_GET['manual_data_cache'])) {
	$coo_cache_control->clear_data_cache();
}
if(isset($_GET['manual_feature_index'])) {
	$coo_cache_control->rebuild_products_feature_index();
}
if(isset($_GET['manual_submenu'])) {
	$coo_cache_control->rebuild_categories_submenus_cache();
}
if(isset($_GET['manual_categories_index'])) {
	$coo_cache_control->rebuild_products_categories_index();
}
if(isset($_GET['manual_products_properties_index'])) {
	$coo_cache_control->rebuild_products_properties_index();
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
           <span class="main">
               <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="100%">
                            <div class="pageHeading" style="float:left; background-image:url(images/gm_icons/hilfsprogr1.png)">
                                <?php echo HEADING_TITLE; ?>
                            </div>
                            <br />
                            <br />

                            <table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr class="dataTableHeadingRow">
                                    <td class="dataTableHeadingContentText" style="border-right: 0px;">
                                        <?php  echo HEADING_TITLE; ?>
                                    </td>
                                </tr>
                            </table>

                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <div id="log_content" style="padding: 10px; border: 1px solid #DDDDDD; font-size: 12px; background-color: #F7F7F7;">
											<?php // if(empty($_GET)) echo TEXT_MESSAGE . '<br /><br />'; ?>

											<form action="clear_cache.php" method="get">
											<div class="cache_row">
												<div class="cache_button">
													<input class="button" style="width: auto; display: inline-block" type="submit" name="manual_output" value="<?php echo BUTTON_OUTPUT_CACHE; ?>" />
													<?php if(isset($_GET['manual_output'])) echo '<div class="status">OK!</div>'; ?>
													<div class="cache_clear"> <!-- --> </div>
												</div>
												<div class="cache_info"><?php echo TEXT_OUTPUT_CACHE; ?></div>
											</div>
												
											<div class="cache_row">
												<div class="cache_button">
													<input class="button" style="width: auto; display: inline-block" type="submit" name="manual_data_cache" value="<?php echo BUTTON_DATA_CACHE; ?>" />
													<?php if(isset($_GET['manual_data_cache'])) echo '<div class="status">OK!</div>'; ?>
													<div class="cache_clear"> <!-- --> </div>
												</div>
												<div class="cache_info"><?php echo TEXT_DATA_CACHE; ?></div>
											</div>

											<?php
											if(class_exists('CategoriesSubmenusContentView', true) == true) {
											?>
											<div class="cache_row">
												<div class="cache_button">
													<input class="button" style="width: auto; display: inline-block" type="submit" name="manual_submenu" value="<?php echo BUTTON_SUBMENUS_CACHE; ?>" />
													<?php if(isset($_GET['manual_submenu'])) echo '<div class="status">OK!</div>'; ?>
													<div class="cache_clear"> <!-- --> </div>
												</div>
												<div class="cache_info"><?php echo TEXT_SUBMENUS_CACHE; ?></div>
											</div>
											<?php } ?>
												
											<div class="cache_row">
												<div class="cache_button">
													<input class="button" style="width: auto; display: inline-block" type="submit" name="manual_categories_index" value="<?php echo BUTTON_CATEGORIES_CACHE; ?>" />
													<?php if(isset($_GET['manual_categories_index'])) echo '<div class="status">OK!</div>'; ?>
													<div class="cache_clear"> <!-- --> </div>
												</div>
												<div class="cache_info"><?php echo TEXT_CATEGORIES_CACHE; ?></div>
											</div>
												
											<div class="cache_row">
												<div class="cache_button">
													<input class="button" style="width: auto; display: inline-block" type="submit" name="manual_products_properties_index" value="<?php echo BUTTON_PROPERTIES_CACHE; ?>" />
													<?php if(isset($_GET['manual_products_properties_index'])) echo '<div class="status">OK!</div>'; ?>
													<div class="cache_clear"> <!-- --> </div>
												</div>
												<div class="cache_info"><?php echo TEXT_PROPERTIES_CACHE; ?></div>
											</div>
												
											<div class="cache_row">
												<div class="cache_button">
													<input class="button" style="width: auto; display: inline-block" type="submit" name="manual_feature_index" value="<?php echo BUTTON_FEATURES_CACHE; ?>" />
													<?php if(isset($_GET['manual_feature_index'])) echo '<div class="status">OK!</div>'; ?>
													<div class="cache_clear"> <!-- --> </div>
												</div>
												<div class="cache_info"><?php echo TEXT_FEATURES_CACHE; ?></div>
											</div>
											</form>

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
            </span>
        </td>
        <!-- body_text_eof //-->
    </tr>
</table>
<!-- body_eof //-->

<style type="text/css">
	
	.cache_row{
		margin: 12px 0 20px 0;
	}
	
	.cache_button{
		margin: 0 0 5px 0;
	}
	
	.cache_button input{
		float: left;
		display: block;
		text-align: center;
		margin: 0;
	}
	
	.cache_button .status{
		width: 30px;
		float: left;
		display: block;
		font-weight: bold;
		height: 25px;
		line-height: 25px;
		margin: 0 0 0 10px;
	}
	
	.cache_clear{
		clear: both;
	}
	
</style>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>