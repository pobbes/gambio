<?php /* Smarty version 2.6.26, created on 2013-05-15 12:04:22
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/module/login.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/module/login.html', 1, false),array('function', 'page_url', 'C:/xampp/htdocs/gambio/templates/sh-webshop/module/login.html', 48, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'login'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>


<div class="login" id="account">
	<h1><?php echo $this->_tpl_vars['txt']['heading_login']; ?>
</h1>
	<?php if ($this->_tpl_vars['info_message'] != ''): ?>
		<?php echo $this->_tpl_vars['info_message']; ?>

		<br />
		<br />
	<?php endif; ?>
	<div class="cols3">
		<?php if ($this->_tpl_vars['account_option'] == 'account' || $this->_tpl_vars['account_option'] == 'both'): ?>
		<div class="col first h300">
			<div class="col-inside">
				<div class="h200">
					<h3><?php echo $this->_tpl_vars['txt']['title_new']; ?>
</h3>

					<p><?php echo $this->_tpl_vars['txt']['text_new']; ?>
</p>
				</div>
				<div class="button-container"><a href="<?php echo $this->_tpl_vars['NEW_ACCOUNT_URL']; ?>
" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $this->_tpl_vars['button']['register']; ?>
</span></span></a></div>
			</div>
		</div>
		<?php endif; ?>
		<?php if ($this->_tpl_vars['account_option'] == 'guest' || $this->_tpl_vars['account_option'] == 'both'): ?>
		<div class="col h300">
			<div class="col-inside">
				<div class="h200">

					<h3><?php echo $this->_tpl_vars['txt']['title_guest']; ?>
</h3>
					<p><?php echo $this->_tpl_vars['txt']['text_guest']; ?>
</p>
				</div>
				<div class="button-container"><a href="<?php echo $this->_tpl_vars['GUEST_URL']; ?>
" class="button_blue button_set"><span class="button-outer"><span class="button-inner"><?php echo $this->_tpl_vars['button']['buy_as_guest']; ?>
</span></span></a></div>
			</div>
		</div>
		<?php endif; ?>
		<div class="col last h300">
			<div class="col-inside">
				<form id="<?php echo $this->_tpl_vars['FORM_ID']; ?>
" action="<?php echo $this->_tpl_vars['FORM_ACTION_URL']; ?>
" method="post">
					<div class="h200">
						<h3><?php echo $this->_tpl_vars['txt']['title_returning']; ?>
</h3>
						<label><?php echo $this->_tpl_vars['txt']['text_email']; ?>
</label><br />
						<input type="text" class="input-text" name="<?php echo $this->_tpl_vars['INPUT_MAIL_NAME']; ?>
" value="<?php echo $this->_tpl_vars['INPUT_MAIL_VALUE']; ?>
" /><br />

						<label><?php echo $this->_tpl_vars['txt']['text_password']; ?>
</label><br />
						<input type="password" class="input-text" name="<?php echo $this->_tpl_vars['INPUT_PASSWORD_NAME']; ?>
" />
						<p><a href="<?php echo $this->_tpl_vars['LINK_LOST_PASSWORD']; ?>
"><?php echo $this->_tpl_vars['txt']['text_lost_password']; ?>
</a></p>
					</div>
					<div class="button-container"><a href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="button_blue button_set action_submit"><span class="button-outer"><span class="button-inner"><?php echo $this->_tpl_vars['button']['login']; ?>
</span></span></a></div>
				</form>
			</div>
		</div>
	</div>

</div>