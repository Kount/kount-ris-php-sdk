<?php

class MaskedTokenTest extends PHPUnit_Framework_TestCase {

  public function testCorrectMasking() {
    $inquiry = new Kount_Ris_Request_Inquiry();
    $inquiry->setPaymentMasked('0007380568572514');

    $this->assertEquals('MASK', $inquiry->getParm('PENC'));
    $this->assertEquals('2514', $inquiry->getParm('LAST4'));
    $this->assertEquals('000738XXXXXX2514', $inquiry->getParm('PTOK'));
  }
}
