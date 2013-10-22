<?php /* Smarty version 2.6.26, created on 2013-06-24 16:47:27
         compiled from sh-webshop/home.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'sh-webshop/home.html', 1, false),array('function', 'pre_black_container', 'sh-webshop/home.html', 1, false),array('function', 'html_shop_offline', 'sh-webshop/home.html', 1, false),array('function', 'gm_menuboxes', 'sh-webshop/home.html', 93, false),array('function', 'show_slides', 'sh-webshop/home.html', 107, false),array('function', 'gm_footer', 'sh-webshop/home.html', 150, false),)), $this); ?>
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
        <div id="top_bg" class="top_bg_home">
            
            <div id="header_container">
                                
                <a href="index.php" title="sh-webshop"><img src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/logo.png" alt="sh-webshop" width="613" height="157"></a>
                
                <!-- start: navigation -->
                <div id="navigation_container" class="left"><?php echo smarty_function_load_language_text(array('section' => 'box_specials'), $this);?>

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
        
            <!-- start: carousel_container -->
            <div id="carousel_container">
                
                <!-- start: allinone_carousel_powerful -->
                <div id="carousel_powerful">                
                    <ul class="carousel_list">                          
                        <li data-title="1">
                            <a href="http://sh-webshop.com/Blasinstrumente/"><img class="carousel_violet" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/01.jpg" width="233" height="524" alt="1" /></a>
                        </li>                            
                        <li data-title="2">
                            <a href="http://sh-webshop.com/Buehnentechnik/"><img class="carousel_orange" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/02.jpg" width="233" height="524" alt="2" /></a>
                        </li>                            
                        <li data-title="3">
                            <a href="http://sh-webshop.com/saz-Baglama/"><img class="carousel_yellow" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/03.jpg" width="233" height="524" alt="3" /></a>
                        </li>                             
                        <li data-title="4">
                            <a href="http://sh-webshop.com/Schlaginstrumente/"><img class="carousel_red" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/04.jpg" width="233" height="524" alt="4" /></a>
                        </li>                            
                        <li data-title="5">
                            <a href="http://sh-webshop.com/Zubehoer/"><img class="carousel_green" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/05.jpg" width="233" height="524" alt="5" /></a>
                        </li>                            
                        <li data-title="6">
                            <a href="http://sh-webshop.com/Blasinstrumente/"><img class="carousel_violet" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/01.jpg" width="233" height="524" alt="6" /></a>
                        </li>                            
                        <li data-title="7">
                            <a href="http://sh-webshop.com/Buehnentechnik/"><img class="carousel_orange" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/02.jpg" width="233" height="524" alt="7" /></a>
                        </li>                            
                        <li data-title="8">
                            <a href="http://sh-webshop.com/saz-Baglama/"><img class="carousel_yellow" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/03.jpg" width="233" height="524" alt="8" /></a>
                        </li>                             
                        <li data-title="9">
                            <a href="http://sh-webshop.com/Schlaginstrumente/"><img class="carousel_red" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/04.jpg" width="233" height="524" alt="9" /></a>
                        </li>                            
                        <li data-title="10">
                            <a href="http://sh-webshop.com/Zubehoer/"><img class="carousel_green" src="<?php echo $this->_tpl_vars['tpl_path']; ?>
/images/carousel/05.jpg" width="233" height="524" alt="10" /></a>
                        </li>                       
                    </ul>
                </div> 
                <!-- end: allinone_carousel_powerful --> 
                
            </div>
            <!-- end: carousel_container -->
        
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
                                
                            <?php echo smarty_function_show_slides(array(), $this);?>
                                                            
                            
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