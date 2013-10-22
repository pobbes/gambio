<?php
/* --------------------------------------------------------------
   econda.php 2012-02-14 gm
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
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: econda.php 1235 2009-04-20 09:49:00Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

require ('includes/application_top.php');

define('TRACKING_ECONDA_ACTIVE_TITLE','econda Shop Monitor aktivieren ?');
define('TRACKING_ECONDA_ACTIVATE','Aktivierungscode');
define('TRACKING_ECONDA_ACTIVE_DESC','(Damit wird der econda Shop Monitor gestartet.)');
define('TRACKING_ECONDA_UPDATE_SUCCESS','&Auml;nderungen wurden gespeichert.');
define('TRACKING_ECONDA_UPDATE_FAILED','&Auml;nderungen konnten nicht gespeichert werden.');
define('TRACKING_ECONDA_ID_TITLE','Aktivierungscode');
define('TRACKING_ECONDA_ID_DESC','Geben Sie hier Ihren Aktivierungscode ein, den Sie von econda erhalten haben.<p><div class="big_link">Einen kostenlosen Testzugang k&ouml;nnen Sie <a href="http://www.econda.de/produkte/landing-page/partner/gambio.html?=campaign/gambio/admin" target="_new">[HIER]</a> anfordern!</div></p>');

$get_activation_query = xtc_db_query("select * from " . TABLE_CONFIGURATION . " where configuration_group_id = '23' and configuration_key = 'TRACKING_ECONDA_ACTIVE'");
$get_activation_array = xtc_db_fetch_array($get_activation_query);
$isactivated = $get_activation_array['configuration_value'];

$get_key_query = xtc_db_query("select * from " . TABLE_CONFIGURATION . " where configuration_group_id = '23' and configuration_key = 'TRACKING_ECONDA_ID'");
$get_key_array = xtc_db_fetch_array($get_key_query);
$activationkey = $get_key_array['configuration_value'];


  if ($_GET['action']) {
    switch ($_GET['action']) {
      case 'save':
   	
      	$updateOK = 0;
      	
      	if($_POST['econda_active']) {$setActive = 'true';}
      	else {$setActive = 'false';}
      	$setKey = trim($_POST['econda_key']);
 	
         if(xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$setActive."' where configuration_key='TRACKING_ECONDA_ACTIVE'")) {
         	$updateOK += 1;
         }
         if(xtc_db_query("UPDATE ".TABLE_CONFIGURATION." SET configuration_value='".$setKey."' where configuration_key='TRACKING_ECONDA_ID'")) {
         	$updateOK += 1;
         }  
              xtc_redirect('econda.php?u='.$updateOK);
        break;

    }
  }

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<link rel="stylesheet" type="text/css" href="../includes/econda/style.css">
<script type="text/javascript" src="gm/javascript/LoadUrl.js"></script>
</head>
<body bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<script language="JavaScript" type="text/javascript">
$(document).ready(function(){
	var coo_load_url = new LoadUrl();
	coo_load_url.load_url('load_content');
});
</script>

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
			<div class="pageHeading" style="background-image:url(images/gm_icons/module.png)">econda Shop Monitor</div>
			<br />
			<span class="main">
				<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr class="dataTableHeadingRow">
						<td class="dataTableHeadingContentText">Aktivierung</td>
					</tr>
				</table>
			
				<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
					<tr class="dataTableRow">
						<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
							<br />
							<form name="econda_form" action="<?php echo xtc_href_link('econda.php?action=save'); ?>" method="post">
							<?php echo TRACKING_ECONDA_ACTIVE_TITLE; ?>&nbsp;<input type="checkbox" name="econda_active" value="<?php echo $isactivated; ?>"<?php if($isactivated  == 'true') echo ' checked'; ?> />&nbsp;&nbsp;<?php echo TRACKING_ECONDA_ACTIVE_DESC; ?>
							<br />
							<br />
							<?php echo TRACKING_ECONDA_ACTIVATE; ?>&nbsp;&nbsp;<input type="text" name="econda_key" value="<?php echo $activationkey; ?>" size="15" />&nbsp;<?php echo TRACKING_ECONDA_ID_DESC; ?>
							<?php
							echo '<input style="margin-left:1px" type="submit" name="go" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/> ';
							if(isset($_GET['u']) && $_GET['u'] == 2) echo "<br /><font color=\"green\">".TRACKING_ECONDA_UPDATE_SUCCESS."</font>";
							elseif(isset($_GET['u']) && $_GET['u'] != 2) echo "<br /><font color=\"red\">".TRACKING_ECONDA_UPDATE_FAILED."</font>";
							?>
							</form>

						</td>
					</tr>
				</table>
	
				<div id="content_loader">
					<div id="url_loader">
						<img id="loading" src="../images/loading.gif" />
						<?php echo TEXT_CONTENT_LOADING; ?>
					</div>
					<div class="load_url">http://news.gambio.de/econda/conditions.html</div>
				</div>
			</span>

		</td>
		<!-- body_text_eof //-->
	</tr>
</table>

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>