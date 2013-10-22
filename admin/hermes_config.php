<?php

/* --------------------------------------------------------------
   hermes_config.php 2012-07 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(ot_cod_fee.php,v 1.02 2003/02/24); www.oscommerce.com
   (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Plänkers ; http://www.themedia.at & http://www.oscommerce.at
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: ot_cod_fee.php 1003 2005-07-10 18:58:52Z mz $)

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

require('includes/application_top.php');
require DIR_FS_CATALOG .'/admin/includes/classes/messages.php';
require DIR_FS_CATALOG .'/includes/classes/hermes.php';

defined('GM_HTTP_SERVER') OR define('GM_HTTP_SERVER', HTTP_SERVER);
define('PAGE_URL', GM_HTTP_SERVER.DIR_WS_ADMIN.basename(__FILE__));

$hermes = new Hermes();
$messages = new Messages('hermes_messages');

$username = $hermes->getUsername();
$password = $hermes->getPassword();
$sandboxmode = $hermes->getSandboxmode();
$os_aftersave = $hermes->getOrdersStatusAfterSave();
$os_afterlabel = $hermes->getOrdersStatusAfterLabel();

if($_SERVER['REQUEST_METHOD'] == 'POST') {
	$hermes->setUsername($_POST['username']);
	$hermes->setPassword($_POST['password']);
	$hermes->setSandboxmode(isset($_POST['sandboxmode']));
	$hermes->setOrdersStatusAfterSave($_POST['os_aftersave']);
	$hermes->setOrdersStatusAfterLabel($_POST['os_afterlabel']);
	$messages->addMessage('Konfiguration gespeichert');
	xtc_redirect(PAGE_URL);
}

$orders_status = array();
$os_query = "SELECT * FROM orders_status WHERE language_id = :language_id ORDER BY orders_status_id";
$os_query = strtr($os_query, array(':language_id' => $_SESSION['languages_id']));
$os_result = xtc_db_query($os_query);
while($os_row = xtc_db_fetch_array($os_result)) {
	$orders_status[$os_row['orders_status_id']] = $os_row['orders_status_name'];
}

/* messages */
$session_messages = $messages->getMessages();
$messages->reset();

?>
<!doctype html>
<html <?php echo HTML_PARAMS; ?>>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
		<title><?php echo TITLE; ?></title>
		<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
		<style>
		.hermesorder { font-family: sans-serif; font-size: 0.8em; }
		.hermesorder h1 { padding: 0; }
		.hermesorder a:link { font-size: inherit; text-decoration: underline; }
		.hermesorder p.message { background: #ffa; border: 1px solid #faa; padding: 1ex 1em; }
		.hermesorder dl.form { overflow: auto; }
		.hermesorder dl.form dt, dl.form dd { float: left; margin: .5ex 0; }
		.hermesorder dl.form dt { clear: left; width: 15em; }
		.hermesorder dl.form dt label:after { content: ':';}
		.hermesorder dl.form dt { margin-right: 1.5em; }
		.hermesorder input { vertical-align: middle; }
		.hermesorder input[type="text"] { width: 25em; }
		</style>
	</head>
	<body>
		<!-- header //-->
		<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
		<!-- header_eof //-->

		<!-- body //-->
		<table border="0" width="100%" cellspacing="2" cellpadding="2">
			<tr>
				<td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
					<table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">

						<!-- left_navigation //-->
						<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
						<!-- left_navigation_eof //-->

					</table>
				</td>

				<!-- body_text //-->
				<td class="boxCenter hermesorder" width="100%" valign="top">
					<h1>Konfiguration der Hermes-Schnittstelle</h1>
					
					<?php foreach($session_messages as $msg): ?>
					<p class="message"><?php echo $msg ?></p>
					<?php endforeach ?>
					
					<form action="<?php echo PAGE_URL ?>" method="POST">
						<dl class="form">
							<dt>
								<label for="username">Benutzername</label>
							</dt>
							<dd>
								<input id="username" name="username" type="text" value="<?php echo $username ?>">
							</dd>
							<dt>
								<label for="password">Passwort</label>
							</dt>
							<dd>
								<input id="password" name="password" type="text" value="<?php echo $password ?>">
							</dd>
							<dt>
								<label for="sandboxmode">Sandbox-Mode</label>
							</dt>
							<dd>
								<input type="checkbox" value="1" name="sandboxmode" id="sandboxmode" <?= $sandboxmode ? 'checked="checked"' : '' ?>>
								(nur für Testbetrieb aktivieren)
							</dd>
							<dt>
								<label for="os_aftersave">Bestellstatus nach Speichern eines Versandauftrags</label>
							</dt>
							<dd>
								<select id="os_aftersave" name="os_aftersave">
									<option value="-1" <?php echo $os_aftersave == '-1' ? 'selected="selected"' : '' ?>>nicht &auml;ndern</option>
									<?php foreach($orders_status as $os_id => $os_name): ?>
									<option value="<?php echo $os_id ?>" <?php echo $os_aftersave == $os_id ? 'selected="selected"' : '' ?>><?php echo $os_name ?></option>
									<?php endforeach ?>
								</select>
							</dd>
							<dt>
								<label for="os_aftersave">Bestellstatus nach Erzeugen eines Versandlabels</label>
							</dt>
							<dd>
								<select id="os_afterlabel" name="os_afterlabel">
									<option value="-1" <?php echo $os_afterlabel == '-1' ? 'selected="selected"' : '' ?>>nicht &auml;ndern</option>
									<?php foreach($orders_status as $os_id => $os_name): ?>
									<option value="<?php echo $os_id ?>" <?php echo $os_afterlabel == $os_id ? 'selected="selected"' : '' ?>><?php echo $os_name ?></option>
									<?php endforeach ?>
								</select>
							</dd>
						</dl>
						<input class="button" type="submit" value="speichern">
					</form>
				</td>
				<!-- body_text_eof //-->
				
			</tr>
		</table>
		<!-- body_eof //-->

		<!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		<!-- footer_eof //-->
		<script>
		</script>
	</body>
</html>
<?php
require(DIR_WS_INCLUDES . 'application_bottom.php');
