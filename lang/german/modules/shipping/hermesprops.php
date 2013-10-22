<?php
/* --------------------------------------------------------------
   item.php 2011 gambio
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2011 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(item.php,v 1.6 2003/02/16); www.oscommerce.com 
   (c) 2003	 nextcommerce (item.php,v 1.4 2003/08/13); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: item.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   ---------------------------------------------------------------------------------------*/

define('MODULE_SHIPPING_HERMESPROPS_TEXT_TITLE', 'Hermes-Versand');
define('MODULE_SHIPPING_HERMESPROPS_TEXT_DESCRIPTION', 'Versand mit Hermes ProfiPaketService');
define('MODULE_SHIPPING_HERMESPROPS_TEXT_WAY', 'Standard');
define('MODULE_SHIPPING_HERMESPROPS_STATUS_TITLE' , 'Versand mit Hermes aktivieren');
define('MODULE_SHIPPING_HERMESPROPS_STATUS_DESC' , 'M&ouml;chten Sie Versand mit Hermes anbieten?');
define('MODULE_SHIPPING_HERMESPROPS_ALLOWED_TITLE' , 'Erlaubte Versandzonen');
define('MODULE_SHIPPING_HERMESPROPS_ALLOWED_DESC' , 'Geben Sie <b>einzeln</b> die Zonen an, in welche ein Versand m�glich sein soll. (z.B. AT,DE (lassen Sie dieses Feld leer, wenn Sie alle Zonen erlauben wollen))');

define('MODULE_SHIPPING_HERMESPROPS_COST_XS_TITLE' , 'Versandkosten Paketklasse XS');
define('MODULE_SHIPPING_HERMESPROPS_COST_XS_DESC' , 'Versandkosten f�r den Versand mit Paketklasse XS');
define('MODULE_SHIPPING_HERMESPROPS_COST_S_TITLE' , 'Versandkosten Paketklasse S');
define('MODULE_SHIPPING_HERMESPROPS_COST_S_DESC' , 'Versandkosten f�r den Versand mit Paketklasse S');
define('MODULE_SHIPPING_HERMESPROPS_COST_M_TITLE' , 'Versandkosten Paketklasse M');
define('MODULE_SHIPPING_HERMESPROPS_COST_M_DESC' , 'Versandkosten f�r den Versand mit Paketklasse M');
define('MODULE_SHIPPING_HERMESPROPS_COST_L_TITLE' , 'Versandkosten Paketklasse L');
define('MODULE_SHIPPING_HERMESPROPS_COST_L_DESC' , 'Versandkosten f�r den Versand mit Paketklasse L');
define('MODULE_SHIPPING_HERMESPROPS_COST_XL_TITLE' , 'Versandkosten Paketklasse XL');
define('MODULE_SHIPPING_HERMESPROPS_COST_XL_DESC' , 'Versandkosten f�r den Versand mit Paketklasse XL');
define('MODULE_SHIPPING_HERMESPROPS_COST_XXL_TITLE' , 'Versandkosten Paketklasse XXL');
define('MODULE_SHIPPING_HERMESPROPS_COST_XXL_DESC' , 'Versandkosten f�r den Versand mit Paketklasse XXL');

define('MODULE_SHIPPING_HERMESPROPS_HANDLING_TITLE' , 'Handling Geb&uuml;hr');
define('MODULE_SHIPPING_HERMESPROPS_HANDLING_DESC' , 'Handling Geb&uuml;hr f�r diese Versandart.');
define('MODULE_SHIPPING_HERMESPROPS_TAX_CLASS_TITLE' , 'Steuerklasse');
define('MODULE_SHIPPING_HERMESPROPS_TAX_CLASS_DESC' , 'Folgende Steuerklasse an Versandkosten anwenden');
define('MODULE_SHIPPING_HERMESPROPS_ZONE_TITLE' , 'Versandzone');
define('MODULE_SHIPPING_HERMESPROPS_ZONE_DESC' , 'Wenn eine Zone ausgew&auml;hlt ist, wird diese Versandmethode ausschlie&szlig;lich f&uuml;r diese Zone angewendet');
define('MODULE_SHIPPING_HERMESPROPS_SORT_ORDER_TITLE' , 'Sortierreihenfolge');
define('MODULE_SHIPPING_HERMESPROPS_SORT_ORDER_DESC' , 'Reihenfolge der Anzeige');
define('MODULE_SHIPPING_HERMESPROPS_PARTNERID_TITLE', 'PartnerID');
define('MODULE_SHIPPING_HERMESPROPS_PARTNERID_DESC', 'PartnerID f�r den Zugang zum ProPS');
define('MODULE_SHIPPING_HERMESPROPS_APIPASSWORD_TITLE', 'API-Passwort');
define('MODULE_SHIPPING_HERMESPROPS_APIPASSWORD_DESC', 'API-Passwort f�r den Zugang zum ProPS');
define('MODULE_SHIPPING_HERMESPROPS_USERNAME_TITLE', 'Benutzername');
define('MODULE_SHIPPING_HERMESPROPS_USERNAME_DESC', 'Benutzername f�r das ProPS-Portal');
define('MODULE_SHIPPING_HERMESPROPS_PASSWORD_TITLE', 'Passwort');
define('MODULE_SHIPPING_HERMESPROPS_PASSWORD_DESC', 'Passwort f�r das ProPS-Portal');
define('MODULE_SHIPPING_HERMESPROPS_MODE_TITLE', 'Sandbox-Modus');
define('MODULE_SHIPPING_HERMESPROPS_MODE_DESC', 'Sandbox f�r Tests aktivieren (sonst Produktivbetrieb)');
define('MODULE_SHIPPING_HERMESPROPS_LABELPOS_TITLE', 'Position des Versandlabels');
define('MODULE_SHIPPING_HERMESPROPS_LABELPOS_DESC', '1 - oben links<br>2 - oben rechts<br>3 - unten links<br>4 - unten rechts');
define('MODULE_SHIPPING_HERMESPROPS_SERVICE_TITLE', 'Dienst');
define('MODULE_SHIPPING_HERMESPROPS_SERVICE_DESC', 'Verwendeter Dienst (ProPS = ProfiPaketService, PriPS = PrivatPaketService)<br>Achtung, PriPS-Modus nicht verf&uuml;gbar!');

define('MODULE_SHIPPING_HERMESPROPS_ERROR_100110', 'Needed role is not assigned to consumer.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_900000', 'Exception');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_901000', 'SQL-Exception ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310001', 'Fehler beim Auslesen der ConsumerData.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310010', 'Der Consumer-Name ist leer.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310011', 'Der Consumer-Name ist ung�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310012', 'Das Consumer-Passwort ist leer.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310013', 'Das Consumer-Passwort ist ung�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310014', 'Das Consumer-Token ist leer.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310015', 'Das Consumer-Token ist ung�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310020', 'Interner Fehler beim Aufruf des Authentifizierung Service.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310021', 'Die Authentifizierungsantwort ist ung�ltig.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310022', 'Die Consumer Rolle ist ung�ltig.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310023', 'Die Consumer Authentifizierung ist fehlerhaft.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310024', 'Dem Consumer fehlt die notwendige Rollenzuweisung.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310025', 'Die Rollenzuweisung ist noch nicht g�ltig.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310026', 'Die Rollenzuweisung ist nicht mehr g�ltig.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310027', 'Die Providerauswahl ist nicht g�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310028', 'Fehler beim Setzen des ConsumerTokens in der Response. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310029', 'Das Entschl�sseln des ConsumerTokens ist fehlgeschlagen. Ung�ltiges ConsumerToken:  ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_310030', 'Der Verschl�sselungs-Key ist ung�ltig.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312001', 'Die Partner-ID ist leer.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312002', 'Die Partner-ID ist ung�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312003', 'Es wurde kein API-Partner geladen.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312011', 'Das Usertoken ist leer.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312012', 'Das Usertoken ist ung�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312013', 'Es ist ein Fehler beim Validieren des Usertokens aufgetreten. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312021', 'Die API-Version ist nicht verf�gbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312022', 'Der Eintrag zum Sandboxmodus ist nicht verf�gbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312023', 'Der Backend Server ist nicht verf�gbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312024', 'Der Portal Server ist nicht verf�gbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312025', 'Der Resourcen Server ist nicht verf�gbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312026', 'Die Resourcen Properties sind nicht verf�gbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312030', 'Es existiert kein Propertieswert zu diesem Key:  ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312031', 'Die Nachladezeit ist ung�ltig: ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312032', 'Es konnte kein Partner geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312033', 'Es ist ein Fehler beim Laden des Partners aufgetreten.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312100', 'Interner Server Fehler. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312110', 'Interner Fehler beim Erstellen des Auftrags. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312113', 'Die Paketklasse des Auftrags ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312114', 'Die Paketklasse des Auftrags ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312115', 'Es ist keine Nachnahme f�r Auslandssendungen m�glich.  ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312116', 'Der Nachnahmebetrag ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312117', 'Der Nachnahmebetrag ist zu klein.'); 
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312118', 'Der Nachnahmebetrag ist zu gro�.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312119', 'Der Auftraggeber hat keine g�ltige Bankverbindung f�r die Nachnahme im System hinterlegt.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312121', 'Der Nachname des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312122', 'Der Nachname des Empf�ngers ist ung�ltig:  ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312123', 'Der Nachname des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312124', 'Der Nachname des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312125', 'Der Vorname des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312126', 'Der Vorname des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312127', 'Der Vorname des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312128', 'Der Vorname des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312129', 'Der Adresszusatz des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312130', 'Der Adresszusatz des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312131', 'Der Adresszusatz des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312132', 'Der Adresszusatz des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312133', 'Packstation oder Postfach wird nicht als Adresszusatz des Empf�ngers akzeptiert.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312134', 'Die Stra�e des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312135', 'Die Stra�e des Empf�ngers ist ung�ltig:  ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312136', 'Die Stra�e des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312137', 'Die Stra�e des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312138', 'Packstation oder Postfach wird nicht als Stra�e des Empf�ngers akzeptiert.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312139', 'Die Hausnummer des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312140', 'Die Hausnummer des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312141', 'Die Hausnummer des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312142', 'Die Hausnummer des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312143', 'Die Postleitzahl des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312144', 'Die Postleitzahl des Empf�ngers ist ung�ltig:  ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312145', 'Die Postleitzahl des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312146', 'Die Postleitzahl des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312147', 'Der Ort des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312148', 'Der Ort des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312149', 'Der Ort des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312150', 'Der Ort des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312151', 'Der Ortsteil des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312152', 'Der Ortsteil des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312153', 'Der Ortsteil des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312154', 'Der Ortsteil des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312155', 'Der L�ndercode des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312156', 'Der L�ndercode des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312157', 'Der L�ndercode des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312158', 'Der L�ndercode des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312159', 'Die Telefonvorwahl des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312160', 'Die Telefonvorwahl des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312161', 'Die Telefonvorwahl des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312162', 'Die Telefonvorwahl des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312163', 'Die Telefonnummer des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312164', 'Die Telefonnummer des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312165', 'Die Telefonnummer des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312166', 'Die Telefonnummer des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312167', 'Die E-Mail des Empf�ngers ist leer. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312168', 'Die E-Mail des Empf�ngers ist ung�ltig:');  
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312169', 'Die E-Mail des Empf�ngers ist zu kurz. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312170', 'Die E-Mail des Empf�ngers ist zu lang. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312171', 'Die Anzahl der zu speichernden Auftr�ge ist zu hoch.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312172', 'Die Anzahl der zu druckenden Auftr�ge ist zu hoch.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312301', 'Der Benutzername oder das  Kennwort ist falsch.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312302', 'Die ProPS Auftraggeberdaten konnten nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312303', 'Die ProPS Auftraggeberdaten konnten nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312304', 'Die ProPS Auftraggeberdaten konnten nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312305', 'Die ProPS Auftraggeberdaten konnten nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312306', 'Die ProPS Auftraggeberdaten konnten nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312307', 'Die ProPS Auftraggeberdaten konnten nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312308', 'Der Auftrag ist nicht vorhanden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312309', 'Der Auftrag ist nicht mehr �nderbar.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312310', 'Der Auftrag kann nicht gedruckt werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312311', 'Der Auftrag kann nicht gel�scht werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312312', 'Der Auftrag kann nicht gespeichert werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312313', 'Die Abholung wurde nicht beauftragt. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312314', 'Die Abholung wurde nicht beauftragt. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312315', 'Die AGB wurden angepasst. Bitte melden Sie sich am Hermes ProfiPaketService Portal an, um den AGB zuzustimmen. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312316', 'Ihre Preise wurden angepasst. Bitte melden Sie sich am Hermes ProfiPaketService Portal an, um den Preisen zuzustimmen. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312317', 'Der Benutzer hat keine ProPS Berechtigung. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312318', 'Die Startposition f�r den Druck muss zwischen 1 und 4 liegen. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312319', 'Ihr Account wird geschlossen. F�r n�here Informationen melden Sie sich am Hermes ProfiPaketService Portal an.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312320', 'Das Standardvolumen f�r die Paketklassen konnte nicht geladen werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312321', 'Die Abholmenge ist ung�ltig. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312322', 'Das Abholdatum ist ung�ltig. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312323', 'Die Abholung konnte nicht storniert werden. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312324', 'Es ist keine Abholung zu diesem Termin vorhanden. Eine Stornierung ist nicht notwendig. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312325', 'Die gew�hlte Empf�ngeradresse kann �ber diesen Service nicht beliefert werden. Folgende Zustellgebiete sind ausgeschlossen: Frankreich: Oversea Departments Italien: Livigno, San Marino, Vatikanstadt Portugal: Azoren, Madeira Spanien: Ceuta, Kanaren, Melilla. Bei Fragen wenden Sie sich bitte an den Kundenservice.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312326', 'Die eingegebene Postleitzahl konnte nicht gefunden werden. Bitte �berpr�fen Sie Ihre Eingaben.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312327', 'Unbekannter Fehler des DPD-Routingmoduls. Der Auftrag wurde nicht gespeichert.');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312328', 'Unbekannter P3SErrorCode. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312350', 'Fehler beim Laden der L�nderliste ProPS. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312351', 'Fehler beim Laden der L�nderausnahmen. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312352', 'Fehler beim Laden der nationalen Sendungspreise. ');
define('MODULE_SHIPPING_HERMESPROPS_ERROR_312353', 'Fehler beim Laden der internationalen Sendungspreise. ');
