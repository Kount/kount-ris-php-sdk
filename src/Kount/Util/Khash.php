<?php
/**
 * Khash.php file containing Kount_Util_Khash class.
 */
/**
 * Kount payment token hashing class.
 *
 * Example usage:
 *   $hashed = Kount_Util_Khash::hashPaymentToken("4111111111111111");
 *     Expect: 411111WMS5YA6FUZA1KC
 *   $hashed = Kount_Util_Khash::hashPaymentToken("5199185454061655");
 *     Expect: 5199182NOQRXNKTTFL11
 *
 * @package Kount
 * @subpackage Util
 * @author Kount <custserv@kount.com>
 * @copyright 2011 Kount Inc. All Rights Reverved.
 */
class Kount_Util_Khash {

  private static $configKey;
  /**
   * An instance of this class.
   * @var Kount_Util_Khash
   */
  protected static $instance = null;
  /**
   * Set the config key for hashing.
   *
   * @param $configKey|string - config key set when user instantiates a RIS request.
   * @return string Config key used for hashing in hash function.
   */
  public static function setConfigKey($configKey) {
    self::$configKey = $configKey;
  }
  /**
   * Get function for the config key.
   *
   * @return string Config key used for hashing in hash function
   */
  public static function getConfigKey() {
    return self::$configKey;
  }
  /**
   * Kount_Util_Khash constructor. Initializes the Config Key used in hashing operations.
   * @param Kount_Ris_ArraySettings|string $settings Existing settings or path to custom settings file.
   */
  private function __construct($settings = null) {
    if ($settings instanceof Kount_Ris_ArraySettings) {
      self::$configKey = $settings->getConfigKey();
    } else {
      $configReader = Kount_Util_ConfigFileReader::instance($settings);
      $settings = new Kount_Ris_ArraySettings($configReader->getSettings());
      self::$configKey = $settings->getConfigKey();
    }
  }
  /**
   * Creates instance of this class.
   * @param Kount_Ris_ArraySettings|string $settings Existing settings or path to custom settings file.
   * @param bool $cached Whether or not to used the cached Khash
   * @return Kount_Util_Khash
   */
  public static function createKhash($settings = null, $cached = true) {
    if(self::$instance == null && $cached) {
      self::$instance = new Kount_Util_Khash($settings);
    }
    return self::$instance;
  }
  /**
   * Create a Kount hash of a provided payment token. Payment tokens that can be
   * hashed via this method include: credit card numbers, Paypal payment IDs,
   * Check numbers, Google Checkout IDs, Bill Me Later IDs, and Green Dot
   * MoneyPak IDs.
   *
   * @param string $token String to be hashed
   * @return string Hashed token
   */
  public static function hashPaymentToken ($token) {
    $firstSix = mb_substr($token, 0, 6, 'latin1');
    $hash = self::hash($token, 14);
    return (null == $token) ? '' : "{$firstSix}{$hash}";
  }
  /**
   * Create a Kount hash of a gift card number.
   *
   * @param int $merchantId Merchant ID
   * @param string $cardNumber Gift card number
   * @return string Hashed card number
   */
  public static function hashGiftCard ($merchantId, $cardNumber) {
    $hash = self::hash($cardNumber, 14);
    return "{$merchantId}{$hash}";
  }
  /**
   * Compute a Kount hash of the provided input string.
   *
   * @param string $data Data to hash
   * @param int $len Length of hash to retain
   * @throws Exception If $configKey is not configured in src/settings.ini or custom settings file.
   * @return string Hashed data
   */
  public static function hash ($data, $len) {
    $configKey = self::getConfigKey();
    if($configKey == null || !isset($configKey)) {
      throw new Exception("Unable to get configuration setting 'CONFIG_KEY'. " .
        "Check that the CONFIG_KEY setting exists and is not set to null or empty string. ");
    }
    static $a = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $r = sha1("{$data}.{$configKey}");
    $c = '';
    if ($len > 17) {
      $len = 17;
    }
    $limit = 2 * $len;
    for ($i = 0; $i < $limit; $i += 2) {
      $c .= $a[hexdec(mb_substr($r, $i, 7, 'latin1')) % 36];
    }
    return $c;
  }
} // end Kount_Util_Khash