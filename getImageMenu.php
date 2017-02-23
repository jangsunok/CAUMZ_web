<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

if (isset($_POST['company_id'])){
    $result = $db->getImageMenu($_POST['company_id']);
    if ($result != false) {
        $response["error"] = false;     
        $data = [];
        for($x = 0; $x<count($result);$x++){
            $arr = array(
                "menu_title" => $result[$x]->menu_title,
                "menu_subtitle" => $result[$x]->menu_subtitle,
                "menu_image" => $result[$x]->menu_image,
                "menu_writer" => $result[$x]->menu_writer);

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