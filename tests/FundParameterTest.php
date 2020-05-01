<?php

use Maximumstart\Alert_System\Fund_Parameter;
use PHPUnit\Framework\TestCase;

class FundParameterTest extends TestCase {
  public function test_parameter_values_returning() {
    $first_parameter = new Fund_Parameter('First Parameter', 'numeric');
    $second_parameter = new Fund_Parameter(
      'Second Parameter',
      'numeric',
      'inc',
      10
    );

    $this->assertSame('First Parameter', $first_parameter->get_property('title'));
    $this->assertSame('numeric', $first_parameter->get_property('handler'));
    $this->assertSame('any', $first_parameter->get_property('diff_type'));
    $this->assertSame(0, $first_parameter->get_property('change_percentage'));

    $this->assertSame('Second Parameter', $second_parameter->get_property('title'));
    $this->assertSame('numeric', $second_parameter->get_property('handler'));
    $this->assertSame('inc', $second_parameter->get_property('diff_type'));
    $this->assertSame(10, $second_parameter->get_property('change_percentage'));
  }

  public function test_numeric_return_type() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric');

    $this->assertIsArray($parameter->compare(2, 1));
    $this->assertIsArray($parameter->compare(1, 2));
    $this->assertIsArray($parameter->compare(1, 1));
  }

  public function test_numeric_equality_comparison() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric');

    $bigger_value = $parameter->compare(2, 1);
    $lower_value = $parameter->compare(1, 2);
    $same_value = $parameter->compare(1, 1);

    $this->assertFalse($bigger_value['is_equal']);
    $this->assertFalse($lower_value['is_equal']);
    $this->assertTrue($same_value['is_equal']);
  }

  public function test_numeric_difference_comparison() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric');

    $bigger_value = $parameter->compare(2, 1);
    $lower_value = $parameter->compare(1, 2);
    $same_value = $parameter->compare(1, 1);

    $this->assertSame(100.0, $bigger_value['diff_value']);
    $this->assertSame(-50.0, $lower_value['diff_value']);
    $this->assertSame(0.0, $same_value['diff_value']);
  }

  public function test_numeric_is_alert_without_diff_type() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric');

    $bigger_value = $parameter->compare(2, 1);
    $lower_value = $parameter->compare(1, 2);
    $same_value = $parameter->compare(1, 1);

    $this->assertTrue($bigger_value['is_alert']);
    $this->assertTrue($lower_value['is_alert']);
    $this->assertFalse($same_value['is_alert']);
  }

  public function test_numeric_is_alert_with_inc_diff_type() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric', 'inc');

    $bigger_value = $parameter->compare(2, 1);
    $lower_value = $parameter->compare(1, 2);
    $same_value = $parameter->compare(1, 1);

    $this->assertTrue($bigger_value['is_alert'], '2 bigger than 1');
    $this->assertFalse($lower_value['is_alert'], '1 lower than 2');
    $this->assertFalse($same_value['is_alert'], '1 equal 1');
  }

  public function test_numeric_is_alert_with_dec_diff_type() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric', 'dec');

    $bigger_value = $parameter->compare(2, 1);
    $lower_value = $parameter->compare(1, 2);
    $same_value = $parameter->compare(1, 1);

    $this->assertFalse($bigger_value['is_alert'], '2 bigger than 1');
    $this->assertTrue($lower_value['is_alert'], '1 lower than 2');
    $this->assertFalse($same_value['is_alert'], '1 equal 1');
  }

  public function test_numeric_is_alert_with_any_diff_type() {
    $parameter = new Fund_Parameter('Numeric Parameter', 'numeric', 'any');

    $bigger_value = $parameter->compare(2, 1);
    $lower_value = $parameter->compare(1, 2);
    $same_value = $parameter->compare(1, 1);

    $this->assertTrue($bigger_value['is_alert']);
    $this->assertTrue($lower_value['is_alert']);
    $this->assertFalse($same_value['is_alert']);
  }

  public function test_strings_equality_comparison() {
    $parameter = new Fund_Parameter('String Parameter', 'string');

    $not_equal = $parameter->compare('First', 'Second');
    $equal = $parameter->compare('First', 'First');

    $this->assertFalse($not_equal['is_equal']);
    $this->assertTrue($equal['is_equal']);
  }

  public function test_dates_equality_comparison() {
    $parameter = new Fund_Parameter('Date Parameter', 'date');

    $not_equal = $parameter->compare('01/02/2019', '02/02/2020');
    $equal = $parameter->compare('01/01/1970', '01/01/1970');

    $this->assertFalse($not_equal['is_equal'], 'Dates must not be equal');
    $this->assertTrue($equal['is_equal'], 'Dates must be equal');
  }

  public function test_arrays_equality_comparison() {
    $parameter = new Fund_Parameter('Array Parameter', 'array');

    $not_equal = $parameter->compare([ 'a' => 1 ], [ 'a' => 2, 'b' => 3 ]);
    $equal = $parameter->compare([ 'a' => 1 ], [ 'a' => 1 ]);

    $this->assertFalse($not_equal['is_equal'], 'Arrays must not be equal');
    $this->assertTrue($equal['is_equal'], 'Arrays must be equal');
  }
}
