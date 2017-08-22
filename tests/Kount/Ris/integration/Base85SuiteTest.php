<?php

class Base85SuiteTest extends PHPUnit_Framework_TestCase
{
  public function testEncode() {
    $input = "This is sample text for testing purposes.";
    $base85 = "<+oue+DGm>F(&p)Ch4`2AU&;>AoD]4FCfN8Bl7Q+E-62?Df]K2/c";

    $encoded = base85::encode($input);

    $this->assertEquals($encoded, $base85);
  }

  public function testDecode() {
    $encoded = "<+oue+DGm>F(&p)Ch4`2AU&;>AoD]4FCfN8Bl7Q+E-62?Df]K2/c";
    $expected = "This is sample text for testing purposes.";

    $decoded = base85::decode($encoded);

    $this->assertEquals($decoded, $expected);
  }
}