document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('form');
    const maNhanVien = document.getElementById('maNhanVien');
    const tenTaiKhoan = document.getElementById('tenTaiKhoan');
    const matKhau = document.getElementById('matKhau');
    const hoTen = document.getElementById('hoTen');
    const ngaySinh = document.getElementById('date');
    const diaChi = document.getElementById('diaChi');
    const email = document.getElementById('email');
    const soDienThoai = document.getElementById('soDienThoai');
    const ghiChu = document.getElementById('ghiChu');
    const errorDiv = document.getElementById('errorDiv');
    const errorEmailMessage = document.getElementById('error__email-message');
    const errorSdtMessage = document.getElementById('error__sdt-message');


    // Xử lý sự kiện blur cho trường email
    email.addEventListener('input', function () {
        if (!hasGmailDomain(email.value)) {
            errorEmailMessage.style.display = 'block';
        } else {
            errorEmailMessage.style.display = 'none';
        }
    });

    // Xử lý sự kiện blur cho trường số điện thoại
    soDienThoai.addEventListener('input', function () {
        if (!isValidPhoneNumber(soDienThoai.value)) {
            errorSdtMessage.style.display = 'block';
        } else {
            errorSdtMessage.style.display = 'none';
        }
    });
    form.addEventListener('submit', function (event) {
        let errors = [];
        // Kiểm tra các trường dữ liệu không được để trống
        if (isEmpty(maNhanVien.value) || isEmpty(tenTaiKhoan.value) || isEmpty(matKhau.value) || isEmpty(hoTen.value) || isEmpty(ngaySinh.value) || isEmpty(diaChi.value) || !checkRadioSex() || isEmpty(email.value) || isEmpty(soDienThoai.value)) {
            errors.push('Hãy nhập đầy đủ thông tin !');
        }
        // Hiển thị thông báo lỗi nếu có
        if (errors.length > 0) {
            event.preventDefault(); // Ngăn form submit nếu có lỗi
            errorDiv.innerHTML = '<i class="fa-solid fa-circle-exclamation"></i>' + errors.join('<br>');
            errorDiv.style.display = 'block';
        } else {
            errorDiv.style.display = 'none';
        }
    });

    function isEmpty(value) {
        return value.trim() === '';
    }
    function hasGmailDomain(email) {
        // Kiểm tra email có đuôi @gmail.com
        const domain = email.substring(email.length - 10);
        return domain === '@gmail.com';
    }
    function isValidPhoneNumber(phoneNumber) {
        // Kiểm tra độ dài số điện thoại từ 9 đến 11 số
        const pattern = /^\d{9,11}$/;
        return pattern.test(phoneNumber);
    }
});
