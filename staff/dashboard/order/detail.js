document.getElementById('status_button').addEventListener("click",function(){
    var status_edit = document.getElementById('status_edit');
    if (status_edit.style.display === "none"){
        status_edit.style.display = "block";
    }else {
        status_edit.style.display = "none";
    }
})