<?php
/* --------------------------------------------------------------
   popup_content.php 2011-07-29 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (content_preview.php,v 1.2 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: popup_content.php 1169 2005-08-22 16:07:09Z mz $)
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require ('includes/application_top.php');

$content_query = xtDBquery("SELECT
 					*
 					FROM ".TABLE_CONTENT_MANAGER."
 					WHERE content_group='".(int) $_GET['coID']."' and languages_id = '".$_SESSION['languages_id']."'");
$content_data = xtc_db_fetch_array($content_query, true);
?>
<html <?php echo HTML_PARAMS; ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>" />
		<meta http-equiv="Content-Style-Type" content="text/css" />
		<title><?php echo $content_data['content_heading']; ?></title>
		<base href="<?php echo GM_HTTP_SERVER . DIR_WS_CATALOG; ?>">
		<link rel="stylesheet" type="text/css" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/stylesheet.css'; ?>" />
		<link type="text/css" rel="stylesheet" href="<?php echo 'templates/'.CURRENT_TEMPLATE.'/gm_dynamic.css.php'.$renew_cache; ?>" />
	</head>
	<body>
<?php
if(isset($_GET['lightbox_mode']) && $_GET['lightbox_mode'] == '1')
{
?>
		<div id="content_page" class="popup_content">
			<h1>
				<?php echo $content_data['content_heading']; ?>
			</h1>
			<div class="content_text">
				<?php
				if($content_data['content_file'] != '')
				{
					if(strpos($content_data['content_file'], '.txt'))
					{
						echo '<pre>';
					}

					include(DIR_FS_CATALOG . 'media/content/' . basename($content_data['content_file']));

					if(strpos($content_data['content_file'], '.txt'))
					{
						echo '</pre>';
					}
				}
				else
				{
					echo $content_data['content_text'];
				}
				?>
			</div>
		</div>
<?php
}
else
{
?>

<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="contentsTopics"><?php echo $content_data['content_heading']; ?></td>
  </tr>
</table>
<br>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
          <tr>
            <td class="main">
 <?php

if ($content_data['content_file'] != '') {
	if (strpos($content_data['content_file'], '.txt'))
		echo '<pre>';

	include (DIR_FS_CATALOG.'media/content/'.$content_data['content_file']);

	if (strpos($content_data['content_file'], '.txt'))
		echo '</pre>';
} else {
	echo $content_data['content_text'];
}
?>
<br><br>
<p class="smallText" align="right">
<script type="text/javascript">
<!-- 
document.write("<a href='javascript:window.close()'><?php echo TEXT_CLOSE_WINDOW; ?></a>")
// -->
</script>
<noscript><?php echo TEXT_CLOSE_WINDOW_NO_JS; ?></noscript>
</p>
</td>
          </tr>
        </table>
<?php
}
?>
</body>
</html>
<?php 
// BOF GM_MOD:
mysql_close(); 
?>