<?php
/* --------------------------------------------------------------
  gm_ebay.php 2012-02-10 gm
  Gambio GmbH
  http://www.gambio.de
  Copyright (c) 2012 Gambio GmbH
  Released under the GNU General Public License (Version 2)
  [http://www.gnu.org/licenses/gpl-2.0.html]
  --------------------------------------------------------------
 */

// -> start with actual obj
if (is_object($_SESSION['gm_ebay']) && empty($_GET['gm_ebay_start'])) {
	unset($_SESSION['gm_ebay']);
}
// -> create ebay obj if not exist
if (!is_object($_SESSION['gm_ebay'])) {

	$gm_ebay_conf = gm_get_conf(array('GM_EBAY_NAME', 'GM_EBAY_COUNT', 'GM_EBAY_SITE_ID', 'GM_EBAY_TYP', 'GM_EBAY_USE'));

	$gm_ebay = MainFactory::create_object('GMEbay', array($gm_ebay_conf));

	$gm_ebay->gmEbay_set();

	$_SESSION['gm_ebay'] = $gm_ebay;
}

// -> get articles
$_SESSION['gm_ebay']->gmEbay_get($_GET['gm_ebay_start']);
?>