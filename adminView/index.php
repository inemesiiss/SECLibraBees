<?php

require_once '../config/ddbconnect.php';
require_once '../config/dbconnect.php';


session_start();
if (isset($_SESSION['user'])) {
   if ($_SESSION['user']['ademail_verified_at'] == null) {
      header('Location: http://localhost/thesis/userViewLibraBees/adminVerification.php');
     exit();
   } else {
     // this code will be executed when the user is verified
     
   }
 } else {
   // user is not logged in, redirect to login page
   header('Location: http://localhost/thesis/userViewLibraBees/loginasadmin.php');
   exit();
 }

// Get the value sent through AJAX
if (isset($_SESSION['user']['current_stud_chat'])) {
   // Set the current student chat in the session
   
   $std_id = $_SESSION['user']['current_stud_chat'];
 } else {
   // Get the chat_sender value of the latest chat
   $sel1stChat = "SELECT chat_sender FROM chat WHERE chat_sender != 'admin' ORDER BY chat_time DESC LIMIT 1";
   $result = mysqli_query($conns, $sel1stChat);
 
   if ($result) {
      $row = mysqli_fetch_assoc($result);
      if ($row) {
        $std_id = $row['chat_sender'];
        // Do something with $std_id
      } else {
        // Handle case where query returned no rows
      }
   } else {
      // Handle query error
      echo "Error: " . mysqli_error($conn);
   }
 }
 
?>
<!DOCTYPE html>
<html>
<head>
  <title>Admin</title>
  <head>
     <!-- Required meta tags -->
     <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
       <link rel="stylesheet" href="./assets/css/style.css"></link>
       <link rel="icon" type="image/x-icon" href="../userViewLibraBees/LB.ico">
  </head>
</head>
<body>
<div class="main">
<?php
            include "./adminHeader.php";
            include "./sidebar.php";
            include_once "./config/dbconnect.php";
        ?>
    <div id="main-content" class="container allContent-section py-4" style="display:flex;">
        <div class="row">
         <section class="services">
            <h1 class="heading-title"> </h1>
            <div class="box-container">
               <div class="box">
                  <img id="MyNotifimg" style="height: 5rem;" src="../userViewLibraBees/images/icon-5.png">
                  <span class="badge bg-danger rounded-pill float-end" style="font-size: 1.5rem;" id="genNotif"></span>
                  <h3 style="font-size: 1rem;">Notifications</h3>
               </div>
               <div class="box">
                  <img id="myChatBoxImg" style="height: 5rem;" src="../userViewLibraBees/images/icon-3.png" alt="">
                  <span class="badge bg-danger rounded-pill float-end" style="font-size: 1.5rem;" id="studChatsNotifNum"></span>
                  <h3 style="font-size: 1rem;">Student Queries</h3>
               </div>
            </div>
         </section>
        </div>
    </div>
</div> 


<div class="modal fade" id="myNotifModal">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
         <h2 class="modal-title">Notification</h2>   
         <button type="button" class="close" style="font-size: 1.5rem; background-color: transparent;"data-bs-dismiss="modal">&times;</button>                                          
			</div> 
			<div class="modal-body" id="modal-body">
         <?php
            $selPickNum = "SELECT * FROM barrow_book WHERE book_status = 1";
            $result = $conns->query($selPickNum);
            $num_rowsPickup = $result->num_rows;

            // Check if any rows were for pick up
            if ($num_rowsPickup > 0) {
               // Output data of each row
               
                     echo '<div class="notification">
                        <img src="../userViewLibraBees/images/book.png" height ="100px" width="100px" class="notification-icon">
                        <span class="notification-message">You have '.$num_rowsPickup.' books for pick up.</span>
                        <a href="#" class="notification-shortcut" onclick="showBarrowManagement();"  id="bookPage">Go to Book Page</a>
                     </div><br></br>';
               
            } else {
               echo '<div class="notification">
                        <img src="../userViewLibraBees/images/book.png" height ="100px" width="100px" class="notification-icon">
                        <span class="notification-message">No books for pick up.</span>
                     </div><br></br>';
            }
            
            // Notif the number review that is not yet posted
            $selReviewNum = "SELECT * FROM review WHERE status = 0";
            $result = $conns->query($selReviewNum);
            $num_rowsReview = $result->num_rows;

            // Check if any rows were for pick up
            if ($num_rowsReview > 0) {
               // Output data of each row
               
               
                     echo '<div class="notification">
                        <img src="../userViewLibraBees/images/rating.png" height ="100px" width="100px" class="notification-icon">
                        <span class="notification-message">You have '.$num_rowsReview.' pending review.</span>
                        <a href="#" class="notification-shortcut" onclick="showManageRevies();"  id="revPage">Manage Reviews Now</a>
                     </div><br></br>';
               
            } else {
               echo '<div class="notification">
                      <img src="../userViewLibraBees/images/rating.png" height ="100px" width="100px" class="notification-icon">
                        <span class="notification-message">No pending reviews yet.</span>
                     </div><br></br>';
            }


             // Notif the number error that has not been solve
             $selError = "SELECT * FROM errQueries";
             $result = $conns->query($selError);
             $num_rowsErr = $result->num_rows;
 
             // Check if any rows were for pick up
             if ($num_rowsErr > 0) {
                // Output data of each row
                
                
                      echo '<div class="notification">
                         <img src="../userViewLibraBees/images/warning-sign.png" height ="100px" width="100px" class="notification-icon">
                         <span class="notification-message">You have '.$num_rowsErr.' unresolve site error.</span>
                         <a href="#" class="notification-shortcut" onclick="showErrQueries();"  id="errPage">Check Errors Now</a>
                      </div><br></br>';
                
             } else {
                echo '<div class="notification">
                       <img src="../userViewLibraBees/images/warning-sign.png" height ="100px" width="100px" class="notification-icon">
                         <span class="notification-message">No reported site error.</span>
                      </div><br></br>';
             }
         ?>

         
         

                        
                         
               </div> 
			</div>  
		</div>                                                                       
	</div>   



<!-- Modal -->

<div class="modal fade" id="myChatBoxModal" role="dialog">
<div class="modal-dialog modal-xl">
    
      <!-- Modal ChatBox-->
      <div class="modal-content" style="transform: scale(0.8);">
        <div class="modal-header">
          <h4 class="modal-title">General Queries</h4>
          <button type="button" class="close" data-bs-dismiss="modal">&times;</button> 
        </div>
        <div class="grid-container">
                    <section class="users" style="background-color: #00BFFF;">
                    <div class="container py-5">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="card" id="chat3" style="border-radius: 15px;">
                            <div class="card-body">
                                <div class="row">
                                <div class="users">
                                    <div class="searchDiv" >
                                    <span class="text" >Select a Student to Chat</span>
                                        <input type="text" placeholder="Search" name="keywordname"></input><button><i class="fa fa-search"></i></button>
                                    </div>
                                    <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 620px; width: 300px;overflow-x:auto;" class="userListBx">
                                    </div>
                                </div>
                                </div>
                            </div>
                            </div>
                        </div>
                        </div>
                     </div>
                    </section>
                <section style="background-color: #00BFFF;">
                    <div class="container py-5">
                        <div class="row">
                        <div class="col-md-12">
                            <div class="card" id="chat3" style="border-radius: 15px;">
                            <div class="card-body">
                                </div>
                                <div class="col-md-6 col-lg-7 col-xl-8">
                                <div id="currStudChat" style="display: flex; align-items: center;">
                                
                                 </div>
                                    <div class="chat-body" id="chatBody" 
                                    style="height:600px; width:480px;overflow-y: scroll; overflow-x: hidden; background: #ffc105; display: flex; flex-direction: column-reverse;" >
                                    </div>
                                    <div style="width:480px;  background: #ffc105;" >
                                        <form action="#" class="typing-area" autocomplete="off">
                                        <input type="text" name="adminChat_id"  value="admin" hidden>
                                        <input type="text" name="studChat_id"  value="<?php echo $std_id;?>" hidden>
                                        <input type="text" name="message" class="input-field" placeholder="Type message here...">
                                        <button class="buttonMsgsend"><i class="fab fa-telegram-plane"></i></button>
                                    </div>
                                    </form>
                                </div>
                                </div>
                             </div>
                        </div>
                    </div>
                </section>
             </div>
        </div>
    </div>
  </div>
  </div>  
   


    <script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
    <script type="text/javascript" src="./assets/js/script.js"></script>
    <script src="https://code.jquery.com/jquery-3.1.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.6.0/dt-1.13.1/datatables.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.6.0/jq-3.6.0/dt-1.13.1/datatables.min.css"/>
    <script src="https://kit.fontawesome.com/0bd5d623c3.js" crossorigin="anonymous"></script>
    
</body>
</html>
<script>

    // open modal admin chat
$(document).ready(function(){
	$('#myChatBoxImg').click(function(){
  		$('#myChatBoxModal').modal('show')
	});
});

$(document).ready(function(){
	$('#MyNotifimg').click(function(){
  		$('#myNotifModal').modal('show')
	});
});




// the chat form
const form = document.querySelector(".typing-area"),
inputField = form.querySelector(".input-field"),
sendMsgBtn = form.querySelector("button"),
chatBox = document.querySelector(".chat-body");

form.onsubmit = (e)=>{
   e.preventDefault();
}
sendMsgBtn.onclick = ()=>{
   let xhr = new XMLHttpRequest();
   xhr.open("POST","controller/insertMessage.php", true);
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
//Gets the Live chat data of  user and admin
setInterval(()=>{
   let xhr = new XMLHttpRequest();
   xhr.open("POST","controller/manageStudChatController.php", true);
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



    ////updates number of notification unseen on admin side
   $(document).ready(function () {
      setInterval(function() {
         $.post("controller/getNotifAllStudNumController.php",{data:'get'},function (
            data) {
                console.log(data);
               if(data>0){
                
                  $("#studChatsNotifNum").show();
                  $("#studChatsNotifNum").text(data);
               }
            });
      },1000);
    });

    $(document).ready(function () {
    setInterval(function() {
       $.post("controller/getNotifAll.php",{data:'get'},function (
          data) {
            console.log(data);
             if(data>0){
                $("#genNotif").show();
                $("#genNotif").text(data);
             }
          });
    },1000);
  });


  function updateChatBanner() {
  var xhttp = new XMLHttpRequest();
  xhttp.onreadystatechange = function() {
    if (this.readyState == 4 && this.status == 200) {
      document.getElementById("currStudChat").innerHTML = this.responseText;
    }
  };
  xhttp.open("GET", "controller/chatBannerController.php", true);
  xhttp.send();
}

window.onload = function() {
  setInterval(function() {
   updateChatBanner();
  }, 500); // call updateChat() every 0.5 seconds
};


    $("#revPage").click(function(){
    $('#myNotifModal').modal('hide')
    });
    $("#errPage").click(function(){
    $('#myNotifModal').modal('hide')
    });
    $("#bookPage").click(function(){
    $('#myNotifModal').modal('hide')
    });





</script>

