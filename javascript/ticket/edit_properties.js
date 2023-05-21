async function editProperties() {
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')
    const userId = document.querySelector('#ticket-page').getAttribute('data-user')
    const creator = document.querySelector('#ticket-page').getAttribute('data-creator')

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

    const res = document.querySelector('#respond')
    if (assignee == userId && !res) {
        const tkt = document.querySelector('#tkt')
        const getFaqs = await fetch('../api/api_search.php?' + encodeForAjax({ type: 'faqs', search: '' }))
        const faqs = await getFaqs.json()
        tkt.appendChild(createCommentBar(faqs))
    }
    else if (assignee != userId && userId != creator){
        if (res && (assignee != userId || status == 'closed'))
        res.remove()
    }
    

}

function createCommentBar(faqs) {
    const section = document.createElement('section');
    section.id = 'respond';

    const textarea = document.createElement('textarea');
    textarea.id = 'message-input';
    textarea.placeholder = 'Type your message...';
    textarea.rows = '1';

    const uploadButton = document.createElement('button');
    uploadButton.id = 'upload-button';
    uploadButton.classList.add('no-background');
    const uploadImg = document.createElement('img');
    uploadImg.src = '../images/icons/upload.png';
    uploadImg.alt = 'Send';
    uploadButton.appendChild(uploadImg);
    uploadButton.addEventListener('click', handleFileUpload)

    const sendButton = document.createElement('button');
    sendButton.id = 'send-button';
    sendButton.classList.add('no-background');
    const sendImg = document.createElement('img');
    sendImg.src = '../images/icons/send.png';
    sendImg.alt = 'Send';
    sendButton.addEventListener('click', addMessage)
    sendButton.appendChild(sendImg);

    section.appendChild(textarea);
    section.appendChild(uploadButton);
    section.appendChild(createFaqContainer(faqs))
    section.appendChild(sendButton);

    return section
}

function createFaqContainer(faqs) {
    const dropupDiv = document.createElement('div');
    dropupDiv.classList.add('dropup');

    const faqButton = document.createElement('button');
    faqButton.classList.add('faq-btn');
    faqButton.innerText = 'FAQ';

    const dropupContent = document.createElement('article');
    dropupContent.classList.add('dropup-content');

    const searchBox = document.createElement('section');
    searchBox.classList.add('search-box', 'center', 'round-border', 'white-border');

    const searchInput = document.createElement('input');
    searchInput.id = 'faq-bar';
    searchInput.type = 'text';
    searchInput.placeholder = 'search';

    const searchIcon = document.createElement('img');
    searchIcon.src = '../images/icons/search.png';

    searchBox.appendChild(searchInput);
    searchBox.appendChild(searchIcon);

    const faqItemsList = document.createElement('ul');
    faqItemsList.id = 'faq-items';
    faqItemsList.classList.add('center')

    for (const faq of faqs){
        const listItem = document.createElement('li');
        listItem.className = 'faq-title';
        listItem.dataset.id = faq.id;
        listItem.innerText = faq.problem;
        listItem.addEventListener('click', () => { answerWithFAQ(faq.Id) })
        faqItemsList.appendChild(listItem);
    }

    dropupContent.appendChild(searchBox);
    dropupContent.appendChild(faqItemsList);

    dropupDiv.appendChild(faqButton);
    dropupDiv.appendChild(dropupContent);
    showDropup(faqButton, dropupContent)
    return dropupDiv
}

function updateAgentSelect(status, assignee) {
    if (assignee != '0' || status != 'new') {
        const noAgent = document.querySelector(`#assignee option[value="0"]`)
        if (noAgent) noAgent.remove()
    }
}

function updateStatusSelect(new_status, agent) {
    const statusSelect = document.querySelector("#stat");
    statusSelect.innerHTML = ''

    if (new_status == 'assigned' || (new_status == 'new' && agent != '0')) {
        const assigned = document.createElement('option')
        assigned.value = 'assigned'
        assigned.textContent = 'assigned'
        assigned.selected = true
        statusSelect.appendChild(assigned)
    }
    const statuses = ["open", "solved", "closed"];

    for (const status of statuses) {
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
