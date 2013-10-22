<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:06
         compiled from C:/xampp/htdocs/gambio/admin/templates/admin_infobox.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/admin/templates/admin_infobox.html', 1, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'admin_info_boxes'), $this);?>


<div id="admin_info_wrapper">		
	<div style="position:relative">
		
		<div class="content">
			<?php $_from = $this->_tpl_vars['content_data']['messages_array']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['messages'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['messages']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['message']):
        $this->_foreach['messages']['iteration']++;
?>
				<div class="admin_info_box<?php if ($this->_tpl_vars['message']['type'] != 'info'): ?> <?php echo $this->_tpl_vars['message']['type']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['message']['status'] == 'hidden'): ?> hidden<?php endif; ?><?php if ($this->_tpl_vars['message']['status'] == 'read'): ?> read<?php endif; ?>">
					<?php if ($this->_tpl_vars['message']['visibility'] == 'hideable' || $this->_tpl_vars['message']['visibility'] == 'removable'): ?><a href="request_port.php?module=AdminInfoBox&action=hide_info_box&id=<?php echo $this->_tpl_vars['message']['infobox_messages_id']; ?>
" class="info_close ajax" rel="hide_info_box"><img src="images/info_box_minimize.png" alt="X" title="<?php echo $this->_tpl_vars['txt']['CLOSE']; ?>
" /></a><?php endif; ?>
					<?php if ($this->_tpl_vars['message']['visibility'] == 'removable'): ?><a href="request_port.php?module=AdminInfoBox&action=remove_info_box&id=<?php echo $this->_tpl_vars['message']['infobox_messages_id']; ?>
" class="info_remove ajax" rel="remove_info_box"><img src="images/info_box_close.png" alt="X" title="<?php echo $this->_tpl_vars['txt']['DELETE']; ?>
" /></a><?php endif; ?>
					<?php if ($this->_tpl_vars['message']['headline'] != ''): ?><p class="info_headline"><?php echo $this->_tpl_vars['message']['headline']; ?>
</p><?php endif; ?>					
					<p class="info_text"><?php echo $this->_tpl_vars['message']['message']; ?>
</p>						
					<img class="info_loading" src="images/loading.gif" alt="..." title="<?php echo $this->_tpl_vars['txt']['IN_PROGRESS']; ?>
" />
					<?php if ($this->_tpl_vars['message']['button_label'] != ''): ?><a href="<?php echo $this->_tpl_vars['message']['button_link']; ?>
" class="info_action_button<?php if ($this->_tpl_vars['message']['ajax'] == 1): ?> ajax<?php endif; ?>" title="<?php echo $this->_tpl_vars['message']['button_label']; ?>
" rel="<?php echo $this->_tpl_vars['message']['identifier']; ?>
"><?php echo $this->_tpl_vars['message']['button_label']; ?>
</a><?php endif; ?>
					<span class="admin_info_box_id hidden"><?php echo $this->_tpl_vars['message']['infobox_messages_id']; ?>
</span>
					<div style="clear: both;"> <!-- --> </div>
				</div>
			<?php endforeach; endif; unset($_from); ?>
			<div class="no_messages">
				<?php echo $this->_tpl_vars['txt']['NO_MESSAGES']; ?>

			</div>
			<div class="show_all">
				<input type="checkbox" class="show_all_info_boxes" /> <?php echo $this->_tpl_vars['txt']['SHOW_ALL']; ?>

			</div>
		</div>
		
		<div class="triangle-with-shadow-wrapper"><div class="triangle-with-shadow-container"><div class="triangle-with-shadow"></div></div></div>

	</div>
</div>