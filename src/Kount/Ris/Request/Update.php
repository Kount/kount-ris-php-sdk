<?php

/**
 * Update.php file containing Kount_Ris_Request_Update class.
 *
 */

/**
 * Perform an update request (MODE 'U' or 'X') to RIS.
 *
 * Modes U and X are identical except mode U does not generate or return risk
 * evaluation information.
 *
 * Basic usage example:
 * <code>
 * <?php
 *   include 'Kount/Ris/Request/Update.php';
 *
 *   try {
 *     $update = new Kount_Ris_Update();
 *     $update->setSessionId('fakesessionid');
 *     $update->setTransactionId($transactioni_id_saved_from_initial_inquiry);
 *     $update->setMack('Y'); // or 'N'
 *     // additional optional setters
 *     $update->setAuth('Y');
 *     $update->setAvsz('M');
 *     $update->setAvst('N');
 *     $update->setCvvr('X');
 *
 *     $response = $update->getResponse();
 *     $status = $response->getErrorCode();
 *     if (null !== $status) {
 *       // handle/record RIS error
 *     }
 *
 *   } catch (Exception $e) {
 *     // handle exception
 *   }
 * </code>
 *
 * @package Kount_Ris
 * @subpackage Request
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_Request_Update extends Kount_Ris_Request
{

    /**
     * RIS update request (no response).
     * @var string
     * @see setMode()
     */
    const MODE_U = 'U';

    /**
     * RIS update request with response.
     * @var string
     * @see setMode()
     */
    const MODE_X = 'X';

    /**
     * Refund
     * @var string
     * @see setRefundChargeback()
     */
    const RFCB_R = 'R';

    /**
     * Chargeback
     * @var string
     * @see setRefundChargeback()
     */
    const RFCB_C = 'C';

    /**
     * Update constructor, sets the "Inquiry" mode to "U".
     * @param Kount_Ris_Settings $settings Configuration settings
     */
    public function __construct($settings = null)
    {
        parent::__construct($settings);
        // defaults
        $this->setMode(self::MODE_U);
    }

    /**
     * Set the update mode
     *
     * @param string $mode RIS update mode (U/X)
     * @return Kount_Ris_Request_Update
     * @throws Kount_Ris_IllegalArgumentException when $mode isn't 'U' or 'X'.
     */
    public function setMode($mode)
    {

        $this->data['MODE'] = $mode;
        return $this;
    }

    /**
     * Set the transaction id recieve from the intial inquiry.
     *
     * @param string $transactionId Transaction id
     * @return Kount_Ris_Request_Update
     */
    public function setTransactionId($transactionId)
    {
        $this->data['TRAN'] = $transactionId;
        return $this;
    }

    /**
     * Set the refund/chargeback status of this transaction: R = Refund, C = Chargeback.
     *
     * @param string $rfcb Refund or chargeback status (R/C)
     * @return Kount_Ris_Request_Update
     * @throws Kount_Ris_IllegalArgumentException when $rfcb isn't "R" or "C"
     */
    public function setRefundChargeback($rfcb)
    {

        $this->data['RFCB'] = $rfcb;
        return $this;
    }

    /**
     * Set the paypal Id
     *
     * @param string $paypalId Set the paypal Id
     * @return Kount_Ris_Request_Update
     * @deprecated version 4.1.0 - 2010. Use
     *   Kount_Ris_Update->setPayPalPayment() instead.
     */
    public function setPayPalId($paypalId)
    {
        $this->logger->info('The method Kount_Ris_Update->setPaypalId() is " +
        "deprecated. Use Kount_Ris_Update->setPaypalPayment() instead.');
        return $this->setPayPalPayment($paypalId);
    }
} // end Kount_Ris_Request_Update
