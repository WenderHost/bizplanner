<?php
use \LightnCandy\SafeString as SafeString;use \LightnCandy\Runtime as LR;return function ($in = null, $options = null) {
    $helpers = array(            'selected' => 'BizPlanner\templates\LnC_helper_isSelected',
);
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
    return '<!-- Vertical Form -->
<form class="row g-3" id="bizplanner-register">
  <div class="alert alert-danger response-message fade show" style="display: none;" role="alert"></div>
  <div class="col-md-6">
    <label for="fname" class="form-label">First Name</label>
    <input type="text" class="form-control" id="fname" name="fname" value="'.htmlspecialchars((string)(($inary && isset($in['firstname'])) ? $in['firstname'] : null), ENT_QUOTES, 'UTF-8').'" required>
  </div>
  <div class="col-md-6">
    <label for="lname" class="form-label">Last Name</label>
    <input type="text" class="form-control" id="lname" name="lname" value="'.htmlspecialchars((string)(($inary && isset($in['lastname'])) ? $in['lastname'] : null), ENT_QUOTES, 'UTF-8').'" required>
  </div>
  <div class="col-md-5">
    <label for="username" class="form-label">Grade</label>
    <select class="form-select" aria-label="Select your grade..." name="grade" required>
      <option selected="" value="">Select your grade...</option>
      <option value="4th"'.htmlspecialchars((string)LR::hbch($cx, 'selected', array(array('4th',(($inary && isset($in['grade'])) ? $in['grade'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'>4th</option>
      <option value="5th"'.htmlspecialchars((string)LR::hbch($cx, 'selected', array(array('5th',(($inary && isset($in['grade'])) ? $in['grade'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'>5th</option>
      <option value="6th"'.htmlspecialchars((string)LR::hbch($cx, 'selected', array(array('6th',(($inary && isset($in['grade'])) ? $in['grade'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'>6th</option>
      <option value="7th"'.htmlspecialchars((string)LR::hbch($cx, 'selected', array(array('7th',(($inary && isset($in['grade'])) ? $in['grade'] : null)),array()), 'enc', $in), ENT_QUOTES, 'UTF-8').'>7th</option>
    </select>
  </div>
  <div class="col-md-7">
    <label for="school" class="form-label">School</label>
    <input type="text" class="form-control" id="school" name="school" value="'.htmlspecialchars((string)(($inary && isset($in['school'])) ? $in['school'] : null), ENT_QUOTES, 'UTF-8').'" placeholder="Enter your school..." required>
  </div>
  <div class="col-12">
    <label for="username" class="form-label">Username</label>
    <input type="text" class="form-control" id="username" name="username" value="'.htmlspecialchars((string)(($inary && isset($in['username'])) ? $in['username'] : null), ENT_QUOTES, 'UTF-8').'" autocapitalize="off" required>
  </div>
  <div class="col-12" style="">
    <label for="visiblePasswordField" class="form-label">Password</label>
    <div style="display: flex; flex-direction: row;">
      <input type="text" class="form-control" id="visiblePasswordField" oninput="updateHiddenPasswordField(event)" required style="width: 70%; border-radius: 3px 0 0 3px;"><button type="button" id="show-password" class="btn btn-primary btn-sm" style="border-radius: 0 3px 3px 0;" onclick="togglePasswordVisibility()"><i class="bi bi-eye-fill"></i> Show Password</button>
    </div>

    <input type="hidden" id="hiddenPasswordField" name="password">
    <style>
      #passwordMask {
        font-family: monospace; /* Ensure consistent character width */
        letter-spacing: .25ch;   /* Adjust as needed for character spacing */
      }
    </style>
    <script>
      var actualPassword = \'\';
      function updateHiddenPasswordField(event) {

        if ( event.inputType === "deleteContentBackward" ) {
          // Remove the last character from actualPassword
          actualPassword = actualPassword.slice(0, -1);
        } else {
          // Append the newly typed value to the existing actualPassword
          actualPassword += event.data;
        }

        // Update the hidden input with the actual password value
        document.getElementById("hiddenPasswordField").value = actualPassword;

        // Create a string with the same length as the password, filled with dots
        var maskedValue = \'•\'.repeat(actualPassword.length);
        document.getElementById("visiblePasswordField").value = maskedValue;
      }

      function togglePasswordVisibility() {
          var visiblePasswordField = document.getElementById("visiblePasswordField");
          var toggleButton = document.getElementById(\'show-password\');

          // Toggle between actual password and masked value
          if (visiblePasswordField.value === actualPassword) {
              var maskedValue = \'•\'.repeat(actualPassword.length);
              visiblePasswordField.value = maskedValue;
              toggleButton.innerHTML = \'<i class="bi bi-eye-fill"></i> Show Password\';
          } else {
              visiblePasswordField.value = actualPassword;
              toggleButton.innerHTML = \'<i class="bi bi-eye-slash-fill"></i> Hide Password\';
          }
      }
    </script>
  </div>

  <div class="col-12">
    <label for="avatar" class="form-label">Your Avatar</label>
    <div class="row">
      <div class="col-3">
        <div class="avatar-frame"><img class="img-fluid" id="avatar" style="cursor: pointer;" src="'.htmlspecialchars((string)(($inary && isset($in['bp_dir_uri'])) ? $in['bp_dir_uri'] : null), ENT_QUOTES, 'UTF-8').'lib/img/bizplanner-avatar_'.htmlspecialchars((string)(($inary && isset($in['avatar'])) ? $in['avatar'] : null), ENT_QUOTES, 'UTF-8').'.png" data-bs-toggle="modal" data-bs-target="#ExtralargeModal" /></div>
        <input type="hidden" name="avatar" id="selectedavatar" value="0" />
      </div>
      <div class="col-9">

        <!-- Extra Large Modal -->
        <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#ExtralargeModal">
          Select Your Avatar - Click Here
        </button>

        <div class="modal fade" id="ExtralargeModal" tabindex="-1">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Select Your Avatar</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body" id="avatar-selector" style="background-color: #eee;">
'.LR::sec($cx, (($inary && isset($in['avatars'])) ? $in['avatars'] : null), null, $in, true, function($cx, $in) {$inary=is_array($in);return '                  <img class="avatar-option" src="'.htmlspecialchars((string)((isset($cx['scopes'][count($cx['scopes'])-1]) && is_array($cx['scopes'][count($cx['scopes'])-1]) && isset($cx['scopes'][count($cx['scopes'])-1]['bp_dir_uri'])) ? $cx['scopes'][count($cx['scopes'])-1]['bp_dir_uri'] : null), ENT_QUOTES, 'UTF-8').'lib/img/bizplanner-avatar_'.htmlspecialchars((string)$in, ENT_QUOTES, 'UTF-8').'.png" data-bpavatar="'.htmlspecialchars((string)$in, ENT_QUOTES, 'UTF-8').'" style="" data-bs-dismiss="modal" data-bs-target="#ExtralargeModal" />
';}).'              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <!--<button type="button" class="btn btn-primary">Save changes</button>-->
              </div>
            </div>
          </div>
        </div><!-- End Extra Large Modal-->

      </div>
    </div>
  </div>
  <div class="text-left">
    <button type="submit" class="btn btn-primary">Save</button>
  </div>
</form><!-- Vertical Form -->';
};
?>