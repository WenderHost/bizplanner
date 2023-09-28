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
    return '<style></style>
<div class="elementor-field-type-textarea" id="question-form-textarea">
  <label speech-bubble pbottom aleft class="" for="'.htmlspecialchars((string)(($inary && isset($in['input_name_esc'])) ? $in['input_name_esc'] : null), ENT_QUOTES, 'UTF-8').'">'.htmlspecialchars((string)(($inary && isset($in['prompt'])) ? $in['prompt'] : null), ENT_QUOTES, 'UTF-8').'</label>
  <textarea class="" id="'.htmlspecialchars((string)(($inary && isset($in['input_name_esc'])) ? $in['input_name_esc'] : null), ENT_QUOTES, 'UTF-8').'" aria-describedby="'.htmlspecialchars((string)(($inary && isset($in['input_name_esc'])) ? $in['input_name_esc'] : null), ENT_QUOTES, 'UTF-8').'" type="textarea" name="'.htmlspecialchars((string)(($inary && isset($in['input_name_esc'])) ? $in['input_name_esc'] : null), ENT_QUOTES, 'UTF-8').'" placeholder="" required="">'.htmlspecialchars((string)(($inary && isset($in['value'])) ? $in['value'] : null), ENT_QUOTES, 'UTF-8').'</textarea>
</div>
';
};
?>