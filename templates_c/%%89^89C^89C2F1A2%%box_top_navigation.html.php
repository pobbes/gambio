<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_top_navigation.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_top_navigation.html', 1, false),array('function', 'page_url', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_top_navigation.html', 21, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'top_navigation'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'infobox','name' => 'infobox'), $this);?>

    <!-- start: box_top_navigation -->
    <div id="top_navi">        
        <ul class="right top_navi_ul">
            <li title="<?php echo $this->_tpl_vars['txt']['title_home']; ?>
" class="png-fix">
                <div title="<?php echo $this->_tpl_vars['txt']['title_home']; ?>
" class="top_navi_home png-fix"></div>
                <a href="<?php echo $this->_tpl_vars['content_data']['HOME_URL']; ?>
" class="link-home">Home</a>
            </li><?php $_from = $this->_tpl_vars['content_data']['CONTENT_LINKS_DATA']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['cat_data'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['cat_data']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['content_item']):
        $this->_foreach['cat_data']['iteration']++;
?> 
            
            <li title="<?php echo $this->_tpl_vars['content_item']['NAME']; ?>
" class="png-fix">
                <a href="<?php echo $this->_tpl_vars['content_item']['URL']; ?>
" target="<?php echo $this->_tpl_vars['content_item']['URL_TARGET']; ?>
"><?php echo $this->_tpl_vars['content_item']['NAME']; ?>
</a>
            </li><?php endforeach; endif; unset($_from); ?><?php if ($this->_tpl_vars['content_data']['LANGUAGE_ICON']): ?>
            
            <li title="<?php echo $this->_tpl_vars['txt']['title_language']; ?>
" class="png-fix"><?php $_from = $this->_tpl_vars['content_data']['languages_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['language'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['language']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['language_data']):
        $this->_foreach['language']['iteration']++;
?><?php if ($this->_tpl_vars['language_data']['ID'] != $this->_tpl_vars['content_data']['CURRENT_LANGUAGES_ID']): ?>
				<a href="<?php echo $this->_tpl_vars['language_data']['LINK']; ?>
" title="<?php echo $this->_tpl_vars['language_data']['NAME']; ?>
">
                    <img src="<?php echo $this->_tpl_vars['language_data']['ICON_SMALL']; ?>
" title="" alt="" border="0" width="16" height="11" />
                </a>
                <a href="<?php echo $this->_tpl_vars['language_data']['LINK']; ?>
" title="<?php echo $this->_tpl_vars['language_data']['NAME']; ?>
"><?php echo $this->_tpl_vars['language_data']['CODE']; ?>
</a>
				<?php endif; ?>
                <?php endforeach; endif; unset($_from); ?>                
                <a href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="last pulldown_link link-language" id="language_link" rel="#language">
                    <img src="<?php echo $this->_tpl_vars['content_data']['LANGUAGE_ICON']; ?>
" title="" alt="" border="0" />
                </a>
            </li><?php endif; ?>
            <?php if ($this->_tpl_vars['content_data']['CURRENT_CURRENCY']): ?>            
            <li title="<?php echo $this->_tpl_vars['txt']['title_currency']; ?>
" class="png-fix">
                <div title="<?php echo $this->_tpl_vars['txt']['title_currency']; ?>
" class="top_navi_arrow png-fix">&nbsp;</div>
                <a href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="pulldown_link link-currency" id="currency_link" rel="#currency"><?php echo $this->_tpl_vars['content_data']['CURRENT_CURRENCY']; ?>
</a>
            </li><?php endif; ?>
            <?php if ($this->_tpl_vars['content_data']['ACCOUNT_URL']): ?>            
            <li title="<?php echo $this->_tpl_vars['txt']['title_account']; ?>
" class="png-fix">
                <a href="<?php echo $this->_tpl_vars['content_data']['ACCOUNT_URL']; ?>
" class="link-account"><?php echo $this->_tpl_vars['txt']['button_account']; ?>
</a>
            </li><?php endif; ?>
            <li title="<?php echo $this->_tpl_vars['txt']['title_checkout']; ?>
" class="png-fix">
                <a href="<?php echo $this->_tpl_vars['content_data']['CHECKOUT_URL']; ?>
" class="link-cart"><?php echo $this->_tpl_vars['txt']['button_checkout']; ?>
</a>
            </li>            
        </ul>        
    </div>
    <!-- end: box_top_navigation -->