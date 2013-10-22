<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:06
         compiled from C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_magnalister.xml */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_magnalister.xml', 4, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<!-- <?php echo smarty_function_load_language_text(array('section' => 'admin_menu'), $this);?>
 -->

<admin_menu>
	<menugroup id="BOX_HEADING_MAGNALISTER" sort="60" background="../../includes/magnalister/images/magnalister_gambio_icon.png" title="Marketing">
		<?php 
		if (function_exists('magnaExecute'))
			$this->assign("__ml_found", magnaExecute(
				'magnaGenerateSideNav', array ('out' => 'xml'), array(),
				MAGNA_WITHOUT_DB_INSTALL | MAGNA_WITHOUT_AUTH | MAGNA_WITHOUT_ACTIVATION
			));
		 ?>
		<?php if (isset ( $this->_tpl_vars['__ml_found'] ) && ! empty ( $this->_tpl_vars['__ml_found'] )): ?>
		<?php echo $this->_tpl_vars['__ml_found']; ?>

		<?php else: ?>
		<menuitem link="FILENAME_MAGNALISTER" title="magnalister Admin" />
		<?php endif; ?>
	</menugroup>
</admin_menu>