<?php

class Rating{
	private $host  = '127.0.0.1:4306';
    private $user  = 'root';
    private $password   = "";
    private $database  = "librabees_DB";    
	private $itemUsersTable = 'users';
	private $itemTable = 'books';	
    private $itemRatingTable = 'review';
	private $dbConnect = false;
    public function __construct(){
        if(!$this->dbConnect){ 
            $conn = new mysqli($this->host, $this->user, $this->password, $this->database);
            if($conn->connect_error){
                die("Error failed to connect to MySQL: " . $conn->connect_error);
            }else{
                $this->dbConnect = $conn;
            }
        }
    }
	private function getData($sqlQuery) {
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if(!$result){
			
		}
		$data= array();
		while ($row = mysqli_fetch_array($result)) {
			$data[]=$row;            
		}
		return $data;
	}
	
		
	
	
	public function getItemRating($itemId){
		$sqlQuery = "
			SELECT r.review_id, r.book_id, r.stud_id, u.stud_number, u.stud_first_name, r.ratingNumber, r.title, r.comments, r.created
			FROM ".$this->itemRatingTable." as r
			LEFT JOIN ".$this->itemUsersTable." as u ON (r.stud_id = u.stud_id)
			WHERE r.book_id = '".$itemId."'";
		return  $this->getData($sqlQuery);		
	}
	
	public function saveRating($POST, $userID){		
		$insertRating = "INSERT INTO ".$this->itemRatingTable." (itemId, userId, ratingNumber, title, comments, created, modified) VALUES ('".$POST['itemId']."', '".$userID."', '".$POST['rating']."', '".$POST['title']."', '".$POST["comment"]."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')";
		mysqli_query($this->dbConnect, $insertRating);	
	}
}
?>