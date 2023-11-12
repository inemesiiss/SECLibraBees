
let menu = document.querySelector('#menu-btn');
let navbar = document.querySelector('.header .navbar');

menu.onclick = () =>{
   menu.classList.toggle('fa-times');
   navbar.classList.toggle('active');
};

window.onscroll = () =>{
   menu.classList.remove('fa-times');
   navbar.classList.remove('active');
};

var swiper = new Swiper(".home-slider", {
   loop:true,
   navigation: {
     nextEl: ".swiper-button-next",
     prevEl: ".swiper-button-prev",
   },
});

var swiper = new Swiper(".reviews-slider", {
   grabCursor:true,
   loop:true,
   autoHeight:true,
   spaceBetween: 20,
   breakpoints: {
      0: {
        slidesPerView: 1,
      },
      700: {
        slidesPerView: 2,
      },
      1000: {
        slidesPerView: 3,
      },
   },
});








  
 


function updatePassword(){
   var oldpassword = $('#oldpassword').val();
   var npassword = $('#npassword').val();
   var cpassword = $('#cpassword').val();
   var fd = new FormData();
   fd.append('oldpassword', oldpassword);
   fd.append('npassword', npassword);
   fd.append('cpassword', cpassword);

   $.ajax({
     
     method:'post',
     data:fd,
     
     success: function(data){
       
     }
   });
}



function openNav() {
   document.getElementById("filterSidebar").style.width = "35%";
   
   
 }
 
 function closeNav() {
   document.getElementById("filterSidebar").style.width = "0";
    
 }

 function filterShowHide() {
  // ...  your function code
    // use this to NOT go to href site
}

 ////updates number of notification unseen
 $(document).ready(function () {
  setInterval(function() {
     $.post("getnotif.php",{data:'get'},function (
        data) {
           if(data>0){
              $("#notifNum").show();
              $("#notifNum").text(data);
           }
        });
  },1000);
  ///updates the the notification once the image was click
  $("#myNotifImg").click(function(){
     $("#notifNum").hide();
     $.post("getnotif.php",{update:'update'},
     function(data){

     });
  });
});

$(document).ready(function () {
  setInterval(function() {
     $.post("getChatNotif.php",{data:'get'},function (
        data) {
           if(data>0){
              $("#chatNum").show();
              $("#chatNum").text(data);
           }
        });
  },1000);
$("#myChatBoxImg").click(function(){
     $("#chatNum").hide();
     $.post("getChatNotif.php",{update:'update'},
     function(data){

     });
  });
});
//open the notification modal
$(document).ready(function(){
	$('#myNotifImg').click(function(){
  		$('#myNotifModal').modal('show')
	});
});
// expand collapse my notification button
$('.myNotifButton').click(function(){
  if ( this.value === 'close' ) {
      // if it's open close it
      open = false;
      this.value = 'Read';
      $(this).next("div.notifcontainer").hide("slow");
  }
  else {
      // if it's close open it
      open = true;
      this.value = 'close';
      $(this).siblings("[value='close']").click();
      $(this).next("div.notifcontainer").show("slow");
  }
});

  function logout() {
    if (confirm("Are you sure you want to log out?")) {
      window.location.href = "logout.php";
    }
  }


   ////updates number of notification unseen
 $(document).ready(function () {
   setInterval(function() {
      $.post("getRevNotif.php",{data:'get'},function (
         data) {
            if(data>0){
               $("#revNum").show();
               $("#revNum").text(data);
            }
         });
   },1000);
 });

 
