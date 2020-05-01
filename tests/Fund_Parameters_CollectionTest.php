<?php

use Maximumstart\Alert_System\Fund_Parameters_Collection;
use PHPUnit\Framework\TestCase;

class Fund_Parameters_CollectionTest extends TestCase {
  public function test_get_rules() {
    $collection = new Fund_Parameters_Collection();

    $this->assertNotEmpty($collection->get_rules('equity'));
    $this->assertSame([], $collection->get_rules('totally_wrong'));
  }
}
