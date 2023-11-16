<?php
use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array();
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
    return '<div class="row">
  <div class="col-11">
    <input class="form-range" type="range" value="'.htmlspecialchars((string)(($inary && isset($in['value'])) ? $in['value'] : null), ENT_QUOTES, 'UTF-8').'" min="'.htmlspecialchars((string)((isset($in['atts']) && is_array($in['atts']) && isset($in['atts']['min'])) ? $in['atts']['min'] : null), ENT_QUOTES, 'UTF-8').'" max="'.htmlspecialchars((string)((isset($in['atts']) && is_array($in['atts']) && isset($in['atts']['max'])) ? $in['atts']['max'] : null), ENT_QUOTES, 'UTF-8').'" step="'.htmlspecialchars((string)((isset($in['atts']) && is_array($in['atts']) && isset($in['atts']['step'])) ? $in['atts']['step'] : null), ENT_QUOTES, 'UTF-8').'" name="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'"  aria-describedby="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" id="range" oninput="rangevalue.value=value"/>
  </div>
  <div class="col-1">
    <input type="number" id="rangevalue" placeholder="'.htmlspecialchars((string)(($inary && isset($in['value'])) ? $in['value'] : null), ENT_QUOTES, 'UTF-8').'" step="'.htmlspecialchars((string)((isset($in['atts']) && is_array($in['atts']) && isset($in['atts']['step'])) ? $in['atts']['step'] : null), ENT_QUOTES, 'UTF-8').'" oninput="range.value=value">
  </div>
</div>
<script type="text/javascript">
const rangeInputs = document.querySelectorAll(\'input[type="range"]\')
const numberInput = document.querySelector(\'input[type="number"]\')

function handleInputChange(e) {
  let target = e.target
  if (e.target.type !== \'range\') {
    target = document.getElementById(\'range\')
  }
  const min = target.min
  const max = target.max
  const val = target.value

  target.style.backgroundSize = (val - min) * 100 / (max - min) + \'% 100%\'
}

rangeInputs.forEach(input => {
  input.addEventListener(\'input\', handleInputChange)
})

numberInput.addEventListener(\'input\', handleInputChange)
</script>';
};
?>