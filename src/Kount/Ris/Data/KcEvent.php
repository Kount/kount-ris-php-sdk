<?php
/**
 * KcEvent.php containing Kount_Ris_Data_KcEvent class.
 */

/**
 * RIS Kount event class handler.
 *
 * @package Kount_Ris
 * @subpackage Data
 * @author Kount <custserv@kount.com>
 * @version $Id: Exception.php 228 2009-10-26 18:04:59Z mmn $
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Ris_Data_KcEvent {

  /**
   * The decision
   *
   * @var string
   */
  protected $decision;

  /**
   * Desciption of the event
   *
   * @var string
   */
  protected $expression;

  /**
   * Event code
   *
   * @var string
   */
  protected $code;

  /**
   * Construct a response object
   *
   * @param string $decision The decision
   * @param string $expression Description of the event
   * @param string $code The event code
   */
  public function __construct ($decision, $expression, $code) {
    $this->decision = $decision;
    $this->expression = $expression;
    $this->code = $code;
  }

  /**
   * Get the product type
   *
   * @return string
   */
  public function getDecision () {
    return ($this->decision != null) ? $this->decision : '';
  }

  /**
   * Get the item name
   *
   * @return string
   */
  public function getExpression () {
    return ($this->expression != null) ? $this->expression : '';
  }

  /**
   * Get the description
   *
   * @return string
   */
  public function getCode () {
    return ($this->code != null) ? $this->code : '';
  }

} // Kount_Ris_Data_KcEvent
