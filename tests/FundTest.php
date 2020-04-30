<?php

use Maximumstart\Alert_System\Fund;
use PHPUnit\Framework\TestCase;

require dirname(__DIR__, 1) . '/classes/class.Fund.php';

class FundTest extends TestCase {
  public function test_get_fund_type() {
    $this->assertSame('equity', Fund::get_fund_type('US Equity Large Cap Growth'));
    $this->assertSame('income', Fund::get_fund_type('US Fixed Income'));
    $this->assertSame('', Fund::get_fund_type(''));
    $this->assertSame('', Fund::get_fund_type('1337!'));
  }
}
