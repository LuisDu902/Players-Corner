const tags = []

async function get_tags(event) {
  const datalist = document.querySelector('#taglist')
  datalist.innerHTML = ''
  const response = await fetch('../../api/api_search.php?' + encodeForAjax({ type: 'tags' }))
  const all_tags = await response.json()

  for (const tag of all_tags) {
    if (!tags.includes(tag)) {
      const option = document.createElement('option')
      option.value = tag
      datalist.appendChild(option)
    }
  }
  const value = event.target.value

  if (document.querySelector(`#taglist option[value="${value}"]`)) {
    event.target.value = ''
    if (!tags.includes(value)) {
      addTag(value)
  }
  const tagsString = tags.join(',')
  const chosenTags = document.querySelector('#chosen_tags')
  chosenTags.value = tagsString
}

function addTag(value) {
  tags.push(value)
  const tagContainer = document.querySelector('#tag-container')
  const tagBlock = document.createElement('div')
  tagBlock.classList.add('tag-block')

  const tagName = document.createElement('span')
  tagName.textContent = value
  tagBlock.appendChild(tagName)

  const removeButton = document.createElement('button')
  removeButton.classList.add('remove-button')
  removeButton.textContent = 'x'
  removeButton.addEventListener('click', () => {
    const index = tags.indexOf(value)
    if (index !== -1) { tags.splice(index, 1) }
    tagBlock.remove()
  })

  tagBlock.appendChild(removeButton)
  tagContainer.appendChild(tagBlock)
  event.target.blur()
  }
}

const tagInput = document.querySelector('#tags')

if (tagInput) {
    tagInput.addEventListener('input', get_tags)
}



/*Edit-ticket*/


async function get_remaining_tags(event) {
  const datalist = document.querySelector('#taglist1')
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
  const value = event.target.value

  if (document.querySelector(`#taglist1 option[value="${value}"]`)) {
    event.target.value = ''
    if (!t_tags.includes(value)) {
      addTag1(value)
  }
}
  const tagsString = t_tags.join(',')
  const chosenTags = document.querySelector('#ticket_tags')
  chosenTags.value = tagsString


  
function addTag1(value) {
  t_tags.push(value)
  const tagContainer = document.querySelector('#tag-container')
  const tagBlock = document.createElement('div')
  tagBlock.classList.add('tag-block')

  const tagName = document.createElement('span')
  tagName.textContent = value
  tagBlock.appendChild(tagName)

  const removeButton = document.createElement('button')
  removeButton.classList.add('remove-button')
  removeButton.textContent = 'x'
  removeButton.addEventListener('click', removeTag)
  tagBlock.appendChild(removeButton)
  tagContainer.appendChild(tagBlock)
  event.target.blur()
  }
}






const t_tags=[];
const tagInputs = document.querySelector('#tags-edit');

if (tagInputs) {
  const currentTags = document.querySelectorAll('.tag-block span')
  
  for (const tag of currentTags){
    t_tags.push(tag.textContent)
  }
  const tagsString = t_tags.join(',')
  const chosenTags = document.querySelector('#ticket_tags')
  chosenTags.value = tagsString
  

  const buttons = document.querySelectorAll('.tag-block button')

  for (const button of buttons){
    button.addEventListener('click', removeTag)
  }

  tagInputs.addEventListener('input', get_remaining_tags)

}


function removeTag(event){
  
    const tagBlock = event.target.closest('.tag-block')
    const value = tagBlock.querySelector('span').textContent
    const index = t_tags.indexOf(value)
    if (index !== -1) { t_tags.splice(index, 1) }
    tagBlock.remove()
  
}