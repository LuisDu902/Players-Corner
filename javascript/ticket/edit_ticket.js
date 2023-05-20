
const ticketEdit= document.querySelector(".sidebar-content");

if(ticketEdit){
    const ticketButton=document.querySelector("#edit-btn");
    ticketButton.addEventListener('click', submitTicket);
}

async function submitTicket(){
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
    const newcategory= document.querySelector("#categories").value;
    const newvisibility=document.querySelector("#visibility").value;
    const newpriority=document.querySelector("#priorities").value;
    const newstatus=document.querySelector("#stat").value;
    const newtags=JSON.stringify(t_tags);
    const newassignee= current;
    const response = await fetch('../api/api_edit_ticket.php?' + encodeForAjax({id: ticketId, tags: newtags,category: newcategory, priority: newpriority, status: newstatus , visibility: newvisibility, replierName: newassignee}));
    const result = await response.json();
    console.log(result);

}