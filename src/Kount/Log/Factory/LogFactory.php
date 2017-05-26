<?php
/**
 * LogFactory.php file containing Kount_Log_Factory_LoggerFactory class.
 */

/**
 * A factory class for creating Kount_Log_Factory_LoggerFactory objects.
 *
 * @package Kount_Log
 * @subpackage Factory
 * @author Kount <custserv@kount.com>
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Log_Factory_LogFactory {

  /**
   * NOP logger configuration setting name.
   * @var string
   */
  const NOP_LOGGER = 'NOP';

  /**
   * Simple logger configuration setting name.
   * @var string
   */
  const SIMPLE_LOGGER = 'SIMPLE';

  /**
   * Logger factory.
   * @var Kount_Log_Factory_LoggerFactory
   */
  protected static $loggerFactory = null;

  /**
   * Get the logger factory to be used.
   * @throws Exception "Unknown logger defined in setting file" when $logger doesn't mach
   * any of the configuration setting names.
   * @return Kount_Log_Factory_LoggerFactory
   */
  public static function getLoggerFactory () {

    if (self::$loggerFactory == null) {
      $configReader = Kount_Util_ConfigFileReader::instance();
      $logger = $configReader->getConfigSetting('LOGGER');

      if ($logger == self::NOP_LOGGER) {
        self::$loggerFactory = new Kount_Log_Factory_NopLoggerFactory();
      } else if ($logger == self::SIMPLE_LOGGER) {
        self::$loggerFactory = new Kount_Log_Factory_SimpleLoggerFactory();
      } else {
        throw new Exception("Unknown logger [{$logger}] defined in setting " .
            "file [" . Kount_Util_ConfigFileReader::SETTINGS_FILE . "]");
      }

    }

    return self::$loggerFactory;
  }

  /**
   * Set the logger factory to be used.
   * @param Kount_Log_Factory_LoggerFactory $factory The logger factory to use
   * @return void
   */
  public static function setLoggerFactory ($factory) {
    self::$loggerFactory = $factory;
  }

} // end Kount_Log_Factory_LogFactory
