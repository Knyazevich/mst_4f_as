<?php

use Maximumstart\Alert_System\Fund;
use PHPUnit\Framework\TestCase;

require dirname(__DIR__, 1) . '/classes/class.Fund.php';

class FundTest extends TestCase {
  public function test_get_fund_type() {
    $equity_example = 'US Equity Large Cap Growth';
    $income_example = 'US Fixed Income';

    $this->assertSame('equity', Fund::get_fund_type($equity_example));
    $this->assertSame('income', Fund::get_fund_type($income_example));
  }
}
