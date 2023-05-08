
const tagInput = document.querySelector('#tags');
const tags = [];

tagInput.addEventListener('input', get_tags)

async function get_tags(event) {
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
    const chosenTags = document.querySelector('#chosen_tags');
    chosenTags.value = tagsString;
}