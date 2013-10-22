<?php
/* --------------------------------------------------------------
   clickandbuy_check.php 2010-04-06 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

$Id: clickandbuy_check.php,v 1.0 2005/10/05
  $Id: clickandbuy_check.php,v 1.1 2005/01/17

  osCommerce payment contribution
  Copyright (c) 2005 by Julius Firl | jfirl@fotocommunity.com | fotocommuntiy.de | v 1.0
  Copyright (c) 2006 by Johannes Teitge | info@tmedia.de | www.oscommerce-admin.de | v 1.1


  Released under the GNU General Public License

  Changes on v 1.1
  - added: $yourdomain, no modification by user needed!


*/

include_once('includes/application_top.php');

$f_price = ($_SERVER["HTTP_X_PRICE"]/1000)/100;
$cmd = "
	select
		customers_basket_id
	from
		customers_basket
	where
		customers_id='".$_GET['userid']."'
		AND final_price='".$f_price."'
		AND clickandbuy_TransactionID='".$_GET['TransactionID']."'
		AND clickandbuy_externalBDRID='".$_GET['externalBDRID']."'
		AND cb_currency='".$_GET['cb_currency']."'";



$res = xtc_db_query($cmd);
$arr = xtc_db_fetch_array($res);

if (ENABLE_SSL == true)
{
  $yourdomain = HTTPS_SERVER . DIR_WS_CATALOG;
}
else
{
  $yourdomain = HTTP_SERVER . DIR_WS_CATALOG;
}

// BOF GM_MOD
if(isset($_GET['XTCsid']) && !empty($_GET['XTCsid']))
{
	$t_gm_session_get_paramter = '&XTCsid=' . $_GET['XTCsid'];
}
else
{
	$t_gm_session_get_paramter = '';
}

if(!isset($_GET['userid']))
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=1' . $t_gm_session_get_paramter);	// no userid -> error
	exit;
}
if(!isset($_GET['TransactionID']))
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=1' . $t_gm_session_get_paramter);	// no userid -> error
	exit;
}
elseif(!isset($_GET['externalBDRID']))
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=3' . $t_gm_session_get_paramter);	// no ExternalBDRID -> error
	exit;
}
elseif(!isset($_SERVER["HTTP_X_PRICE"]))
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=4' . $t_gm_session_get_paramter);	// no price -> error
	exit;
}
elseif($_SERVER["HTTP_X_TRANSACTION"] == '0')
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=5' . $t_gm_session_get_paramter);	// no TransactionID from clickandbuy or this TransactionID is fraud -> error
	exit;
}
elseif(substr($_SERVER["REMOTE_ADDR"],0,10) != '217.22.128')
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&case=ip' . $t_gm_session_get_paramter);	// remote ip address is false -> error
	exit;
}
elseif(isset($_SERVER["HTTP_X_USERID"]) )
{ // all ok
	if(!isset($arr['customers_basket_id']))
	{
		header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=6' . $t_gm_session_get_paramter . '&dbg='.$_GET['userid'].'-'.$_SERVER["HTTP_X_TRANSACTION"].'-'.$f_price); 	// no basket_id -> error -> success for clickandbuy
		exit;
	}
	elseif ($arr['customers_basket_id'] > 0)
	{
		header('Location: '.$yourdomain.'checkout_process.php?result=success&transaction='.$_GET['TransactionID'].'&userid='.$_GET['userid'].'&price='.$f_price.'&externalBDRID='.$_GET['externalBDRID'].'&xTransaction='.$_SERVER["HTTP_X_TRANSACTION"].'&xUser='.$_SERVER["HTTP_X_USERID"] . $t_gm_session_get_paramter); 	// all ok -> process payment and checkout
		exit;
	}
	else
	{
		header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=7' . $t_gm_session_get_paramter);	// default -> error -> success for clickandbuy
		exit;
	}
}
else
{
	header('Location: '.$yourdomain.''.FILENAME_CHECKOUT_PAYMENT.'?result=error&error=8' . $t_gm_session_get_paramter);		// fallback -> error
	exit;
}
// EOF GM_MOD
?>