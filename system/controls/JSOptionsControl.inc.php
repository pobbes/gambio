<?php
/* --------------------------------------------------------------
   JSOptionsControl.inc.php 2011-09-27 tb@gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/


class JSOptionsControl
{
  function get_options_array(  )
  {
    $coo_js_options_source = MainFactory::create_object('JSOptionsSource', array(false));
    $coo_js_options_source->init_structure_array();
	
	return $coo_js_options_source->get_array();
  } 
}
?>