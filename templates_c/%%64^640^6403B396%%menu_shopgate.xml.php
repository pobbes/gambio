<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:06
         compiled from C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_shopgate.xml */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/system/conf/AdminMenu/menu_shopgate.xml', 4, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<!-- <?php echo smarty_function_load_language_text(array('section' => 'shopgate'), $this);?>
 -->

<?php 
if(strpos(MODULE_PAYMENT_INSTALLED, 'shopgate.php') !== false) {
	define(ACTIVATE_SHOPGATE, 'true');
} else {
	define(ACTIVATE_SHOPGATE, 'false');
}
 ?>
<?php if (ACTIVATE_SHOPGATE == 'true'): ?>
<admin_menu>
    <menugroup id="BOX_HEADING_SHOPGATE" sort="90" background="module.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_SHOPGATE']; ?>
">
		<menuitem link="FILENAME_SHOPGATE" link_param="sg_option=info" sort="1" title="<?php echo $this->_tpl_vars['txt']['BOX_SHOPGATE_INFO']; ?>
" />
		<menuitem link="FILENAME_SHOPGATE" link_param="sg_option=help" sort="2" title="<?php echo $this->_tpl_vars['txt']['BOX_SHOPGATE_HELP']; ?>
" />
		<menuitem link="FILENAME_SHOPGATE" link_param="sg_option=register" sort="3" title="<?php echo $this->_tpl_vars['txt']['BOX_SHOPGATE_REGISTER']; ?>
" />
		<menuitem link="FILENAME_SHOPGATE" link_param="sg_option=config" sort="4" title="<?php echo $this->_tpl_vars['txt']['BOX_SHOPGATE_CONFIG']; ?>
" />
		<menuitem link="FILENAME_SHOPGATE" link_param="sg_option=merchant" sort="7" title="<?php echo $this->_tpl_vars['txt']['BOX_SHOPGATE_MERCHANT']; ?>
" />
	</menugroup>
</admin_menu>
<?php endif; ?>