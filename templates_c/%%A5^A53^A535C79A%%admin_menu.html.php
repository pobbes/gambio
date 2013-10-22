<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:05
         compiled from C:/xampp/htdocs/gambio/admin/templates/admin_menu.html */ ?>
<?php $_from = $this->_tpl_vars['content_data']['DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['group']):
?>
  <div class="leftmenu_head" style="background-image:url(images/gm_icons/<?php echo $this->_tpl_vars['group']['background']; ?>
)"><?php echo $this->_tpl_vars['group']['title']; ?>
</div>
  <div class="leftmenu_collapse leftmenu_collapse_opened"> </div>
  <ul class="leftmenu_box" id="<?php echo $this->_tpl_vars['group']['id']; ?>
">
  <?php $_from = $this->_tpl_vars['group']['menuitems']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }if (count($_from)):
    foreach ($_from as $this->_tpl_vars['item']):
?>
    <?php if ($this->_tpl_vars['group']['title'] == 'FAVS'): ?>
      <li class="leftmenu_body_item"><a class="fav_content_item" id="<?php echo $this->_tpl_vars['item']['id']; ?>
" href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
    <?php else: ?>
      <li class="leftmenu_body_item"><a class="fav_drag_item" id="<?php echo $this->_tpl_vars['item']['id']; ?>
" href="<?php echo $this->_tpl_vars['item']['link']; ?>
"><?php echo $this->_tpl_vars['item']['title']; ?>
</a></li>
    <?php endif; ?>
  <?php endforeach; endif; unset($_from); ?>
  </ul>
<?php endforeach; endif; unset($_from); ?>