
   
 <!-- nav -->
 <nav  class="navbar navbar-expand-lg navbar-light px-5" style="background-color: #00BFFF; transform: scale(0.90);"  >
    
    <a class="navbar-brand ml-5" href="./index.php">
        
        
        <h5 style="margin-left: 100px;color:#1c0707;font-size: 2rem; text-align: right;"> <img src="./assets/images/seclogo.png" width="150" height="150">    Southeastern College Virtual Library Management
            
    
    </h5>
        
    
    </a>

    <ul class="navbar-nav mr-auto mt-2 mt-lg-0"></ul>
    
  <div class="user-cart">  
    <?php if(isset($_SESSION['user'])){ ?>
        <a href="logout.php" style="text-decoration:none;" onclick="return confirm('Are you sure you want to log out?');">
            <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
        </a>
    <?php } else { ?>
        <a href="logout.php" style="text-decoration:none;" onclick="return confirm('Are you sure you want to log out?');">
            <i class="fa fa-sign-in mr-5" style="font-size:30px; color:#fff;" aria-hidden="true"></i>
        </a>
    <?php } ?>
</div>  
</nav>
