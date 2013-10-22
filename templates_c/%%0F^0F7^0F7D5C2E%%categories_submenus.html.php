<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:08
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/module/categories_submenus.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('modifier', 'count', 'C:/xampp/htdocs/gambio/templates/sh-webshop/module/categories_submenus.html', 2, false),array('modifier', 'replace', 'C:/xampp/htdocs/gambio/templates/sh-webshop/module/categories_submenus.html', 15, false),)), $this); ?>
<!-- start: module/categories_submenus -->
<?php if (count($this->_tpl_vars['content_data']['CATEGORIES_DATA']) > 0): ?>
<div class="submenu_container" style="display:none;">
	<div id="submenu_box_id_<?php echo $this->_tpl_vars['content_data']['current_category_id']; ?>
" class="submenu png-fix clearfix">
		<div>
			<ul>
				<?php $_from = $this->_tpl_vars['content_data']['CATEGORIES_DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cat_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['categories_item']):
        $this->_foreach['cat_data']['iteration']++;
?>
					<li id="menu_cat_id_<?php echo $this->_tpl_vars['categories_item']['data']['id']; ?>
"<?php if (($this->_foreach['cat_data']['iteration'] == $this->_foreach['cat_data']['total'])): ?> class="last"<?php endif; ?>>
						<h4>
							<?php if ($this->_tpl_vars['categories_item']['data']['icon']): ?>
                                <img src="<?php echo $this->_tpl_vars['categories_item']['data']['icon']; ?>
" width="<?php echo $this->_tpl_vars['categories_item']['data']['icon_w']; ?>
" height="<?php echo $this->_tpl_vars['categories_item']['data']['icon_h']; ?>
" style="float: left; margin-right: 10px;" alt="" />
                            <?php endif; ?>
                            
                            <a href="<?php echo $this->_tpl_vars['categories_item']['data']['url']; ?>
"<?php if (count($this->_tpl_vars['categories_item']['children']) > 0): ?> class="parent"<?php endif; ?>>
                                <?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['categories_item']['data']['name'])) ? $this->_run_mod_handler('replace', true, $_tmp, "&amp;", "&") : smarty_modifier_replace($_tmp, "&amp;", "&")))) ? $this->_run_mod_handler('replace', true, $_tmp, "&", "&amp;") : smarty_modifier_replace($_tmp, "&", "&amp;")); ?>
<?php if ($this->_tpl_vars['categories_item']['data']['products_count']): ?> (<?php echo $this->_tpl_vars['categories_item']['data']['products_count']; ?>
)<?php endif; ?>
                            </a>
						</h4>
					</li>
				<?php endforeach; endif; unset($_from); ?>
			</ul>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- end: module/categories_submenus -->