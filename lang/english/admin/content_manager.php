<?php
/* --------------------------------------------------------------
   content_manager.php 2008-11-13 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (content_manager.php,v 1.8 2003/08/25); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: content_manager.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

define('HEADING_TITLE','Content Manager');

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Tools');
// EOF GM_MOD

define('HEADING_CONTENT','Site content');
define('HEADING_PRODUCTS_CONTENT','Product Content');
define('TABLE_HEADING_CONTENT_ID','Link ID');
define('TABLE_HEADING_CONTENT_TITLE','Title');
define('TABLE_HEADING_CONTENT_FILE','File');
define('TABLE_HEADING_CONTENT_STATUS','Visible in Box');
define('TABLE_HEADING_CONTENT_BOX','Box');
define('TABLE_HEADING_PRODUCTS_ID','ID');
define('TABLE_HEADING_PRODUCTS','Product');
define('TABLE_HEADING_PRODUCTS_CONTENT_ID','ID');
define('TABLE_HEADING_LANGUAGE','Language');
define('TABLE_HEADING_CONTENT_NAME','Name/Filename');
define('TABLE_HEADING_CONTENT_LINK','Link');
define('TABLE_HEADING_CONTENT_HITS','Viewed');
define('TABLE_HEADING_CONTENT_GROUP','Group');
define('TABLE_HEADING_CONTENT_SORT','Sort Order');
define('TEXT_YES','Yes');
define('TEXT_NO','No');
define('TABLE_HEADING_CONTENT_ACTION','Action');
define('TEXT_DELETE','Delete');
define('TEXT_EDIT','Edit');
define('TEXT_PREVIEW','Preview');
define('CONFIRM_DELETE','Delete Content ?');
define('CONTENT_NOTE','Content marked <font color="#ff0000">*</font> is a part of the system and cannot be deleted!');


// edit
define('TEXT_LANGUAGE','Language:');
define('TEXT_STATUS','Visible:');
define('TEXT_STATUS_DESCRIPTION','If checked, a link or an extra box will be displayed');
define('TEXT_TITLE','Title:');
define('TEXT_TITLE_FILE','Title/Filename:');
define('TEXT_SELECT','-Select-');
define('TEXT_HEADING','Heading:');
define('TEXT_CONTENT','Text:');
define('TEXT_UPLOAD_FILE','Upload File:');
define('TEXT_UPLOAD_FILE_LOCAL','(from local system)');
define('TEXT_CHOOSE_FILE','Choose File:');
define('TEXT_CHOOSE_FILE_DESC','You also can choose an existing file from the list.');
define('TEXT_NO_FILE','Delete Selection');
define('TEXT_CHOOSE_FILE_SERVER','(If you have already uploaded your files via FTP to <i>(media/content)</i>, you can select the file here.');
define('TEXT_CURRENT_FILE','Current File:');
define('TEXT_FILE_DESCRIPTION','<b>Info:</b><br />You can also upload a <b>.html</b> or <b>.htm</b> file and display it as store content.<br /> If you select or upload a file, the text in the box will be ignored.<br /><br />');
define('ERROR_FILE','Incorrect file format (.html or .htm only)');
define('ERROR_TITLE','Please enter a title');
define('ERROR_COMMENT','Please enter a file description!');
define('TEXT_FILE_FLAG','Box:');
define('TEXT_PARENT','Main Document:');
define('TEXT_PARENT_DESCRIPTION','Assign to this document');
define('TEXT_PRODUCT','Product:');
define('TEXT_LINK','Link:');
define('TEXT_SORT_ORDER','Sort:');
define('TEXT_GROUP','Language Group:');
define('TEXT_GROUP_DESC','You can use this ID to link similar subjects from different languages.');
define('TITLE_CONTENT_SLIDER',' Content teaser slider');
define('TEXT_SELECT_NONE', 'no teaser slider');

define('TEXT_CONTENT_DESCRIPTION','You can use this content manager to add any file type to a product, i.e. technical data sheets, product details, videos, etc. These elements will be displayed on the product details page.<br /><br />');
define('TEXT_FILENAME','Use File:');
define('TEXT_FILE_DESC','Description:');
define('USED_SPACE','Disk space used:');
define('TABLE_HEADING_CONTENT_FILESIZE','File Size');


// BOF GM_MOD
define('GM_LINK', 'Link:');
define('GM_LINK_TOP', 'Open in same window');
define('GM_LINK_BLANK', 'Open in new window');
define('GM_SITEMAP_CHANGEFREQ', 'Change frequency in sitemap');
define('GM_SITEMAP_PRIORITY', 'Priority in sitemap');
define('TITLE_ALWAYS', 'always');
define('TITLE_HOURLY', 'hourly');
define('TITLE_DAILY', 'daily');
define('TITLE_WEEKLY', 'weekly');
define('TITLE_MONTHLY', 'monthly');
define('TITLE_YEARLY', 'annually');
define('TITLE_NEVER', 'never');
define('GM_SITEMAP_ENTRY', 'link in sitemap');

define('GM_WARNING_CONTENT_GROUP_ID_EXISTS', 'The entered language group already exists. Choose a free language group  e.g. "{ID}".');
define('GM_ERROR_CONTENT_GROUP_ID_EXISTS',	'The entered language group already exists. Choose a free language group  e.g. "{ID}".');

// EOF GM_MOD

// NEW
define('GM_WARNING_CONTENT_GROUP_ID_EXISTS', 'The language group entered already exists. Choose a free language group  e.g. "{ID}".');
define('GM_ERROR_CONTENT_GROUP_ID_EXISTS',	'The language group entered already exists. Choose a free language group  e.g. "{ID}".');


define('GM_META_TITLE', 'Meta Title:');
define('GM_META_KEYWORDS', 'Meta Keywords:');
define('GM_META_DESCRIPTION', 'Meta Description:');

define('GM_URL_KEYWORDS', 'URL Keywords:');

?>