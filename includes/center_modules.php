<?php
/* --------------------------------------------------------------
   center_modules.php 2008-04-26 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercebased on original files from OSCommerce CVS 2.2 2002/08/28 02:14:35 www.oscommerce.com 
   (c) 2003	 nextcommerce (center_modules.php,v 1.5 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: center_modules.php 899 2005-04-29 02:40:57Z hhgag $) 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


	//TOP
	require(DIR_WS_MODULES . FILENAME_NEW_PRODUCTS);	
	
	//UPCOMING
  require(DIR_WS_MODULES . FILENAME_UPCOMING_PRODUCTS);
	
	//SPECIALS
  require(DIR_WS_MODULES . 'specials_main.php');
	
	//NEW
  require(DIR_WS_MODULES . 'products_new_main.php');
	
	return $module;
?>