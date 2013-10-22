<?php
/*
 $Id: iclear.php 20 2009-03-03 17:11:55Z dis $

 osCommerce, Open Source E-Commerce Solutions
 http://www.oscommerce.com

 Copyright (c) 2001 - 2003 osCommerce

 Released under the GNU General Public License

 ************************************************************************
 Copyright (C) 2001 - 2003 TheMedia, Dipl.-Ing Thomas Pl�nkers
 http://www.themedia.at & http://www.oscommerce.at

 Copyright (C) 2004 - 2009 iclear GmbH, Mannheim, FRG
 All rights reserved.

 This program is free software licensed under the GNU General Public License (GPL).

 This program is free software; you can redistribute it and/or modify
 it under the terms of the GNU General Public License as published by
 the Free Software Foundation; either version 2 of the License, or
 (at your option) any later version.

 This program is distributed in the hope that it will be useful,
 but WITHOUT ANY WARRANTY; without even the implied warranty of
 MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 GNU General Public License for more details.

 You should have received a copy of the GNU General Public License
 along with this program; if not, write to the Free Software
 Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA 02111-1307
 USA

 *************************************************************************/
global $icCore, $icLang;

if(!class_exists('IclearLanguage')) {
	$icPath = './iclear/class/IclearLanguage.php';
	if(!file_exists($icPath)) {
		$icPath = '.' . $icPath;
	}
	require_once $icPath;
}
$icLang = new IclearLanguage('en');

define('MODULE_PAYMENT_ICLEAR_TEXT_TITLE', $icLang->getParam('MODULE_TITLE'));
define('MODULE_PAYMENT_ICLEAR_IFRAME_TITLE', $icLang->getParam('IFRAME_TITLE'));
define('MODULE_PAYMENT_ICLEAR_IFRAME_DESC', $icLang->getParam('IFRAME_DESC'));

?>
