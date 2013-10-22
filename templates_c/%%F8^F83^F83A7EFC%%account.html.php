<?php /* Smarty version 2.6.26, created on 2013-06-13 18:45:27
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/module/account.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/module/account.html', 1, false),array('function', 'object_product_list', 'C:/xampp/htdocs/gambio/templates/sh-webshop/module/account.html', 85, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'account'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'downloads','name' => 'downloads'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>


<div class="user_home" id="account">
	<h1><?php echo $this->_tpl_vars['txt']['heading_account']; ?>
</h1>

	<div class="class_error">
		<?php echo $this->_tpl_vars['error_message']; ?>

	</div>

		<p><?php echo $this->_tpl_vars['txt']['text_welcome']; ?>
</p>
	<div class="cols3">
		<div class="col first">

			<div class="col-inside">
				<h3><?php echo $this->_tpl_vars['txt']['title_account']; ?>
</h3>
				<ul class="arrows">
					<li><a href="<?php echo $this->_tpl_vars['LINK_EDIT']; ?>
"><?php echo $this->_tpl_vars['txt']['text_edit']; ?>
</a></li>
					<li><a href="<?php echo $this->_tpl_vars['LINK_ADDRESS']; ?>
"><?php echo $this->_tpl_vars['txt']['text_address']; ?>
</a></li>
					<?php if ($this->_tpl_vars['NO_GUEST'] == 1): ?>
					<li><a href="<?php echo $this->_tpl_vars['LINK_PASSWORD']; ?>
"><?php echo $this->_tpl_vars['txt']['text_password']; ?>
</a></li>
					<li><a href="<?php echo $this->_tpl_vars['LINK_DELETE_ACCOUNT']; ?>
"><?php echo $this->_tpl_vars['txt']['text_delete_account']; ?>
</a></li>
					<?php endif; ?>					
					<?php if ($this->_tpl_vars['CUSTOMER_UPLOAD'] == 1): ?>
					<li><a href="<?php echo $this->_tpl_vars['LINK_CUSTOMER_UPLOAD']; ?>
"><?php echo $this->_tpl_vars['txt']['text_customer_upload']; ?>
</a></li>
					<?php endif; ?>
				</ul>
			</div>
		</div>

		<?php if ($this->_tpl_vars['order_content']): ?>
		<div class="col">
			<div class="col-inside">
				<h3><?php echo $this->_tpl_vars['txt']['title_orders']; ?>
</h3>
				<a class="account_link" href="<?php echo $this->_tpl_vars['LINK_ALL']; ?>
"><?php echo $this->_tpl_vars['txt']['text_all']; ?>
</a><br /><br />
				<?php $_from = $this->_tpl_vars['order_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['order_data']):
        $this->_foreach['aussen']['iteration']++;
?>
					<div class="order clearfix">
						<a class="account_link" href="<?php echo $this->_tpl_vars['order_data']['ORDER_LINK']; ?>
"><?php echo $this->_tpl_vars['order_data']['ORDER_DATE']; ?>
</a><br />

						<?php echo $this->_tpl_vars['txt']['order_nr']; ?>
<?php echo $this->_tpl_vars['order_data']['ORDER_ID']; ?>
<br />
						<?php echo $this->_tpl_vars['txt']['order_total']; ?>
<?php echo $this->_tpl_vars['order_data']['ORDER_TOTAL']; ?>
<br />
						<?php echo $this->_tpl_vars['txt']['order_status']; ?>
 <span class="price"><?php echo $this->_tpl_vars['order_data']['ORDER_STATUS']; ?>
</span>
						
						<?php if ($this->_tpl_vars['order_data']['downloads_data']): ?>
						<div class="product-documents clearfix">
							<dl class="clearfix">
							<?php $_from = $this->_tpl_vars['order_data']['downloads_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['innen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['innen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['download_data']):
        $this->_foreach['innen']['iteration']++;
?>
								<dd>
									<a href="<?php echo $this->_tpl_vars['order_data']['ORDER_BUTTON_LINK']; ?>
"><?php echo $this->_tpl_vars['download_data']['PRODUCTS_NAME']; ?>
</a><br /><?php echo $this->_tpl_vars['downloads']['text_download_count']; ?>
 <?php echo $this->_tpl_vars['download_data']['COUNT']; ?>
 <?php echo $this->_tpl_vars['downloads']['text_download_date']; ?>
 <?php echo $this->_tpl_vars['download_data']['DATE_SHORT']; ?>

                                    <?php if ($this->_tpl_vars['download_data']['LINK'] != '' && $this->_tpl_vars['download_data']['COUNT'] > 0): ?>
                                        <div class="show_download_button"><a href="<?php echo $this->_tpl_vars['download_data']['LINK']; ?>
" class="button_green button_set" target="_blank"><span class="button-outer"><span class="button-inner"><?php echo $this->_tpl_vars['button']['download']; ?>
</span></span></a></div>
                                    <?php endif; ?>
								</dd>
							<?php endforeach; endif; unset($_from); ?>
							</dl>
						</div>
						<?php endif; ?>
						
						<div style="clear:both"></div>
						<div class="show_order_button"><a href="<?php echo $this->_tpl_vars['order_data']['ORDER_BUTTON_LINK']; ?>
" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $this->_tpl_vars['button']['show']; ?>
</span></span></a></div>

					</div>							
				<?php endforeach; endif; unset($_from); ?>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['LINK_NEWSLETTER']): ?>
		<div class="col last">
			<div class="col-inside">
				<h3><?php echo $this->_tpl_vars['txt']['title_notification']; ?>
</h3>
				<p><a class="account_link" href="<?php echo $this->_tpl_vars['LINK_NEWSLETTER']; ?>
"><?php echo $this->_tpl_vars['txt']['text_newsletter']; ?>
</a></p>
			</div>
		</div>
		<?php endif; ?>
	</div>
	<div class="clearfix"></div>
	<div style="clear:both"></div>

	<?php if ($this->_tpl_vars['products_history']): ?>
		<br />
		<br />
		<div class="headline"><?php echo $this->_tpl_vars['txt']['title_viewed_products']; ?>
</div><br />
		<?php echo smarty_function_object_product_list(array('product_list' => $this->_tpl_vars['products_history'],'id_prefix' => 'products_history','truncate_products_name' => $this->_tpl_vars['TRUNCATE_PRODUCTS_NAME']), $this);?>

			<?php endif; ?>

</div>