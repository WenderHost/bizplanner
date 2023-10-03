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
    return '<div class="elementor-element e-con-full e-flex e-con e-child bizplan-cards" style="flex-direction: row;">
'.LR::sec($cx, (($inary && isset($in['bp'])) ? $in['bp'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '    <div class="elementor-element e-con-full e-flex e-con e-child bizplan-card">
      <h3 style="margin-bottom: 3px;">'.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</h3>
      <p>Company: '.htmlspecialchars((string)(($inary && isset($in['company_name'])) ? $in['company_name'] : null), ENT_QUOTES, 'UTF-8').'<br>
      Product: '.htmlspecialchars((string)(($inary && isset($in['product'])) ? $in['product'] : null), ENT_QUOTES, 'UTF-8').'</p>
      <div class="button-row">
        <div class="bizplan-link view-business-plan" data-bpid="'.htmlspecialchars((string)(($inary && isset($in['ID'])) ? $in['ID'] : null), ENT_QUOTES, 'UTF-8').'">
          <a href="'.htmlspecialchars((string)(($inary && isset($in['view_url'])) ? $in['view_url'] : null), ENT_QUOTES, 'UTF-8').'" class="elementor-button" >View</a>
        </div>
        <div class="bizplan-link edit-business-plan" data-bpid="'.htmlspecialchars((string)(($inary && isset($in['ID'])) ? $in['ID'] : null), ENT_QUOTES, 'UTF-8').'">
          <a href="'.htmlspecialchars((string)(($inary && isset($in['edit_url'])) ? $in['edit_url'] : null), ENT_QUOTES, 'UTF-8').'" class="elementor-button" >Edit</a>
        </div>
        <div class="bizplan-link delete-business-plan" data-bpid="'.htmlspecialchars((string)(($inary && isset($in['ID'])) ? $in['ID'] : null), ENT_QUOTES, 'UTF-8').'">
          <a href="'.htmlspecialchars((string)(($inary && isset($in['delete_url'])) ? $in['delete_url'] : null), ENT_QUOTES, 'UTF-8').'" class="elementor-button" >Delete</a>
        </div>
      </div>
    </div>
';}).''.((LR::ifvar($cx, (($inary && isset($in['show_add_new'])) ? $in['show_add_new'] : null), false)) ? '    <div class="elementor-element e-con-full e-flex e-con e-child add-new" id="start-new-plan-container">
      <a href="#" class="add-new-card" id="start-new-plan">
        <span>Start a New Plan</span>
        <div id="response-message"></div>
      </a>

    </div>
' : '').''.((LR::ifvar($cx, (($inary && isset($in['show_empty_1'])) ? $in['show_empty_1'] : null), false)) ? '    <div class="elementor-element e-con-full e-flex e-con e-child empty">
      <h2>Empty 1</h2>
    </div>
' : '').''.((LR::ifvar($cx, (($inary && isset($in['show_empty_2'])) ? $in['show_empty_2'] : null), false)) ? '    <div class="elementor-element e-con-full e-flex e-con e-child empty">
      <h2>Empty 2</h2>
    </div>
' : '').'</div>';
};
?>