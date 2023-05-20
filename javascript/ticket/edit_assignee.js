
const depChange= document.querySelector(".sidebar-content");
current=document.querySelector("#assignee").value;
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
    assignee.appendChild(changeMembers(department,current));
    
  }
  function changeMembers(department,current) {
    belongs=false;
    const label =document.createElement('label');
    label.innerHTML="Assignee: ";
    const select = document.createElement('select');
    for (var i = 0; i < department.members.length; i++) {
        var option = document.createElement('option');
        option.value = department.members[i].userId;
        if(option.value==current){
          option.selected=true;
          belongs=true;
        }
        else{
          if(!belongs){
          current=department.members[0].name;}
        }
        option.text = department.members[i].name;
        select.appendChild(option);
      }
    
    label.appendChild(select);
    return label;
  }

if(depChange){
  const assigned = document.querySelector("#assignee");
    
    assigned.addEventListener("change", ()=>{
        current='';
        current=assigned.value;
    });
}