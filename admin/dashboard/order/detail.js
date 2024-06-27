document.getElementById('status_button').addEventListener("click",function(){
    var order_detail = document.getElementById('status_edit');
    if (order_detail.style.display === "none"){
        order_detail.style.display = "block";
    }else {
        order_detail.style.display = "none";
    }
})