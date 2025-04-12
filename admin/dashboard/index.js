const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu_btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");
const darkModeToggle = document.getElementById('darkModeToggle');
const lightModeToggle = document.getElementById('lightModeToggle');

const isDarkMode = JSON.parse(localStorage.getItem('darkMode')) || false;
darkModeToggle.checked = isDarkMode;


menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})


closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
})

//change


let istoggle = false;
let result = istoggle;
themeToggler.addEventListener('click', () => {
    istoggle = !istoggle;
    document.body.classList.toggle('dark-them-variables');

    themeToggler.querySelector('i:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('i:nth-child(2)').classList.toggle('active');


    localStorage.setItem('darkModeEnabled', istoggle);
    result = localStorage.getItem('darkModeEnabled');
    console.log(istoggle);
    console.log(result);
})

themeToggler.addEventListener('DOMContentLoaded', () => {
    if (result) {
        themeToggler.querySelector('i:nth-child(1)').classList.add('active');
        themeToggler.querySelector('i:nth-child(2)').classList.remove('active');
    } else {
        themeToggler.querySelector('i:nth-child(2)').classList.add('active');
        themeToggler.querySelector('i:nth-child(1)').classList.remove('active');
    }
})


console.log(istoggle);
console.log(result);