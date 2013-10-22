<?php
/*
#   --------------------------------------------------------------
#   global_options.js 2012-04-18 tb@gambio
#   Gambio GmbH
#   http://www.gambio.de
#   Copyright (c) 2012 Gambio GmbH
#   Released under the GNU General Public License (Version 2)
#   [http://www.gnu.org/licenses/gpl-2.0.html]
#   --------------------------------------------------------------
*/
?><?php

	$array["global"] = array();
        
        // Prüfen ob StyleEdit gestartet wurde
        if($_SESSION['style_edit_mode'] == "edit"){
            $array["global"]['style_edit_mode'] = "edit";
        }else{
            $array["global"]['style_edit_mode'] = "";
        }
        
        $array["global"]["language_id"] = $_SESSION['language_id'];
        $array["global"]["language"] = $_SESSION['language'];
        $array["global"]["language_code"] = $_SESSION['language_code'];
        
        $array["global"]["http_server"] = HTTP_SERVER;
        $array["global"]["dir_ws_catalog"] = DIR_WS_CATALOG;
        $array["global"]["shop_root"] = HTTP_SERVER . DIR_WS_CATALOG;
       
        $array["global"]["shop_name"] = STORE_NAME;
?>
