
<!-- Sidebar -->
<div class="sidebar" id="mySidebar" >
<div class="side-header">
    <img src="./assets/images/LB.png" width="190" height="180" alt="Swiss Collection"> 
    <?php
   echo" <h5 style='margin-top:10px;'>Hello, Admin ".$_SESSION['user']['fname']."</h5>"
   ?>
</div>

<hr style="border:1px solid; background-color:#8a7b6d; border-color:#3B3131;">
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()"></a>
    <a style = "font-size: 20px; text-align: left;" href="./index.php" ><i class="fa fa-home"></i> Dashboard</a>
    <button style = "font-size: 20px; text-align: left;" class="dropdown-btn"><i class="fas fa-users"></i> Users
    <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-container">
    <a href="#admins" style = "font-size: 18px; text-align: left;" onclick="showAdmin()" ></i> Admin</a>
    <a href="#users" style = "font-size: 18px; text-align: left;" onclick="showStudentsList()" ></i> Students</a>
    <hr />
    </div>
    <button style = "font-size: 20px; text-align: left;" class="dropdown-btn"><i class="fas fa-book"></i> Books
    <i class="fa fa-caret-down"></i></button>
    <div class="dropdown-container">
    <a href="#books"  style = "font-size: 18px; text-align: left;" onclick="showBookManagement()" ></i>  Management</a>
    <a href="#booksbarrowed"  style = "font-size: 18px; text-align: left;" onclick="showBarrowManagement()" ></i>  Borrow</a>
    <a href="#booksections" style = "font-size: 18px; text-align: left;"  onclick="showCategory()" ></i>  Sections</a>
    <a href="#bookcategories" style = "font-size: 18px; text-align: left;"  onclick="showBookCat()" ></i>  Categories</a>
    <a href="#booksubjects" style = "font-size: 18px; text-align: left;"  onclick="showBookSubjects()" ></i>  Subjects</a>
    <hr />
  </div>
    
    
    
    
  <a href="#managenotification" style = "font-size: 20px; text-align: left;"   onclick="showManageNotif()" ><i class="fa fa-bell"></i>  Notification</a>  
    <a href="#reviewmanagement" style = "font-size: 20px; text-align: left;"   onclick="showManageRevies()" ><i class="fas fa-thumbs-up"></i>  Reviews</a>  
    
    <a href="#errorandqueries"  style = "font-size: 20px; text-align: left;"  onclick="showErrQueries()" ><i class="fa-solid fa-triangle-exclamation"></i> Error</a>  
     
    
    
    
  <!---->
</div>
 
<div id="main">
    <button class="openbtn" onclick="openNav()"><i class="fa fa-home"></i></button>
</div>

<style>

.dropdown-btn {
  padding: 6px 8px 6px 16px;
  text-decoration: none;
  font-size: 25px;
  color: white;
  display: block;
  border: none;
  background: #00BFFF;
  width:100%;
  text-align: justify;
  cursor: pointer;
  outline: none;
}
.active {
  background-color: #FCD116;
  color: black;
}

.dropdown-container {
  display: none;
  background-color: #00BFFF;
  padding-left: 8px;
}
.fa-caret-down {
  float: right;
  padding-right: 8px;
}
  
</style>

<script>
  var dropdown = document.getElementsByClassName("dropdown-btn");
var i;

for (i = 0; i < dropdown.length; i++) {
  dropdown[i].addEventListener("click", function() {
    this.classList.toggle("active");
    var dropdownContent = this.nextElementSibling;
    if (dropdownContent.style.display === "block") {
      dropdownContent.style.display = "none";
    } else {
      dropdownContent.style.display = "block";
    }
  });
}
</script>


