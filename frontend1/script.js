document.querySelectorAll('.sidebar-button').forEach(button => {
    button.addEventListener('click', function() {
      // Replace the content below with the functionality you want to trigger
      console.log('Button clicked:', this.textContent);
      // For example, load content related to the button into a main content area
    });
  });
  