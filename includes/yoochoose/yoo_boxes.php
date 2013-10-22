<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */


///
/// FUNCTION COLLECTION FOR TEMPLATE BOXES
///


/** Converts a recommended objects returned by YOO-Backend into
 *  an array for using in Smarty templates.
 *  
 *  @param $recomendedObjects
 *      such arrays prepares for example the 
 *      funcrion #recommend from the functions.php.
 */
function createBoxRecords($p_coo_product, $recomendedObjects, $maxToShow) {
	
	    if ( !(defined('YOOCHOOSE_ACTIVE') && YOOCHOOSE_ACTIVE)) {
	    	return array();
	    }
    	
	    //fsk18 lock
        $t_fsk_lock = '';
        if($_SESSION['customers_status']['customers_fsk18_display'] == '0') {
            $t_fsk_lock = ' AND p.products_fsk18 != 1';
        }
        
        if(GROUP_CHECK == 'true') {
            $t_group_check = " AND p.group_permission_".$_SESSION['customers_status']['customers_status_id']." = 1 ";
        }
        
        $sql = "SELECT
                   p.*,
                   pd.products_name,
                   pd.gm_alt_text,
                   pd.products_meta_description
                   
                FROM ".TABLE_PRODUCTS." p
                JOIN ".TABLE_PRODUCTS_DESCRIPTION." pd ON pd.products_id = p.products_id 
                WHERE 
                   p.products_status = '1' AND
                   pd.language_id = '".$_SESSION['languages_id']."' AND
                   p.products_id IN (%1\$s)
                   ".$t_group_check."
                   ".$t_fsk_lock."                                             
                ORDER BY %2\$s";
        
        $records = array();
        
        if ($recomendedObjects) {
            $in = array();
            $orderBy = array();
            
            foreach ($recomendedObjects as $item) {
                $itemId = sprintf('%d',$item->itemId); 
                $in[] = $itemId;
                $orderBy[] = "p.products_id <> $itemId";
            }
            
            $random_query = xtc_db_query(sprintf($sql, join(',', $in), join(',', $orderBy)));
            
            $i = $maxToShow;
            while ($next = xtc_db_fetch_array($random_query)) {
                if ($i == 0) {
                    break;
                }            	
                $records[] = $next;
                $i--;
            }
        } 
	   
        $builded = array();
        if ($records) {
            foreach ($records as $record) { 
                // buiding some very special arrays from product records
                // such arrays are compatible with the template we are using
                $product = $p_coo_product->buildDataArray($record);
                $product['YOOCHOOSE_RELEVANCE'] = getRelevance($recomendedObjects, $product['PRODUCTS_ID']);
                $builded[] = $product;
            }
        }
            
        return $builded;
}


function getRelevance($recomendedObjects, $itemId) {
     foreach ($recomendedObjects as $item) {
     	  if ($itemId == $item->itemId) {
     	  	   return $item->relevance;
     	  }
     }
     return 0;
}



?>