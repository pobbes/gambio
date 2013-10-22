<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_categories.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_categories.html', 1, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'box_categories'), $this);?>

                    <!-- start: box_categories -->    
                    <div>        
                        <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_categories']; ?>
</span></div>  
                    
                        <ul id="accordion">
                            <?php echo $this->_tpl_vars['content_data']['BOX_CONTENT']; ?>

                        </ul>        
                    </div>
                    <!-- end: box_categories -->