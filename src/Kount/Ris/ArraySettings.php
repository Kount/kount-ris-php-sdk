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
    if(!$this->settings['MERCHANT_ID']) {
      throw new Exception(
        "Unable to get configuration setting 'MERCHANT_ID'. " .
        "Check that the MERCHANT_ID setting exists and is not set to null or empty string. ");
    }
    return $this->settings['MERCHANT_ID'];
  }

  /**
   * Get the RIS server URL.
   * @throws Exception when the URL setting in settings.ini
   * does not exist or is set to null or empty value.
   * @return string RIS server URL
   */
  public function getRisUrl () {
    if(!$this->settings['URL']) {
      throw new Exception(
        "Unable to get configuration setting 'URL'. " .
        "Check that the URL setting exists and is not set to null or empty string. ");
    }
    return $this->settings['URL'];
  }

  /**
   * Get the path to the Merchant's x509 public certificate.
   * @return string Filesystem path to PEM encoded x509 certificate
   */
  public function getX509CertPath () {
    return $this->settings['PEM_CERTIFICATE'];
  }

  /**
   * Get the path to the Merchant's x509 private key.
   * @return string Filesystem path to PEM encoded x509 private key
   */
  public function getX509KeyPath () {
    return $this->settings['PEM_KEY_FILE'];
  }

  /**
   * Get the passphrase for the Merchant's x509 private key.
   * @return string Passphrase needed to decrypt PEM encoded x509 private key
   */
  public function getX509Passphrase () {
    return $this->settings['PEM_PASS_PHRASE'];
  }

  /**
   * Get the maximum number of seconds for RIS connection functions to timeout.
   * @return int Number of seconds to timeout
   */
  public function getConnectionTimeout () {
    return $this->settings['CONNECT_TIMEOUT'];
  }

  /**
   * The API key for authentication. Use this in favor of certificates, which
   * have been deprecated.
   * @return string API key
   */
  public function getApiKey () {
    return $this->settings['API_KEY'];
  }

  /**
   * The Salt phrase for hashing credit card numbers.
   *
   * @throws Exception when the SALT_PHRASE setting in settings.ini
   * does not exist or is set to null or empty value.
   * @return string SALT PHRASE
   */

  public function getSaltPhrase() {
    if(!$this->settings['SALT_PHRASE']) {
      throw new Exception(
        "Unable to get configuration setting 'SALT_PHRASE'. " .
        "Check that the SALT_PHRASE setting exists and is not set to null or empty string. ");
    }
    return $this->settings['SALT_PHRASE'];
  }

} //end Kount_Ris_ArraySettings
