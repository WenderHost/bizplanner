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
});