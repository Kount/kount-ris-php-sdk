<?php

class RisSuiteTest extends PHPUnit_Framework_TestCase
{
  const MERCHANT_ID  = 999666;
  const RIS_ENDPOINT = "https://risk.beta.kount.net";
  const API_KEY = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI5OTk2NjYiLCJhdWQiOiJLb3VudC4xIiwiaWF0IjoxNDk0NTM0Nzk5LCJzY3AiOnsia2EiOm51bGwsImtjIjpudWxsLCJhcGkiOmZhbHNlLCJyaXMiOnRydWV9fQ.eMmumYFpIF-d1up_mfxA5_VXBI41NSrNVe9CyhBUGck';

  private function getInquiry() {
    $inquiry = (new UtilityHelperTest())->createInquiry(self::MERCHANT_ID, self::RIS_ENDPOINT, self::API_KEY);

    $inquiry->setApiKey(self::API_KEY);

    return $inquiry;
  }

  // First test-case #1
  public function testRisQOneItemRequiredFieldsOneRuleReview() {
    $inquiry = $this->getInquiry();
    //RIS response
    $response = $inquiry->getResponse();

    $this->assertEquals('R', $response->getAuto());
    $this->assertEquals('0', $response->getWarningCount());
    $this->assertEquals(1, sizeof($response->getRulesTriggered()));
    $this->assertEquals($inquiry->getParm('SESS'), $response->getSessionId());
    $this->assertEquals($inquiry->getParm('ORDR'), $response->getOrderNumber());
  }

  // Second test-case #2
  public function testRisQMultiCartItemsTwoOptionalFieldsTwoRulesDecline() {
    $inquiry = $this->getInquiry();
    $inquiry->setUserAgent('Mozilla/5.0(Macintosh; Intel Mac OSX 10_9_5)AppleWebKit/537.36(KHTML, like Gecko)Chrome/37.0.2062.124Safari/537.36');
    $inquiry->setTotal(123456789);

    //Building a cartItem with multiple items
    $cart = array(
      new Kount_Ris_Data_CartItem("cart item type 0", "cart item 0", "cart item 0 description", 10, 1000),
      new Kount_Ris_Data_CartItem("cart item type 1", "cart item 1", "cart item 1 description", 11, 1001),
      new Kount_Ris_Data_CartItem("cart item type 2", "cart item 2", "cart item 2 description", 12, 1002)
    );

    $inquiry->setCart($cart);
    //RIS response
    $response = $inquiry->getResponse();

    $this->assertEquals('D', $response->getAuto());
    $this->assertEquals('0', $response->getWarningCount());
    $this->assertEquals(2, sizeof($response->getRulesTriggered()));
  }

  // Third test-case #3
  public function testRisQWithUserDefinedFields() {
    $inquiry = $this->getInquiry();
    $inquiry->setUserDefinedField("ARBITRARY_ALPHANUM_UDF", "alphanumerictrigger value");
    $inquiry->setUserDefinedField("ARBITRARY_NUMERIC_UDF", "777");

    $response = $inquiry->getResponse();

    $aNumTriggered = false;
    $numTriggered = false;

    for($i = 0; $i < sizeof($response->getRulesTriggered()); $i++)
    {
      $rule = $response->getParm("RULE_DESCRIPTION_$i");
      if(strpos($rule, 'ARBITRARY_ALPHANUM_UDF'))
      {
        $aNumTriggered = true;
      } else if(strpos($rule, 'ARBITRARY_NUMERIC_UDF'))
      {
        $numTriggered = true;
      }
    }
    $this->assertTrue($aNumTriggered);
    $this->assertTrue($numTriggered);
  }

  // Fourth test-case #4
  public function testRisQHardErrorExpected() {
    $inquiry = $this->getInquiry();
    $inquiry->setParm("PTOK", Kount_Util_Khash::hashPaymentToken("BADPTOK"));

    $response = $inquiry->getResponse();

    $this->assertEquals('E', $response->getMode());
    $this->assertEquals(332, $response->getErrorCode());
    $this->assertEquals('332 BAD_CARD Cause: [PTOK invalid format], Field: [PTOK], Value: [hidden]', $response->getErrors()[0]);
    $this->assertEquals(1, $response->getErrorCount());
    $this->assertEquals(0, $response->getWarningCount());
  }

  // Fifth test-case #5
  public function testRisQWarningApproved() {
    $inquiry = $this->getInquiry();
    $inquiry->setUserDefinedField('UDF_DOESNOTEXIST', 'Throw a warning please!');

    $inquiry->setTotal(1000);

    $throwAWarning = false;
    $notDefinedForMechant = false;

    $response = $inquiry->getResponse();

    foreach($response->getWarnings() as $warning) {
      if($warning == '399 BAD_OPTN Field: [UDF], Value: [UDF_DOESNOTEXIST=>Throw a warning please!]') {
        $throwAWarning = true;
      } else if($warning == '399 BAD_OPTN Field: [UDF], Value: [The label [UDF_DOESNOTEXIST] is not defined for merchant ID [999666].]') {
        $notDefinedForMechant = true;
      }
    }

    $this->assertEquals('A', $response->getAuto());
    $this->assertEquals('2', $response->getWarningCount());
    $this->assertTrue($throwAWarning);
    $this->assertTrue($notDefinedForMechant);
  }

  // Sixth test-case #6
  public function testRisQHardSoftErrorsExpected() {
    $inquiry = $this->getInquiry();

    $inquiry->setParm("PTOK", "BADPTOK");
    $inquiry->setUserDefinedField('UDF_DOESNOTEXIST', 'Throw a warning please!');

    $throwAWarning = false;
    $notDefinedForMechant = false;

    $response = $inquiry->getResponse();

    foreach($response->getWarnings() as $warning) {
      if($warning == '399 BAD_OPTN Field: [UDF], Value: [UDF_DOESNOTEXIST=>Throw a warning please!]') {
        $throwAWarning = true;
      } else if($warning == '399 BAD_OPTN Field: [UDF], Value: [The label [UDF_DOESNOTEXIST] is not defined for merchant ID [999666].]') {
        $notDefinedForMechant = true;
      }
    }

    $this->assertEquals('E', $response->getMode());
    $this->assertEquals(332, $response->getErrorCode());
    $this->assertEquals(1, $response->getErrorCount());
    $this->assertEquals(2, $response->getWarningCount());
    $this->assertEquals('332 BAD_CARD Cause: [PTOK invalid format], Field: [PTOK], Value: [hidden]', $response->getErrors()[0]);
    $this->assertTrue($throwAWarning);
    $this->assertTrue($notDefinedForMechant);

  }

  //Seventh test-case #7
  public function testRisWTwoKCRulesReview() {
    $inquiry = $this->getInquiry();
    $inquiry->setMode('W');
    $inquiry->setTotal(10001);
    $inquiry->setKcCustomerId('KCentralCustomerOne');

    $billisngToShippingAddress = false;
    $orderTotalReview = false;

    $response = $inquiry->getResponse();

    foreach($response->getKcEvents() as $kcEvent){
      if($kcEvent->getCode() == 'billingToShippingAddressReview' && $kcEvent->getDecision() == 'R') {
        $billisngToShippingAddress = true;
      } else if($kcEvent->getCode() == 'orderTotalReview' && $kcEvent->getDecision() == 'R'){
        $orderTotalReview = true;
      }
    }

    $this->assertEquals(2, $response->getKcEventCount());
    $this->assertEquals(0, $response->getKcWarningCount());
    $this->assertEquals(0, $response->getWarningCount());
    $this->assertEquals('R', $response->getKcDecision());
    $this->assertTrue($billisngToShippingAddress);
    $this->assertTrue($orderTotalReview);
  }

  //Eight test-case #8
  public function testRisJOneKountCentralRuleDecline() {
    $inquiry = $this->getInquiry();

    $inquiry->setMode('J');
    $inquiry->setTotal(1000);
    $inquiry->setKcCustomerId('KCentralCustomerDeclineMe');

    $response = $inquiry->getResponse();

    $this->assertEquals(1, $response->getKcEventCount());
    $this->assertEquals(0, $response->getKcWarningCount());
    $this->assertEquals('D', $response->getKcDecision());
    $this->assertEquals('D', $response->getKcEvents()[0]->getDecision());
    $this->assertEquals('orderTotalDecline', $response->getKcEvents()[0]->getCode());
  }

  //Ninth test-case #9
  public function testModeUAfterModeQ() {
    $inquiry = $this->getInquiry();

    $response = $inquiry->getResponse();

    $transaction = $response->getTransactionId();
    $session = $response->getSessionId();
    $order = $response->getOrderNumber();

    $update = new Kount_Ris_Request_Update();
    $update->setMode('U');
    $update->setSessionId($session);
    $update->setVersion('0695');
    $update->setTransactionId($transaction);
    $update->setOrderNumber($order);
    $update->setParm('PTOK', Kount_Util_Khash::hashPaymentToken('5386460135176807'));
    $update->setMerchantId(self::MERCHANT_ID);
    $update->setUrl(self::RIS_ENDPOINT);
    $update->setPaymentTokenLast4('6807');
    $update->setApiKey(self::API_KEY);
    $update->setMack('Y');
    $update->setAuth('A');
    $update->setAvsz('M');
    $update->setAvst('M');
    $update->setCvvr('M');

    $updateResponse = $update->getResponse();

    $this->assertEquals('U', $updateResponse->getMode());
    $this->assertEquals($transaction, $updateResponse->getTransactionId());
    $this->assertEquals($session, $updateResponse->getSessionId());
    $this->assertNull($updateResponse->getAuto());
    $this->assertNull($updateResponse->getScore());
    $this->assertNull($updateResponse->getGeox());
  }

  //Tenth test-case #10
  public function testModeXAfterModeQ() {
    $inquiry = $this->getInquiry();

    $response = $inquiry->getResponse();

    $transaction = $response->getTransactionId();
    $session = $response->getSessionId();
    $order = $response->getOrderNumber();

    $update = new Kount_Ris_Request_Update();
    $update->setMode('X');
    $update->setSessionId($session);
    $update->setVersion('0695');
    $update->setTransactionId($transaction);
    $update->setOrderNumber($order);
    $update->setMerchantId(self::MERCHANT_ID);
    $update->setUrl(self::RIS_ENDPOINT);
    $update->setApiKey(self::API_KEY);
    $update->setParm('PTOK', Kount_Util_Khash::hashPaymentToken('5386460135176807'));
    $update->setPaymentTokenLast4('6807');
    $update->setMack('Y');
    $update->setAuth('A');
    $update->setAvsz('M');
    $update->setAvst('M');
    $update->setCvvr('M');

    $updateResponse = $update->getResponse();

    $this->assertEquals('X', $updateResponse->getMode());
    $this->assertEquals($transaction, $updateResponse->getTransactionId());
    $this->assertEquals($session, $updateResponse->getSessionId());
    $this->assertEquals($order, $updateResponse->getOrderNumber());

    $this->assertNotNull($updateResponse->getAuto());
    $this->assertNotNull($updateResponse->getGeox());
    $this->assertNotNull($updateResponse->getScore());
  }

  //Eleventh test-case #11
  public function testModeP () {
    $inquiry = $this->getInquiry();
    $inquiry->setAnid('2085551212');
    $inquiry->setMode('P');
    $inquiry->setTotal(1000);

    $response = $inquiry->getResponse();
    $this->assertEquals('P', $response->getMode());
    $this->assertEquals('A', $response->getAuto());
  }
}