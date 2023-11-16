// Function to handle keydown event
function handleKeyUp(event) {
  const buttonDelay = 300; // milliseconds to wait before moving to the next/prev URL
  var focusedInput = document.querySelector('.form-control:focus');

  // Check if the pressed key is the right arrow key (key code 39)
  if (event.keyCode === 39 && ! focusedInput ) {
    const nextBtn = document.getElementById('next-question-btn');
    nextBtn.classList.remove('btn-primary');
    nextBtn.classList.add('btn-selected', 'btn-primary-outline');
    window.setTimeout(function(){
      window.location.href = bpapi.next_question_url;
    },buttonDelay);
  }

  if(event.keyCode === 37 && ! focusedInput ) {
    const previousBtn = document.getElementById('previous-question-btn');
    previousBtn.classList.remove('btn-primary');
    previousBtn.classList.add('btn-selected', 'btn-primary-outline');
    window.setTimeout(function(){
      window.location.href = bpapi.previous_question_url;
    }, buttonDelay);
  }
}

// Add event listener to the document for the keydown event
document.addEventListener('keyup', handleKeyUp);
