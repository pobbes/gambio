<?php
/* --------------------------------------------------------------
   top_menu.php 2010-09-24 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/


$coo_top_search = MainFactory::create_object('SearchContentView');
$coo_top_search->set_content_template('boxes/box_top_search.html');
$t_top_search_html = $coo_top_search->get_html();
$smarty->assign('TOP_SEARCH', $t_top_search_html);

?>