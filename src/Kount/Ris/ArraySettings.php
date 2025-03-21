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
class Kount_Ris_ArraySettings implements Kount_Ris_Settings
{

    /**
     * Settings array
     * @var array
     */
    protected $settings;

    /**
     * ArraySettings constructor, sets $settings.
     * @param array $settings Configuration settings
     */
    public function __construct($settings)
    {
        $this->settings = $settings;
    }

    /**
     * Get the Merchant ID.
     * @return int Kount Merchant ID (MERC)
     * @throws Exception when the MERCHANT_ID setting in settings.ini
     * does not exist or is set to null or empty value.
     */
    public function getMerchantId()
    {

        return $this->settings['MERCHANT_ID'];
    }

    /**
     * Get the RIS server URL.
     * @return string RIS server URL
     * @throws Exception when the URL setting in settings.ini
     * does not exist or is set to null or empty value.
     */
    public function getRisUrl()
    {

        return $this->settings['URL'];
    }

    /**
     * Get the path to the Merchant's x509 public certificate.
     * @return string Filesystem path to PEM encoded x509 certificate
     */
    public function getX509CertPath()
    {
        return $this->settings['PEM_CERTIFICATE'] ? $this->settings['PEM_CERTIFICATE'] : null;
    }

    /**
     * Get the path to the Merchant's x509 private key.
     * @return string Filesystem path to PEM encoded x509 private key
     */
    public function getX509KeyPath()
    {
        return $this->settings['PEM_KEY_FILE'] ? $this->settings['PEM_KEY_FILE'] : null;
    }

    /**
     * Get the passphrase for the Merchant's x509 private key.
     * @return string Passphrase needed to decrypt PEM encoded x509 private key
     */
    public function getX509Passphrase()
    {
        return $this->settings['PEM_PASS_PHRASE'] ? $this->settings['PEM_PASS_PHRASE'] : null;
    }

    /**
     * Get the maximum number of seconds for RIS connection functions to timeout.
     * @return int Number of seconds to timeout
     */
    public function getConnectionTimeout()
    {
        return $this->settings['CONNECT_TIMEOUT'] ? $this->settings['CONNECT_TIMEOUT'] : Kount_Ris_Request::CONNECTION_TIMEOUT;
    }

    /**
     * The API key for authentication. Use this in favor of certificates, which
     * have been deprecated.
     * @return string API key
     */
    public function getApiKey()
    {
        return $this->settings['API_KEY'] ? $this->settings['API_KEY'] : null;
    }

    /**
     * The config key for hashing credit card numbers.
     *
     * @return string CONFIG_KEY
     */

    public function getConfigKey()
    {
        return $this->settings['CONFIG_KEY'];
    }

    /**
     * Kount RIS release version.
     *
     * @return string VERS
     * @throws Exception
     */
    public function getVERS()
    {
        return array_key_exists('VERS', $this->settings) ? $this->settings['VERS'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('VERS');
    }

    /**
     * Which SDK is this.
     *
     * @return string SDK
     * @throws Exception
     */
    public function getSdk()
    {
        return array_key_exists('SDK', $this->settings) ? $this->settings['SDK'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('SDK');
    }

    /**
     * SDK release version.
     *
     * @return string SDK_VERSION
     * @throws Exception
     */
    public function getSdkVersion()
    {
        return array_key_exists('SDK_VERSION', $this->settings) ? $this->settings['SDK_VERSION'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('SDK_VERSION');
    }

    /**
     * Whether Migration Mode is enabled.
     * @return boolean
     * @throws Exception
     */
    public function getIsMigrationModeEnabled()
    {
        return array_key_exists('MIGRATION_MODE_ENABLED', $this->settings) ? $this->settings['MIGRATION_MODE_ENABLED'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('MIGRATION_MODE_ENABLED');
    }

    /**
     * Payments Fraud Client ID
     * @return integer
     * @throws Exception
     */
    public function getPaymentsFraudClientId()
    {
        return array_key_exists('PF_CLIENT_ID', $this->settings) ? $this->settings['PF_CLIENT_ID'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('PF_CLIENT_ID');
    }

    /**
     * Payments Fraud Auth URL
     * @return integer
     * @throws Exception
     */
    public function getPaymentsFraudAuthUrl()
    {
        return array_key_exists('PF_AUTH_ENDPOINT', $this->settings) ? $this->settings['PF_AUTH_ENDPOINT'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('PF_AUTH_ENDPOINT');
    }

    /**
     * Payments Fraud Auth URL
     * @return integer
     * @throws Exception
     */
    public function getPaymentsFraudApiUrl()
    {
        return array_key_exists('PF_API_ENDPOINT', $this->settings) ? $this->settings['PF_API_ENDPOINT'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('PF_API_ENDPOINT');
    }

    /**
     * Payments Fraud Auth URL
     * @return integer
     * @throws Exception
     */
    public function getPaymentsFraudApiKey()
    {
        return array_key_exists('PF_API_KEY', $this->settings) ? $this->settings['PF_API_KEY'] :
            Kount_Util_ConfigFileReader::instance()->getConfigSetting('PF_API_KEY');
    }
} //end Kount_Ris_ArraySettings
