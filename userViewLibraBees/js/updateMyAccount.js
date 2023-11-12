const formEditAccount = document.querySelector(".myAccount form"),
editAccBtn = formEditAccount.querySelector(".myAccountBtn input");



formEditAccount.onsubmit = (e)=>{
   e.preventDefault();
}
editAccBtn.onclick = ()=>{

   let xhr =  new XMLHttpRequest();
   xhr.open("POST", "UpdtMyAcc.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let data = xhr.response;
            if (data.includes("success")) {
               alert("Details Successfully Changed!");
               location.href="home.php";
               console.log(data);
             } else {
               
             }
         }
      }
   }
   let formData = new FormData(formEditAccount);
   xhr.send(formData);
}





