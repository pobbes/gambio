<?php
/* --------------------------------------------------------------
   ekomi.php 2011-11-22 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
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

	if(gm_get_conf('EKOMI_STATUS') == '1' || $_SESSION['style_edit_mode'] == 'edit')
	{
		//$box_smarty->assign('BOX_CONTENT', '');

		$box_smarty->caching = 0;
		$box_smarty->assign('language', $_SESSION['language']);

		$t_widget_code = gm_get_conf('EKOMI_WIDGET_CODE');

		if($_SESSION['style_edit_mode'] == 'edit')
		{
			$t_widget_code = preg_replace('!(.*?)<script.*?</script>(.*?)!is', "$1$2", $t_widget_code);
		}

		$box_smarty->assign('WIDGET_CODE', $t_widget_code);

		$box_ekomi = $box_smarty->fetch(CURRENT_TEMPLATE . '/boxes/box_ekomi.html');

		$gm_box_pos = $coo_template_control->get_menubox_position('ekomi');

		$smarty->assign($gm_box_pos, $box_ekomi);
	}
?>