<?php /* Smarty version 2.6.26, created on 2013-05-15 12:04:16
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_login_dropdown.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_login_dropdown.html', 1, false),array('function', 'page_url', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_login_dropdown.html', 29, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'box_login_dropdown'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>


<!-- start: box_login_dropdown -->

<div id="customer_login" style="display: none;">
    
	<div class="customer_login_container png-fix">
        
		<div class="customer_login_inside">
            
			<form action="<?php echo $this->_tpl_vars['content_data']['FORM_ACTION_URL']; ?>
" method="<?php echo $this->_tpl_vars['content_data']['FORM_METHOD']; ?>
">
                
				<label class="control-label" for="email"><?php echo $this->_tpl_vars['txt']['text_email']; ?>
</label>
                <div class="control_group">                    
                    <div class="controls">
				        <input id="email" type="text" name="<?php echo $this->_tpl_vars['content_data']['FIELD_EMAIL_NAME']; ?>
" value="" class="input-text-login" placeholder="<?php echo $this->_tpl_vars['txt']['text_email']; ?>
" />
                    </div>
                </div>
                
                <label class="control-label" for="password"><?php echo $this->_tpl_vars['txt']['text_pwd']; ?>
</label>
                <div class="control_group">                 
                    <div class="controls">
				        <input id="password" type="password" name="<?php echo $this->_tpl_vars['content_data']['FIELD_PWD_NAME']; ?>
" value="" class="input-text-login" placeholder="<?php echo $this->_tpl_vars['txt']['text_pwd']; ?>
" />
                    </div>
                </div>
                    
				<div class="submit-container">
                    <a href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="button_blue button_set action_submit">
                        <span class="button-outer">
                            <span class="button-inner"><?php echo $this->_tpl_vars['button']['login']; ?>
</span>
                        </span>
                    </a>
                </div>
                
				<div class="customer_login_links">
                    
					<a href="<?php echo $this->_tpl_vars['content_data']['LINK_CREATE_ACCOUNT']; ?>
">
						<?php echo $this->_tpl_vars['txt']['text_create_account']; ?>

					</a>
                    <br />
					<a href="<?php echo $this->_tpl_vars['content_data']['LINK_LOST_PASSWORD']; ?>
">
						<?php echo $this->_tpl_vars['txt']['text_password_forgotten']; ?>

					</a>
                    
				</div>
                
			</form>
            
		</div>
        
	</div>
    
</div>

<!-- end: box_login_dropdown -->