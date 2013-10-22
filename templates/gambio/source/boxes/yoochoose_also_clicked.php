<?php
/* --------------------------------------------------------------
   Copyright (c) 2010 - 2011 Yoochoose GmbH
   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_WS_INCLUDES . 'yoochoose/recommendations.php');
require_once(DIR_WS_INCLUDES . 'yoochoose/functions.php');
require_once(DIR_WS_INCLUDES . 'yoochoose/yoo_boxes.php');
require_once(DIR_FS_CATALOG.'gm/inc/gm_get_content.inc.php');



$box_smarty = new smarty;
$box_smarty->assign('tpl_path', 'templates/'.CURRENT_TEMPLATE.'/');
$box_content = '';
// include needed functions
require_once (DIR_FS_INC.'xtc_random_select.inc.php');


        if (is_object($product) && $product->isProduct()) {
            $recomendedObjects = recommend(getAlsoClickedStrategy(), $product->pID, getBoxAlsoClickedMaxDisplay() * 2);
            $builded = createBoxRecords($product, $recomendedObjects, getBoxAlsoClickedMaxDisplay());
        } else {
            $builded = array();
        }
        
        
if ($builded || $_SESSION['style_edit_mode'] == 'edit') {

	$box_smarty->assign('language', $_SESSION['language']);
	$box_smarty->assign('box_content', $builded);
	$box_smarty->assign('box_header', gm_get_content(YOOCHOOSE_BOX_ALSO_CLICKED_HEADER, $_SESSION['languages_id']));
	
	// set cache ID
	 if (!CacheCheck()) {
		$box_smarty->caching = 0;
		$box_specials = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_yoochoose_items.html');
	} else {
		$box_smarty->caching = 1;
		$box_smarty->cache_lifetime = CACHE_LIFETIME;
		$box_smarty->cache_modified_check = CACHE_CHECK;
		$cache_id = $_SESSION['language'].$random_product["products_id"].$_SESSION['customers_status']['customers_status_name'];
		$box_specials = $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_yoochoose_items.html', $cache_id);
	}

  //GM_MOD:
  	if(is_dir(DIR_FS_CATALOG.'StyleEdit/') === false) {
  		$gm_box_pos = YOOCHOOSE_BOX_ALSO_CLICKED_POSITION;
  	} else {
		$gm_box_pos = $gmBoxesMaster->get_position('yoochoose_also_clicked');
  	}
			
	$smarty->assign($gm_box_pos, $box_specials);
}
?>