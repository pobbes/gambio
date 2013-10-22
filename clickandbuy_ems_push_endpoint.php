<?php
/*

  clickandbuy_ems_push_endpoint.php
  
  xt:Commerce ClickandBuy Payment Module
  (c) 2008 Matthias Bauer / Trust in Dialog <http://www.trustindialog.de/>

  @author Matthias Bauer <m.bauer@trustindialog.de>
  @copyright (c) 2008 Matthias Bauer / Trust in Dialog
  @version $Revision$
  @license GPLv2

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.
  
*/

require_once('ext/clickandbuy/lib/xml_parser.php');

include_once('includes/configure.php');
include_once('includes/filenames.php');

require_once(DIR_FS_INC.'xtc_db_connect.inc.php');
require_once(DIR_FS_INC.'xtc_db_close.inc.php');
require_once(DIR_FS_INC.'xtc_db_error.inc.php');
require_once(DIR_FS_INC.'xtc_db_perform.inc.php');
require_once(DIR_FS_INC.'xtc_db_query.inc.php');
require_once(DIR_FS_INC.'xtc_db_queryCached.inc.php');
require_once(DIR_FS_INC.'xtc_db_fetch_array.inc.php');
require_once(DIR_FS_INC.'xtc_db_num_rows.inc.php');
require_once(DIR_FS_INC.'xtc_db_data_seek.inc.php');
require_once(DIR_FS_INC.'xtc_db_insert_id.inc.php');
require_once(DIR_FS_INC.'xtc_db_free_result.inc.php');
require_once(DIR_FS_INC.'xtc_db_fetch_fields.inc.php');
require_once(DIR_FS_INC.'xtc_db_output.inc.php');
require_once(DIR_FS_INC.'xtc_db_input.inc.php');
require_once(DIR_FS_INC.'xtc_db_prepare_input.inc.php');

xtc_db_connect();

function find_node($root, $tagName) {
  $res= array();
  foreach ($root->tagChildren as $child) {
    $res= array_merge($res, find_node($child, $tagName));
    if ($child->tagName == $tagName) array_push($res, $child);
  }
  return $res;
}

$postData = $_POST['xml'];
if (!$postData) die('ERROR no data');
if (get_magic_quotes_gpc()) $postData = stripslashes($postData);

/* Parse the XML */
$parser = new XMLParser($postData);
$parser->parse();
$doc = $parser->document;

/* Extract the info we want */
$crn = $doc->global[0]->crn[0]->tagData;
$type = $doc->tagChildren[1]->tagName;
$datetime = $doc->global[0]->datetime[0]->tagData;
if ($datetime) {
  $datetime = vsprintf('%s%s-%s-%s %s:%s:%s', explode('|', chunk_split($datetime, 2, '|')));
}

$qr = false;
switch (strtolower($type)) {
  case 'bdr':
    $bdr_data = $doc->bdr[0]->bdr_data[0];
    
    $BDRID = $bdr_data->bdr_id[0]->tagData;
    $externalBDRID = $bdr_data->externalbdrid[0]->tagData;
    $action = $bdr_data->action[0]->tagData;
    
    $state = $action;
    $qr = xtc_db_query(vsprintf("INSERT INTO orders_clickandbuy_ems (tst_received, datetime, type, xml, externalBDRID, BDRID, crn, action) VALUES (NOW(), '%s', '%s', '%s', '%s', %d, %d, '%s')", array_map('mysql_escape_string', array($datetime, $type, $postData, $externalBDRID, $BDRID, $crn, $state))));
    break;
  
  default:
    $action = find_node($doc->tagChildren[1], 'action');
    $state = $action ? $action[0]->tagData : 'other';
    $qr = xtc_db_query(vsprintf("INSERT INTO orders_clickandbuy_ems (tst_received, datetime, type, xml, crn, action) VALUES (NOW(), '%s', '%s', '%s', %d, '%s')", array_map('mysql_escape_string', array($datetime, $type, $postData, $crn, $state))));
    break;
}

if ($qr !== false) print('OK'); else print('ERROR');
 
?>