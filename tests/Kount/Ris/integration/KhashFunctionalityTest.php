<?php


class ConfigurationSaltTest extends \PHPUnit\Framework\TestCase
{
  const  CARD_NUM_1 = "4111111111111111";
  const  CARD_NUM_2 = "5199185454061655";
  const  CARD_NUM_3 = "4259344583883";
  const  MERCHANT_ID = 666666;

  public function testCorrectCreditCard1() {
    
    $configReader = Kount_Util_ConfigFileReader::instance();
    if ($configReader->getConfigSetting('CONFIG_KEY') == '$CONFIG_KEY') {
      Kount_Util_Khash::setConfigKey(base64_decode(getenv("RIS_CONFIG_KEY_BASE64")));
    }
    
    $token = Kount_Util_Khash::hashPaymentToken(self::CARD_NUM_1);

    $this->assertEquals('411111WMS5YA6FUZA1KC', $token);
  }

  public function testCorrectCreditCard2() {
    $token = Kount_Util_Khash::hashPaymentToken(self::CARD_NUM_2);

    $this->assertEquals('5199182NOQRXNKTTFL11', $token);
  }

  public function testCorrectCreditCard3() {
    $token = Kount_Util_Khash::hashPaymentToken(self::CARD_NUM_3);

    $this->assertEquals('425934FEXQI1QS6TH2O5', $token);
  }

  public function testCorrectGiftCard1() {
    $token = Kount_Util_Khash::hashGiftCard(self::MERCHANT_ID, self::CARD_NUM_1);

    $this->assertEquals('666666WMS5YA6FUZA1KC', $token);
  }

  public function testCorrectGiftCard2() {
    $token = Kount_Util_Khash::hashGiftCard(self::MERCHANT_ID, self::CARD_NUM_2);

    $this->assertEquals('6666662NOQRXNKTTFL11', $token);
  }

  public function testCorrectGiftCard3() {
    $token = Kount_Util_Khash::hashGiftCard(self::MERCHANT_ID, self::CARD_NUM_3);

    $this->assertEquals('666666FEXQI1QS6TH2O5', $token);
  }

  public function testHashWithNull() {
    $token = Kount_Util_Khash::hashPaymentToken(null);

    $this->assertEquals('TBNC2MTR28JOUY', $token);
  }
}