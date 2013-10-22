<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
 */
?>


<div style="padding: 40px;">

<link rel="stylesheet" type="text/css" href="includes/javascript/spiffyCal/spiffyCal_v2_1.css">
<script type="text/javascript" src="includes/javascript/spiffyCal/spiffyCal_v2_1.js"></script>

<?php

    require_once('usage_data_common.php');

	$rowBg1 = '#d6e6f3';
	$rowBg2 = '#f7f7f7';
	
	$oneYearBefore = time() - (365 * 24 * 3600);
	
	$dateFrom = getPost('dateFrom', date($dateFormatPhp, $oneYearBefore));
	$dateTo   = getPost('dateTo',   date($dateFormatPhp));
	$justFile = getPost('justFile', False);
	
	$sprintf_js     = DIR_WS_ADMIN.'yoochoose/sprintf.js';
	$generateAction = DIR_WS_ADMIN.'yoochoose/usage_data_generate.php';
	$toolsAction    = DIR_WS_ADMIN.'yoochoose/usage_data_tools.php';
?>


<style type="text/css">
    tb.dataTableContent_gm_error { color: red; }
    tb.width300 { width: 300; } 
    strong.hist_error {color: red;}
</style>

<script type="text/javascript" src="<?=$sprintf_js?>"></script>
<script type="text/javascript">

    var dateFrom = new ctlSpiffyCalendarBox("dateFrom", "history_upload", "dateFrom", "dateFromBtn", "one year before", scBTNMODE_CUSTOMBLUE);
    var dateTo = new ctlSpiffyCalendarBox("dateTo", "history_upload", "dateTo", "dateToBtn", "today", scBTNMODE_CUSTOMBLUE);

    function historyUploadSubmit() {
        // document.history_upload.justFile.checked;
        return false; // AJAX only function
    }

    
    function reportResult(waitingText, xmlhttp) {

    	var infoBlock = document.getElementById("usageDataInfo");
        
    	if (xmlhttp.readyState == 4) {
	        if (xmlhttp.status == 200) {
	            try {
	                var resp = eval('(' + xmlhttp.responseText + ')');
	                if (resp.success) {
                        return resp.value; // succesided
	                } else { 
	                    infoBlock.innerHTML = '<strong class="hist_error">' + resp.error + '</strong>';
	                }
	            } catch(err) {
	                infoBlock.innerHTML = xmlhttp.responseText;
	            }
	        } else {
	            infoBlock.innerHTML = xmlhttp.status + " " + xmlhttp.statusText;
	        }
    	} else {
    		if (xmlhttp.readyState == 1) {
    			infoBlock.innerHTML = waitingText + " (processing)";    
    		} else if (xmlhttp.readyState == 2) {
    			infoBlock.innerHTML = waitingText + " (waiting for replay)";
            } else if (xmlhttp.readyState == 3) {
            	infoBlock.innerHTML = waitingText + " (tranfering data)";
            }
    	}
        return false; // not ready or failed
    }

    
    function createHttpRequest() {
        var xmlhttp;
        if (window.XMLHttpRequest) { // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        return xmlhttp;
    }

    var YOOCHOOSE_VALIDATING_DDD        = <?=json_encode(utf8_encode(YOOCHOOSE_VALIDATING_DDD))?>;
    var YOOCHOOSE_GENERATING_USAGE_DATA = <?=json_encode(utf8_encode(YOOCHOOSE_GENERATING_USAGE_DATA))?>;
    var YOOCHOOSE_GENERATING_FINISHED   = <?=json_encode(utf8_encode(YOOCHOOSE_GENERATING_FINISHED))?>;
    var YOOCHOOSE_DOWNLOAD_FILE         = <?=json_encode(utf8_encode(YOOCHOOSE_DOWNLOAD_FILE))?>;
    var YOOCHOOSE_MD5_SCHEDULING        = <?=json_encode(utf8_encode(YOOCHOOSE_MD5_SCHEDULING))?>;
    var YOOCHOOSE_MD5_FINISHED          = <?=json_encode(utf8_encode(YOOCHOOSE_MD5_FINISHED))?>;
    var YOOCHOOSE_UPLOAD_SCHEDULED      = <?=json_encode(utf8_encode(YOOCHOOSE_UPLOAD_SCHEDULED))?>;
    var YOOCHOOSE_GENERATING_USAGE_DATA_FINISHED = <?=json_encode(utf8_encode(YOOCHOOSE_GENERATING_USAGE_DATA_FINISHED))?>;
    

    /** Fired, if some date in the form was changed. */
    function datesChanged() {
    	var infoBlock = document.getElementById("usageDataInfo");
        var uploadBtn = document.history_upload.uploadBtn;
        uploadBtn.disabled = true;
    	
        xmlhttp = createHttpRequest();
        xmlhttp.onreadystatechange=function() {
        	if (resp = reportResult(YOOCHOOSE_VALIDATING_DDD, xmlhttp)) {
        		infoBlock.innerHTML = resp.message;
        		uploadBtn.disabled = false; // only if validated.
        	}
        };

        var action = "<?=$toolsAction?>";
        var f = encodeURIComponent(document.history_upload.dateFrom.value);
        var t = encodeURIComponent(document.history_upload.dateTo.value);
        
        xmlhttp.open("GET", action+"?method=check&from="+f+"&to="+t, true);
        xmlhttp.send();
    }


    /** Creates an HTML message to show after the step is succesfully finished. */
    function getHtmlMessageAfterStep(stepOfTen, downloadUrl, md5Url) {

        result = "";
        if (stepOfTen < 10) {
        	result += sprintf(YOOCHOOSE_GENERATING_USAGE_DATA_FINISHED, stepOfTen);
        } else {
        	result += sprintf(YOOCHOOSE_GENERATING_FINISHED, encodeURI(downloadUrl));
        }

        if (stepOfTen == 10) {
        	result += "<br>";
        	result += YOOCHOOSE_MD5_SCHEDULING;
        } else if (stepOfTen == 11) {
        	result += "<br>";
        	result += sprintf(YOOCHOOSE_MD5_FINISHED, encodeURI(md5Url));
        	result += "<br>";
        	result += YOOCHOOSE_UPLOAD_SCHEDULED;
        }
        
        return result;
    }


    
    function uploadData(salt, url) {

        var fromFld = document.history_upload.dateFrom;
        var toFld = document.history_upload.dateTo;

        fromFld.disabled = true;
        toFld.disabled = true;
        
        var uploadBtn = document.history_upload.uploadBtn;
        uploadBtn.disabled = true;

        var infoBlock = document.getElementById("usageDataInfo");
        
        xmlhttp = createHttpRequest();
        xmlhttp.onreadystatechange=function() {
        	resp = reportResult(sprintf(YOOCHOOSE_MD5_SCHEDULING, 11), xmlhttp);
            if (resp) {
                infoBlock.innerHTML = getHtmlMessageAfterStep(11, resp.url, resp.md5url);
                    
                fromFld.disabled = false;
                toFld.disabled = false;
                uploadBtn.disabled = false; // completed. Reenabling user interface.
            }
            if (xmlhttp.readyState == 4 && !resp) {
                fromFld.disabled = false;
                toFld.disabled = false;
                uploadBtn.disabled = false; // something goes wrong
            }
        };

        var action = "<?=$toolsAction?>";

        var f = encodeURIComponent(document.history_upload.dateFrom.value);
        var t = encodeURIComponent(document.history_upload.dateTo.value);
                        
        xmlhttp.open("GET", action + "?method=upload&salt=" + salt, true);

        xmlhttp.send();
    }
    

    
    function appendDataStep(stepOfTen, salt) {

    	var fromFld = document.history_upload.dateFrom;
    	var toFld = document.history_upload.dateTo;

    	fromFld.disabled = true;
    	toFld.disabled = true;
        
        var uploadBtn = document.history_upload.uploadBtn;
        uploadBtn.disabled = true;

        var infoBlock = document.getElementById("usageDataInfo");
        
        xmlhttp = createHttpRequest();
        xmlhttp.onreadystatechange=function() {
        	resp = reportResult(sprintf(YOOCHOOSE_GENERATING_USAGE_DATA, stepOfTen), xmlhttp);
            if (resp) {
                if (stepOfTen == 10) {
                    infoBlock.innerHTML = getHtmlMessageAfterStep(stepOfTen, resp.url);
                    uploadData(resp.salt, resp.url);
                } else {
                	infoBlock.innerHTML = getHtmlMessageAfterStep(stepOfTen);
                    if (stepOfTen == 1) {
                    	salt = resp.salt;
                    }
                    appendDataStep(stepOfTen + 1, salt);
                }
            }
            if (xmlhttp.readyState == 4 && !resp) {
                fromFld.disabled = false;
                toFld.disabled = false;
            	uploadBtn.disabled = false; // something goes wrong
            }
        };

        var action = "<?=$toolsAction?>";

        var f = encodeURIComponent(document.history_upload.dateFrom.value);
        var t = encodeURIComponent(document.history_upload.dateTo.value);        

        if (stepOfTen == 1) {
            xmlhttp.open("GET", action + "?method=append&from=" + f + "&to=" + t + 
            	        "&stepOfTen=" + stepOfTen, true);
        } else {
            xmlhttp.open("GET", action + "?method=append" + 
                        "&stepOfTen=" + stepOfTen + "&salt=" + salt, true);
        }
        xmlhttp.send();
    }    
    

    function renderInfo(response) {

    	var infoBlock = document.getElementById("usageDataInfo"); 
        
        if (responce.success) {
        	infoBlock.innerHTML.styleClass = "dataTableContent_gm dataTableContent_gm_error";
        	infoBlock.innerHTML = responce.value;
        } else {
        	infoBlock.innerHTML.styleClass = "dataTableContent_gm";
        	infoBlock.innerHTML = responce.error;
        }
    	
    }   
</script>

<div style="margin-bottom: 2em;">
<?php echo YOOCHOOSE_USAGE_DATA_UPLOAD_INFO?>
</div>

<form name="history_upload" onsubmit="return historyUploadSubmit()" method="POST">

	<table class="dataTable" border="0" cellspacing="0" cellpadding="4" style="width:710px;">
  		<tr valign="top" bgcolor="<?php printRowColor()?>">
    		<th width="200"><b><?=sprintf(YOOCHOOSE_UPL_FROM, $dateFormatHuman)?></b></th>
    		<td>
    	      <input name='dateFrom' type="text" onclick="datesChanged()" value="<?=$dateFrom?>"/>        
    		</td>
    	</tr>
		<tr valign="top" bgcolor="<?php printRowColor()?>">    		
    		<th width="200"><b><?=sprintf(YOOCHOOSE_UPL_TO, $dateFormatHuman)?></b></th>
    		<td>
                <input name='dateTo' type="text" onclick="datesChanged()" value="<?=$dateTo?>"/>
    		</td>    		
    	</tr>
        <tr valign="top" bgcolor="<?php printRowColor()?>">
            <th width="200"></th>
            <td id="usageDataInfo"><?=YOOCHOOSE_VALIDATING_DDD?></td>
        </tr>
    	<tr valign="top" bgcolor="<?php printRowColor()?>">
    		<th width="200"></th>
    		<td>
    			<input type="submit" class="button" onClick="this.blur(); appendDataStep(1, '')" 
                value="<?=sprintf(YOOCHOOSE_UPL_BTN, $dateFormatHuman)?>" name="uploadBtn" disabled="disabled"/>			
    		</td>
    	</tr>
	</table>
	<div id="spiffycalendar" class="text"></div>
</form>

<script type="text/javascript">
	datesChanged();
</script>

</div>

<?php






?>