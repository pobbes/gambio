<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_cart_dropdown.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_cart_dropdown.html', 1, false),array('modifier', 'xtc_href_link', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_cart_dropdown.html', 26, false),)), $this); ?>
    <?php echo smarty_function_load_language_text(array('section' => 'box_cart'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>

    <!-- start: box_cart_dropdown -->    
    <div id="dropdown_shopping_cart" style="display: none;">
        
        <div id="dropdown_shopping_cart_inner" class="clearfix"><?php if ($this->_tpl_vars['empty'] == 'false'): ?><?php $_from = $this->_tpl_vars['products']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['products_data']):
        $this->_foreach['aussen']['iteration']++;
?>
            
            <div class="cart-item clearfix">            
                <div class="cart-item-inner clearfix"><?php if ($this->_tpl_vars['products_data']['IMAGE']): ?>               
                    <a href="<?php echo $this->_tpl_vars['products_data']['LINK']; ?>
">
                        <img alt="" style="max-width: 40px; max-height: 40px; border: 0pt none; margin: 0px 10px 0px 0pt; float: left;" src="<?php echo $this->_tpl_vars['products_data']['IMAGE']; ?>
" />
                    </a><?php endif; ?>
                     
                    <p><?php echo $this->_tpl_vars['products_data']['QTY']; ?>
<?php if ($this->_tpl_vars['products_data']['UNIT']): ?> <?php echo $this->_tpl_vars['products_data']['UNIT']; ?>
<?php else: ?>x<?php endif; ?> <?php echo $this->_tpl_vars['products_data']['NAME']; ?>
<br/>
                        <span class="price"><?php echo $this->_tpl_vars['products_data']['PRICE']; ?>
</span>
                    </p>                                            
                </div>                                        
            </div><?php endforeach; endif; unset($_from); ?>
            
            <div id="dropdown_shopping_cart_total">
                <span><?php echo $this->_tpl_vars['txt']['text_total']; ?>
 <?php echo $this->_tpl_vars['TOTAL']; ?>
</span>
            </div>
        
            <p class="mwst-hint"><?php echo $this->_tpl_vars['UST']; ?>
 <?php if ($this->_tpl_vars['SHIPPING_INFO']): ?><?php echo $this->_tpl_vars['SHIPPING_INFO']; ?>
<?php endif; ?></p>
                    
            <div class="cart-button left">    
                <a class="button_blue button_set" href="<?php echo ((is_array($_tmp='shopping_cart.php')) ? $this->_run_mod_handler('xtc_href_link', true, $_tmp) : smarty_modifier_xtc_href_link($_tmp)); ?>
">
                    <span class="button-outer">
                            <span class="button-inner"><?php echo $this->_tpl_vars['button']['to_cart']; ?>
</span>
                    </span>
                </a>    
            </div>
        
            <div class="checkout-button right">
                <a class="button_blue button_set" href="<?php echo ((is_array($_tmp='checkout_shipping.php')) ? $this->_run_mod_handler('xtc_href_link', true, $_tmp, '', 'SSL') : smarty_modifier_xtc_href_link($_tmp, '', 'SSL')); ?>
">
                    <span class="button-outer">
                        <span class="button-inner"><?php echo $this->_tpl_vars['button']['checkout']; ?>
</span>
                    </span>
                </a>
            </div><?php else: ?>
            
            <div class="cart-item clearfix">
                <div class="cart-item-inner clearfix">
                    <p><?php echo $this->_tpl_vars['txt']['text_empty_cart']; ?>
</p>
                </div>
            </div><?php endif; ?>
                                
        </div>
        
        <div class="dropdown_shopping_cart_bg_bottom"></div>
                                    
    </div>                            
    <!-- end: box_cart_dropdown -->