/**
 * CREATE Logic
 *
 * Creates a new business plan
 */
document.addEventListener("DOMContentLoaded", function () {
  const newPlanButton = document.getElementById('start-new-plan');
  const responseMessage = document.getElementById('response-message');
  const newPlanButtonText = document.getElementById('new-plan-button-text');

  if( newPlanButton ){
    newPlanButton.addEventListener('click',function(e){
      e.preventDefault();

      newPlanButtonText.innerHTML = 'Setting up plan...';
      responseMessage.innerHTML = 'One moment. We\'re setting up your new business plan...';

      const xhr = new XMLHttpRequest();
      xhr.open("POST", bpapi.endpoint + 'create', true);
      xhr.setRequestHeader('X-WP-Nonce', bpapi.nonce);
      xhr.onload = function () {
        console.log(xhr);
        if (xhr.status === 200) {
          let response = JSON.parse(xhr.response);
          // Update the button text with the incremented counter
          // Check if the responseMessage element exists before setting its innerHTML
          if (responseMessage) {
            responseMessage.innerHTML = '';
          }

          responseMessage.innerHTML = "Success! Your new plan is ready. Redirecting you, one moment...";
          setCookie('bpid', response.post_id, 1);
          setTimeout(() => {

             // Get the base URL dynamically and append the desired path
              const dynamicURL = window.location.origin + '/question/company-name/';
              // Redirect to the dynamic URL after a successful form submission
              window.location.href = dynamicURL;
          }, 500);
        } else {
          let response = JSON.parse(xhr.response);
          console.log('🛑 xhr = ', xhr);
          console.log('🛑 response = ', response);

          // Check if the responseMessage element exists before setting its innerHTML
          if (responseMessage) {
            responseMessage.innerHTML = response.message;
          }
        }
      };

      // Send the request with the current counter value as the title

      //  console.log('Sending request with data:', JSON.stringify());
      xhr.send();

    });
  }
});
/**
 * UPDATE Logic
 *
 * Handles the "updating" portion of our CRUD for Business Plan CPTs
 */
document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('bizplanner-form');

  if( form ){
    const submitButton = form.querySelector("#bizplanner-form button[type='submit']");
    const submitButtonText = form.querySelector("#bizplanner-form button[type='submit'] span");
    const responseMessage = document.getElementById("response-message");

    /**
     * Handles saving our form data.
     *
     * @param      {obj}  e       The event
     */
    function saveForm(e){
      if(e)
        e.preventDefault();

      // Get the form data as a FormData object
      const formData = new FormData(form);
      console.log('🔔 formData =', formData);

      responseMessage.innerHTML = '';

      // Disable the submit button and set its text to "Saving..."
      submitButton.disabled = true;
      submitButtonText.innerHTML = "Saving...";

      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Define the AJAX request method, URL, and async setting
      xhr.open("POST", bpapi.endpoint + 'update', true);
      xhr.setRequestHeader('X-WP-Nonce', bpapi.nonce);

      // Define a callback function to handle the response
      xhr.onload = function() {
        if (xhr.status === 200) {
          // The request was successful
          console.log("AJAX request successful!");
          console.log(xhr.responseText);
          // You can handle the response data here

          // Re-enable the submit button and set its text to "Saved"
          submitButton.disabled = false;
          submitButtonText.innerHTML = "Saved!";
          setTimeout( () => {
            submitButtonText.innerHTML = "Save";
          }, 1500 );
        } else {
          // The request encountered an error
          //console.error("AJAX request error:", xhr.status, xhr.statusText);
          let response = JSON.parse(xhr.response);
          console.log( '🛑 xhr = ', xhr );
          console.log( '🛑 response = ', response );

          // Re-enable the submit button and set its text to the original text
          submitButton.disabled = false;
          submitButtonText.innerHTML = "Not saved!";
          setTimeout( () => {
            submitButtonText.innerHTML = "Save";
          }, 1500 );
          responseMessage.innerHTML = response.message;
        }
      };

      // Send the form data as the request body
      xhr.send(formData);
    }
    form.addEventListener('submit', saveForm );

    /**
     * Auto-saves the form any time it loses focus.
     *
     * @param      {obj}  e       The event
     */
    function autoSave(e){
      saveForm();
    }
    form.addEventListener('blur', autoSave );

    /**
     * Allow saving form by pressing the ENTER key.
     *
     * @param      {obj}  e       The event
     */
    function handleKeyUp(e){
      if (e.keyCode === 13) {
        e.preventDefault();
        saveForm();
      }
    }
    //document.addEventListener('keyup', handleKeyUp);
  }


});
/**
 * Logic for our "View" and "Edit" buttons.
 */
document.addEventListener("DOMContentLoaded", function() {
  // Get all anchor tags with class .bizplan-link
  const bizplanLinks = document.querySelectorAll(".bizplan a.btn");

  // Add click event listener to each anchor tag
  bizplanLinks.forEach(function(link) {
    link.addEventListener("click", function(event) {
      // Prevent the default action of the anchor tag (e.g., navigating to a new page)
      event.preventDefault();

      // Get the parent div of the anchor tag
      //const parentDiv = link.parentElement;
      //const parentDiv = link.closest('div.bizplan-link');

      // Get the href of this link
      const href = this.getAttribute('href');

      // Check if the parent div has either class .view-business-plan or .edit-business-plan
      if (link.classList.contains("view-business-plan") || link.classList.contains("edit-business-plan")) {
        // Get the value of the "data-bpid" attribute
        const dataBpid = link.getAttribute("data-bpid");

        // Now you can use the value of dataBpid as needed
        console.log("🔔 data-bpid:", dataBpid);
        setCookie('bpid', dataBpid, 1);
        window.location.href = href;
      }
    });
  });
});
/**
 * Sets a cookie.
 *
 * @param      {string}  cookieName      The cookie name
 * @param      {string}  cookieValue     The cookie value
 * @param      {number}  expirationDays  The expiration days
 */
function setCookie(cookieName, cookieValue, expirationDays) {
    // Calculate the expiration date
    const d = new Date();
    d.setTime(d.getTime() + (expirationDays * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();

    // Set the cookie
    document.cookie = cookieName + "=" + cookieValue + ";" + expires + ";path=/";
}
// Usage example:
//setCookie("myCookie", "cookieValue", 365); // Set 'myCookie' with a value that expires in 365 days
/**
 * Login a user
 */
document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('bizplanner-login');
  //console.info( '🔔 login form = ', form );

  if( form ){
    const submitButton = form.querySelector("#bizplanner-login button[type='submit']");
    const responseMessage = form.querySelector("#bizplanner-login .response-message");

    form.addEventListener('submit', function(event){
      event.preventDefault();

      // Get the form data as a FormData object
      const formData = new FormData(form);

      // Disable the submit button and set its text to "Saving..."
      submitButton.disabled = true;
      submitButton.innerHTML = "One moment...";

      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Define the AJAX request method, URL, and async setting
      xhr.open("POST", bpapi.endpoint + 'login', true);
      xhr.setRequestHeader('X-WP-Nonce', bpapi.nonce);

      // Define a callback function to handle the response
      xhr.onload = function() {
        if (xhr.status === 200) {
          // The request was successful
          console.log("AJAX request successful!");
          console.log(xhr.responseText);
          let response = JSON.parse(xhr.responseText);
          // You can handle the response data here

          // Re-enable the submit button and set its text to "Saved"
          submitButton.disabled = false;
          console.log('response.data = ', response.data );
          responseMessage.style.display = 'block';
          responseMessage.innerHTML = response.message;
          responseMessage.classList = 'alert alert-success response-message fade show';
          setTimeout( () => {
            submitButton.innerHTML = "Redirecting...";
            window.location.href = response.data.redirect_url;
          }, 1500 );
        } else {
          // The request encountered an error
          let response = JSON.parse(xhr.response);

          // If we're showing consecutive error messages, add a delay:
          if( 'block' == responseMessage.style.display ){
            responseMessage.style.display = 'none';
            setTimeout(() => {
              // Re-enable the submit button and set its text to the original text
              submitButton.disabled = false;
              submitButton.innerHTML = "Log In";
              responseMessage.style.display = 'block';
              responseMessage.classList = 'alert alert-danger response-message fade show';
              responseMessage.innerHTML = response.message;
            }, 300 );
          } else {
            // Re-enable the submit button and set its text to the original text
            submitButton.disabled = false;
            submitButton.innerHTML = "Log In";

            responseMessage.style.display = 'block';
            responseMessage.classList = 'alert alert-danger response-message fade show';
            responseMessage.innerHTML = response.message;
          }
        }
      };

      // Send the form data as the request body
      xhr.send(formData);
    });
  }
});
/**
 * Register a User
 */
document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('bizplanner-register');
  //console.info( '🔔 register form = ', form );

  if( form ){
    const submitButton = form.querySelector("#bizplanner-register button[type='submit']");
    const responseMessage = form.querySelector("#bizplanner-register .response-message");

    form.addEventListener('submit', function(event){
      event.preventDefault();

      // Get the form data as a FormData object
      const formData = new FormData(form);

      // Disable the submit button and set its text to "Saving..."
      submitButton.disabled = true;
      submitButton.innerHTML = "One moment...";

      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Define the AJAX request method, URL, and async setting
      xhr.open("POST", bpapi.endpoint + 'register', true);
      xhr.setRequestHeader('X-WP-Nonce', bpapi.nonce);

      // Define a callback function to handle the response
      xhr.onload = function() {
        if (xhr.status === 200) {
          // The request was successful
          console.log("AJAX request successful!");
          console.log(xhr.responseText);
          let response = JSON.parse(xhr.responseText);
          // You can handle the response data here

          // Re-enable the submit button and set its text to "Saved"
          submitButton.disabled = false;
          console.log('response = ', response );
          if( 'block' == responseMessage.style.display )
            responseMessage.style.display = 'none';
          responseMessage.style.display = 'block';
          responseMessage.classList = 'alert alert-success response-message fade show';
          responseMessage.innerHTML = response.message;
          setTimeout( () => {
            submitButton.innerHTML = "Redirecting...";
            window.location.href = response.redirect_url;
          }, 1500 );
        } else {
          // The request encountered an error
          //console.error("AJAX request error:", xhr.status, xhr.statusText);
          let response = JSON.parse(xhr.response);
          console.log( '🛑 xhr = ', xhr );
          console.log( '🛑 response = ', response );

          // Re-enable the submit button and set its text to the original text
          submitButton.disabled = false;
          submitButton.innerHTML = "Register";

          // If we're showing consecutive error messages, add a delay:
          if( 'block' == responseMessage.style.display ){
            responseMessage.style.display = 'none';
            setTimeout(() => {
              responseMessage.style.display = 'block';
              responseMessage.classList = 'alert alert-danger response-message fade show';
              responseMessage.innerHTML = response.message;
            }, 300 );
          } else {
            responseMessage.style.display = 'block';
            responseMessage.classList = 'alert alert-danger response-message fade show';
            responseMessage.innerHTML = response.message;
          }
        }
      };

      // Send the form data as the request body
      xhr.send(formData);
    });
  }
});

/**
 * Avatar Selector
 */
// Get all the avatar options
const avatarOptions = document.querySelectorAll('#avatar-selector .avatar-option');
// Get the hidden form field
const selectedAvatarInput = document.getElementById('selectedavatar');
// Get the img element with id 'avatar'
const avatarImage = document.getElementById('avatar');

/**
 * Function to handle click event on avatar options
 *
 * @param      {obj}  event   The event
 */
function handleAvatarOptionClick(event) {
  // Remove .avatar-selected class from all avatar options
  avatarOptions.forEach(option => {
    option.classList.remove('avatar-selected');
  });

  // Add .avatar-selected class to the clicked avatar option
  const clickedAvatarOption = event.target;
  clickedAvatarOption.classList.add('avatar-selected');

  // Update the value of the hidden form field with data-bpavatar value
  const selectedAvatarValue = clickedAvatarOption.getAttribute('data-bpavatar');
  selectedAvatarInput.value = selectedAvatarValue;
  avatarImage.src = `${bpapi.themedir}lib/img/bizplanner-avatar_${selectedAvatarValue}.png`;
}
// Add click event listener to each avatar option
avatarOptions.forEach(option => {
  option.addEventListener('click', handleAvatarOptionClick);
});// Function to handle keydown event
function handleKeyUp(event) {
  const buttonDelay = 300; // milliseconds to wait before moving to the next/prev URL
  var focusedInput = document.querySelector('.form-control:focus');
  const previousBtn = document.getElementById('previous-question-btn');
  const nextBtn = document.getElementById('next-question-btn');

  // Check if the pressed key is the right arrow key (key code 39)
  if ( nextBtn && event.keyCode === 39 && ! focusedInput ) {
    nextBtn.classList.remove('btn-primary');
    nextBtn.classList.add('btn-selected', 'btn-primary-outline');
    window.setTimeout(function(){
      window.location.href = bpapi.next_question_url;
    },buttonDelay);
  }

  if( previousBtn && event.keyCode === 37 && ! focusedInput ) {
    previousBtn.classList.remove('btn-primary');
    previousBtn.classList.add('btn-selected', 'btn-primary-outline');
    window.setTimeout(function(){
      window.location.href = bpapi.previous_question_url;
    }, buttonDelay);
  }
}

// Add event listener to the document for the keydown event
document.addEventListener('keyup', handleKeyUp);
/**
 * Apply focus to first input element
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get the first input with class "form-control" inside the form with id "bizplanner-form"
    var firstInput = document.querySelector('form#bizplanner-form input.form-control');
    var firstTextarea = document.querySelector('form#bizplanner-form textarea.form-control');
    //var firstCheckInput = document.querySelector('form#bizplanner-form input.form-check-input');

    // Check if the input element is found before applying focus
    if (firstInput) {
        // Apply focus to the first input
        firstInput.focus();
    }

    // Check if the input element is found before applying focus
    if (firstTextarea) {
        // Apply focus to the first input
        firstTextarea.focus();
    }

    // Check if the input element is found before applying focus
    /*
    if (firstCheckInput) {
        // Apply focus to the first input
        firstCheckInput.focus();
    }
    */
});
