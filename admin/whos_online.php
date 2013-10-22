<?php
/* --------------------------------------------------------------
   whos_online.php 2009-12-03 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2008 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(whos_online.php,v 1.30 2002/11/22); www.oscommerce.com
   (c) 2003	 nextcommerce (whos_online.php,v 1.9 2003/08/18); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: whos_online.php 1133 2005-08-07 07:47:07Z gwinger $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  $xx_mins_ago = (time() - 900);

  require('includes/application_top.php');
  require(DIR_FS_INC. 'xtc_get_products.inc.php');

  // remove entries that have expired
  xtc_db_query("delete from " . TABLE_WHOS_ONLINE . " where time_last_click < '" . $xx_mins_ago . "'");
?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
</head>
<body marginwidth="0" marginheight="0" topmargin="0" bottommargin="0" leftmargin="0" rightmargin="0" bgcolor="#FFFFFF">
<!-- header //-->
<?php require(DIR_WS_INCLUDES . 'header.php'); ?>
<!-- header_eof //-->

<!-- body //-->
<table border="0" width="100%" cellspacing="2" cellpadding="2">
  <tr>
    <td class="columnLeft2" width="<?php echo BOX_WIDTH; ?>" valign="top"><table border="0" width="<?php echo BOX_WIDTH; ?>" cellspacing="1" cellpadding="1" class="columnLeft">
<!-- left_navigation //-->
<?php require(DIR_WS_INCLUDES . 'column_left.php'); ?>
<!-- left_navigation_eof //-->
    </table></td>
<!-- body_text //-->
    <td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td width="100%">
			<div class="pageHeading" style="background-image:url(images/gm_icons/hilfsprogr1.png)"><?php echo HEADING_TITLE; ?></div>
			<br />
		</td>
      </tr>
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
              <tr class="dataTableHeadingRow">
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ONLINE; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_CUSTOMER_ID; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_FULL_NAME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_IP_ADDRESS; ?></td>
                <td class="dataTableHeadingContent"><?php echo TABLE_HEADING_ENTRY_TIME; ?></td>
                <td class="dataTableHeadingContent" align="center"><?php echo TABLE_HEADING_LAST_CLICK; ?></td>
              </tr>
<?php
  $whos_online_query = xtc_db_query("select customer_id, full_name, ip_address, time_entry, time_last_click, last_page_url, session_id from " . TABLE_WHOS_ONLINE ." order by time_last_click desc");
  while ($whos_online = xtc_db_fetch_array($whos_online_query)) {
    $time_online = (time() - $whos_online['time_entry']);

//BOF_GM_MOD
     if ( ((!$_GET['info']) || (@$_GET['info'] == $whos_online['session_id'])) && (!$info) ) {
        $info = $whos_online['session_id'];
    }

    else if(!empty($_GET['info'])) $info = $_GET['info'];
//EOF_GM_MOD
    if ($whos_online['session_id'] == $info) {
      echo '              <tr class="dataTableRowSelected">' . "\n";
    } else {
      echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_WHOS_ONLINE, xtc_get_all_get_params(array('info', 'action')) . 'info=' . $whos_online['session_id'], 'NONSSL') . '\'">' . "\n";
    }
?>
                <td class="smallText"><?php echo gmdate('H:i:s', $time_online); ?></td>
                <td class="smallText" align="left"><?php echo $whos_online['customer_id']; ?></td>
                <td class="smallText"><?php echo $whos_online['full_name']; ?></td>
                <td class="smallText" align="left"><?php echo $whos_online['ip_address']; ?></td>
                <td class="smallText"><?php echo date('H:i:s', $whos_online['time_entry']); ?></td>
                <td class="smallText" align="left"><?php echo date('H:i:s', $whos_online['time_last_click']); ?></td>
              </tr>
			  <?php
					if ($whos_online['session_id'] == $info) {
					  echo '              <tr class="dataTableRowSelected">' . "\n";
					} else {
					  echo '              <tr class="dataTableRow" onmouseover="this.className=\'dataTableRowOver\';this.style.cursor=\'hand\'" onmouseout="this.className=\'dataTableRow\'" onclick="document.location.href=\'' . xtc_href_link(FILENAME_WHOS_ONLINE, xtc_get_all_get_params(array('info', 'action')) . 'info=' . $whos_online['session_id'], 'NONSSL') . '\'">' . "\n";
					}
			?>
                <td class="dataTableContent"><?php echo TABLE_HEADING_LAST_PAGE_URL; ?></td>
                <td class="dataTableContent" colspan="5"><?php echo $whos_online['last_page_url']; ?></td>
              </tr>
<?php
  }
?>
              <tr>
                <td class="smallText" colspan="6">
				<!-- bof gm -->
				<?php
					if(xtc_db_num_rows($whos_online_query) > 1) {
						echo sprintf(TEXT_NUMBER_OF_CUSTOMERS, xtc_db_num_rows($whos_online_query));
					} else {
						echo sprintf(TEXT_NUMBER_OF_CUSTOMER, xtc_db_num_rows($whos_online_query));
					}
				?>
				<!-- eof gm -->
				</td>
              </tr>
            </table></td>
<?php

  $heading = array();
  $contents = array();
  if ($info) {
    $heading[] = array('text' => '<b>' . TABLE_HEADING_SHOPPING_CART . '</b>');

    if (STORE_SESSIONS == 'mysql') {
      $session_data = xtc_db_query("select value from " . TABLE_SESSIONS . " WHERE sesskey = '" . $info . "'");
      $session_data = xtc_db_fetch_array($session_data);
      $session_data = trim($session_data['value']);
    } else {
      if ( (file_exists(xtc_session_save_path() . '/sess_' . $info)) && (filesize(xtc_session_save_path() . '/sess_' . $info) > 0) ) {
        $session_data = file(xtc_session_save_path() . '/sess_' . $info);
        $session_data = trim(implode('', $session_data));
      }
    }

      $user_session = unserialize_session_data($session_data);

      if ($user_session) {
        $products = xtc_get_products($user_session);
        for ($i = 0, $n = sizeof($products); $i < $n; $i++) {
          $contents[] = array('text' => $products[$i]['quantity'] . ' x ' . $products[$i]['name']);
        }

        if (sizeof($products) > 0) {
          $contents[] = array('text' => xtc_draw_separator('pixel_black.gif', '100%', '1'));
          $contents[] = array('align' => 'right', 'text'  => TEXT_SHOPPING_CART_SUBTOTAL . ' ' . $user_session['cart']->total . ' ' . $user_session['currency']);
        } else {
          $contents[] = array('text' => '&nbsp;');
        }
      }
    }

  if ( (xtc_not_null($heading)) && (xtc_not_null($contents)) ) {
    echo '            <td width="25%" valign="top">' . "\n";

    $box = new box;
    echo $box->infoBox($heading, $contents);

    echo '            </td>' . "\n";
  }
?>
          </tr>
        </table></td>
      </tr>
    </table></td>
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