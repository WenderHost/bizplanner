// Function to handle keydown event
function handleKeyUp(event) {
  const buttonDelay = 300; // milliseconds to wait before moving to the next/prev URL
  var focusedInput = document.querySelector('.form-control:focus');
  const previousBtn = document.getElementById('previous-question-btn');
  const nextBtn = document.getElementById('next-question-btn');

  // Check if the pressed key is the right arrow key (key code 39)
  if ( nextBtn && event.keyCode === 39 && ! focusedInput ) {
    nextBtn.classList.remove('btn-primary');
    nextBtn.classList.add('btn-selected', 'btn-primary-outline');
    window.setTimeout(function(){
      window.location.href = bpapi.next_question_url;
    },buttonDelay);
  }

  if( previousBtn && event.keyCode === 37 && ! focusedInput ) {
    previousBtn.classList.remove('btn-primary');
    previousBtn.classList.add('btn-selected', 'btn-primary-outline');
    window.setTimeout(function(){
      window.location.href = bpapi.previous_question_url;
    }, buttonDelay);
  }
}

// Add event listener to the document for the keydown event
document.addEventListener('keyup', handleKeyUp);
