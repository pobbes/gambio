<?php
/* --------------------------------------------------------------
   languages.php 2010-09-23 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(languages.php,v 1.14 2003/02/12); www.oscommerce.com
   (c) 2003	 nextcommerce (languages.php,v 1.8 2003/08/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: languages.php 1262 2005-09-30 10:00:32Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

if(!isset($lng) && !is_object($lng))
{
	include_once(DIR_WS_CLASSES . 'language.php');
	$lng = new language;
}

$coo_languages = MainFactory::create_object('LanguagesContentView');
$t_box_html = $coo_languages->get_html($lng, $request_type);

$gm_box_pos = $coo_template_control->get_menubox_position('languages');
$smarty->assign($gm_box_pos, $t_box_html);

?>