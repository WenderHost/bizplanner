<pre style="font-size: 12px;"><strong>Available variables:</strong>
<?php
global $current_business_plan;
foreach( $current_business_plan as $key => $value ){
  $type = gettype( $value );
  switch( $type ){
    case 'boolean':
    case 'integer':
    case 'double':
    case 'string':
      $html_key = 'current_business_plan.<strong>' . $key . '</strong>';
      $html_value = '<span style="color: #80c74c">' . $value . '</span>';
      break;

    case 'array':
      if( 'financial_plan' == $key ){
        $financial_plan = $value;
        $financial_plan_entries = [];
        foreach( $financial_plan as $plan_key => $plan_value ){
          $financial_plan_entries[] = ' • {{current_business_plan.financial_plan.<strong>' . $plan_key . '</strong>}} = <span style="color: #80c74c">' . $plan_value . '</span>';
        }
      }
      $html_key = 'processarray current_business_plan.<strong>' . $key . '</strong>';
      $html_value = "\n  " . '<span style="color: #80c74c">' . BizPlanner\templates\LnC_helper_processarray( $value ) . '</span>';
      break;

    default:
      $html_key = 'current_business_plan.<strong>' . $key . '</strong>';
      $html_value = '<span style="color: #c79a4c">' . $type . '</span>';
  }
  echo '{{' . $html_key . '}} = ' . $html_value . "\n";
  if( isset( $financial_plan_entries ) && is_array( $financial_plan_entries ) )
    echo implode( "\n", $financial_plan_entries );
}
?>
</pre>

