<?php
/* --------------------------------------------------------------
   xtc_php_mail.inc.php 2013-02-25 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2013 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on:
   (c) 2003	 nextcommerce (xtc_php_mail.inc.php,v 1.17 2003/08/24); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: xtc_php_mail.inc.php 1129 2005-08-05 11:46:11Z mz $)


   Released under the GNU General Public License
   ---------------------------------------------------------------------------------------*/

include_once(DIR_FS_INC . 'prepare_mail_content.inc.php');
// include the mail classes
function xtc_php_mail($from_email_address, $from_email_name, $to_email_address, $to_name, $forwarding_to, $reply_address, $reply_address_name, $path_to_attachement, $path_to_more_attachements, $email_subject, $message_body_html, $message_body_plain) {
	global $mail_error;

	$mail = new PHPMailer();
	$mail->PluginDir = DIR_FS_DOCUMENT_ROOT.'includes/classes/';

	if (isset ($_SESSION['language_charset'])) {
		$mail->CharSet = $_SESSION['language_charset'];
	} else {
		$lang_query = "SELECT * FROM ".TABLE_LANGUAGES." WHERE code = '".DEFAULT_LANGUAGE."'";
		$lang_query = xtc_db_query($lang_query);
		$lang_data = xtc_db_fetch_array($lang_query);
		$mail->CharSet = $lang_data['language_charset'];
	}
	if ($_SESSION['language'] == 'german') {
		$mail->SetLanguage("de", DIR_WS_CLASSES);
	} else {
		$mail->SetLanguage("en", DIR_WS_CLASSES);
	}
	if (EMAIL_TRANSPORT == 'smtp') {
		$mail->IsSMTP();
		$mail->SMTPKeepAlive = true; // set mailer to use SMTP
		$mail->SMTPAuth = SMTP_AUTH; // turn on SMTP authentication true/false
		$mail->Username = SMTP_USERNAME; // SMTP username
		$mail->Password = SMTP_PASSWORD; // SMTP password
		$mail->Host = SMTP_MAIN_SERVER.';'.SMTP_Backup_Server; // specify main and backup server "smtp1.example.com;smtp2.example.com"
	}

	if (EMAIL_TRANSPORT == 'sendmail') { // set mailer to use SMTP
		$mail->IsSendmail();
		$mail->Sendmail = SENDMAIL_PATH;
	}
	if (EMAIL_TRANSPORT == 'mail') {
		$mail->IsMail();
	}

	$message_body_html = prepare_mail_content($message_body_html);
	//remove html tags
	$message_body_plain = str_replace('<br>', "<br/>", $message_body_plain);
	$message_body_plain = str_replace('<br/>', " \n", $message_body_plain);
	$message_body_plain = strip_tags($message_body_plain);
	$message_body_plain = prepare_mail_content($message_body_plain);
	
	if (EMAIL_USE_HTML == 'true') // set email format to HTML
		{
		$mail->IsHTML(true);
		$mail->Body = $message_body_html;
		$mail->AltBody = $message_body_plain;
	} else {
		$mail->IsHTML(false);
		$mail->Body = $message_body_plain;
	}

	$mail->From = $from_email_address;
	$mail->Sender = $from_email_address;
	$mail->FromName = $from_email_name;
	$mail->AddAddress($to_email_address, $to_name);
	if ($forwarding_to != '')
		$mail->AddBCC($forwarding_to);
	$mail->AddReplyTo($reply_address, $reply_address_name);

	// BOF GM_MOD:
	$mail->WordWrap = 76; // set word wrap to 50 characters
	$mail->AddAttachment($path_to_attachement);                     // add attachments
	//$mail->AddAttachment($path_to_more_attachements);               // optional name

	$mail->Subject = $email_subject;

	if (!$mail->Send()) {
		return false;
	} else {
		return true;
	}

}
?>