/**
 * DELETE Logic
 *
 * DELETE a new business plan
 */
document.addEventListener("DOMContentLoaded", function () {
  const deleteButtons = document.querySelectorAll('.bizplan a.delete-business-plan'); // Select all delete buttons by their class

  deleteButtons.forEach(function (deleteButton) {
    deleteButton.addEventListener('click', function (event) {
      event.preventDefault();

      // Get the business plan ID from the data attribute
      //const bpid = deleteButton.closest('.delete-business-plan').getAttribute('data-bpid');
      let bpid = this.getAttribute('data-bpid');
      console.log(`🔔 bpid = ${bpid}`);

      if (!bpid) {
        console.error('Business plan ID not found.');
        return;
      }

      // Use a confirmation dialog
      const confirmation = confirm('Are you sure you want to delete this business plan?');

      if (confirmation) {
        // User clicked "Yes," proceed with the deletion
        const xhr = new XMLHttpRequest();
        //deleteButton.innerHTML = "Deleting...";

        xhr.open("DELETE", bpapi.endpoint + 'delete/' + bpid, true);
        xhr.setRequestHeader('X-WP-Nonce', bpapi.nonce);

        xhr.onload = function () {
          if (xhr.status === 200) {
            // Refresh the page after deletion
            location.reload();
            /*
            setTimeout( () => {
              location.reload();
            }, 500 );
            */
          } else {
            let response = JSON.parse(xhr.response);
            console.error('🛑 xhr = ', xhr);
            console.error('🛑 response = ', response);
          }
        };

        // Send the delete request
        xhr.send();
      } else {
          // User clicked "No," do nothing
      }
    });
  });
});