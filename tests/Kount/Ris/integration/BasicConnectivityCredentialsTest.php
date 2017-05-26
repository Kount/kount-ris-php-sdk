<?php

class BasicConnectivityCredentialsTest extends PHPUnit_Framework_TestCase
{
  const MERCHANT_ID = 999667;
  const EMAIL = 'predictive@kount.com';
  const RIS_ENDPOINT = "https://risk.beta.kount.net";
  const API_KEY = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI5OTk2NjciLCJhdWQiOiJLb3VudC4xIiwiaWF0IjoxNDk0NTM1OTE2LCJzY3AiOnsia2EiOm51bGwsImtjIjpudWxsLCJhcGkiOmZhbHNlLCJyaXMiOnRydWV9fQ.KK3zG4dMIhTIaE5SeCbej1OAFhZifyBswMPyYFAVRrM';

  private function getInquiryCustomCreds() {
    $inquiry = (new UtilityHelperTest())->createInquiry(self::MERCHANT_ID, self::RIS_ENDPOINT, self::API_KEY);

    $inquiry->setMerchantId(self::MERCHANT_ID);
    $inquiry->setEmail(self::EMAIL);
    //$inquiry->setApiKey(self::API_KEY);

    return $inquiry;
  }

  public function testExpectedScore() {
    $inquiry = $this->getInquiryCustomCreds();

    $inquiry->setParm('UDF[~K!_SCOR]', 42);
    $response = $inquiry->getResponse();
    $this->assertEquals(42, $response->getScore());
  }

  public function testExpectedDecision() {
    $inquiry = $this->getInquiryCustomCreds();

    $inquiry->setParm('UDF[~K!_AUTO]', 'R');
    $response = $inquiry->getResponse();

    $this->assertEquals('R', $response->getAuto());
  }
}