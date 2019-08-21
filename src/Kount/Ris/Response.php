<?php
/**
 * Response.php file containing Kount_Ris_Response class.
 */

/**
 * RIS response data class.
 *
 * @package Kount_Ris
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_Response {

  /**
   * Response data
   *
   * @var Hash map
   */
  private $response = array();

  /**
   * Raw response string
   *
   * @var string
   */
  private $raw;

  /**
   * A logger binding.
   * @var Kount_Log_Binding_Logger
   */
  protected $logger;

  /**
   * Construct a response object
   *
   * @param string $output Response string comes in as key=value\n pairs
   */
  public function __construct ($output) {
    $loggerFactory = Kount_Log_Factory_LogFactory::getLoggerFactory();
    $this->logger = $loggerFactory->getLogger(__CLASS__);

    $this->raw = $output;
    $lines = preg_split('/[\r\n]+/', $output, -1, PREG_SPLIT_NO_EMPTY);
    foreach ($lines as $line) {
      list($key, $value) = explode('=', $line, 2);
      $this->response[$key] = $value;
    }
  }

  /**
   * Get an explicit parameter from the response
   *
   * @param string $key The key for the parameter
   * @return string
   */
  public function getParm ($key) {
    return $this->safeGet("{$key}");
  }

  /**
   * Get the version number
   *
   * @return string
   */
  public function getVersion () {
    return $this->safeGet('VERS');
  }

  /**
   * Get the RIS mode
   *
   * @return string
   */
  public function getMode () {
    return $this->safeGet('MODE');
  }

  /**
   * Get the transaction id
   *
   * @return string
   */
  public function getTransactionId () {
    return $this->safeGet('TRAN');
  }

  /**
   * Get the merchant id
   *
   * @return int
   */
  public function getMerchantId () {
    return $this->safeGet('MERC');
  }

  /**
   * Get the merchant gateway's customer id for Kount Central
   *
   * @return string
   */
  public function getKcCustomerId () {
    return $this->safeGet('KC_CUSTOMER_ID');
  }

  /**
   * Get the session id
   *
   * @return string
   */
  public function getSessionId () {
    return $this->safeGet('SESS');
  }

  /**
   * Get the site
   *
   * @return string
   */
  public function getSite () {
    return $this->safeGet('SITE');
  }

  /**
   * Get the merchant order number
   *
   * @return string
   */
  public function getOrderNumber () {
    return $this->safeGet('ORDR');
  }

  /**
   * Get the RIS auto response (A/R/D)
   *
   * @return string
   */
  public function getAuto () {
    return $this->safeGet('AUTO');
  }

  /**
   * Get the RIS reason for the response/score
   *
   * @return string
   * @deprecated version 5.0.0 - 2012.
   *     Use Kount_Ris_Response->getReasonCode() instead.
   */
  public function getReason () {
    $this->logger->info('The method Kount_Ris_Response->getReason() is " +
        "deprecated. Use Kount_Ris_Response->getReasonCode() instead.');
    return $this->safeGet('REAS');
  }

  /**
   * Get the merchant defined decision reason code.
   *
   * @return string
   */
  public function getReasonCode () {
    return $this->safeGet('REASON_CODE');
  }

  /**
   * Get the Kount score
   *
   * @return int
   */
  public function getScore () {
    return $this->safeGet('SCOR');
  }


  /**
   * Get the Kount OMNI score
   *
   * @return float
   */
  public function getOmniscore () {
    return $this->safeGet('OMNISCORE');
  }

  /**
   * Get the geox
   *
   * @return string
   */
  public function getGeox () {
    return $this->safeGet('GEOX');
  }

  /**
   * Get the card brand
   *
   * @return string
   */
  public function getBrand () {
    return $this->safeGet('BRND');
  }

  /**
   * Get the 6 week velocity
   *
   * @return int
   */
  public function getVelo () {
    return $this->safeGet('VELO');
  }

  /**
   * Get the 6 hour velocity
   *
   * @return int
   */
  public function getVmax () {
    return $this->safeGet('VMAX');
  }

  /**
   * Get the network type
   *
   * @return string
   */
  public function getNetwork () {
    return $this->safeGet('NETW');
  }

  /**
   * Get the 'know your customer' flash
   *
   * @return string
   */
  public function getKnowYourCustomer () {
    return $this->safeGet('KYCF');
  }

  /**
   * Get the region
   *
   * @return string
   */
  public function getRegion () {
    return $this->safeGet('REGN');
  }

  /**
   * Get the kaptcha flag, enabled upon request and for when a RIS record has
   *
   * @return string
   */
  public function getKaptcha () {
    return $this->safeGet('KAPT');
  }


  /**
   * Get a string representing whether the remote device is using a proxy
   * @return string "Y" or "N"
   */
  public function getProxy () {
    return $this->safeGet('PROXY');
  }

  /**
   * Get the number of transactions associated with the email
   * @return string
   */
  public function getEmails () {
    return $this->safeGet('EMAILS');
  }

  /**
   * Get the two character country code setting in the remote device's
   * browser
   * @return string
   */
  public function getHttpCountry () {
    return $this->safeGet('HTTP_COUNTRY');
  }

  /**
   * Get a string representing the time zone of the customer as a 3 digit
   * number
   * @return string
   */
  public function getTimeZone () {
    return $this->safeGet('TIMEZONE');
  }

  /**
   * Get the number of transactions associated with the credit card
   * @return string
   */
  public function getCards () {
    return $this->safeGet('CARDS');
  }

  /**
   * Get a string representing whether the end device is a remotely
   * controlled computer
   * @return string "Y" or "N"
   */
  public function getPcRemote () {
    return $this->safeGet('PC_REMOTE');
  }

  /**
   * Get the number of transactions associated with the particular device
   * @return string
   */
  public function getDevices () {
    return $this->safeGet('DEVICES');
  }

  /**
   * Get a string representing the five layers (Operating System, SSL, HTTP,
   * Flash, JavaScript) of the remote device
   * @return string
   */
  public function getDeviceLayers () {
    return $this->safeGet('DEVICE_LAYERS');
  }

  /**
   * Get the mobile device's wireless application protocol
   * @return string
   */
  public function getMobileForwarder () {
    return $this->safeGet('MOBILE_FORWARDER');
  }

  /**
   * Get a string representing whether or not the remote device is voice
   * controlled
   * @return string "Y" or "N"
   */
  public function getVoiceDevice () {
    return $this->safeGet('VOICE_DEVICE');
  }

  /**
   * Get local time of the remote device in the YYYY-MM-DD format
   * @return string
   */
  public function getLocalTime () {
    return $this->safeGet('LOCALTIME');
  }

  /**
   * Get the mobile device type
   * @return string
   */
  public function getMobileType () {
    return $this->safeGet('MOBILE_TYPE');
  }

  /**
   * Get the device finger print
   * @return string
   */
  public function getFingerPrint () {
    return $this->safeGet('FINGERPRINT');
  }

  /**
   * Get a string representing whether or not the remote device allows flash
   * @return string "Y" or "N"
   */
  public function getFlash () {
    return $this->safeGet('FLASH');
  }

  /**
   * Get the language setting on the remote device
   * @return string
   */
  public function getLanguage () {
    return $this->safeGet('LANGUAGE');
  }

  /**
   * Get the remote device's country of origin as a two character code
   * @return string
   */
  public function getCountry () {
    return $this->safeGet('COUNTRY');
  }

  /**
   * Get a string representing whether the remote device allows JavaScript
   * @return string "Y" or "N"
   */
  public function getJavaScript () {
    return $this->safeGet('JAVASCRIPT');
  }

  /**
   * Get a string representing whether the remote device allows cookies
   * @return string "Y" or "N"
   */
  public function getCookies () {
    return $this->safeGet('COOKIES');
  }

  /**
   * Get a string representing whether the remote device is a mobile device
   * @return string "Y" or "N"
   */
  public function getMobileDevice () {
    return $this->safeGet('MOBILE_DEVICE');
  }

  /**
   * Get MasterCard Fraud Score associated with the RIS transaction. Please
   * contact your Kount representative to enable support for this feature in
   * your merchant account.
   * @return string MasterCard Fraud Score
   */
  public function getMasterCardFraudScore () {
    return $this->safeGet('MASTERCARD');
  }

  /**
   * Get pierced IP address
   * @return string Pierced IP address
   */
  public function getPiercedIPAddress () {
    return $this->safeGet('PIP_IPAD');
  }

  /**
   * Get latitude of pierced IP address
   * @return string Latitude of pierced IP address
   */
  public function getPiercedIPAddressLatitude () {
    return $this->safeGet('PIP_LAT');
  }

  /**
   * Get longitude of pierced IP address
   * @return string Longitude of pierced IP address
   */
  public function getPiercedIPAddressLongitude () {
    return $this->safeGet('PIP_LON');
  }

  /**
   * Get country of pierced IP address
   * @return string Country of pierced IP address
   */
  public function getPiercedIPAddressCountry () {
    return $this->safeGet('PIP_COUNTRY');
  }

  /**
   * Get region of pierced IP address
   * @return string Region of pierced IP address
   */
  public function getPiercedIPAddressRegion () {
    return $this->safeGet('PIP_REGION');
  }

  /**
   * Get city of pierced IP address
   * @return string City of pierced IP address
   */
  public function getPiercedIPAddressCity () {
    return $this->safeGet('PIP_CITY');
  }

  /**
   * Get organization of pierced IP address
   * @return string Organization of pierced IP address
   */
  public function getPiercedIPAddressOrganization () {
    return $this->safeGet('PIP_ORG');
  }

  /**
   * Get proxy IP address
   * @return string Proxy IP address
   */
  public function getIPAddress () {
    return $this->safeGet('IP_IPAD');
  }

  /**
   * Get latitude of proxy IP address
   * @return string Latitude of proxy IP address
   */
  public function getIPAddressLatitude () {
    return $this->safeGet('IP_LAT');
  }

  /**
   * Get longitude of proxy IP address
   * @return string Longitude of proxy IP address
   */
  public function getIPAddressLongitude () {
    return $this->safeGet('IP_LON');
  }

  /**
   * Get country of proxy IP address
   * @return string Country of proxy IP address
   */
  public function getIPAddressCountry () {
    return $this->safeGet('IP_COUNTRY');
  }

  /**
   * Get region of proxy IP address
   * @return string Region of proxy IP address
   */
  public function getIPAddressRegion () {
    return $this->safeGet('IP_REGION');
  }

  /**
   * Get city of proxy IP address
   * @return string City of proxy IP address
   */
  public function getIPAddressCity () {
    return $this->safeGet('IP_CITY');
  }

  /**
   * Get organization of proxy IP address
   * @return string Organization of proxy IP address
   */
  public function getIPAddressOrganization () {
    return $this->safeGet('IP_ORG');
  }

  /**
   * Get date device first seen
   * @return string Date device first seen
   */
  public function getDateDeviceFirstSeen () {
    return $this->safeGet('DDFS');
  }

  /**
   * Get user agent string
   * @return string User agent string
   */
  public function getUserAgentString () {
    return $this->safeGet('UAS');
  }

  /**
   * Get device screen resolution
   * @return string Device screen resolution (HxW - Height by Width)
   */
  public function getDeviceScreenResolution () {
    return $this->safeGet('DSR');
  }

  /**
   * Get operating system (derived from user agent string)
   * @return string OS (operating system)
   */
  public function getOS () {
    return $this->safeGet('OS');
  }

  /**
   * Get browser (derived from user agent string)
   * @return string Browser
   */
  public function getBrowser () {
    return $this->safeGet('BROWSER');
  }

  /**
   * Print all values in the object
   * @return string The string representation of the response
   */
  public function __toString () {
    return $this->raw;
  }

  /**
   * Get a possible error code
   *
   * @return string
   */
  public function getErrorCode () {
    return $this->safeGet('ERRO');
  }

  /**
   * Get a value from $this->response with safe handling of missing keys.
   * @param string $key Value to get
   * @return string Value found in response or null if key not present
   */
  protected function safeGet ($key) {
    return array_key_exists($key, $this->response) ? $this->response[$key] : null;
  }

  /**
   * Get an array with the fields from the RIS response.
   * Getting the response array is null-safe.
   *
   * @return array Response fields
   */
  public function getResponseAsDict () {
    return !is_null($this->response) ? $this->response : '';
  }

  /**
   * Get an array of the rules triggered by this Response.
   * @return array Rules triggered
   */
  public function getRulesTriggered () {
    $rules = array();
    $ruleCount = $this->getNumberRulesTriggered();
    for ($i = 0; $i < $ruleCount; $i++) {
      $ruleId = $this->safeGet("RULE_ID_{$i}");
      $rules[$ruleId] = $this->safeGet("RULE_DESCRIPTION_{$i}");
    }
    return $rules;
  }

  /**
   * Get the number of rules triggered with the response.
   * @return int Number of rules triggered
   */
  public function getNumberRulesTriggered () {
    // A RIS response will always contain the field RULES_TRIGGERED which
    // will be set to zero if there are no rules triggered.
    return (int) $this->safeGet("RULES_TRIGGERED");
  }

  /**
   * Get an array of the warnings associated with this response.
   * @return array Array of warning messages
   */
  public function getWarnings () {
    $warnings = array();
    $warningCount = $this->getWarningCount();
    for ($i = 0; $i < $warningCount; $i++) {
      $warnings[] = $this->safeGet("WARNING_{$i}");
    }
    return $warnings;
  }

  /**
   * Get the number of warnings associated with the response.
   * @return int Number of warnings
   */
  public function getWarningCount () {
    // A RIS response will always contain the field WARNING_COUNT which
    // will be set to zero if there are no warnings.
    return (int) $this->safeGet("WARNING_COUNT");
  }

  /**
   * Get the errors associated with the response.
   * @return array Array of error messages
   */
  public function getErrors () {
    $errors = array();
    $errorCount = $this->getErrorCount();
    for ($i = 0; $i < $errorCount; $i++) {
      $errors[] = $this->safeGet("ERROR_{$i}");
    }
    return $errors;
  }

  /**
   * Get the number of errors associated with the response.
   * @return int Number of errors
   */
  public function getErrorCount () {
    // A normal response will not contain any errors in which case the
    // RIS response field ERROR_COUNT will not be sent.
    return (int) $this->safeGet("ERROR_COUNT");
  }

  /**
   * Get LexisNexis Chargeback Defender attribute data associated with the RIS
   * transaction. Please contact your Kount representative to enable support
   * for this feature in your merchant account.
   *
   * @return array The array keys are the attribute names and the values are the
   *     attribute values.
   */
  public function getLexisNexisCbdAttributes () {
    return $this->getPrefixedResponseDataMap("CBD_");
  }

  /**
   * Get LexisNexis Instant ID attribute data associated with the RIS
   * transaction. Please contact your Kount representative to enable support
   * for this feature in your merchant account.
   *
   * @return array The array keys are the attribute names and the values are the
   *     attribute values.
   */
  public function getLexisNexisInstantIdAttributes () {
    return $this->getPrefixedResponseDataMap("INSTANTID_");
  }

  /**
   * Get a map of the response data where the keys are the RIS response keys
   * that begin with a specified prefix.
   * @param string $prefix Key prefix.
   * @return map Map of key-value pairs for a specified RIS key prefix.
   */
  protected function getPrefixedResponseDataMap ($prefix) {
    $data = array();
    foreach ($this->response as $key => $value) {
      $prefixLength = mb_strlen($prefix);
      if (mb_substr($key, 0, $prefixLength) == $prefix) {
        $data[mb_substr($key, $prefixLength)] = $value;
      }
    }
    return $data;
  }

  /**
   * Get the number of rules counters triggered in the response.
   * @return int Number of counters triggered
   */
  public function getNumberCountersTriggered () {
    return (int) $this->safeGet("COUNTERS_TRIGGERED");
  }

  /**
   * Get an associative array of the rules counters associated with the response.
   * @return array Rules counters
   */
  public function getCountersTriggered () {
    $counters = array();
    $numCounters = $this->getNumberCountersTriggered();
    for ($i = 0; $i < $numCounters; $i++) {
      $counterName = $this->safeGet("COUNTER_NAME_{$i}");
      $counters[$counterName] = $this->safeGet("COUNTER_VALUE_{$i}");
    }
    return $counters;
  }

  /**
   * Get the number of Kount Central warnings associated with the response.
   * @return int Number of warnings
   */
  public function getKcWarningCount () {
    return (int) $this->safeGet("KC_WARNING_COUNT");
  }

  /**
   * Get an array of the Kount Central warnings associated with this response.
   * @return array Array of warning messages associated with response.
   */
  public function getKcWarnings () {
    $warnings = array();
    $warningCount = $this->getKcWarningCount();
    for ($i = 1; $i <= $warningCount; $i++) {
      $warnings[] = $this->safeGet("KC_WARNING_{$i}");
    }
    return $warnings;
  }

  /**
   * Get the number of Kount Central errors associated with the response.
   * @return int Number of errors
   */
  public function getKcErrorCount () {
    return (int) $this->safeGet("KC_ERROR_COUNT");
  }

  /**
   * Get the Kount Central errors associated with the response.
   * @return array Array of error messages
   */
  public function getKcErrors () {
    $errors = array();
    $errorCount = (int) $this->safeGet("KC_ERROR_COUNT");
    for ($i = 1; $i <= $errorCount; $i++) {
      $errors[] = $this->safeGet("KC_ERROR_{$i}");
    }
    return $errors;
  }

  /**
   * Get the Kount Central decision
   * @return string The decision from Kount Central
   */
  public function getKcDecision () {
    return $this->safeGet("KC_DECISION");
  }

  /**
   * Get the number of Kount Central events associated with the response.
   * @return int Number of events
   */
  public function getKcEventCount () {
    return (int) $this->safeGet("KC_TRIGGERED_COUNT");
  }

  /**
   * Get the Kount Central threshold events associated with the decision
   * @return array An array of Kount Central Event objects
   */
  public function getKcEvents () {
    $events = array();
    $eventCount = $this->getKcEventCount();
    for ($i = 1; $i <= $eventCount; $i++) {
      $event = new Kount_Ris_Data_KcEvent(
        $this->safeGet("KC_EVENT_{$i}_DECISION"),
        $this->safeGet("KC_EVENT_{$i}_EXPRESSION"),
        $this->safeGet("KC_EVENT_{$i}_CODE"));
      $events[] = $event;
    }
    return $events;
  }

} // Kount_Ris_Response
