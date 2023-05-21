async function editProperties() {
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
    const category = document.querySelector("#categories").value;
    const visibility = document.querySelector("#visibility").value;
    const priority = document.querySelector("#priorities").value;
    const status = document.querySelector("#stat").value;
    const tags = t_tags.join(',')
    const assignee = document.querySelector('#assignee').value

    if (assignee == '0' && status != 'new') return

    const response = await fetch('../../api/api_ticket.php', {
        method: 'PUT',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: encodeForAjax({ ticketId: ticketId, category: category, visibility: visibility, priority: priority, status: status, tags: tags, assignee: assignee }),
    })

    const lastChange = await response.json()
    const ticketHistory = document.querySelector('#history ol')

    ticketHistory.appendChild(createChange(lastChange))
    updateStatusSelect(status, assignee)
    updateAgentSelect(status, assignee)
}

function updateAgentSelect(status, assignee){
    if (assignee != '0' || status != 'new'){
        const noAgent = document.querySelector(`#assignee option[value="0"]`)
        noAgent.remove()
    }
}

function updateStatusSelect(new_status, agent){
    const statusSelect = document.querySelector("#stat");
    statusSelect.innerHTML = ''

    if (new_status == 'assigned' || (new_status == 'new' && agent != '0')){
        const assigned = document.createElement('option')
        assigned.value = 'assigned'
        assigned.textContent = 'assigned'
        assigned.selected = true
        statusSelect.appendChild(assigned)
    }
    const statuses = ["open", "solved", "closed"];
    
    for (const status of statuses){
        const option = document.createElement('option')
        option.value = status
        option.textContent = status
        if (status == new_status) option.selected = true
        statusSelect.appendChild(option)
    }

}

function createChange(change) {
    const historyCard = document.createElement('li')
    historyCard.classList.add('card-history')

    const title = document.createElement('h3')
    title.classList.add('title-history')
    title.textContent = change[0].date

    const wrapper = document.createElement('div')
    wrapper.classList.add('vert-flex')
    wrapper.textContent = change[0].user.name

    const changes = document.createElement('ul')
    changes.classList.add('ticket-changes')

    for (const field of change) {
        const item = document.createElement('li')
        if (field.old_field == '') {
            item.textContent = field.changes
        } else {
            item.textContent = field.changes + ' : ' + field.old_field + ' >>> ' + field.new_field
        }
        changes.appendChild(item)
    }
    wrapper.appendChild(changes)
    historyCard.appendChild(title)
    historyCard.appendChild(wrapper)
    return historyCard
}

const editBtn = document.querySelector('#edit-btn')

if (editBtn) {
    editBtn.addEventListener('click', editProperties)
}
