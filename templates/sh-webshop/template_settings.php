<?php
/* --------------------------------------------------------------
   template_settings.php 2011-01-04 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

$t_template_settings_array = array
(
	'TEMPLATE_PRESENTATION_VERSION' => 2.0,
	'MENUBOXES' => array()
);


$t_menubox_array = array(
    'categories'                 => array('POSITION' => 'gm_box_pos_1', 'STATUS' => 0),     // Categories
    'admin'                      => array('POSITION' => 'gm_box_pos_2', 'STATUS' => 1),     // Adminbox
    'filter'                     => array('POSITION' => 'gm_box_pos_3', 'STATUS' => 1),     // Filter
    'login'                      => array('POSITION' => 'gm_box_pos_4', 'STATUS' => 0),     // Login
    'search'                     => array('POSITION' => 'gm_box_pos_5', 'STATUS' => 0),     // Searchbox
	'add_quickie'                => array('POSITION' => 'gm_box_pos_6', 'STATUS' => 0),     // Quick-Buy
    'gm_ebay'                    => array('POSITION' => 'gm_box_pos_7', 'STATUS' => 1),     // Ebay
    'languages'                  => array('POSITION' => 'gm_box_pos_8', 'STATUS' => 0),     // Languages
    'currencies'                 => array('POSITION' => 'gm_box_pos_9', 'STATUS' => 0),     // Currencies
    'infobox'                    => array('POSITION' => 'gm_box_pos_10', 'STATUS' => 0),    // Customergroup
    'reviews'                    => array('POSITION' => 'gm_box_pos_11', 'STATUS' => 0),    // Reviews
	'bestsellers'                => array('POSITION' => 'gm_box_pos_12', 'STATUS' => 1),    // Bestsellers
    'whatsnew'                   => array('POSITION' => 'gm_box_pos_13', 'STATUS' => 1),    // New Products
	'gm_counter'                 => array('POSITION' => 'gm_box_pos_14', 'STATUS' => 1),    // Counter
    'last_viewed'                => array('POSITION' => 'gm_box_pos_15', 'STATUS' => 0),    // Last viewed 
    'order_history'              => array('POSITION' => 'gm_box_pos_16', 'STATUS' => 1),    // Order Hitory
    'information'                => array('POSITION' => 'gm_box_pos_17', 'STATUS' => 1),    // Informationen
    'content'                    => array('POSITION' => 'gm_box_pos_18', 'STATUS' => 1),    // Content
    'trusted'                    => array('POSITION' => 'gm_box_pos_19', 'STATUS' => 0),    // Trusted shop badge
    'gm_scroller'                => array('POSITION' => 'gm_box_pos_20', 'STATUS' => 1),    // News (Scrollbox)
	'paypal'                     => array('POSITION' => 'gm_box_pos_21', 'STATUS' => 0),    // Paypal
	'gm_trusted_shops_widget'    => array('POSITION' => 'gm_box_pos_22', 'STATUS' => 0),    // gm_trusted_shops_widget
    'newsletter'                 => array('POSITION' => 'gm_box_pos_23', 'STATUS' => 0),    // Newsletter
    'gm_bookmarks'               => array('POSITION' => 'gm_box_pos_24', 'STATUS' => 0),    // Bookmarks        
    'yoochoose_also_clicked'     => array('POSITION' => 'gm_box_pos_25', 'STATUS' => 0),    // also clicked (Yoochoose)
    'yoochoose_top_selling'      => array('POSITION' => 'gm_box_pos_26', 'STATUS' => 0),    // top selling (Yoochoose)
	'ekomi'                      => array('POSITION' => 'gm_box_pos_27', 'STATUS' => 0),    // Ekomi    
    'specials'                   => array('POSITION' => 'gm_box_pos_28', 'STATUS' => 0),    // Angebote
    'manufacturers'              => array('POSITION' => 'gm_box_pos_29', 'STATUS' => 0),    // Manufacturers    
	'manufacturers_info'         => array('POSITION' => 'gm_box_pos_30', 'STATUS' => 0),    // Manufacturers  Info  
    
	'extrabox1'                  => array('POSITION' => 'gm_box_pos_40', 'STATUS' => 1),
	'extrabox2'                  => array('POSITION' => 'gm_box_pos_41', 'STATUS' => 1),
	'extrabox3'                  => array('POSITION' => 'gm_box_pos_42', 'STATUS' => 0),
	'extrabox4'                  => array('POSITION' => 'gm_box_pos_43', 'STATUS' => 0),
	'extrabox5'                  => array('POSITION' => 'gm_box_pos_44', 'STATUS' => 0),
	'extrabox6'                  => array('POSITION' => 'gm_box_pos_45', 'STATUS' => 0),
	'extrabox7'                  => array('POSITION' => 'gm_box_pos_46', 'STATUS' => 0),
	'extrabox8'                  => array('POSITION' => 'gm_box_pos_47', 'STATUS' => 0),
	'extrabox9'                  => array('POSITION' => 'gm_box_pos_48', 'STATUS' => 0),	

);

$t_template_settings_array['MENUBOXES'] = $t_menubox_array;
?>