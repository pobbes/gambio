<?php
/* --------------------------------------------------------------
   backup.php 2008-08-10 gambio
   Gambio OHG
   http://www.gambio.de
   Copyright (c) 2008 Gambio OHG
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------


   based on: 
   (c) 2000-2001 The Exchange Project  (earlier name of osCommerce)
   (c) 2002-2003 osCommerce(backup.php,v 1.21 2002/06/15); www.oscommerce.com 
   (c) 2003	 nextcommerce (backup.php,v 1.4 2003/08/14); www.nextcommerce.org
   (c) 2003 XT-Commerce - community made shopping http://www.xt-commerce.com ($Id: backup.php 899 2005-04-29 02:40:57Z hhgag $)

   Released under the GNU General Public License 
   --------------------------------------------------------------*/

define('HEADING_TITLE', 'Datenbanksicherung'); 

// BOF GM_MOD
define('HEADING_SUB_TITLE', 'Hilfsprogramme');
// EOF GM_MOD

define('TABLE_HEADING_TITLE', 'Titel');
define('TABLE_HEADING_FILE_DATE', 'Datum');
define('TABLE_HEADING_FILE_SIZE', 'Gr&ouml;&szlig;e');
define('TABLE_HEADING_ACTION', 'Aktion');
define('TEXT_MARKED_ELEMENTS','Markiertes Element');
define('TEXT_INFO_HEADING_NEW_BACKUP', 'Neue Sicherung');
define('TEXT_INFO_HEADING_RESTORE_LOCAL', 'Lokal wiederherstellen');
define('TEXT_INFO_NEW_BACKUP', 'Bitte den Sicherungsprozess AUF KEINEN FALL unterbrechen. Dieser kann einige Minuten in Anspruch nehmen.<br /><br /><strong>Hinweis:</strong> Es werden keine Artikelbilder und Shopdateien  gesichert! Diese k&ouml;nnen Sie separat mit einem FTP-Programm herunterladen, um sie lokal zu sichern.<br /><br />Bricht der Sicherungsprozess ab und es erscheint eine wei&szlig;e Seite oder eine Fehlermeldung, ist eine Erstellung einer Datenbanksicherung &uuml;ber dieses Modul nicht m&ouml;glich, da die Serverkonfiguration nicht gen&uuml;gend Speicher oder Ausf&uuml;hrungszeit f&uuml;r den Prozess zur Verf&uuml;gung stellt. Eine Sicherung sollten Sie dann im Kundenbereich Ihres Providers &uuml;ber die Datenbankverwaltung phpMyAdmin durchf&uuml;hren. Eine Anleitung dazu finden Sie im Gambio Handbuch.');
define('TEXT_INFO_UNPACK', '<br /><br />(nach dem die Dateien aus dem Archiv extrahiert wurden)');
define('TEXT_INFO_RESTORE', 'Den Wiederherstellungsprozess AUF KEINEN FALL unterbrechen.<br /><br />Je gr&ouml;sser die Sicherungsdatei, desto l&auml;nger dauert die Wiederherstellung!<br /><br />Bitte, wenn m&ouml;glich, den mysql client benutzen.<br /><br />Beispiel:<br /><br /><b>mysql -h' . DB_SERVER . ' -u' . DB_SERVER_USERNAME . ' -p ' . DB_DATABASE . ' < %s </b> %s');
define('TEXT_INFO_RESTORE_LOCAL', 'Den Wiederherstellungsprozess AUF KEINEN FALL unterbrechen.<br /><br />Je gr&ouml;sser die Sicherungsdatei, desto l&auml;nger dauert die Wiederherstellung!');
define('TEXT_INFO_RESTORE_LOCAL_RAW_FILE', 'Die Datei, welche hochgeladen wird, muss eine sog. Raw SQL Datei sein (nur Text).');
define('TEXT_INFO_DATE', 'Datum:');
define('TEXT_INFO_SIZE', 'Gr&ouml;&szlig;e:');
define('TEXT_INFO_COMPRESSION', 'Komprimierung:');
define('TEXT_INFO_USE_GZIP', 'mit GZip');
define('TEXT_INFO_USE_ZIP', 'mit Zip');
define('TEXT_INFO_USE_NO_COMPRESSION', 'Keine Komprimierung (<strong>empfohlen</strong>)');
define('TEXT_INFO_DOWNLOAD_ONLY', 'Nur herunterladen (nicht auf dem Server speichern)');
define('TEXT_INFO_BEST_THROUGH_HTTPS', 'Sichere HTTPS Verbindung verwenden!');
define('TEXT_NO_EXTENSION', 'keine');
define('TEXT_BACKUP_DIRECTORY', 'Sicherungsverzeichnis:');
define('TEXT_LAST_RESTORATION', 'Letzte Wiederherstellung:');
define('TEXT_FORGET', '(<u>vergessen</u>)');
define('TEXT_DELETE_INTRO', 'Sind Sie sicher, dass Sie diese Sicherung l&ouml;schen m&ouml;chten?');

define('ERROR_BACKUP_DIRECTORY_DOES_NOT_EXIST', 'Fehler: Das Sicherungsverzeichnis ist nicht vorhanden.');
define('ERROR_BACKUP_DIRECTORY_NOT_WRITEABLE', 'Fehler: Das Sicherungsverzeichnis ist schreibgesch&uuml;tzt.');
define('ERROR_DOWNLOAD_LINK_NOT_ACCEPTABLE', 'Fehler: Downloadlink nicht akzeptabel.');

define('SUCCESS_LAST_RESTORE_CLEARED', 'Erfolg: Das letzte Wiederherstellungdatum wurde gel&ouml;scht.');
define('SUCCESS_DATABASE_SAVED', 'Erfolg: Die Datenbank wurde gesichert.');
define('SUCCESS_DATABASE_RESTORED', 'Erfolg: Die Datenbank wurde wiederhergestellt.');
define('SUCCESS_BACKUP_DELETED', 'Erfolg: Die Sicherungsdatei wurde gel&ouml;scht.');
?>