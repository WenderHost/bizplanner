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
    return '<ul class="sidebar-nav" id="sidebar-nav" style="margin-bottom: 80px;">
'.LR::sec($cx, (($inary && isset($in['questions'])) ? $in['questions'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '  <li class="nav-item">
    <a class="nav-link '.htmlspecialchars((string)(($inary && isset($in['current'])) ? $in['current'] : null), ENT_QUOTES, 'UTF-8').'" href="'.htmlspecialchars((string)(($inary && isset($in['permalink'])) ? $in['permalink'] : null), ENT_QUOTES, 'UTF-8').'">
      <!--<i class="bi bi-grid"></i>-->
      <i class="fas '.htmlspecialchars((string)(($inary && isset($in['classes'])) ? $in['classes'] : null), ENT_QUOTES, 'UTF-8').'" aria-hidden="true"></i>
      <span>'.htmlspecialchars((string)(($inary && isset($in['counter'])) ? $in['counter'] : null), ENT_QUOTES, 'UTF-8').'. '.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</span>
    </a>
  </li><!-- End Dashboard Nav -->
';}).'</ul>';
};
?>