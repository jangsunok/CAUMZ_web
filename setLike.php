<?php
require_once 'DB_Functions.php';
$db = new DB_Functions();

// json response array
$response = array("error" => FALSE);

if (isset($_POST['company_id'])) {


    $result = $db->setLike($_POST['company_id']);
    if ($result) {
        //company is found
        $response["error"] = false;
        $response["msg"] = "success";
        
        echo json_encode($response);
    } else {
        //company is not found
        $response["error"] = TRUE;
        $response["error_msg"] = "result is null";
        echo json_encode($response);
    }
}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "can;t get post data";
    echo json_encode($response);
}
?>
