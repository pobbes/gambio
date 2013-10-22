<?php
/* --------------------------------------------------------------
   gm_corner.gif.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

require('includes/application_top.php');

if(gm_get_conf('GM_GAMBIO_CORNER') == 1){
	$gm_bg_color = xtc_db_query("SELECT cc.style_value
															 FROM 
															 		gm_css_style c,
																	gm_css_style_content cc
																WHERE
																	c.style_name = '.wrap_shop'
																	AND c.gm_css_style_id = cc.gm_css_style_id
																	AND cc.style_attribute = 'background-color'
																LIMIT 1");


	if(xtc_db_num_rows($gm_bg_color) == 1){
		$row = xtc_db_fetch_array($gm_bg_color);
		$color = substr($row['style_value'], 1, strlen($row['style_value']));
		$r = hexdec(substr($color, 0, 2));
		$g = hexdec(substr($color, 2, 2));
		$b = hexdec(substr($color, 4, 2));
		$image = imagecreate(10, 10);
		$body_color = imagecolorallocate($image, $r, $g, $b);
		
		$gm_topmenu_color = xtc_db_query("SELECT cc.style_value
																			FROM 
																		 		gm_css_style c,
																				gm_css_style_content cc
																			WHERE
																				c.style_name = '#topmenu_block'
																				AND c.gm_css_style_id = cc.gm_css_style_id
																				AND cc.style_attribute = 'background-color'
																			LIMIT 1");
		if(xtc_db_num_rows($gm_topmenu_color) == 1){
			$row = xtc_db_fetch_array($gm_topmenu_color);
			$color = substr($row['style_value'], 1, strlen($row['style_value']));
			$r = hexdec(substr($color, 0, 2));
			$g = hexdec(substr($color, 2, 2));
			$b = hexdec(substr($color, 4, 2));
			$topmenu_bg = imagecolorallocate($image, $r, $g, $b);
			$poly = array(10, 0, 10, 10, 0, 10);
			imagefilledpolygon($image, $poly, 3, $topmenu_bg); 
			header("Content-Type: image/gif"); 
			imagegif($image);
		}
	}
	else{
		$image = imagecreate(10, 10);
		$body_color = imagecolorallocate($image, 255, 255, 255);  
		$topmenu_bg = imagecolorallocate($image, 0, 101, 173); 
		$poly = array(10, 0, 10, 10, 0, 10); 
		imagefilledpolygon($image, $poly, 3, $topmenu_bg); 
		header("Content-Type: image/gif"); 
		imagegif($image);
	}
}
else{
	$gm_topmenu_color = xtc_db_query("SELECT cc.style_value
																		FROM 
																	 		gm_css_style c,
																			gm_css_style_content cc
																		WHERE
																			c.style_name = '#topmenu_block'
																			AND c.gm_css_style_id = cc.gm_css_style_id
																			AND cc.style_attribute = 'background-color'
																		LIMIT 1");
	if(xtc_db_num_rows($gm_topmenu_color) == 1){
		$row = xtc_db_fetch_array($gm_topmenu_color);
		$color = substr($row['style_value'], 1, strlen($row['style_value']));
		$r = hexdec(substr($color, 0, 2));
		$g = hexdec(substr($color, 2, 2));
		$b = hexdec(substr($color, 4, 2));
		$image = imagecreate(10, 10);
		$body_color = imagecolorallocate($image, $r, $g, $b);
		header("Content-Type: image/gif"); 
		imagegif($image);
	}
	else{
		$image = imagecreate(10, 10);
		$body_color = imagecolorallocate($image, 0, 101, 173); 
		header("Content-Type: image/gif"); 
		imagegif($image);
	}
}
?>