function confirmDeleteBook(id) {
    if (confirm("Are you sure you want to delete this Book?")) {
        itemDelete(id);
    }
}
function showReserveBook(){  
    $.ajax({
        url:"./adminView/viewReserveBook.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}


function showErrQueries(){  
    $.ajax({
        url:"./adminView/viewErrQueries.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}


function showManageRevies(){  
    $.ajax({
        url:"./adminView/viewManageRev.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}



function showGenQueries(){  
    $.ajax({
        url:"./adminView/viewQueries.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}


function showManageNotif(){  
    $.ajax({
        url:"./adminView/viewManageNotif.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}

function showReturnedBooks(){  
    $.ajax({
        url:"./adminView/viewReturnedBook.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}

function showBarrowManagement(){  
    $.ajax({
        url:"./adminView/viewBarrowedBooks.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}

function showBookManagement(){  
    $.ajax({
        url:"./adminView/viewAllBooks.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}
function showBookSubjects(){  
    $.ajax({
        url:"./adminView/viewSubjects.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}
function showCategory(){  
    $.ajax({
        url:"./adminView/viewCategories.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}
function showBookCat(){  
    $.ajax({
        url:"./adminView/viewBookCat.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}


function showStudentsList(){
    $.ajax({
        url:"./adminView/viewStudentList.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}

function showAdmin(){
    $.ajax({
        url:"./adminView/viewAdmin.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}

function showOrders(){
    $.ajax({
        url:"./adminView/viewAllOrders.php",
        method:"post",
        data:{record:1},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}

function ChangeOrderStatus(id){
    $.ajax({
       url:"./controller/updateOrderStatus.php",
       method:"post",
       data:{record:id},
       success:function(data){
           alert('Order Status updated successfully');
           $('form').trigger('reset');
           showOrders();
       }
   });
}





//edit book data
function itemEditForm(id){
    $.ajax({
        url:"./adminView/editItemForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}
//edit admin data
function editAdminForm(id){
    $.ajax({
        url:"./adminView/editAdminForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
            $('form').trigger('reset'); // Clear form data
        }
    });
}
//edit book status data
function editBookStatFrm(id){
    $.ajax({
        url:"./adminView/editBookStatusFrm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

//update book status
function updateBookStat(){
    var book_status = $('#book_status').val();
    var barrow_id = $('#barrow_id').val();
    
    var fd = new FormData();
    fd.append('book_status', book_status);
    fd.append('barrow_id', barrow_id);


    $.ajax({
      url:'./controller/updateBookStatus.php',
      method:'post',
      data:fd,
      processData: false,
      contentType: false,
      success: function(data){
        alert('Book Status Update Success.');
        $('form').trigger('reset');
        showBarrowManagement();
      }
    });
}

//edit admin data
function editAdminForm(id){
    $.ajax({
        url:"./adminView/editAdminForm.php",
        method:"post",
        data:{record:id},
        success:function(data){
            $('.allContent-section').html(data);
        }
    });
}

//update admin info after submit
function updateAdminInfo(){
    var admin_id = $('#admin_id').val();
    var pos = $('#pos').val();
    var ad_fname = $('#ad_fname').val();
    var ad_sur = $('#ad_sur').val();
    var ad_usern = $('#ad_usern').val();
    var ad_pass = $('#ad_pass').val();
    var bookManagementAccess = $('#bookManagementAccess').val();
    var studManagementAccess = $('#studManagementAccess').val();
    var chatManagementAccess = $('#chatManagementAccess').val();
    var notifManagementAccess = $('#notifManagementAccess').val();
    var revCommssMngtAccess = $('#revCommssMngtAccess').val();
    var fd = new FormData();
    fd.append('admin_id', admin_id);
    fd.append('pos', pos);
    fd.append('ad_fname', ad_fname);
    fd.append('ad_sur', ad_sur);
    fd.append('ad_usern', ad_usern);
    fd.append('ad_pass', ad_pass);
    fd.append('bookManagementAccess', bookManagementAccess);
    fd.append('studManagementAccess', studManagementAccess);
    fd.append('chatManagementAccess', chatManagementAccess);
    fd.append('notifManagementAccess', notifManagementAccess);
    fd.append('revCommssMngtAccess', revCommssMngtAccess);
   
   
    $.ajax({
      url:'./controller/updateAdminInfoController.php',
      method:'post',
      data:fd,
      processData: false,
      contentType: false,
      success: function(data){
        alert('Admin Information Update Success.');
        $('form').trigger('reset');
        showAdmin();
      }
    });
}

//update book after submit
function updateItems() {
    var book_id = $('#book_id').val();
    var b_title = $('#b_title').val();
    var b_code = $('#b_code').val();
    var b_author = $('#b_author').val();
    var b_desc = $('#b_desc').val();
    var b_stat = $('#b_stat').val();
    var daysbarrowed = $('#daysbarrowed').val();
    var category = $('#category').val();
    var b_category = $('#b_category').val();
    var b_subject = $('#b_subject').val();
    var existingImage = $('#existingImage').val();
    var newImage = $('#newImage')[0].files[0];
  
    var form_data = new FormData();
    form_data.append('book_id', book_id);
    form_data.append('b_title', b_title);
    form_data.append('b_code', b_code);
    form_data.append('b_author', b_author);
    form_data.append('b_desc', b_desc);
    form_data.append('b_stat', b_stat);
    form_data.append('daysbarrowed', daysbarrowed);
    form_data.append('category', category);
    form_data.append('b_category', b_category);
    form_data.append('b_subject', b_subject);
    form_data.append('existingImage', existingImage);
    form_data.append('newImage', newImage);
  
    $.ajax({
        url:'./controller/updateItemController.php',
      type: 'POST',
      data: form_data,
      contentType: false,
      processData: false,
      success: function(response) {
        alert(response);
        showBookManagement();
      },
      error: function(jqXHR, textStatus, errorThrown) {
        alert('Error updating book: ' + textStatus + ' ' + errorThrown);
      }
    });
    return false;
  }
  function cancelBorrow(id){
    if(confirm("Are you sure you want to cancel the borrow request of this book?")){
      borrowDelete(id);
    }
  }
// delete barrow items
  function borrowDelete(id){
    $.ajax({
        url:"./controller/deleteBorrowBook.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Book Successfully Cancelled');
            $('form').trigger('reset');
            showBarrowManagement();
        }
    });
}
//cancel the reserve

function cancelReserve(id){
    if(confirm("Are you sure you want to cancel the reservation request of this book?")){
        reserveDelete(id);
    }
  }
// delete barrow items
  function reserveDelete(id){
    $.ajax({
        url:"./controller/deleteReserveBook.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Reservation Successfully Cancelled');
            $('form').trigger('reset');
            showReserveBook();
        }
    });
}
//cancel the reserve

function confirmDelReview(id){
    if(confirm("Are you sure you want to Delete this Review?")){
        reviewDelete(id);
    }
  }
// delete barrow items
  function reviewDelete(id){
    $.ajax({
        url:"./controller/deleteReviews.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Review Successfully Deleted');
            $('form').trigger('reset');
            showManageRevies();
        }
    });
}



  

//delete product data

function itemDelete(id){
    $.ajax({
        url:"./controller/deleteItemController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Items Successfully deleted');
            $('form').trigger('reset');
            showBookManagement();
        }
    });
}

function notifDelete(id){
    if (confirm("Are you sure you want to delete this Notification?")) {
    
    $.ajax({
        url:"./controller/notificationDelController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Notification Successfully deleted');
            $('form').trigger('reset');
            showCategory();
        }
    });
}
}



//delete category data
function categoryDelete(id){
    if (confirm("Are you sure you want to delete this Section?")) {
    
    $.ajax({
        url:"./controller/catDeleteController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Category Successfully deleted');
            $('form').trigger('reset');
            showCategory();
        }
    });
}
}


//RESOLVE error data
function resolveErr(id){
    if (confirm("Are you sure you want to Resolve this Error?")) {
    $.ajax({
        url:"./controller/resolveErr.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Error Successfully Resolve!');
            $('form').trigger('reset');
            showErrQueries();
        }
    });
}
}

//delete subject data
function subjectDelete(id){
    if (confirm("Are you sure you want to delete this Subject?")) {
    $.ajax({
        url:"./controller/subDeleteController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Subject Successfully deleted');
            $('form').trigger('reset');
            showBookSubjects();
        }
    });
}
}

//delete size data
function catbookDelete(id){
    if (confirm("Are you sure you want to delete this Category?")) {
    $.ajax({
        url:"./controller/deleteCatBookController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Category Successfully deleted');
            $('form').trigger('reset');
            showBookCat();
        }
    });
}
}

//delete admin data
function adminInfoDelete(id){
    if (confirm("Are you sure you want to delete this Category?")) {
    $.ajax({
        url:"./controller/deleteAdminController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Successfully deleted');
            $('form').trigger('reset');
            showAdmin();
        }
    });
    }
}


const searchBar =  document.querySelector(".searchDiv input"),
searchBtn = document.querySelector(".users .searchDiv button"),
usersListBox = document.querySelector(".userListBx");

searchBtn.onclick = ()=>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value="";
}
searchBar.onkeyup = ()=>{
let searchTerm = searchBar.value;
    if(searchTerm != ""){
        searchBar.classList.add("active");
    }else{
        searchBar.classList.remove("active");
    }
let xhr = new XMLHttpRequest();
    xhr.open("POST","controller/studSearchListChat.php", true);
    xhr.onload = ()=>{
       if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
             let data = xhr.response;
             usersListBox.innerHTML = data;
            console.log(data);
          }
 
       }
    }
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xhr.send("searchTerm=" + searchTerm);
 }
//chat user list ajax code

setInterval(()=>{
    let xhr = new XMLHttpRequest();
    xhr.open("GET","controller/manageStudListController.php", true);
    xhr.onload = ()=>{
       if(xhr.readyState === XMLHttpRequest.DONE){
          if(xhr.status === 200){
             let data = xhr.response;
             if(!searchBar.classList.contains("active")){
                usersListBox.innerHTML = data;
             }
             
             
          }
 
       }
    }
    
    xhr.send();
 },500);





 function storeCurrChatId(event, id) {
    event.preventDefault();
    console.log(id);
    if (!id) {
      console.log("Error: chatid value is empty or undefined");
      return;
    }
    // Send the value to the server using AJAX
    $.ajax({
        url:"./controller/updateChatSender.php",
        method:"post",
        data:{chatid:id},
        success:function(data){
            
        }
    });
  }

 

 
  

  //delete admin data
function resetPassConfirmation(id){
    if (confirm("Are you sure you want to Reset this student password?")) {
    $.ajax({
        url:"./controller/resStudPassController.php",
        method:"post",
        data:{record:id},
        success:function(data){
            alert('Password Successfully Reset!');
            $('form').trigger('reset');
            showStudentsList();
        }
    });
    }
}


function confirmDelStud(id){
    if(confirm("Are you sure you want to remove this student?")){
        studentDel(id);
    }
  }
// delete student
function studentDel(id){
    $.ajax({
        url:"./controller/deleteStudent.php",
        method:"post",
        data:{record:id},
        success:function(data){
            if(data.includes("success")){
                alert("Student record deleted successfully.");
            } else {
                alert("Failed to delete student record.");
            }
            $('form').trigger('reset');
            showStudentsList();
        }
    });
}
  