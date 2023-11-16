/**
 * Apply focus to first input element
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get the first input with class "form-control" inside the form with id "bizplanner-form"
    var firstInput = document.querySelector('form#bizplanner-form input.form-control');
    var firstTextarea = document.querySelector('form#bizplanner-form textarea.form-control');
    //var firstCheckInput = document.querySelector('form#bizplanner-form input.form-check-input');

    // Check if the input element is found before applying focus
    if (firstInput) {
        // Apply focus to the first input
        firstInput.focus();
    }

    // Check if the input element is found before applying focus
    if (firstTextarea) {
        // Apply focus to the first input
        firstTextarea.focus();
    }

    // Check if the input element is found before applying focus
    /*
    if (firstCheckInput) {
        // Apply focus to the first input
        firstCheckInput.focus();
    }
    */
});
