const LogIn = document.querySelector('.js-LogIn');
const model_LogIn = document.querySelector('.js-model_LogIn');
const model_LogIn_Close = document.querySelector('.js-model_LogIn-close');
const model_LogIn_Container = document.querySelector('.js-model-container');
// hiển thị module đăng nhập


function showLogIn() {
    model_LogIn.classList.add('open');
}
// ẩn module đăng nhập
function hideLogIn() {
    model_LogIn.classList.remove('open');
}

// Xử lý sự kiện click để mở mô-đun
LogIn.addEventListener('click', showLogIn);

// Xử lý sự kiện click để đóng mô-đun
model_LogIn_Close.addEventListener('click', hideLogIn);

model_LogIn.addEventListener('click', hideLogIn);

model_LogIn_Container.addEventListener('click', function(event) {
    event.stopPropagation();
});