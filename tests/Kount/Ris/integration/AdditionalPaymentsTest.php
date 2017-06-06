<?php

class AdditionalPaymentsTest extends PHPUnit_Framework_TestCase
{
  const MERCHANT_ID  = 999666;
  const RIS_ENDPOINT = "https://risk.beta.kount.net";
  const API_KEY = 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiI5OTk2NjYiLCJhdWQiOiJLb3VudC4xIiwiaWF0IjoxNDk0NTM0Nzk5LCJzY3AiOnsia2EiOm51bGwsImtjIjpudWxsLCJhcGkiOmZhbHNlLCJyaXMiOnRydWV9fQ.eMmumYFpIF-d1up_mfxA5_VXBI41NSrNVe9CyhBUGck';

  private function getInquiry() {
    $inquiry = (new UtilityHelperTest())->createInquiryForPayments(self::MERCHANT_ID, self::RIS_ENDPOINT, self::API_KEY);

    return $inquiry;
  }

  public function testTokenPayment1() {
    $inquiry = $this->getInquiry();
    $inquiry->setTokenPayment('6011476613608633');

    $this->assertEquals($inquiry->getParm('PTOK'), '601147IF86FKXJTM5K8Z');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::TOKEN_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }

  public function testTokenPayment2 () {
    $inquiry = $this->getInquiry();
    $inquiry->setTokenPayment('1A2B3C6613608633');

    $this->assertEquals($inquiry->getParm('PTOK'), '1A2B3C6SYWXNDI5GN77V');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::TOKEN_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }

  public function testCarteBleuePayment() {
    $inquiry = $this->getInquiry();
    $inquiry->setCarteBleuePayment('AABBCC661360DDD');

    $this->assertEquals($inquiry->getParm('PTOK'), 'AABBCCG297U47WC6J0BC');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::CARTE_BLEUE_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }

  public function testSkrillPayment() {
    $inquiry = $this->getInquiry();
    $inquiry->setSkrillPayment('XYZ123661360SKMB');

    $this->assertEquals($inquiry->getParm('PTOK'), 'XYZ1230L2VYV3P815Q2I');
    $this->assertEquals($inquiry->getParm('PTYP'), $inquiry::SKRILL_TYPE);
    $this->assertEquals($inquiry->getParm('PENC'), 'KHASH');
  }
}