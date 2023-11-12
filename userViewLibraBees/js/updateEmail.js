const form2 = document.querySelector(".formUpdtEmail"),
sendVcodeBtn = form2.querySelector(".updatevcode input"),
emailErrTxt = form2.querySelector(".Uptemail-Error"),
emailMsgTxt = form2.querySelector(".Uptemail-Msg"),
updtMailBtn = form2.querySelector(".updatemail input");



form2.onsubmit = (e)=>{
   e.preventDefault();
}
sendVcodeBtn.onclick = ()=>{

   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "updateEm.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let dataEmail = xhr.response;
            if(dataEmail.includes("success")){
               alert("Email Verication Successfully Sent!");
            }else{
               emailErrTxt.textContent=dataEmail;
               emailErrTxt.style.display = "block";
               console.log(dataEmail);
               
            }
         }
      }
   }
   let formData2 = new FormData(form2);
   xhr.send(formData2);
}


var updateEmailInput = document.getElementById("newEmail");

updateEmailInput.onfocus = function() {
   emailErrTxt.style.display = "none";
}






updtMailBtn.onclick = ()=>{

   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "changeEmail.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let upEmData = xhr.response;
            if(upEmData.includes("success")){
               alert("Email Successfully Change!");
               console.log(upEmData);
               location.href="logout.php";
               
            }else{
               emailErrTxt.textContent=upEmData;
               emailErrTxt.style.display = "block";
               console.log(upEmData);
               
            }
         }
      }
   }
   let formData2 = new FormData(form2);
   xhr.send(formData2);
}
