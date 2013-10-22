<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from sh-webshop/module/specials_main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/module/specials_main.html', 1, false),array('function', 'object_product_list', 'sh-webshop/module/specials_main.html', 3, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'specials'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'index','name' => 'index'), $this);?>
<?php if ($this->_tpl_vars['module_content'] != ''): ?>	
                        <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_text']; ?>
</span></div>
	<?php echo smarty_function_object_product_list(array('product_list' => $this->_tpl_vars['module_content'],'id_prefix' => 'specials','truncate_products_name' => $this->_tpl_vars['TRUNCATE_PRODUCTS_NAME']), $this);?>

<?php endif; ?>
