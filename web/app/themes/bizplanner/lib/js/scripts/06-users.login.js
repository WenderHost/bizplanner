
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
