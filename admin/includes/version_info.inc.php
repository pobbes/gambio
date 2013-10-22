<?php
/* --------------------------------------------------------------
   version_info.inc.php 2012-09-17 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

include(DIR_FS_CATALOG . 'release_info.php');

$coo_cache =& DataCache::get_instance();

$css_class = '';

if(gm_get_conf('SHOP_KEY_VALID') != '1')
{
	$css_class = 'no_version_check';
}
elseif(gm_get_conf('SHOP_UP_TO_DATE') != '1')
{
	$css_class = 'new_version';
}

?>
<div id="header_version_info" class="<?php echo $css_class; ?>">
	<strong>Gambio Version:</strong> <?php echo $gx_version; ?>
</div>
