<?php
/* --------------------------------------------------------------
   module_newsletter.php 2010-01-13 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2010 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommercecoding standards www.oscommerce.com
   (c) 2003  nextcommerce (templates_boxes.php,v 1.14 2003/08/18); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: module_newsletter.php 1142 2005-08-11 08:19:55Z matthias $)

   Released under the GNU General Public License
   --------------------------------------------------------------*/

  require('includes/application_top.php');

  require_once(DIR_FS_CATALOG.DIR_WS_CLASSES.'class.phpmailer.php');
  require_once(DIR_FS_INC . 'xtc_php_mail.inc.php');
  // BOF GM_MOD:
	require_once(DIR_FS_ADMIN . 'gm/fckeditor/fckeditor.php');

  switch ($_GET['action']) {  // actions for datahandling

    case 'save': // save newsletter

     $id=xtc_db_prepare_input((int)$_POST['ID']);
     $status_all=xtc_db_prepare_input($_POST['status_all']);
     if ($newsletter_title=='') $newsletter_title='no title';
     $customers_status=xtc_get_customers_statuses();
     // BOF GM_MOD:
		 sort($customers_status);

     $rzp='';
     for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {
         if (xtc_db_prepare_input($_POST['status'][$i])=='yes') {
             if ($rzp!='') $rzp.=',';
             $rzp.=$customers_status[$i]['id'];
         }
     }

      if (xtc_db_prepare_input($_POST['status_all'])=='yes') $rzp.=',all';

   $error=false; // reset error flag
   if ($error == false) {

      $sql_data_array = array( 'title'=> xtc_db_prepare_input($_POST['title']),
                               'status' => '0',
                               'bc'=>$rzp,
                               'cc'=>xtc_db_prepare_input($_POST['cc']),
                               'date' => 'now()',
                               'body' => xtc_db_prepare_input($_POST['newsletter_body']));

   if ($id!='') {
   xtc_db_perform(TABLE_MODULE_NEWSLETTER, $sql_data_array, 'update', "newsletter_id = '" . $id . "'");
   // create temp table
   xtc_db_query("DROP TABLE IF EXISTS module_newsletter_temp_".$id);
   xtc_db_query("CREATE TABLE module_newsletter_temp_".$id."
                  (
                     id int(11) NOT NULL auto_increment,
                    customers_id int(11) NOT NULL default '0',
                    customers_status int(11) NOT NULL default '0',
                    customers_firstname varchar(64) NOT NULL default '',
                    customers_lastname varchar(64) NOT NULL default '',
                    customers_email_address text NOT NULL,
                    mail_key varchar(32) NOT NULL,
                    date datetime NOT NULL default '0000-00-00 00:00:00',
                    comment varchar(64) NOT NULL default '',
                    PRIMARY KEY  (id)
                    )");
   } else {
   xtc_db_perform(TABLE_MODULE_NEWSLETTER, $sql_data_array);
   // create temp table
   $id=xtc_db_insert_id();
   xtc_db_query("DROP TABLE IF EXISTS module_newsletter_temp_".$id);
   xtc_db_query("CREATE TABLE module_newsletter_temp_".$id."
                  (
                     id int(11) NOT NULL auto_increment,
                    customers_id int(11) NOT NULL default '0',
                    customers_status int(11) NOT NULL default '0',
                    customers_firstname varchar(64) NOT NULL default '',
                    customers_lastname varchar(64) NOT NULL default '',
                    customers_email_address text NOT NULL,
                    mail_key varchar(32) NOT NULL,
                    date datetime NOT NULL default '0000-00-00 00:00:00',
                    comment varchar(64) NOT NULL default '',
                    PRIMARY KEY  (id)
                    )");
   }

   // filling temp table with data!
   $flag='';
   if (!strpos($rzp,'all')) $flag='true';
   $rzp=str_replace(',all','',$rzp);
   $groups=explode(',',$rzp);
   $sql_data_array='';

   for ($i=0,$n=sizeof($groups);$i<$n;$i++) {
   // check if customer wants newsletter

   if (xtc_db_prepare_input($_POST['status_all'])=='yes') {
		$customers_query=xtc_db_query("SELECT
											c.customers_id,
											c.customers_firstname,
											c.customers_lastname,
											c.customers_email_address,
											n.mail_key
										FROM " . TABLE_CUSTOMERS . " c
										LEFT JOIN " . TABLE_NEWSLETTER_RECIPIENTS . " AS n USING(customers_id)
										WHERE
											c.customers_status = '" . $groups[$i] . "'");
		
   } else {
      $customers_query=xtc_db_query("SELECT
										  customers_email_address,
										  customers_id,
										  customers_firstname,
										  customers_lastname,
										  mail_key
									  FROM ".TABLE_NEWSLETTER_RECIPIENTS."
									  WHERE
										 customers_status='".$groups[$i]."' and
										 mail_status='1'");
   }
   while ($customers_data=xtc_db_fetch_array($customers_query)){
          $sql_data_array=array(
                               'customers_id'=>$customers_data['customers_id'],
                               'customers_status'=>$groups[$i],
                               'customers_firstname'=>$customers_data['customers_firstname'],
                               'customers_lastname'=>$customers_data['customers_lastname'],
                               'customers_email_address'=>$customers_data['customers_email_address'],
                               'mail_key'=>$customers_data['mail_key'],
                               'date'=>'now()');

   xtc_db_perform('module_newsletter_temp_'.$id, $sql_data_array);
   }

   if($groups[$i] == 1 && xtc_db_prepare_input($_POST['status_all'])=='yes')
   {
	   $customers_query2=xtc_db_query("SELECT
											  customers_email_address,
											  customers_firstname,
											  customers_lastname,
											  mail_key
										  FROM ".TABLE_NEWSLETTER_RECIPIENTS."
										  WHERE
											  customers_id='0' and
											  mail_status='1'");
   }
   }

   // BOF GM_MOD:
   if(isset($customers_query2)){
		while ($customers_data=xtc_db_fetch_array($customers_query2)){
          	$sql_data_array=array(
                               'customers_id'=>0,
                               'customers_status'=>1,
                               'customers_firstname'=>$customers_data['customers_firstname'],
                               'customers_lastname'=>$customers_data['customers_lastname'],
                               'customers_email_address'=>$customers_data['customers_email_address'],
                               'mail_key'=>$customers_data['mail_key'],
                               'date'=>'now()');

   		xtc_db_perform('module_newsletter_temp_'.$id, $sql_data_array);
   		}
   }
   // EOF GM_MOD

   xtc_redirect(xtc_href_link(FILENAME_MODULE_NEWSLETTER));
   }

   break;

   case 'delete':

   xtc_db_query("DELETE FROM ".TABLE_MODULE_NEWSLETTER." WHERE   newsletter_id='".(int)$_GET['ID']."'");
   xtc_redirect(xtc_href_link(FILENAME_MODULE_NEWSLETTER));

   break;

   case 'send':
   // max email package  -> should be in admin area!
   $package_size='200';
   xtc_redirect(xtc_href_link(FILENAME_MODULE_NEWSLETTER,'send=0,'.$package_size.'&ID='.(int)$_GET['ID']));
   }

// action for sending mails!

if ($_GET['send']) {

$limits=explode(',',$_GET['send']);
$limit_low = $limits['0'];
$limit_up = $limits['1'];



     $limit_query=xtc_db_query("SELECT count(*) as count
                                FROM module_newsletter_temp_".(int)$_GET['ID']."
                                ");
     $limit_data=xtc_db_fetch_array($limit_query);



 // select emailrange from db

    $email_query=xtc_db_query("SELECT
                               customers_firstname,
                               customers_lastname,
                               customers_email_address,
                               mail_key ,
                               id
                               FROM  module_newsletter_temp_".(int)$_GET['ID']."
                               LIMIT ".$limit_low.",".$limit_up);

     $email_data=array();
 while ($email_query_data=xtc_db_fetch_array($email_query)) {

 $email_data[]=array('id' => $email_query_data['id'],
                      'firstname'=>$email_query_data['customers_firstname'],
                      'lastname'=>$email_query_data['customers_lastname'],
                      'email'=>$email_query_data['customers_email_address'],
                      'key'=>$email_query_data['mail_key']);
 }

 // ok lets send the mails in package of 30 mails, to prevent php timeout
 $package_size='200';
 $break='0';
 if ($limit_data['count']<$limit_up) {
     $limit_up=$limit_data['count'];
     $break='1';
 }
 $max_runtime=$limit_up-$limit_low;
  $newsletters_query=xtc_db_query("SELECT
                                   title,
                                    body,
                                    bc,
                                    cc
                                  FROM ".TABLE_MODULE_NEWSLETTER."
                                  WHERE  newsletter_id='".(int)$_GET['ID']."'");
 $newsletters_data=xtc_db_fetch_array($newsletters_query);
// BOF GM_MOD
if(!empty($newsletters_data['cc']) && $limit_low == '0')
{
	$t_gm_cc_mails = array($newsletters_data['cc']);
	
	if(strpos($newsletters_data['cc'], ',') !== false)
	{
		$t_gm_cc_mails = explode(',', $newsletters_data['cc']);
	}
	elseif(strpos($newsletters_data['cc'], ';') !== false)
	{
		$t_gm_cc_mails = explode(';', $newsletters_data['cc']);
	}
	
	for($i = 0; $i < count($t_gm_cc_mails); $i++)
	{
		xtc_php_mail(EMAIL_SUPPORT_ADDRESS,
						EMAIL_SUPPORT_NAME,
						trim($t_gm_cc_mails[$i]),
						trim($t_gm_cc_mails[$i]),
						'',
						EMAIL_SUPPORT_REPLY_ADDRESS,
						EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
						'',
						'',
						$newsletters_data['title'],
						$newsletters_data['body'].$link2,
						$newsletters_data['body'].$link1);	
	}
}
// EOF GM_MOD

 for ($i=1;$i<=$max_runtime;$i++)
 {
  // mail

	 $link1 = '';
	 $link2 = '';

	 if(!empty($email_data[$i-1]['key']))
	 {
		$link1 = chr(13).chr(10).chr(13).chr(10).TEXT_NEWSLETTER_REMOVE.chr(13).chr(10).chr(13).chr(10).HTTP_CATALOG_SERVER.DIR_WS_CATALOG.FILENAME_CATALOG_NEWSLETTER.'?action=remove&email='.urlencode($email_data[$i-1]['email']).'&key='.$email_data[$i-1]['key'];
		$link2 = '<br /><br /><hr>'.TEXT_NEWSLETTER_REMOVE.'<br /><a href="'.HTTP_CATALOG_SERVER.DIR_WS_CATALOG.FILENAME_CATALOG_NEWSLETTER.'?action=remove&email='.urlencode($email_data[$i-1]['email']).'&key='.$email_data[$i-1]['key'].'">' . TEXT_REMOVE_LINK . '</a>';
	 }

  xtc_php_mail(EMAIL_SUPPORT_ADDRESS,
               EMAIL_SUPPORT_NAME,
               $email_data[$i-1]['email'] ,
               $email_data[$i-1]['lastname'] . ' ' . $email_data[$i-1]['firstname'] ,
               '',
               EMAIL_SUPPORT_REPLY_ADDRESS,
               EMAIL_SUPPORT_REPLY_ADDRESS_NAME,
                '',
                '',
                $newsletters_data['title'],
                $newsletters_data['body'].$link2,
                $newsletters_data['body'].$link1);

  xtc_db_query("UPDATE module_newsletter_temp_".(int)$_GET['ID']." SET comment='send' WHERE id='".$email_data[$i-1]['id']."'");

 }
 if ($break=='1') {
     // finished

          $limit1_query=xtc_db_query("SELECT count(*) as count
                                FROM module_newsletter_temp_".(int)$_GET['ID']."
                                WHERE comment='send'");
     $limit1_data=xtc_db_fetch_array($limit1_query);

     if ($limit1_data['count']-$limit_data['count']<=0)
     {
     xtc_db_query("UPDATE ".TABLE_MODULE_NEWSLETTER." SET status='1' WHERE newsletter_id='".(int)$_GET['ID']."'");
     xtc_redirect(xtc_href_link(FILENAME_MODULE_NEWSLETTER));
     } else {
     echo '<b>'.$limit1_data['count'].'<b> emails send<br />';
     echo '<b>'.$limit1_data['count']-$limit_data['count'].'<b> emails left';
     }


 } else {
 $limit_low=$limit_up+1;
 $limit_up=$limit_low+$package_size;
 xtc_redirect(xtc_href_link(FILENAME_MODULE_NEWSLETTER,'send='.$limit_low.','.$limit_up.'&ID='.(int)$_GET['ID']));
 }


}


?>
<!doctype html public "-//W3C//DTD HTML 4.01 Transitional//EN">
<html <?php echo HTML_PARAMS; ?>>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $_SESSION['language_charset']; ?>">
<?php
if(preg_match('/MSIE [\d]{2}\./i', $_SERVER['HTTP_USER_AGENT']))
{
?>
<meta http-equiv="X-UA-Compatible" content="IE=EmulateIE9" />
<?php
}
?>
<title><?php echo TITLE; ?></title>
<link rel="stylesheet" type="text/css" href="includes/stylesheet.css">
<script type="text/javascript">
<!--
	function gm_show_newsletter_recipients(box_id)
	{
		if($('#' + box_id).css('display') == 'block')
		{	
			$('#' + box_id).css({"display": "none"});
		}
		else
		{
			$('#' + box_id).css({"display": "block"});
		}
		return;							
	}
//-->
</script>

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
    <td width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="0">
      <tr>
        <td width="100%">
			<div class="pageHeading" style="background-image:url(images/gm_icons/hilfsprogr1.png)"><?php echo HEADING_TITLE; ?></div>
			<br />
		</td>
      </tr>

 <?php
 if ($_GET['send'])
 {
 ?>

      <tr><td>
      Sending
      </td></tr>
<?php
}
?>

      <tr>
        <td><table width="100%" border="0">
          <tr>
            <td>
 <?php

 // Default seite
switch ($_GET['action']) {

    default:
		

		$customer_group_query=xtc_db_query("
											SELECT
												 customers_status_name,
												 customers_status_id,
												 customers_status_image
											FROM " . 
												TABLE_CUSTOMERS_STATUS . "
											WHERE
												language_id='" . $_SESSION['languages_id'] . "'
											");
		$customer_group=array();
		while ($customer_group_data=xtc_db_fetch_array($customer_group_query)) 
		{

			// get single users
			$group_query = xtc_db_query("
										SELECT 
											customers_email_address,											
											customers_firstname,
											customers_lastname
										FROM " . 
											TABLE_NEWSLETTER_RECIPIENTS . "
										WHERE 
											mail_status='1' 
										AND
											customers_status='" . $customer_group_data['customers_status_id'] . "'
										ORDER BY
											customers_email_address
										");
			
			
			$gm_user_count = xtc_db_num_rows($group_query);

			$gm_newsletter_recipients .= '<table border="0" width="100%" cellspacing="0" cellpadding="2">';
			while($group_data = xtc_db_fetch_array($group_query))
			{
				$gm_newsletter_recipients .= '<tr><td class="main">' . $group_data['customers_firstname'] . ' ' . $group_data['customers_lastname'] . '</td><td class="main">' . $group_data['customers_email_address'] . '</td></tr>';
			}
			$gm_newsletter_recipients .= "</table>";

			$customer_group[] = array
									(
										'ID'			=>	$customer_group_data['customers_status_id'],
										'NAME'			=>	$customer_group_data['customers_status_name'],
										'IMAGE'			=>	$customer_group_data['customers_status_image'],
										'USERS'			=>	$gm_user_count,
										'USERS_INFO'	=>	$gm_newsletter_recipients
									);
			$gm_user_count = 0;
			$gm_newsletter_recipients = '';
		}

 ?>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tr class="dataTableHeadingRow">
					<td class="dataTableHeadingContent" width="150">
						<?php echo TITLE_CUSTOMERS; ?>
					</td>
					<td class="dataTableHeadingContent">
						<?php echo TITLE_STK; ?>
					</td>
				</tr>
			</table>
				<?php
					for ($i=0,$n=sizeof($customer_group); $i<$n; $i++) {
				?>
			<table border="0" width="100%" cellspacing="0" cellpadding="2">
				<tr>
					<td width="150" class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left">
						<?php 
							echo xtc_image(DIR_WS_ICONS . $customer_group[$i]['IMAGE'], ''); 
						?>
						<?php 
							echo '<span style="cursor:pointer" onMouseover="this.style.textDecoration=\'underline\';" onMouseout="this.style.textDecoration=\'none\';" onclick="gm_show_newsletter_recipients(\'gm_group_' . $i . '\');">' . $customer_group[$i]['NAME'] . '</span>'; 
						?>
					</td>
					<td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left">
						<?php 
							echo $customer_group[$i]['USERS'];
						?>
					</td>
				</tr>
			</table>
			<div style="display:none;" id="gm_group_<?php echo $i; ?>">
				<table border="0" width="100%" cellspacing="0" cellpadding="2">
					<tr>
						<td width="150" class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left">
							&nbsp;		
						</td>
						<td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left">
							<?php
								if((int)$customer_group[$i]['USERS'] == 0)
								{
									echo "&nbsp;";
								}
								else
								{
									echo $customer_group[$i]['USERS_INFO'];
								}
								
							?>
						</td>
					</tr>
				</table>
			</div>				
        <?php
}
?>
      </table></td>
    <td width="30%" align="right" valign="top"><?php
    echo '<a class="button" href="'.xtc_href_link(FILENAME_MODULE_NEWSLETTER,'action=new').'">'.BUTTON_NEW_NEWSLETTER.'</a>';


    ?></td>
  </tr>
</table>
 <br />
 <?php

 // get data for newsletter overwiev

 $newsletters_query=xtc_db_query("SELECT
                                   newsletter_id,date,title
                                  FROM ".TABLE_MODULE_NEWSLETTER."
                                  WHERE status='0'");
 $news_data=array();
 while ($newsletters_data=xtc_db_fetch_array($newsletters_query)) {

 $news_data[]=array(    'id' => $newsletters_data['newsletter_id'],
                        'date'=>$newsletters_data['date'],
                        'title'=>$newsletters_data['title']);
 }

?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr class="dataTableHeadingRow">
        <td class="dataTableHeadingContent" width="30" ><?php echo TITLE_DATE; ?></td>
          <td class="dataTableHeadingContent" width="80%" ><?php echo TITLE_NOT_SEND; ?></td>
          <td class="dataTableHeadingContent"  >.</td>
        </tr>
<?php
for ($i=0,$n=sizeof($news_data); $i<$n; $i++) {
if ($news_data[$i]['id']!='') {
?>
        <tr>
        <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"><?php echo $news_data[$i]['date']; ?></td>
          <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left"><a href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'ID='.$news_data[$i]['id']); ?>"><?php echo xtc_image(DIR_WS_CATALOG.'images/icons/arrow.gif'); ?></a><a href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'ID='.$news_data[$i]['id']); ?>"><b><?php echo $news_data[$i]['title']; ?></b></a></td>
          <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left">

          </td>
        </tr>
 <?php

if ($_GET['ID']!='' && $_GET['ID']==$news_data[$i]['id']) {

$total_query=xtc_db_query("SELECT
                           count(*) as count
                           FROM module_newsletter_temp_".(int)$_GET['ID']."");
$total_data=xtc_db_fetch_array($total_query);
?>
<tr>
<td class="dataTableContent_products" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"></td>
<td colspan="2" class="dataTableContent_products" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left"><?php echo TEXT_SEND_TO.$total_data['count']; ?></td>
</tr>
<td class="dataTableContent" valign="top" style="border-bottom: 1px solid; border-color: #999999;" align="left">
  <a class="button" href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'action=delete&ID='.$news_data[$i]['id']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')"><?php echo BUTTON_DELETE.'</a><br />'; ?>
  <a class="button" href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'action=edit&ID='.$news_data[$i]['id']); ?>"><?php echo BUTTON_EDIT.'</a>'; ?>
  <br /><br /><div style="height: 1px; background: Black; margin: 3px 0;"></div>
  <a class="button" href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'action=send&ID='.$news_data[$i]['id']); ?>"><?php echo BUTTON_SEND.'</a>'; ?>

</td>
<td colspan="2" class="dataTableContent" style="border-bottom: 1px solid; border-color: #999999; text-align: left;">
<?php

 // get data
    $newsletters_query=xtc_db_query("SELECT
                                   title,body,cc,bc
                                  FROM ".TABLE_MODULE_NEWSLETTER."
                                  WHERE newsletter_id='".(int)$_GET['ID']."'");
   $newsletters_data=xtc_db_fetch_array($newsletters_query);

echo TEXT_TITLE.$newsletters_data['title'].'<br />';

     $customers_status=xtc_get_customers_statuses();
		 // BOF GM_MOD:
		 sort($customers_status);
     for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {

     $newsletters_data['bc']=str_replace($customers_status[$i]['id'],$customers_status[$i]['text'],$newsletters_data['bc']);

     }

echo TEXT_TO.$newsletters_data['bc'].'<br />';
echo TEXT_CC.$newsletters_data['cc'].'<br /><br />'.TEXT_PREVIEW;
echo '<table style="border-color: #cccccc; border: 1px solid;" width="100%"><tr><td>'.$newsletters_data['body'].'</td></tr></table>';
?>
</td></tr>
<?php
}
?>

<?php
}
}


?>
</table>
<br /><br />
<?php
 $newsletters_query=xtc_db_query("SELECT
                                   newsletter_id,date,title
                                  FROM ".TABLE_MODULE_NEWSLETTER."
                                  WHERE status='1'");
 $news_data=array();
 while ($newsletters_data=xtc_db_fetch_array($newsletters_query)) {

 $news_data[]=array(    'id' => $newsletters_data['newsletter_id'],
                        'date'=>$newsletters_data['date'],
                        'title'=>$newsletters_data['title']);
 }

?>
<table border="0" width="100%" cellspacing="0" cellpadding="2">
        <tr class="dataTableHeadingRow">
          <td class="dataTableHeadingContent" width="80%" ><?php echo TITLE_SEND; ?></td>
          <td class="dataTableHeadingContent"><?php echo TITLE_ACTION; ?></td>
        </tr>
<?php
for ($i=0,$n=sizeof($news_data); $i<$n; $i++) {
if ($news_data[$i]['id']!='') {
?>
        <tr>
          <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" valign="middle" align="left"><?php echo $news_data[$i]['date'].'    '; ?><b><?php echo $news_data[$i]['title']; ?></b></td>
          <td class="dataTableContent" style="border-bottom: 1px solid; border-color: #f1f1f1;" align="left">

  <a href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'action=delete&ID='.$news_data[$i]['id']); ?>" onClick="return confirm('<?php echo CONFIRM_DELETE; ?>')">
  <?php
  echo xtc_image(DIR_WS_ICONS.'delete.gif','Delete','','','style="cursor:hand" onClick="return confirm(\''.DELETE_ENTRY.'\')"').'  '.TEXT_DELETE.'</a>&nbsp;&nbsp;';
  ?>
<a href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER,'action=edit&ID='.$news_data[$i]['id']); ?>">
<?php echo xtc_image(DIR_WS_ICONS.'icon_edit.gif','Edit','','').'  '.TEXT_EDIT.'</a>'; ?>





          </td>
        </tr>
<?php
}
}


?>
</table>

<?php


  break;       // end default page

  case 'edit':

   $newsletters_query=xtc_db_query("SELECT title,body,cc,bc FROM ".TABLE_MODULE_NEWSLETTER." WHERE newsletter_id='".(int)$_GET['ID']."'");
   $newsletters_data=xtc_db_fetch_array($newsletters_query);

  case 'safe':
  case 'new':  // action for NEW newsletter!

$customers_status=xtc_get_customers_statuses();
// BOF GM_MOD:
sort($customers_status);

  echo xtc_draw_form('edit_newsletter',FILENAME_MODULE_NEWSLETTER,'action=save','post','enctype="multipart/form-data"').xtc_draw_hidden_field('ID',$_GET['ID']);
	?>

 <table class="main gm_border dataTableRow" width="100%" border="0">
   </tr>
      <tr>
      <td width="10%"><?php echo TEXT_TITLE; ?></td>
      <td width="90%"><?php echo xtc_draw_input_field('title',$newsletters_data['title'],'size=100'); ?></td>
   </tr>
   <tr>
      <td width="10%"><?php echo TEXT_TO; ?></td>
      <td width="90%"><?php
for ($i=0,$n=sizeof($customers_status);$i<$n; $i++) {

     $group_query=xtc_db_query("SELECT count(*) as count
                                FROM ".TABLE_NEWSLETTER_RECIPIENTS."
                                WHERE mail_status='1' and
                                customers_status='".$customers_status[$i]['id']."'");
     $group_data=xtc_db_fetch_array($group_query);

     $group_query=xtc_db_query("SELECT count(*) as count
                                FROM ".TABLE_CUSTOMERS."
                                WHERE
                                customers_status='".$customers_status[$i]['id']."'");
     $group_data_all=xtc_db_fetch_array($group_query);

     $bc_array = explode(',', $newsletters_data['bc']);

echo xtc_draw_checkbox_field('status['.$i.']','yes', in_array($customers_status[$i]['id'], $bc_array)).' '.$customers_status[$i]['text'].'  <i>(<b>'.$group_data['count'].'</b>'.TEXT_USERS.$group_data_all['count'].TEXT_CUSTOMERS.'<br />';

}
echo xtc_draw_checkbox_field('status_all', 'yes',in_array('all', $bc_array)).' <b>'.TEXT_NEWSLETTER_ONLY.'</b>';

       ?></td>
   </tr>
         <tr>
      <td width="10%"><?php echo TEXT_CC; ?></td>
      <td width="90%"><?php

       echo xtc_draw_input_field('cc',$newsletters_data['cc'],'size=100'); ?></td>
   </tr>
      </tr>
      <tr>
      <td width="10%" valign="top"><?php echo TEXT_BODY; ?></td>
      <td width="90%">
				<?php
					if(USE_WYSIWYG == 'true'){
					$oFCKeditor = new FCKeditor('newsletter_body');
					$oFCKeditor->BasePath	= DIR_WS_ADMIN . 'gm/fckeditor/';
					$oFCKeditor->Height = 400;
					$oFCKeditor->Value = stripslashes($newsletters_data['body']);
					$oFCKeditor->ToolbarSet = "Content";
					$oFCKeditor->Config["CustomConfigurationsPath"] = DIR_WS_ADMIN . "gm/fckeditor/gm_config.js";
					$oFCKeditor->Config["DefaultLanguage"] = $_SESSION['language_code'];
					$oFCKeditor->Create();
				}
				else{
					echo xtc_draw_textarea_field('newsletter_body', 'soft', '110', '45', stripslashes($newsletters_data['body']));
				}
				?>
				<br />
				<a class="button float_left" onClick="this.blur();" href="<?php echo xtc_href_link(FILENAME_MODULE_NEWSLETTER); ?>"><?php echo BUTTON_BACK; ?></a>
				<?php echo '<input type="submit" class="button float_left" onClick="this.blur();" value="' . BUTTON_SAVE . '"/>'; ?>
			</td>
   </tr>
   </table>
  </form>
  <?php

  break;
} // end switch
?>


</td>

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
</body>
</html>
<?php require(DIR_WS_INCLUDES . 'application_bottom.php'); ?>