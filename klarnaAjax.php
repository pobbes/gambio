<?php
/* --------------------------------------------------------------
Released under the GNU General Public License (Version 2)
[http://www.gnu.org/licenses/gpl-2.0.html]
--------------------------------------------------------------
*/

include_once('includes/application_top.php');
require_once(DIR_FS_DOCUMENT_ROOT . 'includes/modules/klarna/class.Klarna_xt.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaAPI.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaHTTPContext.php');
include_once(DIR_KLARNA . 'api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc.inc');
include_once(DIR_KLARNA . 'api/transport/xmlrpc-3.0.0.beta/lib/xmlrpc_wrappers.inc');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaAjax.php');
include_once(DIR_KLARNA . 'checkout/classes/class.KlarnaDispatcher.php');
include_once(DIR_KLARNA . 'klarnautils.php');

global $request_type;

$sCountry   = $_GET['country'];
$option     = str_replace('klarna_box_', '', $_GET['type']);
$sMode      = KlarnaUtils::getMode($option);
$sEID       = KlarnaUtils::getEid($sCountry, $option);
$sSecret    = KlarnaUtils::getSecret($sCountry, $option);
$pcUri      = KlarnaUtils::getPCUri();

$web_root = KlarnaUtils::getWebRoot();
$oKlarna = new Klarna_xt();
$oKlarna->config($sEID, $sSecret, $sCountry, null, null, $sMode, "mysql", $pcUri, false);

$kAjax =  new KlarnaAjax ($oKlarna, $sEID, DIR_KLARNA . 'checkout/', $web_root);
$kAjax->__setTemplate(MODULE_PAYMENT_SPECKLARNA_ACTIVE_TEMPLATE);
$dispatcher = new KlarnaDispatcher($kAjax);
$dispatcher->dispatch ();
