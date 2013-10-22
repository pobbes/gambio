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
require_once ('includes/modules/mediafinanz/models/MF/Misc.php');
require_once ('includes/modules/mediafinanz/models/MF/Encashment.php');

$config = MF_Config::getInstance();
$encashment = new MF_Encashment();

//get details for this claim:
$orderId = (int) xtc_db_input($_GET['oID']);
$claimDetails = $encashment->getClaimDetails($orderId);

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

             if (!empty($claimDetails))
             {
                 //claim found!

            ?>
                    <table>
                    <tr>
                    <td colspan="4">
                     <table border="0" cellspacing="1" cellpadding="3" class="smalltext">
                         <caption><strong>An mediafinanz &uuml;bergebene Rechnung</strong></caption>
                          <tr bgcolor="white">
                            <td><strong>Rechnungsnr: <?php echo $orderId; ?></strong></td>
                            <td><strong><?php echo $claimDetails['firstname'].' '.$claimDetails['lastname']; ?></strong></td>
                            <td><strong>AZ: <?php echo $claimDetails['fileNumber']; ?></strong></td>
                            <td><strong><?php echo date('d.m.Y H:i', $claimDetails['transmissionDate']); ?></strong></td>
                          </tr>
                          <tr bgcolor="lightgrey">
                            <td>Statuscode:</td><td colspan="3"><img src="./includes/modules/mediafinanz/images/<?php echo $claimDetails['claimStatus']['statusCode']; ?>.gif" alt="Statuscode: <?php echo $claimDetails['claimStatus']['statusCode']; ?>"/></td>
                          </tr>
                          <tr bgcolor="white">
                            <td>Statustext:</td><td colspan="3"><?php echo $claimDetails['claimStatus']['statusText']; ?></td>
                          </tr>
                          <tr bgcolor="lightgrey">
                            <td>StatusDetails:</td><td colspan="3"><?php echo $claimDetails['claimStatus']['statusDetails']; ?></td>
                          </tr>
                          <tr bgcolor="white">
                            <td>Gesamtschulden:</td><td colspan="3"><?php echo $claimDetails['totalDebts']; ?> &euro;</td>
                          </tr>
                          <tr bgcolor="lightgrey">
                            <td>Bereits gezahlt:</td><td colspan="3"><?php echo $claimDetails['paid']; ?> &euro;</td>
                          </tr>
                          <tr bgcolor="white">
                            <td>noch offen:</td><td colspan="3"><?php echo $claimDetails['outstanding']; ?> &euro;</td>
                          </tr>
                          <tr bgcolor="lightgrey">
                            <td>aktueller Abrechnungsbetrag:</td><td colspan="3"><?php echo $claimDetails['currentPayout']; ?> &euro;</td>
                          </tr>
                          <tr bgcolor="white">
                            <td colspan="4">Auszahlungen (<?php echo $claimDetails['sumPayout']; ?> &euro;)</td>
                          </tr>
            <?php
                        $payoutHistory = $claimDetails['payoutHistory'];

                        if (count($payoutHistory) == 0)
                        {
                            echo '<tr bgcolor="lightgrey">
                                     <td colspan="4">Noch keine Auszahlungen</td>
                                  </tr>';
                        }
                        else
                        {
                            echo '<tr bgcolor="lightgrey">
                                    <td>Datum</td><td>Auszahlungsbetrag</td><td colspan="2">Abrechnungsnummer</td>
                                  </tr>';
                        }

                        $i = 0;
                        foreach ($payoutHistory as $entry)
                        {
                            $color = ($i % 2 == 0) ? 'lightgrey' : 'white';
                            echo '<tr bgcolor="'.$color.'">
                                    <td>'.$entry['date'].'</td>
                                    <td>'.$entry['total'].'</td>
                                    <td colspan="2">'.$entry['payoutNumber'].'</td>
                                  </tr>';
                            $i++;
                        }
                        ?>



                        <?php

                        if ($claimDetails['claimStatus']['statusCode'] == 10210)
                        {
                            echo '<tr bgcolor="white">
                                    <td colspan="4"><strong>Forderung storniert!</strong></td>
                                  </tr></table></form>';
                        }
                        else
                        {
                           ?>
                           </table></td></tr>
                           <tr><td>&nbsp;</td></tr>
                           <tr>
                           <td>
                           <table border="0" cellspacing="1" cellpadding="3" class="smalltext" width="100%">
                          <caption><strong>Aktionen</strong></caption>
                            <tr bgcolor="lightgrey">
                                <td colspan="2">Forderung stornieren:</td>
                            </tr>
                            <tr bgcolor="white">
                                <td>
                                    <form action="mediafinanz.php?action=close_claim" method="POST">
                                    <input type="hidden" name="fileNumber" value="<?php echo $claimDetails['fileNumber']; ?>" />
                                    <input type="hidden" name="customerId" value="<?php echo $claimDetails['customerId']; ?>" />
                                    <input type="hidden" name="orderId" value="<?php echo $orderId; ?>" />
                                    <input type="submit" value="Forderung stornieren!"/>
                                    </form>
                                </td>
                            </tr>
                            </table></td></tr>
                            <tr>
                            <td>

                            <form action="mediafinanz.php?action=direct_payment" name="directPayment" method="POST">
                            <script type="text/javascript">
                                var dateAvailable = new ctlSpiffyCalendarBox("dateAvailable", "directPayment", "dateOfPayment","btnDate1","",scBTNMODE_CUSTOMBLUE);
                            </script>
                            <table border="0" cellspacing="1" cellpadding="3" class="smalltext" width="100%">
                            <tr bgcolor="lightgrey">
                                <td colspan="2">Direktzahlung melden:</td>
                            </tr>
                            <tr bgcolor="white">

                                <td>H&ouml;he der Zahlung</td>
                                <td><input type="text" name="paidAmount" /></td>
                            </tr>
                            <tr bgcolor="lightgrey">
                                <td>Datum der Zahlung (JJJJ-MM-TT)</td>
                                <td><script type="text/javascript">dateAvailable.writeControl(); dateAvailable.dateFormat="yyyy-MM-dd";</script></td>
                            </tr>
                            <tr bgcolor="white">
                                <input type="hidden" name="fileNumber" value="<?php echo $claimDetails['fileNumber']; ?>" />
                                <input type="hidden" name="customerId" value="<?php echo $claimDetails['customerId']; ?>" />
                                <input type="hidden" name="orderId" value="<?php echo $orderId; ?>" />
                                <td colspan="2"><input type="submit" value="Direktzahlung melden!"/></td>
                            </tr>
                        </table>
                        </td></tr>
                        <tr>
                            <td>
                                <a href="mediafinanz.php?action=claims">Zur&uuml;ck</a>
                            </td>
                        </tr>
                        </table>
                        </form>

                        <?php

                        }


            }
            else
            {
                echo 'Keine Rechnung mit dieser Nummer gefunden!';

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