<?php /* Smarty version 2.6.26, created on 2013-05-10 18:36:15
         compiled from C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_top_search.html */ ?>
<?php require_once(SMARTY_CORE_DIR . 'core.load_plugins.php');
smarty_core_load_plugins(array('plugins' => array(array('function', 'load_language_text', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_top_search.html', 1, false),array('function', 'page_url', 'C:/xampp/htdocs/gambio/templates/sh-webshop/boxes/box_top_search.html', 8, false),)), $this); ?>
<?php echo smarty_function_load_language_text(array('section' => 'box_search'), $this);?>
<?php echo smarty_function_load_language_text(array('section' => 'buttons','name' => 'button'), $this);?>

                            <!-- start: box_top_search -->
                            <div>
                                <form action="<?php echo $this->_tpl_vars['content_data']['FORM_ACTION_URL']; ?>
" method="<?php echo $this->_tpl_vars['content_data']['FORM_METHOD']; ?>
">
                                    <div class="control-group">                                    
                                        <div class="controls">
                                            <input type="text" name="<?php echo $this->_tpl_vars['content_data']['INPUT_NAME']; ?>
" value="<?php echo $this->_tpl_vars['txt']['text_default_value']; ?>
" class="input-text box-input-field default_value left" id="search_field" autocomplete="off" />                                                    
                                            <a href="<?php echo smarty_function_page_url(array(), $this);?>
#" class="action_submit top_search_btn left" title="<?php echo $this->_tpl_vars['txt']['title_search']; ?>
"></a>                                                
                                            <input type="hidden" name="XTCsid" value="<?php echo $this->_tpl_vars['session_id_placeholder']; ?>
" />     
                                        </div>                                    
                                    </div>                              
                                </form>     
                            </div>
                            <!-- end: box_top_search -->