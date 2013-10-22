<?php
/* --------------------------------------------------------------
   show_log.php 2011-02-28 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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
/*
 * robots download
 */
require_once(DIR_FS_CATALOG.'gm/inc/get_robots.php');

// check if robots.txt obsolete
$check_robots_result = check_robots(DIR_WS_CATALOG);
if(!$check_robots_result) {
	$obsolete_warning .= ROBOTS_OBSOLETE;
}

if(isset($_POST['download_robots'])) {
    get_robots(DIR_WS_CATALOG);
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<style type="text/css">
<!--
.content_robot {
    height: 100px; border: 1px solid #DDDDDD; font-size: 12px; background-color: #F7F7F7; padding: 5px;
}
-->
</style>
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
                            <div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)">
                                <?php echo HEADING_TITLE; ?>
                            </div>
                            <br />
                            <form name="robots_download" action="<?php echo xtc_href_link('robots_download.php'); ?>" method="post">
                            <table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr class="dataTableHeadingRow">
                                    <td class="dataTableHeadingContentText" style="border-right: 0px;">
                                        <?php echo HEADING_SUB_TITLE; ?>
                                    </td>
                                </tr>
                            </table>
							<?php
							if($obsolete_warning) {
								?>
								<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
									<tr class="dataTableHeadingRow">
										<td class="dataTableHeadingContentText" style="border-right: 0px; background-color: #BB0000; color: white;"><?php echo $obsolete_warning; ?></td>
									</tr>
								</table>
								<?php
							}
							?>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <div id="log_content" class="content_robot">
                                            <?php echo TEXT_ROBOTS_DOWNLOAD; ?>
                                            <br />
                                            <br />
                                            <input type="submit" class="button" name="download_robots" value="<?php echo ROBOTS_SUBMIT; ?>" />
                                        </div>
                                    </td>
                                </tr>
                            </table>
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
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>