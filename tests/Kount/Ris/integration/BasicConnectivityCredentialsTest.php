<?php

class BasicConnectivityCredentialsTest extends \PHPUnit\Framework\TestCase
{
  const EMAIL = 'predictive@kount.com';

  private function getInquiryCustomCreds()
  {
    $inquiry = (new UtilityHelperTest())->createInquiry();

    $inquiry->setEmail(self::EMAIL);

    return $inquiry;
  }

  public function testExpectedScore()
  {
    $inquiry = $this->getInquiryCustomCreds();

    $inquiry->setParm('UDF[~K!_SCOR]', 42);
    $response = $inquiry->getResponse();
    $this->assertEquals(42, $response->getScore());
  }

  public function testExpectedDecision()
  {
    $inquiry = $this->getInquiryCustomCreds();

    $inquiry->setParm('UDF[~K!_AUTO]', 'R');
    $response = $inquiry->getResponse();

    $this->assertEquals('R', $response->getAuto());
  }
}
