<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_best_sellers.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_best_sellers.html', 2, false),array('modifier', 'truncate', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_best_sellers.html', 16, false),array('modifier', 'replace', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_best_sellers.html', 16, false),)), $this); ?>
                   
                    <?php echo smarty_function_load_language_text(array('section' => 'box_best_sellers'), $this);?>

                    <!-- start: box_best_sellers --><?php if ($this->_tpl_vars['content_data']['PRODUCTS_DATA'] || $this->_tpl_vars['style_edit_active']): ?>

                    <div id="menubox_best_sellers" class="c_bestsellers content-box white clearfix">
                        
                        <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_best_sellers']; ?>
</span></div> 
                        
                        <div id="menubox_best_sellers_body" class="content-box-main clearfix">
                            
                            <div class="content-box-main-inner clearfix article-list bestsellers"><?php $_from = $this->_tpl_vars['content_data']['PRODUCTS_DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['products_item']):
        $this->_foreach['aussen']['iteration']++;
?>                            
                                <div class="article-list-item box_load_bestseller">                                    
                                    <div class="article-list-item-inside">                                        
                                        <div class="article-list-item-text box_head">
                                            <span id="bestseller-number_<?php echo $this->_tpl_vars['products_item']['PRODUCTS_ID']; ?>
" class="article-list-item-number flyover_item"><?php echo $this->_tpl_vars['products_item']['COUNT']; ?>
.</span>
                                            <span id="bestseller-title_<?php echo $this->_tpl_vars['products_item']['PRODUCTS_ID']; ?>
" class="title flyover_item"><a href="<?php echo $this->_tpl_vars['products_item']['PRODUCTS_LINK']; ?>
"<?php if ($this->_tpl_vars['products_item']['PRODUCTS_META_DESCRIPTION'] != ''): ?> title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['products_item']['PRODUCTS_META_DESCRIPTION'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...") : smarty_modifier_truncate($_tmp, 80, "...")))) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['products_item']['PRODUCTS_NAME']; ?>
</a></span>
                                        </div>

                                        <div class="article-list-item-price">
                                            <?php echo $this->_tpl_vars['products_item']['PRODUCTS_PRICE']; ?>
<br />
                                        </div>

                                    </div>
                                </div><?php endforeach; endif; unset($_from); ?>    

                            </div>

                        </div>

                    </div><?php endif; ?>

                    <!-- end: box_best_sellers -->