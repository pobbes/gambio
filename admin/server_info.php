<?php
/* --------------------------------------------------------------
   server_info.php 2012-01-25 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(server_info.php,v 1.4 2003/03/17); www.oscommerce.com 
   (c) 2003	 nextcommerce (server_info.php,v 1.7 2003/08/18); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: server_info.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  $system = xtc_get_system_information();

  $coo_server_info = MainFactory::create_object('ServerInfoMaster');
  $t_server_info = $coo_server_info->get_server_info();
  
  if(isset($_POST['send']))
  {
	  $t_send_success = $coo_server_info->send($coo_server_info->format($t_server_info), $_POST['comment']);
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
    <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%">
			<div class="pageHeading" style="background-image:url(images/gm_icons/hilfsprogr1.png)"><?php echo HEADING_TITLE; ?></div>
			<br />
		</td>
      </tr>
      <tr>
	<?php
	if(function_exists('curl_init'))
	{
	?>
	  <tr>
		  <td>
			  <strong><?php echo SEND_SERVER_INFO_TITLE; ?></strong>
			 <br /><br />
			 <?php 
			 if(isset($_POST['send']) && $t_send_success == true)
			 {
			 ?>
			 <span style="font-weight: bold; color: darkgreen"><?php echo SEND_SERVER_INFO_SUCCESS; ?></span><br /><br />
			 <?php
			 }
			 elseif(isset($_POST['send']) && $t_send_success == false)
			 {
			 ?>
			 <span style="font-weight: bold; color: red"><?php echo SEND_SERVER_INFO_ERROR; ?></span><br /><br />
			 <?php
			 }
			 ?>
			 <?php echo SEND_SERVER_INFO_TEXT; ?>
			 <br /><br />
			 <form name="send_server_info" action="server_info.php" method="post" style="padding: 2px">
				  <strong><?php echo SEND_SERVER_INFO_MESSAGE_LABEL; ?></strong>
				  <br />
				  <textarea name="message" style="width: 99%; height: 300px" readonly="readonly"><?php echo htmlspecialchars_wrapper($coo_server_info->format($t_server_info)); ?></textarea>
				  <br /><br />
				  <strong><?php echo SEND_SERVER_INFO_COMMENT_LABEL; ?></strong>
				  <br />
				  <textarea name="comment" style="width: 99%; height: 100px"><?php echo htmlspecialchars_wrapper(STORE_NAME) . "\n" . htmlspecialchars_wrapper(HTTP_SERVER . DIR_WS_CATALOG); ?></textarea>
				  <br /><br />
				  <?php echo SEND_SERVER_INFO_SEND_TEXT; ?>
				  <br />
				  <input type="submit" class="button" name="send" value="<?php echo BUTTON_SEND; ?>" />
			 </form>
			 <br /><br />
			 <br /><br />
		  </td>
	  </tr>
	 <?php } ?>
	  <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td align="center"><table border="0" cellspacing="0" cellpadding="3">
              <tr>
                <td class="smallText"><b><?php echo TITLE_SERVER_HOST; ?></b></td>
                <td class="smallText"><?php echo $system['host'] . ' (' . $system['ip'] . ')'; ?></td>
                <td class="smallText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo TITLE_DATABASE_HOST; ?></b></td>
                <td class="smallText"><?php echo $system['db_server'] . ' (' . $system['db_ip'] . ')'; ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TITLE_SERVER_OS; ?></b></td>
                <td class="smallText"><?php echo $system['system'] . ' ' . $system['kernel']; ?></td>
                <td class="smallText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo TITLE_DATABASE; ?></b></td>
                <td class="smallText"><?php echo $system['db_version']; ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TITLE_SERVER_DATE; ?></b></td>
                <td class="smallText"><?php echo $system['date']; ?></td>
                <td class="smallText">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><?php echo TITLE_DATABASE_DATE; ?></b></td>
                <td class="smallText"><?php echo $system['db_date']; ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TITLE_SERVER_UP_TIME; ?></b></td>
                <td colspan="3" class="smallText"><?php echo $system['uptime']; ?></td>
              </tr>
              <tr>
                <td colspan="4"><?php echo xtc_draw_separator('pixel_trans.gif', '1', '5'); ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TITLE_HTTP_SERVER; ?></b></td>
                <td colspan="3" class="smallText"><?php echo $system['http_server']; ?></td>
              </tr>
              <tr>
                <td class="smallText"><b><?php echo TITLE_PHP_VERSION; ?></b></td>
                <td colspan="3" class="smallText"><?php echo $system['php'] . ' (' . TITLE_ZEND_VERSION . ' ' . $system['zend'] . ')'; ?></td>
              </tr>
            </table></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td>
<?php
  if (function_exists('ob_start')) {
    ob_start();
    phpinfo();
    $phpinfo = ob_get_contents();
    ob_end_clean();

    $phpinfo = str_replace('border: 1px', '', $phpinfo);
    preg_match("!<style type=\"text/css\">(.+?)</style>!s", $phpinfo, $regs);
    echo '<style type="text/css">' . $regs[1] . '</style>';
    preg_match("!<body>(.+)</body>!s", $phpinfo, $regs);
    echo $regs[1];
  } else {
    phpinfo();
  }
?>
        </td>
      </tr>
    </table></td>
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