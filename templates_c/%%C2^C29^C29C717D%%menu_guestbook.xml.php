<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:06
         compiled from C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_guestbook.xml */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_guestbook.xml', 4, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<!-- <?php echo smarty_function_load_language_text(array('section' => 'admin_menu'), $this);?>
 -->

<?php if (file_exists ( 'gm_guestbook.php' )): ?>
<admin_menu>
	<menugroup id="BOX_HEADING_MODULES">
		<menuitem sort="30" link="FILENAME_GM_GUESTBOOK" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_GUESTBOOK']; ?>
" />
	</menugroup>
</admin_menu>
<?php endif; ?>