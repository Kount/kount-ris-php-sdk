<?php

class MaskEncodingTest extends PHPUnit_Framework_TestCase {

  const MERCHANT_ID  = 999666;
  const RIS_ENDPOINT = "https://risk.beta.kount.net";
  const API_KEY = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI5OTk2NjYiLCJhdWQiOiJLb3VudC4xIiwiaWF0IjoxNDk0NTM0Nzk5LCJzY3AiOnsia2EiOm51bGwsImtjIjpudWxsLCJhcGkiOmZhbHNlLCJyaXMiOnRydWV9fQ.eMmumYFpIF-d1up_mfxA5_VXBI41NSrNVe9CyhBUGck';

  private function getInquiry($cardNumber) {
    $inquiry = (new UtilityHelperTest())->createMaskedInquiry($cardNumber, self::RIS_ENDPOINT, self::MERCHANT_ID);

    $inquiry->setApiKey(self::API_KEY);

    return $inquiry;
  }

  public function testRisQUsingPaymentEncodingMaskValid() {
    $inquiry = $this->getInquiry('370070538959797');
    $response = $inquiry->getResponse();

    $this->assertEquals('AMEX', $response->getBrand());
  }

  public function testRisQUsingPaymentEncodingMaskError() {
    $inquiry = $this->getInquiry('370070538959797');
    $inquiry->setParm('PTOK', '370070538959797');
    $response = $inquiry->getResponse();

    $this->assertEquals('E', $response->getMode());
    $this->assertEquals(340, $response->getErrorCode());
    $this->assertEquals('340 BAD_MASK Cause: [value [370070538959797] did not match regex /^\d{6}X{5,9}\d{1,4}$/], Field: [PTOK], Value: [370070538959797]', $response->getErrors()[0]);
    $this->assertEquals(1, $response->getErrorCount());
    $this->assertEquals(0, $response->getWarningCount());
  }
}