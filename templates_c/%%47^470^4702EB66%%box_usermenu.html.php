<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_usermenu.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_usermenu.html', 1, false),array('function', 'page_url', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_usermenu.html', 11, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'top_navigation'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'infobox','name' => 'infobox'), $this);?>

                <!-- start: user_menu -->
                <div id="usermenu_container">

                    <span id="wishlist" class="left"><?php if ($this->_tpl_vars['content_data']['WISHLIST_URL']): ?> 
                        <a href="<?php echo $this->_tpl_vars['content_data']['WISHLIST_URL']; ?>
" title="<?php echo $this->_tpl_vars['txt']['title_wish_list']; ?>
" class="usermenu-wishlist"><?php echo $this->_tpl_vars['txt']['button_wish_list']; ?>
</a><?php endif; ?>  
                    </span>
                        
                    <span id="login_register" class="right"><?php if (! $this->_tpl_vars['content_data']['ACCOUNT_URL']): ?>
                            
                        <a title="<?php echo $this->_tpl_vars['txt']['title_login']; ?>
" href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="pulldown_link usermenu-login" id="customer_login_link" rel="#customer_login"><?php echo $this->_tpl_vars['txt']['button_login']; ?>
</a><?php else: ?>
                            
                        <a title="<?php echo $this->_tpl_vars['txt']['title_logoff']; ?>
" href="<?php echo $this->_tpl_vars['content_data']['LOGOFF_URL']; ?>
" class="usermenu-login usermenu-active"><?php echo $this->_tpl_vars['txt']['button_logoff']; ?>
</a><?php endif; ?>
                            
                    </span>