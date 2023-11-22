<?php
global $current_business_plan;
use function BizPlanner\templates\{render_template};

$data = [];
$data['current_business_plan'] = $current_business_plan;
$data['logo'] = BP_DIR_URI . 'lib/img/ex_logo.jpg';
?>
<div class="col-fluid" style="margin-bottom: 140px;">
  <div class="row">
    <div class="col">
      <div class="card">
        <div class="card-body">
          <?= render_template('financial-plan', $data ) ?>
        </div>
      </div>
    </div>
  </div><!-- /.row -->
</div>
<style>
  table td.total-cell{text-align: right; font-weight: bold;}
  table td.total-cell.pad-right{padding-right: 1.8em;}
  .negative{color: #f00 !important;}
</style>