<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_gm_scroller.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_gm_scroller.html', 2, false),)), $this); ?>
                       
                        <?php echo smarty_function_load_language_text(array('section' => 'box_gm_scroller'), $this);?>
                        
                        <!-- start: box_gm_scroller -->                        
                        <div id="menubox_gm_scroller" class="c_gm_scroller content-box white clearfix">
                            
                            <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_gm_scroller']; ?>
</span></div> 
                            
                            <div id="menubox_gm_scroller_body" class="content-box-main clearfix" style="position:relative; overflow:hidden; height: <?php echo $this->_tpl_vars['content_data']['HEIGHT']; ?>
px;">
                                <div class="content-box-main-inner clearfix">
                                    <div id="gm_scroller" style="position:relative; display:none">
                                    <?php echo $this->_tpl_vars['content_data']['CONTENT']; ?>

                                    </div>
                                </div>                                
                            </div>
                            
                        </div>
                        <!-- end: box_gm_scroller -->