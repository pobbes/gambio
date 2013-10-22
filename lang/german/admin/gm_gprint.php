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

define('GM_GPRINT_HEADING_TITLE', 'GX-Customizer');

define('GM_GPRINT_OVERVIEW', 'Sets-&Uuml;bersicht');
define('GM_GPRINT_CONFIGURATION', 'Konfiguration');

define('GM_GPRINT_DESCRIPTION', '<strong>Bereiche</strong><br /><p>&Uuml;ber den Button &quot;Bereich anlegen&quot; f&uuml;gen Sie dem Set einen Bereich hinzu, auf dem Texte, Eingabefelder, Bilder und Dateiuploadfelder (so genannte &quot;Elemente&quot;) platziert werden k&ouml;nnen.</p>
<p>Ein Bereich hat eine H&ouml;he und Breite, sowie einen Namen, der &uuml;ber dem Bereich als Tab erscheint. Es k&ouml;nnen mehrere Bereiche angelegt werden, die mit Klick auf den zugeh&ouml;rigen Tab angezeigt werden.</p>
<br />
<strong>Elemente</strong><br />
<p>&Uuml;ber den Button &quot;Element anlegen&quot; f&uuml;gen Sie dem aktuell sichtbaren Bereich einen Text, ein Eingabefeld, ein Bild, ein Dropdown oder ein Dateiuploadfeld hinzu.</p>
<ul>
	<li>
		<p>Jedes Element kann frei im Bereich positioniert werden. Die Positionsangabe bezieht sich auf die linke obere Ecke des Bereichs. Um das Element weiter rechts zu positionieren, tragen Sie im Feld &quot;Abstand nach links&quot; einen h&ouml;heren Wert ein. Eine Positionierung weiter unten erreichen Sie, indem Sie im Feld &quot;Abstand nach oben&quot; einen h&ouml;heren Wert eintragen.
		</p><p>
		Elemente k&ouml;nnen auch &uuml;bereinander platziert werden. Welches Element &uuml;ber welchem liegt, kann &uuml;ber das Feld "Ebene" gesteuert werden. Ebene &quot;2&quot; liegt z. B. &uuml;ber Ebene &quot;1&quot;.
		</p><p>
		Wurde das Element hinzugef&uuml;gt, kann dieses auch per Drag&Drop verschoben werden. Klicken Sie dazu das Element an, lassen die Maustaste gedr&uuml;ckt und ziehen das Element an die gew&uuml;nschte Position. Die Position wird beim Loslassen der Maustaste &uuml;bernommen.</p>
	</li>
	<li>
		<p>Der Name des Elements ist f&uuml;r die Bestellung wichtig, damit z. B. ein vom Kunden eingegebener Text dem Eingabefeld zugeordnet werden kann. F&uuml;r Eingabefelder und Dropdowns kann der Name auch optional als Bezeichnung &uuml;ber dem Feld angezeigt werden.</p>
	</li>
	<li>
		<p>Im Feld &quot;Wert&quot; tragen Sie den Text ein, der im Bereich, Eingabefeld oder Dropdown erscheinen soll. Die Anzahl der Werte f&uuml;r Dropdowns k&ouml;nnen Sie mit Klick auf &quot;+&quot; erh&ouml;hen und mit Klick auf &quot;-&quot; verringern.</p>
	</li>
	<li>
		<p>Die Abmessungen jedes Elements, bis auf Bilder, sind frei bestimmbar. Bilder werden in der Originalgr&ouml;&szlig;e angezeigt.</p>
	</li>
</ul>
');
define('GM_GPRINT_ADVICES', '<strong>Hinweise:</strong><br />
<ul>
	<li><p>Die Eigenschaften des Bereichs oder Elements bearbeiten Sie, indem Sie darauf doppelklicken.</p></li>
	<li><p>&Auml;nderungen durch das Verschieben von Elementen innerhalb des Bereichs per Drag&Drop oder das Anlegen, Bearbeiten und L&ouml;schen von Bereichen oder Elementen k&ouml;nnen nicht r&uuml;ckg&auml;ngig gemacht werden. Diese sind f&uuml;r den Kunden sofort sichtbar, sofern das Set einem aktiven Artikel zugeordnet ist.</p></li>
</ul>');

define('GM_GPRINT_OVERVIEW_ADVICE', '<strong>Hinweis:</strong> Die Set-Zuweisung nehmen Sie &uuml;ber die Kategorie- oder Artikelbearbeitung vor, indem Sie das Set im Dropdown &quot;GX-Customizer Set&quot; ausw&auml;hlen.');

define('GM_GPRINT_TEXT_SET', 'Set');
define('GM_GPRINT_TEXT_SIZE', 'Abmessungen');

define('GM_GPRINT_TEXT_WIDTH', 'Breite');
define('GM_GPRINT_TEXT_HEIGHT', 'H&ouml;he');
define('GM_GPRINT_TEXT_TOP', 'Abstand nach oben');
define('GM_GPRINT_TEXT_LEFT', 'Abstand nach links');
define('GM_GPRINT_TEXT_Z_INDEX', 'Ebene');
define('GM_GPRINT_TEXT_MAX_CHARACTERS', 'Max. Zeichenanzahl');
define('GM_GPRINT_TEXT_MAX_CHARACTERS_INFO', '(0 = kein Maximum)');
define('GM_GPRINT_TEXT_SHOW_NAME', 'Namen anzeigen?');
define('GM_GPRINT_TEXT_NAME', 'Bezeichnung');
define('GM_GPRINT_TEXT_VALUE', 'Wert');
define('GM_GPRINT_TEXT_TYPE', 'Typ');
define('GM_GPRINT_TEXT_IMAGE', 'Bild');
define('GM_GPRINT_TEXT_ALLOWED_EXTENSIONS', 'Erlaubte Dateitypen');
define('GM_GPRINT_TEXT_ALLOWED_EXTENSIONS_2', '(z. B.: jpg,png)');
define('GM_GPRINT_TEXT_MINIMUM_FILESIZE', 'Min. Dateigr&ouml;&szlig;e');
define('GM_GPRINT_TEXT_MINIMUM_FILESIZE_2', 'MB (0 = kein Limit)');
define('GM_GPRINT_TEXT_MAXIMUM_FILESIZE', 'Max. Dateigr&ouml;&szlig;e');
define('GM_GPRINT_TEXT_MAXIMUM_FILESIZE_2', 'MB (0 = kein Limit)');

define('GM_GPRINT_TEXT_NEW_SURFACE', 'Neuer Bereich');
define('GM_GPRINT_TEXT_NEW_ELEMENT', 'Neues Element');

define('GM_GPRINT_TEXT_SURFACE', 'Bereich');
define('GM_GPRINT_TEXT_ELEMENT', 'Element');

define('GM_GPRINT_TEXT_SELECTED_SET', 'Ausgew&auml;hltes Set');
define('GM_GPRINT_TEXT_COPY_NAME', 'Neuer Name der Kopie');
define('GM_GPRINT_TEXT_RENAME_NAME', 'Neuer Name');
define('GM_GPRINT_TEXT_NEW_SET', 'Neues Set');

define('GM_GPRINT_INPUT_TEXT', 'Eingabefeld einzeilig');
define('GM_GPRINT_TEXTAREA', 'Eingabefeld mehrzeilig');
define('GM_GPRINT_INPUT_FILE', 'Dateiuploadfeld');
define('GM_GPRINT_DROPDOWN', 'Dropdown');
define('GM_GPRINT_IMAGE', 'Bild');
define('GM_GPRINT_DIV_TEXT', 'Text');

define('GM_GPRINT_BUTTON_CREATE_SET', 'Set anlegen');
define('GM_GPRINT_BUTTON_LOAD_SET', 'Set laden');
define('GM_GPRINT_BUTTON_DELETE_SET', 'Set l&ouml;schen');

define('GM_GPRINT_BUTTON_CREATE', 'erstellen');
define('GM_GPRINT_BUTTON_ADD', 'hinzuf&uuml;gen');
define('GM_GPRINT_BUTTON_UPDATE', 'speichern');
define('GM_GPRINT_BUTTON_DELETE', 'l&ouml;schen');
define('GM_GPRINT_BUTTON_CLOSE', 'schlie&szlig;en');
define('GM_GPRINT_BUTTON_COPY', 'kopieren');
define('GM_GPRINT_BUTTON_EDIT', 'bearbeiten');
define('GM_GPRINT_BUTTON_CHANGE', '&auml;ndern');
define('GM_GPRINT_BUTTON_RENAME', 'umbenennen');
define('GM_GPRINT_BUTTON_HELP', 'Hilfe');

define('GM_GPRINT_BUTTON_CREATE_SURFACE', 'Bereich anlegen');
define('GM_GPRINT_BUTTON_CREATE_ELEMENT', 'Element anlegen');
define('GM_GPRINT_BUTTON_EDIT_SURFACE', 'Bereich bearbeiten');
define('GM_GPRINT_BUTTON_EDIT_ELEMENT', 'Element bearbeiten');

define('GM_GPRINT_BUTTON_BACK_TO_OVERVIEW', 'Zur&uuml;ck zur &Uuml;bersicht');

define('GM_GPRINT_CONFIGURATION_TEXT', 'Allgemeine Konfiguration');
define('GM_GPRINT_ALLOWED_FILE_EXTENSIONS_TEXT', 'Erlaubte Dateiformate f&uuml;r den Upload');
define('GM_GPRINT_SHOW_TABS_TEXT', 'Tabs zum Wechseln der Bereiche in Artikeldetailseite anzeigen?');
define('GM_GPRINT_SHOW_TABS_ACTIVATE_TEXT', 'ja (Standard) ');
define('GM_GPRINT_AUTO_WIDTH_TEXT', 'Set-Breite ignorieren und in Artikeldetailansicht maximale Breite anzeigen?');
define('GM_GPRINT_AUTO_WIDTH_ACTIVATE_TEXT', 'ja (Standard) ');
define('GM_GPRINT_EXCLUDE_SPACES_TEXT', 'Leerzeichen bei der Berechnung der maximalen Zeichenanzahl in Texteingabefeldern ausschlie&szlig;en?');
define('GM_GPRINT_EXCLUDE_SPACES_ACTIVATE_TEXT', 'ja (Standard) ');
define('GM_GPRINT_POSITION_TEXT', 'Set Position');
define('GM_GPRINT_POSITION_1_TEXT', '&uuml;ber Artikelbeschreibung');
define('GM_GPRINT_POSITION_2_TEXT', 'unter Artikelbeschreibung');
define('GM_GPRINT_POSITION_3_TEXT', 'unter Attributauswahl');
define('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION_TEXT', 'Artikelbeschreibung anzeigen?');
define('GM_GPRINT_SHOW_PRODUCTS_DESCRIPTION_ACTIVATE_TEXT', 'ja (Standard)');
define('GM_GPRINT_CHARACTER_LENGTH', 'K&uuml;rzen von Texteingaben in &Uuml;bersichten');
define('GM_GPRINT_CHARACTER_LENGTH_UNIT', 'Zeichen');
define('GM_GPRINT_CHARACTER_LENGTH_TEXT', 'Vom Kunden eingegebene Texte werden im Warenkorb, auf der Bestellbest&auml;tigungsseite vor Abschluss der Bestellung, im Adminbereich in der Bestellungen&uuml;bersicht und in der Bestelldetailansicht in der Artikelauflistung auf die angegebene Zeichenzahl gek&uuml;rzt (0 = kein K&uuml;rzen). Der gesamte Text wird weiterhin im Set, in der Druckversion der Bestellbest&auml;tigung, in der Bestellbest&auml;tigungs-E-Mail, in der PDF-Rechnung und im PDF-Lieferschein angezeigt.');
define('GM_GPRINT_ANTI_SPAM', 'Spam-Schutz');
define('GM_GPRINT_UPLOADS_PER_IP_TEXT', 'Anzahl erlaubter Dateiuploads pro Besucher (0 = keine Begrenzung)');
define('GM_GPRINT_UPLOADS_PER_IP_INTERVAL_TEXT', 'Zeitraum in Minuten, f&uuml;r den die Begrenzung der Anzahl an Dateiuploads gilt');

define('GM_GPRINT_CATEGORIES_HEADING', 'Set-Zuweisung');
define('GM_GPRINT_CATEGORIES_DESCRIPTION', 'Weisen Sie ein Set einem oder mehreren Artikeln in einer Kategorie zu, 
indem Sie vor den gew&uuml;nschten Kategorien einen Haken setzen, 
am Ende der Seite das Set aus dem Drop-Down-Feld ausw&auml;hlen 
und mit Klick auf den Button &quot;Zuweisen&quot; die Zuordnung speichern.<br /><br />
L&ouml;schen Sie die Zuweisung eines Sets zu Artikeln einer Kategorie, indem Sie vor den Kategorien einen Haken setzen und
am Ende der Seite auf den Button &quot;Set-Zuweisung aufheben&quot; klicken.<br /><br />
<strong>Um einzelne Artikel einer Kategorie einem Set zuzuordnen, klicken Sie auf den Kategorienamen, um die Seite zur Zuweisung der Artikel zu &ouml;ffnen.</strong>');
define('GM_GPRINT_PRODUCTS_DESCRIPTION', 'Weisen Sie ein Set einem oder mehreren Artikeln zu, 
indem Sie vor den Artikeln einen Haken setzen, 
am Ende der Seite das Set aus dem Drop-Down-Feld ausw&auml;hlen 
und mit Klick auf den Button &quot;Zuweisen&quot; die Zuordnung speichern.<br /><br />
L&ouml;schen Sie die Zuweisung eines Sets zu Artikeln, indem Sie vor den Artikeln einen Haken setzen und
am Ende der Seite auf den Button &quot;Set-Zuweisung aufheben&quot; klicken.');
define('GM_GPRINT_BUTTON_ASSIGN_SET', 'Set-Zuweisung &ouml;ffnen');
define('GM_GPRINT_BUTTON_ASSIGN', 'Zuweisen');
define('GM_GPRINT_BUTTON_DELTE_ASSIGNMENT', 'Set-Zuweisung aufheben');
define('GM_GPRINT_BUTTON_BACK', 'Zur&uuml;ck');
define('GM_GPRINT_SELECT_ALL', 'alle ausw&auml;hlen');
define('GM_GPRINT_SUCCESS', 'Die &Auml;nderungen wurden erfolgreich gespeichert!');
define('GM_GPRINT_SET_NAME_CHANGE_SUCCESS', 'Die Set-Bezeichnung wurde erfolgreich gespeichert!');

// edit category
define('GM_GPRINT_SUBCATEGORIES', 'Unterkategorien einbeziehen');
define('GM_GPRINT_DELETE_ASSIGNMENT', 'Set-Zuweisung aller Artikel l&ouml;schen');

// JavaScript 
define('GM_GPRINT_CONFIRM_DELETE_1', 'Möchten Sie das Set "');
define('GM_GPRINT_CONFIRM_DELETE_2', '" wirklich löschen?');


?>