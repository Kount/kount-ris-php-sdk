<?php
/**
 * ValidationError.php file containing Kount_Ris_ValidationError class.
 */

/**
 * A class representing a RIS SDK client side validation error.
 * @package Kount_Ris
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_ValidationError {

  /**
   * A field regular expression error type.
   * @var string
   */
  const REGEX_ERR = "REGEX";

  /**
   * A field length error type.
   * @var string
   */
  const LENGTH_ERR = "LENGTH";

  /**
   * A required field error type.
   * @var string
   */
  const REQUIRED_ERR = "REQUIRED";

  /**
   * The error type.
   * @var string
   */
  public $error;

  /**
   * The field.
   * @var string
   */
  public $field;

  /**
   * The RIS mode.
   * @var string
   */
  public $mode;

  /**
   * Field value.
   * @var string
   */
  public $value;

  /**
   * Regular expression pattern.
   * @var string
   */
  public $pattern;

  /**
   * Maximum allowable length of a field.
   * @var int
   */
  public $maxLength;

  /**
   * Constructor for missing required field.
   * @param string $field The name of the bad field
   */
  public function __construct ($field) {
    $this->field = $field;
  }

  /**
   * Get the string representation of the error.
   * @return message
   */
  public function __toString () {
    switch ($this->error) {
      case self::LENGTH_ERR:
        $len = mb_strlen($this->value);
        $m = "Field [{$this->field}] has length [{$len}] " .
            "which is longer than the maximum of [{$this->maxLength}]";
        break;

      case self::REGEX_ERR:
        $m = "Field [{$this->field}] has value [{$this->value}] " .
            "which does not match the pattern [{$this->pattern}]";
        break;

      case self::REQUIRED_ERR:
          $m = "Required field [{$this->field}] missing " .
              "for mode [{$this->mode}]";
        break;

      default:
        $m = "unknown validation error [{$this->error}]";
        break;
    } // end switch error type
    return $m;
  }

  /**
   * Set values for a regular expression error.
   *
   * @param string $field The name of the bad field
   * @param string $mode The RIS mode the field is associated with
   * @return Kount_Ris_ValidationError Error object
   */
  public static function requiredFieldError ($field, $mode) {
    $e = new Kount_Ris_ValidationError($field);
    $e->error = self::REQUIRED_ERR;
    $e->mode = $mode;
    return $e;
  }

  /**
   * Set values for a regular expression error.
   *
   * @param string $field The name of the bad field
   * @param string $value The value of the field
   * @param string $pattern The regular expression violated.
   * @return Kount_Ris_ValidationError Error object
   */
  public static function regexError ($field, $value, $pattern) {
    $e = new Kount_Ris_ValidationError($field);
    $e->error = self::REGEX_ERR;
    $e->value = $value;
    $e->pattern = $pattern;
    return $e;
  }

  /**
   * Set values for a maximum length error.
   *
   * @param string $field The name of the bad field
   * @param string $value The value of the field
   * @param int $length The maximum allowable length
   * @return Kount_Ris_ValidationError Error object
   */
  public static function maximumLengthError ($field, $value, $length) {
    $e = new Kount_Ris_ValidationError($field);
    $e->error = self::LENGTH_ERR;
    $e->value = $value;
    $e->maxLength = $length;
    return $e;
  }

} // end Kount_Ris_ValidationError
