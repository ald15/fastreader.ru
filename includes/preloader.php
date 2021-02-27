<div class="d-flex justify-content-center spinnerBlock">

  <script>

    window.onload = function () {
      document.body.classList.add('hideSpinner');

      window.setTimeout(function () {
         document.getElementsByClassName('spinnerBlock')[0].outerHTML = '';
       }, 500);

    }
    
  </script>

  <div class="spinner-border  border-orange" role="status">
    <span class="sr-only">Loading...</span>
  </div>
</div>
