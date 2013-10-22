<?php /* Smarty version 2.6.26, created on 2013-05-15 12:13:40
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/module/gm_mega_flyover.html */ ?>
<div id="flyover" style="width: <?php echo $this->_tpl_vars['BOX_WIDTH']; ?>
px; height: <?php echo $this->_tpl_vars['BOX_HEIGHT']; ?>
px;">
	<?php $_from = $this->_tpl_vars['images_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['images'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['images']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['image_data']):
        $this->_foreach['images']['iteration']++;
?> 
		<img src="<?php echo $this->_tpl_vars['image_data']['IMAGE']; ?>
" class="flyover_image" border="0" alt="" title="" style="margin-left:<?php echo $this->_tpl_vars['image_data']['PADDING_LEFT']; ?>
px; margin-top: <?php echo $this->_tpl_vars['image_data']['PADDING_TOP']; ?>
px; display: none;"/>
	<?php endforeach; endif; unset($_from); ?>
</div>