<?php 
session_start();
//if($_SESSION['user']['chataccess'] == 0){
 // debug_backtrace() || die ("<h2>Access Denied!</h2> Please contact the admin librian"); 
//}

?>


<script type="text/javascript" src="./assets/js/ajaxWork.js"></script>    
<script type="text/javascript" src="./assets/js/script.js"></script>
<script type="text/javascript" src="./assets/js/studentQueries.js"></script>
<?php
if (isset($_GET['keyword'])) {
   $keyword = $_GET['keywordname'];
} else {
   $keyword = "";
}
$std_id=5158696;
?>

<div >
  <h2>General Queries</h2>

  <section style="background-color: #00BFFF;">
  <div class="container py-5">

    <div class="row">
      <div class="col-md-12">

        <div class="card" id="chat3" style="border-radius: 15px;">
          <div class="card-body">

            <div class="row">
              <div class="col-md-6 col-lg-5 col-xl-4 mb-4 mb-md-0">

                <div class="p-3">

                  <div class="input-group rounded mb-3">
                    <input type="search" class="form-control rounded" placeholder="Search" aria-label="Search" name="keywordname"
                      aria-describedby="search-addon" />
                    <span class="input-group-text border-0" id="search-addon">
                      <i class="fas fa-search"></i>
                    </span>
                  </div>

                  <div data-mdb-perfect-scrollbar="true" style="position: relative; height: 400px; overflow-x:auto;">
                    <ul class="list-unstyled mb-0">
                      <li class="p-2 border-bottom">
                        <a href="#!" class="d-flex justify-content-between">
                          <div class="d-flex flex-row">
                            <div>
                              <img
                              src="./assets/images/student1.png"
                                alt="./assets/images/student1.png" class="d-flex align-self-center me-3" width="60">
                              <span class="badge bg-success badge-dot"></span>
                            </div>
                            <div class="pt-1">
                              <p class="fw-bold mb-0">Marie Horwitz</p>
                              <p class="small text-muted">Hello, Are you there?</p>
                            </div>
                          </div>
                          <div class="pt-1">
                            <p class="small text-muted mb-1">Just now</p>
                            <span class="badge bg-danger rounded-pill float-end">3</span>
                          </div>
                        </a>
                      </li>
                     
                        
                     
                      
                      
                      
                    </ul>
                  </div>

                </div>

              </div>

              <div class="col-md-6 col-lg-7 col-xl-8">

                <div class="pt-3 pe-3" data-mdb-perfect-scrollbar="true"
                  style="position: relative; height: 400px; overflow-x:auto;" >

                 
                  

                  
                    

                  
                    

                 

                  

                </div>

                <div class="text-muted d-flex justify-content-start align-items-center pe-3 pt-3 mt-2">
                  <img src=""
                    alt="avatar 3" style="width: 40px; height: 100%;">
                    <section class="form typing"></section>
                    <form action="#" id="typing-forms" autocomplete="off">
                      <input type="text" name="adminChat_id"  value="admin" hidden>
                      <input type="text" name="studChat_id"  value="<?php echo $std_id;?>" hidden>
                      <input type="text" name="message" class="message-field" placeholder="Type message here...">
                      <a class="ms-1 text-muted" href="#!"><i class="fas fa-paperclip"></i></a>
                      <a class="ms-3 text-muted" href="#!"><i class="fas fa-smile"></i></a>
                      <button class="buttonMsgsend"><i class="fas fa-paper-plane"></i></button>
                  
                  </form>
                </div></i>

              </div>
            </div>

          </div>
        </div>

      </div>
    </div>

  </div>
</section>
