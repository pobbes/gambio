<?php
/* --------------------------------------------------------------
   gm_ajax.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php


require('includes/application_top.php');



switch($_GET['module'])
{
	case 'guestbook': 							include(DIR_FS_CATALOG.'gm/ajax/guestbook.php'); break;
	case 'calculate_price': 				include(DIR_FS_CATALOG.'gm/ajax/attributes_calculator.php'); break;
	case 'calculate_weight': 				include(DIR_FS_CATALOG.'gm/ajax/attributes_weight_calculator.php'); break;
	case 'attribute_images': 				include(DIR_FS_CATALOG.'gm/ajax/attribute_images.php'); break;
	case 'tell_a_friend': 					include(DIR_FS_CATALOG.'gm/ajax/tell_a_friend.php'); break;
	case 'products_images_popup':		include(DIR_FS_CATALOG.'gm/ajax/products_images_popup.php'); break;
	case 'callback_service': 				include(DIR_FS_CATALOG.'gm/ajax/callback_service.php'); break;
	case 'order_quantity_checker': 	include(DIR_FS_CATALOG.'gm/ajax/order_quantity_checker.php'); break;
	case 'mega_flyover': 						include(DIR_FS_CATALOG.'gm/ajax/mega_flyover.php'); break;
	case 'live_search': 						include(DIR_FS_CATALOG.'gm/ajax/live_search.php'); break;
	case 'product_images': 					include(DIR_FS_CATALOG.'gm/ajax/product_images.php'); break;
	case 'gmotion': 					include(DIR_FS_CATALOG.'gm/ajax/gmotion.php'); break;
	
	case 'admin_fav_master': 			include(DIR_FS_CATALOG.'gm/ajax/admin_fav_master.php'); break;
	case 'admin_leftboxes': 			include(DIR_FS_CATALOG.'gm/ajax/admin_leftboxes.php'); break;
	case 'admin_lang_edit': 			include(DIR_FS_CATALOG.'gm/ajax/admin_lang_edit.php'); break;
}
mysql_close();
?>