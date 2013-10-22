<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */

require_once 'functions.php';
echo "\n<!-- Yoochoose Tracking -->\n";


$logged_id = getLoggedUserId();

$user_transrefed = $_SESSION['yoochoose_transferred_user'];

echo "<!-- ".($logged_id?"user logged in":"user not logged in")." | ".($user_transrefed?"already transfered":"not transfered"). "-->\n";

$category_path = getCurrentPath($breadcrumb);
$userid = getCurrentUserId();

if ( ! $user_transrefed  && ! empty($logged_id)) {
	$trUrl = getTransferURL(getAnonymousUserId(), getLoggedUserId());
	echo "<!-- transfering user -->\n";
	echo '<img src="'.$trUrl.'" width="0" height="0" alt="">';
	 
	$_SESSION['yoochoose_transferred_user'] = true;
}

if ($user_transrefed && empty($logged_id)) {
	echo "<!-- dropping transfered user -->\n";
	
	$_SESSION['yoochoose_transferred_user'] = false;
}

// "$product" exists alwasy, even in non-product pages.
// "$coo_product_info" exists only if dispeched from product_info.php
if (is_object($product) && $product->isProduct() && is_object($coo_product_info)) {
	
	echo "<!-- product info page -->\n";
	
	if (array_key_exists('ycr', $_GET)) {
		echo '<img src="'.getTrackingURL($userid, 'follow', $product->data['products_id'], $category_path).'" width="0" height="0" alt="">';
	} else {
		echo '<img src="'.getTrackingURL($userid, 'click', $product->data['products_id'], $category_path).'" width="0" height="0" alt="">';
	}
} else 

if (isset($current_category_id) && $current_category_id && ! is_object($coo_product_info)) {
    if (array_key_exists('cat', $_GET)) {
        echo "<!-- category page -->\n";
        
        echo '<img src="'.getTrackingURL($userid, 'click', $current_category_id, $category_path, 0).'" width="0" height="0" alt="">';
    }
}

$current_page = join('', preg_grep("/.+\.php$/", preg_split("/\?|\//", $_SERVER['PHP_SELF'])));

switch ($current_page) {
    case FILENAME_CHECKOUT_SUCCESS:
        // billing daten
        $last_orders_query = xtc_db_query("select orders_id, customers_city, customers_postcode, customers_country from "
                        . TABLE_ORDERS . " where customers_id = '" . (int) $_SESSION['customer_id']
                        . "' order by date_purchased desc limit 1");
        $last_orders = xtc_db_fetch_array($last_orders_query);
        // basket daten
        $last_orders_products_query = xtc_db_query("select products_id, products_quantity, products_price, products_tax from "
                        . TABLE_ORDERS_PRODUCTS . " where orders_id = '" . (int) $last_orders['orders_id']
                        . "' order by orders_products_id");
        $count = 0;
        $purchase_time = time();
        $basket = array();
        $last_orders_totalprice = 0;
        $purchase_time = time();
        while ($last_orders_products = xtc_db_fetch_array($last_orders_products_query)) {
            for ($item_count = 0; $item_count < $last_orders_products['products_quantity']; $item_count++) {
                
                $priceCents = round($last_orders_products['products_price'] * 100);
                
                $trUrl = getTrackingURL($userid, 'buy', $last_orders_products['products_id'], $category_path);
                $trUrl = $trUrl.'&price='.$priceCents.'&timestamp='.$purchase_time;
                echo '<img src="'.$trUrl.'" width="0" height="0" alt="">';
            }
        }
        break;
        
    case FILENAME_CONTENT:

        break;
        
    case FILENAME_DEFAULT:
		// it is overwritten by SuMO / SEO. Not used anymore.
        break;
        
    case FILENAME_PRODUCT_INFO:
		// 	it is overwritten by SuMO / SEO. Not used anymore.
        break;        

}

echo "\n<!-- /Yoochoose Tracking -->\n";
?>