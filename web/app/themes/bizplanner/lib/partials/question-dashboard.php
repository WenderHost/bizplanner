<?php
global $current_business_plan;
$quantity = $current_business_plan['quantity'];
$sales_price = $current_business_plan['product_price'];
$revenue = $sales_price * $quantity;

$cost_per_unit = $current_business_plan['production_costs'];
$material_costs = $cost_per_unit * $quantity;
$facility_expenses = $current_business_plan['company_facility_cost'];
$production_costs = ( $material_costs + $facility_expenses );
$operating_expenses = ( $current_business_plan['management_team_cost'] + $current_business_plan['marketing_methods_cost'] );
$startup_funding = $current_business_plan['startup_funding_source_cost'];
$net_profit = ( $revenue ) - ( $production_costs + $operating_expenses );
?>
<div class="col-fluid">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <table class="table" style="margin-top: 1em;">
            <tbody>
              <tr>
                <th style="width: 55%;">Income/Revenue Goal <span style="font-size: .8em; font-weight: normal;">(<?= number_format( $quantity ) ?> sold x $<?= $sales_price ?>/<em><?= $current_business_plan['product'] ?></em>)</span></th>
                <td class="total-cell pad-right" style="width: 45%;">$<?= number_format( $revenue ) ?></td>
              </tr>
              <tr>
                <th>Production Costs</th>
                <td class="total-cell">$<?= number_format( $production_costs ) ?> &boxdl;</td>
              </tr>
              <tr>
                <td>&bull; Product Costs ($<?= $cost_per_unit  ?> <span style="font-size: .8em;">per</span> <em style="font-size: .8em;"><?= $current_business_plan['product'] ?></em> x <?= number_format( $quantity ) ?>)</td>
                <td style="text-align: right;">$<?= number_format( $material_costs ) ?></td>
              </tr>
              <tr>
                <td>&bull; Facility Expenses</td>
                <td style="text-align: right;">$<?= number_format( $facility_expenses ) ?></td>
              </tr>
              <tr>
                <th>Operating Expenses</th>
                <td class="total-cell">$<?= number_format( $operating_expenses ) ?> &boxdl;</td>
              </tr>
              <tr>
                <td>&bull; Management Labor</td>
                <td style="text-align: right;">$<?= number_format( $current_business_plan['management_team_cost'] ) ?></td>
              </tr>
              <tr>
                <td>&bull; Marketing/Advertising Expenses</td>
                <td style="text-align: right;">$<?= number_format( $current_business_plan['marketing_methods_cost'] ) ?></td>
              </tr>
              <tr>
                <th>Net Profit</th>
                <td class="total-cell pad-right">$<?= number_format( $net_profit ) ?></td>
              </tr>
              <tr>
                <th>Startup Funding</th>
                <td class="total-cell pad-right">$<?= number_format( $startup_funding ) ?></td>
              </tr>
              <tr>
                <th>Cash Reserves</th>
                <td class="total-cell pad-right">$<?= number_format( $net_profit + $startup_funding ) ?></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
    <!--<div class="col-lg-6">
      <pre><?= print_r( $current_business_plan, true ) ?></pre>
    </div>-->
  </div><!-- /.row -->
</div>
<style>
  table td.total-cell{text-align: right; font-weight: bold;}
  table td.total-cell.pad-right{padding-right: 1.8em;}
</style>