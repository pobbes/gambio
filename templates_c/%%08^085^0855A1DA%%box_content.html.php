<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_content.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_content.html', 2, false),)), $this); ?>

                        <?php echo smarty_function_load_language_text(array('section' => 'box_content'), $this);?>
                        
                        <!-- start:box_content -->                        
                        <div id="menubox_content" class="c_content content-box white clearfix">
                            
                            <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_content']; ?>
</span></div> 
                            
                            <div id="menubox_content_body" class="content-box-main clearfix">
                                <div class="content-box-main-inner clearfix">
                                    <ul class="sidebar_nav">
                                    <?php echo $this->_tpl_vars['content_data']['CONTENT']; ?>

                                    </ul>
                                </div>
                            </div>
                            
                        </div>
                        <!-- end:box_content -->