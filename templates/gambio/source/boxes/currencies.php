<?php
/* --------------------------------------------------------------
   currencies.php 2012-06-26 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(currencies.php,v 1.16 2003/02/12); www.oscommerce.com 
   (c) 2003	 nextcommerce (currencies.php,v 1.11 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: currencies.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

  // include functions
  require_once(DIR_FS_INC . 'xtc_hide_session_id.inc.php');
  if (isset($xtPrice) && is_object($xtPrice)) {

    $count_cur='';
    reset($xtPrice->currencies);
    $currencies_array = array();
    while (list($key, $value) = each($xtPrice->currencies)) {
    $count_cur++;
      $currencies_array[] = array('id' => $key, 'text' => $value['title']);
    }

    $hidden_get_variables = '';
    reset($_GET);
    while (list($key, $value) = each($_GET)) {
      if ( ($key != 'currency') && ($key != xtc_session_name()) && ($key != 'x') && ($key != 'y') ) {
        $hidden_get_variables .= xtc_draw_hidden_field($key, $value);
      }
    }


  }


  // dont show box if there's only 1 currency
  if ($count_cur > 1 ) {

  // reset var
  $box_smarty = new smarty;
  $box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');
  $box_content='';
	// BOF GM_MOD:
  $box_content=xtc_draw_form('currencies', xtc_href_link(basename($PHP_SELF), '', $request_type, false, true, true), 'get').xtc_draw_pull_down_menu('currency', $currencies_array, $_SESSION['currency'], 'onchange="this.form.submit();" style="width: 100%" class="lightbox_visibility_hidden"') . $hidden_get_variables . xtc_hide_session_id().'</form>';


  $box_smarty->assign('BOX_CONTENT', $box_content);
  $box_smarty->assign('language', $_SESSION['language']);
    	  // set cache ID
   if (!CacheCheck()) {
  $box_smarty->caching = 0;
  $box_currencies= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_currencies.html');
  } else {
  $box_smarty->caching = 1;	
  $box_smarty->cache_lifetime=CACHE_LIFETIME;
  $box_smarty->cache_modified_check=CACHE_CHECK;
  $cache_id = $_SESSION['language'].$_SESSION['currency'];
  $box_currencies= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_currencies.html',$cache_id);
  }

			$gm_box_pos = $coo_template_control->get_menubox_position('currencies');
			
  $smarty->assign($gm_box_pos,$box_currencies);

  }
 ?>