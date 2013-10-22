<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */
   defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');


   require_once(DIR_FS_CATALOG . '/includes/yoochoose/functions.php');
?>

<div style="padding: 40px;" class="yoo-image5-large">

<table class="dataTable" border="0" cellspacing="0" cellpadding="4" style="border-top: none;">

<?php

    try {
    	
    	 $statDateFormat = '%d.%m.%Y %H:%M:%S';
    	
		 $statistik =  loadStatistik();
		 
		
		 if (count(get_object_vars($statistik)) > 0) {
	         printCounter('
		    <tr valign="top" bgcolor="%s">
		      <td class="dataTableContent_gm" style="padding-right:3em;">%s</td>
		      <td class="dataTableContent_gm" style="padding-right:3em;"><b>%s</b></td>
		      <td class="dataTableContent_gm" style="padding-right:3em;">%s</td>
		    </tr>', $statistik, $statDateFormat);
		  } else {
		  	 echo '<tr><td width="600" colspan="3" style="background-color: #f7f7f7;">';
		  	 printf(YOOCHOOSE_STATISTIC_EMPTY);
		  	 echo '</td></tr>';
		  }
    } catch (IOException $e) {
    	echo '<tr><td width="600" colspan="3">';
    	echo '<div class="error-message">';
        printf(YOOCHOOSE_CONNECTION_ERROR, $e->getMessage());
        echo '</div>';
        echo '</td></tr>';
    } catch (JSONException $e) {
        $formLicenseError = sprintf(YOOCHOOSE_JSON_ERROR, $message);
        just_log_recommendation("JSON Error loading statistic.", $e);
        just_log_error("JSON Error loading statistic.", $e);        
    }
?>

</table>

</div>


<?php

    


    function loadStatistik() {
        return load_json_url_ex(createSummaryUrl());
    }
    
    function createSummaryUrl() {
        return getRegServerUrl() . "/rest/".YOOCHOOSE_ID."/counter/summary.json";
    }
    
    function printCounter($template, $statistik, $statDateFormat) {
        $result = "";

        $cs = get_object_vars($statistik);
        ksort($cs);
        
        $row_cnt = 0;
        foreach (array_keys($cs) as $counter_name) {
            if(($row_cnt++ % 2) == 0) $gm_row_bg='#d6e6f3'; else $gm_row_bg='#f7f7f7';
            $counter_obj = $cs[$counter_name];
            $counter_value = $counter_obj->count;
            $counter_range = formatDateRange($counter_obj->rangeFrom, $counter_obj->rangeTo, $statDateFormat);

            $title = 'YOOCHOOSE_'.strtoupper($counter_name);
            if (defined($title)) {
                $counter_name_title = constant($title);
            } else {
                $counter_name_title = $counter_name;
            }
            $result .= sprintf($template, $gm_row_bg, $counter_name_title, $counter_value, $counter_range)."\n";
        }
        echo $result;
    }

    
    function formatDateRange($lowerBound, $upperBound, $statDateFormat) {
    	
        if ($lowerBound == $upperBound) {
            $range = strftime($statDateFormat, $lowerBound);
        } else {
            $range = strftime($statDateFormat, $lowerBound) . ' - ' . strftime($statDateFormat, $upperBound);
        }
        return $range;
    }

    
?>