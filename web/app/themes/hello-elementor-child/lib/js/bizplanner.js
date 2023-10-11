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
document.addEventListener("DOMContentLoaded", function () {
  const userInformation = document.getElementById('user-information');

  // Check if the "user-information" element exists
  if (userInformation) {
    // Fetch user information using the WordPress REST API
    fetch(bpapi.endpoint + 'read', {
      method: 'GET',
      headers: {
        'X-WP-Nonce': bpapi.nonce
      }
    })
    .then(response => {
      if (response.status === 200) {
        return response.json();
      } else {
        throw new Error('Failed to fetch user information');
      }
    })
    .then(data => {
      // Check if business_plans array exists in the response
      if (data.business_plans && Array.isArray(data.business_plans)) {
        // Clear the userInformation element
        userInformation.innerHTML = '';

        // Create an HTML list to display the business plan details
        const ul = document.createElement('ul');
        ul.classList.add('business-plan-container');
        data.business_plans.forEach(plan => {
          // Check if business plan has ACF values
          if (plan.acf) {
            // Create an outer list item for each business plan
            const li = document.createElement('li');
             li.classList.add('business-plan-wrap');
            // Display the post title for this business plan
            const title = document.createElement('h2');
            title.textContent = plan.post_title;
            li.appendChild(title);

            // Check and add ACF values as needed
            if (plan.acf.company_name) {
              const companyInfo = document.createElement('p');
              companyInfo.textContent = `Name: ${plan.acf.company_name}`;
              li.appendChild(companyInfo);
            }

            if (plan.acf.product) {
              const productInfo = document.createElement('p');
              productInfo.textContent = `Product: ${plan.acf.product}`;
              li.appendChild(productInfo);
            }

            if (plan.acf.product_description) {
              const productDescriptionInfo = document.createElement('p');
              productDescriptionInfo.textContent = `Description: ${plan.acf.product_description}`;
              li.appendChild(productDescriptionInfo);
            }

            // Check and add customer information within a nested list
            if (plan.acf.customers) {
              const customersArray = plan.acf.customers;

              if (customersArray.length > 0) {
                const customerList = document.createElement('ul');

                customersArray.forEach((customer) => {
                  if (customer.name) {
                    const customerLi = document.createElement('li');
                    customerLi.textContent = customer.name;
                    customerList.appendChild(customerLi);
                  }
                });

                const customersTitle = document.createElement('p');
                customersTitle.textContent = 'Customers:';
                li.appendChild(customersTitle);
                li.appendChild(customerList);
              }
            }
            // PRODUCT PRICE
          if (plan.acf.product_price) {
              const productPrice = document.createElement('p');
              productPrice.textContent = `Product Price: ${plan.acf.product_price}`;
              li.appendChild(productPrice);
            }

            if (plan.acf.marketing_methods) {
              const marketing_methodsArray = plan.acf.marketing_methods;

              if (marketing_methodsArray.length > 0) {
                const marketing_methodList = document.createElement('ul');

                marketing_methodsArray.forEach((marketing_method) => {
                  if (marketing_method.name) {
                    const marketing_methodLi = document.createElement('li');
                    //console.log(marketing_methodsArray);
                    marketing_methodLi.textContent = marketing_method.name;
                    marketing_methodList.appendChild(marketing_methodLi);
                  }
                });

                const marketing_methodsTitle = document.createElement('p');
                marketing_methodsTitle.textContent = 'Marketing Method:';
                li.appendChild(marketing_methodsTitle);
                li.appendChild(marketing_methodList);
              }
            }

        // For management team
        if (plan.acf.management_team) {
          const management_teamArray = plan.acf.management_team;

          if (management_teamArray.length > 0) {
            const management_teamList = document.createElement('ul');

            management_teamArray.forEach((manager) => {
              if (manager.name) {
                const managerLi = document.createElement('li');
                managerLi.textContent = manager.name;
                management_teamList.appendChild(managerLi);
              }
            });

            const management_teamTitle = document.createElement('p');
            management_teamTitle.textContent = 'Management Team:';
            li.appendChild(management_teamTitle);
            li.appendChild(management_teamList);
          }
        }

          if (plan.acf.sales_and_marketing_team) {
            const sales_and_marketing_teamArray = plan.acf.sales_and_marketing_team;

            if (sales_and_marketing_teamArray.length > 0) {
              const sales_and_marketing_teamList = document.createElement('ul');

              sales_and_marketing_teamArray.forEach((teamMember) => {
                if (teamMember.name) {
                  const teamMemberLi = document.createElement('li');
                  teamMemberLi.textContent = teamMember.name;
                  sales_and_marketing_teamList.appendChild(teamMemberLi);
                }
              });

              const sales_and_marketing_teamTitle = document.createElement('p');
              sales_and_marketing_teamTitle.textContent = 'Sales and Marketing Team:';
              li.appendChild(sales_and_marketing_teamTitle);
              li.appendChild(sales_and_marketing_teamList);
            }
          }
 


            // Append the populated 'li' to the main list ('ul')
            ul.appendChild(li);
          }
        });

        // Append the list to the "user-information" element
        userInformation.appendChild(ul);
      } else {
        userInformation.innerHTML = 'No business plans found for the current user.';
      }
    })
    .catch(error => {
      console.error('Error:', error);
      userInformation.innerHTML = 'Error: Unable to fetch user information.';
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
// 
document.addEventListener("DOMContentLoaded", function () {
    const deleteButtons = document.querySelectorAll('.delete-business-plan .elementor-button'); // Select all delete buttons by their class
    
    deleteButtons.forEach(function (deleteButton) {
        deleteButton.addEventListener('click', function (event) {
            event.preventDefault();

          //  alert('delete-business-plan');
            
            // Get the business plan ID from the data attribute
            const bpid = deleteButton.closest('.delete-business-plan').getAttribute('data-bpid');
            
            if (!bpid) {
                console.error('Business plan ID not found.');
                return;
            }
            
            // Use a confirmation dialog
            const confirmation = confirm('Are you sure you want to delete this business plan?');
            
            if (confirmation) {
                // User clicked "Yes," proceed with the deletion
                
                const nonce = wpApiSettings.nonce;
                
                const xhr = new XMLHttpRequest();
                deleteButton.innerHTML = "Deleting...";
                
                xhr.open("DELETE", bpapi.endpoint + 'delete/' + bpid, true);
                xhr.setRequestHeader('X-WP-Nonce', nonce);
                
                xhr.onload = function () {
                    if (xhr.status === 200) {
                        // Display the success message
                        const responseMessage = document.querySelector("#response-message");
                        if (responseMessage) {
                            responseMessage.innerHTML = 'Business plan deleted successfully.';
                        }
                        
                        // Refresh the page after deletion
                              setTimeout( () => {
                                location.reload();
                            }, 1500 );
                      
                    } else {
                        let response = JSON.parse(xhr.response);
                        console.error('🛑 xhr = ', xhr);
                        console.error('🛑 response = ', response);
                        
                        // Handle error and display the error message
                        const responseMessage = document.querySelector("#response-message");
                        if (responseMessage) {
                            responseMessage.innerHTML = response.message;
                        }
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



