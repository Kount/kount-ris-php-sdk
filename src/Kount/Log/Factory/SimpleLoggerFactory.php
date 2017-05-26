<?php
/**
 * SimpleLoggerFactory.php file containing Kount_Log_Factory_SimpleLoggerFactory class.
 */

/**
 * A factory class that creates Kount_Log_Binding_SimpleLogger objects.
 *
 * @package Kount_Log
 * @subpackage Factory
 * @author Kount <custserv@kount.com>
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Log_Factory_SimpleLoggerFactory implements
 Kount_Log_Factory_LoggerFactory {

  /**
   * Get a Simple Logger.
   * @param string $name Logger name
   * @return Kount_Log_Binding_SimpleLogger
   */
  public static function getLogger ($name) {
    return new Kount_Log_Binding_SimpleLogger($name);
  }

} // end Kount_Log_Factory_SimpleLoggerFactory
