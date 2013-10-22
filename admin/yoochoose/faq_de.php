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
Sie haben dazu die Wahl zwischen zwei verschiedenen Boxen, die Sie über die Template Einstellungen ein- und ausschalten können. Weiterhin können Sie dort auch die Position und Reihenfolge der Boxen verändern. Um eine andere Empfehlungsart in der Box zu verwenden, können Sie unter den Einstellungen für die YOOCHOOSE Recommendation auch die Art der Empfehlung anpassen.

<p class="question" style="margin-right: 300px;" >
2.  In welchen Online Shops machen Empfehlungen keinen Sinn
<p style="margin-right: 300px;">
Erfahrungsgemäß sind Empfehlungen dann besonders wertvoll wenn Sie mehr als 100 Produkte in Ihrem Shop anbieten und mindestens 10 Besucher am Tag haben.
Wenn Sie deutlich weniger Produkte anbieten sieht der Kunde all Ihre Produkte auch ohne Empfehlung (zu geringe Komplexität). Und wenn sie weniger Besucher haben, dann kann das System keine guten Erfahrungswerte sammeln.


<p class="question" style="margin-right: 300px;">
3.  Wie groß ist der Zeitaufwand für mich?
<p style="margin-right: 300px;">
Nachdem Sie sich in wenigen Minuten registriert haben und entschieden haben an welcher Stelle in Ihrem Shop Sie die Empfehlungen anzeigen wollen, läuft der Dienst automatisch. 
Weiterhin gibt es bei den Cross-Selling Funktionen für das Anlegen von manuellen Verknüpfungen eine zusätzliche Funktion, die Ihnen automatische Empfehlungen während des Anlegens von Verknüpfungen gibt, so dass Sie sogar Zeit einsparen.

<p class="question" style="margin-right: 300px;">
4.  Kann ich den Mehrwert der Empfehlungen messen oder statistisch belegen?
<p style="margin-right: 300px;">
In den Statistiken sehen Sie wie viele Recommendations angeklickt wurden und dadurch sehen Sie welche Seiten ein User überhaupt nur deswegen angeklickt hat weil Sie ihm die Recommendations angezeigt haben. 

<p class="question" style="margin-right: 300px;">
5.   Welche Daten werden von mir oder meinen Kunden gespeichert?
<p style="margin-right: 300px;">
a.  Es werden keine personenbezogenen Daten gespeichert. Eine Zuordnung der von uns erhobenen Daten (z.B. ein Kauf-Event) auf eine einzelne Person/Individuum ist nicht möglich. Das bedeutet für Sie, dass die Privatsphäre  Ihrer Kunden zu keiner Zeit gefährdet ist.  Aufgezeichnete und verwendete Daten sind "Warenkorb-Events" und "Klick- und Kaufevents" die sich auf eine Cockie oder Session-ID beziehen und damit nicht zurück zu verfolgen sind.



<a name="styleedit" style="margin-right: 300px;"></a>
<p class="question" style="margin-right: 300px;">
6. Warum kann ich die Seitenboxen mit Empfehlungen nicht aktivieren bzw. deaktivieren?
</p>
<p style="margin-right: 300px;">
Das Aktivieren und Deaktivieren von Seitenboxen ist in Gabmio nur dann möglich, wenn das
StyleEdit Plugin installiert ist. Siehe die Gambio Installationsanleitung für mehr Information!
Ohne StyleEdit können die Boxen Manuell über die Datei <code>template_settings.php</code> in Ihrem
Template-Verzeichnis auf dem Web-Server angesteuert werden.
</p>


<a name="firewall"></a>
<p class="question" style="margin-right: 300px;">
7. Meine Statistik oder der Lizenzschlüssel kann nicht geladen werden.
Wie sind die Firewall Einstellungen für den Zugriff auf YOOCHOOSE Server?
</p>
<p style="margin-right: 300px;">
Ihr Web-Server muss auf zwei unserer Server über HTTP Protokoll (Port 80) zugreifen können:
Recommendation Server (<?php echo YOOCHOOSE_RECO_SERVER_DEFAULT; ?>) und Configuration Server
(<?php echo YOOCHOOSE_REG_SERVER_DEFAULT; ?>). Stellen Sie sicher, dass Ihre Firewall
entsprechend konfiguriert ist. <a href="yoochoose.php?page=check">Hier</a> könne Sie Ihre Konfiguration testen. 
</p>


</div>