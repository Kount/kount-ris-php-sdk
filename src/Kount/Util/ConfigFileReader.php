<?php

/**
 * ConfigFileReader.php file containing Kount_Util_ConfigFileReader class.
 */

if (!defined('KOUNT_SETTINGS_FILE')) {
  /*
   * Path to SDK configuration file.
   * @var string
   */
  define('KOUNT_SETTINGS_FILE', realpath(dirname(__FILE__) .
    DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . '..' .
    DIRECTORY_SEPARATOR . 'settings.ini'));
}

/**
 * A class for reading Kount configuration files.
 *
 * @package Kount_Util
 * @author Kount <custserv@kount.com>
 * @version $Id: Request.php 11177 2010-08-16 21:44:19Z bst $
 * @copyright 2012 Kount, Inc. All Rights Reserved.
 */
class Kount_Util_ConfigFileReader
{

  /**
   * An instance of this class.
   * @var Kount_Util_ConfigFileReader
   */
  protected static $instance = null;

  /**
   * A map of the config settings.
   * @var Map
   */
  protected $settings;

  /**
   * Private constructor to prevent direct object instantiation.
   * @param string $path absolute path to custom settings file.
   * @throws Exception when reading a file fails.
   */
  private function __construct($path = null)
  {
    if ($path == null) {
      $file = KOUNT_SETTINGS_FILE;
    } else {
      $file = $path;
    }
    $this->settings = parse_ini_file($file, false);
  }

  /**
   * Get an instance of this class.
   * @param string @path Absolute path to custom settings file.
   * @return Kount_Util_ConfigFileReader
   */
  public static function instance($path = null)
  {
    if ($path == null) {
      self::$instance = new Kount_Util_ConfigFileReader();
    } else {
      self::$instance = new Kount_Util_ConfigFileReader($path);
    }
    return self::$instance;
  }

  /**
   * Get static RIS settings from an ini file.
   * @return array Hash map
   */
  public function getSettings()
  {
    return $this->settings;
  }

  /**
   * Get a named configuration setting.
   * @param string $name Get a named configuration file setting
   * @return string
   * @throws Exception If the specified setting name does not exist.
   */
  public function getConfigSetting($name)
  {
    $settings = $this->getSettings();
    return $settings[$name];
  }
} // end Kount_Util_ConfigFileReader
