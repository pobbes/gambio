<?php /* Smarty version 2.6.26, created on 2013-06-18 14:46:57
         compiled from sh-webshop/index.php */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/index.php', 1, false),array('function', 'pre_black_container', 'sh-webshop/index.php', 1, false),array('function', 'html_shop_offline', 'sh-webshop/index.php', 1, false),array('function', 'gm_menuboxes', 'sh-webshop/index.php', 53, false),array('function', 'gm_footer', 'sh-webshop/index.php', 299, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'index'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'top_navigation'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'infobox','name' => 'infobox'), $this);?>
<?php echo smarty_function_pre_black_container(array(), $this);?>
<?php if (SHOP_OFFLINE): ?><?php echo smarty_function_html_shop_offline(array(), $this);?>
<?php else: ?>

<!-- start: wrap_box -->
<div id="wrap_box" class="wrap_shop">
    <?php echo $this->_tpl_vars['TOP_NAVIGATION']; ?>
 
    <!-- start: container_inner -->
    <div id="container_inner" class="shadow">
        
        <noscript>
            <div class="noscript_notice"><?php echo $this->_tpl_vars['txt']['text_noscript_notice']; ?>
</div>
        </noscript>
        
        <!-- start: top_bg -->
        <div id="top_bg" class="top_bg_index">
            
            <div id="header_container">
                
                <a href="index.php" title="sh-webshop"><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/logo.png" alt="sh-webshop" width="613" height="157"></a>
                
                <!-- start: navigation -->
                <div id="navigation_container" class="left">
                    <?php echo smarty_function_load_language_text(array('section' => 'box_specials'), $this);?>

                    <ul class="navigation_list">                
                        <li><a href="<?php echo $this->_tpl_vars['content_data']['HOME_URL']; ?>
">home</a></li>
                        <li><a href="http://sh-webshop.com/info/mein-kontakt.html">kontakt</a></li>
                        <li><a href="specials.php"><?php echo $this->_tpl_vars['txt']['heading_specials']; ?>
</a></li>
                        <li id="search"><?php echo $this->_tpl_vars['TOP_SEARCH']; ?>

                        </li>
                    </ul>     
                    
                </div>
                <!-- end: navigation -->   
                
                <img id="shipping_icn" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/shipping.jpg" alt="free shipping" width="250" height="120">                    
                <?php echo $this->_tpl_vars['USERMENU']; ?>
                                        
                <?php echo $this->_tpl_vars['SHOPPING_CART_HEAD']; ?>

                </div>
                <!-- end: user_menu -->
            
            </div>
        
        </div>
        <!-- end: top_bg -->    
    
        <!-- start: bottom_bg -->
        <div id="bottom_bg">
        
            <!-- start: content_container -->
            <div id="content_container">                
                
                <div id="sidebar" class="left clearfix">  
                <?php echo $this->_tpl_vars['CATEGORIES']; ?>
                            
                <?php echo smarty_function_gm_menuboxes(array('first' => 1,'last' => 100,'html' => '<div id="gm_box_pos_[COUNTER]" class="gm_box_container">[CONTENT]</div>'), $this);?>

                </div>
                
                <!-- start: main_content -->
                <div id="main_content" class="right">            
                
                    <!-- start: news_container -->
                    <div id="news_container" class="left">
                        
                        <div class="module_heading_2"><span>News</span></div>
                        
                        <!-- start: slider_container -->
                        <div id="bannerRotator_classic" style="display:none;">
                                
                            <!-- images -->
                            <?php echo '<?php'; ?>
 
                
                            include('../slideradmin/includes/db_functions.inc.php');
                    
                            $final_slides = getFinalSlides();
                    
                            while($final_slides_row = mysql_fetch_array($final_slides, MYSQL_ASSOC))
                            <?php echo $this->_tpl_vars['final_slides_id']; ?>
 
                            
                            echo "fuck gambio";
                            
                            <?php echo '?>'; ?>
 
                            
                            
                                                                
                            <div id="banner_welcome" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_welcome_1" data-initial-left="2" data-initial-top="10" data-final-left="2" data-final-top="10" 
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    WILLKOMMEN
                                </div>
                               
                                <div class="bannerRotator_text_line banner_welcome_2" data-initial-left="260" data-initial-top="10" data-final-left="260" data-final-top="10"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    bei sh-webshop
                                </div>
                                
                                <div class="bannerRotator_text_line banner_welcome_3" data-initial-left="2" data-initial-top="60" data-final-left="2" data-final-top="60" 
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    WIR haben f&uuml;r
                                </div>
                                
                                <div class="bannerRotator_text_line banner_welcome_4" data-initial-left="260" data-initial-top="60" data-final-left="260" data-final-top="60"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    SIE
                                </div>
                                
                                <div class="bannerRotator_text_line banner_welcome_5" data-initial-left="2" data-initial-top="120" data-final-left="2" data-final-top="120" 
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    die HOMEPAGE<br/> aktualisiert
                                </div>
                                
                                <div class="bannerRotator_text_line banner_welcome_6" data-initial-left="290" data-initial-top="120" data-final-left="290" data-final-top="120"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    das SORTIMENT<br/> erweitert
                                </div>
                            </div> 
                                
                            <div id="banner_offer_1" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_offer_heading" data-initial-left="50" data-initial-top="10" data-final-left="50" data-final-top="5"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    FL-520 E-Gitarre, fretless Perdesiz Gitar
                                    mit Video
                                </div>
                                
                                <div class="bannerRotator_text_line banner_old_price" data-initial-left="340" data-initial-top="120" data-final-left="340" data-final-top="120"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    229,99 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="50" data-initial-top="80" data-final-left="250" data-final-top="80"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    169,99 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_button" data-initial-left="270" data-initial-top="180" data-final-left="270" data-final-top="180"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    <a href="http://sh-webshop.com/saz-Baglama/Gitarren/E-Gitarre/FL-520-E-Gitarre--fretless-Schwarz-SH26215565.html" target="_blank">zum Angebot</a>
                                </div>                                    
                            </div>  
                            
                            <div id="banner_offer_2" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_offer_heading" data-initial-left="200" data-initial-top="10" data-final-left="200" data-final-top="5"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    Rahmentrommel - Bendir
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="340" data-initial-top="120" data-final-left="340" data-final-top="120"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    178,90 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="50" data-initial-top="80" data-final-left="250" data-final-top="80"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    10% billiger
                                </div>
                                
                                <div class="bannerRotator_text_line banner_button" data-initial-left="270" data-initial-top="180" data-final-left="270" data-final-top="180"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    <a href="http://sh-webshop.com/Schlaginstrumente/archiv/Rahmentrommel-Bendir-157-158-160-161-261-262.html" target="_blank">zum Angebot</a>
                                </div>                
                            </div>  
                                
                            <div id="banner_offer_3" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_offer_heading" data-initial-left="50" data-initial-top="10" data-final-left="50" data-final-top="5"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    Kiz Ney Bambus Fl&ouml;te
                                </div>
                                
                                <div class="bannerRotator_text_line banner_old_price" data-initial-left="340" data-initial-top="120" data-final-left="340" data-final-top="120"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    59,99 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="50" data-initial-top="80" data-final-left="250" data-final-top="80"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    49,90 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_button" data-initial-left="270" data-initial-top="180" data-final-left="270" data-final-top="180"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    <a href="http://sh-webshop.com/Blasinstrumente/Floete-Ney-Kaval/Kiz-Ney-Bambus-Floete-79.html" target="_blank">zum Angebot</a>
                                </div>  
                            </div>
                            
                            <div id="banner_offer_4" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_offer_heading" data-initial-left="200" data-initial-top="10" data-final-left="200" data-final-top="5"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    Davul Trommel 25 cm
                                </div>
                                
                                <div class="bannerRotator_text_line banner_old_price" data-initial-left="370" data-initial-top="120" data-final-left="370" data-final-top="120"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    29,99 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="50" data-initial-top="80" data-final-left="330" data-final-top="80"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    19,00 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_button" data-initial-left="270" data-initial-top="180" data-final-left="270" data-final-top="180"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    <a href="http://sh-webshop.com/Schlaginstrumente/Davul-Pauke/Davul-Trommel-7-8-40-126-127-265.html" target="_blank">zum Angebot</a>
                                </div>  
                            </div>  
                            
                            <div id="banner_offer_5" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_offer_heading" data-initial-left="50" data-initial-top="10" data-final-left="50" data-final-top="5"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    OMNITRONIC LS-1222A Live-Power-Mixer 2 x 300 W
                                </div>
                                
                                <div class="bannerRotator_text_line banner_old_price" data-initial-left="340" data-initial-top="120" data-final-left="340" data-final-top="120"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    319,90 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="50" data-initial-top="80" data-final-left="260" data-final-top="80"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    289,90 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_button" data-initial-left="270" data-initial-top="180" data-final-left="270" data-final-top="180"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    <a href="http://sh-webshop.com/Buehnentechnik/Verstaerker/OMNITRONIC-LS-1222A-Live-Power-Mixer-2-x-300-W.html" target="_blank">zum Angebot</a>
                                </div>  
                            </div>  
                            
                            <div id="banner_offer_6" class="bannerRotator_texts">
                                <div class="bannerRotator_text_line banner_offer_heading" data-initial-left="50" data-initial-top="10" data-final-left="50" data-final-top="5"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    K-26 Bb Klarinette, 26 Klappen
                                </div>
                                
                                <div class="bannerRotator_text_line banner_old_price" data-initial-left="360" data-initial-top="150" data-final-left="360" data-final-top="150"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    279,90 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_new_price" data-initial-left="50" data-initial-top="110" data-final-left="270" data-final-top="110"
                                    data-duration="0.5" data-fade-start="0" data-delay="0.3">
                                    249,00 EUR
                                </div>
                                
                                <div class="bannerRotator_text_line banner_button" data-initial-left="270" data-initial-top="180" data-final-left="270" data-final-top="180"
                                    data-duration="0.5" data-fade-start="0" data-delay="0">
                                    <a href="http://sh-webshop.com/Blasinstrumente/Klarinette/K-17H-Bb-Klarinette--aus-hochwertigem-Palisander-315.html" target="_blank">zum Angebot</a>
                                </div>  
                            </div>  
                            
                        </div>  
                        <!-- end: slider_container -->                          
                        
                    </div>
                    <!-- end: news_container -->
                
                    <!-- start: support_container -->
                    <div id="support_container" class="right">
                        
                        <div class="module_heading"><span>Support</span></div>
                        
                        <div class="support clear">                            
                            <span id="support_txt">besuchen sie uns auch auf</span>   
                            
                            <div id="support_img">
                                <img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/facebook_icn.png" height="98" width="98" alt="facebook_icn" />
                            </div>         
                            
                            <div id="support_btn">
                                <a href="https://www.facebook.com/ShWebshop">Facebook</a>
                            </div>                                
                        </div>  
                        
                    </div>
                    <!-- end: support_container -->
                
                    <div id="breadcrumb_navi" class="left">
                        <span>&#187; <?php echo $this->_tpl_vars['navtrail']; ?>
</span>
                    </div>
                
                    <!-- start: products_container -->
                    <div id="products_container" class="clear">
                    <?php echo $this->_tpl_vars['main_content']; ?>
                                 
                    </div>
                    <!-- end: products_container --> 
                
                </div>
                <!-- end: main_content -->
            
            </div>
            <!-- end: content_container -->       
            <?php echo smarty_function_gm_footer(array(), $this);?>
        
        </div>
        <!-- end: bottom_bg -->
    
    </div> 
    <!-- end: container_inner -->

    <?php echo $this->_tpl_vars['SHOPPING_CART_DROPDOWN']; ?>

    <?php echo $this->_tpl_vars['LOGIN_DROPDOWN']; ?>

    <?php echo $this->_tpl_vars['INFOBOX_DROPDOWN']; ?>

    <?php echo $this->_tpl_vars['CURRENCIES_DROPDOWN']; ?>

    <?php echo $this->_tpl_vars['LANGUAGES_DROPDOWN']; ?>

</div>  
<!-- end: wrap_box -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.5.1/jquery.min.js"></script>
<?php endif; ?>