<div class="row">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Login</h5>
        <!-- Vertical Form -->
        <form class="row g-3" id="bizplanner-login">
          <p class="response-message" style="display: none;"></p>
          <div class="col-12">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="login_username" name="username" required>
          </div>
          <div class="col-12">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="login_password" name="password" required>
          </div>
          <div class="text-left">
            <button type="submit" class="btn btn-primary">Log In</button>
          </div>
        </form><!-- Vertical Form -->
      </div>
    </div>
  </div>
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title">Register</h5>
        <!-- Vertical Form -->
        <form class="row g-3" id="bizplanner-register">
          <p class="response-message" style="display: none;"></p>
          <div class="col-md-6">
            <label for="fname" class="form-label">First Name</label>
            <input type="text" class="form-control" id="fname" name="fname">
          </div>
          <div class="col-md-6">
            <label for="lname" class="form-label">Last Name</label>
            <input type="text" class="form-control" id="lname" name="lname">
          </div>
          <div class="col-md-5">
            <label for="username" class="form-label">Grade</label>
            <select class="form-select" aria-label="Select your grade..." name="grade">
              <option selected="">Select your grade...</option>
              <option value="4th">4th</option>
              <option value="5th">5th</option>
              <option value="6th">6th</option>
              <option value="7th">7th</option>
            </select>
          </div>
          <div class="col-md-7">
            <label for="school" class="form-label">School</label>
            <input type="text" class="form-control" id="school" name="school" placeholder="Enter your school..." required>
          </div>
          <div class="col-12">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" autocapitalize="off" required>
          </div>
          <div class="col-12">
            <label for="visiblePasswordField" class="form-label">Password</label>
            <input type="text" class="form-control" id="visiblePasswordField" oninput="updateHiddenPasswordField(event)" required>
            <input type="hidden" id="hiddenPasswordField" name="password">
            <style>
              #passwordMask {
                font-family: monospace; /* Ensure consistent character width */
                letter-spacing: .25ch;   /* Adjust as needed for character spacing */
              }
            </style>
            <script>
              var actualPassword = '';
              function updateHiddenPasswordField(event) {
                // Handle backspace key press
                if (event.inputType === "deleteContentBackward") {
                  actualPassword = actualPassword.slice(0, -1);
                } else {
                  // Append the newly typed value to the existing actualPassword
                  actualPassword += event.data;
                }

                // Update the hidden input with the actual password value
                document.getElementById("hiddenPasswordField").value = actualPassword;

                // Create a string with the same length as the password, filled with dots
                var maskedValue = '•'.repeat(actualPassword.length);
                document.getElementById("visiblePasswordField").value = maskedValue;
              }
            </script>
          </div>
          <div class="col-12">
            <label for="avatar" class="form-label">Your Avatar</label>
            <div class="row">
              <div class="col-3">
                <div class="avatar-frame"><img class="img-fluid" id="avatar" src="<?= BP_DIR_URI ?>lib/img/bizplanner-avatar_0.png" /></div>
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
                        <?php
                        $counter = 1;
                        for ($counter = 1; $counter < 5; $counter++) {
                          echo '<img class="avatar-option" src="' . BP_DIR_URI . 'lib/img/bizplanner-avatar_' . $counter . '.png" data-bpavatar="' . $counter . '" style="" />';
                        }
                        ?>
                      </div>
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
            <button type="submit" class="btn btn-primary">Register</button>
          </div>
        </form><!-- Vertical Form -->
      </div>
    </div>
  </div>
</div><!-- /.row -->