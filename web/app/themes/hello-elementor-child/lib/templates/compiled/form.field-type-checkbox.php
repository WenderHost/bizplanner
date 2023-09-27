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
    return '<style>
#bizplanner-form .elementor-field-option{color: #fff;}
#bizplanner-form .elementor-field-option label{display: inline-block; width: 180px; overflow: hidden; white-space: nowrap; text-overflow: ellipsis;}
</style>
<div class="elementor-field-type-checkbox elementor-field-group elementor-field-group-checkbox elementor-col-100">
  <label for="form-field-checkbox" class="elementor-field-label" style="display: block;">'.htmlspecialchars((string)(($inary && isset($in['placeholder'])) ? $in['placeholder'] : null), ENT_QUOTES, 'UTF-8').'</label>
  <div class="elementor-field-subgroup">
'.LR::sec($cx, (($inary && isset($in['options'])) ? $in['options'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '    <span class="elementor-field-option">
      <input type="checkbox" value="'.htmlspecialchars((string)(($inary && isset($in['term_id'])) ? $in['term_id'] : null), ENT_QUOTES, 'UTF-8').'" id="'.htmlspecialchars((string)(($inary && isset($in['slug_esc'])) ? $in['slug_esc'] : null), ENT_QUOTES, 'UTF-8').'" name="'.htmlspecialchars((string)(($inary && isset($in['input_name_esc'])) ? $in['input_name_esc'] : null), ENT_QUOTES, 'UTF-8').'[]"'.(($inary && isset($in['checked'])) ? $in['checked'] : null).'> <label for="'.htmlspecialchars((string)(($inary && isset($in['slug_esc'])) ? $in['slug_esc'] : null), ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars((string)(($inary && isset($in['name'])) ? $in['name'] : null), ENT_QUOTES, 'UTF-8').'</label>
      '.((LR::ifvar($cx, (($inary && isset($in['cost'])) ? $in['cost'] : null), false)) ? '<span class="value-symbol">$</span><span class="value">'.htmlspecialchars((string)(($inary && isset($in['cost'])) ? $in['cost'] : null), ENT_QUOTES, 'UTF-8').'</span>' : '').'
    </span>
';}).'  </div>
'.((LR::ifvar($cx, (($inary && isset($in['cost'])) ? $in['cost'] : null), false)) ? '  <div class="total">

  </div>
' : '').'</div>';
};
?>