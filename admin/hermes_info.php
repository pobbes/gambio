<?php
/* --------------------------------------------------------------
   hermes_info.php 2011 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
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

// ALTER TABLE `admin_access` ADD `hermes_info` INT( 1 ) NOT NULL DEFAULT '0'
// update admin_access set hermes_info = 1

ob_start();
require('includes/application_top.php');
require DIR_FS_CATALOG .'/admin/includes/classes/messages.php';
require DIR_FS_CATALOG .'/includes/classes/hermes.php';

$hermes = new Hermes();
$messages = new Messages('hermes_messages');

if(isset($_REQUEST['ajax'])) {
	switch($_REQUEST['ajax']) {
		case 'checkinfo':
			$info = $hermes->getInfo();
			echo '<img class="logogram" src="'.$info->urlHermesLogogram.'">';
			echo '<h3>Ihre Produkte</h3>';
			echo '<table class="products">';
			echo '<tr>';
			echo '<th>Paketklasse</th>';
			echo '<th>Preis</th>';
			echo '<th>kürzeste + längste Seite min.</th>';
			echo '<th>kürzeste + längste Seite max.</th>';
			echo '<th>Masse min.</th>';
			echo '<th>Masse max.</th>';
			echo '<th>Land</th>';
			echo '</tr>';
			foreach($info->products->ProductWithPrice as $product) {
				echo '<tr>';
				if(empty($product->productInfo->parcelFormat->parcelClass)) {
					echo '<td>(alle)</td>';
				}
				else {
					echo '<td>'.$product->productInfo->parcelFormat->parcelClass.'</td>';
				}
				echo '<td class="ra">'.number_format(($product->netPriceEurcent / 100), 2, '.', '').' &euro;</td>';
				echo '<td class="ra">'.$product->productInfo->parcelFormat->shortestPlusLongestEdgeCmMin.' cm</td>';
				echo '<td class="ra">'.$product->productInfo->parcelFormat->shortestPlusLongestEdgeCmMax.' cm</td>';
				echo '<td class="ra">'.$product->productInfo->parcelFormat->weightMinKg.' kg</td>';
				echo '<td class="ra">'.$product->productInfo->parcelFormat->weigthMaxKg.' kg</td>'; // N.B.: intentionally misspelled!
				echo '<td class="destination">';
				$destinations = array();
				foreach($product->productInfo->deliveryDestinations->DeliveryDestination as $dest) {
					$deststr = $dest->countryCode;
					if(!empty($dest->exclusions)) {
						$deststr .= ' ('. $dest->exclusions .')';
					}
					$destinations[] = $deststr;
				}
				echo implode(', ', $destinations);
				echo '</td>';
				echo '</tr>';
			}
			echo '</table>';
			echo '<p>';
			echo '<strong>Abrechnung:</strong> '. $info->settlementType .'<br>';
			echo '<strong>Nachnahmegebühren:</strong> '. number_format(($info->netPriceCashOnDeliveryEurocent / 100), 2, ',', '') .' &euro;<br>';
			echo '<strong>Mehrwertsteuer:</strong> '.$info->vatInfo.'<br>';
			echo '<a class="newwindow" href="'.$info->urlTermsAndConditions .'">AGB der Hermes Logistik Gruppe Deutschland GmbH</a><br>';
			echo '<a class="newwindow" href="'.$info->urlPackagingGuidelines .'">Verpackungsrichtlinien</a><br>';
			echo '<a class="newwindow" href="'.$info->urlPortalB2C.'">zum Hermes-ProfiPaketService-Portal</a>';
			echo '</p>';
			//echo '<pre>'.  htmlspecialchars(print_r($info, true)) . '</pre>';
			break;
		default:
			echo 'not implemented';
	}
	exit;
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
		.propsorders { background: #eeeeee; width: 100%; margin: auto; border-collapse: collapse; }
		.propsorders td { }
		.propsorders td, .propsorders th { padding: .1ex .5ex; }
		.propsorders td.shippingid { cursor: pointer; width: 8em; }
		.propsorders th { background: #ccc; }
		.propsorders tr:hover { background: #ffffee !important; }
		.propsorders tr:nth-child(even) { background: #ddd; }
		.availability { float: right; width: 25em; border: 1px solid #555; background: #eee; padding: 1ex 1em; }
		.printpos { display: inline-block; margin-bottom: -4px; }
		.printpos input { vertical-align: middle; margin: 0; }
		.orderlabel * { vertical-align: middle; }
		p.message { background: #ffa; border: 1px solid #faa; padding: 1ex 1em; }
		.ra { text-align: right; }
		table.products { width: 99%; margin: auto; }
		table.products th { background: #ccc; text-align: center; }
		table.products td { background: #f8f8f; }
		table.products td { vertical-align: top; padding: .5ex; }
		table.products tr:nth-child(even) td { background: #e0e0e0 }
		table.products tr:nth-child(odd) td { background: #f3f3f3 }
		td.destination { max-width: 20em; }
		img.logogram { float: right; }
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
					
					<div id="messages">
					<?php foreach($session_messages as $msg): ?>
					<p class="message"><?php echo $msg ?></p>
					<?php endforeach ?>
					</div>
				
					<h2>Informationen zu Ihrem Hermes-Webservice-Account</h2>
					
					<div id="hermes_info">
						wird geladen ...
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
				$('.availability').load('hermes_order.php', { 'ajax': 'checkavailability' }, function() {
					if($('span.available').length > 0) {
						$('#hermes_info').load('hermes_info.php', { 'ajax': 'checkinfo' });
					}
					else {
						$('#hermes_info').html('nicht verf&uuml;gbar');
					}
				});
				
				$('a.newwindow').live('click', (function(e) {
					e.preventDefault();
					window.open($(this).attr('href'));
				}));

			});
		</script>
	</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>
