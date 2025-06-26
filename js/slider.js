"use strict";

let slider = document.querySelector('.slider-body');
let sliderItems = Array.from(document.querySelectorAll('.slider-item'));
let content = document.querySelector('.slider-content');



function scrollSlider(index) {
    content.style.transform = `translateX(${index * -(290 + 50)}px)`;
}

let sliderNav = document.querySelector('.slider-nav');
let sliderDots = Array.from(document.querySelectorAll('.dot'));

sliderNav.addEventListener('click', function (e) {
    let targetDot = e.target.closest('.dot');
    if (!targetDot) return;
    if (targetDot.classList.contains('active')) return;
    document.querySelector('.dot.active').classList.remove('active');
    document.querySelector('.slider-item.active').classList.remove('active');

    targetDot.classList.add('active');
    sliderItems[sliderDots.indexOf(targetDot)].classList.add('active');
    scrollSlider(sliderDots.indexOf(targetDot));
})
let currentIndex = 0;
setInterval(() => {
    currentIndex = (currentIndex + 1) % sliderItems.length;
    sliderDots.forEach(dot => dot.classList.remove('active'));
    sliderDots[currentIndex].classList.add('active');
    scrollSlider(currentIndex);
}, 3000);