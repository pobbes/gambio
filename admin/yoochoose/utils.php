<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */

      
    /** Updates a YOOCHOOSE Propery. Creates if not found.
     *  Deletes the property, if it has a default value. */
    function updateProperty($name, $value, $deaultValue = '') {
        
        if ($deaultValue && $name == $deaultValue) {
            $sql = 'DELETE FROM '.TABLE_CONFIGURATION.' WHERE configuration_key=\'%1$s\'';
        } else if (defined($name)) {
            $sql = 'UPDATE '.TABLE_CONFIGURATION.' SET configuration_group_id=24, 
                   configuration_value=\'%2$s\' WHERE configuration_key=\'%1$s\'';
        } else {
            $sql = 'INSERT INTO '.TABLE_CONFIGURATION.' (configuration_key, configuration_group_id, configuration_value ) 
                   VALUES (\'%1$s\', 24, \'%2$s\')';        
        }
        xtc_db_query(sprintf($sql, mysql_real_escape_string($name), mysql_real_escape_string($value)));
    }
    
        
    /** Returns a post value, if set; a constant value, if set; or derfault value otherwise. */
    function getValue($name, $default) {
        if (isset($_POST[$name])) {
            if (function_exists('do_magic_quotes_gpc')) {
                // Gambio enforces magic_quotes using this function.
                // We need to undo this fraud action
                return stripcslashes($_POST[$name]);
            } else {
                return $_POST[$name];
            }
        } else if ($name && defined($name)) {
            return constant($name);
        } else {
            return $default;
        }
    }    
 
    
    
    /** Updates the box status in "gm_boxes" table.
     *  Creates a new record, if the box doesn't exist.
     */
    function updateBoxEnabled($boxName, $position, $enabled) {
    	
    	$sql = 'SELECT box_status FROM gm_boxes WHERE template_name=\'%1$s\' AND box_name=\'%2$s\'';
        
        $resultset = xtc_db_query(sprintf($sql, 
                mysql_real_escape_string(CURRENT_TEMPLATE), 
                mysql_real_escape_string($boxName)));
        
        if ($record = xtc_db_fetch_array($resultset)) {
            $updSql = 'UPDATE gm_boxes SET box_status=\'%1$s\' WHERE template_name=\'%2$s\' AND box_name=\'%3$s\'';
        } else {
        	$updSql = 'INSERT INTO gm_boxes (box_status, template_name, box_name, position)
        	               VALUES (\'%1$s\', \'%2$s\', \'%3$s\', \'%4$s\')';
        }
        
        $scs = xtc_db_query(sprintf($updSql, 
                mysql_real_escape_string($enabled ? 1 : 0), 
                mysql_real_escape_string(CURRENT_TEMPLATE),
                mysql_real_escape_string($boxName),
                mysql_real_escape_string($position)));
    	
        if (! $scs) {
            throw new Exception("Unable to set the box state '$name' for language '$values'");
        }
    }
    
    
    require_once(DIR_FS_CATALOG.'gm/inc/gm_get_content.inc.php');
    require_once(DIR_FS_CATALOG.'gm/inc/gm_set_content.inc.php');
    
    
    /** Updates the table 'gm_contents', setting all the languages 
     *  specified in array. Creates records, if some language was not found.
     *  Do not delete values, if some language was not specified in 
     *  array.
     */
    function updateContentValue($name, $values) {
    	foreach ($values as $langKey=>$value) {
    		if (! gm_set_content($name, $value, $langKey)) {
    			throw new Exception("Unable to set the content '$name' for language '$values'");
    		}
    	}
    }
    
    
    /** Returns spezified content from the table 'gm_contents' values for 
     *  all languages as array. 
     *  */
    function getContentValue($name) {
    	
    	$result = array();
    	
    	$sql = "SELECT l.languages_id, c.gm_value
                        FROM ".TABLE_LANGUAGES." l LEFT JOIN gm_contents c ON l.languages_id = c.languages_id 
                        WHERE c.gm_key = '" . mysql_real_escape_string($name) . "' ORDER BY l.sort_order";
    	
    	$resultset = xtc_db_query($sql);
    	
    	while ($record = xtc_db_fetch_array($resultset)) {
    		
    		$languageId = $record['languages_id'];
    		$content = $record['gm_value'];
    		
    	    if (isset($_POST[$name]) && isset($_POST[$name][$languageId])) {
    	    	$result[$languageId] = $_POST[$name][$languageId];
    	    } else if ($content != null) {
    	   	    $result[$languageId] = $content;
    	    } else {
    	    	$result[$languageId] = "";
    	    }
    	}
        
        return $result;
    }
    
    
?>