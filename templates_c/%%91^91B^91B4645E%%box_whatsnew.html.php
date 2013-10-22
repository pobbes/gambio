<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_whatsnew.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_whatsnew.html', 2, false),array('modifier', 'default', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_whatsnew.html', 19, false),array('modifier', 'truncate', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_whatsnew.html', 26, false),array('modifier', 'replace', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_whatsnew.html', 26, false),)), $this); ?>

                        <?php echo smarty_function_load_language_text(array('section' => 'box_whatsnew'), $this);?>

                        <!-- start: box_whatsnew -->
                        <div id="menubox_whatsnew" class="c_whatsnew content-box white clearfix">
                            
                            <div class="module_heading"><span><?php echo $this->_tpl_vars['txt']['heading_whatsnew']; ?>
</span></div> 
                            
                            <a href="<?php echo $this->_tpl_vars['content_data']['LINK_NEW_PRODUCTS']; ?>
">
                                <div class="png-fix circle_arrow_right" title="<?php echo $this->_tpl_vars['txt']['heading_whatsnew']; ?>
">&nbsp;</div>
                            </a>
                            
                            <div id="menubox_whatsnew_body" class="content-box-main clearfix">
                                <div class="content-box-main-inner clearfix article-list offer">
                                    <div class="article-list-item">
                                        <div class="article-list-item-inside"><?php if ($this->_tpl_vars['content_data']['box_content']['PRODUCTS_IMAGE']): ?>
                                            
                                            <div class="article-list-item-image">
                                                <a href="<?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_LINK']; ?>
">
                                                    <img src="<?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_IMAGE']; ?>
" alt="<?php echo ((is_array($_tmp=@$this->_tpl_vars['content_data']['box_content']['PRODUCTS_IMAGE_ALT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['content_data']['box_content']['PRODUCTS_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['content_data']['box_content']['PRODUCTS_NAME'])); ?>
" title="<?php echo ((is_array($_tmp=@$this->_tpl_vars['content_data']['box_content']['PRODUCTS_IMAGE_ALT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['content_data']['box_content']['PRODUCTS_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['content_data']['box_content']['PRODUCTS_NAME'])); ?>
" />
                                                </a>
                                            </div><?php endif; ?>
                                            
                                            <div class="article-list-item-text">
                                                <br />
                                                <span class="title">
                                                    <a href="<?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_LINK']; ?>
"<?php if ($this->_tpl_vars['content_data']['box_content']['PRODUCTS_META_DESCRIPTION'] != ''): ?> title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['content_data']['box_content']['PRODUCTS_META_DESCRIPTION'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...") : smarty_modifier_truncate($_tmp, 80, "...")))) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_NAME']; ?>
</a>
                                                </span>
                                                <br />
                                                <br />
                                                <span class="price">
                                                    <a href="<?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_LINK']; ?>
"><?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_PRICE']; ?>
</a>
                                                </span>
                                                <br /><?php if ($this->_tpl_vars['content_data']['box_content']['PRODUCTS_VPE']): ?>

                                                <span class="title"><?php echo $this->_tpl_vars['content_data']['box_content']['PRODUCTS_VPE']; ?>
</span>
                                                <br /><?php endif; ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- end: box_whatsnew -->