let dropdowns = document.querySelectorAll('.drop-down');
dropdowns.forEach(function (dropdown) {
    let submenu = dropdown.querySelector('.submenu'),
        dropdownBtn = dropdown.querySelector('.drop-down-btn')
    dropdown.addEventListener('click', function () {
        submenu.classList.add('active');
        dropdownBtn.style.display = 'none';
    })
})