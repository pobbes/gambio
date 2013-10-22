<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_languages_dropdown.html */ ?>
    
    <!-- start: box_languages_dropdown -->
    <div id="language" style="display:none;">
        <div class="language_container png-fix">
            <div class="language_inside">
                <ul>
<?php $_from = $this->_tpl_vars['content_data']['languages_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_data']):
        $this->_foreach['language']['iteration']++;
?><?php if ($this->_tpl_vars['language_data']['ID'] != $this->_tpl_vars['content_data']['CURRENT_LANGUAGES_ID']): ?>
                    <li>
                        <div style="clear:both">
                            <a href="<?php echo $this->_tpl_vars['language_data']['LINK']; ?>
" title="<?php echo $this->_tpl_vars['language_data']['NAME']; ?>
">
                                <img src="<?php echo $this->_tpl_vars['language_data']['ICON_SMALL']; ?>
" title="" alt="" width="16" height="11" />
                            </a> 
                            <a href="<?php echo $this->_tpl_vars['language_data']['LINK']; ?>
" title="<?php echo $this->_tpl_vars['language_data']['NAME']; ?>
"><?php echo $this->_tpl_vars['language_data']['CODE']; ?>
</a>
                        </div>
                    </li>
<?php endif; ?><?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: box_languages_dropdown -->