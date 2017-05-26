<?php
/**
 * LoggerFactory.php file containing Kount_Log_Factory_LoggerFactory interface.
 */

/**
 * Interface for factory classes that create Kount_Log_Binding_Logger objects.
 *
 * @package Kount_Log
 * @subpackage Factory
 * @author Kount <custserv@kount.com>
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
interface Kount_Log_Factory_LoggerFactory {

  /**
   * Get a named logger.
   *
   * @param string $name Name of logger
   * @return Kount_Log_Factory_LoggerFactory
   */
  public static function getLogger ($name);

} // end Kount_Log_Factory_LoggerFactory
