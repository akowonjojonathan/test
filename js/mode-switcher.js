const modeSwitch = document.getElementById('mode-switch');
const body = document.body;

// Function to set the mode based on user preference
function setMode() {
  if (modeSwitch.checked || prefersDarkMode) {
    body.classList.add('dark-mode');
  } else {
    body.classList.remove('dark-mode');
  }
}

// Initial mode setting
setMode();

// Toggle mode when the switch is clicked
modeSwitch.addEventListener('change', () => {
  setMode();
});