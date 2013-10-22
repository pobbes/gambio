<?php
/* --------------------------------------------------------------
   function.html_shop_offline.php 2012-10-22 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

function smarty_function_html_shop_offline()
{
	$t_output = '<br/><br/><br/>'. gm_get_conf('GM_SHOP_OFFLINE_MSG') .'<br/><br/><br/>';
	
	return $t_output;
}

?>