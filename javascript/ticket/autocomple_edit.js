t_tags=[];
const tagInputs = document.querySelector('#tags-edit');

if (tagInputs) {
    const ticketId = document.querySelector('#ticket-page').getAttribute('data-id')

 
    get_ticket_tags(ticketId);
    async function get_ticket_tags(ticketId){
        const datalist = document.querySelector('#taglist')
        const response1 = await fetch('../api/api_get_ticket_tags.php?' + encodeForAjax({id: ticketId}));
        const tagss = await response1.json() ;
        t_tags= await tagss;
        for(const tag of t_tags){
            const tagContainer = document.querySelector('#tag-container');
            const tagBlock = document.createElement('div');
            tagBlock.classList.add('tag-block');
    
            const tagName = document.createElement('span');
            tagName.textContent = tag;
            tagBlock.appendChild(tagName);
    
            const removeButton = document.createElement('button');
            removeButton.classList.add('remove-button');
            removeButton.textContent = 'x';
            removeButton.addEventListener('click', () => {
            const index = t_tags.indexOf(tag);
                if (index !== -1) {
                    t_tags.splice(index, 1);
                }
                tagBlock.remove();
                
            });
            tagBlock.appendChild(removeButton);
    
            tagContainer.appendChild(tagBlock);
            
        }
        const tagsString = t_tags.join(',');
        const chosenTags = document.querySelector('#ticket_tags');
        chosenTags.value = tagsString;
        get_ticket_tags=function(){};
    }
    
    
    tagInputs.addEventListener('input', (event) =>{
        get_edit_tags(event);
    });
    
    async function get_edit_tags(event) {
        const datalist = document.querySelector('#taglist')
        datalist.innerHTML = ''
        const response = await fetch('../../api/api_search.php?' + encodeForAjax({ type: 'tags' }))
        const all_tags = await response.json()

        for (const tag of all_tags) {
            if (!t_tags.includes(tag)) {
                const option = document.createElement('option')
                option.value = tag
                datalist.appendChild(option)
            }
        }

        const value = event.target.value;

        if (document.querySelector(`#taglist option[value="${value}"]`)) {
            event.target.value = '';
            if (!t_tags.includes(value)) {
                t_tags.push(value);
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
                const index = t_tags.indexOf(value);
                    if (index !== -1) {
                        t_tags.splice(index, 1);
                        const option = document.createElement('option')
                        option.value = value
                        datalist.appendChild(option)
                    }
                    tagBlock.remove();
                });
                tagBlock.appendChild(removeButton);

                tagContainer.appendChild(tagBlock);
                event.target.blur();
            }
        }

        const tagsString = t_tags.join(',');
        const chosenTags = document.querySelector('#ticket_tags');
        chosenTags.value = tagsString;
    }
}

