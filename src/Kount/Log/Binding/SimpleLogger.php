<?php
/**
 * SimpleLogger.php containing Kount_Log_Binding_SimpleLogger class.
 */

/**
 * Implementation of a Simple Logging facade.
 * @package Kount_Log
 * @subpackage Binding
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Log_Binding_SimpleLogger implements Kount_Log_Binding_Logger {

  /**
   * A simple logger instance.
   * @var Logger
   */
  protected $logger;

  /**
   * Constructor for a simple logger binding.
   * @param string $name Name of the logger
   */
  public function __construct ($name) {
    $this->logger = new Kount_SimpleLogger_File($name);
  }

  /**
   * Log a debug level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function debug ($message, $exception = null) {
    $this->logger->debug($message, $exception);
  }

  /**
   * Log a debug level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function info ($message, $exception = null) {
    $this->logger->info($message, $exception);
  }

  /**
   * Log a debug level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function warn ($message, $exception = null) {
    $this->logger->warn($message, $exception);
  }

  /**
   * Log a debug level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function error ($message, $exception = null) {
    $this->logger->error($message, $exception);
  }

  /**
   * Log a debug level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function fatal ($message, $exception = null) {
    $this->logger->fatal($message, $exception);
  }

} // end Kount_Log_Binding_SimpleLogger
