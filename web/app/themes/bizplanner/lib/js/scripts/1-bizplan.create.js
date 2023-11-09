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