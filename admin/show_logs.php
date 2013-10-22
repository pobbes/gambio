<?php
/* --------------------------------------------------------------
   show_log.php 2012-08-10 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project
   (c) 2002-2003 osCommerce coding standards (a typical file) www.oscommerce.com
   (c) 2003      nextcommerce (start.php,1.5 2004/03/17); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: start.php 1235 2005-09-21 19:11:43Z mz $)

   Released under the GNU General Public License
   --------------------------------------------------------------
*/

/*
 * needed functions
 */
require_once('includes/application_top.php');
/*
 * class to show logs
 */
require_once('gm/classes/ShowLogs.php');

$page_array[0]['id'] = 1;
$page_array[0]['text'] = 1;

$coo_show_logs = new ShowLogs();

// get a list of logs
$file_array = $coo_show_logs->scan_dir();

// set filename
$file = $file_array[0]['id'];
if((isset($_GET['file']) || isset($_GET['hidden_file'])) && (!empty($_GET['file']) || !empty($_GET['hidden_file']))) {
	$file = $_GET['file'];
    if(!empty($_GET['hidden_file'])) {
		$file = $_GET['hidden_file'];
	}
}

$checked_filename = $coo_show_logs->check_file_name($file, $file_array);
if($checked_filename) {
    // get page numbers for the page select
    $page_array = $coo_show_logs->get_page_number($file);

    // set pagenumber
    $page = 1;
    if(isset($_GET['page']) && !empty($_GET['page'])) {
        $page = (int)$_GET['page'];
    }

    // read log
    if(!empty($file_array[0]['id'])) {
        $log = $coo_show_logs->get_log($file, $page);
    }
} else {
    $error_message = TEXT_ERROR_MESSAGE.' ('.$file.')';
}

if(isset($_GET['action']) && $_GET['action'] == 'mark_as_read')
{
	$coo_show_logs->mark_as_read($_SESSION['customer_id'], $_GET['file']);
	$t_success_message = LOG_MARKED_AS_READ;
}

?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript" src="gm/javascript/ShowLog.js"></script>
</head>

<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">

<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<script type="text/javascript">
    $(document).ready(function(){
        var coo_show_log = new ShowLog();
		var divWidth = $('#test').width();
		var t_last_key_pressed = 0;

		$('#log_content').width(divWidth-4);
		$('#log_content').show();

		$(document).keydown(function(e) {

			var t_key_pressed = (e.keyCode ? e.keyCode : (e.which ? e.which : e.charCode));
			
			// r = reload
			if (t_key_pressed == 82) {
				location.reload();
			}
			// e = Log neu laden
			if (t_key_pressed == 69) {
				coo_show_log.do_request();
				$('#log_message').html(' - Log neu geladen');
				$("#log_message").fadeIn("fast").delay(4000).fadeOut("fast");
			}
			// d = delete selected log
			if (t_key_pressed == 68) {
				if(confirm('Log wirklich löschen?')) {
					coo_show_log.delete_log();
				}
			}
			// c = clear selected log
			if (t_key_pressed == 67 && t_last_key_pressed != 17) {
				
				if(confirm('Log wirklich leeren?')) {
		            coo_show_log.clear_log();
					coo_show_log.do_request();
				}
			}
			// a = autoload start/stop
			if (t_key_pressed == 65) {
				if($('input[name="autoload"]').is(':checked')) {
					$('input[name="autoload"]').attr('checked', false);
				} else {
					$('input[name="autoload"]').attr('checked', true);
				}
	            coo_show_log.start_stop('<?php echo TEXT_MIN_TIME; ?>');
			}

			t_last_key_pressed = (e.keyCode ? e.keyCode : (e.which ? e.which : e.charCode));
		});

        $('input[name="autoload"]').change(function(){
            coo_show_log.start_stop('<?php echo TEXT_MIN_TIME; ?>');
        });
     });
</script>

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
    <tr>
        <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top">
            <table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
                <!-- left_navigation //-->
                <?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
                <!-- left_navigation_eof //-->
            </table>
        </td>
        <!-- body_text //-->
        <td class="boxCenter" width="100%" valign="top">
           <span class="main">
               <table border="0" width="100%" cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="100%">
                            <div class="pageHeading" style="float:left; background-image:url(images/gm_icons/hilfsprogr1.png)">
                                <?php echo HEADING_TITLE; ?>
                            </div>
                            <table class="showLogMenu" width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
										<span>
											<?php
											echo '<label for="autoload">'.TEXT_AUTO_LOAD.'</label>&nbsp;';
											echo xtc_draw_input_field('autoload', '1', 'id="autoload"', false, 'checkbox')
											?>
										</span>
										<span>
											<?php
											echo '<label for="interval">'.TEXT_AUTO_LOAD_INTERVAL.'</label>&nbsp;';
											echo xtc_draw_input_field('auto_interval', '3', 'style="width: 40px;" id="interval"');
											?>
										</span>
										<span>
											<?php
											echo xtc_draw_form('file_search', FILENAME_SHOW_LOGS, '', 'get');
											echo xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
											echo HEADING_LOG_FILE . '&nbsp;' .
												xtc_draw_pull_down_menu('file',
													$file_array,
													$file,
													'onChange="this.form.submit();"');
											?>
											</form>
										</span>
										<span>
											<?php
											echo xtc_draw_form('file_search1', FILENAME_SHOW_LOGS, '', 'get');
											echo xtc_draw_hidden_field(xtc_session_name(), xtc_session_id());
											echo xtc_draw_hidden_field('hidden_file', $file);
											echo HEADING_PAGE_NUMBER . '&nbsp;';
											echo xtc_draw_pull_down_menu(
													'page',
													$page_array,
													$page,
													'onChange="this.form.submit();"');
											?>
											</form>
										</span>
                                    </td>
                                </tr>
                            </table>
                            <table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
                                <tr class="dataTableHeadingRow">
                                    <td class="dataTableHeadingContentText" style="border-right: 0px;">
                                        <?php echo HEADING_TITLE; ?>
										<span style="display: none;" id="counter">
											<?php
											echo ' - '.TEXT_RELOAD.'&nbsp;';
											echo '<span id="timer" style="width: 40px; font-weight: bold;"></span>';
											?>
										</span>
										<span style="display: none;" id="log_message">
										</span>
                                    </td>
                                </tr>
                            </table>
                            <?php
                            // show errormessage
                            if(!empty($error_message)) {
                                ?>
                                <table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr class="dataTableHeadingRow">
                                        <td class="dataTableHeadingContentText" style="border-right: 0px; background-color: #BB0000; color: white;"><?php echo $error_message; ?></td>
                                    </tr>
                                </table>
                                <?php
                            }
							 // show success message
                            if(!empty($t_success_message)) {
                                ?>
                                <table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
                                    <tr class="dataTableHeadingRow">
                                        <td class="dataTableHeadingContentText" style="border-right: 0px; background-color: #408e2f; color: white;"><?php echo $t_success_message; ?></td>
                                    </tr>
                                </table>
                                <?php
                            }
                            ?>
                            <table width="100%" cellspacing="0" cellpadding="0" border="0">
                                <tr>
                                    <td>
                                        <div id="log_content" style="padding: 2px; display: none; width: 100%; height: 500px; border: 1px solid #DDDDDD; overflow:auto; font-size: 12px; background-color: #F7F7F7;">
                                            <?php
                                            echo nl2br($log);
                                            ?>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>
			   <div style="float:left">
				   <ul style="list-style-type: none; padding-left: 10px;">
					<li>r = Seite neu laden</li>
					<li>a = Log automatisch neu laden</li>
					<li>e = Log neu laden</li>
				</ul>
				<h3 style="padding-bottom: 0px;">Vorsicht!</h3>
				<ul style="list-style-type: none; padding-left: 10px;">
					<li>c = Gew&auml;hltes Log leeren</li>
					<li>d = Gew&auml;hltes Log l&ouml;schen</li>
				</ul>
			   </div>
			   <div style="width:100%; text-align: right; margin-top: 20px">
			   <?php
			   if($coo_show_logs->check_for_change($_SESSION['customer_id'], $_GET['file']) == true)
			   {
				   echo '<a style="width: auto; display: inline-block" class="button" href="' . xtc_href_link(FILENAME_SHOW_LOGS, xtc_get_all_get_params() . 'action=mark_as_read') . '">' . BUTTON_MARK_AS_READ . '</a>';
			   }
			   ?>
			   </div>
            </span>
        </td>
        <!-- body_text_eof //-->
    </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br>
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>