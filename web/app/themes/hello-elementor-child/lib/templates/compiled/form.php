<?php
use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
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
    return '<style>#bizplanner-form label{padding-bottom: 6px; color: #fff} #bizplanner-form input{background-color: #fff;} #bizplanner-form .elementor-field-type-submit{margin-top: 10px;}</style>
<form class="elementor-form" id="bizplanner-form">'.(($inary && isset($in['html'])) ? $in['html'] : null).'
  <div class="elementor-field-group elementor-column elementor-field-type-submit elementor-col-100 e-form__buttons">
    <button type="submit" class="elementor-button elementor-size-sm" id="form-submit"><span><span class="elementor-button-text">Save</span></span></button>
  </div>
</form>';
};
?>