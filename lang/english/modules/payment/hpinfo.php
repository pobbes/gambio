<?php
/*
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
*/

$src = 'http://testshops.heidelpay.de/contact/index.php';
$hpIframe = '<center><div id="hpBox"><div style="background-color: #888; position:fixed; display:block; margin:0; padding:0; top:0; left:0; opacity: 0.9; -moz-opacity: 0.9; -khtml-opacity: 0.9; filter:alpha(opacity=90); z-index: 1000; width: 100%; height: 100%;"></div>';
$hpIframe.= '<div style="z-index: 1001; position: absolute; width: 900px; top: 50%; left: 50%; margin-top: -325px; margin-left: -450px; background-color: #fff;">';
$hpIframe.= '<iframe src="'.$src.'" frameborder="0" width="900" height="600" style="border: 1px solid #ddd"></iframe><br>';
$hpIframe.= '<a href="" onClick="document.getElementById(\'hpBox\').style.display=\'none\'; return false;">close</a></div></div></center>';

define('MODULE_PAYMENT_HPINFO_TEXT_TITLE', '<b style=color:#f00>Information about payment method of Heidelberger Payment GmbH.</b>');
define('MODULE_PAYMENT_HPINFO_TEXT_DESC', $hpIframe);
?>
