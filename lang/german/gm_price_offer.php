<?php
/* --------------------------------------------------------------
   gm_price_offer.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------
*/
?><?php



global $gmLangFileMaster;
$gmLangFileMaster->define_lang_file_content('lang/german/gm_price_offer.php');
/*


define('GM_PRICE_OFFER_NAVBAR_TITLE','Woanders g&uuml;nstiger?');
define('GM_PRICE_OFFER_TITLE',' woanders g&uuml;nstiger gesehen?');

define('GM_PRICE_OFFER_INFO','Woanders billiger gesehen? Sagen Sie uns wo und zu welchem Preis, und wir werden pr&uuml;fen, ob wir den Preis halten k&ouml;nnen:');

define('GM_PRICE_OFFER_TEXT','Wenn Sie diesen Artikel bei einem anderen Anbieter g&uuml;nstiger gesehen haben, teilen Sie uns dies bitte mit. F&uuml;llen Sie dazu bitte einfach das unten stehende Formular aus und schicken es ab. Wir werden uns anschließend schnellstm&ouml;glich mit Ihnen in Verbindung setzen.');
define('GM_PRICE_OFFER_OUR_PRICE','Unser Preis:');
define('GM_PRICE_OFFER_NECESSARY_INFO','* notwendige Informationen');
define('GM_PRICE_OFFER_NAME','Ihr Name:');
define('GM_PRICE_OFFER_EMAIL','Ihre E-Mail:');
define('GM_PRICE_OFFER_TELEPHONE','Telefonnummer:');
define('GM_PRICE_OFFER_PRICE','Angebotspreis:');
define('GM_PRICE_OFFER_OFFERER','Fremdanbieter:');
define('GM_PRICE_OFFER_LINK','Angebotslink:');
define('GM_PRICE_OFFER_MESSAGE','Anmerkung:');

define('GM_PRICE_OFFER_WRONG_CODE', 'Inkorrekter Code!');
define('GM_PRICE_OFFER_VALIDATION', 'Sicherheitscode:');

*/

// Umlaute nicht in HTML-Code umwandeln!
define('GM_PRICE_OFFER_MAIL_SUBJECT','günstiger gesehen: ');
define('GM_PRICE_OFFER_MAIL_CUSTOMER','Kunde: ');
define('GM_PRICE_OFFER_MAIL_EMAIL','E-Mail: ');
define('GM_PRICE_OFFER_MAIL_TELEPHONE','Telefonnummer: ');
define('GM_PRICE_OFFER_MAIL_PRICE','Preis des günstigeren Angebotes:');
define('GM_PRICE_OFFER_MAIL_OFFERER','Name des fremden Anbieters:');
define('GM_PRICE_OFFER_MAIL_LINK','Link zum günstigeren Angebot:');
define('GM_PRICE_OFFER_MAIL_MESSAGE','Anmerkung:');

define('GM_PRICE_OFFER_MAIL_OUT','Vielen Dank! Ihre Anfrage wurde erfolgreich versendet.');
define('GM_PRICE_OFFER_ERROR','Die Anfrage konnte nicht abgesendet werden, da Sie entweder Name, E-Mail oder den Link zum g&uuml;nstigeren Angebot nicht angegeben haben.');
?>
