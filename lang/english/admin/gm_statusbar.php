<?php
/* --------------------------------------------------------------
   gm_statusbar.php 2008-03-17 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

gm_id_starts.php 2008-01-30
	Gambio OHG
	http://www.gambio.de
	Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
	--------------------------------------------------------------
*/
?>
<?php
	
	define('HEADING_TITLE', 'Statusbar text');
	define('HEADING_SUB_TITLE', 'Gambio');
	define('GM_STATUSBAR_DESCRIPTION', 'Here you can define the text that appears on your browser statusbar. The statusbar is the bar at the bottom of your browser which also shows if a page is loaded. Check your browser settings if you cannot view the text after setup.<br /><br />
To do this, go to &quot;Extras&quot; -> &quot;Internet Options&quot; in the Internet Explorer 7 icon bar and then go to &quot;Security&quot;. Then click on &quot;Adjust level&quot; and scroll down to &quot;Allow statusbar update via script&quot;. Click on Activate and validate all the dialog boxes with OK.<br />
For the Firefox browser, click in the menu on &quot;Extras&quot; -> &quot;Settings&quot; -> &quot;Content&quot;. At &quot;Activate JavaScript&quot; click on &quot;Advanced&quot; and check &quot;Change statusbar text&quot;. Validate all the dialog boxes with OK.');
	define('GM_STATUSBAR_ACTIVATE_TEXT', 'Activate statusbar text');
	define('GM_STATUSBAR_TEXT_TEXT', 'Statusbar text: ');
	define('GM_STATUSBAR_SPEED_TEXT', 'Speed (standard 120): ');
	define('GM_STATUSBAR_WIDTH_TEXT', 'Width of display range (standard 100): ');
	
	//javascript alerts
	define('GM_STATUSBAR_SPEED_ERROR', 'The speed has to be a positive numeric value!');	
	define('GM_STATUSBAR_WIDTH_ERROR', 'The width has to be a positive numeric value!');	
?>