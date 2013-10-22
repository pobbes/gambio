<?php
/* --------------------------------------------------------------
   gm_style_edit.php 2011-03-08 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?>
<?php
	define('HEADING_TITLE', 'Template Settings');
	define('HEADING_SUB_TITLE', 'Gambio');
	
	define('GM_FRONT_STYLE', 'Edit store design');
	
	define('GM_FORM_SUBMIT', 'Save');	
	
	define('GM_LOAD_EDIT_MODE', 'Load store in edit mode');
	define('GM_LOAD_SOS_MODE', 'Load store in recovery mode');
	define('GM_NO_STYLE_EDIT_INSTALLED_TEXT', 'StyleEdit is not installed.<br /><br />');
	
	define('GM_CART_ON_TOP', 'Shopping cart undocked');	
	define('GM_SHOW_WISHLIST', 'Activate wishlist');
	define('GM_TOPMENU_MODE', 'Separate path trail and quick search');
    define('GM_SHOW_QUICK_SEARCH', 'Show quick search');
	define('GM_GAMBIO_CORNER', 'Show Gambio corner');
	define('GM_SHOW_FLYOVER', 'Show flyover (products on startpage, in categories, cross-sell, reverse-cross-sell and purchased products)');	
	define('GM_SPECIALS_STARTPAGE', 'Maximum count of specials on startpage');	
	define('GM_NEW_PRODUCTS_STARTPAGE', 'Maximum count of new products on startpage');	
	
	
	define('GM_STYLE_BACKGROUND_COLOR', 'Background color');
	define('GM_STYLE_BACKGROUND_IMAGE', 'Background image');
	define('GM_STYLE_BACKGROUND_REPEAT', 'Background repeat');
	
	define('GM_STYLE_BORDER_LEFT', 'Border left');
	define('GM_STYLE_BORDER_BOTTOM', 'Border bottom');
	define('GM_STYLE_BORDER_RIGHT', 'Border right');
	define('GM_STYLE_BORDER_TOP', 'Border top');
	
	define('GM_STYLE_BORDER_COLOR', 'Border color');
	define('GM_STYLE_BORDER_TOP_COLOR', 'Border color top');
	define('GM_STYLE_BORDER_RIGHT_COLOR', 'Border color right');
	define('GM_STYLE_BORDER_BOTTOM_COLOR', 'Border color bottom');
	define('GM_STYLE_BORDER_LEFT_COLOR', 'Border color left');
	
	define('GM_STYLE_BORDER_STYLE', 'Border style');
	define('GM_STYLE_BORDER_TOP_STYLE', 'Border style top');
	define('GM_STYLE_BORDER_RIGHT_STYLE', 'Border style right');
	define('GM_STYLE_BORDER_BOTTOM_STYLE', 'Border style bottom');
	define('GM_STYLE_BORDER_LEFT_STYLE', 'Border style left');
	
	define('GM_STYLE_BORDER_WIDTH', 'Border width');
	define('GM_STYLE_BORDER_TOP_WIDTH', 'Border width top');
	define('GM_STYLE_BORDER_RIGHT_WIDTH', 'Border width right');
	define('GM_STYLE_BORDER_BOTTOM_WIDTH', 'Border width bottom');
	define('GM_STYLE_BORDER_LEFT_WIDTH', 'Border width left');
	
	define('GM_STYLE_CLEAR', 'Text float stop (clear)');
	define('GM_STYLE_COLOR', 'Color');
	define('GM_STYLE_FLOAT', 'Float');
	define('GM_STYLE_FONT_FAMILY', 'Font family');
	define('GM_STYLE_FONT_SIZE', 'Font size');
	define('GM_STYLE_FONT_WEIGHT', 'Font weight');
	define('GM_STYLE_FONT_STYLE', 'Font style');
	define('GM_STYLE_HEIGHT', 'Height');
	define('GM_STYLE_MARGIN_TOP', 'Margin top');
	define('GM_STYLE_MARGIN_BOTTOM', 'Margin bottom');
	define('GM_STYLE_MARGIN_LEFT', 'Margin left');
	define('GM_STYLE_MARGIN_RIGHT', 'Margin right');
	define('GM_STYLE_PADDING_LEFT', 'Padding left');
	define('GM_STYLE_PADDING_BOTTOM', 'Padding bottom');
	define('GM_STYLE_PADDING_RIGHT', 'Padding right');
	define('GM_STYLE_PADDING_TOP', 'Padding top');
	define('GM_STYLE_TEXT_ALIGN', 'Horizontal alignment');
	define('GM_STYLE_TEXT_DECORATION', 'Text decoration');
	define('GM_STYLE_VERTICAL_ALIGN', 'Vertical alignment');
	define('GM_STYLE_WIDTH', 'Width');
	
	
	define('GM_STYLE_VALUE_NORMAL', 'normal');
	define('GM_STYLE_VALUE_BOLD', 'bold');
	
	define('GM_STYLE_VALUE_ITALIC', 'italic');
	define('GM_STYLE_VALUE_OBLIQUE', 'oblique');
	
	define('GM_STYLE_VALUE_LEFT', 'left');
	define('GM_STYLE_VALUE_CENTER', 'center');
	define('GM_STYLE_VALUE_RIGHT', 'right');
	
	define('GM_STYLE_VALUE_TOP', 'top');
	define('GM_STYLE_VALUE_MIDDLE', 'middle');
	define('GM_STYLE_VALUE_BASELINE', 'baseline');
	define('GM_STYLE_VALUE_SUB', 'sub');
	define('GM_STYLE_VALUE_SUPER', 'super');
	define('GM_STYLE_VALUE_TEXT_TOP', 'text top');
	define('GM_STYLE_VALUE_TEXT_BOTTOM', 'text bottom');
	
	define('GM_STYLE_VALUE_NONE', 'none');
	define('GM_STYLE_VALUE_HIDDEN', 'hidden');
	define('GM_STYLE_VALUE_DOTTED', 'dotted');
	define('GM_STYLE_VALUE_DASHED', 'dashed');
	define('GM_STYLE_VALUE_SOLID', 'solid');
	define('GM_STYLE_VALUE_DOUBLE', 'double');
	define('GM_STYLE_VALUE_GROOVE', '3D effect (groove)');
	define('GM_STYLE_VALUE_RIDGE', '3D effect (ridge)');
	define('GM_STYLE_VALUE_INSET', '3D effect (inset)');
	define('GM_STYLE_VALUE_OUTSET', '3D effect (outset)');
	
	define('GM_STYLE_VALUE_BOTH', 'both');
	
	define('GM_STYLE_VALUE_UNDERLINE', 'underline');
	
	
	define('GM_MENUBOX_HEAD_BACKGROUND_COLOR', 'header background color');
	define('GM_MENUBOX_HEAD_BACKGROUND_IMAGE', 'header background image');
	define('GM_MENUBOX_HEAD_COLOR', 'header text color');
	define('GM_MENUBOX_HEAD_FONT_FAMILY', 'header text font');
	define('GM_MENUBOX_HEAD_FONT_SIZE', 'header font size');
	define('GM_MENUBOX_HEAD_FONT_WEIGHT', 'header font weight');
	define('GM_MENUBOX_HEAD_FONT_STYLE', 'header italic');
	define('GM_MENUBOX_HEAD_HEIGHT', 'header height');
	define('GM_MENUBOX_HEAD_TEXT_DECORATION', 'header underline');
	
	define('GM_MENUBOX_BODY_BACKGROUND_COLOR', 'content background color');
	define('GM_MENUBOX_BODY_BACKGROUND_IMAGE', 'content background image');
	define('GM_MENUBOX_BODY_COLOR', 'content text color');
	define('GM_MENUBOX_BODY_FONT_FAMILY', 'content text font');
	define('GM_MENUBOX_BODY_FONT_SIZE', 'content font size');
	define('GM_MENUBOX_BODY_FONT_WEIGHT', 'content font weight');
	define('GM_MENUBOX_BODY_FONT_STYLE', 'content italic');
	define('GM_MENUBOX_BODY_TEXT_DECORATION', 'content underline');
	
	define('GM_FONT_FAMILY', 'text font');
	define('GM_FONT_FAMILY_TEXT', '<strong>IMPORTANT:</strong> The different fonts used in the store will be replaced by the font selected. Changes are irreversible!');
	
	define('GM_FORM_BACKGROUND_COLOR', 'background color');
	define('GM_FORM_COLOR', 'font color');
	define('GM_FORM_BORDER_COLOR', 'border color');
	define('GM_FORM_BORDER_STYLE', 'border style');
	define('GM_FORM_BORDER_WIDTH', 'border width');
	
	
	define('GM_MENUBOXES_TITLE', 'Menuboxes');
	define('GM_GLOBAL_FONT_TITLE', 'Global text font');
	define('GM_FORMS_TITLE', 'Forms (guestbook, found cheaper?, callback service)');
	define('GM_LINKS_TITLE', 'Links');
	define('GM_PATH_BAR_TITLE', 'Path bar');
	define('GM_HOVER_TITLE', 'Mouseover color (hover)');
	
	define('GM_UNDERLINE_LINKS_TEXT', 'underline links on mouseover ');
	
	define('GM_PATH_BAR_BACKGROUND_COLOR', 'background color');
	
	define('GM_STARTPAGE_HOVER_BACKGROUND_COLOR', 'Product boxes on startpage');
	define('GM_CAT_HOVER_BACKGROUND_COLOR', 'Entry in categories box');
	
	define('BUTTON_CLOSE', 'Close');

	define('GM_SHOP_ALIGN', 'Store width and alignment');
	define('GM_SHOP_WIDTH', 'Store width');
	define('GM_SHOP_ALIGN_TEXT', 'Store alignment');
	define('GM_SHOP_ALIGN_LEFT', 'left');
	define('GM_SHOP_ALIGN_CENTER', 'center');
	define('GM_SHOP_ALIGN_RIGHT', 'right');
	define('GM_SHOP_ALIGN_JUSTIFY', 'justify');
	
	define('GM_RESTORE_CORNER', 'Gambio corner');
	define('GM_RESTORE_CORNER_TEXT', 'Restore Gambio corner');
	
	define('GM_TOPMENU_BACKGROUND_COLOR', 'Top menu');
	define('GM_TOPMENU_BACKGROUND_COLOR_TEXT', 'Top menu background color');


	// NEW
	define('GM_SHOW_CAT', 'Level(s) in the category listing');
	define('GM_SHOW_CAT_ALL', 'all');
	define('GM_SHOW_CAT_CHILD', 'first');
	define('GM_SHOW_CAT_NONE', 'top');
?>