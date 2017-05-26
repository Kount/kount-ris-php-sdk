<?php
/**
 * Settings.php file containing Kount_Ris_Settings interface.
 */

/**
 * Configuration information for RIS requests.
 *
 * @package Kount
 * @subpackage Ris
 * @author Kount <custserv@kount.com>
 * @version SVN: $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
interface Kount_Ris_Settings {

  /**
   * Get the Merchant ID.
   * @return int Kount Merchant ID (MERC)
   */
  public function getMerchantId ();

  /**
   * Get the RIS server URL.
   * @return string RIS server URL
   */
  public function getRisUrl ();

  /**
   * Get the path to the Merchant's x509 public certificate.
   * @return string Filesystem path to PEM encoded x509 certificate
   */
  public function getX509CertPath ();

  /**
   * Get the path to the Merchant's x509 private key.
   * @return string Filesystem path to PEM encoded x509 private key
   */
  public function getX509KeyPath ();

  /**
   * Get the passphrase for the Merchant's x509 private key.
   * @return string Passphrase needed to decrypt PEM encoded x509 private key
   */
  public function getX509Passphrase ();

  /**
   * The maximum number of seconds to RIS connection function to timeout.
   * @return int Number of seconds to timeout
   */
  public function getConnectionTimeout ();

  /**
   * The API key for authentication. Use this in favor of certificates, which
   * have been deprecated.
   * @return string API key
   */
  public function getApiKey ();

} //end Kount_Ris_Settings
