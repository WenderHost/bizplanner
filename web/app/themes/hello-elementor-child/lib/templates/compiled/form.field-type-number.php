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
    return '<style>.input-row{display: flex; align-items: center; width: 100%;} .input-row span.prepend{background-color: #eee; border-radius: 3px 0 0 3px; display: block; height: 100%; padding: 7px 10px; font-size: 16px;}</style>
<div class="elementor-field-type-number elementor-field-group elementor-field-group-number_field elementor-col-100">
  <label for="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" class="elementor-field-label">'.htmlspecialchars((string)(($inary && isset($in['placeholder'])) ? $in['placeholder'] : null), ENT_QUOTES, 'UTF-8').'</label>
  <div class="input-row">'.(($inary && isset($in['prepend'])) ? $in['prepend'] : null).'
    <input type="number" name="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" id="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" class="elementor-field elementor-size-sm  elementor-field-textual" value="'.htmlspecialchars((string)(($inary && isset($in['value'])) ? $in['value'] : null), ENT_QUOTES, 'UTF-8').'" placeholder="'.htmlspecialchars((string)(($inary && isset($in['placeholder_esc'])) ? $in['placeholder_esc'] : null), ENT_QUOTES, 'UTF-8').'" '.htmlspecialchars((string)(($inary && isset($in['min_attr'])) ? $in['min_attr'] : null), ENT_QUOTES, 'UTF-8').''.htmlspecialchars((string)(($inary && isset($in['max_attr'])) ? $in['max_attr'] : null), ENT_QUOTES, 'UTF-8').'>
  '.(($inary && isset($in['append'])) ? $in['append'] : null).'</div><!-- /.input-row -->
</div>';
};
?>