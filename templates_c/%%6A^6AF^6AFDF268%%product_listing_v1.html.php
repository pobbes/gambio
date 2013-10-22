<?php /* Smarty version 2.6.26, created on 2013-05-15 12:20:57
         compiled from sh-webshop/module/product_listing/product_listing_v1.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/module/product_listing/product_listing_v1.html', 1, false),array('function', 'object_product_list', 'sh-webshop/module/product_listing/product_listing_v1.html', 113, false),array('modifier', 'default', 'sh-webshop/module/product_listing/product_listing_v1.html', 17, false),array('modifier', 'truncate', 'sh-webshop/module/product_listing/product_listing_v1.html', 133, false),array('modifier', 'replace', 'sh-webshop/module/product_listing/product_listing_v1.html', 133, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'product_listing'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'product_info','name' => 'info'), $this);?>

<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>



<!-- start: product_listing_v1 -->
<div id="product_listing" class="product-listing">

	<div class="categories_name">
		<?php if ($this->_tpl_vars['SEARCH_RESULT_PAGE'] == 1): ?>
			<?php if ($this->_tpl_vars['KEYWORDS'] != ''): ?>
				<h1><?php echo $this->_tpl_vars['txt']['heading_search_result_plus_keywords']; ?>
 &quot;<?php echo $this->_tpl_vars['KEYWORDS']; ?>
&quot;</h1>
			<?php else: ?>
				<h1><?php echo $this->_tpl_vars['txt']['heading_search_result']; ?>
</h1>
			<?php endif; ?>
		<?php else: ?>
			<h1><?php echo ((is_array($_tmp=@$this->_tpl_vars['CATEGORIES_HEADING_TITLE'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['CATEGORIES_NAME'])); ?>
</h1>
		<?php endif; ?>
	</div>
    
        <?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION'] || $this->_tpl_vars['CATEGORIES_IMAGE'] || $this->_tpl_vars['MANUFACTURER_DROPDOWN']): ?>
            <div class="categories_description">
                    <?php if ($this->_tpl_vars['CATEGORIES_DESCRIPTION']): ?>
                            <?php echo $this->_tpl_vars['CATEGORIES_DESCRIPTION']; ?>

                    <?php endif; ?>

                    <div class="align_right">
                            <?php if ($this->_tpl_vars['CATEGORIES_IMAGE']): ?>
                                    <img src="<?php echo $this->_tpl_vars['CATEGORIES_IMAGE']; ?>
" alt="<?php echo ((is_array($_tmp=@$this->_tpl_vars['CATEGORIES_GM_ALT_TEXT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['CATEGORIES_NAME'])); ?>
" title="<?php echo ((is_array($_tmp=@$this->_tpl_vars['CATEGORIES_GM_ALT_TEXT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['CATEGORIES_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['CATEGORIES_NAME'])); ?>
" />
                            <?php endif; ?>
                            <?php if ($this->_tpl_vars['MANUFACTURER_DROPDOWN']): ?>
                                                                        <br />
                                    <br />
                                    <form id="<?php echo $this->_tpl_vars['manufacturers_data']['FORM']['ID']; ?>
" action="<?php echo $this->_tpl_vars['manufacturers_data']['FORM']['ACTION']; ?>
" method="<?php echo $this->_tpl_vars['manufacturers_data']['FORM']['METHOD']; ?>
">
                                            <?php $_from = $this->_tpl_vars['manufacturers_data']['HIDDEN']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hidden_fields'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hidden_fields']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['hidden']):
        $this->_foreach['hidden_fields']['iteration']++;
?>
                                                    <input type="hidden" name="<?php echo $this->_tpl_vars['hidden']['NAME']; ?>
" value="<?php echo $this->_tpl_vars['hidden']['VALUE']; ?>
" />
                                            <?php endforeach; endif; unset($_from); ?>

                                            <span class="strong"><?php if ($this->_tpl_vars['gm_manufacturers_id']): ?><?php echo $this->_tpl_vars['txt']['text_show']; ?>
<?php else: ?><?php echo $this->_tpl_vars['txt']['text_show']; ?>
<?php endif; ?>&nbsp;</span>

                                            <select name="<?php echo $this->_tpl_vars['manufacturers_data']['NAME']; ?>
" size="1" class="manufactuers_selection input-select">
                                            <?php $_from = $this->_tpl_vars['manufacturers_data']['OPTIONS']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['options'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['options']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['option']):
        $this->_foreach['options']['iteration']++;
?>
                                                    <option value="<?php echo $this->_tpl_vars['option']['VALUE']; ?>
"<?php if ($this->_tpl_vars['manufacturers_data']['DEFAULT'] == $this->_tpl_vars['option']['VALUE']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['option']['NAME']; ?>
</option>
                                            <?php endforeach; endif; unset($_from); ?>
                                            </select>
                                    </form>
                            <?php endif; ?>
                    </div>
            </div>
        <?php endif; ?>


	<div class="panel clearfix">
		<form name="panel" action="<?php echo $this->_tpl_vars['SORTING_FORM_ACTION_URL']; ?>
" method="get">
			<?php $_from = $this->_tpl_vars['get_params_hidden_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hidden_fields'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hidden_fields']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['hidden_data']):
        $this->_foreach['hidden_fields']['iteration']++;
?>
				<input type="hidden" name="<?php echo $this->_tpl_vars['hidden_data']['NAME']; ?>
" value="<?php echo $this->_tpl_vars['hidden_data']['VALUE']; ?>
" />
			<?php endforeach; endif; unset($_from); ?>
			<div class="panel-sort left clearfix">
				<div class="input select">
					<label for="listing_sort"><?php echo $this->_tpl_vars['txt']['label_sort']; ?>
</label>
					<select name="listing_sort" class="input-select">
						<option value=""<?php if (! $this->_tpl_vars['SORT'] || $this->_tpl_vars['SORT'] == ''): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_select']; ?>
</option>
						<option value="price_asc"<?php if ($this->_tpl_vars['SORT'] == 'price_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_price_asc']; ?>
</option>
						<option value="price_desc"<?php if ($this->_tpl_vars['SORT'] == 'price_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_price_desc']; ?>
</option>
						<option value="name_asc"<?php if ($this->_tpl_vars['SORT'] == 'name_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_name_asc']; ?>
</option>
						<option value="name_desc"<?php if ($this->_tpl_vars['SORT'] == 'name_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_name_desc']; ?>
</option>
						<option value="date_asc"<?php if ($this->_tpl_vars['SORT'] == 'date_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_date_asc']; ?>
</option>
						<option value="date_desc"<?php if ($this->_tpl_vars['SORT'] == 'date_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_date_desc']; ?>
</option>
						<option value="shipping_asc"<?php if ($this->_tpl_vars['SORT'] == 'shipping_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_shipping_asc']; ?>
</option>
						<option value="shipping_desc"<?php if ($this->_tpl_vars['SORT'] == 'shipping_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_shipping_desc']; ?>
</option>
					</select>
				</div>
			</div>
			<div class="panel-itemcount left clearfix">
				<div class="input select">
					<label for="listing_count"><?php echo $this->_tpl_vars['txt']['label_itemcount']; ?>
</label>
					<select name="listing_count" class="input-select">
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_1']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_1']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_1']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_2']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_2']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_2']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_3']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_3']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_3']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_4']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_4']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_4']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_5']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_5']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_5']; ?>
</option>
					</select>
				</div>
			</div>


			<div class="panel-viewmode left clearfix">
				<?php if ($this->_tpl_vars['VIEW_MODE'] == 'tiled'): ?>
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_DEFAULT']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_default_off.png" alt="" /></a>&nbsp;&nbsp;
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_TILED']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/icons/view_mode_tiled_on.png" alt="" /></a>
				<?php else: ?>
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_DEFAULT']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_default_on.png" alt="" /></a>&nbsp;&nbsp;
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_TILED']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_tiled_off.png" alt="" /></a>
				<?php endif; ?>
			</div>

		</form>
		<div class="panel-pagination right clearfix">
			<p><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</p>
		</div>
	</div>


	<?php if ($this->_tpl_vars['VIEW_MODE'] == 'tiled'): ?>
		<?php if ($this->_tpl_vars['module_content'] != ''): ?>
			<?php echo smarty_function_object_product_list(array('product_list' => $this->_tpl_vars['module_content'],'id_prefix' => 'new_products','truncate_products_name' => $this->_tpl_vars['TRUNCATE_PRODUCTS_NAME']), $this);?>

		<?php endif; ?>

	<?php else: ?>
		<div class="article-list rows clearfix">
		
		<?php $_from = $this->_tpl_vars['module_content']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['aussen'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['aussen']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['module_data']):
        $this->_foreach['aussen']['iteration']++;
?>
        <!-- start: product_listing_v1 -->    
		<div class="article_list_outer clearfix">
            <div class="article-list-item left clearfix">
                <form id="<?php echo $this->_tpl_vars['module_data']['FORM_DATA']['ID']; ?>
" action="<?php echo $this->_tpl_vars['module_data']['FORM_DATA']['ACTION_URL']; ?>
" method="<?php echo $this->_tpl_vars['module_data']['FORM_DATA']['METHOD']; ?>
">
                    <div class="article-list-item-inside">
                        <div class="article-list-item-image left" style="width:<?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE_WIDTH']; ?>
px;">
                            <div class="article-list-item-image-inline" style="width: <?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE_W']; ?>
px;">
                                <?php if ($this->_tpl_vars['module_data']['PRODUCTS_IMAGE'] != ''): ?><span id="prodlist_<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
" class="flyover_item"><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
"><img src="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_IMAGE']; ?>
" alt="<?php echo ((is_array($_tmp=@$this->_tpl_vars['module_data']['PRODUCTS_IMAGE_ALT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME'])); ?>
" title="<?php echo ((is_array($_tmp=@$this->_tpl_vars['module_data']['PRODUCTS_IMAGE_ALT'])) ? $this->_run_mod_handler('default', true, $_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME']) : smarty_modifier_default($_tmp, @$this->_tpl_vars['module_data']['PRODUCTS_NAME'])); ?>
" /></a></span><?php endif; ?>
                            </div>
                            <?php if ($this->_tpl_vars['module_data']['PRODUCTS_FSK18'] == 'true'): ?><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
img/fsk18.gif" alt="fsk18.gif" title="fsk18.gif" /><?php endif; ?>
                        </div>
                        <div class="article-list-item-main">
                            <h2>
                                <a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
" class="product_link"<?php if ($this->_tpl_vars['module_data']['PRODUCTS_META_DESCRIPTION'] != ''): ?> title="<?php echo ((is_array($_tmp=((is_array($_tmp=$this->_tpl_vars['module_data']['PRODUCTS_META_DESCRIPTION'])) ? $this->_run_mod_handler('truncate', true, $_tmp, 80, "...") : smarty_modifier_truncate($_tmp, 80, "...")))) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
"<?php endif; ?>><?php echo $this->_tpl_vars['module_data']['PRODUCTS_NAME']; ?>
</a>
                            </h2>
                            <p><?php echo $this->_tpl_vars['module_data']['PRODUCTS_SHORT_DESCRIPTION']; ?>
<br />
                                <?php if ($this->_tpl_vars['module_data']['GM_ATTRIBUTES']): ?>
                                    <?php echo $this->_tpl_vars['module_data']['GM_ATTRIBUTES']; ?>

                                    <?php if (! $this->_tpl_vars['module_data']['GM_GRADUATED_PRICES']): ?><br /><br /><?php endif; ?>
                                <?php endif; ?>
                                <?php if ($this->_tpl_vars['module_data']['GM_GRADUATED_PRICES']): ?><?php echo $this->_tpl_vars['module_data']['GM_GRADUATED_PRICES']; ?>
<?php endif; ?>
                            </p>
    
                        </div>
    
                        <div class="article-list-item-right">
                            <div class="article-list-item-price">
                                <span class="price"><a href="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_LINK']; ?>
">
                                    <span class="gm_price" id="gm_attr_calc_price_<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
">
                                        <?php echo $this->_tpl_vars['module_data']['PRODUCTS_PRICE']; ?>

                                        <?php if ($this->_tpl_vars['module_data']['PRODUCTS_VPE']): ?>
                                            <br /><span class="gm_products_vpe"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_VPE']; ?>
</span><br />
                                        <?php endif; ?>
                                    </span>
                                </a></span><?php if (! $this->_tpl_vars['module_data']['PRODUCTS_VPE']): ?><br /><?php endif; ?>
                                <?php if (( $this->_tpl_vars['module_data']['PRODUCTS_TAX_INFO'] != '' || $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_LINK'] != '' ) && $this->_tpl_vars['module_data']['GM_PRODUCTS_QTY']): ?>
                                    <span class="tax-shipping-text"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_TAX_INFO']; ?>
<?php echo $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_LINK']; ?>
</span><br />
                                <?php endif; ?>
                            </div>
                        </div>
    
                        <div class="article-list-item-bottom clearfix">
                            <?php if ($this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_NAME'] || $this->_tpl_vars['module_data']['PRODUCTS_QUANTITY'] || ( $this->_tpl_vars['module_data']['SHOW_PRODUCTS_WEIGHT'] && $this->_tpl_vars['module_data']['PRODUCTS_WEIGHT'] )): ?>
                            <div class="article-list-item-delivery">
                                <p>
                                    <?php if ($this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_NAME']): ?>
                                                                        <span class="label"><?php echo $this->_tpl_vars['txt']['text_shippingtime']; ?>
</span>
                                                                        <?php if ($this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_IMAGE']): ?>
                                                                                <span class="image_shippingtime"><img src="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_IMAGE']; ?>
" alt="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_NAME']; ?>
" /></span>
                                                                        <?php endif; ?>
                                                                        <?php echo $this->_tpl_vars['module_data']['PRODUCTS_SHIPPING_NAME']; ?>
<?php if ($this->_tpl_vars['GM_SHOW_QTY_INFO'] == '1' && $this->_tpl_vars['module_data']['GM_PRODUCTS_STOCK'] > 0): ?>,<?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($this->_tpl_vars['module_data']['PRODUCTS_QUANTITY']): ?>
                                        <span class="products_stock"><span class="label"><?php echo $this->_tpl_vars['txt']['text_products_stock']; ?>
</span><?php echo $this->_tpl_vars['module_data']['GM_PRODUCTS_STOCK']; ?>
 <?php if ($this->_tpl_vars['module_data']['UNIT']): ?><?php echo $this->_tpl_vars['module_data']['UNIT']; ?>
<?php else: ?><?php echo $this->_tpl_vars['txt']['text_pieces']; ?>
<?php endif; ?></span><?php if (( $this->_tpl_vars['GM_SHOW_QTY_INFO'] == '1' || $this->_tpl_vars['module_data']['GM_PRODUCTS_STOCK'] > 0 ) && $this->_tpl_vars['module_data']['SHOW_PRODUCTS_WEIGHT'] && $this->_tpl_vars['module_data']['PRODUCTS_WEIGHT']): ?>,<?php endif; ?>
                                    <?php endif; ?>
                                    <?php if ($this->_tpl_vars['module_data']['SHOW_PRODUCTS_WEIGHT'] && $this->_tpl_vars['module_data']['PRODUCTS_WEIGHT']): ?>
                                        <span class="label"><?php echo $this->_tpl_vars['info']['text_weight']; ?>
</span> <span id="gm_calc_weight_<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
"><?php echo $this->_tpl_vars['module_data']['PRODUCTS_WEIGHT']; ?>
</span> <?php echo $this->_tpl_vars['info']['text_weight_unit']; ?>

                                    <?php endif; ?>
                                </p>
                            </div>
                            <?php endif; ?>
    
    
                            <div style="width: auto; text-align: right;">
                                <div><span class="gm_checker_error" id="gm_checker_error_<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
"></span></div>
                                <?php if ($this->_tpl_vars['module_data']['GM_PRODUCTS_BUTTON_BUY_NOW'] && $this->_tpl_vars['module_data']['GM_PRODUCTS_QTY']): ?>
                                    
                                    <a href="<?php echo $this->_tpl_vars['module_data']['GM_PRODUCTS_BUTTON_BUY_NOW_URL']; ?>
" class="button_green button_set action_add_to_cart"<?php if ($this->_tpl_vars['module_data']['PRODUCTS_NAME'] != ''): ?> title="<?php echo ((is_array($_tmp=$this->_tpl_vars['module_data']['PRODUCTS_NAME'])) ? $this->_run_mod_handler('replace', true, $_tmp, '"', '&quot;') : smarty_modifier_replace($_tmp, '"', '&quot;')); ?>
 <?php echo $this->_tpl_vars['txt']['text_buy']; ?>
"<?php endif; ?>>
                                        <span class="button-outer">
                                            <span class="button-inner"><?php echo $this->_tpl_vars['button']['add_to_cart']; ?>
</span>
                                        </span>
                                    </a>
                                    <?php if ($this->_tpl_vars['module_data']['QTY_DATA']['VALUE'] != 1 || ( ( $this->_tpl_vars['GM_SHOW_QTY'] == '1' && $this->_tpl_vars['module_data']['GM_ATTRIBUTES'] ) || ( $this->_tpl_vars['GM_SHOW_QTY'] == '1' && $this->_tpl_vars['module_data']['GM_HAS_ATTRIBUTES'] == '0' ) )): ?>
                                        <span class="quantity_container">
                                            <?php if ($this->_tpl_vars['module_data']['UNIT']): ?><label for="<?php echo $this->_tpl_vars['module_data']['QTY_DATA']['ID']; ?>
" class="products_quantity_unit"><?php echo $this->_tpl_vars['module_data']['UNIT']; ?>
</label><?php endif; ?>
                                            <input type="<?php echo $this->_tpl_vars['module_data']['QTY_DATA']['TYPE']; ?>
" name="<?php echo $this->_tpl_vars['module_data']['QTY_DATA']['NAME']; ?>
" id="<?php echo $this->_tpl_vars['module_data']['QTY_DATA']['ID']; ?>
" class="article-count-input numeric input-text products_quantity <?php echo $this->_tpl_vars['module_data']['QTY_DATA']['CLASS']; ?>
" value="<?php echo $this->_tpl_vars['module_data']['QTY_DATA']['VALUE']; ?>
" />
                                        </span>
                                    <?php else: ?>
                                        <input type="hidden" name="<?php echo $this->_tpl_vars['HIDDEN_QTY_NAME']; ?>
" value="<?php echo $this->_tpl_vars['module_data']['QTY_DATA']['VALUE']; ?>
" />
                                    <?php endif; ?>
                                    <input type="hidden" class="gm_products_id" name="products_id" value="<?php echo $this->_tpl_vars['module_data']['PRODUCTS_ID']; ?>
" />
                                <?php endif; ?>
                            </div>
    
    
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- end: product_listing_v1 -->      
		<?php endforeach; endif; unset($_from); ?>
		</div>
	<?php endif; ?>

	<div class="panel clearfix">
		<form name="panel2" action="<?php echo $this->_tpl_vars['SORTING_FORM_ACTION_URL']; ?>
" method="get">
			<?php $_from = $this->_tpl_vars['get_params_hidden_data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array'); }$this->_foreach['hidden_fields2'] = array('total' => count($_from), 'iteration' => 0);
if ($this->_foreach['hidden_fields2']['total'] > 0):
    foreach ($_from as $this->_tpl_vars['hidden_data']):
        $this->_foreach['hidden_fields2']['iteration']++;
?>
				<input type="hidden" name="<?php echo $this->_tpl_vars['hidden_data']['NAME']; ?>
" value="<?php echo $this->_tpl_vars['hidden_data']['VALUE']; ?>
" />
			<?php endforeach; endif; unset($_from); ?>
			<div class="panel-sort left clearfix">
				<div class="input select">
					<label><?php echo $this->_tpl_vars['txt']['label_sort']; ?>
</label>
					<select name="listing_sort" class="input-select">
						<option value=""<?php if (! $this->_tpl_vars['SORT'] || $this->_tpl_vars['SORT'] == ''): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_select']; ?>
</option>
						<option value="price_asc"<?php if ($this->_tpl_vars['SORT'] == 'price_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_price_asc']; ?>
</option>
						<option value="price_desc"<?php if ($this->_tpl_vars['SORT'] == 'price_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_price_desc']; ?>
</option>
						<option value="name_asc"<?php if ($this->_tpl_vars['SORT'] == 'name_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_name_asc']; ?>
</option>
						<option value="name_desc"<?php if ($this->_tpl_vars['SORT'] == 'name_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_name_desc']; ?>
</option>
						<option value="date_asc"<?php if ($this->_tpl_vars['SORT'] == 'date_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_date_asc']; ?>
</option>
						<option value="date_desc"<?php if ($this->_tpl_vars['SORT'] == 'date_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_date_desc']; ?>
</option>
						<option value="shipping_asc"<?php if ($this->_tpl_vars['SORT'] == 'shipping_asc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_shipping_asc']; ?>
</option>
						<option value="shipping_desc"<?php if ($this->_tpl_vars['SORT'] == 'shipping_desc'): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['txt']['option_shipping_desc']; ?>
</option>
					</select>
				</div>
			</div>
			<div class="panel-itemcount left clearfix">
				<div class="input select">
					<label><?php echo $this->_tpl_vars['txt']['label_itemcount']; ?>
</label>
					<select name="listing_count" class="input-select">
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_1']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_1']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_1']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_2']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_2']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_2']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_3']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_3']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_3']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_4']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_4']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_4']; ?>
</option>
						<option value="<?php echo $this->_tpl_vars['COUNT_VALUE_5']; ?>
"<?php if ($this->_tpl_vars['ITEM_COUNT'] == $this->_tpl_vars['COUNT_VALUE_5']): ?> selected="selected"<?php endif; ?>><?php echo $this->_tpl_vars['COUNT_VALUE_5']; ?>
</option>
					</select>
				</div>
			</div>

			<div class="panel-viewmode left clearfix">
				<?php if ($this->_tpl_vars['VIEW_MODE'] == 'tiled'): ?>
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_DEFAULT']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_default_off.png" alt="" /></a>&nbsp;&nbsp;
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_TILED']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_tiled_on.png" alt="" /></a>
				<?php else: ?>
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_DEFAULT']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_default_on.png" alt="" /></a>&nbsp;&nbsp;
					<a href="<?php echo $this->_tpl_vars['VIEW_MODE_URL_TILED']; ?>
"><img class="png-fix" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
images/icons/view_mode_tiled_off.png" alt="" /></a>
				<?php endif; ?>
			</div>

		</form>
		<div class="panel-pagination right clearfix">
			<p><?php echo $this->_tpl_vars['NAVIGATION']; ?>
</p>
		</div>
	</div>

	<div class="panel-pagination-info right"><?php echo $this->_tpl_vars['NAVIGATION_INFO']; ?>
</div>
	
</div>
<!-- end: product_listing_v1 -->