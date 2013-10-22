<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
?>

<?php 
   
    require_once(DIR_FS_ADMIN.'yoochoose/utils.php');
    
    $formAdvView  = @$_GET['advview'] || '0';
        
    $post = isset($_POST['YOOCHOOSE_BOX_TOP_SELLING_HEADER']);
    
    $languages = xtc_get_languages(); 
    
    $strategies = array();
    
    $boxTopSellingHeader      = getContentValue('YOOCHOOSE_BOX_TOP_SELLING_HEADER');
    $boxAlsoClickedHeader     = getContentValue('YOOCHOOSE_BOX_ALSO_CLICKED_HEADER');    
    
    $boxTopSellingStrategy    = getValue('YOOCHOOSE_BOX_TOP_SELLING_STRATEGY',    YOOCHOOSE_BOX_TOP_SELLING_STRATEGY_DEFAULT);
    $boxAlsoPurchasedStrategy = getValue('YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY', YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY_DEFAULT);
    $boxAlsoClickedStrategy   = getValue('YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY',   YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY_DEFAULT);    
    
    $boxTopSellingMax    = getValue('YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY',  YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY_DEFAULT);
    $boxAlsoPurchasedMax = getValue('MAX_DISPLAY_ALSO_PURCHASED',             MAX_DISPLAY_ALSO_PURCHASED_DEFAULT);
    $boxAlsoClickedMax   = getValue('YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY', YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY_DEFAULT);
    
    $boxTopSellingEnabled  = getBoxEnabled(YOOCHOOSE_BOX_TOP_SELLING_NAME, $post);
    $boxAlsoClickedEnabled = getBoxEnabled(YOOCHOOSE_BOX_ALSO_CLICKED_NAME, $post);

    
    if ($post) {
    	
    	if (isStyleEditInstalled()) {
            updateBoxEnabled(YOOCHOOSE_BOX_TOP_SELLING_NAME, YOOCHOOSE_BOX_TOP_SELLING_POSITION, $boxTopSellingEnabled);
            updateBoxEnabled(YOOCHOOSE_BOX_ALSO_CLICKED_NAME, YOOCHOOSE_BOX_ALSO_CLICKED_POSITION, $boxAlsoClickedEnabled);
    	}

        updateContentValue('YOOCHOOSE_BOX_TOP_SELLING_HEADER', $boxTopSellingHeader);
        updateContentValue('YOOCHOOSE_BOX_ALSO_CLICKED_HEADER', $boxAlsoClickedHeader);
        
        updateProperty('YOOCHOOSE_BOX_TOP_SELLING_STRATEGY', $boxTopSellingStrategy,  YOOCHOOSE_BOX_TOP_SELLING_STRATEGY_DEFAULT);
        updateProperty('YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY', $boxAlsoPurchasedStrategy,  YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY_DEFAULT);
        updateProperty('YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY', $boxAlsoClickedStrategy,  YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY_DEFAULT);
        
        updateProperty('YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY', $boxTopSellingMax,  YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY_DEFAULT);
        updateProperty('MAX_DISPLAY_ALSO_PURCHASED', $boxAlsoPurchasedMax,  MAX_DISPLAY_ALSO_PURCHASED_DEFAULT);
        updateProperty('YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY', $boxAlsoClickedMax,  YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY_DEFAULT);
    }
    

    
?>

<form class="yoochoose_prefs" name="yoochoose_prefs" method="POST"
        action="yoochoose.php?page=models&advview=<?php printf("%d", $formAdvView)?>">

<div style="padding: 40px 15px;">

    <table cellspacing="0" cellpadding="0" style="width: 770px;" class="strategies">
        

<?php 
    if ($formAdvView) {
        try {
            $loaded = load_json_url_ex(getRegServerUrl()."/ebl/".YOOCHOOSE_ID."/configuration/strategies.json");
            
            foreach($loaded->strategies->strategy as $strategy) {
                $strategies[] = $strategy->referenceCode;
            }
        } catch (IOException $ex) {
            $text = sprintf(YOOCHOOSE_ERROR_LOADING_STRATEGIES, $ex->getMessage());
            echo '<td colspan="3" style="padding-bottom: 10px;">'; 
            printInfoDiv($text , "onebit_49.png");
            echo '</td>';
            $formAdvView = false;
        }
    }
 ?>

        <tr>
        <td colspan="3" class="unimportant" style="background-color: #F7F7F7; height: 2em; padding: 10px;">
	        <?php echo sprintf(YOOCHOOSE_MODELS_MAIN_MENU)?>
        </td> 
        </tr><tr>
        <td style="width: 16em; vertical-align:text-top;">
            <div class="unimportant" style="height: 5em; margin: 5px 5px 0 0;">
	           <?php echo sprintf(YOOCHOOSE_MODELS_LOGIN)?>
	        </div>
            <div class="important" style="margin: 5px 5px 0 0;">
                <?php printTopSelling($boxTopSellingHeader, $boxTopSellingStrategy, $boxTopSellingMax, $boxTopSellingEnabled); ?>
            </div>
	    </td><td style="vertical-align:text-top;">
	        <div class="unimportant" style=" height: 8em; margin: 5px 0 0 0;">
	            Artikel
	        </div>
	        <div class="important" style="background-color: #D6E6F3; margin: 5px 0 0 0; ">
	            <?php printAlsoPurchased($boxAlsoPurchasedStrategy, $boxAlsoPurchasedMax); ?>
	        </div>
	    </td><td style="width: 16em; vertical-align:text-top;">
            <div class="unimportant" style="background-color: #F7F7F7; height: 2em; margin: 5px 0 0 5px; ">
                &nbsp;
            </div>     
               
	        <div class="important" style="background-color: #D6E6F3; margin: 5px 0 0 5px;">
	            <?php printAlsoClicked($boxAlsoClickedHeader, $boxAlsoClickedStrategy, $boxAlsoClickedMax, $boxAlsoClickedEnabled); ?>
	        </div>        
	    </td>
        </tr><tr>
            <td></td>
	        <td style="height: 2em; padding: 7px;">
	            <input type="submit" class="button" style="display:block; margin: 10px auto 0 auto;"
	                value="<?php echo sprintf(YOOCHOOSE_PREF_BTN)?>" name="btn"/>   
	        </td>      
	        <td style="text-align:right;">
                <?php if (!$formAdvView) { ?>
	            <a href="yoochoose.php?page=models&advview=1"><?php echo YOOCHOOSE_ADVANCED_SETTINGS;?></a>
                <?php } ?>
	        </td>
        </tr><tr>
            <td colspan="3" style="padding-top: 30px;"> 
    	    <?php
    	    
    	    if (isStyleEditInstalled()) {
	        	$text = sprintf(YOOCHOOSE_MODELS_POSITION_HINT, 'gm_style_edit.php'); 
	            printInfoDiv($text , "onebit_22.png");
	        } else {
	        	$text = sprintf(YOOCHOOSE_MODELS_POSITION_NO_STYLEEDIT, 'yoochoose.php?page=faq#styleedit');
	        	printInfoDiv($text, "onebit_47.png");
	        }
	        ?>
            </td>
        </tr>
    </table>
    
</div>

    
</form>

<?php 

    function printTopSelling($header, $strategy, $max, $enabled) {
    	global $formAdvView;
    	
    	printInputContent('YOOCHOOSE_BOX_TOP_SELLING_HEADER', $header, 19);
    	
    	echo "<div class='values'>";
        printInputCheckbox(YOOCHOOSE_BOX_TOP_SELLING_NAME.'_ENABLED', $enabled, !isStyleEditInstalled());
        echo " - ".YOOCHOOSE_BOX_ENABLED."<br>";
        echo "</div>"; 
    	
    	if ($formAdvView) {
    	   echo YOOCHOOSE_STRATEGY.":<br>";
    	   printSelectStrategy('YOOCHOOSE_BOX_TOP_SELLING_STRATEGY', $strategy);
    	}
        
    	echo "<div class='values'>".YOOCHOOSE_MAX_RECOMMENDATIONS;
    	echo "<input size='2' name='YOOCHOOSE_BOX_TOP_SELLING_MAX_DISPLAY' value='".htmlentities($max)."'>";
    	echo "</div>";
    }
    
    
    function printAlsoPurchased($strategy, $max) {
    	global $formAdvView;
    	
        printAlsoPurchaseHeader();
        if ($formAdvView) {
            echo YOOCHOOSE_STRATEGY.": ";
            printSelectStrategy('YOOCHOOSE_BOX_ALSO_PURCHASED_STRATEGY', $strategy);
        }
        echo "<br>";
        echo "<div class='values'>".YOOCHOOSE_MAX_RECOMMENDATIONS;
        echo "<input size='2' name='MAX_DISPLAY_ALSO_PURCHASED' value='".htmlentities($max)."'>";
        echo "</div>";
    }
    
    
    function printAlsoClicked($header, $strategy, $max, $enabled) {
    	global $formAdvView;
    	
    	printInputContent('YOOCHOOSE_BOX_ALSO_CLICKED_HEADER', $header, 19);
    	       
        echo "<div class='values'>";
        printInputCheckbox(YOOCHOOSE_BOX_ALSO_CLICKED_NAME.'_ENABLED', $enabled, !isStyleEditInstalled());
        echo " - ".YOOCHOOSE_BOX_ENABLED."<br>";
        echo "</div>";
        
    	if ($formAdvView) {
            echo YOOCHOOSE_STRATEGY.":<br>";
            printSelectStrategy('YOOCHOOSE_BOX_ALSO_CLICKED_STRATEGY', $strategy);
    	}
    	
        echo "<div class='values'>".YOOCHOOSE_MAX_RECOMMENDATIONS;
        echo "<input size='2' name='YOOCHOOSE_BOX_ALSO_CLICKED_MAX_DISPLAY' value='".htmlentities($max)."'>";
        echo "</div>";
    }
    
    
    /** It was an embeded gambio header. Here is a bit sophisticated code to fetch it */
    function printAlsoPurchaseHeader() {
    	global $languages;
    	foreach ($languages as $lang) {
            $landId = $lang[id];
            $inputName = YOOCHOOSE_BOX_ALSO_PURCHASED_HEADER.'['.$landId.']';
            
            $lang_fs_path = DIR_FS_CATALOG . 'lang/' . $lang['directory'];
            $lang_ws_path = DIR_WS_CATALOG . 'lang/' . $lang['directory'];
            $imgSrc = $lang_ws_path . '/' . $lang['image'];

            require($lang_fs_path."/sections/_samples/also_purchased.lang.inc.php");

            echo "<div class='values'>";
            echo "<input class='values header' size='51' readonly='readonly' type='text'
                 name='$inputName' value='".$t_language_text_section_content_array['heading_text']."'>";
            echo "<img class='langicon' src='$imgSrc'>"; 
            echo "</div>";
    	}
    }
    
    
    function printInputContent($name, $content, $size) {
    	global $languages;
    	foreach ($languages as $lang) {
    		$landId = $lang[id];
    		$inputName = $name.'['.$landId.']';
    		$text = $content[$landId];
    		$imgSrc = DIR_WS_CATALOG . 'lang/' . $lang['directory'].'/'.$lang['image'];
    		
    		echo "<div class='values'>";
    	    echo "<input class='header' size='$size' name='$inputName' value='".htmlentities($text)."'>";
    	    echo "<img class='langicon' src='$imgSrc'>";
    	    echo "</div>";	
    	}
    }
    
    
    function printInputCheckbox($inputName, $checked, $readonly = false) {
         echo "<input name='$inputName' type='checkbox' class='checked'";
         echo $checked ? " checked='checked'" : "";
         echo $readonly ? " disabled='disabled'" : "";
         echo ">";
    }    
    
    
    function printSelectStrategy($inputName, $selectedStrategy) {
    	global $strategies;
       	echo "<select class='values' name='$inputName'>";
    	foreach ($strategies as $value) {
            echo "<option value='$value'".($value==$selectedStrategy?' selected="selected"':'').">";
            echo htmlentities($value);
            echo "</option>";
    	}
    	echo "</select>";
    }

?>



<?php

    function printInfoDiv($content, $icon) {
    	echo '<div class="info" style=\'background-image:url("yoochoose/images/kurumizawa/'.$icon.'")\'">';
    	echo $content;
    	echo '</div>';
    }
    
    function printQuestionDiv($question, $answer) {
        echo '<div class="$question">';
        echo $question.'<br>';
        echo $answer;
        echo '</div>';
    }
    


    /** Boxes can be enabled or disabled via GUI only, if the StyleEdit installed.
     *  If the StyleEdit is not installes, see the file "<your template>/template_settings.php" */
    function isStyleEditInstalled() {
        $activeBoxesEditable = is_dir(DIR_FS_CATALOG.'StyleEdit/');
        return $activeBoxesEditable;
    }
    
    
    /** Reads the box array from the template settings file.
     *  
     *  Returns false, if the file not found or the
     *  specified box doesn't exists in the configuration.
     */ 
    function getBoxStaticSettings($boxName) {
    	
    	$settingsfile = getTemplateSettingFile();
    	
    	if (is_file($settingsfile)) {
    	   include($settingsfile);
    	
    	   if (@isset($t_template_settings_array['MENUBOXES'][$boxName])) {
    	   	   return $t_template_settings_array['MENUBOXES'][$boxName];
    	   } else {
    	   	   return false;
    	   }
    	} else {
    		return false;
    	}
    }
    
    
    function getTemplateSettingFile() {
    	$setting_file = DIR_FS_CATALOG.'templates/'.CURRENT_TEMPLATE.'/template_settings.php';
    	return $setting_file;
    }
       
    
    /** Reads the value "$boxName_ENABLED" from POST. 
     *  If not set and $readFromPort==true, returns false.
     *  
     *  Otherwise reads the "status" field from the table "gm_boxes".
     *  
     *  If the StyleEdit is not active, returns static setting.
     *  
     *  If the temlpate doesn't support the box, returns false.
     */
    function getBoxEnabled($boxName, $readFromPost) {
    	
    	$statisSettings = getBoxStaticSettings($boxName);
    	
    	if (!$statisSettings) {
    	   return false;
    	   
    	} else if (isStyleEditInstalled()) {
        
    		// Styleedit installed. Stytic settings can be ignored.
	        $postName = $boxName.'_ENABLED';
	        if (isset($_POST[$postName])) {
	            return $_POST[$postName] ? true : false;
	        } else if ($readFromPost) {
	            return false;
	        }
	        
	        $sql = 'SELECT box_status FROM gm_boxes WHERE template_name=\'%1$s\' AND box_name=\'%2$s\'';
	        
	        $resultset = xtc_db_query(sprintf($sql, CURRENT_TEMPLATE, $boxName));
	        
	        if ($record = xtc_db_fetch_array($resultset)) {
	            return $record['box_status'];
	        } else {
	            return false;
	        }
	        
    	} else {
    		
    		return $statisSettings['STATUS'];
    	}
    }




?>