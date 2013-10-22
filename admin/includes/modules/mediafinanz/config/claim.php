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
    $config->storeValue('orderStatusIdMarked', (int)($_POST['orderStatusIdMarked']));
    $config->storeValue('overdueFees', (double)(str_replace(',', '.', $_POST['overdueFees'])));
    $config->storeValue('displayClaimsCount', (int)($_POST['displayClaimsCount']));
    $config->storeValue('daysUntilClaimStart', (int)($_POST['daysUntilClaimStart']));
    $config->storeValue('statusUpdateInterval', (int)($_POST['statusUpdateInterval']));
    $config->storeValue('daysFromLastReminder', (int)($_POST['daysFromLastReminder']));
    $config->storeValue('defaultType', (int)($_POST['defaultType']));

    $msg = '<strong style="font-size:14px;">Daten gespeichert!</strong>';
}
?>

<tr>
    <td id="configtitle" colspan="2"><br />Forderungs Optionen</td>
</tr>
<tr>
    <td class="smallText"><b>Anzahl der angezeigten Forderungen?</b></td>
    <td class="smallText"><input type="text" name="displayClaimsCount"size="5"  value="<?php echo $config->getValue('displayClaimsCount'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Nach wie vielen Tagen soll eine Bestellung im Forderungsmen&uuml; angezeigt werden?</b></td>
    <td class="smallText"><input type="text" name="daysUntilClaimStart"size="5"  value="<?php echo $config->getValue('daysUntilClaimStart'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Order Status Id der an mediafinanz zu &uuml;bergebenen Rechnungen? (Standard: 1)</b></td>
    <td class="smallText"><input type="text" name="orderStatusIdMarked"size="5"  value="<?php echo $config->getValue('orderStatusIdMarked'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Grundmahnkosten</b></td>
    <td class="smallText"><input type="text" name="overdueFees"size="5"  value="<?php echo $config->getValue('overdueFees'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Standardabstand zwischen Bestelldatum und erster Mahnung</b></td>
    <td class="smallText"><input type="text" name="daysFromLastReminder" size="5"  value="<?php echo $config->getValue('daysFromLastReminder'); ?>"/></td>
</tr>
<tr>
    <td class="smallText"><b>Standardtyp</b></td>
    <td class="smallText">
        <select name="defaultType">
        <?php

        switch($config->getValue('defaultType'))
        {
            case 1:
                    $val1 = 'SELECTED';
                    break;
            case 2:
                    $val2 = 'SELECTED';
                    break;
            case 3:
                    $val3 = 'SELECTED';
                    break;
            default:
                    break;
        }

        echo '<option value="1" '.$val1.'>Ware verkauft</option>'
           . '<option value="2" '.$val2.'>Ware per Vorkasse verkauft</option>'
           . '<option value="3" '.$val3.'>Dienstleistung erbracht </option>';

?>
        </select>
    </td>
</tr>
<tr>
    <td class="smallText"><b>Update Intervall der Forderungen in Stunden</b></td>
    <td class="smallText"><input type="text" name="statusUpdateInterval" size="5"  value="<?php echo $config->getValue('statusUpdateInterval'); ?>"/></td>
</tr>