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
    return ''.((LR::ifvar($cx, (($inary && isset($in['next'])) ? $in['next'] : null), false)) ? ''.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? '    <a href="'.htmlspecialchars((string)(($inary && isset($in['url'])) ? $in['url'] : null), ENT_QUOTES, 'UTF-8').'" class="btn btn-nextprev btn-primary" id="next-question-btn">Next'.((LR::ifvar($cx, (($inary && isset($in['pagename'])) ? $in['pagename'] : null), false)) ? ': '.htmlspecialchars((string)(($inary && isset($in['pagename'])) ? $in['pagename'] : null), ENT_QUOTES, 'UTF-8').'' : '').' <i class="bi bi-arrow-right-circle"></i></a>
' : '    <a href="'.htmlspecialchars((string)(($inary && isset($in['print_url'])) ? $in['print_url'] : null), ENT_QUOTES, 'UTF-8').'" target="_blank" class="btn btn-primary"><i class="bi bi-printer"></i> Generate Business Plan</a>
').'' : ''.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? '    <a href="'.htmlspecialchars((string)(($inary && isset($in['url'])) ? $in['url'] : null), ENT_QUOTES, 'UTF-8').'" class="btn btn-nextprev btn-primary" id="previous-question-btn"><i class="bi bi-arrow-left-circle"></i> Previous'.((LR::ifvar($cx, (($inary && isset($in['pagename'])) ? $in['pagename'] : null), false)) ? ': '.htmlspecialchars((string)(($inary && isset($in['pagename'])) ? $in['pagename'] : null), ENT_QUOTES, 'UTF-8').'' : '').'</a>
' : '    &nbsp;
').'').'';
};
?>