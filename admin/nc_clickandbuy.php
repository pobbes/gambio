<?php
/* --------------------------------------------------------------
   nc_clickandbuy.php 2010-01-22 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
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
  
  
	if($_GET['page'] == 'register')
	{
		// BOF GM_MOD:
		$sql = '
			SELECT
			cn.countries_iso_code_2 	AS countries_iso_code_2,
			ab.entry_firstname 				AS entry_firstname,
			ab.entry_lastname 				AS entry_lastname,
			ab.entry_postcode 				AS entry_postcode,
			c.customers_email_address AS customers_email_address,
			ab.entry_company 					AS entry_company,
			ab.entry_city 						AS entry_city,
			ab.entry_street_address 	AS entry_street_address,
			c.customers_telephone 		AS customers_telephone,
			c.customers_fax 					AS customers_fax,
			c.customers_gender 				AS customers_gender
			FROM
				customers AS c
				LEFT JOIN address_book 	AS ab ON (c.customers_default_address_id = ab.address_book_id) AND c.customers_id = "'.$_SESSION['customer_id'].'"
				LEFT JOIN countries 		AS cn ON (ab.entry_country_id = cn.countries_id)
			WHERE c.customers_id = "'.$_SESSION['customer_id'].'"
		';
		
		$result = xtc_db_query($sql);
		$data 	= xtc_db_fetch_array($result);
		
		if($data['customers_gender'] == '' || $data['customers_gender'] == 'm') {
			$gender = 'Herr';
		} else {
			$gender = 'Frau';
		}
		// BOF GM_MOD:
		$cab = array(
			'mode' 							=> 'anbieter',
			'lang' 							=> 'de',
			'Nation' 						=> $data['countries_iso_code_2'],
			'portalmerchant'		=> 'GAMBIO2',
			'skriptname'				=> rawurlencode('Ihr Warenkorb'),
			'linkType'					=> 'transaction',
			'domainurl'					=> rawurlencode(HTTP_CATALOG_SERVER.DIR_WS_CATALOG),
			'domainname'					=> rawurlencode(STORE_NAME),
			'skripturl'					=> rawurlencode(HTTP_CATALOG_SERVER.DIR_WS_CATALOG),
			'test'							=> 'False',
			'readOnly'					=> 'False',
			'cb_regversion'			=> '1.1',
			'EnableDynamicCurrencyHandover'	=> 'True',
			'prn_link'				=> 'True',
			'ConfigurationURL'	=> rawurlencode(HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'admin/nc_clickandbuy.php'),
			'activateTMI'			=> 'True',
			'AccountCurrency'		=> 'EUR',
			'SellerIDMaster'		=> '14412378',
			'FirstName' 		=> rawurlencode($data['entry_firstname']),
			'LastName' 			=> rawurlencode($data['entry_lastname']),
			'ZIP' 					=> rawurlencode($data['entry_postcode']),
			'Email' 				=> rawurlencode($data['customers_email_address']),
			'Company' 			=> rawurlencode($data['entry_company']),
			'City' 					=> rawurlencode($data['entry_city']),
			'Street' 				=> rawurlencode($data['entry_street_address']),
			'Phone' 				=> rawurlencode($data['customers_telephone']),
			'Fax' 					=> rawurlencode($data['customers_fax']),
			'Gender' 				=> $gender,
			'portalid' 			=> rawurlencode(HTTP_CATALOG_SERVER.DIR_WS_CATALOG),
			'ems_push'			=> rawurlencode(HTTP_CATALOG_SERVER.DIR_WS_CATALOG.'clickandbuy_ems_push_endpoint.php')
		);
		$code = 'GAT3Nni5FR83r';
		$url = 'https://eu.clickandbuy.com/cgi-bin/register.pl?';
		
		for($i=0; $i<count($cab); $i++) 
		{
	  	$url .= key($cab) .'='. current($cab) .'&';
	  	next($cab);
		}
		$url = substr($url, 0, strlen($url) - 1);
		$hash = md5($code.$url);
		
		$register_url = $url .'&fgkey='. $hash;
		xtc_redirect($register_url);
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="includes/general.js"></script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF" onload="SetFocus();">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top">

    
 <table border="0" width="100%" cellspacing="0" cellpadding="0">
  <tr>
    <td class="pageHeading">ClickandBuy</td>
    <td width="80" rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td class="main" valign="top"></td>
  </tr>
</table><br>
		
<span class="main">

<?php
if(isset($_GET['LinkURL']))
{
	// BOF GM_MOD
	if(defined('MODULE_PAYMENT_CLICKANDBUY_V2_ID') === false) 
	{
		include_once(DIR_FS_CATALOG.DIR_WS_MODULES.'payment/clickandbuy_v2.php');
		$coo_clickandbuy = new clickandbuy_v2();
		$coo_clickandbuy->install();
		
		xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
						SET configuration_value = '" . xtc_db_input(xtc_db_prepare_input($_GET['LinkURL'])) . "'
						WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_ID'");
		xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
						SET configuration_value = '" . xtc_db_input(xtc_db_prepare_input($_GET['SellerID'])) . "'
						WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID'");
		xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
						SET configuration_value = '" . xtc_db_input(xtc_db_prepare_input($_GET['TMIPassword'])) . "'
						WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD'");
		
		echo 'Das ClickandBuy 2.0 Zahlungsmodul wurde erfolgreich installiert. <br />Sie k&ouml;nnen das Modul nun unter dem Men&uuml;punkt Zahlungsweisen aktivieren.';
	}
	else {
		xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
						SET configuration_value = '" . xtc_db_input(xtc_db_prepare_input($_GET['LinkURL'])) . "'
						WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_ID'");
		xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
						SET configuration_value = '" . xtc_db_input(xtc_db_prepare_input($_GET['SellerID'])) . "'
						WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_SELLER_ID'");
		xtc_db_query("UPDATE " . TABLE_CONFIGURATION . "
						SET configuration_value = '" . xtc_db_input(xtc_db_prepare_input($_GET['TMIPassword'])) . "'
						WHERE configuration_key = 'MODULE_PAYMENT_CLICKANDBUY_V2_TMI_PASSWORD'");
		
		echo 'Ihre ClickandBuy-Daten wurden im ClickandBuy 2.0 Zahlungsmodul erfolgreich hinterlegt. <br />Sie k&ouml;nnen das Modul nun unter dem Men&uuml;punkt Zahlungsweisen aktivieren.';
	}
	// EOF GM_MOD
}
elseif($_GET['page'] == '') {
	$news_url = 'http://news.gambio.de/clickandbuy/conditions_page1.html';
} elseif($_GET['page'] == 'conditions') {
	$news_url = 'http://news.gambio.de/clickandbuy/conditions_page2.html';
} 

if(isset($news_url)) 
{
	if(ini_get('allow_url_fopen') == '1' && ini_get('allow_url_include') == '1') // CHECK for allow_url_fopen
	{
		include($news_url);
	}
	elseif(function_exists('curl_init')) // CHECK for cURL
	{
		$ch = curl_init();
		   curl_setopt ($ch, CURLOPT_URL, $news_url);
		   curl_setopt ($ch, CURLOPT_HEADER, 0);
		   curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		   echo curl_exec ($ch);
		curl_close($ch);
	}
	else // SHOW direct links
	{
		?>
		&nbsp;&nbsp;&nbsp;
		<a href="http://www.clickandbuy.com/extra/premium_info_center/DE-de/" target="_blank"><font size="4"><u>-&gt; Informationen zu ClickandBuy</u></font></a><br><br>
		&nbsp;&nbsp;&nbsp;
		<a href="nc_clickandbuy.php?page=register"><font size="4"><u>-&gt; ClickandBuy-Registrierung</u></font></a>
		<?php
	}
}
?>

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