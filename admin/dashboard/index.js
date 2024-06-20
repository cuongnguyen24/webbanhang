const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu_btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");
const sideBarActive = document.querySelectorAll(".x");
menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})


closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
})

//change

themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-them-variables');

    themeToggler.querySelector('i:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('i:nth-child(2)').classList.toggle('active');
})

console.log(sideBarActive.length);