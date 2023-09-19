console.log( '🔔 bizplanner.js is loaded. bpapi = ', bpapi );

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
      xhr.open("POST", bpapi.endpoint, true);

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

  // Add a click event listener to the "edit-business-plan" button
  /*
  const editButton = document.querySelector(".edit-business-plan");

  if( editButton ){
    editButton.addEventListener("click", function( event ) {
      event.preventDefault();

      // Get the "bpid" data attribute value from the button
      const bpid = this.getAttribute("data-bpid");
      const href = this.getAttribute("href");

      // Check if the "bpid" value exists
      if (bpid) {
        // Set the "bpid" value as a cookie named "bpid"
        setCookie("bpid", bpid, 30); // Cookie expires in 30 days (adjust as needed)

        // You can optionally provide feedback to the user here
        console.log(`Cookie "bpid" set with value: ${bpid}`);
        console.log(`href = ${href}`);
        window.location.href = href;
      } else {
        console.error('Button does not have a "data-bpid" attribute.');
      }
    });
  }
  */

});

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

// Function to set a cookie
/*
function setCookie(name, value, days) {
  const expires = new Date();
  expires.setTime(expires.getTime() + days * 24 * 60 * 60 * 1000);
  document.cookie = `${name}=${value};expires=${expires.toUTCString()};path=/`;
}
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



