<?php
/**
 * ArraySettings.php file containing Kount_Ris_ArraySettings class.
 */

/**
 * Configuration information for RIS requests.
 *
 * Expects to be constructed with a PHP array having the following keys:
 *  - MERCHANT_ID: Kount Mechant Id
 *  - URL: RIS server URL
 *
 *  - PEM_CERTIFICATE: Path to PEM encoded x509 public certificate
 *  - PEM_KEY_FILE: Path to PEM encoded x509 private key
 *  - PEM_PASS_PHRASE: Passphrase to decrypt x509 private key
 *  OR
 *  - API_KEY: API key used for authentication instead of a certificate.
 *
 * @package Kount
 * @subpackage Ris
 * @author Kount <custserv@kount.com>
 * @version SVN: $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_ArraySettings implements Kount_Ris_Settings {

  /**
   * Settings array
   * @var array
   */
  protected $settings;

  /**
   * ArraySettings constructor, sets $settings.
   * @param array $settings Configuration settings
   */
  public function __construct ($settings) {
    $this->settings = $settings;
  }

  /**
   * Get the Merchant ID.
   * @throws Exception when the MERCHANT_ID setting in settings.ini
   * does not exist or is set to null or empty value.
   * @return int Kount Merchant ID (MERC)
   */
  public function getMerchantId () {

    return $this->settings['MERCHANT_ID'];
  }

  /**
   * Get the RIS server URL.
   * @throws Exception when the URL setting in settings.ini
   * does not exist or is set to null or empty value.
   * @return string RIS server URL
   */
  public function getRisUrl () {
  
    return $this->settings['URL'];
  }

  /**
   * Get the path to the Merchant's x509 public certificate.
   * @return string Filesystem path to PEM encoded x509 certificate
   */
  public function getX509CertPath () {
    return $this->settings['PEM_CERTIFICATE'] ? $this->settings['PEM_CERTIFICATE'] : null;
  }

  /**
   * Get the path to the Merchant's x509 private key.
   * @return string Filesystem path to PEM encoded x509 private key
   */
  public function getX509KeyPath () {
    return $this->settings['PEM_KEY_FILE'] ? $this->settings['PEM_KEY_FILE'] : null;
  }

  /**
   * Get the passphrase for the Merchant's x509 private key.
   * @return string Passphrase needed to decrypt PEM encoded x509 private key
   */
  public function getX509Passphrase () {
    return $this->settings['PEM_PASS_PHRASE'] ? $this->settings['PEM_PASS_PHRASE'] : null;
  }

  /**
   * Get the maximum number of seconds for RIS connection functions to timeout.
   * @return int Number of seconds to timeout
   */
  public function getConnectionTimeout () {
    return $this->settings['CONNECT_TIMEOUT'] ? $this->settings['CONNECT_TIMEOUT'] : Kount_Ris_Request::CONNECTION_TIMEOUT;
  }

  /**
   * The API key for authentication. Use this in favor of certificates, which
   * have been deprecated.
   * @return string API key
   */
  public function getApiKey () {
    return $this->settings['API_KEY'] ? $this->settings['API_KEY'] : null;
  }

  /**
   * The config key for hashing credit card numbers.
   *
   * @return string CONFIG_KEY
   */

  public function getConfigKey () {
    return $this->settings['CONFIG_KEY'];
  }

} //end Kount_Ris_ArraySettings
