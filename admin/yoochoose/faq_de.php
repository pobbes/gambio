<?php
/* --------------------------------------------------------------
   Yoochoose GmbH
   http://www.yoochoose.com
   Copyright (c) 2011 Yoochoose GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   -------------------------------------------------------------- */

defined('_VALID_XTC') or die('Direct Access to this location is not allowed.');
?>

<div style="padding: 20px 40px 40px 40px;" class="yoo-image2-large">

<h2>Oft gestellte Fragen</h2>

<p class="question" style="margin-right: 300px; margin-top: 1.5em;" >
1.  Wie sieht die Darstellung der Ausspielung von Empfehlungen auf meiner Seite aus?
<p style="margin-right: 300px;">
Sie haben dazu die Wahl zwischen zwei verschiedenen Boxen, die Sie �ber die Template Einstellungen ein- und ausschalten k�nnen. Weiterhin k�nnen Sie dort auch die Position und Reihenfolge der Boxen ver�ndern. Um eine andere Empfehlungsart in der Box zu verwenden, k�nnen Sie unter den Einstellungen f�r die YOOCHOOSE Recommendation auch die Art der Empfehlung anpassen.

<p class="question" style="margin-right: 300px;" >
2.  In welchen Online Shops machen Empfehlungen keinen Sinn
<p style="margin-right: 300px;">
Erfahrungsgem�� sind Empfehlungen dann besonders wertvoll wenn Sie mehr als 100 Produkte in Ihrem Shop anbieten und mindestens 10 Besucher am Tag haben.
Wenn Sie deutlich weniger Produkte anbieten sieht der Kunde all Ihre Produkte auch ohne Empfehlung (zu geringe Komplexit�t). Und wenn sie weniger Besucher haben, dann kann das System keine guten Erfahrungswerte sammeln.


<p class="question" style="margin-right: 300px;">
3.  Wie gro� ist der Zeitaufwand f�r mich?
<p style="margin-right: 300px;">
Nachdem Sie sich in wenigen Minuten registriert haben und entschieden haben an welcher Stelle in Ihrem Shop Sie die Empfehlungen anzeigen wollen, l�uft der Dienst automatisch. 
Weiterhin gibt es bei den Cross-Selling Funktionen f�r das Anlegen von manuellen Verkn�pfungen eine zus�tzliche Funktion, die Ihnen automatische Empfehlungen w�hrend des Anlegens von Verkn�pfungen gibt, so dass Sie sogar Zeit einsparen.

<p class="question" style="margin-right: 300px;">
4.  Kann ich den Mehrwert der Empfehlungen messen oder statistisch belegen?
<p style="margin-right: 300px;">
In den Statistiken sehen Sie wie viele Recommendations angeklickt wurden und dadurch sehen Sie welche Seiten ein User �berhaupt nur deswegen angeklickt hat weil Sie ihm die Recommendations angezeigt haben. 

<p class="question" style="margin-right: 300px;">
5.   Welche Daten werden von mir oder meinen Kunden gespeichert?
<p style="margin-right: 300px;">
a.  Es werden keine personenbezogenen Daten gespeichert. Eine Zuordnung der von uns erhobenen Daten (z.B. ein Kauf-Event) auf eine einzelne Person/Individuum ist nicht m�glich. Das bedeutet f�r Sie, dass die Privatsph�re  Ihrer Kunden zu keiner Zeit gef�hrdet ist.  Aufgezeichnete und verwendete Daten sind "Warenkorb-Events" und "Klick- und Kaufevents" die sich auf eine Cockie oder Session-ID beziehen und damit nicht zur�ck zu verfolgen sind.



<a name="styleedit" style="margin-right: 300px;"></a>
<p class="question" style="margin-right: 300px;">
6. Warum kann ich die Seitenboxen mit Empfehlungen nicht aktivieren bzw. deaktivieren?
</p>
<p style="margin-right: 300px;">
Das Aktivieren und Deaktivieren von Seitenboxen ist in Gabmio nur dann m�glich, wenn das
StyleEdit Plugin installiert ist. Siehe die Gambio Installationsanleitung f�r mehr Information!
Ohne StyleEdit k�nnen die Boxen Manuell �ber die Datei <code>template_settings.php</code> in Ihrem
Template-Verzeichnis auf dem Web-Server angesteuert werden.
</p>


<a name="firewall"></a>
<p class="question" style="margin-right: 300px;">
7. Meine Statistik oder der Lizenzschl�ssel kann nicht geladen werden.
Wie sind die Firewall Einstellungen f�r den Zugriff auf YOOCHOOSE Server?
</p>
<p style="margin-right: 300px;">
Ihr Web-Server muss auf zwei unserer Server �ber HTTP Protokoll (Port 80) zugreifen k�nnen:
Recommendation Server (<?php echo YOOCHOOSE_RECO_SERVER_DEFAULT; ?>) und Configuration Server
(<?php echo YOOCHOOSE_REG_SERVER_DEFAULT; ?>). Stellen Sie sicher, dass Ihre Firewall
entsprechend konfiguriert ist. <a href="yoochoose.php?page=check">Hier</a> k�nne Sie Ihre Konfiguration testen. 
</p>


</div>