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
    return '

  <input size="1" type="text" name="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'"  aria-describedby="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" id="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" class="form-control" value="'.htmlspecialchars((string)(($inary && isset($in['value'])) ? $in['value'] : null), ENT_QUOTES, 'UTF-8').'" placeholder="'.htmlspecialchars((string)(($inary && isset($in['placeholder_esc'])) ? $in['placeholder_esc'] : null), ENT_QUOTES, 'UTF-8').'">
';
};
?>