<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_infobox_dropdown.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_infobox_dropdown.html', 1, false),)), $this); ?>
    <?php echo smarty_function_load_language_text(array('section' => 'infobox'), $this);?>

    <!-- start: box_infobox_dropdown -->
    <div id="infobox" style="display:none;">
        <div class="infobox_container png-fix">
            <div class="infobox_content">
<?php if ($this->_tpl_vars['content_data']['customers_data']['LAST_NAME']): ?>
                <p><?php if ($this->_tpl_vars['content_data']['customers_data']['GENDER'] == 'm'): ?><?php echo $this->_tpl_vars['txt']['male']; ?>
<?php else: ?><?php echo $this->_tpl_vars['txt']['female']; ?>
<?php endif; ?> <?php echo $this->_tpl_vars['content_data']['customers_data']['FIRST_NAME']; ?>
 <?php echo $this->_tpl_vars['content_data']['customers_data']['LAST_NAME']; ?>
</p>
<?php endif; ?><?php if ($this->_tpl_vars['content_data']['customers_data']['PRODUCTS_DISCOUNT']): ?>
                <p><?php echo $this->_tpl_vars['txt']['products_discount']; ?>
: <?php echo $this->_tpl_vars['content_data']['customers_data']['PRODUCTS_DISCOUNT']; ?>
%</p><?php endif; ?><?php if ($this->_tpl_vars['content_data']['customers_data']['ORDER_DISCOUNT']): ?>
                <p><?php echo $this->_tpl_vars['txt']['order_discount']; ?>
: <?php echo $this->_tpl_vars['content_data']['customers_data']['ORDER_DISCOUNT']; ?>
%</p><?php endif; ?>            </div>
        </div>
    </div>
    <!-- end: box_infobox_dropdown -->