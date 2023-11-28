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
    return '<table class="table">
  <tr>
    <td>
      <h1 class="title" style="font-size: 28px; font-weight: bold; text-transform: uppercase;">Business Plan</h1>
      <h2 style="font-size: 18px; font-weight: bold;">'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['company_name'])) ? $in['current_business_plan']['company_name'] : null), ENT_QUOTES, 'UTF-8').'</h2>
    </td>
    <td style="text-align: right;"><img src="'.htmlspecialchars((string)(($inary && isset($in['logo'])) ? $in['logo'] : null), ENT_QUOTES, 'UTF-8').'" alt="Entreprenuerial Xchange" width="140" /></td>
  </tr>
</table>
<div style="border-top: 1px solid #ccc; margin: 10px 0;"></div>
<table class="table">
  <tr>
    <td style="width: 40%;"><span style="font-weight: bold;">Student:</span> '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['firstname'])) ? $in['current_business_plan']['user']['firstname'] : null), ENT_QUOTES, 'UTF-8').' '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['lastname'])) ? $in['current_business_plan']['user']['lastname'] : null), ENT_QUOTES, 'UTF-8').'</td>
    <td style="width: 20%;"><span style="font-weight: bold;">Grade:</span> '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['grade'])) ? $in['current_business_plan']['user']['grade'] : null), ENT_QUOTES, 'UTF-8').'</td>
    <td style="width: 40%;"><span style="font-weight: bold;">School:</span> '.htmlspecialchars((string)((isset($in['current_business_plan']['user']) && is_array($in['current_business_plan']['user']) && isset($in['current_business_plan']['user']['school'])) ? $in['current_business_plan']['user']['school'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td colspan="2"><span style="font-weight: bold;">Product Description:</span><br>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_description'])) ? $in['current_business_plan']['product_description'] : null), ENT_QUOTES, 'UTF-8').'</td>
    <td><span style="font-weight: bold;">Tagline/Slogan:</span><br>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['tagline_or_slogan'])) ? $in['current_business_plan']['tagline_or_slogan'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
</table>
<div style="border-top: 1px solid #ccc; margin: 10px 0;"></div>
<h2 style="font-size: 18px; font-weight: bold; text-transform: uppercase;">Marketing and Sales Plan</h2>
<table class="table">
  <tr>
    <td style="width: 15%;"><span style="font-weight: bold;">Product:</span> </td>
    <td style="width: 85%;">'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product'])) ? $in['current_business_plan']['product'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Category:</span> </td>
    <td>'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_category'])) ? $in['current_business_plan']['product_category'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Description:</span> </td>
    <td>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_description'])) ? $in['current_business_plan']['product_description'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Competitors:</span> </td>
    <td>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['competitors'])) ? $in['current_business_plan']['competitors'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Differences:</span> </td>
    <td>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['differences'])) ? $in['current_business_plan']['differences'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
</table>
<h3 style="font-size: 15px; font-weight: bold;">Pricing Plan</h3>
<table class="table">
  <tr>
    <td style="width: 50%;"><span style="font-weight: bold;">Price:</span> $'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_price'])) ? $in['current_business_plan']['product_price'] : null), ENT_QUOTES, 'UTF-8').'</td>
    <td style="width: 50%;"><span style="font-weight: bold;">First Year Sales:</span> '.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
</table>
<h3 style="font-size: 15px; font-weight: bold;">Sales Distribution</h3>
<table class="table">
  <tr>
    <td style="width: 15%;"><span style="font-weight: bold;">Customers:</span> </td>
    <td style="width: 85%;">'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['customers'])) ? $in['current_business_plan']['customers'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Retail Sales:</span> </td>
    <td>'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['retail_sale'])) ? $in['current_business_plan']['retail_sale'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Direct Sales:</span> </td>
    <td>'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['direct_sale'])) ? $in['current_business_plan']['direct_sale'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
</table>
<h3 style="font-size: 15px; font-weight: bold;">Marketing Methods</h3>
'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['marketing_methods'])) ? $in['current_business_plan']['marketing_methods'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'
<div style="border-top: 1px solid #ccc; margin: 10px 0;"></div>
<h2 style="font-size: 18px; font-weight: bold; text-transform: uppercase;">Operating/Manufacturing Plan</h2>
<table class="table">
  <tr>
    <td style="width: 25%;"><span style="font-weight: bold;">Production:</span> </td>
    <td style="width: 75%;">'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['production_methods'])) ? $in['current_business_plan']['production_methods'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Product Cost:</span> </td>
    <td>$'.htmlspecialchars((string)((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['cost_per_unit'])) ? $in['current_business_plan']['financial_plan']['cost_per_unit'] : null), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Manufacturing Quantity:</span> </td>
    <td>'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Company Facilities:</span> </td>
    <td>'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['company_facility'])) ? $in['current_business_plan']['company_facility'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
</table>
'.((LR::ifvar($cx, ((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['management_team'])) ? $in['current_business_plan']['management_team'] : null), false)) ? '<div style="border-top: 1px solid #ccc; margin: 10px 0;"></div>
<h2 style="font-size: 18px; font-weight: bold; text-transform: uppercase;">Management Team</h2>
'.htmlspecialchars((string)LR::hbch($cx, 'processarray', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['management_team'])) ? $in['current_business_plan']['management_team'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'
' : '').'<div style="border-top: 1px solid #ccc; margin: 10px 0;"></div>
<h2 style="font-size: 18px; font-weight: bold; text-transform: uppercase;">Financial Plan</h2>
<table cellPadding="5" class="table" style="border-collapse: collapse;">
  <tr bgcolor="#f1f1f1">
    <td border="1" style="width: 80%; border: 1px solid #eee;"><span style="font-weight: bold;">Income/Revenue Goal</span> <span style="font-size: .8em; font-weight: normal;">('.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' sold x $'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product_price'])) ? $in['current_business_plan']['product_price'] : null), ENT_QUOTES, 'UTF-8').'/<em>'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product'])) ? $in['current_business_plan']['product'] : null), ENT_QUOTES, 'UTF-8').'</em>)</span></td>
    <td style="width: 20%; text-align: right; padding-right: 18px; font-weight: bold;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['revenue'])) ? $in['current_business_plan']['financial_plan']['revenue'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Production Costs</span></td>
    <td style="text-align: right; font-weight: bold;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['production_costs'])) ? $in['current_business_plan']['financial_plan']['production_costs'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' ↴</td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td><span style="font-weight: bold;"> • Product Costs ($'.htmlspecialchars((string)((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['cost_per_unit'])) ? $in['current_business_plan']['financial_plan']['cost_per_unit'] : null), ENT_QUOTES, 'UTF-8').' <span style="font-size: .8em;">per</span> <em style="font-size: .8em;">'.htmlspecialchars((string)((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['product'])) ? $in['current_business_plan']['product'] : null), ENT_QUOTES, 'UTF-8').'</em> x '.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['quantity'])) ? $in['current_business_plan']['quantity'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').')</span></td>
    <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['material_costs'])) ? $in['current_business_plan']['financial_plan']['material_costs'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;"> • Facility Expenses</td>
    <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['company_facility_cost'])) ? $in['current_business_plan']['company_facility_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td><span style="font-weight: bold;">Operating Expenses</span></td>
    <td style="text-align: right; font-weight: bold;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['operating_expenses'])) ? $in['current_business_plan']['financial_plan']['operating_expenses'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').' ↴</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;"> • Management Labor</td>
    <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['management_team_cost'])) ? $in['current_business_plan']['management_team_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td><span style="font-weight: bold;"> • Marketing/Advertising Expenses</td>
    <td style="text-align: right;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['marketing_methods_cost'])) ? $in['current_business_plan']['marketing_methods_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Net Profit</span></td>
    <td style="text-align: right; font-weight: bold; padding-right: 18px;'.((LR::ifvar($cx, ((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['profitable'])) ? $in['current_business_plan']['financial_plan']['profitable'] : null), false)) ? '' : ' color: #f00;').'">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['net_profit'])) ? $in['current_business_plan']['financial_plan']['net_profit'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr bgcolor="#f1f1f1">
    <td><span style="font-weight: bold;">Startup Funding</span></td>
    <td style="text-align: right; font-weight: bold; padding-right: 18px;">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']) && is_array($in['current_business_plan']) && isset($in['current_business_plan']['startup_funding_source_cost'])) ? $in['current_business_plan']['startup_funding_source_cost'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
  <tr>
    <td><span style="font-weight: bold;">Cash Reserves</span></td>
    <td style="text-align: right; font-weight: bold; padding-right: 18px;'.((LR::ifvar($cx, ((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['positive_cash_reserves'])) ? $in['current_business_plan']['financial_plan']['positive_cash_reserves'] : null), false)) ? '' : ' color: #f00;').'">$'.htmlspecialchars((string)LR::hbch($cx, 'numberformat', array(array(((isset($in['current_business_plan']['financial_plan']) && is_array($in['current_business_plan']['financial_plan']) && isset($in['current_business_plan']['financial_plan']['cash_reserves'])) ? $in['current_business_plan']['financial_plan']['cash_reserves'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'</td>
  </tr>
</table>';
};
?>