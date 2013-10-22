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

/**
 * Class for the mediafinanz encashment functions
 *
 * @author Marcel Kirsch
 * @version 2009-01-12
 *
 */
class MF_Encashment
{
    private $auth;
    private $soapClient;



    /**
     * Constructor
     *
     */
    public function __construct()
    {

        $config = MF_Config::getInstance();

        $licenceKey = md5($config->getValue('applicationLicence').$config->getValue('clientLicence'));

        $config = MF_Config::getInstance();

        //set sandbox if set in config:
        $sandbox = ($config->getValue('sandbox') == 0) ? false : true;

        $auth = array('clientId'   => $config->getValue('clientId'),
                      'licenceKey' => $licenceKey,
                      'sandbox'    => $sandbox);

        $this->auth = $auth;

        $options = array('trace'       => 1,
                         'compression' => true,
                         'exceptions'  => true);

        $this->soapClient = new SoapClient('https://soap.mediafinanz.de/encashment201.wsdl', $options);
    }



    /**
     * Stores a new Claim
     *
     * @param MF_Suspect $suspect
     * @param MF_Claim $claim
     * @return NewClaimResult
     */
    public function newClaim(MF_Suspect $suspect, MF_Claim $claim)
    {
       //build debtor array:
       $debtor = array(
                        'id'          => $suspect->getCustomerId(),
                        'address'     => $suspect->getSex(),
                        'firstname'   => $suspect->getFirstname(),
                        'lastname'    => $suspect->getLastname(),
                        'company'     => $suspect->getCompany(),
                        'co'          => '',
                        'street'      => $suspect->getAddress()->getStreet(),
                        'postcode'    => $suspect->getAddress()->getPostcode(),
                        'city'        => $suspect->getAddress()->getCity(),
                        'country'     => $suspect->getAddress()->getCountry(),
                        'telephone1'  => $suspect->getPhone(),
                        'telephone2'  => '',
                        'email'       => $suspect->getEmailAddress());


        if ($this->dateOfBirth != '0000-00-00' && $this->dateOfBirth != '')
        {
            $debtor['dateOfBirth'] = $this->dateOfBirth;
        }

        array_walk_recursive($debtor, array('MF_Misc', 'toUtf8'));

        //build claim array:
        $claimArray = array('invoice'            => $claim->getInvoice(),
                            'type'               => $claim->getType(),
                            'reason'             => $claim->getReason(),
                            'originalValue'      => $claim->getOriginalValue(),
                            'overdueFees'        => $claim->getOverdueFees(),
                            'dateOfOrigin'       => $claim->getDateOfOrigin(),
                            'dateOfLastReminder' => $claim->getDateOfReminder(),
                            'note'               => $claim->getNote());

        array_walk_recursive($claimArray, array('MF_Misc', 'toUtf8'));

        try
        {
            //submit claim to mf:
            $result = $this->soapClient->newClaim($this->auth, $claimArray, $debtor);

            if (!empty($result->fileNumber))
            {
                //claim successful stored:
                //store fileNumber in database with associated order, get additional status info:
                $statusResult = $this->getClaimStatus($result->fileNumber);

                xtc_db_query("INSERT INTO
                                         mf_claims (orderId, fileNumber, firstname, lastname, transmissionDate, statusCode, statusText, statusDetails)
                                     VALUES
                                         ('".$claim->getInvoice()."',
                                          '".$result->fileNumber."',
                                          '".$suspect->getFirstname()."',
                                          '".$suspect->getLastname()."',
                                          '".time()."',
                                          '".$statusResult->statusCode."',
                                          '".utf8_decode($statusResult->statusText)."',
                                          '".utf8_decode($statusResult->statusDetails)."')");

                return array('success'    => true,
                             'fileNumber' => $result->fileNumber);

            }
            else
            {
                //error occured!
                $errorString = implode(',<br />', $result->errorList);
                $errorString = utf8_decode($errorString);
                MF_Misc::errorLog($suspect->getCustomerId(), xtc_db_input($errorString));

                $path = parse_url($_SERVER['HTTP_REFERER']);

                return array('success' => false,
                             'error'   => $errorString);
            }
        }
        catch (Exception $e)
        {
            MF_Misc::errorLog($suspect->getCustomerId(), utf8_decode($e->getMessage()));
            $path = parse_url($_SERVER['HTTP_REFERER']);
            return array('success' => false,
                         'error'   => utf8_decode($e->getMessage()));
        }
    }



    /**
     * Updates the status of all claims
     *
     * @return bool
     */
    public function updateClaimStatus()
    {
        try
        {
            $result = $this->soapClient->getClaimStatusChanges($this->auth);
            $transactionId = $result->transactionId;

            //update each claim with changes:
            foreach ($result->changes as $order)
            {
                xtc_db_query("UPDATE
                                  mf_claims
                              SET
                                  statusCode    = '$order->statusCode',
                                  statusText    = '" .utf8_decode($order->statusName) ."',
                                  statusDetails = '" .utf8_decode($order->statusDetails) ."',
                                  lastChange    = '$order->time'
                              WHERE
                                  fileNumber    = '$order->fileNumber'
                              LIMIT 1");
            }

            //update last request time:
            xtc_db_query("UPDATE mf_config SET config_value = ".time()." WHERE config_key = 'lastStatusUpdate' LIMIT 1");

            //only commit transaction, if everything went fine till this point:
            $result = $this->soapClient->commitTransaction($this->auth, $transactionId);

            return true;
        }
        catch (Exception $e)
        {
            MF_Misc::errorLog(-1, utf8_decode($e->getMessage()));
            return false;
        }
    }



    /**
     * Returns a list with orders which could be transmitted to mediafinanz.
     *
     * @return array
     */
    public function getOrdersMarkedForMediafinanz($start = 0, $limit = 5, $orderBy = '', $orderDirection = 'ASC', $searchType = '', $searchValue = '')
    {
        $config = MF_Config::getInstance();

        // set the start and the order values
        $start = (int) xtc_db_input($start);

        $allowedSortOrder = array('lastname',
                                  'orderId',
                                  'firstname',
                                  'purchaseDate',
                                  'paymentMethod',
                                  'total');

        $orderBy = (in_array($orderBy, $allowedSortOrder)) ? $orderBy : 'orders.orders_id';
        $orderDirection = ((int) $orderDirection == 1) ? 'ASC' : 'DESC';

        // build searchstring:
        $where = '';
        if (strlen($searchValue) > 0)
        {
            switch ($searchType)
            {
                case 'lastname':
                    $searchType = 'billing_lastname';
                    $searchValue = '%'.xtc_db_input($searchValue).'%';
                    break;
                case 'orderId':
                    $searchValue = 'orders.orders_id';
                    $searchValue = (int) xtc_db_input($searchValue);
                    break;
                default:
                    $searchType = '';
                    $searchValue = '';
                    break;
            }

            if ($searchType != '' && $searchValue != '')
            {
                $where = "AND `".$searchType."` LIKE '".$searchValue."'";
            }
        }

        // Fetch unpaid orders from db
        $markedClaims = xtc_db_query("SELECT SQL_CALC_FOUND_ROWS
                                          orders.orders_id as orderId,
                                          billing_firstname AS firstname,
                                          billing_lastname AS lastname,
                                          billing_name AS tmpName,
                                          date_purchased AS purchaseDate,
                                          payment_method AS paymentMethod,
                                          orders_total.text AS total
                                      FROM
                                          orders
                                      INNER JOIN
                                          orders_total
                                      ON (orders_total.orders_id = orders.orders_id)
                                      WHERE
                                          orders_status = '".$config->getValue('orderStatusIdMarked')."'
                                      AND
                                          date_purchased <= '".date('Y-m-d', time() - ($config->getValue('daysUntilClaimStart') * 86400))."'
                                      AND
                                          orders_total.class = 'ot_total'
                                      AND
                                          orders.orders_id NOT IN (SELECT mf_claims.orderId FROM mf_claims)
                                      ".$wherePart."
                                      ORDER BY ".$orderBy." ".$orderDirection."
                                      LIMIT ".$start.', '.$limit);

        $rowCountMarkedClaims = mysql_num_rows($markedClaims);

        $entries = array();
        while ($row = mysql_fetch_assoc($markedClaims))
                {
                    $entries[] = $row;
                }

        $rowCount = mysql_fetch_assoc(xtc_db_query('SELECT FOUND_ROWS() as rowCount'));

        return array('count'    => $rowCountMarkedClaims,
                     'entries'  => $entries,
                     'rowCount' => $rowCount['rowCount']);
    }



    /**
     * Returns an array with claims transmitted to mf:
     *
     * @param int $start
     * @param int $limit
     * @param string $orderBy
     * @param int $orderDirection
     * @param string $searchType
     * @param string $searchValue
     * @return array
     */
    public function getOpenClaims($start = 0, $limit = 5, $orderBy = '', $orderDirection = 'ASC', $searchType = '', $searchValue = '')
    {
        $rowCount = xtc_db_query("SELECT
                                      COUNT(1) AS count
                                  FROM
                                      mf_claims
                                  INNER JOIN
                                      orders
                                  ON (orders.orders_id = mf_claims.orderId)");

        $rowCount = mysql_fetch_assoc($rowCount);
        $rowCount = $rowCount['count'];


        // set the start and the order values
        $start = ($start > $rowCount || $start < 0) ? 0 : (int) xtc_db_input($start);

        $allowedSortOrder = array('lastname',
                                  'orderId',
                                  'statusCode',
                                  'statusText',
                                  'transmissionDate');

        $orderBy = (in_array($orderBy, $allowedSortOrder)) ? $orderBy : 'transmissionDate';
        $orderDirection = ((int) $orderDirection == 1) ? 'ASC' : 'DESC';

        // build searchstring:
        $where = '';
        if (strlen($searchValue) > 0)
        {
            switch ($searchType)
            {
                case 'lastname':
                    $searchValue = '%'.xtc_db_input($searchValue).'%';
                    break;
                case 'orderId':
                    $searchValue = (int) xtc_db_input($searchValue);
                    break;
                default:
                    $searchType = '';
                    $searchValue = '';
                    break;
            }

            if ($searchType != '' && $searchValue != '')
            {
                $where = "WHERE `".$searchType."` LIKE '".$searchValue."'";
            }
        }

        $sentClaims = xtc_db_query("SELECT
                                    orderId,
                                    fileNumber,
                                    customers_id as customerId,
                                    firstname,
                                    lastname,
                                    transmissionDate,
                                    statusDetails,
                                    statusCode,
                                    statusText
                            FROM
                                    mf_claims
                            INNER JOIN
                                    orders
                            ON
                                    (orders.orders_id = mf_claims.orderId)
                             ".$where."
                            ORDER BY
                                    ".$orderBy." ".$orderDirection."
                            LIMIT
                                    ".$start.", ".$limit);

        $rowCountSentClaims = mysql_num_rows($sentClaims);

        $entries = array();

        while ($row = mysql_fetch_assoc($sentClaims))
        {
            $entries[] = $row;
        }

        return array('count'    => $rowCountSentClaims,
                     'entries'  => $entries,
                     'rowCount' => $rowCount);
    }



    /**
     * Returns Claim Status
     *
     * @param string $filenumber
     * @return ClaimStatus
     */
    private function getClaimStatus($filenumber)
    {
        $claimIdentifier = array('fileNumber' => $filenumber);
        return $this->soapClient->getClaimStatus($this->auth, $claimIdentifier);
    }



    /**
     * Returns ClaimAccountingSummary
     *
     * @param string $filenumber
     * @return ClaimAccountingSummary
     */
    private function getClaimAccountingSummary($filenumber)
    {
        $claimIdentifier = array('fileNumber' => $filenumber);
        return $this->soapClient->getClaimAccountingSummary($this->auth, $claimIdentifier);
    }



    /**
     * closes a claim
     *
     * @param string $filenumber
     * @return boolean
     */
    public function closeClaim($filenumber)
    {
        $claimIdentifier = array('fileNumber' => $filenumber);

        $closed = $this->soapClient->closeClaim($this->auth, $claimIdentifier);

        if ($closed)
        {
            //automaticly update claim status:
            xtc_db_query("UPDATE
                                  mf_claims
                              SET
                                  statusCode    = 10210,
                                  statusText    = 'Forderung von Ihnen storniert',
                                  lastChange    = '".date('Y-m-d H:i:s', time())."'
                              WHERE
                                  fileNumber    = '$filenumber'
                              LIMIT 1");
        }

        return $closed;
    }



     /**
     * sends mediafinanz information about a direct payment
     *
     * @param string $filenumber
     * @param array $directPayment
     * @return boolean
     */
    public function bookDirectPayment($filenumber, $directPayment)
    {
        $claimIdentifier = array('fileNumber' => $filenumber);

        $success = $this->soapClient->bookDirectPayment($this->auth, $claimIdentifier, $directPayment);
        $this->updateClaimStatus();

        return $success;
    }



    /**
     * return details of a claim
     *
     * @param int $orderId
     * @return array
     */
    public function getClaimDetails($orderId)
    {
        // Fetch data from database
        $claim = xtc_db_query("SELECT
                                   orderId,
                                   fileNumber,
                                   statusCode,
                                   customers_id as customerId,
                                   firstname AS firstname,
                                   lastname AS lastname,
                                   transmissionDate
                               FROM
                                   mf_claims
                               INNER JOIN
                                   orders
                               ON (orders.orders_id = mf_claims.orderId)
                               WHERE
                                  orderId = '".$orderId."'
                               LIMIT 1");

        $result = mysql_fetch_assoc($claim);
        $currentStatus = $result['statusCode'];
        unset($result['statusCode']);

        if (!empty($result))
        {
            //claim found!
            // get claim status:
            $result['claimStatus']   = array();
            $result['payoutHistory'] = array();
            try
            {
                $claimStatus = $this->getClaimStatus($result['fileNumber']);
                $details     = $this->getClaimAccountingSummary($result['fileNumber']);

                if ($claimStatus)
                {
                    //add claim status details:
                    $result['claimStatus']['statusCode']    = $claimStatus->statusCode;
                    $result['claimStatus']['statusText']    = utf8_decode($claimStatus->statusText);
                    $result['claimStatus']['statusDetails'] = utf8_decode($claimStatus->statusDetails);

                    //update status in database, if changed:
                    if ($currentStatus != $claimStatus->statusCode)
                    {
                        xtc_db_query("UPDATE
                                          mf_claims
                                      SET
                                          statusCode = ".$result['claimStatus']['statusCode'].",
                                          statusText = '".$result['claimStatus']['statusText']."',
                                          statusDetails = '".$result['claimStatus']['statusDetails']."'
                                      WHERE
                                          orderId = '".$orderId."'");
                    }
                }

                if ($details)
                {
                    //add payout details:
                    $result['totalDebts']    = $details->totalDebts;
                    $result['paid']          = $details->paid;
                    $result['outstanding']   = $details->outstanding;
                    $result['currentPayout'] = $details->currentPayout;
                    $result['sumPayout']     = $details->sumPayout;

                    if (isset($details->payoutHistory))
                    {
                        foreach ($details->payoutHistory as $historyEntry)
                        {
                            $result['payoutHistory'][] = array('date'         => $historyEntry->date,
                                                               'total'        => $historyEntry->total,
                                                               'payoutNumber' => $historyEntry->payoutNumber);
                        }
                    }
                }

            }
            catch (Exception $e)
            {
                MF_Misc::errorLog($result['customerId'], utf8_decode($e->getMessage()));
            }
        }

        return $result;
    }



    /**
     * Get details of an order
     *
     * @param int $orderId
     * @return array
     */
    public function getOrder($orderId)
    {
        // Fetch data from database
        $query = xtc_db_query("SELECT
                                   orders.customers_id as customerId,
                                   orders.orders_id as orderId,
                                   billing_firstname AS firstname,
                                   billing_lastname AS lastname,
                                   billing_name AS tmpName,
                                   date_purchased AS purchaseDate,
                                   orders_total.value as total
                               FROM
                                   orders
                               INNER JOIN
                                   orders_total ON (orders_total.orders_id = orders.orders_id)
                               WHERE
                                   orders.orders_id = '".$orderId."'
                                   AND
                                   orders_total.class = 'ot_total'
                               LIMIT 1");

        $return = mysql_fetch_assoc($query);

        $productQuery = xtc_db_query("SELECT
                                          products_model as model,
                                          products_name as name,
                                          products_quantity as quantity
                                      FROM
                                          orders_products
                                      WHERE
                                          orders_id = '".$orderId."'");

        $return['products'] = array();

        //add products:
        while ($row = mysql_fetch_assoc($productQuery))
        {
            $return['products'][] = $row;
        }

        return $return;
    }
}

?>