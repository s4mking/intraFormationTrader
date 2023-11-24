document.querySelector('#removeOperations').addEventListener("click", function(){
  var array = []
  var checkboxes = document.querySelectorAll('input[type=checkbox]:checked')

  for (var i = 0; i < checkboxes.length; i++) {
    array.push(checkboxes[i].id)
  }

  let urlCallAjax = location.protocol + '//' + location.host + '/operation/removeoperations';
// Making our request
  fetch(urlCallAjax, { method: 'POST', body: JSON.stringify(array) })
    .then(Result => Result.json())
    .then(string => {

      // Printing our response
      window.location.reload()
    })
    .catch(errorMsg => { console.log(errorMsg); });
});
