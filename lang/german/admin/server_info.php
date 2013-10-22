<?php
/* --------------------------------------------------------------
   server_info.php 2012-01-25 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(server_info.php,v 1.4 2002/03/30); www.oscommerce.com 
   (c) 2003	 nextcommerce (server_info.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: server_info.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Server Informationen');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Hilfsprogramme');
// EOF GM_MOD

define('TITLE_SERVER_HOST', 'Server Host:');
define('TITLE_SERVER_OS', 'Server OS:');
define('TITLE_SERVER_DATE', 'Server Datum:');
define('TITLE_SERVER_UP_TIME', 'Server Up Time:');
define('TITLE_HTTP_SERVER', 'HTTP Server:');
define('TITLE_PHP_VERSION', 'PHP Version:');
define('TITLE_ZEND_VERSION', 'Zend:');
define('TITLE_DATABASE_HOST', 'Datenbank Host:');
define('TITLE_DATABASE', 'Datenbank:');
define('TITLE_DATABASE_DATE', 'Datenbank Datum:');

define('SEND_SERVER_INFO_TITLE', 'Unterst&uuml;tzen Sie uns bei der Weiterentwicklung!');
define('SEND_SERVER_INFO_TEXT', 'Sie k&ouml;nnen uns bei der Weiterentwicklung der Gambio-Shopsoftware unterst&uuml;tzen, indem Sie uns Ihre Server-Informationen zusenden.<br />Da Serverkonfigurationen stark voneinander abweichen, helfen uns diese Informationen serverspezifische Konflikte zu vermeiden und somit ein sichereres und stabileres System anbieten k&ouml;nnen.');
define('SEND_SERVER_INFO_MESSAGE_LABEL', 'Nachricht:');
define('SEND_SERVER_INFO_COMMENT_LABEL', 'Kommentar:');
define('SEND_SERVER_INFO_SEND_TEXT', 'Mit Klick auf &quot;Senden&quot; werden ausschlie&szlig;lich die in diesem Formular stehenden Daten einmalig an die Gambio GmbH gesendet.');
define('SEND_SERVER_INFO_SUCCESS', 'Vielen Dank! Die Daten wurden erfolgreich an die Gambio GmbH gesendet.');
define('SEND_SERVER_INFO_ERROR', 'Die Daten konnten leider nicht versendet werden.');
?>