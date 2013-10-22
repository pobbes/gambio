<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from sh-webshop/module/products_new_main.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/module/products_new_main.html', 1, false),array('function', 'object_product_list', 'sh-webshop/module/products_new_main.html', 3, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'index'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'new_products','name' => 'product'), $this);?>
<?php if ($this->_tpl_vars['module_content'] != ''): ?>	
                        <div class="module_heading_2"><span><?php echo $this->_tpl_vars['product']['heading_text']; ?>
</span></div>
	<?php echo smarty_function_object_product_list(array('product_list' => $this->_tpl_vars['module_content'],'id_prefix' => 'new_products','truncate_products_name' => $this->_tpl_vars['TRUNCATE_PRODUCTS_NAME']), $this);?>

<?php endif; ?>