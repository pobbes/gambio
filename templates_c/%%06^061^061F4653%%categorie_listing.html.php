<?php /* Smarty version 2.6.26, created on 2013-06-24 15:21:45
         compiled from sh-webshop/module/categorie_listing/categorie_listing.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/module/categorie_listing/categorie_listing.html', 1, false),array('modifier', 'default', 'sh-webshop/module/categorie_listing/categorie_listing.html', 5, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'categorie_listing'), $this);?>


<div id="categorie_listing">
    
        <div class="module_heading"><span><?php echo ((is_array($_tmp=@$this->_tpl_vars['CATEGORIES_HEADING_TITLE'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['CATEGORIES_NAME'])); ?>
</span></div>

        <?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION'] || $this->_tpl_vars['CATEGORIES_IMAGE']): ?>
            <div class="categories_description">
                    <?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION']): ?>
                            <?php echo $this->_tpl_vars['CATEGORIES_DESCRIPTION']; ?>

                    <?php endif; ?>
                    <?php if ($this->_tpl_vars['CATEGORIES_IMAGE']): ?>
                            <br />
                            <img src="<?php echo $this->_tpl_vars['CATEGORIES_IMAGE']; ?>
" alt="<?php echo ((is_array($_tmp=@$this->_tpl_vars['CATEGORIES_ALT_TEXT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['CATEGORIES_NAME'])); ?>
" title="<?php echo ((is_array($_tmp=@$this->_tpl_vars['CATEGORIES_ALT_TEXT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['CATEGORIES_NAME'])); ?>
" />
                            <br />
                            <br />
                    <?php endif; ?>
            </div>
        <?php endif; ?>

	<ul class="sub_categories_listing_body">
	<?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
		<?php  $col++;  ?>
		<li class="box_list" style="width:<?php echo $this->_tpl_vars['GM_LI_WIDTH']; ?>
%">
			<?php if ($this->_tpl_vars['SHOW_SUB_CATEGORIES_IMAGES'] == '1' && $this->_tpl_vars['module_data']['CATEGORIES_IMAGE']): ?>
				<a href="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_LINK']; ?>
"><img src="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_IMAGE']; ?>
" alt="<?php echo ((is_array($_tmp=@$this->_tpl_vars['module_data']['CATEGORIES_ALT_TEXT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['module_data']['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['module_data']['CATEGORIES_NAME'])); ?>
" title="<?php echo ((is_array($_tmp=@$this->_tpl_vars['module_data']['CATEGORIES_ALT_TEXT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['module_data']['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['module_data']['CATEGORIES_NAME'])); ?>
" /></a><br />
			<?php endif; ?>
			<?php if ($this->_tpl_vars['SHOW_SUB_CATEGORIES_NAMES'] == '1'): ?>
				<a href="<?php echo $this->_tpl_vars['module_data']['CATEGORIES_LINK']; ?>
"><?php echo $this->_tpl_vars['module_data']['CATEGORIES_NAME']; ?>
</a><br />
			<?php endif; ?>
		</li>
		<?php 
			$mod = $col % MAX_DISPLAY_CATEGORIES_PER_ROW;
			if($mod == 0 && $col != GM_CAT_COUNT)
			{
				echo '</ul><ul class="sub_categories_listing_body">';
			}
		 ?>
	<?php endforeach; endif; unset($_from); ?>
	</ul>

	</div>



<?php echo $this->_tpl_vars['MODULE_new_products']; ?>