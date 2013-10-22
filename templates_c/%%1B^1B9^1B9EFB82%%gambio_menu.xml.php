<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:06
         compiled from C:/xampp/htdocs/gambio/system/conf/AdminMenu/gambio_menu.xml */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/system/conf/AdminMenu/gambio_menu.xml', 4, false),)), $this); ?>
<?php echo '<?xml'; ?>
 version="1.0"<?php echo '?>'; ?>

<!-- <?php echo smarty_function_load_language_text(array('section' => 'admin_menu'), $this);?>
 -->
<admin_menu>
	<menugroup id="BOX_HEADING_FAVORITES" sort="10" background="favs.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_FAVS']; ?>
">
	</menugroup>
	
	<menugroup id="BOX_HEADING_GAMBIO" sort="20" background="gambio.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_LAYOUT_DESIGN']; ?>
">
		<menuitem sort="10" link="FILENAME_GM_LIGHTBOX" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_LIGHTBOX']; ?>
" />
		<menuitem sort="20" link="FILENAME_GM_LOGO" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_LOGO']; ?>
" />
		<menuitem sort="30" link="FILENAME_GM_SLIDER" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_SLIDER']; ?>
" />
		<menuitem sort="40" link="FILENAME_GM_STYLE_EDIT" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_STYLE_EDIT']; ?>
" />
	</menugroup>
	
	<menugroup id="BOX_HEADING_GAMBIO_SEO" sort="30" background="gambio.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_GAMBIO_SEO']; ?>
">
		<menuitem sort="10" link="FILENAME_GM_SEO_BOOST" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_SEO_BOOST']; ?>
" />		
		<menuitem sort="20" link="FILENAME_GM_META" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_META']; ?>
" />
		<menuitem sort="30" link="FILENAME_ROBOTS_DOWNLOAD" title="<?php echo $this->_tpl_vars['txt']['BOX_ROBOTS']; ?>
" />
		<menuitem sort="40" link="FILENAME_GM_SITEMAP" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_SITEMAP']; ?>
" />
		<menuitem sort="50" link="FILENAME_GM_BOOKMARKS" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_BOOKMARKS']; ?>
" />
		<menuitem sort="60" link="FILENAME_GM_ANALYTICS" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_ANALYTICS']; ?>
" />
	</menugroup>
	
	<menugroup id="BOX_HEADING_CUSTOMERS" sort="40" background="kunden.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_CUSTOMERS']; ?>
">
		<menuitem sort="10" link="FILENAME_ORDERS" title="<?php echo $this->_tpl_vars['txt']['BOX_ORDERS']; ?>
" />
		<menuitem sort="20" link="FILENAME_CUSTOMERS" title="<?php echo $this->_tpl_vars['txt']['BOX_CUSTOMERS']; ?>
" />
		<menuitem sort="30" link="FILENAME_GM_MODULE_EXPORT" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_MODULE_EXPORT']; ?>
" />
		<menuitem sort="40" link="FILENAME_CUSTOMERS_STATUS" title="<?php echo $this->_tpl_vars['txt']['BOX_CUSTOMERS_STATUS']; ?>
" />
		<menuitem sort="50" link="FILENAME_GM_INVOICING" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_INVOICING']; ?>
" />
	</menugroup>

	<menugroup id="BOX_HEADING_PRODUCTS" sort="50" background="artkatalog.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_PRODUCTS']; ?>
">
		<menuitem sort="10" link="FILENAME_GM_FEATURE_CONTROL" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_FEATURE_CONTROL']; ?>
" />
		<menuitem sort="20" link="FILENAME_CATEGORIES" title="<?php echo $this->_tpl_vars['txt']['BOX_CATEGORIES']; ?>
" />
		<menuitem sort="30" link="FILENAME_PRODUCTS_ATTRIBUTES" title="<?php echo $this->_tpl_vars['txt']['BOX_PRODUCTS_ATTRIBUTES']; ?>
" />
		<menuitem sort="40" link="FILENAME_REVIEWS" title="<?php echo $this->_tpl_vars['txt']['BOX_REVIEWS']; ?>
" />
		<menuitem sort="50" link="FILENAME_PROPERTIES" title="<?php echo $this->_tpl_vars['txt']['BOX_PROPERTIES']; ?>
" />
		<menuitem sort="60" link="FILENAME_GM_PRODUCT_EXPORT" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_PRODUCT_EXPORT']; ?>
" />
		<menuitem sort="70" link="FILENAME_NEW_ATTRIBUTES" title="<?php echo $this->_tpl_vars['txt']['BOX_ATTRIBUTES_MANAGER']; ?>
" />
		<menuitem sort="80" link="csv_backend.php" title="<?php echo $this->_tpl_vars['txt']['BOX_IMPORT']; ?>
" />
		<menuitem sort="90" link="FILENAME_PRODUCTS_EXPECTED" title="<?php echo $this->_tpl_vars['txt']['BOX_PRODUCTS_EXPECTED']; ?>
" />
		<menuitem sort="100" link="FILENAME_GM_GPRINT" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_GPRINT']; ?>
" />
		<menuitem sort="110" link="FILENAME_MANUFACTURERS" title="<?php echo $this->_tpl_vars['txt']['BOX_MANUFACTURERS']; ?>
" />
		<menuitem sort="120" link="FILENAME_QUANTITYUNITS" title="<?php echo $this->_tpl_vars['txt']['BOX_QUANTITYUNITS']; ?>
" />
		<menuitem sort="130" link="FILENAME_SPECIALS" title="<?php echo $this->_tpl_vars['txt']['BOX_SPECIALS']; ?>
" />
	</menugroup>

	<menugroup id="BOX_HEADING_MODULES" sort="70" background="module.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_MODULES']; ?>
">
		<menuitem sort="10" link="econda.php" title="<?php echo $this->_tpl_vars['txt']['BOX_ECONDA']; ?>
" />
		<menuitem sort="20" link="FILENAME_EKOMI" title="eKomi" />
		<menuitem sort="40" link="FILENAME_GM_JANOLAW" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_JANOLAW']; ?>
" />
		<menuitem sort="50" link="lettr_de.php" title="Lettr.de Mailer" />
		<menuitem sort="60" link="FILENAME_MODULE_EXPORT" title="<?php echo $this->_tpl_vars['txt']['BOX_MODULE_EXPORT']; ?>
" />
		<menuitem sort="70" link="FILENAME_GM_SCROLLER" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_SCROLLER']; ?>
" />
		<menuitem sort="80" link="paypal.php" title="<?php echo $this->_tpl_vars['txt']['BOX_PAYPAL']; ?>
" />
		<menuitem sort="90" link="FILENAME_GM_TRUSTED_SHOP_ID" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_TRUSTED_SHOP_ID']; ?>
" />
		<menuitem sort="100" link="FILENAME_GM_TRUSTED_SHOPS_WIDGET" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_TRUSTED_WIDGET']; ?>
" />
		<menuitem sort="110" link="FILENAME_MODULES" link_param="set=shipping" title="<?php echo $this->_tpl_vars['txt']['BOX_SHIPPING']; ?>
" />
		<menuitem sort="120" link="yatego.php" title="<?php echo $this->_tpl_vars['txt']['BOX_YATEGO']; ?>
" />
		<menuitem sort="130" link="yoochoose.php" title="<?php echo $this->_tpl_vars['txt']['BOX_YOOCHOOSE']; ?>
" />
		<menuitem sort="140" link="FILENAME_MODULES" link_param="set=payment" title="<?php echo $this->_tpl_vars['txt']['BOX_PAYMENT']; ?>
" />
		<menuitem sort="150" link="FILENAME_MODULES" link_param="set=ordertotal" title="<?php echo $this->_tpl_vars['txt']['BOX_ORDER_TOTAL']; ?>
" />
	</menugroup>

	<menugroup id="BOX_HEADING_STATISTICS" sort="80" background="statistik.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_STATISTICS']; ?>
">
		<menuitem sort="10" link="FILENAME_GM_COUNTER" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_COUNTER']; ?>
" />
		<menuitem sort="20" link="FILENAME_STATS_PRODUCTS_VIEWED" title="<?php echo $this->_tpl_vars['txt']['BOX_PRODUCTS_VIEWED']; ?>
" />
		<menuitem sort="30" link="FILENAME_CAMPAIGNS_REPORT" title="<?php echo $this->_tpl_vars['txt']['BOX_CAMPAIGNS_REPORT']; ?>
" />
		<menuitem sort="40" link="FILENAME_STATS_CUSTOMERS" title="<?php echo $this->_tpl_vars['txt']['BOX_STATS_CUSTOMERS']; ?>
" />
		<menuitem sort="50" link="FILENAME_SALES_REPORT" title="<?php echo $this->_tpl_vars['txt']['BOX_SALES_REPORT']; ?>
" />
		<menuitem sort="60" link="FILENAME_STATS_PRODUCTS_PURCHASED" title="<?php echo $this->_tpl_vars['txt']['BOX_PRODUCTS_PURCHASED']; ?>
" />
	</menugroup>
	
	<menugroup id="BOX_HEADING_XTBOOSTER" sort="100" background="module.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_XTBOOSTER']; ?>
">
		<menuitem sort="10" link="FILENAME_XTBOOSTER" link_param="xtb_module=list" title="<?php echo $this->_tpl_vars['txt']['BOX_XTBOOSTER_LISTAUCTIONS']; ?>
" />
		<menuitem sort="20" link="FILENAME_XTBOOSTER" link_param="xtb_module=add" title="<?php echo $this->_tpl_vars['txt']['BOX_XTBOOSTER_ADDAUCTIONS']; ?>
" />
		<menuitem sort="30" link="FILENAME_GM_EBAY" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_EBAY']; ?>
" />
		<menuitem sort="40" link="FILENAME_XTBOOSTER" link_param="xtb_module=conf" title="<?php echo $this->_tpl_vars['txt']['BOX_XTBOOSTER_CONFIG']; ?>
" />
	</menugroup>

	<menugroup id="BOX_HEADING_TOOLS" sort="110" background="hilfsprogr1.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_TOOLS']; ?>
">
		<menuitem sort="10" link="FILENAME_BANNER_MANAGER" title="<?php echo $this->_tpl_vars['txt']['BOX_BANNER_MANAGER']; ?>
" />
		<menuitem sort="20" link="FILENAME_CLEAR_CACHE" title="<?php echo $this->_tpl_vars['txt']['BOX_CLEAR_CACHE']; ?>
" />
		<menuitem sort="30" link="FILENAME_CONTENT_MANAGER" title="<?php echo $this->_tpl_vars['txt']['BOX_CONTENT']; ?>
" />
		<menuitem sort="40" link="FILENAME_GM_BACKUP_FILES_ZIP" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_BACKUP_FILES_ZIP']; ?>
" />
		<menuitem sort="50" link="FILENAME_BACKUP" title="<?php echo $this->_tpl_vars['txt']['BOX_BACKUP']; ?>
" />
		<menuitem sort="60" link="FILENAME_BLACKLIST" title="<?php echo $this->_tpl_vars['txt']['BOX_TOOLS_BLACKLIST']; ?>
" />
		<menuitem sort="70" link="FILENAME_SHOW_LOGS" title="<?php echo $this->_tpl_vars['txt']['BOX_SHOW_LOGS']; ?>
" />
		<menuitem sort="80" link="FILENAME_MODULE_NEWSLETTER" title="<?php echo $this->_tpl_vars['txt']['BOX_MODULE_NEWSLETTER']; ?>
" />
		<menuitem sort="90" link="FILENAME_GM_OPENSEARCH" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_OPENSEARCH']; ?>
" />
		<menuitem sort="100" link="FILENAME_SERVER_INFO" title="<?php echo $this->_tpl_vars['txt']['BOX_SERVER_INFO']; ?>
" />
		<menuitem sort="110" link="FILENAME_GM_OFFLINE" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_OFFLINE']; ?>
" />
		<menuitem sort="120" link="FILENAME_GM_SQL" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_SQL']; ?>
" />
		<menuitem sort="130" link="FILENAME_GM_LANG_EDIT" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_LANG_EDIT']; ?>
" />
		<menuitem sort="140" link="FILENAME_WHOS_ONLINE" title="<?php echo $this->_tpl_vars['txt']['BOX_WHOS_ONLINE']; ?>
" />
	</menugroup>
	
	<menugroup id="BOX_HEADING_GV_ADMIN" sort="120" background="hilfsprogr2.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_GV_ADMIN']; ?>
">
		<menuitem sort="10" link="FILENAME_GV_MAIL" title="<?php echo $this->_tpl_vars['txt']['BOX_GV_ADMIN_MAIL']; ?>
" />
		<menuitem sort="20" link="FILENAME_GV_QUEUE" title="<?php echo $this->_tpl_vars['txt']['BOX_GV_ADMIN_QUEUE']; ?>
" />
		<menuitem sort="30" link="FILENAME_GV_SENT" title="<?php echo $this->_tpl_vars['txt']['BOX_GV_ADMIN_SENT']; ?>
" />
		<menuitem sort="40" link="FILENAME_COUPON_ADMIN" title="<?php echo $this->_tpl_vars['txt']['BOX_COUPON_ADMIN']; ?>
" />
	</menugroup>

	<menugroup id="BOX_HEADING_ZONE" sort="130" background="land.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_ZONE']; ?>
">
		<menuitem sort="10" link="FILENAME_ZONES" title="<?php echo $this->_tpl_vars['txt']['BOX_ZONES']; ?>
" />
		<menuitem sort="20" link="FILENAME_COUNTRIES" title="<?php echo $this->_tpl_vars['txt']['BOX_COUNTRIES']; ?>
" />
		<menuitem sort="30" link="FILENAME_LANGUAGES" title="<?php echo $this->_tpl_vars['txt']['BOX_LANGUAGES']; ?>
" />
		<menuitem sort="40" link="FILENAME_TAX_CLASSES" title="<?php echo $this->_tpl_vars['txt']['BOX_TAX_CLASSES']; ?>
" />
		<menuitem sort="50" link="FILENAME_TAX_RATES" title="<?php echo $this->_tpl_vars['txt']['BOX_TAX_RATES']; ?>
" />
		<menuitem sort="60" link="FILENAME_GEO_ZONES" title="<?php echo $this->_tpl_vars['txt']['BOX_GEO_ZONES']; ?>
" />
		<menuitem sort="70" link="FILENAME_CURRENCIES" title="<?php echo $this->_tpl_vars['txt']['BOX_CURRENCIES']; ?>
" />
	</menugroup>

	<menugroup id="BOX_HEADING_CONFIGURATION" sort="140" background="meinshop.png" title="<?php echo $this->_tpl_vars['txt']['BOX_HEADING_CONFIGURATION']; ?>
">
		<menuitem sort="10" link="FILENAME_GM_MISCELLANEOUS" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_MISCELLANEOUS']; ?>
" />
		<menuitem sort="20" link="FILENAME_CONFIGURATION" link_param="gID=8" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_8']; ?>
" />
		<menuitem sort="30" link="FILENAME_ORDERS_STATUS" title="<?php echo $this->_tpl_vars['txt']['BOX_ORDERS_STATUS']; ?>
" />
		<menuitem sort="40" link="FILENAME_CONFIGURATION" link_param="gID=4" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_4']; ?>
" />
		<menuitem sort="50" link="FILENAME_CONFIGURATION" link_param="gID=11" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_11']; ?>
" />
		<menuitem sort="60" link="FILENAME_XSELL_GROUPS" title="<?php echo $this->_tpl_vars['txt']['BOX_ORDERS_XSELL_GROUP']; ?>
" />
		<menuitem sort="70" link="FILENAME_CONFIGURATION" link_param="gID=13" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_13']; ?>
" />
		<menuitem sort="80" link="FILENAME_CONFIGURATION" link_param="gID=12" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_12']; ?>
" />
		<menuitem sort="90" link="FILENAME_GM_EMAILS" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_EMAILS']; ?>
" />
		<menuitem sort="100" link="FILENAME_CONFIGURATION" link_param="gID=14" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_14']; ?>
" />
		<menuitem sort="110" link="FILENAME_CAMPAIGNS" title="<?php echo $this->_tpl_vars['txt']['BOX_CAMPAIGNS']; ?>
" />
		<menuitem sort="120" link="FILENAME_CONFIGURATION" link_param="gID=5" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_5']; ?>
" />
		<menuitem sort="130" link="FILENAME_CONFIGURATION" link_param="gID=9" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_9']; ?>
" />
		<menuitem sort="140" link="FILENAME_SHIPPING_STATUS" title="<?php echo $this->_tpl_vars['txt']['BOX_SHIPPING_STATUS']; ?>
" />
		<menuitem sort="150" link="FILENAME_CONFIGURATION" link_param="gID=10" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_10']; ?>
" />
		<menuitem sort="160" link="FILENAME_CONFIGURATION" link_param="gID=3" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_3']; ?>
" />
		<menuitem sort="170" link="FILENAME_CONFIGURATION" link_param="gID=1" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_1']; ?>
" />
		<menuitem sort="180" link="FILENAME_CONFIGURATION" link_param="gID=2" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_2']; ?>
" />
		<menuitem sort="190" link="FILENAME_GM_ID_STARTS" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_ID_STARTS']; ?>
" />
		<menuitem sort="200" link="FILENAME_GM_PDF" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_PDF']; ?>
" />
		<menuitem sort="210" link="FILENAME_CONFIGURATION" link_param="gID=19" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_19']; ?>
" />
		<menuitem sort="220" link="FILENAME_CONFIGURATION" link_param="gID=15" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_15']; ?>
" />
		<menuitem sort="230" link="FILENAME_GM_SECURITY" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_SECURITY']; ?>
" />
		<menuitem sort="240" link="FILENAME_GM_STATUSBAR" title="<?php echo $this->_tpl_vars['txt']['BOX_GM_STATUSBAR']; ?>
" />
		<menuitem sort="250" link="FILENAME_CONFIGURATION" link_param="gID=22" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_22']; ?>
" />
		<menuitem sort="260" link="FILENAME_CONFIGURATION" link_param="gID=16" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_16']; ?>
" />
		<menuitem sort="270" link="FILENAME_CONFIGURATION" link_param="gID=18" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_18']; ?>
" />
		<menuitem sort="280" link="FILENAME_PRODUCTS_VPE" title="<?php echo $this->_tpl_vars['txt']['BOX_PRODUCTS_VPE']; ?>
" />
		<menuitem sort="290" link="FILENAME_CONFIGURATION" link_param="gID=7" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_7']; ?>
" />
		<menuitem sort="300" link="FILENAME_CONFIGURATION" link_param="gID=17" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_17']; ?>
" />
		<menuitem sort="301" link="FILENAME_CONFIGURATION" link_param="gID=753" title="<?php echo $this->_tpl_vars['txt']['BOX_CONFIGURATION_753']; ?>
" />
	</menugroup>
</admin_menu>