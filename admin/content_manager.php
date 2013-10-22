<?php
/* --------------------------------------------------------------
   content_manager.php 2012-06-18 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2003	 nextcommerce (content_manager.php,v 1.18 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: content_manager.php 1304 2005-10-12 18:04:43Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------
   Third Party contribution:
   SPAW PHP WYSIWYG editor  Copyright: Solmetra (c)2003 All rights reserved. | www.solmetra.com

   Released under the GNU General Public License
   --------------------------------------------------------------*/
		
	require('includes/application_top.php');

	require_once(DIR_FS_INC			. 'xtc_format_filesize.inc.php');
	require_once(DIR_FS_INC			. 'xtc_filesize.inc.php');
	require_once(DIR_FS_ADMIN		. 'gm/fckeditor/fckeditor.php');
	
	/* BOF GM GMGroupIdChecker */
	require_once (DIR_FS_CATALOG	. 'admin/gm/classes/GMGroupIdChecker.php');
	$coo_gm_group_id_checker = new GMGroupIdChecker($_SESSION['languages_id']);
	/* EOF GM GMGroupIdChecker */

	$languages = xtc_get_languages();

	if ($_GET['special']=='delete') 
	{
		// BOF GM_MOD
		// manage teaser slider for product
		$t_content_group = xtc_db_query('SELECT content_group FROM '.TABLE_CONTENT_MANAGER.' WHERE content_id = '.xtc_db_input((int)$_GET['coID']));
		$t_result = xtc_db_fetch_array($t_content_group);
		$t_content_group_id = $t_result['content_group'];
		$coo_product_slider_handler = MainFactory::create_object('ContentSliderHandler');
		$coo_product_slider_handler->remove_content_slider($t_content_group_id);
		// EOF GM_MOD
		xtc_db_query("DELETE FROM ".TABLE_CONTENT_MANAGER." where content_id='".(int)$_GET['coID']."'");
		xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER));
	}

	if ($_GET['special']=='delete_product') 
	{
		xtc_db_query("DELETE FROM ".TABLE_PRODUCTS_CONTENT." where content_id='".(int)$_GET['coID']."'");
		xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER,'pID='.(int)$_GET['pID']));
	}

	if ($_GET['id']=='update' || $_GET['id']=='insert')
	{

		 // set allowed c.groups
		$group_ids='';

		if(isset($_POST['groups'])) foreach($_POST['groups'] as $b)
		{
			$group_ids .= 'c_'.$b."_group ,";
		}

		$customers_statuses_array=xtc_get_customers_statuses();
		
		if (strstr($group_ids,'c_all_group')) 
		{
			$group_ids='c_all_group,';
			foreach($customers_statuses_array AS $t_gm_key => $t_gm_value)
			{
			    $group_ids .='c_'.$t_gm_value['id'].'_group,';
			} 
		}

		$content_title		=	xtc_db_prepare_input($_POST['cont_title']);
		$content_header		=	xtc_db_prepare_input($_POST['cont_heading']);
		$content_text		=	xtc_db_prepare_input($_POST['cont']);
		$coID				=	xtc_db_prepare_input($_POST['coID']);
		$upload_file		=	xtc_db_prepare_input($_POST['file_upload']);
		$content_status		=	xtc_db_prepare_input($_POST['status']);
		$content_language	=	xtc_db_prepare_input($_POST['language']);
		$select_file		=	xtc_db_prepare_input($_POST['select_file']);
		$file_flag			=	xtc_db_prepare_input($_POST['file_flag']);
		$parent_check		=	xtc_db_prepare_input($_POST['parent_check']);
		$parent_id			=	xtc_db_prepare_input($_POST['parent']);
		$group_id			=	xtc_db_prepare_input($_POST['content_group']);
		$group_ids			=	$group_ids;
		$sort_order			=	xtc_db_prepare_input($_POST['sort_order']);
		$content_slider		=	xtc_db_prepare_input($_POST['content_slider']);

		// BOF GM_MOD
		$gm_link			=	trim($_POST['gm_link']);
		$gm_link_target		=	$_POST['gm_link_target'];
		$gm_priority		=	$_POST['gm_priority'];
		$gm_changefreq		=	$_POST['gm_changefreq'];
		$gm_sitemap_entry	=	$_POST['gm_sitemap_entry'];
		
		$contents_meta_title		=	$_POST['contents_meta_title'];
		$contents_meta_keywords		=	$_POST['contents_meta_keywords'];
		$contents_meta_description	=	$_POST['contents_meta_description'];
		
		$gm_url_keywords = xtc_cleanName(xtc_db_prepare_input($_POST['gm_url_keywords']));

		
		// EOF GM_MOD

		for ($i = 0, $n = sizeof($languages); $i < $n; $i++)
		{
			if ($languages[$i]['code']==$content_language)
			{
				$content_language=$languages[$i]['id'];
			}
		}

		$error=false; // reset error flag

		if(strlen($content_title) < 1) 
		{
			$error = true;
			$messageStack->add(ERROR_TITLE,'error');
		}

		if ($content_status=='yes')
		{
			$content_status=1;
		} 
		else
		{
			$content_status=0;
		}

		if ($parent_check=='yes')
		{
			$parent_id=$parent_id;
		} 
		else
		{
			$parent_id='0';
		}

		if ($error == false) 
		{
			// file upload
			if ($select_file!='default')
			{
				$content_file_name=$select_file;
			}

			//BOF GM_MOD:
			if ($content_file = &xtc_try_upload('file_upload', DIR_FS_CATALOG.'media/content/', '644', explode(',', gm_get_conf('UPLOAD_CONTENT_EXTENSIONS'))))
			{
				$content_file_name=$content_file->filename;
			}

			// BOF GM_MOD:
			$sql_data_array = array(
									'languages_id'				=> $content_language,
									'content_title'				=> $content_title,
									'content_heading'			=> $content_header,
									'content_text'				=> $content_text,
									'content_file'				=> $content_file_name,
									'content_status'			=> $content_status,
									'parent_id'					=> $parent_id,
									'group_ids'					=> $group_ids,
									'content_group'				=> $group_id,
									'sort_order'				=> $sort_order,
									'file_flag'					=> $file_flag,
									'gm_link'					=> $gm_link,
									'gm_sitemap_entry'			=> $gm_sitemap_entry,
									'gm_priority'				=> $gm_priority,
									'gm_changefreq'				=> $gm_changefreq,
									'gm_link_target'			=> $gm_link_target,
									'contents_meta_title'		=> $contents_meta_title,
									'contents_meta_keywords'	=> $contents_meta_keywords,
									'contents_meta_description'	=> $contents_meta_description,
									'gm_url_keywords'			=> $gm_url_keywords,
									'gm_last_modified'			=> 'now()'
			);

			if ($_GET['id']=='update')
			{
				// BOF GM_MOD
				// manage teaser slider for product
				$coo_product_slider_handler = MainFactory::create_object('ContentSliderHandler');
				$coo_product_slider_handler->remove_content_slider($group_id);
				if (!empty($content_slider)) {
					$coo_product_slider_handler->set_content_slider($content_slider, $group_id);
				}
				// EOF GM_MOD
				xtc_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array, 'update', "content_id = '" . $coID . "'");
				$t_coID = $coID;
			} 
			else 
			{
				xtc_db_perform(TABLE_CONTENT_MANAGER, $sql_data_array);
				$t_coID = xtc_db_insert_id();
				// BOF GM_MOD
				// manage teaser slider for product
				$coo_product_slider_handler = MainFactory::create_object('ContentSliderHandler');
				if (!empty($content_slider)) {
					$coo_product_slider_handler->set_content_slider($content_slider, $group_id);
				}
				// EOF GM_MOD
			}

			$coo_seo_boost = MainFactory::create_object('GMSEOBoost');
			$coo_seo_boost->repair('contents');

			/* BOF GM GMGroupIdChecker */
			if($coo_gm_group_id_checker->content_group_id_exist($group_id, $content_language))
			{
				$error = true;
				$t_content_group_id = $coo_gm_group_id_checker->suggest_content_group_id($content_language);
				$t_error = str_replace('{ID}', $t_content_group_id, GM_ERROR_CONTENT_GROUP_ID_EXISTS);
				$messageStack->add($t_error, 'error');
				$_GET['action'] = 'edit';
				$_GET['coID']	= $t_coID;
			}
			else
			{
				xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER));
			}
			/* EOF GM GMGroupIdChecker */
		}
	}

	if ($_GET['id']=='update_product' or $_GET['id']=='insert_product') 
	{
		// set allowed c.groups
		$group_ids='';
		if(isset($_POST['groups']))
		{
			foreach($_POST['groups'] as $b)
			{
				$group_ids .= 'c_'.$b."_group ,";
			}
		}

		$customers_statuses_array=xtc_get_customers_statuses();
		if (strstr($group_ids,'c_all_group')) 
		{
			$group_ids='c_all_group,';
			foreach($customers_statuses_array AS $t_gm_key => $t_gm_value)
			{
			    $group_ids .='c_'.$t_gm_value['id'].'_group,';
			}
		}

		$content_title		=	xtc_db_prepare_input($_POST['cont_title']);
		$content_link		=	xtc_db_prepare_input($_POST['cont_link']);
		$content_language	=	xtc_db_prepare_input($_POST['language']);
		$product			=	xtc_db_prepare_input($_POST['product']);
		$upload_file		=	xtc_db_prepare_input($_POST['file_upload']);
		$filename			=	xtc_db_prepare_input($_POST['file_name']);
		$coID				=	xtc_db_prepare_input($_POST['coID']);
		$file_comment		=	xtc_db_prepare_input($_POST['file_comment']);
		$select_file		=	xtc_db_prepare_input($_POST['select_file']);
		$group_ids			=	$group_ids;

		$error=false; // reset error flag

		for ($i = 0, $n = sizeof($languages); $i < $n; $i++) 
		{
			if ($languages[$i]['code']==$content_language)
			{
				$content_language=$languages[$i]['id'];
			}
		}

		if (strlen($content_title) < 1) 
		{
			$error = true;
			$messageStack->add(ERROR_TITLE,'error');
		}

		if ($error == false) 
		{
			/* mkdir() wont work with php in safe_mode
			if(!is_dir(DIR_FS_CATALOG.'media/products/'.$product.'/')) 
			{
				$old_umask = umask(0);
				xtc_mkdirs(DIR_FS_CATALOG.'media/products/'.$product.'/',0777);
				umask($old_umask);
			}
			*/

			if ($select_file=='default') 
			{
				if ($content_file = &xtc_try_upload('file_upload', DIR_FS_CATALOG.'media/products/')) 
				{
					$content_file_name=$content_file->filename;
					$old_filename=$content_file->filename;
					$timestamp=str_replace('.','',microtime());
					$timestamp=str_replace(' ','',$timestamp);
					$content_file_name=$timestamp.strstr($content_file_name,'.');
					$rename_string=DIR_FS_CATALOG.'media/products/'.$content_file_name;
					rename(DIR_FS_CATALOG.'media/products/'.$old_filename,$rename_string);
					copy($rename_string,DIR_FS_CATALOG.'media/products/backup/'.$content_file_name);
				}
				
				if ($content_file_name=='')
				{
					$content_file_name=$filename;
				}
			} 
			else 
			{
				$content_file_name=$select_file;
			}

			// update data in table - set allowed c.groups
			$group_ids='';
			
			if(isset($_POST['groups'])) foreach($_POST['groups'] as $b)
			{
				$group_ids .= 'c_'.$b."_group ,";
			}

			$customers_statuses_array=xtc_get_customers_statuses();
			
			if(strstr($group_ids,'c_all_group')) 
			{
				$group_ids='c_all_group,';
				foreach($customers_statuses_array AS $t_gm_key => $t_gm_value)
				{
				    $group_ids .='c_'.$t_gm_value['id'].'_group,';
				} 
			}

			$sql_data_array = array(
									'products_id'	=> $product,
									'group_ids'		=> $group_ids,
									'content_name'	=> $content_title,
									'content_file'	=> $content_file_name,
									'content_link'	=> $content_link,
									'file_comment'	=> $file_comment,
									'languages_id'	=> $content_language
			);

			if ($_GET['id']=='update_product') 
			{
				xtc_db_perform(TABLE_PRODUCTS_CONTENT, $sql_data_array, 'update', "content_id = '" . $coID . "'");
				$content_id = xtc_db_insert_id();
			} 
			else
			{
				xtc_db_perform(TABLE_PRODUCTS_CONTENT, $sql_data_array);
				$content_id = xtc_db_insert_id();
			}

			xtc_redirect(xtc_href_link(FILENAME_CONTENT_MANAGER,'pID='.$product));
		}
	}

// BOF GM_MOD
// get the slider select html
function generateContentSliderSelect($group_id)
{
	global $content_slider_array;

	$t_content_slider_check = xtc_db_query('SELECT slider_set_id FROM '.TABLE_CONTENT_SLIDER_SET.' WHERE content_slider_set_id = '.xtc_db_input($group_id));
	$t_result = xtc_db_fetch_array($t_content_slider_check);
	$t_content_slider_id = $t_result['slider_set_id'];

	$pro_slider_set_id = $pInfo->slider_set_id;
	$html = '';
	$t_text_select_none = TEXT_SELECT_NONE;
	if (strpos($p_param_name, 'index') > 0) {
		$t_text_select_none = TEXT_SELECT_NONE_INDEX;
	}
	$html .= '<select name="content_slider" size="1" style="width:130px">'."";
	$html .= '<option value="0">'.$t_text_select_none.'</option>'."<br>\n";
	foreach ($content_slider_array as $f_key => $coo_slider) {
		$t_slider_set_id = $coo_slider->v_slider_set_id;
		$t_slider_set_name = $coo_slider->v_slider_set_name;
		$t_mark  = ($t_slider_set_id == $t_content_slider_id) ? ' selected="selected"' : '';
		$html .= '<option value="'.$t_slider_set_id.'"'.$t_mark.'>'.$t_slider_set_name.'</option>'."<br>\n";
	}
	$html .= '</select>'."";
	return $html;
}
$coo_cat_slider   = MainFactory::create_object('SliderControl');
$content_slider_array = $coo_cat_slider->get_slider_set_array();
// EOF GM_MOD
	?>

	<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
	<html <?php echo HTML_PARAMS; ?>>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
	<?php
	if(preg_match('/MSIE [\d]{2}\./i', $_SERVER['HTTP_USER_AGENT']))
	{
	?>
	<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
	<?php
	}
	?>
	<title><?php echo TITLE; ?></title>
	<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
	</head>
	<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
	<!-- header //-->
	<?php require(DIR_WS_INCLUDES . 'header.php');?>

	<!-- header_eof //-->

	<!-- body //-->
	<table border="0" width="100%" cellspacing="2" cellpadding="2">
	  <tr>
		<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
	<!-- left_navigation //-->
	<?php require(DIR_WS_INCLUDES . 'column_left.php');?>
	<!-- left_navigation_eof //-->
		</table></td>
	<!-- body_text //-->
		<td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
		  <tr>
			<td width="100%">
				<div class="pageHeading" style="float:left;background-image:url(images/gm_icons/hilfsprogr1.png)"><?php echo HEADING_TITLE; ?></div>
				<?php if (!$_GET['action']) { xtc_spaceUsed(DIR_FS_CATALOG.'media/content/'); echo '<div class="pageHeading" style="text-transform:none;font-size:12px;float:right;text-align:right;" >'.USED_SPACE.xtc_format_filesize($total).'&nbsp;&nbsp;&nbsp;</div>'; } ?>
			</td>
		  </tr>
		  <tr>
			<td>
			<table width="100%" border="0">
			  <tr>
				<td>
	<?php
	if (!$_GET['action']) {
	?>
	<!-- <div class="pageHeading"><br /><?php echo HEADING_CONTENT; ?><br /></div>
	<div class="main"><?php echo CONTENT_NOTE; ?></div>
	 -->
	<?php
	// Display Content
	for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {
			$content=array();

						// BOF GM_MOD:
			 $content_query=xtc_db_query("SELECT
											content_id,
											categories_id,
											parent_id,
											group_ids,
											languages_id,
											content_title,
											content_heading,
											content_text,
											sort_order,
											file_flag,
											content_file,
											content_status,
											content_group,
											content_delete,
											gm_link,
											gm_link_target,
											gm_url_keywords
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE languages_id='".$languages[$i]['id']."'
											AND parent_id='0'
											order by sort_order
											");
			while ($content_data=xtc_db_fetch_array($content_query)) {

			 $content[]=array(
							'CONTENT_ID' =>$content_data['content_id'] ,
							'PARENT_ID' => $content_data['parent_id'],
							'GROUP_IDS' => $content_data['group_ids'],
							'LANGUAGES_ID' => $content_data['languages_id'],
							'CONTENT_TITLE' => $content_data['content_title'],
							'CONTENT_HEADING' => $content_data['content_heading'],
							'CONTENT_TEXT' => $content_data['content_text'],
							'SORT_ORDER' => $content_data['sort_order'],
							'FILE_FLAG' => $content_data['file_flag'],
							'CONTENT_FILE' => $content_data['content_file'],
							'CONTENT_DELETE' => $content_data['content_delete'],
							'CONTENT_GROUP' => $content_data['content_group'],
							'GM_URL_KEYWORDS' => $content_data['gm_url_keywords'],
							'CONTENT_STATUS' => $content_data['content_status']);

			} // while content_data


	?>
	<div class="main"><br /><strong><?php echo xtc_image(DIR_WS_LANGUAGES.$languages[$i]['directory'].'/admin/images/'.$languages[$i]['image']).'&nbsp;&nbsp;'.$languages[$i]['name']; ?></strong></div>
	<table border="0" width="100%" cellspacing="0" cellpadding="2">
				  <tr class="dataTableHeadingRow">
					<td class="dataTableHeadingContent" width="10" ><?php echo TABLE_HEADING_CONTENT_ID; ?></td>
					<td class="dataTableHeadingContent" width="10" >&nbsp;</td>
					<td class="dataTableHeadingContent" width="12%" align="left"><?php echo TABLE_HEADING_CONTENT_TITLE; ?></td>
					<td class="dataTableHeadingContent" width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_GROUP; ?></td>
					<td class="dataTableHeadingContent" width="1%" align="middle"><?php echo TABLE_HEADING_CONTENT_SORT; ?></td>
					<td class="dataTableHeadingContent" width="10%"align="left"><?php echo TABLE_HEADING_CONTENT_FILE; ?></td>
					<td class="dataTableHeadingContent" nowrap width="5%" align="left"><?php echo TABLE_HEADING_CONTENT_STATUS; ?></td>
					<td class="dataTableHeadingContent" nowrap width="" align="middle"><?php echo TABLE_HEADING_CONTENT_BOX; ?></td>
					<td class="dataTableHeadingContent" width="30%" align="middle"><?php echo TABLE_HEADING_CONTENT_ACTION; ?>&nbsp;</td>
				  </tr>
	 <?php
	for ($ii = 0, $nn = sizeof($content); $ii < $nn; $ii++) {
	 $file_flag_sql = xtc_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content[$ii]['FILE_FLAG']);
	 $file_flag_result = xtc_db_fetch_array($file_flag_sql);
	 echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";
	 if ($content[$ii]['CONTENT_FILE']=='') $content[$ii]['CONTENT_FILE']='database';
	 ?>
	 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_ID']; ?></td>
	 <td bgcolor="#<?php echo substr((6543216554/$content[$ii]['CONTENT_GROUP']),0,6); ?>" class="dataTableContent" align="left">&nbsp;</td>
	 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_TITLE']; ?><?php
	if ($content[$ii]['CONTENT_DELETE']=='0'){
	 echo '<font color="#ff0000">*</font>';
	} ?>
	 </td>
	 <td class="dataTableContent" align="middle"><?php echo $content[$ii]['CONTENT_GROUP']; ?></td>
	 <td class="dataTableContent" align="middle"><?php echo $content[$ii]['SORT_ORDER']; ?>&nbsp;</td>
	 <td class="dataTableContent" align="left"><?php echo $content[$ii]['CONTENT_FILE']; ?></td>
	 <td class="dataTableContent" align="middle"><?php if ($content[$ii]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
	 <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
	 <td class="dataTableContent" align="right">
	<?php
	 if ($content[$ii]['CONTENT_DELETE']=='1'){
	?>
	 <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content[$ii]['CONTENT_ID']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')"><?php echo xtc_image(DIR_WS_ICONS.'delete.gif','Delete','','','style="cursor:pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').' '.TEXT_DELETE.'</a>';} // if content
	?>
	 <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content[$ii]['CONTENT_ID']); ?>">
	<?php echo xtc_image(DIR_WS_ICONS.'icon_edit.gif','Edit','','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>'; ?>
	<?php
	// BOF GM_MOD
	if($content[$ii]['CONTENT_FILE'] == 'database'){
	?>
	 <a style="cursor:pointer" onClick="javascript:window.open('<?php echo xtc_href_link(FILENAME_CONTENT_PREVIEW,'coID='.$content[$ii]['CONTENT_ID']); ?>', 'popup', 'toolbar=0, width=640, height=600')"><?php echo xtc_image(DIR_WS_ICONS.'preview.gif','Preview','','','style="cursor:pointer"').' '.TEXT_PREVIEW.'</a>'; ?>
	<?php
	}
	else echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
	// EOF GM_MOD
	?>
	 </td>
	 </tr>

	 <?php
	 $content_1=array();
			 $content_1_query=xtc_db_query("SELECT
											content_id,
											categories_id,
											parent_id,
											group_ids,
											languages_id,
											content_title,
											content_heading,
											content_text,
											file_flag,
											content_file,
											content_status,
											content_delete,
											gm_url_keywords
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE languages_id='".$i."'
											AND parent_id='".$content[$ii]['CONTENT_ID']."'
											order by sort_order
											 ");
			while ($content_1_data=xtc_db_fetch_array($content_1_query)) {

			 $content_1[]=array(
							'CONTENT_ID' =>$content_1_data['content_id'] ,
							'PARENT_ID' => $content_1_data['parent_id'],
							'GROUP_IDS' => $content_1_data['group_ids'],
							'LANGUAGES_ID' => $content_1_data['languages_id'],
							'CONTENT_TITLE' => $content_1_data['content_title'],
							'CONTENT_HEADING' => $content_1_data['content_heading'],
							'CONTENT_TEXT' => $content_1_data['content_text'],
							'SORT_ORDER' => $content_1_data['sort_order'],
							'FILE_FLAG' => $content_1_data['file_flag'],
							'CONTENT_FILE' => $content_1_data['content_file'],
							'CONTENT_DELETE' => $content_1_data['content_delete'],
							'GM_URL_KEYWORDS' => $content_1_data['gm_url_keywords'],
							'CONTENT_STATUS' => $content_1_data['content_status']);
	 }
	for ($a = 0, $x = sizeof($content_1); $a < $x; $a++) {
	if ($content_1[$a]!='') {
	 $file_flag_sql = xtc_db_query("SELECT file_flag_name FROM " . TABLE_CM_FILE_FLAGS . " WHERE file_flag=" . $content_1[$a]['FILE_FLAG']);
	 $file_flag_result = xtc_db_fetch_array($file_flag_sql);
	 echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";

	 if ($content_1[$a]['CONTENT_FILE']=='') $content_1[$a]['CONTENT_FILE']='database';
	 ?>
	 <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_ID']; ?></td>
	 <td class="dataTableContent" align="left">--<?php echo $content_1[$a]['CONTENT_TITLE']; ?></td>
	 <td class="dataTableContent" align="left"><?php echo $content_1[$a]['CONTENT_FILE']; ?></td>
	 <td class="dataTableContent" align="middle"><?php if ($content_1[$a]['CONTENT_STATUS']==0) { echo TEXT_NO; } else { echo TEXT_YES; } ?></td>
	 <td class="dataTableContent" align="middle"><?php echo $file_flag_result['file_flag_name']; ?></td>
	 <td class="dataTableContent" align="right">
	 <!--<a href="">-->
	<?php
	 if ($content_1[$a]['CONTENT_DELETE']=='1'){
		?>
		<a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'special=delete&coID='.$content_1[$a]['CONTENT_ID']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
		<?php echo xtc_image(DIR_WS_ICONS.'delete.gif','Delete','','','style="cursor:pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a><br />';
		} // if content
	?>
	 <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=edit&coID='.$content_1[$a]['CONTENT_ID']); ?>">
	<?php echo xtc_image(DIR_WS_ICONS.'icon_edit.gif','Edit','','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>'; ?><br />
	 <a style="cursor:pointer" onClick="javascript:window.open('<?php echo xtc_href_link(FILENAME_CONTENT_PREVIEW,'coID='.$content_1[$a]['CONTENT_ID']); ?>', 'popup', 'toolbar=0, width=640, height=600')"><?php echo xtc_image(DIR_WS_ICONS.'preview.gif','Preview','','','style="cursor:pointer"').'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>'; ?>
	 </td>
	 </tr>


	<?php
	}
	} // for content
	} // for language
	?>
	</table>


	<?php
	}
	} else {

	switch ($_GET['action']) {
	// Diplay Editmask
	 case 'new':
	 case 'edit':
	 if ($_GET['action']!='new') {
		   // BOF GM_MOD
				 $content_query=xtc_db_query("SELECT
											content_id,
											categories_id,
											parent_id,
											group_ids,
											languages_id,
											content_title,
											content_heading,
											content_text,
											sort_order,
											file_flag,
											content_file,
											content_status,
											content_group,
											content_delete,
											gm_link,
											gm_link_target,
											gm_sitemap_entry,
											gm_priority,
											gm_changefreq,
											gm_url_keywords,
											contents_meta_title,
											contents_meta_description,
											contents_meta_keywords
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE content_id='".(int)$_GET['coID']."'");
		
		if(xtc_db_num_rows($content_query) > 0)
		{
			$content=xtc_db_fetch_array($content_query);
		}
	}
			$languages_array = array();



	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {

	  if ($languages[$i]['id']==$content['languages_id']) {
			 $languages_selected=$languages[$i]['code'];
			 $languages_id=$languages[$i]['id'];
			}
		$languages_array[] = array('id' => $languages[$i]['code'],
				   'text' => $languages[$i]['name']);

	  } // for
	  // BOF GM_MOD
		if ($languages_id!='') $content_query_string='languages_id='.$languages_id.' AND';
		$categories_query=xtc_db_query("SELECT
											content_id,
											content_title
											FROM ".TABLE_CONTENT_MANAGER."
											WHERE ".$content_query_string." parent_id='0'
											AND content_id!='".(int)$_GET['coID']."'");
	  // EOF GM_MOD
		while ($categories_data=xtc_db_fetch_array($categories_query)) {

	  $categories_array[]=array(
							'id'=>$categories_data['content_id'],
							'text'=>$categories_data['content_title']);
	 }
	?>
	<br />
	<?php
	 if ($_GET['action']!='new') {
	echo xtc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit&id=update&coID='.$_GET['coID'],'post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$_GET['coID']);
	} else {
	echo xtc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=new&id=insert','post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$_GET['coID']);
	}
	// BOF GM_MOD
	if (($content['content_delete'] !=0 && !empty($_GET['coID'])) || $_GET['action']=='new') 
	{
		// BOF GM_MOD
		if($_GET['action'] == 'new')
		{
			$languages_selected = $_SESSION['language_code'];
		}
		// EOF GM_MOD
	?>
		<table class="main gm_border dataTableRow" width="100%" border="0">
			<tr>
				<td width="15%"><?php echo TEXT_LANGUAGE; ?></td>
				<td width="85%"><?php echo xtc_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></td>
			</tr>
			<tr>
				<td width="15%"><?php echo TEXT_GROUP; ?></td>
				<td width="85%">
					<?php 
						
						$t_content_group_id = $coo_gm_group_id_checker->suggest_content_group_id($content['languages_id']);

						if(empty($content['content_group']))
						{
							$content['content_group'] = $t_content_group_id;
						}

						if($coo_gm_group_id_checker->content_group_id_exist($content['content_group'], $content['languages_id']))
						{
							echo xtc_draw_input_field('content_group',$content['content_group'],'size="5" style="border:1px solid #FF0000;"'); 					
							echo " " . str_replace('{ID}', $t_content_group_id, GM_WARNING_CONTENT_GROUP_ID_EXISTS);
						}
						else
						{
							echo xtc_draw_input_field('content_group',$content['content_group'],'size="5"'); 					
							echo TEXT_GROUP_DESC; 
						}
					?>
				</td>
			</tr>
			<?php // BOF GM_MOD
			if(!empty($content_slider_array)) { ?>
				<tr>
					<td><?php echo TITLE_CONTENT_SLIDER; ?>:</td>
					<td><?php echo generateContentSliderSelect($content['content_group']); ?></td>
				</tr>
			<?php
			} // EOF GM_MOD
						
	} else {

	echo xtc_draw_hidden_field('language',$languages_selected);
	echo xtc_draw_hidden_field('content_group',$content['content_group']);
	?>
	<table class="main gm_border dataTableRow" width="100%" border="0">
	   <tr>
		  <td width="15%"><?php echo TEXT_LANGUAGE; ?></td>
		  <td width="85%"><?php echo xtc_draw_pull_down_menu('language',$languages_array,$languages_selected,'disabled'); ?></td>
	   </tr>
		<tr>
		  <td width="15%"><?php echo TEXT_GROUP; ?></td>
		  <td width="85%"><?php echo $content['content_group']; ?></td>
	   </tr>
	<?php
	// EOF GM_MOD
	}
	if($content['content_group'] != 199 && $content['content_group'] != 198)
	{
		$file_flag_sql = xtc_db_query("SELECT file_flag as id, file_flag_name as text FROM " . TABLE_CM_FILE_FLAGS);
		while($file_flag = xtc_db_fetch_array($file_flag_sql)) {
			$file_flag_array[] = array('id' => $file_flag['id'], 'text' => $file_flag['text']);
		}
	?>
	  <tr>
		  <td width="15%"><?php echo TEXT_FILE_FLAG; ?></td>
		  <td width="85%">
		  	<?php
				if($content['content_group'] > 60 && $content['content_group'] < 70 && $content['file_flag'] == 4)
				{
					echo xtc_draw_pull_down_menu('file_flag',$file_flag_array,4,'disabled');
					echo xtc_draw_hidden_field('file_flag', 4); 
				}
				else if ($content['content_delete'] == 0 && $_GET['action'] != 'new' && $content['file_flag'] != 4)
				{
					for ($i = 0; $i < count($file_flag_array); $i++)
					{
						if ($file_flag_array[$i]['id'] == 4)
						{
							unset($file_flag_array[$i]);
							break;
						}
						$file_flag_array = array_values($file_flag_array);
					}
					echo xtc_draw_pull_down_menu('file_flag',$file_flag_array,$content['file_flag']);
				}
		  		else
		  		{
		  			echo xtc_draw_pull_down_menu('file_flag',$file_flag_array,$content['file_flag']); 
		  		}
		  	?>
		  </td>
	   </tr>
	<?php
	/*  build in not completed yet
		  <tr>
		  <td width="15%"><?php echo TEXT_PARENT; ?></td>
		  <td width="85%"><?php echo xtc_draw_pull_down_menu('parent',$categories_array,$content['parent_id']); ?><?php echo xtc_draw_checkbox_field('parent_check', 'yes',false).' '.TEXT_PARENT_DESCRIPTION; ?></td>
	   </tr>
	*/	
	?>
		<tr>
		  <td width="15%"><?php echo TEXT_SORT_ORDER; ?></td>
		  <td width="85%"><?php echo xtc_draw_input_field('sort_order',$content['sort_order'],'size="5"'); ?></td>
		</tr>
	
		  <tr>
		  <td valign="top" width="15%"><?php echo TEXT_STATUS; ?></td>
		  <td width="85%"><?php
		  if ($content['content_status']=='1') {
		  echo xtc_draw_checkbox_field('status', 'yes',true).' '.TEXT_STATUS_DESCRIPTION;
		  } else {
		  echo xtc_draw_checkbox_field('status', 'yes',false).' '.TEXT_STATUS_DESCRIPTION;
		  }

		  ?><br /><br /></td>
	   </tr>
	<?php
	}
	else
	{
	?>
	   <tr>
		  <td width="15%"><br /></td>
		  <td width="85%"><?php echo xtc_draw_hidden_field('sort_order', '0') .
									xtc_draw_hidden_field('gm_link', '') .
									xtc_draw_hidden_field('gm_link_target', '_blank') .
									xtc_draw_hidden_field('contents_meta_title', '') .
									xtc_draw_hidden_field('contents_meta_keywords', '') .
									xtc_draw_hidden_field('contents_meta_description', '') .
									xtc_draw_hidden_field('gm_url_keywords', '') .
									xtc_draw_hidden_field('gm_priority', '0.0') .
									xtc_draw_hidden_field('gm_changefreq', 'always') .
									xtc_draw_hidden_field('file_flag', '4') .
									xtc_draw_hidden_field('status', 'yes'); ?></td>
		</tr>
	<?php
	}
	?>
			  <?php
	if (GROUP_CHECK=='true') {
	$customers_statuses_array = xtc_get_customers_statuses();
	$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
	?>
	<tr>
	<td style="border-top: 1px solid; border-color: #ff0000;" valign="top" class="main" ><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
	<td style="border-top: 1px solid; border-left: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-right: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-bottom: 1px solid; border-color: #ff0000;" bgcolor="#FFCC33" class="main">
	<?php
	foreach($customers_statuses_array AS $t_gm_key => $t_gm_value)
	{
		if(strstr($content['group_ids'],'c_'.$t_gm_value['id'].'_group'))
		{
			$checked='checked ';
		} else {
			$checked='';
		}
		echo '<input type="checkbox" name="groups[]" value="'.$t_gm_value['id'].'"'.$checked.'> '.$t_gm_value['text'].'<br />';
	}
	?>
	</td>
	</tr>
	<?php
	}
	?>


	   <tr>
		  <td width="15%"><?php echo TEXT_TITLE; ?></td>
		  <td width="85%"><?php echo xtc_draw_input_field('cont_title',$content['content_title'],'size="60"'); ?></td>
	   </tr>


	   <tr>
		  <td width="15%"><?php echo TEXT_HEADING; ?></td>
		  <td width="85%"><?php echo xtc_draw_input_field('cont_heading',$content['content_heading'],'size="60"'); ?></td>
	   </tr>
	   <tr>
		  <td width="15%" valign="top"><?php echo TEXT_UPLOAD_FILE; ?></td>
		  <td width="85%"><?php echo xtc_draw_file_field('file_upload').' '.TEXT_UPLOAD_FILE_LOCAL; ?></td>
	   </tr>
			 <tr>
		  <td width="15%" valign="top"><?php echo TEXT_CHOOSE_FILE; ?></td>
		  <td width="85%">
	<?php
	 if ($dir= opendir(DIR_FS_CATALOG.'media/content/')){
	 while  (($file = readdir($dir)) !==false) {
			if (is_file( DIR_FS_CATALOG.'media/content/'.$file) and ($file !="index.html")){
			$files[]=array(
							'id' => $file,
							'text' => $file);
			}//if
			} // while
			closedir($dir);
	 }
	 // set default value in dropdown!
	if ($content['content_file']=='') {
		$default_array[]=array('id' => 'default','text' => TEXT_SELECT);
		$default_value='default';
		if (count($files) == 0)
		{
		$files = $default_array;
		}
		else
		{
		$files=array_merge($default_array,$files);
		}
	} else {
	$default_array[]=array('id' => 'default','text' => TEXT_NO_FILE);
	$default_value=$content['content_file'];
		if (count($files) == 0)
		{
		$files = $default_array;
		}
		else
		{
		$files=array_merge($default_array,$files);
		}
	}
	echo '<br />'.TEXT_CHOOSE_FILE_SERVER.'</br>';
	echo xtc_draw_pull_down_menu('select_file',$files,$default_value);
		  if ($content['content_file']!='') {
			echo TEXT_CURRENT_FILE.' <b>'.$content['content_file'].'</b><br />';
			}



	?>
		  </td>
		  </td>
	   </tr>
	   <tr>
		  <td width="15%" valign="top"></td>
		  <td colspan="85%" valign="top"><br /><?php echo TEXT_FILE_DESCRIPTION; ?></td>
	   </tr>
		 <?php // BOF GM_MOD

		 if($content['content_group'] != 199 && $content['content_group'] != 198)
		{

		 ?>
	   <tr>
		  <td width="15%"><?php echo GM_LINK; ?></td>
		  <td width="85%">
					<?php echo xtc_draw_input_field('gm_link',$content['gm_link'],'size="60"'); ?>
					<?php
						$gm_values = array();
						$gm_values[] = array('id' => '_blank', 'text' => GM_LINK_BLANK);
						$gm_values[] = array('id' => '_top', 'text' => GM_LINK_TOP);
						echo xtc_draw_pull_down_menu('gm_link_target', $gm_values, $content['gm_link_target']);
					?>
				</td>
	   </tr>
	   <?php
		}
		?>
	   <tr>
		  <td width="15%" valign="top"><?php echo TEXT_CONTENT; ?></td>

		  <td width="85%">
				<?php
				if(USE_WYSIWYG == 'true'){
					$oFCKeditor = new FCKeditor('cont');
					$oFCKeditor->BasePath	= DIR_WS_ADMIN . 'gm/fckeditor/';
					$oFCKeditor->Height = 400;
					$oFCKeditor->Value = $content['content_text'];
					$oFCKeditor->ToolbarSet = "Content";
					$oFCKeditor->Config["DefaultLanguage"] = $_SESSION['language_code'];
					$oFCKeditor->Create();
				}
				else{
					echo xtc_draw_textarea_field('cont','','100%','35',$content['content_text']);
				}
				// EOF GM_MOD
				?>
			  </td>
	   </tr>
	 <?php
	 if($content['content_group'] != 199 && $content['content_group'] != 198)
	 {
	 ?>
	<!-- BOF GM CONTENT META TAGS -->
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<tr>
		<td><span class="main"><?php echo GM_META_TITLE;		?></span></td>
		<td>
			<?php echo xtc_draw_input_field('contents_meta_title',			$content['contents_meta_title'],		'size="100"'); ?>
		</td>
	</tr>
	<tr>
		<td><span class="main"><?php echo GM_META_KEYWORDS;		?></span></td>
		<td>
			<?php echo xtc_draw_input_field('contents_meta_keywords',		$content['contents_meta_keywords'],		'size="100"'); ?>
		</td>
	</tr>
	<tr>
		<td><span class="main"><?php echo GM_META_DESCRIPTION;	?></span></td>
		<td>
			<?php echo xtc_draw_input_field('contents_meta_description',	$content['contents_meta_description'],	'size="100"'); ?>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	<!-- EOF GM CONTENT META TAGS -->
	
	<tr>
		<td><span class="main"><?php echo GM_URL_KEYWORDS; ?></span></td>
		<td>
			<?php
				echo xtc_draw_input_field('gm_url_keywords', $content['gm_url_keywords'], 'size="15"');
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">&nbsp;</td>
	</tr>
	
<!--	$gm_url_keywords = xtc_db_prepare_input($categories_data['gm_url_keywords'][$lang['id']]);
			$gm_url_keywords = xtc_cleanName($gm_url_keywords);-->
	
	<?php // BOF GM_MOD SITEMAP ?>
		  <tr>
			<td><span class="main"><?php echo GM_SITEMAP_ENTRY; ?></span></td>
			<td>
			<?php
				if($content['gm_sitemap_entry'] == '1') {
					echo xtc_draw_checkbox_field('gm_sitemap_entry', '1', true);
				} else {
					echo xtc_draw_checkbox_field('gm_sitemap_entry', '1', false);
				}
			?>
			</td>
		  </tr>

			<?php
				$gm_priority   = array();
				$gm_priority[] = array('id' => '0.0', 'text' => '0.0');
				$gm_priority[] = array('id' => '0.1', 'text' => '0.1');
				$gm_priority[] = array('id' => '0.2', 'text' => '0.2');
				$gm_priority[] = array('id' => '0.3', 'text' => '0.3');
				$gm_priority[] = array('id' => '0.4', 'text' => '0.4');
				$gm_priority[] = array('id' => '0.5', 'text' => '0.5');
				$gm_priority[] = array('id' => '0.6', 'text' => '0.6');
				$gm_priority[] = array('id' => '0.7', 'text' => '0.7');
				$gm_priority[] = array('id' => '0.8', 'text' => '0.8');
				$gm_priority[] = array('id' => '0.9', 'text' => '0.9');
				$gm_priority[] = array('id' => '1.0', 'text' => '1.0');
			?>
		  <tr>
			<td><span class="main"><?php echo GM_SITEMAP_PRIORITY; ?></span></td>
			<td><?php echo xtc_draw_pull_down_menu('gm_priority', $gm_priority, $content['gm_priority']); ?></td>
		  </tr>
			<tr>
			<td colspan="2" align="right" class="main">&nbsp;</td>
	   </tr>

		  <tr>
			<?php
				$gm_changefreq   = array();
				$gm_changefreq[] = array('id' => 'always', 'text' => TITLE_ALWAYS);
				$gm_changefreq[] = array('id' => 'hourly', 'text' => TITLE_HOURLY);
				$gm_changefreq[] = array('id' => 'daily', 'text' => TITLE_DAILY);
				$gm_changefreq[] = array('id' => 'weekly', 'text' => TITLE_WEEKLY);
				$gm_changefreq[] = array('id' => 'monthly', 'text' => TITLE_MONTHLY);
				$gm_changefreq[] = array('id' => 'yearly', 'text' => TITLE_YEARLY);
				$gm_changefreq[] = array('id' => 'never', 'text' => TITLE_NEVER);
			?>
			<td><span class="main"><?php echo GM_SITEMAP_CHANGEFREQ; ?></span></td>
			<td><?php echo xtc_draw_pull_down_menu('gm_changefreq', $gm_changefreq, $content['gm_changefreq']); ?></td>
		  </tr>
	<?php // EOF GM_MOD SITEMAP
	 }
	?>

		<tr>
			<td colspan="2" align="right" class="main">&nbsp;</td>
	   </tr>
		<tr>
			<td colspan="2" align="right" class="main"><?php echo '<input style="float:left" type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?><a style="float:left" class="button" onClick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER); ?>"><?php echo BUTTON_BACK; ?></a></td>
	   </tr>
	</table>
	</form>
	<?php
	 break;

	 case 'edit_products_content':
	 case 'new_products_content':
	 // bof gm
		echo '<div class="gm_border dataTableRow">';
	 // eof gm



	  if ($_GET['action']=='edit_products_content') {
			$content_query=xtc_db_query("SELECT
											content_id,
											products_id,
											group_ids,
											content_name,
											content_file,
											content_link,
											languages_id,
											file_comment,
											content_read

											FROM ".TABLE_PRODUCTS_CONTENT."
											WHERE content_id='".(int)$_GET['coID']."'");

			$content=xtc_db_fetch_array($content_query);
	}

	 // get products names.
	 $products_query=xtc_db_query("SELECT
									products_id,
									products_name
									FROM ".TABLE_PRODUCTS_DESCRIPTION."
									WHERE language_id='".(int)$_SESSION['languages_id']."'");
	 $products_array=array();

	 while ($products_data=xtc_db_fetch_array($products_query)) {

	 $products_array[]=array(
							'id' => $products_data['products_id'],
							'text' => $products_data['products_name']);
	}

	 // get languages
	 $languages_array = array();



	  for ($i = 0, $n = sizeof($languages); $i < $n; $i++) {

	  if ($languages[$i]['id']==$content['languages_id']) {
			 $languages_selected=$languages[$i]['code'];
			 $languages_id=$languages[$i]['id'];
			}
		$languages_array[] = array('id' => $languages[$i]['code'],
				   'text' => $languages[$i]['name']);

	  } // for

	  // get used content files
	  $content_files_query=xtc_db_query("SELECT DISTINCT
									content_name,
									content_file
									FROM ".TABLE_PRODUCTS_CONTENT."
									WHERE content_file!=''");
	 $content_files=array();

	 while ($content_files_data=xtc_db_fetch_array($content_files_query)) {

	 $content_files[]=array(
							'id' => $content_files_data['content_file'],
							'text' => $content_files_data['content_name']);
	}

	 // add default value to array
	 $default_array[]=array('id' => 'default','text' => TEXT_SELECT);
	 $default_value='default';
	 $content_files=array_merge($default_array,$content_files);
	 // mask for product content

	 if ($_GET['action']!='new_products_content') {
	 ?>
	 <?php echo xtc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit_products_content&id=update_product&coID='.$_GET['coID'],'post','enctype="multipart/form-data"').xtc_draw_hidden_field('coID',$_GET['coID']); ?>
	<?php
	} else {
	?>
	<?php echo xtc_draw_form('edit_content',FILENAME_CONTENT_MANAGER,'action=edit_products_content&id=insert_product','post','enctype="multipart/form-data"');   ?>
	<?php
	}
	?>
	 <div class="main"><?php echo TEXT_CONTENT_DESCRIPTION; ?></div>
	 <table class="main" width="100%" border="0">
	   <tr>
		  <td width="15%"><?php echo TEXT_PRODUCT; ?></td>
		  <td width="85%"><?php echo xtc_draw_pull_down_menu('product',$products_array,$content['products_id']); ?></td>
	   </tr>
		  <tr>
		  <td width="15%"><?php echo TEXT_LANGUAGE; ?></td>
		  <td width="85%"><?php echo xtc_draw_pull_down_menu('language',$languages_array,$languages_selected); ?></td>
	   </tr>

			  <?php
	if (GROUP_CHECK=='true') {
	$customers_statuses_array = xtc_get_customers_statuses();
	$customers_statuses_array=array_merge(array(array('id'=>'all','text'=>TXT_ALL)),$customers_statuses_array);
	?>
	<tr>
	<td style="border-top: 1px solid; border-color: #ff0000;" valign="top" class="main" ><?php echo ENTRY_CUSTOMERS_STATUS; ?></td>
	<td style="border-top: 1px solid; border-left: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-right: 1px solid; border-color: #ff0000;" style="border-top: 1px solid; border-bottom: 1px solid; border-color: #ff0000;" bgcolor="#FFCC33" class="main">
	<?php

	foreach($customers_statuses_array AS $t_gm_key => $t_gm_value)
	{
		if(strstr($content['group_ids'],'c_'.$t_gm_value['id'].'_group'))
		{		
			$checked='checked ';
		} else {
			$checked='';
		}
		echo '<input type="checkbox" name="groups[]" value="'.$t_gm_value['id'].'"'.$checked.'> '.$t_gm_value['text'].'<br />';
	}
	?>
	</td>
	</tr>
	<?php
	}
	?>

		  <tr>
		  <td width="15%"><?php echo TEXT_TITLE_FILE; ?></td>
		  <td width="85%"><?php echo xtc_draw_input_field('cont_title',$content['content_name'],'size="60"'); ?></td>
	   </tr>
		  <tr>
		  <td width="15%"><?php echo TEXT_LINK; ?></td>
		  <td width="85%"><?php  echo xtc_draw_input_field('cont_link',$content['content_link'],'size="60"'); ?></td>
	   </tr>
		 <tr>
		  <td width="15%" valign="top"><?php echo TEXT_FILE_DESC; ?></td>
		  <td width="85%">
					<?php
					// BOF GM_MOD
						if(USE_WYSIWYG == 'true'){
						$oFCKeditor = new FCKeditor('file_comment');
						$oFCKeditor->BasePath	= DIR_WS_ADMIN . 'gm/fckeditor/';
						$oFCKeditor->Height = 400;
						$oFCKeditor->Value = $content['file_comment'];
						$oFCKeditor->ToolbarSet = "Content";
						$oFCKeditor->Config["DefaultLanguage"] = $_SESSION['language_code'];
						$oFCKeditor->Create();
					}
					else{
						echo xtc_draw_textarea_field('cont','','100%','35',$content['file_comment']);
					}
					// EOF GM_MOD
					?>
				</td>
	   </tr>
		  <tr>
		  <td width="15%"><?php echo TEXT_CHOOSE_FILE; ?></td>
		  <td width="85%"><?php echo xtc_draw_pull_down_menu('select_file',$content_files,$default_value); ?><?php echo ' '.TEXT_CHOOSE_FILE_DESC; ?></td>
	   </tr>
		  <tr>
		  <td width="15%" valign="top"><?php echo TEXT_UPLOAD_FILE; ?></td>
		  <td width="85%"><?php echo xtc_draw_file_field('file_upload').' '.TEXT_UPLOAD_FILE_LOCAL; ?></td>
	   </tr>
	 <?php
	 if ($content['content_file']!='') {
	 ?>
		<tr>
		  <td width="15%"><?php echo TEXT_FILENAME; ?></td>
		  <td width="85%" valign="top"><?php echo xtc_draw_hidden_field('file_name',$content['content_file']).xtc_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.','',strstr($content['content_file'],'.')).'.gif').$content['content_file']; ?></td>
		</tr>
	  <?php
	}
	?>
		   <tr>
			<td colspan="2" align="left" class="main"><br /><br /><?php echo '<input style="float:left;" type="submit" class="button" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?><a style="float:left;" class="button" onClick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER); ?>"><?php echo BUTTON_BACK; ?></a></td>
	   </tr>
	   </form>
	   </table>

	 <?php
	 // bof gm
		echo '</div>';
	 // eof gm
	 break;


	}
	}

	if (!$_GET['action']) {
	?>

	<a class="button" onClick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=new'); ?>"><?php echo BUTTON_NEW_CONTENT; ?></a>
	<?php
	}
	?>
	</td>
			  </tr>
			</table>
	 <?php
	 if (!$_GET['action']) {
	 // products content
	 // load products_ids into array

	 $products_id_query=xtc_db_query("SELECT DISTINCT
									pc.products_id,
									pd.products_name
									FROM ".TABLE_PRODUCTS_CONTENT." pc, ".TABLE_PRODUCTS_DESCRIPTION." pd
									WHERE pd.products_id=pc.products_id and pd.language_id='".(int)$_SESSION['languages_id']."'");

	 $products_ids=array();
	 while ($products_id_data=xtc_db_fetch_array($products_id_query)) {

			$products_ids[]=array(
							'id'=>$products_id_data['products_id'],
							'name'=>$products_id_data['products_name']);

			} // while


	 ?></br>
	 <div class="pageHeading"  style="background-image:url(images/gm_icons/hilfsprogr1.png)"><?php echo HEADING_PRODUCTS_CONTENT; ?></div>
	  <?php xtc_spaceUsed(DIR_FS_CATALOG.'media/products/');
	 echo '<div class="main" style="text-align:right">'.USED_SPACE.xtc_format_filesize($total).'</div>';
	?>
	 <table border="0" width="100%" cellspacing="0" cellpadding="2">
		<tr class="dataTableHeadingRow">
		 <td class="dataTableHeadingContent" nowrap width="5%" ><?php echo TABLE_HEADING_PRODUCTS_ID; ?></td>
		 <td class="dataTableHeadingContent" width="95%" align="left"><?php echo TABLE_HEADING_PRODUCTS; ?></td>
	</tr>
	<?php

	for ($i=0,$n=sizeof($products_ids); $i<$n; $i++) {
	 echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";

	 ?>
	 <td class="dataTableContent_products" align="left"><?php echo $products_ids[$i]['id']; ?></td>
	 <td class="dataTableContent_products" align="left"><b><?php echo xtc_image(DIR_WS_CATALOG.'images/icons/arrow.gif'); ?><a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'pID='.$products_ids[$i]['id']);?>"><?php echo $products_ids[$i]['name']; ?></a></b></td>
	 </tr>
	<?php
	if ($_GET['pID']) {
	// display content elements
			$content_query=xtc_db_query("SELECT
											content_id,
											content_name,
											content_file,
											content_link,
											languages_id,
											file_comment,
											content_read
											FROM ".TABLE_PRODUCTS_CONTENT."
											WHERE products_id='".$_GET['pID']."' order by content_name");
			$content_array='';
			while ($content_data=xtc_db_fetch_array($content_query)) {

					$content_array[]=array(
											'id'=> $content_data['content_id'],
											'name'=> $content_data['content_name'],
											'file'=> $content_data['content_file'],
											'link'=> $content_data['content_link'],
											'comment'=> $content_data['file_comment'],
											'languages_id'=> $content_data['languages_id'],
											'read'=> $content_data['content_read']);

					} // while content data

	if ($_GET['pID']==$products_ids[$i]['id']){
	?>

	<tr>
	 <td class="dataTableContent" align="left"></td>
	 <td class="dataTableContent" align="left">

	 <table border="0" width="100%" cellspacing="0" cellpadding="2">
		<tr class="dataTableHeadingRow">
		<td class="dataTableHeadingContent" nowrap width="2%" ><?php echo TABLE_HEADING_PRODUCTS_CONTENT_ID; ?></td>
		<td class="dataTableHeadingContent" nowrap width="2%" >&nbsp;</td>
		<td class="dataTableHeadingContent" nowrap width="5%" ><?php echo TABLE_HEADING_LANGUAGE; ?></td>
		<td class="dataTableHeadingContent" nowrap width="15%" ><?php echo TABLE_HEADING_CONTENT_NAME; ?></td>
		<td class="dataTableHeadingContent" nowrap width="30%" ><?php echo TABLE_HEADING_CONTENT_FILE; ?></td>
		<td class="dataTableHeadingContent" nowrap width="1%" ><?php echo TABLE_HEADING_CONTENT_FILESIZE; ?></td>
		<td class="dataTableHeadingContent" nowrap align="middle" width="20%" ><?php echo TABLE_HEADING_CONTENT_LINK; ?></td>
		<td class="dataTableHeadingContent" nowrap width="5%" ><?php echo TABLE_HEADING_CONTENT_HITS; ?></td>
		<td class="dataTableHeadingContent" nowrap width="20%" ><?php echo TABLE_HEADING_CONTENT_ACTION; ?></td>
		</tr>

	<?php

	 for ($ii=0,$nn=sizeof($content_array); $ii<$nn; $ii++) {

	 echo '<tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\'" onmouseout="this.className=\'dataTableRow\'">' . "\n";

	 ?>
	 <td class="dataTableContent" align="left"><?php echo  $content_array[$ii]['id']; ?> </td>
	 <td class="dataTableContent" align="left"><?php



	 if ($content_array[$ii]['file']!='') {

	 echo xtc_image(DIR_WS_CATALOG.'admin/images/icons/icon_'.str_replace('.','',strstr($content_array[$ii]['file'],'.')).'.gif');
	} else {
	echo xtc_image(DIR_WS_CATALOG.'admin/images/icons/icon_link.gif');
	}

	for ($xx=0,$zz=sizeof($languages); $xx<$zz;$xx++){
		if ($languages[$xx]['id']==$content_array[$ii]['languages_id']) {
		$lang_dir=$languages[$xx]['directory'];
		break;
		}
	}

	?>
	</td>
	 <td class="dataTableContent" align="left"><?php echo xtc_image(DIR_WS_CATALOG.'lang/'.$lang_dir.'/admin/images/icon.gif'); ?></td>
	 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['name']; ?></td>
	 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['file']; ?></td>
	 <td class="dataTableContent" align="left"><?php echo xtc_filesize($content_array[$ii]['file']); ?></td>
	 <td class="dataTableContent" align="left" align="middle"><?php
	 if ($content_array[$ii]['link']!='') {
	 echo '<a href="'.$content_array[$ii]['link'].'" target="new">'.$content_array[$ii]['link'].'</a>';
	}
	 ?>
	  &nbsp;</td>
	 <td class="dataTableContent" align="left"><?php echo $content_array[$ii]['read']; ?></td>
	 <td class="dataTableContent" align="left">

	  <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'special=delete_product&coID='.$content_array[$ii]['id']).'&pID='.$products_ids[$i]['id']; ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
	 <?php

	 echo xtc_image(DIR_WS_ICONS.'delete.gif','Delete','','','style="cursor:pointer" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';

	?>
	 <a href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=edit_products_content&coID='.$content_array[$ii]['id']); ?>">
	<?php echo xtc_image(DIR_WS_ICONS.'icon_edit.gif','Edit','','','style="cursor:pointer"').'  '.TEXT_EDIT.'</a>'; ?>

	<?php
	// display preview button if filetype
	// .gif,.jpg,.png,.html,.htm,.txt,.tif,.bmp
	if (	preg_match('/.gif/i',$content_array[$ii]['file'])
		or
		preg_match('/.jpg/i',$content_array[$ii]['file'])
		or
		preg_match('/.png/i',$content_array[$ii]['file'])
		or
		preg_match('/.html/i',$content_array[$ii]['file'])
		or
		preg_match('/.htm/i',$content_array[$ii]['file'])
		or
		preg_match('/.txt/i',$content_array[$ii]['file'])
		or
		preg_match('/.bmp/i',$content_array[$ii]['file'])
		) {
	?>
	 <a style="cursor:pointer" onClick="javascript:window.open('<?php echo xtc_href_link(FILENAME_CONTENT_PREVIEW,'pID=media&coID='.$content_array[$ii]['id']); ?>', 'popup', 'toolbar=0, width=640, height=600')"


	 ><?php echo xtc_image(DIR_WS_ICONS.'preview.gif','Preview','','',' style="cursor:pointer"').'&nbsp;&nbsp;'.TEXT_PREVIEW.'</a>'; ?>
	<?php
	}
	?>



	 </td>
	 </tr>

	<?php

	} // for content_array
	echo '</table></td></tr>';
	}
	} // for
	}
	?>


	 </table>
	 <a class="button" onClick="this.blur();" href="<?php echo xtc_href_link(FILENAME_CONTENT_MANAGER,'action=new_products_content'); ?>"><?php echo BUTTON_NEW_CONTENT; ?></a>
	 <?php
	} // if !$_GET['action']
	?>

			</td>
		  </tr>
		</table></td>
	<!-- body_text_eof //-->
	  </tr>
	</table>
	<!-- body_eof //-->

	<!-- footer //-->
	<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
	<!-- footer_eof //-->
	</body>
	</html>

	<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>