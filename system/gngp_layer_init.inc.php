<?php
/* --------------------------------------------------------------
   gngp_layer_init.inc.php 2012-01-09 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/


require_once(DIR_FS_CATALOG.'system/core/Debugger.inc.php');
require_once(DIR_FS_CATALOG.'system/core/DataCache.inc.php');
require_once(DIR_FS_CATALOG.'system/core/StopWatch.inc.php');

require_once(DIR_FS_CATALOG.'system/core/CachedDirectory.inc.php');
require_once(DIR_FS_CATALOG.'system/core/Registry.inc.php');
require_once(DIR_FS_CATALOG.'system/core/ClassRegistry.inc.php');
require_once(DIR_FS_CATALOG.'system/core/ClassOverloadRegistry.inc.php');
require_once(DIR_FS_CATALOG.'system/core/MainFactory.inc.php');
require_once(DIR_FS_CATALOG.'system/core/MainAutoloader.inc.php');

require_once(DIR_FS_CATALOG.'system/views/ContentView.inc.php');
require_once(DIR_FS_CATALOG.'system/request_port/AjaxHandler.inc.php');

require_once(DIR_FS_CATALOG.'system/data/GMDataObject.inc.php');
require_once(DIR_FS_CATALOG.'system/data/GMDataObjectGroup.inc.php');

?>