<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from sh-webshop/module/main_content.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'sh-webshop/module/main_content.html', 1, false),array('modifier', 'replace', 'sh-webshop/module/main_content.html', 8, false),)), $this); ?>
                        <?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang_".($this->_tpl_vars['language']).".conf",'section' => 'index'), $this);?>


                        <?php echo $this->_tpl_vars['MODULE_error']; ?>
   

                        <div class="first_page_content">
                        <?php echo $this->_tpl_vars['title']; ?>

                                                                                                                    
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['text'])) ? $this->_run_mod_handler('replace', true, $_tmp, "text-decoration:underline;", "") : smarty_modifier_replace($_tmp, "text-decoration:underline;", "")); ?>

                        </div>                        
                        
                        <!-- start: specials_main -->
                        <?php echo $this->_tpl_vars['specials_main']; ?>

                        <!-- end: specials_main -->
                        
                        <!-- start: products_new_main -->
                        <?php echo $this->_tpl_vars['products_new_main']; ?>

                        <!-- end: products_new_main -->

                        <!-- start: MODULE_upcoming_products -->
                        <?php echo $this->_tpl_vars['MODULE_upcoming_products']; ?>

                        <!-- end: MODULE_upcoming_products -->
                        
                        <!-- start: MODULE_new_products -->
                        <?php echo $this->_tpl_vars['MODULE_new_products']; ?>

                        <!-- end: MODULE_new_products -->
                        
                        <!-- start: kp -->
                        <div class="first_page_content">
                        <?php echo $this->_tpl_vars['title_center']; ?>

                        <?php echo ((is_array($_tmp=$this->_tpl_vars['text_center'])) ? $this->_run_mod_handler('replace', true, $_tmp, "text-decoration:underline;", "") : smarty_modifier_replace($_tmp, "text-decoration:underline;", "")); ?>

                        </div>
                        <!-- end: kp -->
                        
                        <div class="first_page_content">
                        <?php echo $this->_tpl_vars['title_bottom']; ?>

                        
                        <?php echo ((is_array($_tmp=$this->_tpl_vars['text_bottom'])) ? $this->_run_mod_handler('replace', true, $_tmp, "text-decoration:underline;", "") : smarty_modifier_replace($_tmp, "text-decoration:underline;", "")); ?>

                        </div>