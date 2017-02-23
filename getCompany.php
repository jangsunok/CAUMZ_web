<?php




require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

//$result = $db->getCompany();

if (isset($_POST['location'])){
    $location = $_POST['location'];
    $result = NULL;

    if(isset($_POST['category'])){
        $result = $db->getCompany($location, $_POST['category']);
    }else{
        $result = $db->getCompany($location, NULL);
    }

    if ($result != false) {
        $response["error"] = false;     
        $data = [];
        for($x = 0; $x<count($result);$x++){
            $arr = array(
                "id" => $result[$x]->id,
                "title" => $result[$x]->title,
                "best_menu" => $result[$x]->best_menu,
                "like_count" => $result[$x]->like_count,
                "delivery" => $result[$x]->delivery);

            array_push($data, $arr);
        }
        $response["data"] = $data;
    
    echo json_encode($response);
    } else {
        //company is not found
        $response["error"] = TRUE;
        $response["error_msg"] = "정보가 없습니다.";
        echo json_encode($response);
    }
}else {
        //company is not found
        $response["error"] = TRUE;
        $response["error_msg"] = "post가 아닙니다.";
        echo json_encode($response);
    }

?>
