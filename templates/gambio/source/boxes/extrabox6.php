<?php

/* --------------------------------------------------------------

   extrabox6.php 2008-08-09 gambio

   Gambio OHG

   http://www.gambio.de

   Copyright (c) 2008 Gambio OHG

   Released under the GNU General Public License

   --------------------------------------------------------------

*/

?><?php

/* ----------------------------------------------------------------------------------------- 

   -----------------------------------------------------------------------------------------

   based on: 

   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)

   (c) 2002-2003 osCommerce(add_a_quickie.php,v 1.10 2001/12/19); www.oscommerce.com

   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: add_a_quickie.php,v 1.1 2004/04/26 20:26:42 fanta2k Exp $) 



   Released under the GNU General Public License 

   -----------------------------------------------------------------------------------------

   Third Party contribution:

   Add A Quickie v1.0 Autor  Harald Ponce de Leon

    

   Released under the GNU General Public License

   ---------------------------------------------------------------------------------------*/



// reset var

$box_smarty = new smarty;

$box_content='';

$box_smarty->assign('tpl_path','templates/'.CURRENT_TEMPLATE.'/');



  if (GROUP_CHECK=='true') {

	$group_check = "and group_ids LIKE '%c_".$_SESSION['customers_status']['customers_status_id']."_group%'";

  }



$content_query = xtDBquery("SELECT

					*

 					FROM ".TABLE_CONTENT_MANAGER."

 					WHERE

						content_group='66' and languages_id = '".$_SESSION['languages_id']."'

						$group_check

					");

$content_data = xtc_db_fetch_array($content_query, true);



if((xtc_db_num_rows($content_query) && $content_data['content_status'] == '1') || $_SESSION['style_edit_mode'] == 'edit')

{



	if ($content_data['content_file'] != '') {

		ob_start();

		if (strpos($content_data['content_file'], '.txt'))

			echo '<pre>';

		include (DIR_FS_CATALOG.'media/content/'.$content_data['content_file']);

		if (strpos($content_data['content_file'], '.txt'))

			echo '</pre>';

		$content_body = ob_get_contents();

		ob_end_clean();



	} else {

		$content_body = $content_data['content_text'];

	}



  $box_smarty->assign('BOX_HEADING', $content_data['content_heading'] );

  //$box_smarty->assign('BOX_CONTENT', $content_body );

	    if($_SESSION['style_edit_mode'] != 'edit') $box_smarty->assign('BOX_CONTENT', $content_body );

	$box_smarty->assign('language', $_SESSION['language']);

	  // set cache ID

  if (USE_CACHE=='false') {

  $box_smarty->caching = 0;

  $box_content= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_extrabox6.html');

  } else {

  $box_smarty->caching = 1;	

  $box_smarty->cache_lifetime=CACHE_LIFETIME;

  $box_smarty->cache_modified_check=CACHE_CHECK;

  $cache_id = $_SESSION['language'];

  $box_content= $box_smarty->fetch(CURRENT_TEMPLATE.'/boxes/box_extrabox6.html',$cache_id);

  }

  

			$gm_box_pos = $coo_template_control->get_menubox_position('extrabox6');

	$smarty->assign($gm_box_pos, $box_content);  

}

?>