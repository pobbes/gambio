<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/objects/product_boxes_list.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'config_load', 'C:/xampp/htdocs/gambio/templates/sh-webshop/objects/product_boxes_list.html', 1, false),array('modifier', 'default', 'C:/xampp/htdocs/gambio/templates/sh-webshop/objects/product_boxes_list.html', 10, false),array('modifier', 'replace', 'C:/xampp/htdocs/gambio/templates/sh-webshop/objects/product_boxes_list.html', 10, false),array('modifier', 'truncate', 'C:/xampp/htdocs/gambio/templates/sh-webshop/objects/product_boxes_list.html', 16, false),)), $this); ?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang_".($this->_tpl_vars['language']).".conf",'section' => 'new_products'), $this);?>
<?php echo smarty_function_config_load(array('file' => ($this->_tpl_vars['language'])."/lang_".($this->_tpl_vars['language']).".conf",'section' => 'index'), $this);?>
             
                        <div class="article-list cols clearfix">
<?php $_from = $this->_tpl_vars['content_data']['PRODUCTS_DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['module_data']):
?>                            
                            <!-- start: product_box -->
                            <div class="product_box left">                            
                                <div class="product_box_inner">                                
                                    <div class="product_image"><?php if ($this->_tpl_vars['module_data']['PRODUCTS_IMAGE']): ?>                                    
                                       <span id="<?php echo $this->_tpl_vars['content_data']['ID_PREFIX']; ?>
_<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
" class="flyover_item">
                                           <a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
">                                   
                                               <img src="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE']; ?>
" alt="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['module_data']['PRODUCTS_IMAGE_ALT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME'])))) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
" title="<?php echo ((is_array($_tmp=((is_array($_tmp=@$this->_tpl_vars['module_data']['PRODUCTS_IMAGE_ALT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME'])))) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
" />
                                           </a>
                                        </span>
                                    <?php endif; ?></div>
                                    
                                    <div class="product_description">
                                        <a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"<?php if ($this->_tpl_vars['module_data']['PRODUCTS_META_DESCRIPTION'] != ''): ?> title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module_data']['PRODUCTS_META_DESCRIPTION'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...") : smarty_modifier_truncate($_tmp, 80, "...")))) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
"<?php endif; ?>><?php echo ((is_array($_tmp=$this->_tpl_vars['module_data']['PRODUCTS_NAME'])) ? $this->_run_mod_handler('truncate', true, $_tmp, $this->_tpl_vars['content_data']['TRUNCATE_PRODUCTS_NAME'], "...") : smarty_modifier_truncate($_tmp, $this->_tpl_vars['content_data']['TRUNCATE_PRODUCTS_NAME'], "...")); ?>
</a>
                                    </div>
                                    
                                    <div class="product_info"> 

                                        <span class="product_details left">
                                            <a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
">details</a>
                                        </span>
                                        
                                        <span class="product_price right">
                                            <a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE']; ?>
</a>
                                        </span>
    
                                        <?php if ($this->_tpl_vars['module_data']['PRODUCTS_TAX_INFO'] != '' || $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_LINK'] != ''): ?><br />
                                                                                <?php endif; ?>
                                        <?php if ($this->_tpl_vars['module_data']['PRODUCTS_VPE']): ?>
                                        <span class="small">
                                        <?php echo $this->_tpl_vars['module_data']['PRODUCTS_VPE']; ?>

                                        <br />
                                        </span><?php endif; ?>

                                    </div>
                                </div>                        
                            </div>                
                            <!-- end: product_box --><?php endforeach; endif; unset($_from); ?>                        
                        </div>