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
    return ''.((LR::ifvar($cx, (($inary && isset($in['next'])) ? $in['next'] : null), false)) ? '<a'.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? ' href="'.htmlspecialchars((string)(($inary && isset($in['url'])) ? $in['url'] : null), ENT_QUOTES, 'UTF-8').'"' : '').' class="btn btn-nextprev '.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? 'btn-primary' : 'btn-light').'" id="next-question-btn"'.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? '' : ' disabled').'>Next'.((LR::ifvar($cx, (($inary && isset($in['pagename'])) ? $in['pagename'] : null), false)) ? ': '.htmlspecialchars((string)(($inary && isset($in['pagename'])) ? $in['pagename'] : null), ENT_QUOTES, 'UTF-8').'' : '').' <i class="bi bi-arrow-right-circle"></i></a>
' : '<a'.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? ' href="'.htmlspecialchars((string)(($inary && isset($in['url'])) ? $in['url'] : null), ENT_QUOTES, 'UTF-8').'"' : '').' class="btn btn-nextprev '.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? 'btn-primary' : 'btn-light').'" id="previous-question-btn"'.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? '' : ' disabled').'><i class="bi bi-arrow-left-circle"></i> Previous'.((LR::ifvar($cx, (($inary && isset($in['pagename'])) ? $in['pagename'] : null), false)) ? ': '.htmlspecialchars((string)(($inary && isset($in['pagename'])) ? $in['pagename'] : null), ENT_QUOTES, 'UTF-8').'' : '').'</a>
').'';
};
?>