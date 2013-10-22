<?php
/* --------------------------------------------------------------
   top_menu.php 2011-06-07 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/


$coo_top_navigation = MainFactory::create_object('TopNavigationContentView');
$coo_top_navigation->set_content_template('boxes/box_top_navigation.html');
$t_top_navigation_html = $coo_top_navigation->get_html();
$smarty->assign('TOP_NAVIGATION', $t_top_navigation_html);

$coo_login_dropdown = MainFactory::create_object('LoginboxContentView');
$coo_login_dropdown->set_content_template('boxes/box_login_dropdown.html');
$t_login_dropdown_html = $coo_login_dropdown->get_html();
$smarty->assign('LOGIN_DROPDOWN', $t_login_dropdown_html);

$coo_infobox_dropdown = MainFactory::create_object('InfoboxContentView');
$coo_infobox_dropdown->set_content_template('boxes/box_infobox_dropdown.html');
$t_infobox_dropdown_html = $coo_infobox_dropdown->get_html();
$smarty->assign('INFOBOX_DROPDOWN', $t_infobox_dropdown_html);

$t_currencies_dropwdown_html = '';
if(gm_get_conf('SHOW_TOP_CURRENCY_SELECTION') == 'true')
{
	$coo_currencies_dropwdown = MainFactory::create_object('CurrenciesContentView');
	$coo_currencies_dropwdown->set_content_template('boxes/box_currencies_dropdown.html');
	$t_currencies_dropwdown_html = $coo_currencies_dropwdown->get_html($request_type, $_GET);
}
$smarty->assign('CURRENCIES_DROPDOWN', $t_currencies_dropwdown_html);

$t_languages_dropwdown_html = '';
if(gm_get_conf('SHOW_TOP_LANGUAGE_SELECTION') == 'true')
{
	if(!isset($lng) && !is_object($lng))
	{
		include(DIR_WS_CLASSES . 'language.php');
		$lng = new language;
	}
	$coo_languages_dropwdown = MainFactory::create_object('LanguagesContentView');
	$coo_languages_dropwdown->set_content_template('boxes/box_languages_dropdown.html');
	$t_languages_dropwdown_html = $coo_languages_dropwdown->get_html($lng, $request_type);
}
$smarty->assign('LANGUAGES_DROPDOWN', $t_languages_dropwdown_html);

?>