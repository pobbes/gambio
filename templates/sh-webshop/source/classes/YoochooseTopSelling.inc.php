<?php
/* --------------------------------------------------------------
   Copyright (c) 2010 - 2011 Yoochoose GmbH

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require_once(DIR_WS_INCLUDES . 'yoochoose/recommendations.php');
require_once(DIR_WS_INCLUDES . 'yoochoose/functions.php');
require_once(DIR_WS_INCLUDES . 'yoochoose/yoo_boxes.php');
require_once(DIR_FS_CATALOG.'gm/inc/gm_get_content.inc.php');



/** Creates a box Also Clicked.
 *  Is used in "yoochoose_top_selling.php".
 *
 *  Uses the stategy #getAlsoClickedStrategy() as a source 
 *  (by default "ultimately_purchased").
 *  
 *  Renders the result using template "box_yoochoose_percent_items.html".
 *  
 *  @author Rodion Alukhanov
 * */
class YoochooseTopSelling extends ContentView {
	
	function YoochooseTopSelling() {
		$this->set_content_template('boxes/box_yoochoose_percent_items.html');
	}

	function get_html($p_coo_product) {

        if (is_object($p_coo_product) && $p_coo_product->isProduct()) {
            $recomendedObjects = recommend(getTopSellingStrategy(), $p_coo_product->pID, getBoxTopSellingMaxDisplay() * 2);
            $builded = createBoxRecords($p_coo_product, $recomendedObjects, getBoxTopSellingMaxDisplay());
        } else {
        	$builded = array();
        }
		
		
		$t_html_output = '';
		
		if($builded || $_SESSION['style_edit_mode'] == 'edit') {
			
			$this->set_content_data('box_content', $builded);
			$this->set_content_data('box_header',  gm_get_content(YOOCHOOSE_BOX_TOP_SELLING_HEADER, $_SESSION['languages_id']));

			$t_html_output = $this->build_html();
		}

		return $t_html_output;
	}
}

?>