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
    return '<!-- Card with an image on left -->
<div class="card mb-3 bizplanner">
  <div class="row g-0">
    <div class="col-md-auto left-column">
      <img src="'.htmlspecialchars((string)(($inary && isset($in['avatar'])) ? $in['avatar'] : null), ENT_QUOTES, 'UTF-8').'" class="img-fluidAAA rounded-start avatar" alt="...">
    </div>
    <div class="col-md-8 right-column">
      <div class="card-body">
        <h5 class="card-title">'.(($inary && isset($in['prompt'])) ? $in['prompt'] : null).'</h5>
        <p id="response-message"></p>
'.((LR::ifvar($cx, (($inary && isset($in['additional_help'])) ? $in['additional_help'] : null), false)) ? '        <div class="alert alert-primary fade show" role="alert">
          '.(($inary && isset($in['additional_help'])) ? $in['additional_help'] : null).'
        </div>
' : '').'        <form class="g-3" id="bizplanner-form">
          <input type="hidden" name="field_name" value="'.htmlspecialchars((string)(($inary && isset($in['input_name'])) ? $in['input_name'] : null), ENT_QUOTES, 'UTF-8').'" />
          '.(($inary && isset($in['html'])) ? $in['html'] : null).'
          <button type="submit" class="btn btn-primary" id="form-submit" style="margin-top: 1rem; display: none;"><span>Save</span></button>
        </form>
      </div>
    </div>
  </div>
</div><!-- End Card with an image on left -->';
};
?>