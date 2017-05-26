<?php
/**
 * File.php file containing Kount_SimpleLogger_File class.
 */

/**
 * A simple file logger.
 *
 * @package Kount_SimpleLogger
 * @author Kount <custserv@kount.com>
 * @version $Id$
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_SimpleLogger_File {

  /**
   * Format for a time stamp.
   * @var string
   */
  const TIME_FORMAT = 'Y-m-d\TH:i:sP';

  /**
   * Logging levels
   * @var Map
   */
  protected $logLevels = array(
      'FATAL' => 5,
      'ERROR' => 4,
      'WARN' => 3,
      'INFO' => 2,
      'DEBUG' => 1,
    );

  /**
   * Name of the logger.
   * @var string
   */
  protected $name;

  /**
   * Absolute path to log file.
   * @var string
   */
  protected $logFilePath;

  /**
   * Simple logger log level.
   * @var string
   */
  protected $logLevel;

  /**
   * Constructor for a simple file logger.
   * @param string $name Name of the logger
   * @throws Exception If an illegal log level is defined in the configuration
   */
  public function __construct ($name) {
    $this->name = $name;
    $configReader = Kount_Util_ConfigFileReader::instance();
    $logFile = $configReader->getConfigSetting('SIMPLE_LOG_FILE');
    $logPath = $configReader->getConfigSetting('SIMPLE_LOG_PATH');
    $this->logFilePath = $logPath . DIRECTORY_SEPARATOR . $logFile;
    $this->logLevel = $configReader->getConfigSetting('SIMPLE_LOG_LEVEL');
    if (!array_key_exists($this->logLevel, $this->logLevels)) {
      throw new Exception("Illegal log level [{$this->logLevel}] " .
          "defined in setting file");
    }
  }

  /**
   * Log a debug level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function debug ($message, $exception = null) {
    $this->processMessage($message, 'DEBUG', $exception);
  }

  /**
   * Log an info level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function info ($message, $exception = null) {
    $this->processMessage($message, 'INFO', $exception);
  }

  /**
   * Log a warn level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function warn ($message, $exception = null) {
    $this->processMessage($message, 'WARN', $exception);
  }

  /**
   * Log an error level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function error ($message, $exception = null) {
    $this->processMessage($message, 'ERROR', $exception);
  }

  /**
   * Log a fatal level message.
   * @param string $message Message to log
   * @param Exception $exception Exception to log
   * @return void
   */
  public function fatal ($message, $exception = null) {
    $this->processMessage($message, 'FATAL', $exception);
  }

  /**
   * Process a log message, by determining if it should be logged, formatting
   * the message, and logging it.
   * @param string $message Message to be logged
   * @param string $level Logging level
   * @param Exception $exception A possible exception associated with the
   * message
   * @return void
   */
  protected function processMessage ($message, $level, $exception) {
    if ($this->isLoggable($level)) {
      $message = $this->formatMessage($message, $level, $exception);
      $this->log($message);
    }
  }

  /**
   * Format a message so it can be logged.
   * @param string $message Message to log
   * @param string $level Logging level of the message to be logged
   * @param exception $exception Exception to log
   * @return string Formatted message
   */
  protected function formatMessage ($message, $level, $exception = null) {
    $exceptionStr = '';
    if ($exception instanceof Exception) {
      $exceptionStr .= $exception->getMessage() . "\n";
      $exceptionStr .= $exception->getTraceAsString() . "\n";
    }
    $dateTime = date(self::TIME_FORMAT);
    $msg = "{$dateTime} [{$level}] {$this->name} - {$message}\n";
    $msg .= $exceptionStr;
    return $msg;
  }

  /**
   * Log a message.
   * @param string $message Message to log
   * @return void
   */
  protected function log ($message) {
    // Current day which will be appended to file name.
    $date = date('Y-m-d');
    file_put_contents($this->logFilePath . "." . $date, $message, FILE_APPEND);
  }

  /**
   * Determine if a message should be logged or not.
   * @param string $level Log level
   * @return boolean True if message is loggable, false or not
   */
  protected function isLoggable ($level) {
    $configLevel = $this->logLevels[$this->logLevel];
    $methodLevel = $this->logLevels[$level];
    if ($methodLevel >= $configLevel) {
      return true;
    }
    return false;
  }

} // end Kount_SimpleLogger_File
