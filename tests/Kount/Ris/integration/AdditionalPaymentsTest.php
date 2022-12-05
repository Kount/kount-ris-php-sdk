<?php

class AdditionalPaymentsTest extends \PHPUnit\Framework\TestCase
{
  private function getInquiry()
  {
    $inquiry = (new UtilityHelperTest())->createInquiry();

    return $inquiry;
  }

  public function testTokenPayment1()
  {
    $inquiry = $this->getInquiry();
    $inquiry->setTokenPayment('6011476613608633');

    $this->assertEquals($inquiry->getParm('PTOK'), '601147IF86FKXJTM5K8Z');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::TOKEN_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }

  public function testTokenPayment2()
  {
    $inquiry = $this->getInquiry();
    $inquiry->setTokenPayment('1A2B3C6613608633');

    $this->assertEquals($inquiry->getParm('PTOK'), '1A2B3C6SYWXNDI5GN77V');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::TOKEN_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }

  public function testCarteBleuePayment()
  {
    $inquiry = $this->getInquiry();
    $inquiry->setCarteBleuePayment('AABBCC661360DDD');

    $this->assertEquals($inquiry->getParm('PTOK'), 'AABBCCG297U47WC6J0BC');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::CARTE_BLEUE_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }

  public function testSkrillPayment()
  {
    $inquiry = $this->getInquiry();
    $inquiry->setSkrillPayment('XYZ123661360SKMB');

    $this->assertEquals($inquiry->getParm('PTOK'), 'XYZ1230L2VYV3P815Q2I');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::SKRILL_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }
}
