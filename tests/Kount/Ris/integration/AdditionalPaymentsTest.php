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

        $this->assertEquals('601147IF86FKXJTM5K8Z', $inquiry->getParm('PTOK'));
        $this->assertEquals($inquiry::TOKEN_TYPE, $inquiry->getParm('PTYP'));
        $this->assertEquals('KHASH', $inquiry->getParm('PENC'));
    }

    public function testTokenPayment2()
    {
        $inquiry = $this->getInquiry();
        $inquiry->setTokenPayment('1A2B3C6613608633');

        $this->assertEquals('1A2B3C6SYWXNDI5GN77V', $inquiry->getParm('PTOK'));
        $this->assertEquals($inquiry::TOKEN_TYPE, $inquiry->getParm('PTYP'));
        $this->assertEquals('KHASH', $inquiry->getParm('PENC'));
    }

    public function testCarteBleuePayment()
    {
        $inquiry = $this->getInquiry();
        $inquiry->setCarteBleuePayment('AABBCC661360DDD');

        $this->assertEquals('AABBCCG297U47WC6J0BC', $inquiry->getParm('PTOK'));
        $this->assertEquals($inquiry::CARTE_BLEUE_TYPE, $inquiry->getParm('PTYP'));
        $this->assertEquals('KHASH', $inquiry->getParm('PENC'));
    }

    public function testSkrillPayment()
    {
        $inquiry = $this->getInquiry();
        $inquiry->setSkrillPayment('XYZ123661360SKMB');

        $this->assertEquals('XYZ1230L2VYV3P815Q2I', $inquiry->getParm('PTOK'));
        $this->assertEquals($inquiry::SKRILL_TYPE, $inquiry->getParm('PTYP'));
        $this->assertEquals('KHASH', $inquiry->getParm('PENC'));
    }
}
