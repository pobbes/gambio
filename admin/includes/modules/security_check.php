<?php
/* --------------------------------------------------------------
   security_check.php 2011-05-12 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


 based on:
 (c) 2003	 nextcommerce (security_check.php,v 1.2 2003/08/23); www.nextcommerce.org
 (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: security_check.php 1221 2005-09-20 16:44:09Z mz $)

 Released under the GNU General Public License
 --------------------------------------------------------------*/
defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');

$file_warning = '';
$obsolete_warning = '';

if (@is_writable(DIR_FS_CATALOG.'includes/configure.php')) {
	$file_warning .= '<br>'.DIR_FS_CATALOG.'includes/configure.php';
}

if (@is_writable(DIR_FS_CATALOG.'includes/configure.org.php')) {
	$file_warning .= '<br>'.DIR_FS_CATALOG.'includes/configure.org.php';
}

if (@is_writable(DIR_FS_ADMIN.'includes/configure.php')) {
	$file_warning .= '<br>'.DIR_FS_ADMIN.'includes/configure.php';
}

if (@is_writable(DIR_FS_ADMIN.'includes/configure.org.php')) {
	$file_warning .= '<br>'.DIR_FS_ADMIN.'includes/configure.org.php';
}

if (!@is_writable(DIR_FS_CATALOG.'templates_c/')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'templates_c/';
}

if (!@is_writable(DIR_FS_CATALOG.'cache/')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'cache/';
}

if (!@is_writable(DIR_FS_CATALOG.'media/')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'media/';
}

if (!@is_writable(DIR_FS_CATALOG.'media/content/')) {
	$folder_warning .= '<br>'.DIR_FS_CATALOG.'media/content/';
}

// check if robots.txt obsolete
require_once(DIR_FS_CATALOG.'gm/inc/get_robots.php');
$check_robots_result = check_robots(DIR_WS_CATALOG);
if(!$check_robots_result) {
	$obsolete_warning .= '<br>'.HTTP_SERVER.'/robots.txt - <a href="'.DIR_WS_ADMIN.'robots_download.php">download robots.txt</a>';
}

$t_db_update_not_installed = false;
if(file_exists(DIR_FS_CATALOG . 'gm_updater.php') && file_exists(DIR_FS_CATALOG . 'gm_updater_sql.php'))
{
	include_once(DIR_FS_CATALOG . 'release_info.php');
	$t_db_shop_version = gm_get_conf('GM_UPDATER_VERSION');
	if($t_db_shop_version != $gx_version)
	{
		$t_db_update_not_installed = true;
	}
}

if ($file_warning != '' or $folder_warning != '' or $obsolete_warning != '' or $t_db_update_not_installed === true) {
?>

<table style="border: 1px solid; border-color: #ff0000;"
	bgcolor="#FDAC00" border="0" width="100%" cellspacing="0"
	cellpadding="0">
	<tr>
		<td><div class="main">
		<table width="100%" border="0">
			<tr>
				<td width="1"><?php echo xtc_image(DIR_WS_ICONS.'big_warning.gif'); ?></td>
				<td class="main"><?php

				if ($file_warning != '') {

					echo TEXT_FILE_WARNING;

					echo '<b>'.$file_warning.'</b><br>';
				}

				if ($folder_warning != '') {

					echo TEXT_FOLDER_WARNING;

					echo '<b>'.$folder_warning.'</b>';
				}

				// if any file obsolete
				if ($obsolete_warning != '') {

					echo TEXT_OBSOLETE_WARNING;

					echo '<b>'.$obsolete_warning.'</b><br />';
				}
				
				// DB not up to date
				if($t_db_update_not_installed)
				{
					echo TEXT_DB_UPDATE_WARNING;
				}

				$payment_query = xtc_db_query("SELECT *
				FROM ".TABLE_CONFIGURATION."
				WHERE configuration_key = 'MODULE_PAYMENT_INSTALLED'");
				while ($payment_data = xtc_db_fetch_array($payment_query)) {
					$installed_payment = $payment_data['configuration_value'];

				}
				if ($installed_payment == '') {
					echo '<br>'.TEXT_PAYMENT_ERROR;
				}
				$shipping_query = xtc_db_query("SELECT *
				FROM ".TABLE_CONFIGURATION."
				WHERE configuration_key = 'MODULE_SHIPPING_INSTALLED'");
				while ($shipping_data = xtc_db_fetch_array($shipping_query)) {
					$installed_shipping = $shipping_data['configuration_value'];

				}
				if ($installed_shipping == '') {
					echo '<br>'.TEXT_SHIPPING_ERROR;
				}
				?></td>
			</tr>
		</table>
		</div>
		</td>
	</tr>
</table>
<?php
}
else
{
	$payment_query = xtc_db_query("SELECT *
				FROM ".TABLE_CONFIGURATION."
				WHERE configuration_key = 'MODULE_PAYMENT_INSTALLED'");
	while ($payment_data = xtc_db_fetch_array($payment_query)) {
		$installed_payment = $payment_data['configuration_value'];
	}

	$shipping_query = xtc_db_query("SELECT *
				FROM ".TABLE_CONFIGURATION."
				WHERE configuration_key = 'MODULE_SHIPPING_INSTALLED'");
	while ($shipping_data = xtc_db_fetch_array($shipping_query)) {
		$installed_shipping = $shipping_data['configuration_value'];
	}

	if($installed_payment == '' || $installed_shipping == '')
	{
?>

	<table style="border: 1px solid; border-color: #ff0000;"
		bgcolor="#FDAC00" border="0" width="100%" cellspacing="0"
		cellpadding="0">
		<tr>
			<td><divclass"main">
			<table width="100%" border="0">
				<tr>
					<td width="1"><?php echo xtc_image(DIR_WS_ICONS.'big_warning.gif'); ?></td>
					<td class="main"><?php
					if ($installed_payment == '') {
						echo TEXT_PAYMENT_ERROR;
					}
					if ($installed_shipping == '') {
						echo '<br>'.TEXT_SHIPPING_ERROR;
					}
					?></td>
				</tr>
			</table>
			</div>
			</td>
		</tr>
	</table>

<?php
	}
}
?>