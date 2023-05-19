
const depChange= document.querySelector("#sidebar");
if(depChange){
    const categorySelect = document.querySelector("#categories");
    
    categorySelect.addEventListener("change", (event )=>{
        clearMemberSelect(event.target.value);
    });

    }

async function clearMemberSelect(categoryValue) {
    const response = await fetch('../api/api_get_dept.php?' + encodeForAjax({category: categoryValue}));
    const department = await response.json();
    const assignee = document.querySelector("#as");
    assignee.innerHTML='';
    assignee.appendChild(changeMembers(department));
    
  }
  function changeMembers(department) {
    const label =document.createElement('label');
    label.innerHTML="Assignee: ";
    const select = document.createElement('select');
    for (var i = 0; i < department.members.length; i++) {
        var option = document.createElement('option');
        option.value = department.members[i].name;
        option.text = department.members[i].name;
        select.appendChild(option);
      }
    label.appendChild(select);
    return label;
  }