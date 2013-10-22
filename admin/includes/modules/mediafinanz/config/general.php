<?php
/* --------------------------------------------------------------
   general.php 2012-11-06 gm
   Gambio GmbH
   http://www.gambio.de
   Copyright (c) 2012 Gambio GmbH
   Released under the GNU General Public License (Version 2)
   [http://www.gnu.org/licenses/gpl-2.0.html]
   --------------------------------------------------------------

/* -----------------------------------------------------------------------------------------
   Copyright (c) 2011 mediafinanz AG

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU General Public License as published by
   the Free Software Foundation, either version 3 of the License, or
   (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU General Public License for more details.

   You should have received a copy of the GNU General Public License
   along with this program.  If not, see http://www.gnu.org/licenses/.
   ---------------------------------------------------------------------------------------

 * @author Marcel Kirsch
 */

if ($store)
{
    $config->storeValue('clientLicence', xtc_db_input(trim($_POST['clientLicence'])));
    $config->storeValue('clientId', (int)($_POST['clientId']));
    $config->storeValue('sandbox', (int)($_POST['sandbox']));

    $msg = '<strong style="font-size:14px;">Daten gespeichert!</strong>';
}

$coo_mediafinanz = MainFactory::create_object('GMDataObject', array('mf_config', array('config_key' => 'clientLicence')));
$t_mediafinanz_licence = $coo_mediafinanz->get_data_value('config_value');

if(empty($t_mediafinanz_licence) == false || isset($_GET['show_registerKey']))
{
	$registerKey = $config->getValue('registrationKey');
	if (strlen($registerKey) == 0)
	{
		$registrationService = new MF_Registration();
		$registerKey = $registrationService->createRegistrationKey();
		$config->storeValue('registrationKey', $registerKey);
	}
}
?>
<tr>
    <td id="configtitle" colspan="2"><br />Erste Schritte</td>
</tr>
<tr>
    <td id="smallText" colspan="2">Um dieses Modul nutzen zu k&ouml;nnen, m&uuml;ssen Sie die folgenden Schritte durchf&uuml;hren:
        <ol>
            <li>Loggen Sie sich in das mediafinanz Mandanten-Online-System ein. Sollten Sie noch kein Mandant bei mediafinanz sein, k&ouml;nnen Sie sich <a href="http://www.mediafinanz.de/de/service/zugangsdaten?ref=Partner_Gambio" target="_blank">hier</a> anmelden.</li>
            <li>Gehen Sie auf die Unterseite <a href="https://mandos.mediafinanz.de/api" target="_blank">https://mandos.mediafinanz.de/api</a> und tragen Sie dort den Registrierungsschl&uuml;ssel<div id="registrationKey"><?php echo $registerKey;?></div>ein. <a href="<?php echo xtc_href_link('mediafinanz.php', 'action=config&show_registerKey=1'); ?>">Registrierungsschl&uuml;ssel anfordern</a></li>
            <li>&Uuml;bertragen Sie die nun generierten Werte &quot;Mandanten-ID&quot; und &quot;Mandanten-Lizenz&quot; in die unten stehenden Formularfelder.</li>
            <li>Konfigurieren und testen Sie das Modul, bevor Sie den Sandbox-Modus ausschalten.</li>
        </ol>
    </td>
</tr>
<tr>
    <td id="configtitle" colspan="2"><br />Allgemeine Optionen</td>
</tr>
<tr>
    <td class="smallText"><b>Version</b></td>
    <td class="smallText"><?php echo $config->getValue('version'); ?></td>
</tr>
<tr>
    <td class="smallText"><b>Sandbox Modus einschalten?</b></td>
    <td class="smallText">
<?php

if ($config->getValue('sandbox') == 1)
{
    echo '<input type="radio" name="sandbox" value="1" checked>Aktiv</input> <input type="radio" name="sandbox" value="0">Inaktiv</input>';
}
else
{
    echo '<input type="radio" name="sandbox" value="1">Aktiv</input> <input type="radio" name="sandbox" value="0" checked>Inaktiv</input>';
}

?>
    </td>
</tr>
<tr>
    <td class="smallText"><b>Mandantenlizenz</b></td>
    <td class="smallText"><input type="text" name="clientLicence" size="50" value="<?php echo $config->getValue('clientLicence'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Mandanten Id</b></td>
    <td class="smallText"><input type="text" name="clientId" size="5" value="<?php echo $config->getValue('clientId'); ?>"/></td>
</tr>
