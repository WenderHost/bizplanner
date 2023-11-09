// Get the input[type="range"] element
const rangeInput = document.querySelector('input[type="range"]');

// Get the element where you want to display the updated value
const output = document.getElementById('range-value'); // Replace 'output' with the actual ID of your output element

// Function to update the value when the range input changes
function updateRangeValue() {
  // Get the current value of the range input
  const value = rangeInput.value;
  
  // Update the output element with the current value
  output.textContent = value;
}

// Add input event listener to the range input
if( rangeInput )
  rangeInput.addEventListener('input', updateRangeValue);
