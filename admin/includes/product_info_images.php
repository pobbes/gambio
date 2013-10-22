<?php
/* --------------------------------------------------------------
   product_info_images.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: product_info_images.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

// BOF GM_IMAGE_LOG
$md5_before = '';
$filetime_before = '';
if(file_exists(DIR_FS_CATALOG_GALLERY_IMAGES.$products_image_name)) {
	$md5_before			= md5_file(DIR_FS_CATALOG_GALLERY_IMAGES.$products_image_name);
	$filetime_before	= filemtime(DIR_FS_CATALOG_GALLERY_IMAGES.$products_image_name);
}
// EOF GM_IMAGE_LOG

$a = new image_manipulation(DIR_FS_CATALOG_ORIGINAL_IMAGES . $products_image_name,PRODUCT_IMAGE_INFO_WIDTH,PRODUCT_IMAGE_INFO_HEIGHT,DIR_FS_CATALOG_INFO_IMAGES . $products_image_name,IMAGE_QUALITY,'');
$array=clear_string(PRODUCT_IMAGE_INFO_BEVEL);
if (PRODUCT_IMAGE_INFO_BEVEL != ''){
$a->bevel($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_INFO_GREYSCALE);
if (PRODUCT_IMAGE_INFO_GREYSCALE != ''){
$a->greyscale($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_INFO_ELLIPSE);
if (PRODUCT_IMAGE_INFO_ELLIPSE != ''){
$a->ellipse($array[0]);}

$array=clear_string(PRODUCT_IMAGE_INFO_ROUND_EDGES);
if (PRODUCT_IMAGE_INFO_ROUND_EDGES != ''){
$a->round_edges($array[0],$array[1],$array[2]);}

$string=str_replace("'",'',PRODUCT_IMAGE_INFO_MERGE);
$string=str_replace(')','',$string);
$string=str_replace('(',DIR_FS_CATALOG_IMAGES . 'logos/',$string);
$array=explode(',',$string);
//$array=clear_string();
if (PRODUCT_IMAGE_INFO_MERGE != ''){
$a->merge($array[0],$array[1],$array[2],$array[3],$array[4]);}

$array=clear_string(PRODUCT_IMAGE_INFO_FRAME);
if (PRODUCT_IMAGE_INFO_FRAME != ''){
$a->frame($array[0],$array[1],$array[2],$array[3]);}

$array=clear_string(PRODUCT_IMAGE_INFO_DROP_SHADDOW);
if (PRODUCT_IMAGE_INFO_DROP_SHADDOW != ''){
$a->drop_shadow($array[0],$array[1],$array[2]);}

$array=clear_string(PRODUCT_IMAGE_INFO_MOTION_BLUR);
if (PRODUCT_IMAGE_INFO_MOTION_BLUR != ''){
$a->motion_blur($array[0],$array[1]);}
	  $a->create();

// BOF GM_IMAGE_LOG
$md5_after = '';
$filetime_after = '';
if(!empty($md5_before)) {
	$md5_after		= md5_file(DIR_FS_CATALOG_GALLERY_IMAGES.$products_image_name);
	$filetime_after = filemtime(DIR_FS_CATALOG_GALLERY_IMAGES.$products_image_name);
}

if($a->image_error) {
	$image_error = true;
} elseif($filetime_before != $filetime_after && $md5_befor == $md5_after) {
	$image_error = true;
}
// EOF GM_IMAGE_LOG

// BOF GM_MOD:		
@chmod(DIR_FS_CATALOG_INFO_IMAGES.$products_image_name, 0777);
?>