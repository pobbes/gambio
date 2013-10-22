<?php
/* --------------------------------------------------------------
   login_admin.php 2012-02-03 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/

if(isset($_GET['repair'] )) {
	$action = 'login_admin.php';
} else {
	$action = 'login.php?action=process';
}

if(isset($_POST['repair'] )) {
	if (file_exists('includes/local/configure.php')) {
		require('includes/local/configure.php');
	} else {
		require('includes/configure.php');
	}
	include_once(DIR_FS_INC.'xtc_db_connect.inc.php');
	include_once(DIR_FS_INC.'xtc_db_query.inc.php');
	include_once(DIR_FS_INC.'xtc_db_input.inc.php');
	include_once(DIR_FS_INC.'xtc_db_fetch_array.inc.php');
	include_once(DIR_FS_CATALOG.'gm/classes/FileLog.php');
	include_once(DIR_FS_CATALOG.'gm/classes/ErrorHandler.php');
	include_once(DIR_FS_CATALOG.'system/gngp_layer_init.inc.php');
	include_once(DIR_FS_CATALOG.'system/controls/CacheControl.inc.php');
	
	set_error_handler(array(new ErrorHandler(), 'HandleError'));
	
	xtc_db_connect() or die('Unable to connect to database server!');
	
	$result = mysql_query('
		SELECT customers_password
		FROM customers
		WHERE
			customers_email_address = "'. xtc_db_input($_POST['email_address']) .'" AND
			customers_status = 0
	');
	$t_data = xtc_db_fetch_array($result);

	if($t_data['customers_password'] == md5($_POST['password']))
	{
		switch($_POST['repair']) {
			case 'clear_data_cache':
				$coo_cache_control = new CacheControl();
				$coo_cache_control->clear_data_cache();
				$coo_cache_control->clear_content_view_cache();
				$coo_cache_control->clear_templates_c();
				$coo_cache_control->clear_css_cache();
				die('Report: Der Modul- und Seitenausgabecache wurde geleert.');
				break;

			case 'se_friendly':
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "false"
					WHERE	configuration_key 	= "SEARCH_ENGINE_FRIENDLY_URLS"
				');
				echo '<p>'.mysql_error().'</p>';
				die('Report: Die Einstellung "Suchmaschinenfreundliche URLs verwenden" wurde deaktiviert.');
				break;

			case 'seo_boost':
				mysql_query('
					UPDATE gm_configuration
					SET		gm_value 	= "false"
					WHERE	gm_key 		= "GM_SEO_BOOST_PRODUCTS"
				');
				echo '<p>'.mysql_error().'</p>';
				mysql_query('
					UPDATE gm_configuration
					SET		gm_value 	= "false"
					WHERE	gm_key 		= "GM_SEO_BOOST_CATEGORIES"
				');
				echo '<p>'.mysql_error().'</p>';
				mysql_query('
					UPDATE gm_configuration
					SET		gm_value 	= "false"
					WHERE	gm_key 		= "GM_SEO_BOOST_CONTENT"
				');
				echo '<p>'.mysql_error().'</p>';
				die('Report: Der SEO Boost wurde deaktiviert.');
				break;

			case 'sess_write':
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "'.DIR_FS_CATALOG.'cache"
					WHERE	configuration_key 	= "SESSION_WRITE_DIRECTORY"
				');
				echo '<p>'.mysql_error().'</p>';
				die('Report: SESSION_WRITE_DIRECTORY wurde auf das Cache-Verzeichnis gerichtet.');
				break;

			case 'sess_default':
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "False"
					WHERE	configuration_key 	= "SESSION_FORCE_COOKIE_USE"
				');
				echo '<p>'.mysql_error().'</p>';
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "False"
					WHERE	configuration_key 	= "SESSION_CHECK_SSL_SESSION_ID"
				');
				echo '<p>'.mysql_error().'</p>';
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "False"
					WHERE	configuration_key 	= "SESSION_CHECK_USER_AGENT"
				');
				echo '<p>'.mysql_error().'</p>';
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "False"
					WHERE	configuration_key 	= "SESSION_CHECK_IP_ADDRESS"
				');
				echo '<p>'.mysql_error().'</p>';
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "False"
					WHERE	configuration_key 	= "SESSION_RECREATE"
				');
				echo '<p>'.mysql_error().'</p>';
				die('Report: Die Session-Einstellungen wurden auf die Standardwerte zur�ckgesetzt.');
				break;
			
			case 'gzip_off':
				mysql_query('
					UPDATE configuration
					SET		configuration_value = "false"
					WHERE	configuration_key 	= "GZIP_COMPRESSION"
				');
				echo '<p>'.mysql_error().'</p>';
				die('Report: Die GZip-Kompression wurde deaktiviert.');
				break;
			
			default:
				die('Report: repair-Befehl ung�ltig.');
		}
	}
	else {
		die('Zugriff verweigert.');
	}
	
	mysql_close();
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Administrations - Login</title>
	<style type="text/css">
		body{background-color: #ffffff; margin:0 auto; padding:0; text-align: center;}
		#wrapper{width: 325px; height:420px; margin: 150px auto;}
		#loginbox{background: url('images/login_admin/login_background.jpg'); background-repeat: no-repeat; width:325px; height: 330px; padding: 50px 30px 30px 30px; text-align: left;}
		h1{margin-bottom:5px; font-family: Arial, Tahoma, sans-serif; font-size: 18px; color: #124368; }
		input{background: #9CCDE8; border: 1px solid #194E77; font-size: 13px; height: 30px; width: 250px; padding: 3px;}
		label{color:#ffffff; font-family: Arial, Tahoma, sans-serif; font-size: 13px; font-weight: bold; display: block; margin-bottom: 3px;}
		div.input{margin-bottom: 15px;}
		#submit_button{background: url('images/login_admin/submit.png'); width:82px; height: 24px; color: #ffffff; font-size: 12px; padding: 3px; border: 0; }
		div#submit{position: relative; float: right; margin-right: 76px;}
		* html div#submit{margin-right: 8px;}
	</style>
</head>
<body>

<form name="login" method="post" action="<?php echo $action ?>">
<div id="wrapper">
	<h1>Administrations - Login</h1>

	<div id="loginbox">
		<div class="input">
			<label>Email</label>
			<input type="text" name="email_address" value="">
		</div>

		<div class="input">
			<label>Passwort</label>
			<input type="password" name="password" value="">
		</div>

		<div id="submit"><input id="submit_button" type="submit" value="Login"></div>
	</div>
</div>

<input type="hidden" name="repair" value="<?php echo htmlspecialchars($_GET['repair']) ?>">
</form>

</body>
</html>