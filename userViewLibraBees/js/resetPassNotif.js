const form6 = document.querySelector(".reportErr form"),
reportErrBtn = form6.querySelector(".button input"),
repErrTxt =  form6.querySelector(".reportBug-Error");



form6.onsubmit = (e)=>{
   e.preventDefault();
}
reportErrBtn.onclick = ()=>{

   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "resetPassNotif.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            
            let data = xhr.responseText;
            if (data.includes("success")) {
               alert("Request Submitted!");
               console.log(data);
             } else {
               repErrTxt.textContent = data;
               repErrTxt.style.display = "block";
             }
         }
      }
   }
   let formData1 = new FormData(form6);
   xhr.send(formData1);
}


var errTitleInput = document.getElementById("user_email");
var errDescInput = document.getElementById("studnum");
var errImgInput = document.getElementById("id_pic");
errTitleInput.onfocus = function() {
   repErrTxt.style.display = "none";
}
errDescInput.onfocus = function() {
   repErrTxt.style.display = "none";
}
errImgInput.onfocus = function() {
   repErrTxt.style.display = "none";
}