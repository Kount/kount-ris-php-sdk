<?php

class MaskEncodingTest extends \PHPUnit\Framework\TestCase
{

  private function getInquiry($cardNumber)
  {
    $inquiry = (new UtilityHelperTest())->createInquiry();
    $inquiry->setPaymentMasked($cardNumber);
    return $inquiry;
  }

  public function testRisQUsingPaymentEncodingMaskValid()
  {
    $inquiry = $this->getInquiry('370070538959797');
    $response = $inquiry->getResponse();

    $this->assertEquals('AMEX', $response->getBrand());
  }

  public function testRisQUsingPaymentEncodingMaskError()
  {
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
