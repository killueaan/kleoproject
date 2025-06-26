let faq = document.querySelector('.faq-section');
faq.addEventListener('click', function (e) {
    let targetItem = e.target.closest('.faq-summary');
    if (!targetItem) return;
    let currentText = targetItem.nextElementSibling;
    targetItem.classList.toggle('active');
    if (targetItem.classList.contains('active')) {
        currentText.style.maxHeight = currentText.scrollHeight + 'px';
    } else {
        currentText.style.maxHeight = 0;
    }
})