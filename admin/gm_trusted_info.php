<?php
/* --------------------------------------------------------------
   gm_trusted_info.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_split_sql_queries.inc.php');
	
	if(isset($_POST['query'])){
		$gm_queries = gm_prepare_string($_POST['query'], true);
		
		$gm_query = array();
		$gm_query = gm_split_sql_queries($gm_queries);
		
		$gm_query_result_output = '';
		
		for($i = 0; $i < count($gm_query); $i++){
			$gm_query_result = mysql_query($gm_query[$i]); // xtc_db_query hier nicht verwenden!
			if(!$gm_query_result) $gm_query_result_output .= GM_SQL_ERROR . mysql_error() . '<br />';
		}
		
		if($gm_query_result_output == '') $gm_query_result_output = GM_SQL_SUCCESS;
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="JavaScript" type="text/javascript">
function change_color(id){
	if(document.getElementById('result_row_'+id).style.backgroundColor != 'rgb(255, 195, 107)' && document.getElementById('result_row_'+id).style.backgroundColor != '#ffc36b'){
		document.getElementById('result_row_'+id).style.backgroundColor = '#96edb2';
	}
}

function change_color_out(id){
	if(document.getElementById('result_row_'+id).style.backgroundColor != 'rgb(255, 195, 107)' && document.getElementById('result_row_'+id).style.backgroundColor != '#ffc36b'){
		if(id % 2 == 0) document.getElementById('result_row_'+id).style.backgroundColor = '#F6F6F6';
		else document.getElementById('result_row_'+id).style.backgroundColor = '#d6e6f3';
	}
}

function set_color(id){
	if(document.getElementById('result_row_'+id).style.backgroundColor == 'rgb(255, 195, 107)' || document.getElementById('result_row_'+id).style.backgroundColor == '#ffc36b'){
		if(id % 2 == 0) document.getElementById('result_row_'+id).style.backgroundColor = '#F6F6F6';
		else document.getElementById('result_row_'+id).style.backgroundColor = '#d6e6f3';
	}
	else{
		document.getElementById('result_row_'+id).style.backgroundColor = '#ffc36b';
	}

}
</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
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
    <td class="boxCenter" width="100%" valign="top">
		
		<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)">Trusted Shops</div>
		<br />
		<span class="main">
		
			<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableHeadingRow">
				 	<td class="dataTableHeadingContentText" style="border-right: 0px">Trusted Shops</td>
				</tr>
			</table>
			
			<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br />

<strong>Ihr Shop mit Trusted Shops Gütesiegel</strong><br>
<br>

Trusted Shops ist das Gütesiegel für Online-Shops mit einer 
Geld-zurück-Garantie für Ihre Online-Kunden. Bei einer Zertifizierung 
wird Ihr Shop umfassenden Sicherheits-Tests unterzogen. Diese Prüfung 
mit mehr als 100 Einzel-Kriterien orientiert sich an den Forderungen 
der Verbraucherschützer sowie dem nationalen und europäischen Recht.

<img src="images/trusted.gif" align="right" alt="Trusted Shops" title="Trusted Shops">
<br><br>
Diese Shopsoftware erfüllt bereits einen Großteil der 
Zertifizierungsanforderungen. Der Vorteil für Sie: Sie können sich 
ohne großen Aufwand und zu <strong>stark vergünstigten Konditionen</strong> 
zertifizieren lassen!<br><br>


<strong>Ihre Vorteile durch Trusted Shops:</strong><br><br>

<ol type="1">
	<li>Verbessern Sie Ihren Shop und Ihren Bestellprozess
			mit Erfahrungen aus über 5.000 Shop-Zertifizierungen</li>
	<li>Erhöhen Sie Ihre Umsätze durch eine bessere Konversionsrate
			Steigern Sie das Vertrauen Ihrer Kunden mit Gütesiegel und Geld-zurück-Garantie</li>
	<li>Reduzieren Sie Ihr Abmahnungsrisiko und vermeiden Sie rechtliche Fehler
			durch Prävention mit bewährten Formulierungen und Abmahnungsradar</li>
</ol>


<strong>Welche Leistungen bietet Ihnen Trusted Shops?</strong>
<ul type="square">
	<li>Zertifizierung Ihres Online-Shops mit individuellem Prüfungsprotokoll
	<li>E-Mail-Support durch Zertifizierungsabteilung während Prüfung
	<li>Trusted Shops Praxishandbuch mit 50 rechtssicheren Musterformulierungen
	<li>Geld-zurück-Garantie für Ihre Kunden
	<li>Mehrsprachiges Service-Center für Ihre Kunden
	<li>Streitschlichtung bei Problemfällen
	<li>Experten-Newsletter mit aktuellen Urteilen und Praxistipps
	<li>Mustershop und Expertenforen für rechtliche Fragen
	<li>Exklusive Preisvorteile (Payment, Hosting, Marketing etc.)
</ul>

<strong>Der Trusted Shops Effekt</strong><br>

Durch die Kombination von Prüfung, Geld-zurück-Garantie und Service 
entsteht für den Verbraucher ein <strong>Rundum-sicher-Paket</strong>. 
Somit <strong>steigt die Kaufrate und Ihr Umsatz</strong> - ein Vorteil, 
den sich bereits über 1.500 erfolgreiche Online-Shops zunutze machen. 
Damit ist Trusted Shops laut Handelsblatt klarer <strong>Marktführer</strong> 
in Deutschland.

Weitere Informationen und Erfahrungen von zertifizierten Online-Shops 
finden Sie auf der Trusted Shops Homepage unter 
<a href="http://www.trustedshops.de" target="_blank"><span class="main"><u>www.trustedshops.de</u></span></a>.
<br><br>

<a href="http://www.trustedshops.de/de/shops/shops_special_conditions_de.html" target="_blank"><span class="main"><u>
Nutzen Sie diese Chance und lassen Sie sich jetzt zum Sonderpreis zertifizieren</u></span></a>.
				
					</td>
				</tr>
			</table>
		
		</span>	

    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>