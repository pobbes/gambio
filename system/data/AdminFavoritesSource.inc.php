<?php
/* --------------------------------------------------------------
   AdminFavoritesSource.inc.php 2012-01-09 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

MainFactory::load_class('MenuSourceInterface');

class AdminFavoritesSource
{
  var $v_favorites_structure_array = array();  
  
  function init_structure_array( )
  {
    $this->v_favorites_structure_array = array();
    $query = xtc_db_query("SELECT * FROM gm_admin_favorites ORDER BY favorites_id ASC");
    while($row = xtc_db_fetch_array($query)){
      $this->v_favorites_structure_array[] = $row;
    }
  }
  
  function get_favorites( $p_customers_id )
  {
    $t_favorites_array = array();
    foreach($this->v_favorites_structure_array AS $t_key => $t_favorite){
      if($t_favorite['customers_id'] == $p_customers_id){
        $t_favorites_array[] = $t_favorite['link_key'];
      }
    }
    return $t_favorites_array;
  }
}
?>