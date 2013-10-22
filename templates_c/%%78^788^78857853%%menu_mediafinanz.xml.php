<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:06
         compiled from C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_mediafinanz.xml */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_mediafinanz.xml', 4, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<!-- <?php echo smarty_function_load_language_text(array('section' => 'admin_menu'), $this);?>
 -->
<admin_menu>
	<menugroup id="BOX_HEADING_MODULES">
		<menuitem sort="54" link="mediafinanz.php" link_param="action=config" title="mediafinanz Konfiguration" />
		<menuitem sort="55" link="mediafinanz.php" link_param="action=errors" title="mediafinanz Fehler" />
		<menuitem sort="56" link="mediafinanz.php" link_param="action=claims" title="mediafinanz Forderungen" />
	</menugroup>
</admin_menu>