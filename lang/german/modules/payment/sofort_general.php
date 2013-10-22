<?php
/**
 * @version SOFORT Gateway 5.2.0 - $Date: 2012-11-21 12:09:39 +0100 (Wed, 21 Nov 2012) $
 * @author SOFORT AG (integration@sofort.com)
 * @link http://www.sofort.com/
 *
 * Copyright (c) 2012 SOFORT AG
 * 
 * Released under the GNU General Public License (Version 2)
 * [http://www.gnu.org/licenses/gpl-2.0.html]
 *
 * $Id: sofort_general.php 5725 2012-11-21 11:09:39Z rotsch $
 */

define('MODULE_PAYMENT_SOFORT_MULTIPAY_JS_LIBS', '
	<script type="text/javascript" src="'.DIR_WS_CATALOG.'callback/sofort/ressources/javascript/jquery.min_1.8.3.js"></script>
	<script type="text/javascript" src="'.DIR_WS_CATALOG.'callback/sofort/ressources/javascript/jquery-ui.min_1.9.1.js"></script>
	<script type="text/javascript" src="'.DIR_WS_CATALOG.'callback/sofort/ressources/javascript/sofortbox.js"></script>
');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY_TITLE', 'Konfigurationsschl�ssel');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_APIKEY_DESC', 'Von SOFORT AG zugewiesener Konfigurationsschl�ssel');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_AUTH_TITLE', 'Konfigurationsschl�ssel/API-Key testen');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_AUTH_DESC', '<noscript>Bitte Javascript aktivieren!</noscript>
	<script type="text/javascript" src="'.DIR_WS_CATALOG.'callback/sofort/ressources/javascript/jquery.min_1.8.3.js"></script>
	<script src="../callback/sofort/ressources/javascript/testAuth.js"></script>
');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_TITLE', 'Zahlungszone');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_ZONE_DESC', 'Wenn eine Zone ausgew�hlt ist, gilt die Zahlungsmethode nur f�r diese Zone.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_REASON_1_TITLE', 'Verwendungszweck 1');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_REASON_1_DESC', 'Im Verwendungszweck 1 k�nnen folgende Optionen ausgew�hlt werden');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_REASON_2_TITLE', 'Verwendungszweck 2');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_REASON_2_DESC', 'Im Verwendungszweck (maximal 27 Zeichen) werden folgende Platzhalter ersetzt:<br />{{order_date}}<br />{{customer_id}}<br />{{customer_name}}<br />{{customer_company}}<br />{{customer_email}}');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_ERROR_HEADING', 'Folgender Fehler wurde w�hrend des Prozesses gemeldet:');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEXT_ERROR_MESSAGE', 'Die gew�hlte Zahlart ist leider nicht m�glich oder wurde auf Kundenwunsch abgebrochen. Bitte w�hlen Sie eine andere Zahlweise.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_IMAGE_TITLE', 'Banner oder Text bei der Auswahl der Zahlungsoptionen');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_IMAGE_DESC', 'Banner oder Text bei der Auswahl der Zahlungsoptionen');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_PROF_SETTINGS_TITLE', '<span style="font-weight:bold; text-decoration:underline; font-size:1.4em;"><br />Profieinstellungen</span> ');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_PROF_SETTINGS_DESC', 'Folgende Einstellungen bed�rfen normalerweise keiner Anpassung und sollten bereits mit den korrekten Werten vorbelegt sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED_TITLE', 'Logging aktivieren');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_LOG_ENABLED_DESC', 'Aktivieren Sie das Logging, um Fehler, Warnungen sowie die Anfragen an und die Antworten von den SOFORT-Servern aufzuzeichnen. Das Logging sollte aus Datenschutzgr�nden nur zur Fehlersuche eingeschaltet sein. Weitere Informationen finden Sie im Handbuch.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEMP_STATUS_ID_TITLE', 'Tempor�rer Bestellstatus');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_TEMP_STATUS_ID_DESC', 'Bestellstatus f�r nicht abgeschlossene Transaktionen. Die Bestellung wurde erstellt aber die Transaktion von der SOFORT AG noch nicht best�tigt.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_ABORTED_STATUS_ID_TITLE', 'Bestellstatus bei abgebrochener Zahlung'); //Bestellstatus bei abgebrochener/erfolgloser Zahlung
define('MODULE_PAYMENT_SOFORT_MULTIPAY_ABORTED_STATUS_ID_DESC', 'Bestellstatus bei Bestellungen, die w�hrend des Bezahlvorgangs abgebrochen wurden.'); //Bestellstatus bei Bestellungen, die whrend des Bestellvorgangs oder im Wizard abgebrochen wurden.

define('MODULE_PAYMENT_SOFORT_MULTIPAY_ORDER_CANCELED', 'Die Bestellung wurde abgebrochen.'); //Die Bestellung wurde abgebrochen.

define('MODULE_PAYMENT_SOFORT_MULTIPAY_TRANSACTION_ID', 'Transaktions-ID');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_UPDATE_NOTICE', 'Sie haben eine neue Modulversion installiert. Zur korrekten Funktion m�ssen alle noch vorhandenen SOFORT Multipay-Zahlarten deinstalliert und anschlie�end wieder (nach Bedarf) installiert werden. Bis dahin werden die Zahlarten dem K�ufer nicht angeboten. Bitte notieren Sie sich vor der Deinstallation die Moduleinstellungen! Weitere Informationen finden Sie im Handbuch.');

define('MODULE_PAYMENT_SOFORT_MULTIPAY_FORWARDING', 'Ihre Anfrage wird gepr�ft, bitte gedulden Sie sich einen Moment und brechen Sie nicht ab. Der Vorgang kann bis zu 30 Sekunden dauern.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_VERSIONNUMBER', 'Versionsnummer');

define('MODULE_PAYMENT_SOFORT_KEYTEST_SUCCESS', 'API-Key erfolgreich validiert!');
define('MODULE_PAYMENT_SOFORT_KEYTEST_SUCCESS_DESC', 'Test OK am');
define('MODULE_PAYMENT_SOFORT_KEYTEST_ERROR', 'API-Key konnte nicht validiert werden!');
define('MODULE_PAYMENT_SOFORT_KEYTEST_ERROR_DESC', 'Achtung: API-Key fehlerhaft');
define('MODULE_PAYMENT_SOFORT_KEYTEST_DEFAULT', 'API-Key noch nicht getestet');

define('MODULE_PAYMENT_SOFORT_REFRESH_INFO', 'Falls Sie diese Bestellung gerade best�tigt, angepasst, storniert oder gutgeschrieben haben, m�ssen Sie diese Seite ggf. {{refresh}} damit alle �nderungen sichtbar werden.');
define('MODULE_PAYMENT_SOFORT_REFRESH_PAGE', 'Klicken Sie hier, um die Seite neu zu laden');
define('MODULE_PAYMENT_SOFORT_TRANSLATE_TIME', 'Zeit');

//definition of error-codes that can resolve by calling the SOFORT-API
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_0',		'Es ist ein unbekannter Fehler aufgetreten.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8002',		'Fehler bei der Validierung aufgetreten.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010',		'Die Daten sind unvollst�ndig oder fehlerhaft. Bitte korrigieren Sie diese oder kontaktieren Sie den Shopbetreiber.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8011',		'Nicht im Bereich g�ltiger Werte.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8012',		'Wert muss positiv sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8013',		'Es werden im Moment nur Bestellungen in Euro unterst�tzt. Bitte korrigieren Sie dies und versuchen es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8015',		'Der Gesamtbetrag ist zu gro� oder zu klein. Bitte korrigieren Sie dies oder kontaktieren Sie den Shopbetreiber.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8017',		'Unbekannte Zeichen.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8018',		'Maximale Anzahl an Zeichen �berschritten (max. 27).');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8019',		'Die Bestellung kann aufgrund fehlerhafter E-Mail-Adresse nicht durchgef�hrt werden. Bitte korrigieren Sie diese und versuchen Sie es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8020',		'Die Bestellung kann aufgrund fehlerhafter Telefonnummer nicht durchgef�hrt werden. Bitte korrigieren Sie diese und versuchen Sie es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8021',		'Die L�nderkennung wird nicht unterst�tzt, bitte wenden Sie sich an Ihren Shopbetreiber.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8022',		'Die angegebene BIC ist nicht g�ltig.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8023',		'Die Bestellung kann aufgrund fehlerhafter BIC (Bank Identifier Code) nicht durchgef�hrt werden. Bitte korrigieren Sie diese und versuchen Sie es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8024',		'Die Bestellung kann aufgrund fehlerhafter L�nderkennung nicht durchgef�hrt werden. Die Liefer-/Rechnungsadresse muss in Deutschland liegen. Bitte korrigieren Sie diese und versuchen Sie es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8029',		'Es werden nur deutsche Konten unterst�tzt. Bitte korrigieren Sie dies oder w�hlen Sie eine andere Zahlart.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8033',		'Der Gesamtbetrag ist zu hoch. Bitte korrigieren Sie dies und versuchen es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8034',		'Der Gesamtbetrag ist zu niedrig. Bitte korrigieren Sie dies und versuchen es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8041',		'Wert f�r Mehrwertsteuer fehlerhaft. G�ltige Werte: 0, 7 oder 19.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8046',		'Die Validierung des Bankkontos und der Bankleitzahl ist fehlgeschlagen.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8047',		'Die maximale Anzahl von 255 Zeichen wurde �berschritten.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8051',		'Die Anfrage enthielt ung�ltige Warenkorbpositionen. Bitte korrigieren Sie dies oder kontaktieren Sie den Shopbetreiber.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8058',		'Bitte geben Sie mindestens den Kontoinhaber an und versuchen Sie es dann erneut.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8061',		'Eine Transaktion mit den von Ihnen �bermittelten Daten existiert bereits.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8068',		'Kauf auf Rechnung steht momentan nur Privatkunden zur Verf�gung.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10001', 	'Bitte f�llen Sie die Felder Kontonummer, Bankleitzahl und Kontoinhaber vollst�ndig aus.'); //LS: holder and bankdata missing
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10002',	'Bitte die Datenschutzhinweise akzeptieren.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10003',	'Mit der gew�hlten Zahlart k�nnen Artikel wie Downloads oder Geschenkgutscheine leider nicht bezahlt werden.');  //RBS and virtual content is not allowed
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_10007',	'Es ist ein unbekannter Fehler aufgetreten.');  //Rechnung by SOFORT: check of shopamount against invoiceamount failed (more than one percent difference found)

//check for empty fields failed (code 8010 = 'must not be empty')
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.EMAIL_CUSTOMER',				'Die E-Mail-Adresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.PHONE_CUSTOMER',				'Die Telefonnummer darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.FIRSTNAME',	'Der Vorname der Rechnungsadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.FIRSTNAME',	'Der Vorname der Versandadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.LASTNAME',	'Der Nachname der Rechnungsadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.LASTNAME',	'Der Nachname der Versandadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.STREET',		'Stra�e und Hausnummer m�ssen durch ein Leerzeichen getrennt werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.STREET',		'Stra�e und Hausnummer m�ssen durch ein Leerzeichen getrennt werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.STREET_NUMBER',	'Stra�e und Hausnummer m�ssen durch ein Leerzeichen getrennt werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.STREET_NUMBER',	'Stra�e und Hausnummer m�ssen durch ein Leerzeichen getrennt werden.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.ZIPCODE',		'Die Postleitzahl der Rechnungsadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.ZIPCODE',	'Die Postleitzahl der Versandadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.CITY',		'Der St�dtename der Rechnungsadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.CITY',		'Der St�dtename der Versandadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.INVOICE_ADDRESS.COUNTRY_CODE',	'Das L�nderkennzeichen der Rechnungsadresse darf nicht leer sein.');
define('MODULE_PAYMENT_SOFORT_MULTIPAY_XML_FAULT_8010.SHIPPING_ADDRESS.COUNTRY_CODE',	'Das L�nderkennzeichen der Versandadresse darf nicht leer sein.');