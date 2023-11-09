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
    return '<style>
.card-buttons{
  display: flex;
  flex-direction: row;
}
.card-buttons a:first-child{
  margin-right: 8px;
}
.card-buttons a:last-child{
  margin-left: auto;
}
</style>
<div class="container">
  <div class="row">
'.LR::sec($cx, (($inary && isset($in['bp'])) ? $in['bp'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '    <div class="col">
      <!-- Card with titles, buttons, and links -->
      <div class="card bizplan">
        <div class="card-body">
          <h5 class="card-title">'.htmlspecialchars((string)(($inary && isset($in['title'])) ? $in['title'] : null), ENT_QUOTES, 'UTF-8').'</h5>
          <table class="table">
            <tbody>
              <tr>
                <th style="width: 25%;">Company:</th>
                <td style="width: 75%;">'.htmlspecialchars((string)(($inary && isset($in['company_name'])) ? $in['company_name'] : null), ENT_QUOTES, 'UTF-8').'</td>
              </tr>
              <tr>
                <th style="width: 25%;">Product:</th>
                <td style="width: 75%;">'.htmlspecialchars((string)(($inary && isset($in['product'])) ? $in['product'] : null), ENT_QUOTES, 'UTF-8').'</td>
              </tr>
            </tbody>
          </table>

          <div class="card-buttons">
            <a href="'.htmlspecialchars((string)(($inary && isset($in['view_url'])) ? $in['view_url'] : null), ENT_QUOTES, 'UTF-8').'" class="btn btn-primary btn-sm view-business-plan" data-bpid="'.htmlspecialchars((string)(($inary && isset($in['ID'])) ? $in['ID'] : null), ENT_QUOTES, 'UTF-8').'">View</a>
            <a href="'.htmlspecialchars((string)(($inary && isset($in['edit_url'])) ? $in['edit_url'] : null), ENT_QUOTES, 'UTF-8').'" class="btn btn-primary btn-sm edit-business-plan" data-bpid="'.htmlspecialchars((string)(($inary && isset($in['ID'])) ? $in['ID'] : null), ENT_QUOTES, 'UTF-8').'">Edit</a>
            <a href="'.htmlspecialchars((string)(($inary && isset($in['view_url'])) ? $in['view_url'] : null), ENT_QUOTES, 'UTF-8').'" class="btn btn-secondary btn-sm delete-business-plan" data-bpid="'.htmlspecialchars((string)(($inary && isset($in['ID'])) ? $in['ID'] : null), ENT_QUOTES, 'UTF-8').'">Delete</a>
          </div>
        </div>
      </div><!-- End Card with titles, buttons, and links -->
    </div><!--  /.col -->
';}).''.((LR::ifvar($cx, (($inary && isset($in['show_add_new'])) ? $in['show_add_new'] : null), false)) ? '    <div class="col">
      <div class="card bizplan add-new-card">
        <div class="card-body text-center">
          <a href="#" class="" id="start-new-plan">
            <span id="new-plan-button-text">Start a New Plan</span>
            <div id="response-message"></div>
          </a>
        </div>
      </div>
    </div>
' : '').''.((LR::ifvar($cx, (($inary && isset($in['show_empty_1'])) ? $in['show_empty_1'] : null), false)) ? '    <div class="col">
      &nbsp;
    </div>
' : '').''.((LR::ifvar($cx, (($inary && isset($in['show_empty_2'])) ? $in['show_empty_2'] : null), false)) ? '    <div class="col">
      &nbsp;
    </div>
' : '').'  </div>
</div>
';
};
?>