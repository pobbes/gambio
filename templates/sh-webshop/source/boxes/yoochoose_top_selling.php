<?php
/* --------------------------------------------------------------
   
   (c) 2010-2011 Yoochoose GmbH
   
   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

require_once(DIR_FS_CATALOG . 'includes/yoochoose/functions.php');

$coo_specials = MainFactory::create_object('YoochooseTopSelling');
$t_box_html = $coo_specials->get_html($product);

if(is_dir(DIR_FS_CATALOG.'StyleEdit/') === false) {
	$gm_box_pos = YOOCHOOSE_BOX_TOP_SELLING_POSITION;
} else {
	$gm_box_pos = $gmBoxesMaster->get_position(YOOCHOOSE_BOX_TOP_SELLING_NAME);
}
$smarty->assign($gm_box_pos, $t_box_html);

?>