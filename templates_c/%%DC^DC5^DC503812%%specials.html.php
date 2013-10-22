<?php /* Smarty version 2.6.26, created on 2013-05-15 12:04:43
         compiled from sh-webshop/module/specials.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/module/specials.html', 1, false),array('function', 'object_product_list', 'sh-webshop/module/specials.html', 10, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'specials'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'product_listing','name' => 'product'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'index','name' => 'index'), $this);?>


<div id="specials">
	<h1><?php echo $this->_tpl_vars['txt']['heading_text']; ?>
</h1>
	
	<div class="site_navigation"><?php echo $this->_tpl_vars['NAVBAR']; ?>
</div>
	<br /><br />
	<?php echo smarty_function_object_product_list(array('product_list' => $this->_tpl_vars['module_content'],'id_prefix' => 'specials','truncate_products_name' => $this->_tpl_vars['TRUNCATE_PRODUCTS_NAME']), $this);?>

	<div>
		<div class="panel-pagination-info"><?php echo $this->_tpl_vars['NAVIGATION_INFO']; ?>
</div>
		<div class="site_navigation"><?php echo $this->_tpl_vars['NAVBAR']; ?>
</div>
	</div>
</div>

