<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_currencies_dropdown.html */ ?>
    
    <!-- start: box_currencies_dropdown -->
    <div id="currency" style="display:none;">
        <div class="currency_container png-fix">
            <div class="currency_content">
                <ul>
<?php $_from = $this->_tpl_vars['content_data']['currencies_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['currencies'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['currencies']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['currency_data']):
        $this->_foreach['currencies']['iteration']++;
?><?php if ($this->_tpl_vars['content_data']['CURRENT_CURRENCY'] != $this->_tpl_vars['currency_data']['id']): ?>
                    <li><a href="<?php echo $this->_tpl_vars['currency_data']['link']; ?>
" title="<?php echo $this->_tpl_vars['currency_data']['text']; ?>
"><?php echo $this->_tpl_vars['currency_data']['id']; ?>
</a></li>
<?php endif; ?><?php endforeach; endif; unset($_from); ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: box_currencies_dropdown -->