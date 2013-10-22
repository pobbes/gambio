<?php
/* --------------------------------------------------------------
   gm_counter_action.php 2008-06-24 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_counter_action.php 2007-12-20 pt@gambio
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2007 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
?>
<?php


	define('SELECT_IP_60',					'60 seconds');
	define('SELECT_IP_3600',				'1 hour');
	define('SELECT_IP_43200',				'12 hours');
	define('SELECT_IP_86400',				'24 hours');

	define('PROCEED',						'Updated');
	define('BUTTON_SAVE',					'Save');
	define('TITLE_CHOOSE',					'Choose');
	define('BUTTON_NAV_FORWARD',			'Next');
	define('BUTTON_NAV_BACK',				'Back');
	define('BUTTON_REFRESH',				'Update');
	define('TITLE_ALL',						'All');
	define('TITLE_UNKNOWN',					'Unknown');
	define('TITLE_PLOT_EMPTY',				'There is no entry currently');
	
	define('GM_COUNTER_TITLE_VISITOR',		'Visitor');
	define('GM_COUNTER_TITLE_PAGES',		'Page Impressions');
	define('GM_COUNTER_TITLE_USER_INFO',	'User Info');
	define('GM_COUNTER_TITLE_SEARCHTERMS',	'Search Terms');
	define('GM_COUNTER_TITLE_CONF',			'Configuration');

	/* set menu titles */
	define('MENU_TITLE_BROWSER',			'Browser');
	define('MENU_TITLE_PLATFORM',			'Operating System');
	define('MENU_TITLE_RESOLUTION',			'Resolution');
	define('MENU_TITLE_COLOR_DEPTH',		'Color Depth');
	define('MENU_TITLE_ORIGIN',				'Origin');
	
	define('MENU_TITLE_INTERN_SEARCH',		'Internal Search Terms');
	define('MENU_TITLE_EXTERN_SEARCH',		'External Search Terms');

	define('MENU_TITLE_INTERN_PAGES',		'Internal Page Impressions');
	define('MENU_TITLE_EXTERN_PAGES',		'Backlinks');

	define('MENU_TITLE_TODAY',				'Today');
	define('MENU_TITLE_DAY',				'Day');
	define('MENU_TITLE_WEEK',				'Week');
	define('MENU_TITLE_MONTH',				'Month');
	define('MENU_TITLE_YEAR',				'Year');
	define('MENU_TITLE_ALL',				'All');

	define('GM_COUNTER_VISITOR_X',			'Period');
	define('GM_COUNTER_VISITOR_Y',			'Visitor');
	
	define('MENU_TITLE_INTERN',				'Internal Page Impressions');
	define('GM_COUNTER_PAGES_X',			'Pages');
	define('GM_COUNTER_PAGES_Y',			'Impressions');
	
	define('MENU_TITLE_DAILY',				'Daily View');
	define('MENU_TITLE_MONTHLY',			'Monthly View');
	define('MENU_TITLE_YEARLY',				'Annual View');
	define('MENU_TITLE_FROM_YEAR',			'from');
	define('MENU_TITLE_TO_YEAR',			'to');
	define('MENU_TITLE_FROM',				'from');
	define('MENU_TITLE_TO',					'to');



	/* configuration */
	define('TITLE_CONF_VISITS',				'Visitor');
	define('TITLE_CONF_START_DATE',			'Start Date');
	define('TITLE_CONF_IP',					'IP Lock');

	/* searchterm */	
	define('TITLE_HITS',					'Hits');
	define('TITLE_NAME',					'Search Term');
	define('TITLE_SEARCH_ENGINE',			'Search Engine');

	/* form */
	define('TITLE_COUNT',					'Count:');
	define('TITLE_PAGE_TYP',				'Page Type:');
	define('TITLE_PRD',						'Product');
	define('TITLE_CAT',						'Category');
	define('TITLE_CONTENT',					'Content');

	/* start */
	define('GM_START_TITLE_Y_VISITS',		'Visits');
	define('GM_START_TITLE_VISITS',			'Visits yesterday and today');

	define('GM_START_TITLE_Y_ORDERS',		'Orders');
	define('GM_START_TITLE_ORDERS',			'Orders yesterday and today');

	define('GM_START_TITLE_Y_SALES',		'Sales');
	define('GM_START_TITLE_SALES',			'Sales yesterday and today');

	define('GM_START_TITLE_Y_HITS',			'Hits');
	define('GM_START_TITLE_HITS',			'Sales yesterday and today');
?>