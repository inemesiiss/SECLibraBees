const form6 = document.querySelector(".reportErr form"),
reportErrBtn = form6.querySelector(".button input"),
errinput1 = form6.querySelector("#titleRB"),
errinput2 = form6.querySelector("#descRB"),
errinput3 = form6.querySelector("#imgBug"),
repErrTxt =  form6.querySelector(".reportBug-Error");



form6.onsubmit = (e)=>{
   e.preventDefault();
}
reportErrBtn.onclick = ()=>{

   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "reportError.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            
            let dataRepError = xhr.response;
            if(dataRepError==1){
               errinput1.value = "";
               errinput2.value = "";
               errinput3.value = "";
               
               alert("Report Successfully Submitted!");
               
            }else{
               
               repErrTxt.textContent = dataRepError;
               repErrTxt.style.display = "block";
            }
         }
      }
   }
   let formData1 = new FormData(form6);
   xhr.send(formData1);
}


var errTitleInput = document.getElementById("titleRB");
var errDescInput = document.getElementById("descRB");
var errImgInput = document.getElementById("imgBug");
errTitleInput.onfocus = function() {
   repErrTxt.style.display = "none";
}
errDescInput.onfocus = function() {
   repErrTxt.style.display = "none";
}
errImgInput.onfocus = function() {
   repErrTxt.style.display = "none";
}