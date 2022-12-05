<?php
# use \PHPUnit\Framework\TestCase;
class Base85SuiteTest extends \PHPUnit\Framework\TestCase
{

  const PLAIN_TEXT = "This is sample text for testing purposes.";
  const ENCODED_TEXT = "<+oue+DGm>F(&p)Ch4`2AU&;>AoD]4FCfN8Bl7Q+E-62?Df]K2/c";

  public function testEncode()
  {

    $encoded = base85::encode(self::PLAIN_TEXT);
    $this->assertEquals($encoded, self::ENCODED_TEXT);
  }

  public function testDecode()
  {

    $decoded = base85::decode(self::ENCODED_TEXT);
    $this->assertEquals($decoded, self::PLAIN_TEXT);
  }
}
