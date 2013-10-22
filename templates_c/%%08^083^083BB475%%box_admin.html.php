<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_admin.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_admin.html', 2, false),)), $this); ?>
                       
                        <?php echo smarty_function_load_language_text(array('section' => 'box_admin'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>

                        <!-- start: box_admin -->                            
                        <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_admin']; ?>
</span></div>
                                
                        <div id="menubox_admin_body" class="content-box-main clearfix">                                
                            <div class="content-box-main-inner clearfix">
                                        
                                <div class="content-box-main-inner_link">
                                    <?php echo $this->_tpl_vars['content_data']['CONTENT']; ?>

                                </div>                            
                                
                                <br /><?php if (! $this->_tpl_vars['content_data']['ADMIN_LINK_INFO']): ?>
                                
                                <a href="#" onclick="window.location='<?php echo $this->_tpl_vars['content_data']['BUTTON_ADMIN_URL']; ?>
'; return false;" class="button_red button_set">
                                    <span class="button-outer">
                                        <span class="button-inner"><?php echo $this->_tpl_vars['button']['click_here']; ?>
</span>
                                    </span>
                                </a><?php else: ?>   
                                
                                <a href="#" onclick="if(confirm('<?php echo $this->_tpl_vars['content_data']['ADMIN_LINK_INFO']; ?>
'))<?php echo '{'; ?>
window.location='<?php echo $this->_tpl_vars['content_data']['BUTTON_ADMIN_URL']; ?>
'; return false;<?php echo '}'; ?>
 return false;" class="button_red button_set">
                                    <span class="button-outer">
                                        <span class="button-inner"><?php echo $this->_tpl_vars['button']['click_here']; ?>
</span>
                                    </span>
                                </a><?php endif; ?><?php if ($this->_tpl_vars['content_data']['BUTTON_EDIT_PRODUCT_URL']): ?>
                                    
                                <br />
                                <br /><?php if (! $this->_tpl_vars['content_data']['ADMIN_LINK_INFO']): ?>
                                
                                <a href="#" onclick="window.open('<?php echo $this->_tpl_vars['content_data']['BUTTON_EDIT_PRODUCT_URL']; ?>
'); return false;" class="button_blue button_set" title="">
                                    <span class="button-outer">
                                        <span class="button-inner"><?php echo $this->_tpl_vars['button']['edit_product']; ?>
</span>
                                    </span>
                                </a><?php else: ?>
                                
                                <a href="#" onclick="if(confirm('<?php echo $this->_tpl_vars['content_data']['ADMIN_LINK_INFO']; ?>
'))<?php echo '{'; ?>
window.open('<?php echo $this->_tpl_vars['content_data']['BUTTON_EDIT_PRODUCT_URL']; ?>
'); return false;<?php echo '}'; ?>
 return false;" class="button_blue button_set" title="">
                                    <span class="button-outer">
                                        <span class="button-inner"><?php echo $this->_tpl_vars['button']['edit_product']; ?>
</span>
                                    </span>
                                </a><?php endif; ?><?php endif; ?>
                                    
                            </div>                                    
                        </div>
                        <!-- end: box_admin -->