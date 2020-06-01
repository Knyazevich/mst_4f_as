<?php

namespace Maximumstart\Alert_System;

class Fund_Parameters_Collection {
  public function get_rules(string $fund_type): array {
    $sets = [
      'income' => [ $this, 'get_income_funds_rules' ],
      'equity' => [ $this, 'get_equity_funds_rules' ],
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

      'performance.calendar_year.2009.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2009)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2010.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2010)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2011.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2011)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2012.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2012)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2013.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2013)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2014.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2014)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2015.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2015)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2016.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2016)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2017.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2017)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2018.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2018)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2019.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2019)',
        'numeric',
        'any'
      ),

      'performance.calendar_year.2009.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2009)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2010.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2010)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2011.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2011)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2012.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2012)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2013.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2013)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2014.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2014)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2015.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2015)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2016.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2016)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2017.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2017)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2018.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2018)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2019.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2019)',
        'numeric',
        'any'
      ),

      'risk_measures.alpha.1YR' => new Fund_Parameter(
        'Risk Measures (Alpha 1YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.3YR' => new Fund_Parameter(
        'Risk Measures (Alpha 3YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.5YR' => new Fund_Parameter(
        'Risk Measures (Alpha 5YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.7YR' => new Fund_Parameter(
        'Risk Measures (Alpha 7YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.10YR' => new Fund_Parameter(
        'Risk Measures (Alpha 10YR)',
        'numeric',
        'any',
        1
      ),

      'risk_measures.beta.1YR' => new Fund_Parameter(
        'Risk Measures (Beta 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.3YR' => new Fund_Parameter(
        'Risk Measures (Beta 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.5YR' => new Fund_Parameter(
        'Risk Measures (Beta 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.7YR' => new Fund_Parameter(
        'Risk Measures (Beta 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.10YR' => new Fund_Parameter(
        'Risk Measures (Beta 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.r-squared.1YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.3YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.5YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.7YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.10YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.sharpe_ratio.1YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.3YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.5YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.7YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.10YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.fund_standard_deviation.1YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.3YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.5YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.7YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.10YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.index_standard_deviation.1YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.3YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.5YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.7YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.10YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.tracking_error.1YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.3YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.5YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.7YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.10YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 10YR)',
        'numeric',
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


      'performance.calendar_year.2009.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2009)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2010.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2010)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2011.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2011)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2012.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2012)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2013.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2013)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2014.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2014)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2015.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2015)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2016.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2016)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2017.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2017)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2018.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2018)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2019.value' => new Fund_Parameter(
        'Calendar year returns (Fund 2019)',
        'numeric',
        'any'
      ),

      'performance.calendar_year.2009.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2009)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2010.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2010)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2011.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2011)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2012.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2012)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2013.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2013)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2014.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2014)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2015.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2015)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2016.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2016)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2017.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2017)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2018.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2018)',
        'numeric',
        'any'
      ),
      'performance.calendar_year.2019.benchmark_value' => new Fund_Parameter(
        'Calendar year returns (Benchmark 2019)',
        'numeric',
        'any'
      ),

      'risk_measures.alpha.1YR' => new Fund_Parameter(
        'Risk Measures (Alpha 1YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.3YR' => new Fund_Parameter(
        'Risk Measures (Alpha 3YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.5YR' => new Fund_Parameter(
        'Risk Measures (Alpha 5YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.7YR' => new Fund_Parameter(
        'Risk Measures (Alpha 7YR)',
        'numeric',
        'any',
        1
      ),
      'risk_measures.alpha.10YR' => new Fund_Parameter(
        'Risk Measures (Alpha 10YR)',
        'numeric',
        'any',
        1
      ),

      'risk_measures.beta.1YR' => new Fund_Parameter(
        'Risk Measures (Beta 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.3YR' => new Fund_Parameter(
        'Risk Measures (Beta 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.5YR' => new Fund_Parameter(
        'Risk Measures (Beta 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.7YR' => new Fund_Parameter(
        'Risk Measures (Beta 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.beta.10YR' => new Fund_Parameter(
        'Risk Measures (Beta 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.r-squared.1YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.3YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.5YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.7YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.r-squared.10YR' => new Fund_Parameter(
        'Risk Measures (R-Squared 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.sharpe_ratio.1YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.3YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.5YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.7YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.sharpe_ratio.10YR' => new Fund_Parameter(
        'Risk Measures (Sharpe Ratio 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.fund_standard_deviation.1YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.3YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.5YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.7YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.fund_standard_deviation.10YR' => new Fund_Parameter(
        'Risk Measures (Fund Standard Deviation 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.index_standard_deviation.1YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.3YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.5YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.7YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.index_standard_deviation.10YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 10YR)',
        'numeric',
        'any',
        0.5
      ),

      'risk_measures.tracking_error.1YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 1YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.3YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 3YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.5YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 5YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.7YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 7YR)',
        'numeric',
        'any',
        0.5
      ),
      'risk_measures.tracking_error.10YR' => new Fund_Parameter(
        'Risk Measures (Index Standard Deviation 10YR)',
        'numeric',
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
