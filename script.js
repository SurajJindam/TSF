'use strict'

const createNewAccountBtn = document.querySelector('.open-account-btn');
const modal = document.querySelector('.modal');
const overlay = document.querySelector('.overlay');
const closeModalBtn = document.querySelector('.btn--close-modal')

createNewAccountBtn.addEventListener('click', function (e) {
    e.preventDefault();
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
});

const closeModal = function () {
    modal.classList.add('hidden');
    overlay.classList.add('hidden');
}

closeModalBtn.addEventListener('click', closeModal)
overlay.addEventListener('click', closeModal)
