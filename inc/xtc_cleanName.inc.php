<?php
/* --------------------------------------------------------------
   xtc_cleanName.inc.php 2009-06-29 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

(c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtc_cleanName.inc.php 1319 2005-10-23 10:35:15Z mz $) 

   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/


 function xtc_cleanName($name) {
 	// BOF GM_MOD
 	$search_array = array('ä','Ä','ö','Ö','ü','Ü','&auml;','&Auml;','&ouml;','&Ouml;','&uuml;','&Uuml;','ß','&szlig;');
 	$replace_array = array('ae','Ae','oe','Oe','ue','Ue','ae','Ae','oe','Oe','ue','Ue','ss','ss');
 	// EOF GM_MOD
 	$name=str_replace($search_array,$replace_array,$name);   	
 	
     $replace_param='/[^a-zA-Z0-9]/';
     $name=preg_replace($replace_param,'-',$name);    
     return $name;
 }

?>