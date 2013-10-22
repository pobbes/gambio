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

require_once ('includes/modules/mediafinanz/models/MF/Config.php');
require_once ('includes/modules/mediafinanz/models/MF/Encashment.php');
require_once ('includes/modules/mediafinanz/models/MF/Misc.php');

$config = MF_Config::getInstance();
$encashment = new MF_Encashment();


// check if a status refresh is forced or necessary according to the config
if ($_GET['forceStatusUpdate'] == 'true'
    || $config->getValue('lastStatusUpdate') < time() - $config->getValue('statusUpdateInterval') * 3600)
{
    if (!$encashment->updateClaimStatus())
    {
        echo 'Der Status der Forderungen konnte nicht aktualisiert werden';
    }
}


if (!isset($_SESSION['mf']['marked']))
{
    $_SESSION['mf']['marked'] = array('start'        => 0,
                                      'sortOrder'    => 'default',
                                      'state'        => 0,
                                      'searchField'  => '',
                                      'searchString' => '');
}
//get all orders, which have been marked as "Fuer mediafinanz markieren" (orderStatusIdMarked):
$startMarked = $_SESSION['mf']['marked']['start']        = isset($_GET['startMarked']) ? $_GET['startMarked'] : $_SESSION['mf']['marked']['start'];
$sortOrderMarked = $_SESSION['mf']['marked']['sortOrder']    = isset($_GET['sortOrderMarked']) ? $_GET['sortOrderMarked'] : $_SESSION['mf']['marked']['sortOrder'];
$stateMarked = $_SESSION['mf']['marked']['state']        = isset($_GET['stateMarked']) ? $_GET['stateMarked'] : $_SESSION['mf']['marked']['state'];
$displayClaimsCountMarked = $config->getValue('displayClaimsCount');

$markedForMediafinanz = $encashment->getOrdersMarkedForMediafinanz($_SESSION['mf']['marked']['start'],
                                                                   $displayClaimsCountMarked,
                                                                   $_SESSION['mf']['marked']['sortOrder'],
                                                                   $_SESSION['mf']['marked']['state'],
                                                                   'default',
                                                                   '');


//get transmitted claims:
if (!isset($_SESSION['mf']['transmitted']))
{
    $_SESSION['mf']['transmitted'] = array('start'        => 0,
                                           'sortOrder'    => 'default',
                                           'state'        => 0,
                                           'searchField'  => '',
                                           'searchString' => '');
}

$startTransmitted = $_SESSION['mf']['transmitted']['start']        = isset($_GET['startTransmitted']) ? $_GET['startTransmitted'] : $_SESSION['mf']['transmitted']['start'];
$sortOrderTransmitted = $_SESSION['mf']['transmitted']['sortOrder']    = isset($_GET['sortOrderTransmitted']) ? $_GET['sortOrderTransmitted'] : $_SESSION['mf']['transmitted']['sortOrder'];
$stateTransmitted = $_SESSION['mf']['transmitted']['state']        = isset($_GET['stateTransmitted']) ? $_GET['stateTransmitted'] : $_SESSION['mf']['transmitted']['state'];
$_SESSION['mf']['transmitted']['searchField']  = isset($_POST['searchFieldTransmitted']) ? $_POST['searchFieldTransmitted'] : $_SESSION['mf']['transmitted']['searchField'];
$_SESSION['mf']['transmitted']['searchString'] = isset($_POST['searchStringTransmitted']) ? $_POST['searchStringTransmitted'] : $_SESSION['mf']['transmitted']['searchString'];
$displayClaimsCountTransmitted = $config->getValue('displayClaimsCount');

$openClaims = $encashment->getOpenClaims($_SESSION['mf']['transmitted']['start'],
                                         $displayClaimsCountTransmitted,
                                         $_SESSION['mf']['transmitted']['sortOrder'],
                                         $_SESSION['mf']['transmitted']['state'],
                                         $_SESSION['mf']['transmitted']['searchField'],
                                         $_SESSION['mf']['transmitted']['searchString']);

?>

<td class="boxCenter" width="100%" valign="top"><table border="0" width="100%" cellspacing="0" cellpadding="2">
      <tr>
        <td><table border="0" width="100%" cellspacing="0" cellpadding="0">
          <tr>
            <td class="pageHeading">mediafinanz - Forderungen</td>
            <td class="pageHeading" align="right"><?php echo xtc_draw_separator('pixel_trans.gif', HEADING_IMAGE_WIDTH, HEADING_IMAGE_HEIGHT); ?></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td>

        <table border="0" cellspacing="0" cellpadding="2">
          <tr>
            <td>

            <?php

            if ($markedForMediafinanz['count'] > 0)
            {
                $newState = $stateMarked + 1;
                //some orders could be transmitted to mediafinanz:
                echo '
                     <table border="0" cellspacing="1" cellpadding="3" class="smalltext">
                     <caption><strong>Offene Bestellungen</strong></caption>
                      <tr bgcolor="white">
                        <td>
                            <a href="mediafinanz.php?action=claims&startMarked='.$startMarked.'&sortOrderMarked=lastname&stateMarked='.($newState % 2).'">
                            <strong>Name</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startMarked='.$startMarked.'&sortOrderMarked=orderId&stateMarked='.($newState % 2).'">
                            <strong>Rechnugnsnr.</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startMarked='.$startMarked.'&sortOrderMarked=purchaseDate&stateMarked='.($newState % 2).'">
                            <strong>Bestelldatum</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startMarked='.$startMarked.'&sortOrderMarked=paymentMethod&stateMarked='.($newState % 2).'">
                            <strong>Zahlweise</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startMarked='.$startMarked.'&sortOrderMarked=total&stateMarked='.($newState % 2).'">
                            <strong>Wert</strong>
                            </a>
                        </td>
                        <td>
                            <strong>Aktion</strong>
                        </td>
                      </tr>';
            ?>
            <?php

                // display rows
                $i = 0;
                foreach ($markedForMediafinanz['entries'] as $entry)
                {
                     if ((!empty($entry['firstname'])) && (!empty($entry['lastname'])))
                     {
                         $name = $entry['firstname'].' '.$entry['lastname'];
                     }
                     else
                     {
                         $name = $entry['tmpName'];
                     }

                     $color = ($i++ % 2 == 0) ? 'lightgrey' : 'white';

                     echo '<tr bgcolor="'.$color.'">
                                <td>'.$name.'</td>
                                <td>'.$entry['orderId'].'</td>
                                <td>'.$entry['purchaseDate'].'</td>
                                <td>'.$entry['paymentMethod'].'</td>
                                <td>'.strip_tags($entry['total']).'</td>
                                <td><a href="mediafinanz.php?action=process_claim&oID='.$entry['orderId'].'">Jetzt &uuml;bergeben</a></td>
                          </tr>';
                     $i++;
                }
                echo '<tr>';

                if ($startMarked != 0)
                {
                    // display arrows left:
                    echo '<td colspan="3"><a href="mediafinanz.php?action=claims&startMarked='.($startMarked - $displayClaimsCountMarked).'&sortOrderMarked='.$sortOrderMarked.'&stateMarked='.$stateMarked.'"><strong>&laquo;</strong></a></td>';
                }
                else
                {
                    echo '<td colspan="3"></td>';
                }

                if ($markedForMediafinanz['rowCount'] > $startMarked + $displayClaimsCountMarked)
                {
                    // display arrows right:
                    echo '<td colspan="4" align="right"><a href="mediafinanz.php?action=claims&startMarked='.($startMarked + $displayClaimsCountMarked).'&sortOrderMarked='.$sortOrderMarked.'&stateMarked='.$stateMarked.'"><strong>&raquo;</strong></a></td>';
                }
                else
                {
                    echo '<td colspan="4"></td>';
                }
                echo '</tr>
                      </table>';
            }
            else
            {
                echo 'Es sind keine Bestellungen f&uuml;r mediafinanz markiert!';

            }
            echo '<br/><br/><br/>';
            echo '
            <table border="0" cellspacing="1" cellpadding="3" class="smalltext">
                    <tr>
                        <td colspan="5"><strong>An mediafinanz &uuml;bergebene Bestellungen <a href="mediafinanz.php?action=claims&forceStatusUpdate=true">Aktualisieren</a></strong></td>
                    </tr>
                     <tr>
                         <td colspan="5">
                             <form method="post" action="mediafinanz.php?action=claims">
                                 <strong>Suche:</strong>
                                 <select size="1" name="searchFieldTransmitted">
                                    <option value="lastname">Nachname</option>
                                    <option value="orderId" '.(($_SESSION['mf']['transmitted']['searchField'] == 'orderId')? 'selected="true"' : '').'>Rechnungsnr</option>
                                 </select>
                                 <input type="text" name="searchStringTransmitted" value="'.$_SESSION['mf']['transmitted']['searchString'].'"/>
                                 <input type="submit" value="Suchen" />
                             </form>
                         </td>
                     </tr>';

            if ($openClaims['count'] > 0)
            {
                //we already have some claims transmitted to mediafinanz:
                $newState = $stateTransmitted + 1;

                echo '
                      <tr bgcolor="white">
                        <td>
                            <a href="mediafinanz.php?action=claims&startTransmitted='.$startTransmitted.'&sortOrderTransmitted=lastname&stateTransmitted='.($newState % 2).'">
                                <strong>Name</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startTransmitted='.$startTransmitted.'&sortOrderTransmitted=orderId&stateTransmitted='.($newState % 2).'">
                                <strong>Rechnungsnr.</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startTransmitted='.$startTransmitted.'&stateTransmitted='.($newState % 2).'">
                                <strong>&Uuml;bergabedatum</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startTransmitted='.$startTransmitted.'&sortOrderTransmitted=statusCode&stateTransmitted='.($newState % 2).'">
                                <strong>Statuscode</strong>
                            </a>
                        </td>
                        <td>
                            <a href="mediafinanz.php?action=claims&startTransmitted='.$startTransmitted.'&sortOrderTransmitted=statusText&stateTransmitted='.($newState % 2).'">
                                <strong>Statustext</strong>
                            </a>
                        </td>
                        <td><strong>Anmerkung</strong></td>
                        <td><strong>Details</td>
                      </tr>';



                // display rows
                $i = 0;
                foreach ($openClaims['entries'] as $entry)
                {
                     $color = ($i++ % 2 == 0) ? 'lightgrey' : 'white';

                     echo '<tr bgcolor="'.$color.'">
                                <td>'.$entry['firstname'].' '.$entry['lastname'].'</td>
                                <td>'.$entry['orderId'].'</td>
                                <td>'.date('d.m.Y H:i', $entry['transmissionDate']).'</td>
                                <td><img src="./includes/modules/mediafinanz/images/'.$entry['statusCode'].'.gif" alt="Statuscode: '.$entry['statusCode'].'"/></td>
                                <td>'.$entry['statusText'].'</td>
                                <td>'.$entry['statusDetails'].'</td>
                                <td><a href="mediafinanz.php?action=display_claim&oID='.$entry['orderId'].'">Anzeigen</a></td>
                          </tr>';
                     $i++;
                }
                echo '<tr>';

                if ($startTransmitted != 0)
                {
                    // display arrows left:
                    echo '<td colspan="3"><a href="mediafinanz.php?action=claims&startTransmitted='.($startTransmitted - $displayClaimsCountTransmitted).'&sortOrderTransmitted='.$sortOrderTransmitted.'&stateTransmitted='.$stateTransmitted.'"><strong>&laquo;</strong></a></td>';
                }
                else
                {
                    echo '<td colspan="3"></td>';
                }

                if ($openClaims['rowCount'] > $startTransmitted + $displayClaimsCountTransmitted)
                {
                    // display arrows right:
                    echo '<td colspan="4" align="right"><a href="mediafinanz.php?action=claims&startTransmitted='.($startTransmitted + $displayClaimsCountTransmitted).'&sortOrderTransmitted='.$sortOrderTransmitted.'&stateTransmitted='.$stateTransmitted.'"><strong>&raquo;</strong></a></td>';
                }
                else
                {
                    echo '<td colspan="4"></td>';
                }
                echo '</tr>';

                echo ' </table>';
            }
            else
            {
                echo '<tr><td colspan="4">Es sind keine Bestellungen an mediafinanz &uuml;bergeben!</td></tr></table>';
            }
            ?>
            </td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td><?php echo xtc_draw_separator('pixel_trans.gif', '1', '10'); ?></td>
      </tr>
      <tr>
        <td>

        </td>
      </tr>
    </table></td>