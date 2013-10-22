<?php
/* --------------------------------------------------------------
   gm_gprint.php 2009-12-15 mb
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2009 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php

define('HEADING_TITLE', 'GX-Customizer');

define('GM_GPRINT_OVERVIEW', 'Sets-Overview');
define('GM_GPRINT_CONFIGURATION', 'Configuration');

define('GM_GPRINT_DESCRIPTION', '<strong>Areas</strong><br /><p>Click on the button &quot;Create Area&quot; to add an area to the set. On the area texts, input fields, images and upload fiels (all called &quot;elements&quot;) can be placed.<p>
An area has a height, a width and a name. The name is shown in tab above the area. You can create several areas which are displayed by clicking on the tab.</p>
<br />
<strong>Elements</strong><br />
<p>Click on the button &quot;Add Element&quot; to add a text, an input field, an image, a dropdown or an upload field to the active area.</p>
<ul>
	<li>
		<p>Every elements can be positioned freely. The offset value of the element is relative to the left top corner of the area. A higher &quot;top offset&quot; value means a lower position and a higher &quot;left offset&quot; value results in a position to the right.
		</p><p>
		Elements can be placed on top of each other. Which element is on top can be determined by the &quot;layer&quot; value.
		</p><p>
		Added Elements can be positioned by drag&drop, too.</p>
	</li>
	<li>
		<p>The element\'s name is important for orders to relate the customers\'s input to the right element. The name can be displayed optionally for input fields and dropdowns.</p>
	</li>
	<li>
		<p>Use the field &quot;value&quot; for texts you want to add to the area or into input fields. Add a new value for a dropdown by clicking on &quot;+&quot;, remove a value by clicking on &quot;-&quot;.</p>
	</li>
	<li>
		<p>The dimensions of each element, except of images, can be defined freely.</p>
	</li>
</ul>
');
define('GM_GPRINT_ADVICES', '<strong>Advices:</strong><br />
<ul>
	<li><p>Doubleclick on an area or an element to edit its attributes.</p></li>
	<li><p>Changes by dragging elements or adding, editing and deleting areas or elements are irreversible. All changes are shown for the customer immediately, if the set is assigned to an active article.</p></li>
</ul>');

define('GM_GPRINT_OVERVIEW_ADVICE', '<strong>Advice:</strong> Assign a set to one or more products by selecting the &quot;GX-Customizer Set&quot; on the edit page of the category or product.');

define('GM_GPRINT_TEXT_SET', 'Set');
define('GM_GPRINT_TEXT_SIZE', 'Dimensions');

define('GM_GPRINT_TEXT_WIDTH', 'Width');
define('GM_GPRINT_TEXT_HEIGHT', 'Height');
define('GM_GPRINT_TEXT_TOP', 'Top offset');
define('GM_GPRINT_TEXT_LEFT', 'Left offset');
define('GM_GPRINT_TEXT_Z_INDEX', 'Layer');
define('GM_GPRINT_TEXT_MAX_CHARACTERS', 'Max. characters');
define('GM_GPRINT_TEXT_MAX_CHARACTERS_INFO', '(0 = no limit)');
define('GM_GPRINT_TEXT_SHOW_NAME', 'Show name?');
define('GM_GPRINT_TEXT_NAME', 'Name');
define('GM_GPRINT_TEXT_VALUE', 'Text');
define('GM_GPRINT_TEXT_TYPE', 'Type');
define('GM_GPRINT_TEXT_IMAGE', 'Image');
define('GM_GPRINT_TEXT_ALLOWED_EXTENSIONS', 'Allowed file types');
define('GM_GPRINT_TEXT_ALLOWED_EXTENSIONS_2', '(e. g.: jpg,png)');
define('GM_GPRINT_TEXT_MINIMUM_FILESIZE', 'Min. filesize');
define('GM_GPRINT_TEXT_MINIMUM_FILESIZE_2', 'MB (0 = no limit)');
define('GM_GPRINT_TEXT_MAXIMUM_FILESIZE', 'Max. filesize');
define('GM_GPRINT_TEXT_MAXIMUM_FILESIZE_2', 'MB (0 = no limit)');

define('GM_GPRINT_TEXT_NEW_SURFACE', 'New Area');
define('GM_GPRINT_TEXT_NEW_ELEMENT', 'New Element');

define('GM_GPRINT_TEXT_SURFACE', 'Area');
define('GM_GPRINT_TEXT_ELEMENT', 'Element');

define('GM_GPRINT_TEXT_SELECTED_SET', 'Selected Set');
define('GM_GPRINT_TEXT_COPY_NAME', 'New name of the copy');
define('GM_GPRINT_TEXT_RENAME_NAME', 'New name');
define('GM_GPRINT_TEXT_NEW_SET', 'New Set');

define('GM_GPRINT_INPUT_TEXT', 'Input field single-line');
define('GM_GPRINT_TEXTAREA', 'Input field multiline');
define('GM_GPRINT_INPUT_FILE', 'File upload field');
define('GM_GPRINT_DROPDOWN', 'Dropdown');
define('GM_GPRINT_IMAGE', 'Image');
define('GM_GPRINT_DIV_TEXT', 'Text');

define('GM_GPRINT_BUTTON_CREATE_SET', 'Create Set');
define('GM_GPRINT_BUTTON_LOAD_SET', 'Load Set');
define('GM_GPRINT_BUTTON_DELETE_SET', 'Delete Set');

define('GM_GPRINT_BUTTON_CREATE', 'create');
define('GM_GPRINT_BUTTON_ADD', 'add');
define('GM_GPRINT_BUTTON_UPDATE', 'save');
define('GM_GPRINT_BUTTON_DELETE', 'delete');
define('GM_GPRINT_BUTTON_CLOSE', 'close');
define('GM_GPRINT_BUTTON_COPY', 'copy');
define('GM_GPRINT_BUTTON_EDIT', 'edit');
define('GM_GPRINT_BUTTON_CHANGE', 'change');
define('GM_GPRINT_BUTTON_RENAME', 'rename');
define('GM_GPRINT_BUTTON_HELP', 'Help');

define('GM_GPRINT_BUTTON_CREATE_SURFACE', 'Create area');
define('GM_GPRINT_BUTTON_CREATE_ELEMENT', 'Add element');
define('GM_GPRINT_BUTTON_EDIT_SURFACE', 'Edit area');
define('GM_GPRINT_BUTTON_EDIT_ELEMENT', 'Edit element');

define('GM_GPRINT_BUTTON_BACK_TO_OVERVIEW', 'Back to overview');

define('GM_GPRINT_CONFIGURATION_TEXT', 'General configuration');
define('GM_GPRINT_ALLOWED_FILE_EXTENSIONS_TEXT', 'Allowed file types for upload');
define('GM_GPRINT_SHOW_TABS_TEXT', 'Show tabs for switching areas on product info site?');
define('GM_GPRINT_SHOW_TABS_ACTIVATE_TEXT', 'yes (standard) ');
define('GM_GPRINT_AUTO_WIDTH_TEXT', 'Use maximum width of &quot;set&quot; on product site?');
define('GM_GPRINT_AUTO_WIDTH_ACTIVATE_TEXT', 'yes (standard) ');
define('GM_GPRINT_EXCLUDE_SPACES_TEXT', 'Exclude spaces for character count (maximum characters for text inputs)?');
define('GM_GPRINT_EXCLUDE_SPACES_ACTIVATE_TEXT', 'yes (standard) ');
define('GM_GPRINT_POSITION_TEXT', 'Set position');
define('GM_GPRINT_POSITION_1_TEXT', 'above product description');
define('GM_GPRINT_POSITION_2_TEXT', 'below product description');
define('GM_GPRINT_POSITION_3_TEXT', 'below attributes');
define('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION_TEXT', 'Show product description?');
define('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION_ACTIVATE_TEXT', 'yes (standard)');
define('GM_GPRINT_CHARACTER_LENGTH', 'Shorten customer\'s texts in overviews');
define('GM_GPRINT_CHARACTER_LENGTH_UNIT', 'characters');
define('GM_GPRINT_CHARACTER_LENGTH_TEXT', 'Show shortened texts in shopping cart, on checkout confirmationen page, on order overview page and in article listing on order details page. Type in the number of shown characters (0 = no abbreviation).');
define('GM_GPRINT_ANTI_SPAM', 'Anti-Spam');
define('GM_GPRINT_UPLOADS_PER_IP_TEXT', 'Number of allowed uploads per user');
define('GM_GPRINT_UPLOADS_PER_IP_INTERVAL_TEXT', 'Time interval in minutes for the above option');

define('GM_GPRINT_CATEGORIES_HEADING', 'Set-Assignment');
define('GM_GPRINT_CATEGORIES_DESCRIPTION', 'Assign a set to one or several products of a category by checking the category\'s checkbox, 
selecting the set from the drop-down-field and clicking on the button &quot;Assign&quot;.<br /><br />
Delete all assignments of products in a category by checking the category\'s checkbox and clicking on the button &quot;Remove Set-Assignment&quot;.<br /><br />
<strong>To assign single products of a category to a set, click on the category\'s name to open the site for product assignments.</strong>');
define('GM_GPRINT_PRODUCTS_DESCRIPTION', 'Assign a set to one or several products by checking the products\'s checkbox, 
selecting the set from the drop-down-field and clicking on the button &quot;Assign&quot;.<br /><br />
Delete an assignment of a product by checking the its checkbox and clicking on the button &quot;Remove Set-Assignment&quot;.');
define('GM_GPRINT_BUTTON_ASSIGN_SET', 'Set-Assignment Configuration');
define('GM_GPRINT_BUTTON_ASSIGN', 'Assign');
define('GM_GPRINT_BUTTON_DELTE_ASSIGNMENT', 'Remove Set-Assignment');
define('GM_GPRINT_BUTTON_BACK', 'Back');
define('GM_GPRINT_SELECT_ALL', 'select all');
define('GM_GPRINT_SUCCESS', 'The changes were successfully saved!');
define('GM_GPRINT_SET_NAME_CHANGE_SUCCESS', 'The set-name was successfully saved!');

// edit category
define('GM_GPRINT_SUBCATEGORIES', 'include subcategories');
define('GM_GPRINT_DELETE_ASSIGNMENT', 'delete set-assignment of all products');

// JavaScript 
define('GM_GPRINT_CONFIRM_DELETE_1', 'Do you really want to delete the set "');
define('GM_GPRINT_CONFIRM_DELETE_2', '"?');
?>