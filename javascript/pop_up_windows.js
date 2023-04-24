
var upgradeModals = document.querySelectorAll(".upgrade-modal");

if (upgradeModals) {
  var upgradeButtons = document.querySelectorAll(".upgrade");
  
  for (var i = 0; i < upgradeModals.length; i++) {
    
    console.log(i);
    console.log(upgradeButtons.length)
    console.log(upgradeModals.length)
   
    var upgradeButton = upgradeButtons[i];

    console.log(upgradeButton)
    console.log(upgradeModals[i])


    upgradeButton.addEventListener('click', function () {

      var upgradeModal = upgradeModals[0];
     if(upgradeModal){
        upgradeModal.style.display = "block";
      }
    });

    window.addEventListener('click', function (event) { 
      var upgradeModal = upgradeModals[0];
      if (event.target == upgradeModal) {
        upgradeModal.style.display = "none";
      }
    });

  }
}


/*
var assignModals = document.querySelectorAll(".assign-modal");


if (assignModals) {
  var assignButtons = document.querySelectorAll(".assign");
  
  for (var i = 0; i < assignModals.length; i++) {
    
    var assignButton = assignButtons[i];

    assignButton.addEventListener('click', function () {
      var assignModal = assignModals[0];
     if(assignModal){
      assignModal.style.display = "block";
      }
    });

    window.addEventListener('click', function (event) { 
      var assignModal = assignModals[0];
      if (event.target == assignModal) {
        assignModal.style.display = "none";
      }
    });

  }
}*/


var departmentModal = document.querySelector("#department-modal");

if (departmentModal) {
  var addButton = document.querySelector("#add-department");
  
  addButton.addEventListener('click', function () {
    departmentModal.style.display = "block";
  });

  window.addEventListener('click', function (event) {
    if (event.target == departmentModal) {
      departmentModal.style.display = "none";
    }
  });

}