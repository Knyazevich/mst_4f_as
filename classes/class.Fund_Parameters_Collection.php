<?php

namespace Maximumstart\Alert_System;

require plugin_dir_path(__FILE__) . 'class.Fund_Parameter.php';

class Fund_Parameters_Collection {
  public static function get_income_funds_rules() {
    return [
      'overview.nav.value' => new Fund_Parameter('NAV', 'float', 'any', 2),
      'overview.performance_ytd.value' => new Fund_Parameter('YTD Performance', 'float', 'any', 1),
      'overview.fund_size.value' => new Fund_Parameter('Fund AUM', 'float'),
      'overview.inception_date.value' => new Fund_Parameter('Share Class Inception Date', 'date'),
      'overview.morningstar_rating.value' => new Fund_Parameter('Overall Morningstar Rating', 'int'),
      'overview.morningstar_category.value' => new Fund_Parameter('Morningstar Category', 'string'),

      'fund_fees_expenses.redemption_charges.value' => new Fund_Parameter('Redemption Charge', 'float'),
      'fund_fees_expenses.charges_ter.value' => new Fund_Parameter('Ongoing Charges/TER', 'float'),
      'fund_fees_expenses.performance_fees.value' => new Fund_Parameter('Performance Fee', 'string'),

      'performance.cumulative.fund_last_year.value' => new Fund_Parameter('Performance Cumulative Fund (1 yr)', 'float', 'any', 1),
      'performance.cumulative.fund_last_3year.value' => new Fund_Parameter('Performance Cumulative Fund (3 yr)', 'float', 'any', 1),
      'performance.cumulative.fund_last_5year.value' => new Fund_Parameter('Performance Cumulative Fund (5 yr)', 'float', 'any', 1),
      'performance.cumulative.fund_last_10year.value' => new Fund_Parameter('Performance Cumulative Fund (10 yr)', 'float', 'any', 1),

      'performance.cumulative.index_last_year.value' => new Fund_Parameter('Performance Cumulative Benchmark (1 yr)', 'float', 'any', 1),
      'performance.cumulative.index_last_3year.value' => new Fund_Parameter('Performance Cumulative Benchmark (3 yr)', 'float', 'any', 1),
      'performance.cumulative.index_last_5year.value' => new Fund_Parameter('Performance Cumulative Benchmark (5 yr)', 'float', 'any', 1),
      'performance.cumulative.index_last_10year.value' => new Fund_Parameter('Performance Cumulative Benchmark (10 yr)', 'float', 'any', 1),

      'performance.annualised.fund_last_year.value' => new Fund_Parameter('Performance Annualized Fund (1 yr)', 'float', 'any', 1),
      'performance.annualised.fund_last_3year.value' => new Fund_Parameter('Performance Annualized Fund (3 yr)', 'float', 'any', 1),
      'performance.annualised.fund_last_5year.value' => new Fund_Parameter('Performance Annualized Fund (5 yr)', 'float', 'any', 1),
      'performance.annualised.fund_last_10year.value' => new Fund_Parameter('Performance Annualized Fund (10 yr)', 'float', 'any', 1),

      'performance.annualised.index_last_year.value' => new Fund_Parameter('Performance Annualized Benchmark (1 yr)', 'float', 'any', 1),
      'performance.annualised.index_last_3year.value' => new Fund_Parameter('Performance Annualized Benchmark (3 yr)', 'float', 'any', 1),
      'performance.annualised.index_last_5year.value' => new Fund_Parameter('Performance Annualized Benchmark (5 yr)', 'float', 'any', 1),
      'performance.annualised.index_last_10year.value' => new Fund_Parameter('Performance Annualized Benchmark (10 yr)', 'float', 'any', 1),

      'portfolio.total' => new Fund_Parameter('Portfolio Total', 'float', 'any', 1),

      'performance.calendar_year' => new Fund_Parameter('Calendar year returns', 'year_returns_array', 'any'),
    ];
  }
}