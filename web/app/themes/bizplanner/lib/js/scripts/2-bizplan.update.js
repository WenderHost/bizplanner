
/**
 * UPDATE Logic
 *
 * Handles the "updating" portion of our CRUD for Business Plan CPTs
 */
document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('bizplanner-form');
  const btnNextPrev = document.querySelectorAll('a.btn-nextprev');

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
    btnNextPrev.forEach( (btn) => {
      console.info('btn.href', btn.href);
      var href = btn.href;
      btn.addEventListener('click', (e) => {
        e.preventDefault();
        btn.disabled = true;
        btn.innerHTML = 'Saving... One moment.';
        console.info('this =', this );
        saveForm();
        setTimeout( () => {
          window.location.href = href;
        }, 2000);
      });
    });

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