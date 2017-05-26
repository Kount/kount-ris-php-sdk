<?php
/**
 * NopLoggerFactory.php file containing Kount_Log_Factory_NopLoggerFactory class.
 */

/**
 * A factory class that creates Kount_Log_Binding_NopLogger objects.
 *
 * @package Kount_Log
 * @subpackage Factory
 * @author Kount <custserv@kount.com>
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Log_Factory_NopLoggerFactory implements
 Kount_Log_Factory_LoggerFactory {

  /**
   * Get a Nop Logger.
   * @param string $name Logger name
   * @return Kount_Log_Binding_NopLogger
   */
  public static function getLogger ($name) {
    return new Kount_Log_Binding_NopLogger($name);
  }

} // end Kount_Log_Factory_NopLoggerFactory
