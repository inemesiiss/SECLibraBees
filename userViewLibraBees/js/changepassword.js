const formChangePass = document.querySelector(".changepass form"),
changePassBtn = formChangePass.querySelector(".button input"),
errorText =  formChangePass.querySelector(".changePass-Error");



formChangePass.onsubmit = (e)=>{
   e.preventDefault();
}
changePassBtn.onclick = ()=>{

   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "changePass.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let data = xhr.response;
            if (data.includes("success")) {
               alert("Password Successfully Changed!");
               console.log(data);
               location.href="logout.php";
             } else {
               errorText.textContent = data;
               errorText.style.display = "block";
             }
         }
      }
   }
   let formData11 = new FormData(formChangePass);
   xhr.send(formData11);
}


var changePassInput1 = document.getElementById("oldpassword");
var changePassInput2 = document.getElementById("npassword");
var changePassInput3 = document.getElementById("cpassword");
changePassInput1.onfocus = function() {
   errorText.style.display = "none";
}
changePassInput2.onfocus = function() {
   errorText.style.display = "none";
}
changePassInput3.onfocus = function() {
   errorText.style.display = "none";
}