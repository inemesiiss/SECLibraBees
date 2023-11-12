const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendMsgBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-body");

form.onsubmit = (e)=>{
   e.preventDefault();
}
sendMsgBtn.onclick = ()=>{
   let xhr = new XMLHttpRequest();
   xhr.open("POST","insertMessage.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            inputField.value = "";
         }

      }
   }
   let formData = new FormData(form);
   xhr.send(formData);
}
// let user scroll the chat box above
chatBox.onmouseenter = ()=>{
   chatBox.classList.add("active");
}
chatBox.onmouseleave = ()=>{
   chatBox.classList.remove("active");
}

setInterval(()=>{
   let xhr = new XMLHttpRequest();
   xhr.open("POST","getChat.php", true);
   xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE){
         if(xhr.status === 200){
            let data = xhr.response;
            chatBox.innerHTML = data;
            if(!chatBox.classList.contains("active")){
               scrollToBottom();
            }
         }

      }
   }
   let formData = new FormData(form);
   xhr.send(formData);
},500);

function scrollToBottom(){
   chatBox.scrollTop = chatBox.scrollHeight;
}

