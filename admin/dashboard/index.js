const sideMenu = document.querySelector("aside");
const menuBtn = document.querySelector("#menu_btn");
const closeBtn = document.querySelector("#close-btn");
const themeToggler = document.querySelector(".theme-toggler");

menuBtn.addEventListener('click', () => {
    sideMenu.style.display = 'block';
})


closeBtn.addEventListener('click', () => {
    sideMenu.style.display = 'none';
})

//change
var test = themeToggler.querySelector('i:nth-child(1)').className.split(' ');
var nameTheme = "";
themeToggler.addEventListener('click', () => {
    document.body.classList.toggle('dark-them-variables');

    themeToggler.querySelector('i:nth-child(1)').classList.toggle('active');
    themeToggler.querySelector('i:nth-child(2)').classList.toggle('active');

    if (test[2] == "active") {
        nameTheme = "light";
    } else {
        nameTheme = 'dark';
    }

})
var nameTheme = "theme = " + nameTheme;
document.cookie = nameTheme
var theme = document.cookie;
console.log(nameTheme);