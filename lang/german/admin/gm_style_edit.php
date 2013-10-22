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
	define('HEADING_TITLE', 'Template-Einstellungen');
	define('HEADING_SUB_TITLE', 'Gambio');
	
	define('GM_FRONT_STYLE', 'Shop anpassen');
		
	define('GM_FORM_SUBMIT', 'Speichern');	

	define('GM_LOAD_EDIT_MODE', 'Shop im Bearbeitungsmodus laden');
	define('GM_LOAD_SOS_MODE', 'Shop im Wiederherstellungsmodus laden');	
	define('GM_NO_STYLE_EDIT_INSTALLED_TEXT', 'Das Modul zum Bearbeiten des Shoplayouts (StyleEdit) ist nicht installiert.<br /><br />');

	define('GM_CART_ON_TOP', 'Warenkorb in separater Box anzeigen');	
	define('GM_SHOW_WISHLIST', 'Merkzettel aktivieren');
	define('GM_TOPMENU_MODE', 'Kategoriepfad und Schnellsuche in eigener Leiste');
    define('GM_SHOW_QUICK_SEARCH', 'Schnellsuche anzeigen');
	define('GM_GAMBIO_CORNER', 'Gambio-Ecke anzeigen');
	define('GM_SHOW_FLYOVER', 'FlyOver anzeigen (Artikel auf Startseite, in Kategorien, Cross-Selling-, Reverse-Cross-Selling-, Ebenfalls-gekauft-Artikel)');	
	define('GM_SPECIALS_STARTPAGE', 'Maximale Anzahl an Sonderangeboten auf der Startseite');	
	define('GM_NEW_PRODUCTS_STARTPAGE', 'Maximale Anzahl an neuen Artikeln auf der Startseite');	
	
	
	define('GM_STYLE_BACKGROUND_COLOR', 'Hintergrundfarbe');
	define('GM_STYLE_BACKGROUND_IMAGE', 'Hintergrundbild');
	define('GM_STYLE_BACKGROUND_REPEAT', 'Wiederholungs-Effekt');
	
	define('GM_STYLE_BORDER_LEFT', 'Rahmen links');
	define('GM_STYLE_BORDER_BOTTOM', 'Rahmen unten');
	define('GM_STYLE_BORDER_RIGHT', 'Rahmen rechts');
	define('GM_STYLE_BORDER_TOP', 'Rahmen oben');
	
	define('GM_STYLE_BORDER_COLOR', 'Rahmenfarbe');
	define('GM_STYLE_BORDER_TOP_COLOR', 'Rahmenfarbe oben');
	define('GM_STYLE_BORDER_RIGHT_COLOR', 'Rahmenfarbe rechts');
	define('GM_STYLE_BORDER_BOTTOM_COLOR', 'Rahmenfarbe unten');
	define('GM_STYLE_BORDER_LEFT_COLOR', 'Rahmenfarbe links');
	
	define('GM_STYLE_BORDER_STYLE', 'Rahmenart');
	define('GM_STYLE_BORDER_TOP_STYLE', 'Rahmenart oben');
	define('GM_STYLE_BORDER_RIGHT_STYLE', 'Rahmenart rechts');
	define('GM_STYLE_BORDER_BOTTOM_STYLE', 'Rahmenart unten');
	define('GM_STYLE_BORDER_LEFT_STYLE', 'Rahmenart links');
	
	define('GM_STYLE_BORDER_WIDTH', 'Rahmenbreite');
	define('GM_STYLE_BORDER_TOP_WIDTH', 'Rahmenbreite oben');
	define('GM_STYLE_BORDER_RIGHT_WIDTH', 'Rahmenbreite rechts');
	define('GM_STYLE_BORDER_BOTTOM_WIDTH', 'Rahmenbreite unten');
	define('GM_STYLE_BORDER_LEFT_WIDTH', 'Rahmenbreite links');
	
	define('GM_STYLE_CLEAR', 'Textumfluss-Stop (clear)');
	define('GM_STYLE_COLOR', 'Farbe');
	define('GM_STYLE_FLOAT', 'Textumfluss (float)');
	define('GM_STYLE_FONT_FAMILY', 'Schriftart');
	define('GM_STYLE_FONT_SIZE', 'Schriftgr&ouml;&szlig;e');
	define('GM_STYLE_FONT_WEIGHT', 'Fett');
	define('GM_STYLE_FONT_STYLE', 'Schriftstil');
	define('GM_STYLE_HEIGHT', 'H&ouml;he');
	define('GM_STYLE_MARGIN_TOP', 'Au&szlig;enabstand oben');
	define('GM_STYLE_MARGIN_BOTTOM', 'Au&szlig;enabstand unten');
	define('GM_STYLE_MARGIN_LEFT', 'Au&szlig;enabstand links');
	define('GM_STYLE_MARGIN_RIGHT', 'Au&szlig;enabstand rechts');
	define('GM_STYLE_PADDING_LEFT', 'Innenabstand links');
	define('GM_STYLE_PADDING_BOTTOM', 'Innenabstand unten');
	define('GM_STYLE_PADDING_RIGHT', 'Innenabstand rechts');
	define('GM_STYLE_PADDING_TOP', 'Innenabstand oben');
	define('GM_STYLE_TEXT_ALIGN', 'horizontale Ausrichtung');
	define('GM_STYLE_TEXT_DECORATION', 'Textdekoration');
	define('GM_STYLE_VERTICAL_ALIGN', 'vertikale Ausrichtung');
	define('GM_STYLE_WIDTH', 'Breite');
	
	
	define('GM_STYLE_VALUE_NORMAL', 'normal');
	define('GM_STYLE_VALUE_BOLD', 'fett');
	
	define('GM_STYLE_VALUE_ITALIC', 'kursiv');
	define('GM_STYLE_VALUE_OBLIQUE', 'schr&auml;g');
	
	define('GM_STYLE_VALUE_LEFT', 'links');
	define('GM_STYLE_VALUE_CENTER', 'mittig');
	define('GM_STYLE_VALUE_RIGHT', 'rechts');
	
	define('GM_STYLE_VALUE_TOP', 'oben');
	define('GM_STYLE_VALUE_MIDDLE', 'mittig');
	define('GM_STYLE_VALUE_BASELINE', 'Grundlinie');
	define('GM_STYLE_VALUE_SUB', 'tiefgestellt');
	define('GM_STYLE_VALUE_SUPER', 'hochgestellt');
	define('GM_STYLE_VALUE_TEXT_TOP', 'oberer Textrand');
	define('GM_STYLE_VALUE_TEXT_BOTTOM', 'unterer Textrand');
	
	define('GM_STYLE_VALUE_NONE', 'nein (none)');
	define('GM_STYLE_VALUE_HIDDEN', 'nein (hidden)');
	define('GM_STYLE_VALUE_DOTTED', 'gepunktet');
	define('GM_STYLE_VALUE_DASHED', 'gestrichelt');
	define('GM_STYLE_VALUE_SOLID', 'durchgezogen');
	define('GM_STYLE_VALUE_DOUBLE', 'doppelt');
	define('GM_STYLE_VALUE_GROOVE', '3D-Effekt (groove)');
	define('GM_STYLE_VALUE_RIDGE', '3D-Effekt (ridge)');
	define('GM_STYLE_VALUE_INSET', '3D-Effekt (inset)');
	define('GM_STYLE_VALUE_OUTSET', '3D-Effekt (outset)');
	
	define('GM_STYLE_VALUE_BOTH', 'beidseitig');
	
	define('GM_STYLE_VALUE_UNDERLINE', 'unterstrichen');
	
	
	define('GM_MENUBOX_HEAD_BACKGROUND_COLOR', '&Uuml;berschrift Hintergrundfarbe');
	define('GM_MENUBOX_HEAD_BACKGROUND_IMAGE', '&Uuml;berschrift Hintergrundbild');
	define('GM_MENUBOX_HEAD_COLOR', '&Uuml;berschrift Schriftfarbe');
	define('GM_MENUBOX_HEAD_FONT_FAMILY', '&Uuml;berschrift Schriftart');
	define('GM_MENUBOX_HEAD_FONT_SIZE', '&Uuml;berschrift Schriftgr&ouml;&szlig;e');
	define('GM_MENUBOX_HEAD_FONT_WEIGHT', '&Uuml;berschrift fett');
	define('GM_MENUBOX_HEAD_FONT_STYLE', '&Uuml;berschrift kursiv');
	define('GM_MENUBOX_HEAD_HEIGHT', '&Uuml;berschrift H&ouml;he');
	define('GM_MENUBOX_HEAD_TEXT_DECORATION', '&Uuml;berschrift unterstrichen');
	
	define('GM_MENUBOX_BODY_BACKGROUND_COLOR', 'Inhalt Hintergrundfarbe');
	define('GM_MENUBOX_BODY_BACKGROUND_IMAGE', 'Inhalt Hintergrundbild');
	define('GM_MENUBOX_BODY_COLOR', 'Inhalt Schriftfarbe');
	define('GM_MENUBOX_BODY_FONT_FAMILY', 'Inhalt Schriftart');
	define('GM_MENUBOX_BODY_FONT_SIZE', 'Inhalt Schriftgr&ouml;&szlig;e');
	define('GM_MENUBOX_BODY_FONT_WEIGHT', 'Inhalt fett');
	define('GM_MENUBOX_BODY_FONT_STYLE', 'Inhalt kursiv');
	define('GM_MENUBOX_BODY_TEXT_DECORATION', 'Inhalt unterstrichen');
	
	define('GM_FONT_FAMILY', 'Schriftart');
	define('GM_FONT_FAMILY_TEXT', '<strong>ACHTUNG:</strong> Diese Option betrifft ALLE Texte im Shop. Standardm&auml;ßig werden im Shop verschiedene Schriftarten genutzt, die beim Speichern durch die eine ausgew&auml;hlte ersetzt werden. Die Anpassung kann nicht r&uuml;ckg&auml;ngig gemacht werden!');
	
	
	define('GM_FORM_BACKGROUND_COLOR', 'Hintergrundfarbe');
	define('GM_FORM_COLOR', 'Schriftfarbe');
	define('GM_FORM_BORDER_COLOR', 'Rahmenfarbe');
	define('GM_FORM_BORDER_STYLE', 'Rahmenart');
	define('GM_FORM_BORDER_WIDTH', 'Rahmenbreite');
		
		
	define('GM_MENUBOXES_TITLE', 'Men&uuml;boxen');
	define('GM_GLOBAL_FONT_TITLE', 'Schriftart global');
	define('GM_FORMS_TITLE', 'Formulare (G&auml;stebuch, Woanders g&uuml;nstiger?, Callback Service)');
	define('GM_LINKS_TITLE', 'Links');
	define('GM_PATH_BAR_TITLE', 'Pfadleiste');
	define('GM_HOVER_TITLE', 'Mouseover-Farbe (Hover)');
	
	define('GM_UNDERLINE_LINKS_TEXT', 'Links unterstreichen, wenn mit dem Mauszeiger darüber gefahren wird ');
	
	define('GM_PATH_BAR_BACKGROUND_COLOR', 'Hintergrundfarbe');
	
	define('GM_STARTPAGE_HOVER_BACKGROUND_COLOR', 'Artikelboxen auf Startseite');
	define('GM_CAT_HOVER_BACKGROUND_COLOR', 'Eintrag in Kategorien-Box');
	
	define('BUTTON_CLOSE', 'Abbrechen');
	
	define('GM_SHOP_ALIGN', 'Shopbreite und -ausrichtung');
	define('GM_SHOP_WIDTH', 'Shopbreite');
	define('GM_SHOP_ALIGN_TEXT', 'Shopausrichtung');
	define('GM_SHOP_ALIGN_LEFT', 'linksb&uuml;ndig');
	define('GM_SHOP_ALIGN_CENTER', 'mittig');
	define('GM_SHOP_ALIGN_RIGHT', 'rechtsb&uuml;ndig');
	define('GM_SHOP_ALIGN_JUSTIFY', 'gestreckt');
	
	define('GM_RESTORE_CORNER', 'Gambio-Ecke');
	define('GM_RESTORE_CORNER_TEXT', 'Wenn Sie im Top-Men&uuml; ein Hintergrundbild hinterlegt haben, k&ouml;nnen Sie an dieser Stelle die Gambio-Ecke wiederherstellen.');
	
	define('GM_TOPMENU_BACKGROUND_COLOR', 'Top-Men&uuml;');
	define('GM_TOPMENU_BACKGROUND_COLOR_TEXT', 'Hintergrundfarbe');

	define('GM_SHOW_CAT', 'Ebene(n) in der Kategorief&uuml;hrung anzeigen');
	define('GM_SHOW_CAT_ALL', 'alle');
	define('GM_SHOW_CAT_CHILD', 'erste');
	define('GM_SHOW_CAT_NONE', 'oberste');
?>