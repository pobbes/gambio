<?php
/* --------------------------------------------------------------
   hermes_collection.php 2012 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License
   --------------------------------------------------------------
*/

/* --------------------------------------------------------------
   --------------------------------------------------------------
   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards (a typical file) www.oscommerce.com
   (c) 2003	 nextcommerce ( start.php,v 1.6 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: credits.php 1263 2005-09-30 10:14:08Z mz $)


   Released under the GNU General Public License
   --------------------------------------------------------------*/

/*
ALTER TABLE `admin_access` ADD `hermes_collection` INT( 1 ) NOT NULL DEFAULT '0'
update admin_access set hermes_collection = 1
*/

ob_start();
require('includes/application_top.php');
require DIR_FS_CATALOG .'/includes/classes/hermes.php';
require DIR_FS_CATALOG .'/admin/includes/classes/messages.php';

$hermes = new Hermes();
$messages = new Messages('hermes_messages');

if(isset($_REQUEST['load_collorders'])) {
	$corders = $hermes->getCollectionOrders();
	if(is_array($corders)) {
		echo '<table class="corders">';
		echo '<tr><th>Datum</th><th>Zeitraum</th><th>Art</th><th>Anzahl Pakete</th><th>Volumen</th><th>Mehr als 2 m³</th><th>Storno</th></tr>';
		foreach($corders as $co) {
			echo '<tr>';
			echo "<td>".date('Y-m-d (D)', strtotime($co->collectionDate))."</td>";
			echo "<td>".$co->timeframe."</td>";
			echo "<td>".$co->collectionType."</td>";
			echo "<td>".$co->numberOfParcels."</td>";
			echo "<td>".($co->volume > 0 ? $co->volume . " m³" : '')."</td>";
			echo "<td>".($co->moreThan2ccm == 'YES' ? 'ja' : 'nein')."</td>";
			echo '<td><form action="" method="POST"><input type="hidden" name="datetime" value="'.$co->collectionDate.'">';
			echo '<input type="submit" value="stornieren"></form></td>';
			echo '</tr>';
		}
		echo '</table>';
	}
	else if(is_string($corders)) {
		echo '<p>'.$corders.'</p>';
	}
	else {
		echo '<p>Daten konnten nicht abgerufen werden</p>';
	}
	exit;
}

if(!empty($_POST)) {
	if(!empty($_POST['datetime'])) {
		$result = $hermes->collectionCancel($_POST['datetime']);
		if($result === true) {
			$messages->addMessage('Auftrag storniert');
		}
		else {
			$messages->addMessage('Auftrag konnte nicht storniert werden');
		}
	}

	if(!empty($_POST['date'])) {
		$_POST['time'] = '12:00';
		$datestring = $_POST['date'] .' '. $_POST['time'] .':00 CET';
		$timestamp = strtotime($datestring);
		$datetime = gmdate('c', $timestamp);
		$result = $hermes->addPropsCollectionRequest($datetime, $_POST['packets']);
		if($result !== true && is_array($result)) {
			$messages->addMessage('FEHLER: '. $result['code'] .' '. $result['message']);
		}
		if(is_string($result)) {
			$messages->addMessage('Auftrag gespeichert, Auftragsnummer '. $result);
		}
	}
	
	xtc_redirect(HTTP_SERVER.DIR_WS_ADMIN.basename(__FILE__));
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
		<link rel="stylesheet" type="text/css" href="<?php echo HTTP_SERVER . DIR_WS_CATALOG; ?>gm/javascript/jquery/ui/datepicker/css/ui-lightness/jquery-ui-1.8.11.custom.css">			
		<style>
		.hermesorder { font-family: sans-serif; font-size: 0.8em; }
		.hermesorder h1 { padding: 0; }
		.hermesorder a:link { font-size: inherit; text-decoration: underline; }
		dl.form { overflow: auto; width: 50%;}
		dl.form dt, dl.form dd { float: left; margin: 1px 0; }
		dl.form dt { clear: left; font-weight: bold; width: 15em; }
		dl.form dd { }
		fieldset { border: none; background: #dddddd; margin: 1em 0; }
		legend { background: #C7E8F8; padding: 1ex 1em; box-shadow: 0 0 2px #000000; }
		.availability { float: right; width: 15em; border: 1px solid #555; background: #eee; padding: 1ex 1em; }
		.corders { width: 99%; margin: auto; }
		.corders th { background: #ccc; text-align: center; }
		.corders td { background: #f8f8f; }
		.corders tr:nth-child(even) td { background: #f0f0f0 }
		p.message { background: #ffa; border: 1px solid #faa; padding: 1ex 1em; }
		.cb { clear: both; }
		.overlay { position: absolute; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.8); color: #fff; text-align: center; padding-top: 15em; font-family: sans-serif; }
		div.info { width: 50%; float: right; }
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

				<td class="boxCenter hermesorder" width="100%" valign="top">
				<!-- body_text //-->
					<div class="availability">
						Verfügbarkeit der Schnittstelle wird überprüft &hellip;
					</div>

					<h2>Abhol-Aufträge</h2>

					<?php foreach($session_messages as $msg): ?>
					<p class="message"><?php echo $msg ?></p>
					<?php endforeach ?>
					
					<form action="" method="post">
						<fieldset>
							<legend>Neuer Abholauftrag</legend>
							<div class="info">
								Der Termin muss folgenden Kriterien genügen:
								<ul>
									<li>Auswahl eines Werktags (Montag bis Samstag)</li>
									<li>keine Angabe eines bundesweiten, gesetzlichen Feiertags</li>
									<li>Abholung frühestens am nächsten Werktag</li>
								</ul>
								Ausnahmen:
								<ul>
									<li>Auftragserteilung nach 21:00 Uhr und einem Sendungsvolumen bis 2 Kubikmeter kann frühestens der übernächste Werktag als Abholtermin angegebenwerden
									</li>
									<li>bei Auftragserteilung nach 14:00 Uhr und einem Sendungsvolumen größer 2 Kubikmeter kann nicht garantiert werden, dass alle Pakete abgeholt werden</li>
									<li>Auftragserteilung nach 14:00 Uhr und einem Sendungsvolumen größer 18 Kubikmeter kann frühestens der übernächste Werktag als Abholtermin angegeben werden</li>
									<li>Auswahl eines Wunschtermins innerhalb von 90 Tagen nach Auftragserteilung</li>
								</ul>
								Hinweis: Wird eine Abholung an einem regionalen Feiertag beauftragt, wird die Abholung erstam nächsten Werktag durchgeführt.
							</div>
							<dl class="form">
								<dt><label for="date">Abholdatum</label></dt>
								<dd>
									<input type="text" name="date" id="date">
								</dd>
								<?php foreach($hermes->getPackageClasses() as $pckey => $pclass): ?>
								<dt><label for="packets_<?php echo $pckey ?>">Anzahl Pakete Klasse <?php echo $pclass['name'] ?></label></dt>
								<dd>
									<input type="text" name="packets[<?php echo $pckey ?>]" id="packets_<?php echo $pckey ?>" value="0">
								</dd>
								<?php endforeach ?>
							</dl>
							<input type="submit" value="Auftrag senden">
						</fieldset>
					</form>
					
					<div id="collorders">
						Liste wird geladen &hellip;
					</div>
				</td>
				<!-- body_text_eof //-->
				
			</tr>
		</table>
		<!-- body_eof //-->

		<!-- footer //-->
		<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
		<!-- footer_eof //-->
		<script>
			$(function() {
				$('a.newwindow').click(function(e) {
					e.preventDefault();
					window.open($(this).attr('href'));
				});
				$('.confirm').click(function(e) {
					return window.confirm('Wirklich löschen?');
				});
				
				$('.availability').load('hermes_order.php', { 'ajax': 'checkavailability' }, function() {
					if($('span.available').length > 0) {
						$('#collorders').load('hermes_collection.php', { 'load_collorders': 1 });
					}
					else {
						$('#collorders').html('nicht verf&uuml;gbar');
					}
				});

				
				
				$('#date').datepicker({
					dateFormat: 'yy-mm-dd',
					minDate: +1,
					maxDate: +90
				});
			});
		</script>
	</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
