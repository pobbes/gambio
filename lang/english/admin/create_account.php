<?php
/* --------------------------------------------------------------
   $Id: create_account.php 985 2005-06-17 22:35:22Z mz $   

   XT-Commerce - community made shopping
   http://www.xt-commerce.com

   Copyright (c) 2003 XT-Commerce
   --------------------------------------------------------------
   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(create_account.php,v 1.13 2003/05/19); www.oscommerce.com 
   (c) 2003	 nextcommerce (create_account.php,v 1.4 2003/08/14); www.nextcommerce.org

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('NAVBAR_TITLE', 'Create an Account');

define('HEADING_TITLE', 'Customer Account Admin');

define('TEXT_ORIGIN_LOGIN', '<font color="#FF0000"><small><b>NOTE:</b></font></small> If you already have an account with us, please log in on the <a href="%s"><u>login page</u></a>.');

define('EMAIL_SUBJECT', 'Welcome to ' . STORE_NAME);
define('EMAIL_GREET_MR', 'Dear Mr ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_MS', 'Dear Ms ' . stripslashes($HTTP_POST_VARS['lastname']) . ',' . "\n\n");
define('EMAIL_GREET_NONE', 'Dear ' . stripslashes($HTTP_POST_VARS['firstname']) . ',' . "\n\n");
define('EMAIL_WELCOME', 'Welcome to <b>' . STORE_NAME . '</b>.' . "\n\n");
define('EMAIL_TEXT', 'You can now benefit from the <b>various services</b> we have to offer. These services include:' . "\n\n" . '<li><b>Permanent Cart</b> - Any products added to your online cart will remain there until you remove them or check them out.' . "\n" . '<li><b>Address Book</b> - We can now deliver your products to an address other than yours! This is perfect for sending birthday gifts direct to the recipient on their birthday.' . "\n" . '<li><b>Order History</b> - View a history of the purchases you have made with us.' . "\n" . '<li><b>Product Reviews</b> - Share your opinions of products with our other customers.' . "\n\n");
define('EMAIL_CONTACT', 'Please email the store owner to obtain help with any of our online services: ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n\n");
define('EMAIL_WARNING', '<b>Note:</b> This email address was given to us by one of our customers. If you did not sign up to be a member, please send an email to ' . STORE_OWNER_EMAIL_ADDRESS . '.' . "\n");
define('ENTRY_PAYMENT_UNALLOWED','Unallowed payment modules:');
define('ENTRY_SHIPPING_UNALLOWED','Unallowed shipping modules:');
?>