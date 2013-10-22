<?php
/*
* id = ini.php
* location = /includes/classes/billsafe_2
*
* This program is free software; you can redistribute it and/or modify
* it under the terms of the GNU General Public License, version 2, as
* published by the Free Software Foundation.
*
* This program is distributed in the hope that it will be useful,
* but WITHOUT ANY WARRANTY; without even the implied warranty of
* MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
* GNU General Public License for more details.
*
* @package BillSAFE_2
* @copyright (C) 2011 BillSAFE GmbH and Bernd Blazynski
* @license GPLv2
*/

//isLiveMode MUST be set to false for testing and debugging!
$ini['isLiveMode'] = false;
//Enter your API credentials provided by BillSAFE:
$ini['merchantId'] = '';
$ini['merchantLicenseSandbox'] = '';
$ini['merchantLicenseLive'] = '';
$ini['applicationSignature'] = 'a619fe3fd7e35da8a57d7efa77c410f1';
$ini['applicationVersion'] = 'xtc_v2.2 2011-10-13';
//Set this to true if your data is utf-8 encoded.
//Set this to false if your data is latin-1 encoded.
//The encoding of the response object will be affected accordingly.
$ini['isUtf8Mode'] = true;
//API version
$ini['apiVersion'] = 202;
//Payment Gateway version
$ini['gatewayVersion'] = 200;
?>