//console.log( '🔔 bizplanner.js is loaded. bpapi = ', bpapi );

/**
 * CREATE Logic
 *
 * Creates a new business plan
 */
document.addEventListener("DOMContentLoaded", function () {
  const container = document.getElementById('start-new-plan-container');
  if (container) {
    const link = document.getElementById('start-new-plan');
    const responseMessage = document.getElementById('response-message');
    if (link) {
      link.addEventListener('click', function (event) {
        event.preventDefault();

        const xhr = new XMLHttpRequest();
        link.innerHTML = "One moment. We're setting up your new business plan...";

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

            link.innerHTML = "Success! Your new plan is ready. Redirecting you, one moment...";
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
  }
});

// READ logic goes here:

/**
 * UPDATE Logic
 *
 * Handles the "updating" portion of our CRUD for Business Plan CPTs
 */
document.addEventListener("DOMContentLoaded", function(){
  const form = document.getElementById('bizplanner-form');
  console.info( '🔔 form = ', form );

  if( form ){
    const submitButton = form.querySelector("#bizplanner-form button[type='submit']");
    const submitButtonText = form.querySelector("#bizplanner-form button[type='submit'] span");
    const responseMessage = form.querySelector("#response-message");

    form.addEventListener('submit', function(event){
      event.preventDefault();

      // Get the form data as a FormData object
      const formData = new FormData(form);

      // Disable the submit button and set its text to "Saving..."
      submitButton.disabled = true;
      submitButtonText.innerHTML = "Saving...";

      // Create a new XMLHttpRequest object
      const xhr = new XMLHttpRequest();

      // Define the AJAX request method, URL, and async setting
      xhr.open("POST", bpapi.endpoint + 'update', true);

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
          responseMessage.innerHTML = response.message;
        }
      };

      // Send the form data as the request body
      xhr.send(formData);
    });
  }
});

// DELETE logic goes here

/**
 * Logic for our "View" and "Edit" buttons.
 */
document.addEventListener("DOMContentLoaded", function() {
  // Get all anchor tags with class .bizplan-link
  const bizplanLinks = document.querySelectorAll(".bizplan-link a.elementor-button");

  // Add click event listener to each anchor tag
  bizplanLinks.forEach(function(link) {
    link.addEventListener("click", function(event) {
      // Prevent the default action of the anchor tag (e.g., navigating to a new page)
      event.preventDefault();

      // Get the parent div of the anchor tag
      //const parentDiv = link.parentElement;
      const parentDiv = link.closest('div.bizplan-link');

      // Get the href of this link
      const href = this.getAttribute('href');

      // Check if the parent div has either class .view-business-plan or .edit-business-plan
      if (parentDiv.classList.contains("view-business-plan") || parentDiv.classList.contains("edit-business-plan")) {
        // Get the value of the "data-bpid" attribute
        const dataBpid = parentDiv.getAttribute("data-bpid");

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



