<?php

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
    $config->storeValue('recheckSuspect', (int)($_POST['recheckSuspect']));
    $config->storeValue('paymentModules', strtolower(str_replace(' ', '', xtc_db_input($_POST['paymentModules']))));
    $config->storeValue('orderTotal', (int)($_POST['orderTotal']));
    $config->storeValue('allowPaymentWithNoResult', (int)($_POST['allowPaymentWithNoResult']));
    $config->storeValue('requestType', $_POST['requestType']);
    $config->storeValue('requestOnModules', strtolower(str_replace(' ', '', xtc_db_input($_POST['requestOnModules']))));
    $config->storeValue('paymentErrorText', xtc_db_input($_POST['paymentErrorText']));
    $config->storeValue('minAmountForRequest', (int) xtc_db_input($_POST['minAmountForRequest']));
    $config->storeValue('maxAmountForRequest', (int) xtc_db_input($_POST['maxAmountForRequest']));
    $config->storeValue('allowPaymentUnderMinAmount', (int) xtc_db_input($_POST['allowPaymentUnderMinAmount']));
    $config->storeValue('allowPaymentOverMaxAmount',(int) xtc_db_input($_POST['allowPaymentOverMaxAmount']));

    $msg = '<strong style="font-size:14px;">Daten gespeichert!</strong>';
}

?>

<tr>
    <td id="configtitle" colspan="2"><br />Allgemeine Bonit&auml;ts Optionen</td>
</tr>
<tr>
    <td class="smallText"><b>Mindestbestellwert (Ganzzahlig)</b></td>
    <td class="smallText"><input type="text" name="minAmountForRequest" size="50" value="<?php echo $config->getValue('minAmountForRequest'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Zahlungsmodule unter Mindestbestellwert ausblenden</b></td>
    <td class="smallText">
    <?php

    if ($config->getValue('allowPaymentUnderMinAmount') == 1)
    {
        echo '<input type="radio" name="allowPaymentUnderMinAmount" value="0">Aktiv</input><br />
              <input type="radio" name="allowPaymentUnderMinAmount" value="1" checked>Inaktiv</input>';
    }
    else
    {
        echo '<input type="radio" name="allowPaymentUnderMinAmount" value="0" checked>Aktiv</input><br />
              <input type="radio" name="allowPaymentUnderMinAmount" value="1">Inaktiv</input>';
    }
    ?>
    </td>
</tr>
<tr>
    <td class="smallText"><b>Maximalbestellwert (Ganzzahlig)</b></td>
    <td class="smallText"><input type="text" name="maxAmountForRequest" size="50" value="<?php echo $config->getValue('maxAmountForRequest'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Zahlungsmodule &uuml;ber Maximalbestellwert ausblenden</b></td>
    <td class="smallText">
    <?php

    if ($config->getValue('allowPaymentOverMaxAmount') == 1)
    {
        echo '<input type="radio" name="allowPaymentOverMaxAmount" value="0">Aktiv</input><br />
              <input type="radio" name="allowPaymentOverMaxAmount" value="1" checked>Inaktiv</input>';
    }
    else
    {
        echo '<input type="radio" name="allowPaymentOverMaxAmount" value="0" checked>Aktiv</input><br />
              <input type="radio" name="allowPaymentOverMaxAmount" value="1">Inaktiv</input>';
    }
    ?>
    </td>
</tr>
<tr>
    <td class="smallText"><b>Art der Abfrage</b></td>
    <td class="smallText">
    <?php

    if ($config->getValue('requestType') == 'always')
    {
        echo '<input type="radio" name="requestType" value="always" checked>Vor Auswahl der Zahlart</input><br />
              <input type="radio" name="requestType" value="paymentDepending">Abh&auml;ngig von der Zahlart</input>';
    }
    else
    {
        echo '<input type="radio" name="requestType" value="always">Vor Auswahl der Zahlart</input><br />
              <input type="radio" name="requestType" value="paymentDepending" checked>Abh&auml;ngig von der Zahlart</input>';
    }
    ?>
    </td>
</tr>
<tr>
    <td class="smallText"><b>Erneute &Uuml;berpr&uuml;fung nach wie vielen Tagen? (0 = st&auml;ndige &Uuml;berpr&uuml;fung)</b></td>
    <td class="smallText"><input type="text" name="recheckSuspect" size="5" value="<?php echo $config->getValue('recheckSuspect'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Welche Zahlungsmodule sollen ausgeblendet werden? (Interne K&uuml;rzel durch Komma getrennt)</b></td>
    <td class="smallText"><input type="text" name="paymentModules" size="50" value="<?php echo $config->getValue('paymentModules'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Ab welcher Warenkorbsumme soll auf jeden Fall eine erneute &Uuml;berpr&uuml;fung stattfinden?</b></td>
    <td class="smallText"><input type="text" name="orderTotal"size="5"  value="<?php echo $config->getValue('orderTotal'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Zahlungsmodule bei nicht m&ouml;glicher Pr&uuml;fung einblenden?</b></td>
    <td class="smallText">
    <?php

    if ($config->getValue('allowPaymentWithNoResult') == 1)
    {
        echo '<input type="radio" name="allowPaymentWithNoResult" value="1" checked>Aktiv</input><br />
              <input type="radio" name="allowPaymentWithNoResult" value="0">Inaktiv</input>';
    }
    else
    {
        echo '<input type="radio" name="allowPaymentWithNoResult" value="1">Aktiv</input><br />
              <input type="radio" name="allowPaymentWithNoResult" value="0" checked>Inaktiv</input>';
    }
?>
    </td>
</tr>
<tr class="configSeparator">
    <td>&nbsp;</td>
    <td>&nbsp;</td>
</tr>
<tr>
    <td id="configtitle" colspan="2"><br />Optionen bei von Zahlart ab&auml;ngiger Bonit&auml;tsabfrage</td>
</tr>
<tr>
    <td class="smallText"><b>Bei welchen Zahlarten soll abgefragt werden? (Interne K&uuml;rzel durch Komma getrennt)</b></td>
    <td class="smallText"><input type="text" name="requestOnModules" size="50" value="<?php echo $config->getValue('requestOnModules'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Angezeigte Meldung bei schlechter Bonit&auml;tsauskunft</b></td>
    <td class="smallText"><textarea name="paymentErrorText" rows="5" cols="47"><?php echo $config->getValue('paymentErrorText'); ?></textarea></td>
</tr>