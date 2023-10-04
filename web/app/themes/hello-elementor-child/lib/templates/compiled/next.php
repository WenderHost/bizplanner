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
    return '<div class="elementor-element elementor-widget elementor-widget-button nextprevbuttons'.((LR::ifvar($cx, (($inary && isset($in['url'])) ? $in['url'] : null), false)) ? '' : ' inactive').'">
  <div class="elementor-widget-container">
    <div class="elementor-button-wrapper">
      <a class="elementor-button elementor-button-link elementor-size-sm" href="'.htmlspecialchars((string)(($inary && isset($in['url'])) ? $in['url'] : null), ENT_QUOTES, 'UTF-8').'">
        <span class="elementor-button-content-wrapper">
          <span class="elementor-button-icon elementor-align-icon-right"><i aria-hidden="true" class="fas fa-arrow-alt-circle-right"></i></span>
          <span class="elementor-button-text">Next'.((LR::ifvar($cx, (($inary && isset($in['pagename'])) ? $in['pagename'] : null), false)) ? ': '.htmlspecialchars((string)(($inary && isset($in['pagename'])) ? $in['pagename'] : null), ENT_QUOTES, 'UTF-8').'' : '').'</span>
        </span>
      </a>
    </div>
  </div>
</div>';
};
?>