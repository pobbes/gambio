<?php
/* --------------------------------------------------------------
   popup_memo.php 2008-05-30 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: popup_memo.php 1125 2005-07-28 09:59:44Z novalis $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

   require('includes/application_top.php');
   include(DIR_FS_LANGUAGES . $_SESSION['language'] . '/admin/customers.php');

if ($_GET['action']) {
switch ($_GET['action']) {

        case 'save':

        $memo_title = xtc_db_prepare_input($_POST['memo_title']);
        $memo_text = xtc_db_prepare_input($_POST['memo_text']);

        if ($memo_text != '' && $memo_title != '' ) {
          $sql_data_array = array(
            'customers_id' => $_POST['ID'],
            'memo_date' => date("Y-m-d"),
            'memo_title' =>$memo_title,
            'memo_text' => nl2br($memo_text),
            'poster_id' => $_SESSION['customer_id']);

          xtc_db_perform(TABLE_CUSTOMERS_MEMO, $sql_data_array);
          }
        break;

        case 'remove':
        xtc_db_query("DELETE FROM ".TABLE_CUSTOMERS_MEMO." where memo_id='".$_GET['mID']."'");
        break;

}
}
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>"> 
<title><?php echo $page_title; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">

</head>
<body bgcolor="#FFFFFF" marginwidth="10" marginheight="10" topmargin="10" bottommargin="10" leftmargin="10" rightmargin="10" style="background-color:#ffffff;margin:15px;">
<table border="0" width="100%" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<div class="pageHeading" style="background-image:url(images/gm_icons/kunden.png)">
			<div style="float:left">
				<?php echo TITLE_MEMO; ?>
			</div>
		</td>
	</tr>
</table>
<br />
<table border="0" width="100%" cellspacing="0" cellpadding="0" class="pdf_menu">
	<tr>
		<td width="120" class="dataTableHeadingContent" style="border-right: 0px;">
			<?php echo TITLE_MEMO; ?>					
		</td>
	</tr>
</table>
<form name="customers_memo" method="POST" action="popup_memo.php?action=save&ID=<?php echo (int)$_GET['ID'];?>">

<table border="0" width="100%" cellspacing="0" cellpadding="2" class="gm_border dataTableRow">
	<tr><td colspan="2" class="main" valign="top">&nbsp;</td></tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			<?php echo TEXT_TITLE ?>
		</td>
		<td class="main" valign="top">
			<?php echo xtc_draw_input_field('memo_title').xtc_draw_hidden_field('ID',(int)$_GET['ID']); ?>
		</td>
	</tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			Text
		</td>
		<td class="main" valign="top">
			<?php echo xtc_draw_textarea_field('memo_text', 'soft', '40', '5'); ?>
		</td>
	</tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			&nbsp;
		</td>
		<td class="main" valign="top">
			<?php echo '<input type="submit" class="button" onClick="this.blur();" value="' . BUTTON_INSERT . '"/>'; ?>
		</td>
	</tr>
</table>
</form>

<?php
  $memo_query = xtc_db_query("
								SELECT
									*
								FROM
									" . TABLE_CUSTOMERS_MEMO . "
								WHERE
									customers_id = '" . (int)$_GET['ID'] . "'
								ORDER BY
									memo_id 
								DESC
							");
	while ($memo_values = xtc_db_fetch_array($memo_query)) {
		$poster_query = xtc_db_query("SELECT customers_firstname, customers_lastname FROM " . TABLE_CUSTOMERS . " WHERE customers_id = '" . $memo_values['poster_id'] . "'");
		$poster_values = xtc_db_fetch_array($poster_query);

?>
<table border="0" width="100%" cellspacing="0" cellpadding="2" class="gm_border dataTableRow">
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			<?php echo TEXT_DATE; ?>
		</td>
		<td class="main" valign="top">
			<?php echo $memo_values['memo_date']; ?>
		</td>
	</tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			<?php echo TEXT_TITLE; ?>
		</td>
		<td class="main" valign="top">
			<?php echo $memo_values['memo_title']; ?>
		</td>
	</tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			<?php echo TEXT_POSTER; ?>
		</td>
		<td class="main" valign="top">
			<?php echo $poster_values['customers_lastname']; ?> <?php echo $poster_values['customers_firstname']; ?>
		</td>
	</tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			Text
		</td>
		<td class="main" valign="top">
			<?php echo $memo_values['memo_text']; ?>
		</td>
	</tr>
	<tr><td colspan="2" class="main" valign="top">&nbsp;</td></tr>
	<tr>
		<td width="100" class="main gm_strong" valign="top">
			&nbsp;
		</td>
		<td class="main" valign="top">
			<a class="button" onClick="this.blur();" href="<?php echo xtc_href_link('popup_memo.php', 'ID=' . $_GET['ID'] . '&action=remove&mID=' . $memo_values['memo_id']); ?>" onClick="return confirm('<?php echo DELETE_ENTRY; ?>')"><?php echo BUTTON_DELETE; ?></a>
		</td>
	</tr>
</table>
	<?php
  }
?>


</body>
</html>