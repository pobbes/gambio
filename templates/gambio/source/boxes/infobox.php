<?php
/* --------------------------------------------------------------
   infobox.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (infobox.php,v 1.7 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: infobox.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   -----------------------------------------------------------------------------------------
   Third Party contributions:
   Loginbox V1.0        	Aubrey Kilian <aubrey@mycon.co.za>

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/
$box_smarty = new smarty;
$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
$box_content='';


  if ($_SESSION['customers_status']['customers_status_image']!='') {
    $loginboxcontent = xtc_image('admin/images/icons/' . $_SESSION['customers_status']['customers_status_image'],  $_SESSION['customers_status']['customers_status_name']) . '<br />';
  }
  // BOF GM_MOD:
	$loginboxcontent .= BOX_LOGINBOX_STATUS . '<strong>' . $_SESSION['customers_status']['customers_status_name'] . '</strong><br />';
  if ($_SESSION['customers_status']['customers_status_show_price'] == 0) {
    $loginboxcontent .= NOT_ALLOWED_TO_SEE_PRICES_TEXT;
  } else  {
    if ($_SESSION['customers_status']['customers_status_discount'] != '0.00') {
      // BOF GM_MOD:
			$loginboxcontent.=BOX_LOGINBOX_DISCOUNT . ': ' . (double)$_SESSION['customers_status']['customers_status_discount'] . '%<br />';
    }
    if ($_SESSION['customers_status']['customers_status_ot_discount_flag'] == 1  && $_SESSION['customers_status']['customers_status_ot_discount'] != '0.00') {
			// BOF GM_MOD:
			$loginboxcontent .= BOX_LOGINBOX_DISCOUNT_TEXT . ': '  . (double)$_SESSION['customers_status']['customers_status_ot_discount'] . '% ' . BOX_LOGINBOX_DISCOUNT_OT . '<br />';
    }
  }

	// BOF GM_MOD:
	$box_smarty->assign('GM_SHOW_BOX', $_SESSION['customers_status']['customers_status_public']);

    $box_smarty->assign('BOX_CONTENT', $loginboxcontent);
	$box_smarty->assign('language', $_SESSION['language']);
       	  // set cache ID
  if (!CacheCheck()) {
  $box_smarty->caching = 0;
  $box_infobox= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_infobox.html');
  } else {
  $box_smarty->caching = 1;
  $box_smarty->cache_lifetime=CACHE_LIFETIME;
  $box_smarty->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['customers_status']['customers_status_id'];
  $box_infobox= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_infobox.html',$cache_id);
  }
    
				$gm_box_pos = $coo_template_control->get_menubox_position('infobox');
    $smarty->assign($gm_box_pos,$box_infobox);

    ?>