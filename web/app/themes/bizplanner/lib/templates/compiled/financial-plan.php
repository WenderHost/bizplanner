<?php
use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array(            'numberformat' => 'BizPlanner\templates\LnC_helper_numberformat',
            'processarray' => 'BizPlanner\templates\LnC_helper_processarray',
);
    $partials = array();
    $cx = array(
        'flags' => array(
            'jstrue' => false,
            'jsobj' => false,
            'jslen' => false,
            'spvar' => true,
            'prop' => false,
            'method' => false,
            'lambda' => false,
            'mustlok' => false,
            'mustlam' => false,
            'mustsec' => false,
            'echo' => false,
            'partnc' => false,
            'knohlp' => false,
            'debug' => isset($options['debug']) ? $options['debug'] : 1,
        ),
        'constants' => array(),
        'helpers' => isset($options['helpers']) ? array_merge($helpers, $options['helpers']) : $helpers,
        'partials' => isset($options['partials']) ? array_merge($partials, $options['partials']) : $partials,
        'scopes' => array(),
        'sp_vars' => isset($options['data']) ? array_merge(array('root' => $in), $options['data']) : array('root' => $in),
        'blparam' => array(),
        'partialid' => 0,
        'runtime' => '\LightnCandy\Runtime',
    );
    
    $inary=is_array($in);
    return '<style>
#financial-plan h1{font-size: 1.6rem; margin: 0;}
#financial-plan h2{font-size: 1.5rem; font-weight: bold; padding-top: .5em; border-top: 1px solid rgb(222, 226, 230);}
#financial-plan h3{font-size: 1.2rem; font-weight: bold;}
#financial-plan{padding-top: 1em;}
#financial-plan .row{margin-bottom: 1rem;}
</style>
<div id="financial-plan">
  <div class="row">
    <div class="col" style="display: flex; flex-direction: column; justify-content: center;"><h1 class="title">Business Plan<br>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['company_name'])) ? $in['current_business_plan']['company_name'] : null), ENT_QUOTES, 'UTF-8').'</h1></div>
    <div class="col text-end"><img src="'.htmlspecialchars((string)(($inary && isset($in['logo'])) ? $in['logo'] : null), ENT_QUOTES, 'UTF-8').'" alt="Entreprenuerial Xchange" width="220" /></div>
  </div>
  <div class="row">
    <div class="col"><strong>Student:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['firstname'])) ? $in['current_business_plan']['user']['firstname'] : null), ENT_QUOTES, 'UTF-8').' '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['lastname'])) ? $in['current_business_plan']['user']['lastname'] : null), ENT_QUOTES, 'UTF-8').'</div>
    <div class="col"><strong>Grade:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['grade'])) ? $in['current_business_plan']['user']['grade'] : null), ENT_QUOTES, 'UTF-8').'</div>
    <div class="col"><strong>School:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['school'])) ? $in['current_business_plan']['user']['school'] : null), ENT_QUOTES, 'UTF-8').'</div>
  </div>
  <div class="row">
    <div class="col"><strong>Product Description:</strong><br>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_description'])) ? $in['current_business_plan']['product_description'] : null), ENT_QUOTES, 'UTF-8').'</div>
    <div class="col"><strong>Tagline/Slogan:</strong><br>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['tagline_or_slogan'])) ? $in['current_business_plan']['tagline_or_slogan'] : null), ENT_QUOTES, 'UTF-8').'</div>
  </div>
<h2>Marketing and Sales Plan</h2>
<div class="row">
  <div class="col">
    <strong>Product:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product'])) ? $in['current_business_plan']['product'] : null), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Category:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_category'])) ? $in['current_business_plan']['product_category'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Description:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_description'])) ? $in['current_business_plan']['product_description'] : null), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Competitors:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['competitors'])) ? $in['current_business_plan']['competitors'] : null), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Differences:</strong> '.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['differences'])) ? $in['current_business_plan']['differences'] : null), ENT_QUOTES, 'UTF-8').'
  </div>
</div>
<h3>Pricing Plan</h3>
<div class="row">
  <div class="col-6"><strong>Price:</strong> $'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_price'])) ? $in['current_business_plan']['product_price'] : null), ENT_QUOTES, 'UTF-8').'</div>
  <div class="col-6"><strong>First Year Sales:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</div>
</div>
<h3>Sales Distribution</h3>
<div class="row">
  <div class="col">
    <strong>Customers:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['customers'])) ? $in['current_business_plan']['customers'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Retail Sales:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['retail_sale'])) ? $in['current_business_plan']['retail_sale'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Direct Sales:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['direct_sale'])) ? $in['current_business_plan']['direct_sale'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'
  </div>
</div>
<h3>Marketing Methods</h3>
<div class="row">
  <div class="col">
    '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['marketing_methods'])) ? $in['current_business_plan']['marketing_methods'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'
  </div>
</div>

<h2>Operatings/Manufacturing Plan</h2>
<div class="row">
  <div class="col">
    <strong>Production:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['production_methods'])) ? $in['current_business_plan']['production_methods'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Product Cost:</strong> $'.htmlspecialchars((string)((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['cost_per_unit'])) ? $in['current_business_plan']['financial_plan']['cost_per_unit'] : null), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Manufacturing Quantity:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'<br>
    <strong>Company Facilities:</strong> '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['company_facility'])) ? $in['current_business_plan']['company_facility'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'
  </div>
</div>

<h2>Management Team</h2>
<div class="row">
  <div class="col">
    '.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['management_team'])) ? $in['current_business_plan']['management_team'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'
  </div>
</div>

<h2>Financial Plan</h2>
<table class="table">
  <tbody>
    <tr>
      <th style="width: 55%;">Income/Revenue Goal <span style="font-size: .8em; font-weight: normal;">('.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' sold x $'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_price'])) ? $in['current_business_plan']['product_price'] : null), ENT_QUOTES, 'UTF-8').'/<em>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product'])) ? $in['current_business_plan']['product'] : null), ENT_QUOTES, 'UTF-8').'</em>)</span></th>
      <td class="total-cell pad-right" style="width: 45%;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['revenue'])) ? $in['current_business_plan']['financial_plan']['revenue'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <th>Production Costs</th>
      <td class="total-cell">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['production_costs'])) ? $in['current_business_plan']['financial_plan']['production_costs'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' &boxdl;</td>
    </tr>
    <tr>
      <td>&bull; Product Costs ($'.htmlspecialchars((string)((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['cost_per_unit'])) ? $in['current_business_plan']['financial_plan']['cost_per_unit'] : null), ENT_QUOTES, 'UTF-8').' <span style="font-size: .8em;">per</span> <em style="font-size: .8em;">'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product'])) ? $in['current_business_plan']['product'] : null), ENT_QUOTES, 'UTF-8').'</em> x '.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').')</td>
      <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['material_costs'])) ? $in['current_business_plan']['financial_plan']['material_costs'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <td>&bull; Facility Expenses</td>
      <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['company_facility_cost'])) ? $in['current_business_plan']['company_facility_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <th>Operating Expenses</th>
      <td class="total-cell">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['operating_expenses'])) ? $in['current_business_plan']['financial_plan']['operating_expenses'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' &boxdl;</td>
    </tr>
    <tr>
      <td>&bull; Management Labor</td>
      <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['management_team_cost'])) ? $in['current_business_plan']['management_team_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <td>&bull; Marketing/Advertising Expenses</td>
      <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['marketing_methods_cost'])) ? $in['current_business_plan']['marketing_methods_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <th>Net Profit</th>
      <td class="total-cell pad-right'.((LR::ifvar($cx, ((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['profitable'])) ? $in['current_business_plan']['financial_plan']['profitable'] : null), false)) ? ' positive' : ' negative').'">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['net_profit'])) ? $in['current_business_plan']['financial_plan']['net_profit'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <th>Startup Funding</th>
      <td class="total-cell pad-right">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['startup_funding_source_cost'])) ? $in['current_business_plan']['startup_funding_source_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
    <tr>
      <th>Cash Reserves</th>
      <td class="total-cell pad-right'.((LR::ifvar($cx, ((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['positive_cash_reserves'])) ? $in['current_business_plan']['financial_plan']['positive_cash_reserves'] : null), false)) ? '' : ' negative').'">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['cash_reserves'])) ? $in['current_business_plan']['financial_plan']['cash_reserves'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
    </tr>
  </tbody>
</table>
</div><!-- #financial-plan -->';
};
?>