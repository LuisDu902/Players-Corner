const faq_page = document.querySelector('#faq-page');
const loadButton = document.querySelector('.load-more');
const loadBorder = document.querySelector('#load');
let faqs = [];
let number = 5;

if (faq_page) {
  getFAQs();
}

async function getFAQs() {
  const response = await fetch('../api/api_get_faqs.php?');
  faqs = await response.json();
  displayFaqs(faqs, number);
}

function displayFaqs(faqs, number) {

  let end = number;
  let faqItems = faqs.slice(0, end);
  const section = document.querySelector('#faq-list');
  section.innerHTML = '';

  for (const faq of faqItems) {
    const faqCard = createFAQ(faq);
    section.appendChild(faqCard);
  }
}

function createFAQ(faq) {
  const faqItem = document.createElement('li');
  faqItem.classList.add('faq-item');

  const inputElement = document.createElement('input');
  inputElement.id = 'cb' + faq.id;
  inputElement.type = 'checkbox';
  inputElement.classList.add('faq-item-checkbox');
  faqItem.appendChild(inputElement);

  const labelElement = document.createElement('label');
  labelElement.classList.add('faq-item-header');
  labelElement.setAttribute('for', 'cb' + faq.id);

  const spanElement = document.createElement('span');
  spanElement.classList.add('faq-title');
  spanElement.textContent = faq.problem;
  labelElement.appendChild(spanElement);

  const divElement = document.createElement('div');
  divElement.classList.add('faq-icons');

  const addIcon = document.createElement('ion-icon');
  addIcon.setAttribute('name', 'add-outline');
  divElement.appendChild(addIcon);

  const removeIcon = document.createElement('ion-icon');
  removeIcon.setAttribute('name', 'remove-outline');
  divElement.appendChild(removeIcon);
  const userRole = faq_page.getAttribute('data-role');
  if (userRole === "admin") {
    const deleteForm = document.createElement('form');
    deleteForm.action = '../actions/faq_actions/action_delete_faq.php';
    deleteForm.method = 'post';
    deleteForm.onsubmit = function () {
      return confirm('Are you sure you want to delete this FAQ?');
    };

    const faqIdInput = document.createElement('input');
    faqIdInput.type = 'hidden';
    faqIdInput.name = 'id';
    faqIdInput.value = faq.id;

    const token = document.createElement('input');
    token.type = 'hidden';
    token.name = 'csrf';
    token.value = document.querySelector('body').getAttribute('data-csrf');

    const deleteButton = document.createElement('button');
    deleteButton.type = 'submit';
    deleteButton.classList.add('trash-button');

    const trashIcon = document.createElement('ion-icon');
    trashIcon.setAttribute('name', 'trash-outline');
    trashIcon.classList.add('buzz-out-on-hover');

    deleteButton.appendChild(trashIcon);
    deleteForm.appendChild(faqIdInput);
    deleteForm.appendChild(deleteButton);
    deleteForm.appendChild(token);
    divElement.appendChild(deleteForm);
  }

  labelElement.appendChild(divElement);
  faqItem.appendChild(labelElement);

  const answerElement = document.createElement('div');
  answerElement.classList.add('faq-item-answer');

  const answerParagraph = document.createElement('p');
  answerParagraph.textContent = faq.answer;

  answerElement.appendChild(answerParagraph);
  faqItem.appendChild(answerElement);

  return faqItem;
}


if (loadButton) {
  loadButton.addEventListener('click', () => {
    console.log('Number:', number);
    console.log('FAQs Length:', faqs.length);

    number += 5;

    displayFaqs(faqs, number);

    if (number >= faqs.length) {
      console.log('No more FAQs');
      loadButton.setAttribute('hidden', 'true');
      loadBorder.setAttribute('hidden', 'true');
    }
  });
}

