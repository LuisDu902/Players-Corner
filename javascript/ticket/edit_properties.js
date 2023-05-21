const editBtn = document.querySelector('#edit-btn')

if (editBtn){
    editBtn.addEventListener('click', editProperties)
}

async function editProperties(){

   
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
    const category = document.querySelector("#categories").value;
    const visibility = document.querySelector("#visibility").value;
    const priority = document.querySelector("#priorities").value;
    const status = document.querySelector("#stat").value;
    const tags = t_tags.join(',')
    const assignee = document.querySelector('#assignee').value
   
    const response = await fetch('../../api/api_ticket.php', {
        method: 'PUT',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: encodeForAjax({ticketId: ticketId, category: category, visibility: visibility, priority: priority, status: status, tags: tags, assignee: assignee}),
      })

    const ticket = response.json()
    console.log(ticket)
}