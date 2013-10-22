<?php
/* --------------------------------------------------------------
   function.gm_footer.php 2010-12-21 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

function smarty_function_gm_footer($params, &$smarty)
{
	$coo_footer = MainFactory::create_object('FooterContentView');
	$t_view_html = $coo_footer->get_html();
	
	return $t_view_html;
}
?>