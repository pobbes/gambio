<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_cart_head.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_cart_head.html', 2, false),array('modifier', 'count', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_cart_head.html', 15, false),)), $this); ?>
                    
                    <?php echo smarty_function_load_language_text(array('section' => 'box_cart'), $this);?>

                    <!-- start: box_cart_head -->                        
                    <div id="head_shopping_cart" class="right" title="<?php echo $this->_tpl_vars['txt']['title_cart']; ?>
">                            
                        <div id="head_shopping_cart_inner">                                
                            <table cellspacing="0" cellpadding="0" class="head_shopping_cart_table">                                    
                                <tbody>                                        
                                    <tr>                                            
                                        <td><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/icon-grey-basket-big.png" width="30" height="24" style="border:none; margin-bottom:3px" alt="" /></td>
                                        
                                        <td>
                                            <span class="shopping-cart-headline"><?php echo $this->_tpl_vars['txt']['heading_cart']; ?>
</span>
                                            <br />
                                            <span class="shopping-cart-product-count">
                                            <?php if (count($this->_tpl_vars['products']) == 0): ?><?php echo $this->_tpl_vars['txt']['text_no_product']; ?>
<?php endif; ?>
                                            <?php if (count($this->_tpl_vars['products']) == 1): ?><?php echo $this->_tpl_vars['txt']['text_one_product']; ?>
<?php endif; ?>
                                            <?php if (count($this->_tpl_vars['products']) > 1): ?><?php echo count($this->_tpl_vars['products']); ?>
 <?php echo $this->_tpl_vars['txt']['text_several_products']; ?>
<?php endif; ?>
                                                
                                            </span>                                                
                                        </td> 
                                        
                                        <td><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/icon-grey-arrowdown.png" width="9" height="5" style="border:none; margin-bottom:3px" alt="" /></td>
                                    </tr>                                        
                                </tbody>                                    
                            </table>                                
                        </div>                            
                    </div>
                    <!-- end: box_cart_head -->