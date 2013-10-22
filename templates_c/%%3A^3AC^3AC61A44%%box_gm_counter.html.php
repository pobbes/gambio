<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_gm_counter.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_gm_counter.html', 2, false),)), $this); ?>

                        <?php echo smarty_function_load_language_text(array('section' => 'box_gm_counter'), $this);?>

                        <!-- start: box_gm_counter -->
                        <div id="menubox_gm_counter" class="c_gm_counter content-box white clearfix">
                            
                            <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_gm_counter']; ?>
</span></div> 
                            
                            <div id="menubox_gm_counter_body" class="content-box-main clearfix">
                                <div class="content-box-main-inner clearfix">
                                    <span class="strong"><?php echo $this->_tpl_vars['content_data']['GM_ONLINE']; ?>
 <?php echo $this->_tpl_vars['txt']['text_vistor']; ?>
</span>
                                    <br />
                                    <?php echo $this->_tpl_vars['txt']['text_online']; ?>

                                    <br />
                                    <br />
                                    <span class="strong"><?php echo $this->_tpl_vars['content_data']['GM_HITS']; ?>
 <?php echo $this->_tpl_vars['txt']['text_vistor']; ?>
</span>
                                    <br />
                                    <?php echo $this->_tpl_vars['txt']['text_since']; ?>
 <?php echo $this->_tpl_vars['content_data']['GM_DATE']; ?>

                                </div>
                            </div>
                        </div>
                        <!-- end: box_gm_counter -->