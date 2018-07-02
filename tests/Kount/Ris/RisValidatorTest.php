<?php

class RisValidatorTest extends PHPUnit_Framework_TestCase
{
	const MERCHANT_ID = 900420;

	private function getInquiry() {
		$inquiry = (new UtilityHelperTest())->createInquiryForValidatorTest(self::MERCHANT_ID);

		return $inquiry;
	}

	public function testPassingIpv6() {
		$inquiry = $this->getInquiry();
		$inquiry->setIpAddress("2001:0:3238:DFE1:63::FEFB");
		$params = $inquiry->getParams();
		$errors = Kount_Ris_Validate::validate($params);

		$this->assertEquals(0, count($errors));
	}

	public function testFailingIpv6() {
		$inquiry = $this->getInquiry();
		$inquiry->setIpAddress("2001:0:3238:mech:63::FEFB");
		$params = $inquiry->getParams();
		$errors = Kount_Ris_Validate::validate($params);

		$this->assertEquals(1, count($errors));
	}

	public function testPassingIpv4Local() {
		$inquiry = $this->getInquiry();
		$inquiry->setIpAddress("192.168.100.200");
		$params = $inquiry->getParams();
		$errors = Kount_Ris_Validate::validate($params);

		$this->assertEquals(0, count($errors));
	}

 	public function testFailingIpv4Local() {
		$inquiry = $this->getInquiry();
		$inquiry->setIpAddress("192.1.100.2048");
	  $params = $inquiry->getParams();
	  $errors = Kount_Ris_Validate::validate($params);

	  $this->assertEquals(1, count($errors));
	}

	public function testPassingIpv4() {
		$inquiry = $this->getInquiry();
		$inquiry->setIpAddress("8.8.8.8");
		$params = $inquiry->getParams();
		$errors = Kount_Ris_Validate::validate($params);

		$this->assertEquals(0, count($errors));
	}

	public function testFailingIpv4() {
		$inquiry = $this->getInquiry();
		$inquiry->setIpAddress("8.8.8");
		$params = $inquiry->getParams();
		$errors = Kount_Ris_Validate::validate($params);

		$this->assertEquals(1, count($errors));
	}
}