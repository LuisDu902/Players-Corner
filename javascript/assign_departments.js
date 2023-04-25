var assign = document.querySelector("#assign-departments");

if (assign) {
  var images = document.querySelectorAll("#department img");

  for (const image of images){
    image.addEventListener('click', function(e) {
        image.classList.toggle('selected')
    })
  }
}

var assignButton = document.querySelector("#assign-button");

if (assignButton){

assignButton.addEventListener('click', function(e) {
    
  var selectedDepartments = document.querySelectorAll("#department img.selected");
  
  var selectedDepartmentsArray = [];
 
  for (const department of selectedDepartments){
    var parent = department.parentElement
    var category = parent.querySelector("span").textContent
    selectedDepartmentsArray.push(category);
  }

  var selectedDepartmentsInput = document.querySelector("#selected-departments");
  selectedDepartmentsInput.value = selectedDepartmentsArray.join(',');

  this.form.submit();
});}