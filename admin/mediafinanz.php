<?php
/* --------------------------------------------------------------
   mediafinanz.php 2012-02-08 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

/* -----------------------------------------------------------------------------------------
   Copyright (c) 2011 mediafinanz AG

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see http://www.gnu.org/licenses/.
   ---------------------------------------------------------------------------------------

 * @author Marcel Kirsch
 */
$version = phpversion();
$majorVersion = explode('.', $version);
$majorVersion = intval($majorVersion[0]);

if ($majorVersion < 5)
{
    return;
}

  require('includes/application_top.php');
  $isPopup = isset($_GET['popup']) ? true : false;

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
    <title><?php echo TITLE; ?></title>
    <link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
    <link rel="stylesheet" type="text/css" href="includes/modules/mediafinanz/style/stylesheet.css">
    <link href="includes/javascript/spiffyCal/spiffyCal_v2_1.css" type="text/css" rel="stylesheet">
    <script src="includes/javascript/spiffyCal/spiffyCal_v2_1.js" type="text/javascript"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<div id="spiffycalendar" class="text"></div>
<?php

if (!$isPopup)
{
    //include header:
    require(DIR_WS_INCLUDES . 'header.php');

    //include body:
    echo '<table border="0" width="100%" cellspacing="2" cellpadding="2">
            <tr>
                <td class="columnLeft2" width="'.BOX_WIDTH.'" valign="top"><table border="0" width="'.BOX_WIDTH.'" cellspacing="1" cellpadding="1" class="columnLeft">';

    //include left navigation:
    require(DIR_WS_INCLUDES . 'column_left.php');

    echo '</table></td>';
}
else
{
    //include body:
    echo '<table border="0" width="100%" cellspacing="2" cellpadding="2">
            <tr>
                <td class="columnLeft2" width="100%" valign="top"><table border="0" width="0" cellspacing="1" cellpadding="1" class="columnLeft">';

}


$coo_mediafinanz = MainFactory::create_object('GMDataObject', array('mf_config', array('config_key' => 'clientLicence')));
$t_mediafinanz_licence = $coo_mediafinanz->get_data_value('config_value');

if($_GET['action'] != 'errors' && empty($t_mediafinanz_licence))
{
	$_GET['action'] = 'config';
}


switch ($_GET['action'])
{
    case 'display':
        require_once('./includes/modules/mediafinanz/display.php');
    break;
    case 'errors':
        require_once('./includes/modules/mediafinanz/errors.php');
    break;
    case 'claims':
        require_once('./includes/modules/mediafinanz/claims.php');
    break;
    case 'process_claim':
        require_once('./includes/modules/mediafinanz/process_claims.php');
    break;
    case 'display_claim':
        require_once('./includes/modules/mediafinanz/display_claim.php');
    break;
    case 'close_claim':
        require_once('./includes/modules/mediafinanz/close_claim.php');
    break;
    case 'config':
        require_once('./includes/modules/mediafinanz/config.php');
    break;
    case 'direct_payment':
        require_once('./includes/modules/mediafinanz/direct_payment.php');
    break;
    default:
        require_once('./includes/modules/mediafinanz/main.php');
    break;
}



echo '</tr></table>';

if (!$isPopup)
{
    //footer:
    require(DIR_WS_INCLUDES . 'footer.php');
}

echo '<br>
      </body>
      </html>';

require(DIR_WS_INCLUDES . 'application_bottom.php');
?>