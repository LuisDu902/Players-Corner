const depChange = document.querySelector(".sidebar");

if (depChange) {
    const categorySelect = document.querySelector("#categories");

    categorySelect.addEventListener("change", (event) => {
        updateMemberSelect(event.target.value);
    });
}

async function updateMemberSelect(categoryValue) {
    const response = await fetch('../api/api_search.php?' + encodeForAjax({ type: 'members', category: categoryValue }));
    const members = await response.json();

    const creator = document.querySelector('#ticket-page').getAttribute('data-creator')
    const assigneeSelect = document.querySelector("#assignee");
    assigneeSelect.innerHTML = '';

    for (const member of members) {
        if (member.userId != creator) {
            const option = document.createElement('option')
            option.value = member.userId
            option.textContent = member.name
            assigneeSelect.appendChild(option);
        }
    }
}
