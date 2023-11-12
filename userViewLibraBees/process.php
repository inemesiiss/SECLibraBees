<?php
require './config/dbconnect.php';

$page = isset($_POST["page"]) ? $_POST["page"] : 1;
$sql = '';


if (isset($_POST["bk_subj"])) {
    $bk_subj = $_POST["bk_subj"];
    $bk_subj = implode("','", $bk_subj);
    $customSql = "booksubject_id IN('" . $bk_subj . "') ";
    $sql .= empty($sql) ? $customSql : "AND ($customSql)";
}

if (isset($_POST["bk_sec"])) {
    $bk_sec = $_POST["bk_sec"];
    $bk_sec = implode("','", $bk_sec);
    $customSql = "category_id IN('" . $bk_sec . "')";
    $sql .= empty($sql) ? $customSql : "AND ($customSql)";
}

if (isset($_POST["bk_cat"])) {
    $bk_cat = $_POST["bk_cat"];
    $bk_cat = implode("','", $bk_cat);
    $customSql =  "bookcategory_id IN('" . $bk_cat . "') ";
    $sql .= empty($sql) ? $customSql : "AND ($customSql)";
}

if (isset($_POST["searchKeyword"])) {
    $searchKeyword = $_POST["searchKeyword"];
    $customSql = "
    book_status =1 AND category_id LIKE ('%" . $searchKeyword . "%') ||
    book_status =1 AND bookcategory_id LIKE ('%" . $searchKeyword . "%') ||
    book_status =1 AND booksubject_id LIKE ('%" . $searchKeyword . "%') ||
    book_status =1 AND book_title LIKE ('%" . $searchKeyword . "%') ||
    book_status =1 AND book_author LIKE ('%" . $searchKeyword . "%') ||
    book_status =1 AND book_code LIKE ('%" . $searchKeyword . "%')";
    $sql .= empty($sql) ? $customSql : "AND ($customSql)";
}

//Pagination
$recordsPerPage = 12;
$recordsFetched = ($page - 1) * $recordsPerPage;  
$totalRecords = mysqli_num_rows(mysqli_query($conns,"SELECT * FROM books WHERE $sql"));
$totalPages = ceil($totalRecords / $recordsPerPage);

$completeSql = "SELECT * FROM books WHERE book_status =1 AND $sql ORDER BY RAND() DESC LIMIT $recordsFetched,$recordsPerPage ";
$query = mysqli_query($conns, $completeSql);
$products = '';
$pageBackgroundColor = 'background-color: #FCD116;';
$paginationData = '';
if ($page > 1) {
    $paginationData .=  '<li class="paginate_button page-item previous" ><a data-page="' . ($page - 1) . '" class="page-link" style="' . $pageBackgroundColor . '"><i class="previous"></i></a></li>';
} 

for ($i = 1; $i <= $totalPages; $i++) {
    $active = $i == $page ? "active": "";
    $paginationData .= '<li class="paginate_button page-item '. $active. '"><a data-page="' .$i. '" class="page-link" style="' . $pageBackgroundColor . '">' . $i . '</a></li>';
}

if ($totalPages > $page) {
    $paginationData .= '<li class="paginate_button page-item next" ><a data-page="' . ($page + 1) . '" class="page-link" style="' . $pageBackgroundColor . '"><i class="next"></i></a></li>';
}

$pagination = empty($paginationData) ? '' :  '<div class="card my-2 py-4">
                           <ul class="pagination"> ' . $paginationData . '</ul>
                </div>';

while ($row = mysqli_fetch_array($query)) {
    $book_image = $row["book_image"];
    $image_src =  $book_image;
    $products .= '<div class="product-card col-md-6 col-lg-4 col-xxl-3" style="align-items: center;">
                                    <div class="card h-100" style="text-align: center;">
                                        <div class="h-250px text-center card-heading">
                                                <img class="mh-250px img-fluid" src="../adminView/' . $image_src . '" alt="image" style=" margin-top: 10px;">
                                        </div>
                                        <hr>
                                        <div class="card-body p-4" >
                                        <div class="fs-4 text-gray-900 d-flex" >
                                        
                                            
                                            <div  class="ms-2 fw-bolder"  style="text-align: center;"> ' . $row["book_title"] . ' </div>
                                        </div>
                                            <a class="fs-5 wrap-text-1 fw-bold"  style="text-align: left;">' . $row["book_author"] . '</a>
                                            
                                        <div class="separator "></div>
                                        <br>
                                        <div class="fs-4 text-gray-700 d-flex">
                                        
                                            
                                            <div class="ms-2 fw-bolder" style="text-align: center;">' . $row["category_id"] . ' </div>
                                        </div>

                                        <div class="fs-4 text-gray-700 d-flex">
                                            
                                            <div class="ms-2 fw-bolder">' . $row["bookcategory_id"] . ' </div>
                                        </div>

                                        <div class="fs-4 text-gray-700 d-flex">
                                            
                                            <div class="ms-2 fw-bolder">' . $row["booksubject_id"] . ' </div>
                                        </div>
                                        <form method="GET" class="box" action="book.php">
                                        <div>
                                            <input type="text" name = "currBook_ID" value="'.$row['book_id'].'"hidden>
                                            <button class="btn" type="submit">View Full Details</button>
                                        </div>
                                        </form>
                                            
                                        </div>
                                    </div>
                                </div>';
}

if(!mysqli_num_rows($query)) $products .= '<div class="card min-h-400px col-lg-12">
    <div div="" class="card-body justify-align-center less-container">
        <center><img style="width: 200px;opacity: .5;"
                src="assets/images/empty_search.jpg" alt="">
            <h2>Sorry, no results found!</h2>
            <h4 class="text-muted">Please check the spelling or try searching for something else:)</h4>
        </center>
    </div>
</div>';

$output = new stdClass;
$output->products = $products;
$output->pagination = $pagination;
echo json_encode($output);
