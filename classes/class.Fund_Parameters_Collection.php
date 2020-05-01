<?php

namespace Maximumstart\Alert_System;

class Fund_Parameters_Collection {
  public function get_rules(string $fund_type): array {
    $sets = [
      'income' => [$this, 'get_income_funds_rules'],
      'equity' => [$this, 'get_equity_funds_rules'],
    ];

    if (isset($sets[$fund_type])) {
      return $sets[$fund_type]();
    }

    return [];
  }

  private function get_income_funds_rules(): array {
    return [
      'overview.nav.value' => new Fund_Parameter(
        'NAV',
        'numeric',
        'any',
        2
      ),
      'overview.performance_ytd.value' => new Fund_Parameter(
        'YTD Performance',
        'numeric',
        'any',
        1
      ),
      'overview.fund_size.value' => new Fund_Parameter(
        'Fund AUM',
        'numeric',
        'any',
        '2'
      ),
      'overview.inception_date.value' => new Fund_Parameter(
        'Share Class Inception Date',
        'date'
      ),
      'overview.morningstar_rating.value' => new Fund_Parameter(
        'Overall Morningstar Rating',
        'numeric'
      ),
      'overview.morningstar_category.value' => new Fund_Parameter(
        'Morningstar Category',
        'string'
      ),

      'fund_fees_expenses.redemption_charges.value' => new Fund_Parameter(
        'Redemption Charge',
        'numeric'
      ),
      'fund_fees_expenses.charges_ter.value' => new Fund_Parameter(
        'Ongoing Charges/TER',
        'numeric'
      ),
      'fund_fees_expenses.performance_fees.value' => new Fund_Parameter(
        'Performance Fee',
        'string'
      ),

      'performance.cumulative.fund_last_year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (1 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.cumulative.fund_last_3year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (3 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.cumulative.fund_last_5year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (5 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.cumulative.fund_last_10year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (10 yr)',
        'numeric',
        'any',
        1
      ),

      'performance.cumulative.index_last_year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (1 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.cumulative.index_last_3year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (3 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.cumulative.index_last_5year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (5 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.cumulative.index_last_10year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (10 yr)',
        'numeric',
        'any',
        1
      ),

      'performance.annualised.fund_last_year.value' => new Fund_Parameter(
        'Performance Annualized Fund (1 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.annualised.fund_last_3year.value' => new Fund_Parameter(
        'Performance Annualized Fund (3 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.annualised.fund_last_5year.value' => new Fund_Parameter(
        'Performance Annualized Fund (5 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.annualised.fund_last_10year.value' => new Fund_Parameter(
        'Performance Annualized Fund (10 yr)',
        'numeric',
        'any',
        1
      ),

      'performance.annualised.index_last_year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (1 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.annualised.index_last_3year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (3 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.annualised.index_last_5year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (5 yr)',
        'numeric',
        'any',
        1
      ),
      'performance.annualised.index_last_10year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (10 yr)',
        'numeric',
        'any',
        1
      ),

      'performance.calendar_year' => new Fund_Parameter(
        'Calendar year returns',
        'array',
        'any'
      ),

      'risk_measures' => new Fund_Parameter(
        'Risk Measures',
        'object',
        'any',
        0.5
      ),

      'morningstar_ratings.overall.rating.value' => new Fund_Parameter(
        'Morningstar Rating (overall)',
        'numeric',
        'any'
      ),
      'morningstar_ratings.3YR.rating.value' => new Fund_Parameter(
        'Morningstar Rating (3YR)',
        'numeric',
        'any'
      ),
      'morningstar_ratings.5YR.rating.value' => new Fund_Parameter(
        'Morningstar Rating (5YR)',
        'numeric',
        'any'
      ),
      'morningstar_ratings.10YR.rating.value' => new Fund_Parameter(
        'Morningstar Rating (10YR)',
        'numeric',
        'any'
      ),

      'portfolio.total' => new Fund_Parameter(
        'Portfolio Total',
        'numeric',
        'any',
        1
      ),

      'fund_managers' => new Fund_Parameter(
        'Management team',
        'array',
        'any'
      ),
    ];
  }

  private function get_equity_funds_rules(): array {
    return [
      'overview.nav.value' => new Fund_Parameter(
        'NAV',
        'numeric',
        'any',
        2
      ),
      'overview.performance_ytd.value' => new Fund_Parameter(
        'YTD Performance',
        'numeric',
        'any',
        2
      ),
      'overview.fund_size.value' => new Fund_Parameter(
        'Fund AUM',
        'numeric',
        'any',
        2
      ),
      'overview.inception_date.value' => new Fund_Parameter(
        'Share Class Inception Date',
        'date'
      ),
      'overview.morningstar_rating.value' => new Fund_Parameter(
        'Overall Morningstar Rating',
        'numeric'
      ),
      'overview.morningstar_category.value' => new Fund_Parameter(
        'Morningstar Category',
        'string'
      ),

      'fund_fees_expenses.redemption_charges.value' => new Fund_Parameter(
        'Redemption Charge',
        'numeric'
      ),
      'fund_fees_expenses.charges_ter.value' => new Fund_Parameter(
        'Ongoing Charges/TER',
        'numeric'
      ),
      'fund_fees_expenses.performance_fees.value' => new Fund_Parameter(
        'Performance Fee',
        'string'
      ),

      'performance.cumulative.fund_last_year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (1 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.cumulative.fund_last_3year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (3 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.cumulative.fund_last_5year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (5 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.cumulative.fund_last_10year.value' => new Fund_Parameter(
        'Performance Cumulative Fund (10 yr)',
        'numeric',
        'any',
        2
      ),

      'performance.cumulative.index_last_year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (1 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.cumulative.index_last_3year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (3 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.cumulative.index_last_5year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (5 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.cumulative.index_last_10year.value' => new Fund_Parameter(
        'Performance Cumulative Benchmark (10 yr)',
        'numeric',
        'any',
        2
      ),

      'performance.annualised.fund_last_year.value' => new Fund_Parameter(
        'Performance Annualized Fund (1 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.annualised.fund_last_3year.value' => new Fund_Parameter(
        'Performance Annualized Fund (3 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.annualised.fund_last_5year.value' => new Fund_Parameter(
        'Performance Annualized Fund (5 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.annualised.fund_last_10year.value' => new Fund_Parameter(
        'Performance Annualized Fund (10 yr)',
        'numeric',
        'any',
        2
      ),

      'performance.annualised.index_last_year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (1 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.annualised.index_last_3year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (3 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.annualised.index_last_5year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (5 yr)',
        'numeric',
        'any',
        2
      ),
      'performance.annualised.index_last_10year.value' => new Fund_Parameter(
        'Performance Annualized Benchmark (10 yr)',
        'numeric',
        'any',
        2
      ),

      'performance.calendar_year' => new Fund_Parameter(
        'Calendar year returns',
        'array',
        'any'
      ),

      'risk_measures' => new Fund_Parameter(
        'Risk Measures',
        'object',
        'any',
        0.5
      ),

      'morningstar_ratings.overall.rating.value' => new Fund_Parameter(
        'Morningstar Rating (overall)',
        'numeric',
        'any'
      ),
      'morningstar_ratings.3YR.rating.value' => new Fund_Parameter(
        'Morningstar Rating (3YR)',
        'numeric',
        'any'
      ),
      'morningstar_ratings.5YR.rating.value' => new Fund_Parameter(
        'Morningstar Rating (5YR)',
        'numeric',
        'any'
      ),
      'morningstar_ratings.10YR.rating.value' => new Fund_Parameter(
        'Morningstar Rating (10YR)',
        'numeric',
        'any'
      ),

      'portfolio.total' => new Fund_Parameter(
        'Portfolio Total',
        'numeric',
        'any',
        2
      ),

      'fund_managers' => new Fund_Parameter(
        'Management team',
        'array',
        'any'
      ),
    ];
  }
}
