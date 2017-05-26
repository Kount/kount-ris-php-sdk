<?php
/**
 * Validate.php file containing Kount_Ris_Validate class.
 */

if (!defined('KOUNT_VALIDATION_FILE')) {
  /*
   * Path to input validation file.
   *
   * @var string
   */
  define('KOUNT_VALIDATION_FILE', realpath(dirname(__FILE__) .
      DIRECTORY_SEPARATOR . 'etc' . DIRECTORY_SEPARATOR . 'validate.xml'));
}

/**
 * Validate class container for the static validate method
 *
 * @package Kount_Ris
 * @author Kount <custserv@kount.com>
 * @version 0.1 SVN: $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_Validate {

  /**
   * Xml validation data cache
   *
   * @var string
   */
  static public $xml = null;

  /**
   * Disallow construction.
   */
  private function __construct () {
    // no-op
  }

  /**
   * Validate RIS request data based on params in an xml file
   *
   * @param array $data Array of data being sent to the RIS server
   * @return array Kount_Ris_ValidationError objects
   */
  public static function validate ($data) {
    $errors = array();

    if (null === self::$xml) {
      self::$xml = simplexml_load_file(KOUNT_VALIDATION_FILE);
    }

    // request mode
    $mode = (isset($data['MODE']))? $data['MODE']: null;

    $cartKeys = self::findCartKeys($data);

    // validate each param in the xml file
    foreach (self::$xml->param as $rule) {
      $name = trim($rule->attributes()->name);

      // check for required fields
      if (isset($rule->required)) {
        $required = false;
        if (isset($rule->required->mode)) {
          // check current request mode vs list of modes that require $name
          // It really takes some effort to stand out as a bad api in php, but
          // simplexml really goes above and beyond in creating an api that
          // only the original author could find intuitative.
          foreach ($rule->required->mode as $reqMode) {
            $required = $required || ($reqMode == $mode);
          }

        } else {
          // if `required` node doesn't contain a mode child we know that
          // this key is unconditionally required.
          $required = true;
        }

        if ($required &&
            !(isset($data[$name]) || isset($cartKeys[$name]))) {
          $errors[] =
              Kount_Ris_ValidationError::requiredFieldError($name, $mode);
        }
      } // end if rule is required

      // validate field contents if provided
      if (isset($data[$name])) {
        $errors = array_merge(
            $errors, self::validateField($rule, $name, $data));

      } else if (isset($cartKeys[$name])) {
        foreach ($cartKeys[$name] as $key) {
          $errors = array_merge(
              $errors, self::validateField($rule, $key, $data));
        }
      }
    } // end foreach xml node

    return $errors;
  } //end validate


  /**
   * Validate a field.
   *
   * @param SimpleXMLElement $rule Validation rule
   * @param string $name Element to validate
   * @param array $data Request data to validate
   * @return array Validation errors
   */
  private static function validateField ($rule, $name, $data) {
    $errors = array();

    // check max length
    if (isset($rule->max_length) &&
        ($rule->max_length < mb_strlen($data[$name]))) {
      $errors[] = Kount_Ris_ValidationError::maximumLengthError(
          $name, $data[$name], $rule->max_length);
    }

    // check regular expression
    if (isset($rule->reg_ex) &&
        !preg_match("/{$rule->reg_ex}/", $data[$name])) {
      $errors[] = Kount_Ris_ValidationError::regexError(
          $name, $data[$name], $rule->reg_ex);
    }

    return $errors;
  } //end validateField


  /**
   * Extract cart parameter keys from the request and return in a collection
   * keyed on the base parameter names.
   *
   * @param array $data Request data
   * @return array Array of param => array of cart key names
   */
  private static function findCartKeys ($data) {
    $keys = array_keys($data);

    $cartParams = array();

    foreach ($keys as $key) {
      $matches = false;
      if (preg_match('/^(PROD_\w+)\[.*\]$/', $key, $matches) == 1) {
        $slot = $matches[1];
        if (!isset($cartParams[$slot])) {
          $cartParams[$slot] = array();
        }
        $cartParams[$slot][] = $key;
      }
    }
    return $cartParams;
  } //end findCartKeys

} // Kount_Ris_Validate
