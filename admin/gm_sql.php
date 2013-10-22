<?php
/* --------------------------------------------------------------
   gm_sql.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(configuration.php,v 1.40 2002/12/29); www.oscommerce.com
   (c) 2003	 nextcommerce (configuration.php,v 1.16 2003/08/19); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: configuration.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');
	require_once(DIR_FS_CATALOG . 'gm/inc/gm_split_sql_queries.inc.php');
	
	if(isset($_POST['query'])){
		$gm_queries = gm_prepare_string($_POST['query'], true);
		
		$gm_query = array();
		$gm_query = gm_split_sql_queries($gm_queries);
		
		$gm_query_result_output = '';
		
		for($i = 0; $i < count($gm_query); $i++){
			$gm_query_result = mysql_query($gm_query[$i]); // xtc_db_query hier nicht verwenden!
			if(!$gm_query_result) $gm_query_result_output .= GM_SQL_ERROR . mysql_error() . '<br />';
		}
		
		if($gm_query_result_output == '') $gm_query_result_output = GM_SQL_SUCCESS;
	}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script language="JavaScript" type="text/javascript">
function change_color(id){
	if(document.getElementById('result_row_'+id).style.backgroundColor != 'rgb(255, 195, 107)' && document.getElementById('result_row_'+id).style.backgroundColor != '#ffc36b'){
		document.getElementById('result_row_'+id).style.backgroundColor = '#96edb2';
	}
}

function change_color_out(id){
	if(document.getElementById('result_row_'+id).style.backgroundColor != 'rgb(255, 195, 107)' && document.getElementById('result_row_'+id).style.backgroundColor != '#ffc36b'){
		if(id % 2 == 0) document.getElementById('result_row_'+id).style.backgroundColor = '#F6F6F6';
		else document.getElementById('result_row_'+id).style.backgroundColor = '#d6e6f3';
	}
}

function set_color(id){
	if(document.getElementById('result_row_'+id).style.backgroundColor == 'rgb(255, 195, 107)' || document.getElementById('result_row_'+id).style.backgroundColor == '#ffc36b'){
		if(id % 2 == 0) document.getElementById('result_row_'+id).style.backgroundColor = '#F6F6F6';
		else document.getElementById('result_row_'+id).style.backgroundColor = '#d6e6f3';
	}
	else{
		document.getElementById('result_row_'+id).style.backgroundColor = '#ffc36b';
	}

}
</script>
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

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
		
		<div class="pageHeading" style="background-image:url(images/gm_icons/gambio.png)"><?php echo HEADING_TITLE; ?></div>
		<br />
		<span class="main">
		
			<table style="margin-bottom:5px" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableHeadingRow">
				 	<td class="dataTableHeadingContentText" style="border-right: 0px"><?php echo HEADING_TITLE; ?></td>
				</tr>
			</table>
			
			<table style="border: 1px solid #dddddd" border="0" cellpadding="0" cellspacing="0" width="100%">
				<tr class="dataTableRow">
					<td style="font-size: 12px; padding: 0px 10px 11px 10px; text-align: justify">
						<br />
						<?php echo GM_SQL_DESCRIPTION; ?>
						<br />
						<br />
						<a href="<?php echo xtc_href_link('minisql.php'); ?>"><?php echo GM_SQL_MINI_LINK; ?></a>
						<br />
						<br />
						<form name="gm_sql_form" action="<?php echo xtc_href_link('gm_sql.php'); ?>" method="post">
							
							<textarea name="query" cols="100" rows="10"><?php echo stripslashes($_POST['query']); ?></textarea>
							<br />
							<br />
							<input style="margin-left:1px" class="button" type="submit" name="go" value="ausf&uuml;hren" />
							
						</form>
						<?php 
						if(isset($gm_query_result_output)) echo '<br />' . $gm_query_result_output;
						?>
						<?php 
						if(isset($gm_query_result) && $gm_query_result_output == GM_SQL_SUCCESS && count($gm_query) == 1 && strpos(strtolower($gm_query[0]), 'select') === 0 ){
						?>
						<br />
						<br />
						<div id="gm_sql_output" style="width:780px; overflow:scroll; height:500px;">
						<table border="0" cellpadding="3" cellspacing="1" bgcolor="black">
							<tr>
								<?php
								for($i = 0; $i < mysql_num_fields($gm_query_result); $i++){
									$name = mysql_field_name($gm_query_result, $i);
								  echo '<td style="background-color: #585858; color: white; font-family: Arial; font-size: 10px">';
								  echo '<nobr><strong>'. $name .'</strong></nobr>';
								  echo '</td>';
								}
								?>
							</tr>
							<?php
							for($i = 0; $i < mysql_num_rows($gm_query_result); $i++){
								if($i % 2 == 0) $bg = 'bgcolor="#F6F6F6"'; 
								else $bg ='bgcolor="#d6e6f3"';
								echo '<tr '.$bg .' id="result_row_'.$i.'" onmouseover="change_color('.$i.')" onmouseout="change_color_out('.$i.')" onclick="set_color('.$i.')">';
								for($h = 0; $h < mysql_num_fields($gm_query_result); $h++){
									$name = mysql_field_name($gm_query_result, $h);
								  $value = mysql_result($gm_query_result, $i, $name);
								  echo '<td style="font-family: Arial; font-size: 10px" valign="top" '.bg.'><nobr>'. $value .'</nobr></td>';
								}
								echo '</tr>';
								flush();
							}
							?>
						</table>
						</div>
						<?php
						}
						?>
					
					</td>
				</tr>
			</table>
		
		</span>	

    </td>
<!-- body_text_eof //-->
  </tr>
</table>
<!-- body_eof //-->

<!-- footer //-->
<?php require(DIR_WS_INCLUDES . 'footer.php'); ?>
<!-- footer_eof //-->
<br />
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>