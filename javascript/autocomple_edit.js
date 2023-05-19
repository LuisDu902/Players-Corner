
const tagInputs = document.querySelector('#tags-edit');

if (tagInputs) {
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')

    tags=get_ticket_tags(ticketId);

    async function get_ticket_tags(ticketId){
        const response1 = await fetch('../api/api_get_ticket_tags.php?' + encodeForAjax({id: ticketId}));
        const tagss = await response1.json() ;
        tags=await tagss;
        for(var i=0;i<tags.length;i++){
            const tagContainer = document.querySelector('#tag-container');
            const tagBlock = document.createElement('div');
            tagBlock.classList.add('tag-block');
    
            const tagName = document.createElement('span');
            tagName.textContent = tags[i];
            tagBlock.appendChild(tagName);
    
            const removeButton = document.createElement('button');
            removeButton.classList.add('remove-button');
            removeButton.textContent = 'x';
            removeButton.addEventListener('click', () => {
            const index = i;
                if (index !== -1) {
                    tags.splice(index, 1);
                }
                tagBlock.remove();
            });
            tagBlock.appendChild(removeButton);
    
            tagContainer.appendChild(tagBlock);
            
        }
        const tagsString = tags.join(',');
        const chosenTags = document.querySelector('#ticket_tags');
        chosenTags.value = tagsString;
        return tags;
    }
    
    
    tagInputs.addEventListener('input', (event) =>{
        get_tags(event,tags);
    });
    
    async function get_tags(event,tags) {
        console.log(tags);
        const datalist = document.querySelector('#taglist')
        datalist.innerHTML = ''
        const response = await fetch('../api/api_get_tags.php')
        const all_tags = await response.json()

        for (const tag of all_tags) {
            if (!tags.includes(tag)) {
                const option = document.createElement('option')
                option.value = tag
                datalist.appendChild(option)
            }
        }
        const value = event.target.value;

        if (document.querySelector(`#taglist option[value="${value}"]`)) {
            event.target.value = '';
            if (!tags.includes(value)) {
                tags.push(value);
                const tagContainer = document.querySelector('#tag-container');
                const tagBlock = document.createElement('div');
                tagBlock.classList.add('tag-block');

                const tagName = document.createElement('span');
                tagName.textContent = value;
                tagBlock.appendChild(tagName);

                const removeButton = document.createElement('button');
                removeButton.classList.add('remove-button');
                removeButton.textContent = 'x';
                removeButton.addEventListener('click', () => {
                    const index = tags.indexOf(value);
                    if (index !== -1) {
                        tags.splice(index, 1);
                    }
                    tagBlock.remove();
                });
                tagBlock.appendChild(removeButton);

                tagContainer.appendChild(tagBlock);
                event.target.blur();
            }
        }

        const tagsString = tags.join(',');
        const chosenTags = document.querySelector('#ticket_tags');
        chosenTags.value = tagsString;
    }
}

