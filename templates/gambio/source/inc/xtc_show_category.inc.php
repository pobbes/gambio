<?php
/* --------------------------------------------------------------
   xtc_show_category.inc.php 2008-07-09 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(categories.php,v 1.23 2002/11/12); www.oscommerce.com
   (c) 2003	 nextcommerce (xtc_show_category.inc.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtc_show_category.inc.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

     
function xtc_show_category($counter, $depth=0) {
    global $foo, $categories_string, $id, $gmSEOBoost;
	

    if ($foo[$counter]['level']=='') {
		
		if (strlen($categories_string)=='0') {
			$categories_string .='
				<div class="categories">';
		} else {
			
			for($i = -1; $i < $depth; $i++ ) {
				
				$close .= "</div>";
			
			}
			$categories_string .= $close . '</div><div class="categories">';
		}

	if($foo[$foo[$counter]['next_id']]['level'] == 0) {
		$depth = 0;
	}

		
		//$categories_string .= $img_1;
		$categories_string .= '' . gm_get_categories_icon($counter, $foo[$counter]['name']) .'<a class="strong" href="';
    } else {
		    if ( ($id) && (in_array($counter, $id)) ) {
			 $categories_string .= '' . gm_get_categories_icon($counter, $foo[$counter]['name']) .'<a class="strong" href="';
			} else {
			$categories_string .= '' . gm_get_categories_icon($counter, $foo[$counter]['name']) .'<a href="';
			}

		
    }

    if($gmSEOBoost->boost_categories)
    {
    	$gm_page = $gmSEOBoost->get_boosted_category_url($counter);
    	$categories_string .= xtc_href_link($gm_page);
    }
    else {
			$cPath_new	=	xtc_category_link($counter,$foo[$counter]['name']);
			$categories_string .= xtc_href_link(FILENAME_DEFAULT, $cPath_new);
    }
    
	// bof gm
    $categories_string .= '">';
	// eof gm

    if ( ($id) && (in_array($counter, $id)) ) {
      //$categories_string .= '<b>';
    }

    // display category name
    $categories_string .= htmlspecialchars($foo[$counter]['name']);

    if ( ($id) && (in_array($counter, $id)) ) {
      //$categories_string .= '</b>';
    }

    if ($foo[$counter]['level']=='') {
		$categories_string .= '</a>' . gm_count_products_in_category($counter) . '<br />';
    } else {
		if($foo[$foo[$counter]['next_id']]['level'] > $foo[$counter]['level'] ) {				
			$categories_string .= '</a>' . gm_count_products_in_category($counter) . '<br />';
			$depth++;

		} else {
			$categories_string .= '</a>' . gm_count_products_in_category($counter) . '</div>';			
		}
    }
			if($foo[$foo[$counter]['next_id']]['level'] < $foo[$counter]['level'] ) {
				$categories_string .= '</div>';		
				$depth--;
				
			}
	/*
	if (SHOW_COUNTS == 'true') {
		$products_in_category = xtc_count_products_in_category($counter);
		if ($products_in_category > 0) {
			$categories_string .= '&nbsp;(' . $products_in_category . ')';
		}
	}
*/
		

	//$categories_string .= '<br />';
	if ($foo[$counter]['next_id']) {
		xtc_show_category($foo[$counter]['next_id'], $depth);
	} else {
		
		if($foo[$counter]['level'] != 0 ) {
			$categories_string .= '</div>';
		} else {
			$categories_string .= '</div></div>';
		}
	}
}

?>