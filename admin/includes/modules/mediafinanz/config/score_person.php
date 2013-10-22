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
    $config->storeValue('person.active', (int)($_POST['active']));
    $config->storeValue('buergel.score', (double)(str_replace(',', '.', $_POST['score'])));

    $msg = '<strong style="font-size:14px;">Daten gespeichert!</strong>';
}

?>

<tr>
    <td id="configtitle" colspan="2"><br />Personen Bonit&auml;ts Optionen</td>
</tr>
<tr>
    <td class="smallText"><b>Personen Bonit&auml;tspr&uuml;fung einschalten?</b></td>
    <td class="smallText">
    <?php

    if ($config->getValue('person.active') == 1)
    {
        echo '<input type="radio" name="active" value="1" checked>Aktiv</input><br />
              <input type="radio" name="active" value="0">Inaktiv</input>';
    }
    else
    {
        echo '<input type="radio" name="active" value="1">Aktiv</input><br />
              <input type="radio" name="active" value="0" checked>Inaktiv</input>';
    }

    ?>
   </td>
</tr>
<tr>
    <td class="smallText"><b>Ab welchem Score sollen Zahlungsmodule ausgeblendet werden?</b></td>
    <td class="smallText"><input type="text" name="score" value="<?php echo $config->getValue('buergel.score'); ?>"/></td>
</tr>