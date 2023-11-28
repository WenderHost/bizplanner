
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