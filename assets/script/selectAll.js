document.getElementById("select-all").addEventListener('click', function() {
  if(this.checked) {
    document.querySelectorAll('input[type="checkbox"]').forEach(function(el) {
      el.checked = true;
    });
  } else {
    document.querySelectorAll('input[type="checkbox"]').forEach(function(el) {
      el.checked = false;
    });
  }
});
