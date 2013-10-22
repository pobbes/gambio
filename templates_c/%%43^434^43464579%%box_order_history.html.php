<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_order_history.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_order_history.html', 2, false),)), $this); ?>
                        
                        <?php echo smarty_function_load_language_text(array('section' => 'box_order_history'), $this);?>

                        <!-- start: box_order_history --><?php if ($this->_tpl_vars['content_data']['CONTENT']): ?>
                        <div id="menubox_order_history" class="c_order_history content-box white clearfix">
                            
                            <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_order_history']; ?>
</span></div> 
                            
                            <div id="menubox_order_history_body" class="content-box-main clearfix">
                                <div class="content-box-main-inner clearfix">
                              <?php echo $this->_tpl_vars['content_data']['CONTENT']; ?>

                                </div>
                            </div>
                        </div><?php endif; ?>
                        <!-- end: box_order_history -->