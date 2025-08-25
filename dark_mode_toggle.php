
<button id="darkModeToggle" class="btn" style="float:right; margin-top:-10px;">🌙 Toggle Dark Mode</button>
<script>
  // Check for saved mode in localStorage
  if (localStorage.getItem('darkMode') === 'enabled') {
    document.body.classList.add('dark-mode');
  }
  document.getElementById('darkModeToggle').onclick = function() {
    document.body.classList.toggle('dark-mode');
    // Save preference
    if(document.body.classList.contains('dark-mode')) {
      localStorage.setItem('darkMode', 'enabled');
    } else {
      localStorage.setItem('darkMode', 'disabled');
    }
  }
</script>