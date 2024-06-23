document.getElementById('detail_button').addEventListener('click',function(){
    var order_detail = document.getElementById('order_detail');
    if (order_detail.style.display === 'none'){
        order_detail.style.display = 'block';
    }else {
        order_detail.style.display = 'none';
    }
})