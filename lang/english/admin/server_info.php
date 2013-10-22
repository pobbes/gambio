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

define('HEADING_TITLE', 'Server Information');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Tools');
// EOF GM_MOD

define('TITLE_SERVER_HOST', 'Server Host:');
define('TITLE_SERVER_OS', 'Server OS:');
define('TITLE_SERVER_DATE', 'Server Date:');
define('TITLE_SERVER_UP_TIME', 'Server Up Time:');
define('TITLE_HTTP_SERVER', 'HTTP Server:');
define('TITLE_PHP_VERSION', 'PHP Version:');
define('TITLE_ZEND_VERSION', 'Zend:');
define('TITLE_DATABASE_HOST', 'Database Host:');
define('TITLE_DATABASE', 'Database:');
define('TITLE_DATABASE_DATE', 'Database Date:');

define('SEND_SERVER_INFO_TITLE', 'Support the development of our software!');
define('SEND_SERVER_INFO_TEXT', 'You can support us in developing the Gambio shop software by sending us your server information.<br />Because server configurations vary greatly, this information will help us to avoid server-specific conflicts, and thus a more secure and stable system can be offered.');
define('SEND_SERVER_INFO_MESSAGE_LABEL', 'Message:');
define('SEND_SERVER_INFO_COMMENT_LABEL', 'Comment:');
define('SEND_SERVER_INFO_SEND_TEXT', 'By clicking "Send" only the data in this form will be sent once to the Gambio GmbH.');
define('SEND_SERVER_INFO_SUCCESS', 'Thank you! The data has been successfully sent to the Gambio GmbH.');
define('SEND_SERVER_INFO_ERROR', 'Unfortunately, the data could not be sent.');
?>