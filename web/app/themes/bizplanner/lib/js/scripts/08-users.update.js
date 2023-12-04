document.addEventListener("DOMContentLoaded", function(){
  //const form = document.getElementById('bizplanner-user-update');
  // Code for update a user goes here...
  const form = document.getElementById('bizplanner-user-update');
  const responseMessage = form.querySelector(".response-message");
  const submitButton = form.querySelector("button[type='submit']");

  if (form) {
    form.addEventListener('submit', function(event) {
      event.preventDefault();

      const formData = new FormData(form);

      submitButton.disabled = true;
      submitButton.innerHTML = "Updating...";

      const xhr = new XMLHttpRequest();
      xhr.open("POST", bpapi.endpoint + 'updateuser', true);
      xhr.setRequestHeader('X-WP-Nonce', bpapi.nonce);

      xhr.onload = function() {
        if (xhr.status === 200) {
          const response = JSON.parse(xhr.responseText);

          submitButton.disabled = false;
          submitButton.innerHTML = "Updated";

          if (responseMessage.style.display === 'block') {
            responseMessage.style.display = 'none';
            setTimeout(() => {
              responseMessage.style.display = 'block';
              responseMessage.classList = 'alert alert-success response-message fade show';
              responseMessage.innerHTML = response.message;
            }, 300);
          } else {
            responseMessage.style.display = 'block';
            responseMessage.classList = 'alert alert-success response-message fade show';
            responseMessage.innerHTML = response.message;
          }
          submitButton.innerHTML = "Update";
          setTimeout( () => {
            window.location.reload();
          },1500);
        } else {
          const response = JSON.parse(xhr.response);

          submitButton.disabled = false;
          submitButton.innerHTML = "Update";

          if (responseMessage.style.display === 'block') {
            responseMessage.style.display = 'none';
            setTimeout(() => {
              responseMessage.style.display = 'block';
              responseMessage.classList = 'alert alert-danger response-message fade show';
              responseMessage.innerHTML = response.message;
            }, 300);
          } else {
            responseMessage.style.display = 'block';
            responseMessage.classList = 'alert alert-danger response-message fade show';
            responseMessage.innerHTML = response.message;
          }
        }
      };

      xhr.send(formData);
    });
  }

});