<?php
/* --------------------------------------------------------------
   gm_miscellaneous.php 2012-01-12 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php
	
	define('HEADING_TITLE', 'Allgemeines');
	define('HEADING_SUB_TITLE', 'Gambio');
	define('BUTTON_SAVE',				'Speichern');
	
	define('GM_TITLE_STOCK', 'Lagerbest&auml;nde anzeigen');
	define('GM_CAT_STOCK', 'Lagerbest&auml;nde in <strong>allen</strong> Kategorien zu jedem Artikel anzeigen (Haken gesetzt) / nicht anzeigen (kein Haken) lassen? Die Option ist unabhängig von der unteren.');
	define('GM_PRODUCT_STOCK', 'Lagerbest&auml;nde in <strong>allen</strong> Artikeln in der Artikeldetailansicht anzeigen (Haken gesetzt) / nicht anzeigen (kein Haken)? Die Option ist unabhängig von der oberen.');
	define('BUTTON_EXECUTE', 'Anwenden');
	define('GM_CAT_STOCK_SUCCESS', 'Die Anpassung der Kategorien war erfolgreich.');
	define('GM_PRODUCT_STOCK_SUCCESS', 'Die Anpassung der Artikel war erfolgreich.');
	
	define('GM_DELETE_IMAGES_TITLE', 'Artikelbilder l&ouml;schen');
	define('GM_DELETE_IMAGES', 'Alle Original-Artikelbilder unwiderruflich l&ouml;schen?');
	define('GM_DELETE_IMAGES_MESSAGE_1', 'Es wurden ');
	define('GM_DELETE_IMAGES_MESSAGE_2', ' von ');
	define('GM_DELETE_IMAGES_MESSAGE_3', ' Dateien aus dem images/product_images/original_images Verzeichnis gel&ouml;scht.');
	define('GM_DELETE_IMAGES_ADVICE_1', ' Datei konnte nicht gel&ouml;scht werden, da die erforderlichen L&ouml;sch- oder Benutzerrechte fehlen.');
	define('GM_DELETE_IMAGES_ADVICE_2', ' Dateien konnten nicht gel&ouml;scht werden, da die erforderlichen L&ouml;sch- oder Benutzerrechte fehlen.');
	
	define('GM_TRUNCATE_FLYOVER', 'Zeichenanzahl nach der die Artikelnamen im "Flyover" gek&uuml;rzt werden.');
	define('GM_TRUNCATE_FLYOVER_TEXT', 'Zeichenanzahl nach der der Artikelkurztext im "Flyover" gek&uuml;rzt wird.');
	define('GM_TRUNCATE_PRODUCTS_NAME', 'Zeichenanzahl nach der die Artikelnamen auf der Startseite unter &quot;Unsere Empfehlungen&quot;, &quot;Sonderangebote&quot; und &quot;Neue Artikel&quot; gek&uuml;rzt werden. Es wird zwischen zwei W&ouml;rtern umgebrochen.');
	define('GM_TRUNCATE_PRODUCTS_HISTORY', 'Zeichenanzahl nach der die Artikelnamen in der Men&uuml;box &quot;Bestellübersicht&quot; gek&uuml;rzt werden.');
	define('GM_ORDER_STATUS_CANCEL_ID', 'ID in der MySQL-Tabelle "orders_status" f&uuml;r den Bestellstatus der Stornierung. Diese ID sollte nur ge&auml;ndert werden, wenn die neue ID entsprechend bekannt ist oder diese noch nicht gesetzt worden ist. Im Standard sollte hier der Wert "99" stehen.');
	
	define('GM_TELL_A_FRIEND', '&quot;Weiterempfehlen&quot;-Modul aktivieren?');
	
	define('GM_TAX_FREE', 'Kleinunternehmerreglung: &quot;Kein Steuerausweis gem. Kleinuntern.-Reg. §19 UStG&quot; statt der MwSt.-Angabe bei jedem Preis anzeigen lassen');
	
	define('GM_HIDE_MSRP_TEXT', 'UVP-Anzeige bei Kundengruppenpreisen deaktivieren');

	define('GM_MISCELLANEOUS_SUCCESS', 'Einstellungen wurde aktualisiert.');
	
	/*law and order */
	define('TITLE_LAW',										'Rechtliches');
	define('TITLE_PRIVACY',									'Datenschutzlink');
	define('TITLE_CONDITIONS',								'Allgemeine Geschäftsbedingungen');
	define('TITLE_WITHDRAWAL',								'Widerrufsrecht');
	
	define('TITLE_CONDITIONS_SHOW_ORDER',					'im Bestellvorgang anzeigen');
	define('TITLE_CONDITIONS_CHECK_ORDER',					'im Bestellvorgang best&auml;tigen');
	
	define('TITLE_PRIVACY_SHOW_REGISTRATION',				'in der Registrierung anzeigen');
	define('TITLE_PRIVACY_CHECK_REGISTRATION',				'in der Registrierung best&auml;tigen');

	define('TITLE_WITHDRAWAL_SHOW_ORDER',					'im Bestellvorgang anzeigen');
	define('TITLE_WITHDRAWAL_CHECK_ORDER',					'im Bestellvorgang best&auml;tigen');
	define('TITLE_WITHDRAWAL_CONTENT_ID_ORDER',					'Content ID');

	define('TITLE_CONFIRMATION', 'Bestellbest&auml;tigung-Seite');
	define('TITLE_PRIVACY_CONFIRMATION', 'Datenschutzerkl&auml;rung-Link anzeigen');
	define('TITLE_CONDITIONS_CONFIRMATION', 'AGB-Link anzeigen');
	define('TITLE_WITHDRAWAL_CONFIRMATION', 'Widerrufsrecht-Link anzeigen');

	define('GM_SHOW_PRODUCTS_WEIGHT', 'Produktgewicht in der Artikelinfoseite anzeigen');
	
	define('TITLE_LOG_IP',			'IP-Logging' );	
	define('TEXT_LOG_IP',			'im Bestellvorgang IP speichern');
	define('TEXT_SHOW_IP',			'im Bestellvorgang Hinweistext anzeigen');	
	define('TEXT_CONFIRM_IP',		'im Bestellvorgang IP-Logging best&auml;tigen');

	define('TEXT_LOG_IP_LOGIN',		'bei Login und Registrierung IP speichern');
	define('TEXT_NOTE_LOGGING',		'Hinweis: IP-Adressen von Benutzern d&uuml;rfen personenbezogen nur gespeichert werden, soweit hierf&uuml;r eine ausdr&uuml;ckliche Einwilligung erteilt wurde.');

	define('TITLE_DISPLAY_TAX', 'Mehrwertsteuer-Anzeige');
	define('TEXT_DISPLAY_TAX', 'Mehrwertsteuer unter Artikelpreisen anzeigen');

	/* delete stats */
	define('GM_TITLE_STATS', 'Statistiken l&ouml;schen');
	
	
	define('GM_TITLE_STAT','Bestellstatus');

	define('TITLE_STAT_PRODUCTS_VIEWED',	'Besuchte Artikel');
	define('TITLE_STAT_PRODUCTS_PURCHASED', 'Verkaufte Artikel');
	define('TITLE_STAT_INTERN_KEWORDS',		'Interne Suchw&ouml;rter');
	define('TITLE_STAT_EXTERN_KEWORDS',		'Externe Suchw&ouml;rter');
	define('TITLE_STAT_IMPRESSIONS',		'Seitenaufrufe');
	define('TITLE_STAT_VISTORS',			'Besucher');
	define('TITLE_STAT_USER_INFO',			'Benutzerinfo');


	/* Privacy */
	define('TITLE_PRIVACY_CALLBACK',			'im Callback Service anzeigen');
	define('TITLE_PRIVACY_CONTACT',				'im Kontaktformular anzeigen');
	define('TITLE_PRIVACY_GUESTBOOK',			'im G&auml;stebuch anzeigen');
	
	define('TITLE_PRIVACY_TELL_A_FRIEND',		'im &quot;Tell a friend&quot;-Modul anzeigen');
	define('TITLE_PRIVACY_FOUND_CHEAPER',		'im &quot;Woanders g&uuml;nstiger&quot;-Modul anzeigen');
	define('TITLE_PRIVACY_REVIEWS',				'im Artikelbewertungsformular anzeigen');
	
	define('TITLE_PRIVACY_ACCOUNT_CONTACT',		'im Kundenbereich unter &quot;Kontodaten bearbeiten&quot; anzeigen');
	define('TITLE_PRIVACY_ACCOUNT_ADDRESS_BOOK','im Kundenbereich unter &quot;Adressbuch bearbeiten&quot; anzeigen');
	
	define('TITLE_PRIVACY_ACCOUNT_NEWSLETTER',	'in der Newsletterregistrierung anzeigen');

	define('TITLE_PRIVACY_CHECKOUT_SHIPPING',	'im Bestellvorgang unter &quot;Versandadresse&quot; anzeigen');
	define('TITLE_PRIVACY_CHECKOUT_PAYMENT',	'im Bestellvorgang unter &quot;Rechnungsadresse&quot; anzeigen');
	
?>