<?php /* Smarty version 2.6.26, created on 2013-06-13 21:27:41
         compiled from sh-webshop/module/error_message.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/module/error_message.html', 1, false),array('function', 'page_url', 'sh-webshop/module/error_message.html', 12, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'advanced_search'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>


<div id="advanced_search">

	<h1><?php echo $this->_tpl_vars['txt']['text_search_again']; ?>
</h1>

	<?php echo $this->_tpl_vars['FORM_ACTION']; ?>

	<p><?php echo $this->_tpl_vars['txt']['text_search_heading']; ?>
</p>
	<p>
		<input type="text" name="<?php echo $this->_tpl_vars['INPUT_SEARCH_NAME']; ?>
" value="" class="input-text" />
		<a href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="button_blue button_set action_submit"><span class="button-outer"><span class="button-inner"><?php echo $this->_tpl_vars['button']['search']; ?>
</span></span></a>
	</p>
	<?php echo $this->_tpl_vars['FORM_END']; ?>

</div>