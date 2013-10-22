<?php
/* --------------------------------------------------------------
   gm_statusbar.php 2008-05-20 gambio
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
	
	define('HEADING_TITLE', 'Statusleistenlauftext');
	define('HEADING_SUB_TITLE', 'Gambio');
	define('GM_STATUSBAR_DESCRIPTION', 'Hier k&ouml;nnen Sie den Text bestimmen, der durch die Statusleiste Ihres Browsers l&auml;uft. Die Statusleiste ist die Leiste an der unteren Kante Ihres Browsers, in der auch angezeigt wird, ob eine Seite geladen wird. Sollte der Text bei Ihnen nach der Einrichtung nicht angezeigt werden, sehen Sie in den Einstellungen Ihres Browsers nach.<br /><br />
Dazu gehen Sie im Internet Explorer 7 in der Symbolleiste auf &quot;Extras&quot; -> &quot;Internetoptionen&quot; und dann auf &quot;Sicherheit&quot;. Dort auf &quot;Stufe anpassen&quot; klicken und runterscrollen bis &quot;Statuszeilenaktualisierung &uuml;ber Skript zulassen&quot; erscheint. Klicken Sie auf Aktivieren und best&auml;tigen alle Dialogboxen mit OK.<br />
F&uuml;r den Firefox Browser klicken Sie im Men&uuml; auf &quot;Extras&quot; -> &quot;Einstellungen&quot; -> &quot;Inhalt&quot;. Bei &quot;JavaScript aktivieren&quot; klicken Sie auf &quot;Erweitert&quot; und machen ein H&auml;ckchen bei &quot;Statuszeilentext &auml;ndern&quot;. Best&auml;tigen Sie alle Dialogboxen mit OK.');
	define('GM_STATUSBAR_ACTIVATE_TEXT', 'Statusleistenlauftext aktivieren');
	define('GM_STATUSBAR_TEXT_TEXT', 'Statusleistenlauftext: ');
	define('GM_STATUSBAR_SPEED_TEXT', 'Laufgeschwindigkeit (Standard 120): ');
	define('GM_STATUSBAR_WIDTH_TEXT', 'Breite des Anzeigebereichs (Standard 100): ');
	
	// Umlaute müssen erhalten bleiben, da dies JavaScript-Fehlermeldungen sind
	define('GM_STATUSBAR_WIDTH_ERROR', 'Die Breite des Anzeigebereichs muss ein positiver numerischer Wert sein!');	
	define('GM_STATUSBAR_SPEED_ERROR', 'Die Laufgeschwindigkeit muss ein positiver numerischer Wert sein!');	
?>