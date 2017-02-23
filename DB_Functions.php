<?php
 
class DB_Functions {
 
    private $conn;
 
    // constructor
    function __construct() {
        require_once 'DB_Connect.php';
        // connecting to database
        $db = new Db_Connect();
        $this->conn = $db->connect();
        mysqli_set_charset($this->conn,"utf8");
    }
 
    // destructor
    function __destruct() {
         
    }
 

    
    
    public function getCompany($location, $category){
        $stmt = NULL;
        if(isset($category)){
            $stmt = $this->conn->prepare("SELECT * FROM company WHERE location = ? AND category = ? ORDER BY like_count DESC");
            $stmt->bind_param("ss", $location, $category);
        }else{
            $stmt = $this->conn->prepare("SELECT * FROM company WHERE location = ? ORDER BY like_count DESC");
            $stmt->bind_param("s", $location);
        }
        

        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_object()){
                $results[] = $row;
            }
            $stmt->close();
            return $results;
        } 
        return NULL;
    }

    public function getCompanyDetail($com_id){
        $stmt = $this->conn->prepare("SELECT * FROM company WHERE id = ?");
        $stmt->bind_param("s", $com_id);

        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_object();
        } 
        return NULL;
    }

    public function getTextMenu($company_id){
        $stmt = $this->conn->prepare("SELECT * FROM text_menu WHERE company_id = ?");
        $stmt->bind_param("i", $company_id);

        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_object()){
                $results[] = $row;
            }
            $stmt->close();
            return $results;
        } 
        return NULL;
    }

    public function getImageMenu($company_id){
        $stmt = $this->conn->prepare("SELECT * FROM image_menu WHERE company_id = ?");
        $stmt->bind_param("i", $company_id);

        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_object()){
                $results[] = $row;
            }
            $stmt->close();
            return $results;
        } 
        return NULL;
    }

 public function getRandomImageMenu($company_id){
        $stmt = $this->conn->prepare("SELECT * FROM image_menu WHERE company_id = ? ORDER BY RAND() LIMIT 1");
        $stmt->bind_param("i", $company_id);
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            return $res->fetch_object();
        } 
        return NULL;
    }

    public function getRandomCompany(){
        $stmt = $this->conn->prepare("SELECT * FROM company ORDER BY RAND() LIMIT 5");
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_object()){
                $results[] = $row;
            }
            $stmt->close();
            return $results;
        } 
        return NULL;
    }



    public function requestModify($company_id, $request){
        //INSERT INTO MyGuests (firstname, lastname, email) VALUES (?, ?, ?)
        $stmt = $this->conn->prepare("INSERT INTO modify_request(company_id, request) VALUES (?, ?)");
        $stmt->bind_param("is", $company_id, $request);
        $result = $stmt->execute();
        if ($result) {
            return true;
        }
        return false;
    }


    public function requestPhotoMenu($company_id, $title, $subtitle, $writer, $image){
        $stmt = $this->conn->prepare("INSERT INTO photomenu_request(company_id, title, subtitle, writer, image) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("issss", $company_id, $title, $subtitle, $writer, $image);
        $result = $stmt->execute();
        if ($result) {
            return true;
        }
        return false;
    }


    public function searchCompany($keyword){
        $stmt = $this->conn->prepare("SELECT * FROM company WHERE title LIKE ?");
        $stmt->bind_param("s", $keyword);   
        $stmt->execute();
        $res = $stmt->get_result();
        if ($res->num_rows > 0) {
            while ($row = $res->fetch_object()){
                $results[] = $row;
            }
            $stmt->close();
            return $results;
        } 
        return false;
    }

    public function setLike($company_id){
        $stmt = $this->conn->prepare("UPDATE company SET like_count=like_count+1 WHERE id = ?");
        $stmt->bind_param("i", $company_id);
        $result = $stmt->execute();
        if ($result) {
            return true;
        }
        return false;
    }

    public function setDislike($company_id){
        $stmt = $this->conn->prepare("UPDATE company SET like_count=like_count-1 WHERE id = ?");
        $stmt->bind_param("i", $company_id);
        $result = $stmt->execute();
        if ($result) {
            return true;
        }
        return false;
    }
       
}


 
?>