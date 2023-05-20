const searchFaq = document.querySelector('#faq-bar')

if (searchFaq) {
    searchFaq.addEventListener('input', () => {
        searchFaqs(searchFaq.value)
    })
}


async function searchFaqs(value) {
    const response = await fetch('../api/api_search.php?' + encodeForAjax({ type: 'faqs', search: value}))
    const faqs = await response.json()

    const sector = document.querySelector('#faq-items')
    sector.innerHTML = ''
    for (const faq of faqs){
        const problem = document.createElement('li')
        problem.setAttribute('data-id', faq.id)
        problem.classList.add('faq-title')
        problem.textContent = faq.problem
        sector.appendChild(problem)
        problem.addEventListener('click', () => {answerWithFAQ(faq.id)})
    }
}
