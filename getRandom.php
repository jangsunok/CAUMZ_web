<?php

require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
$result = $db->getRandomCompany();
if ($result != NULL) {
    $response["error"] = false;     
    $data = [];
    for($x = 0; $x<count($result);$x++){
        $arr = array(
            "id" => $result[$x]->id,
            "title" => $result[$x]->title,
            "location" => $result[$x]->location,
            "best_menu" => $result[$x]->best_menu,
            "category" => $result[$x]->category,
            "delivery" => $result[$x]->delivery);

        
        $imenu = $db->getRandomImageMenu($result[$x]->id);

        if($imenu!=false){
            $arr2 = array(
            "menu_title" => $imenu->menu_title,
            "menu_subtitle" => $imenu->menu_subtitle,
            "menu_image" => $imenu->menu_image,
            "menu_writer" => $imenu->menu_writer);

            $arr = array_merge($arr, $arr2);
        }

        array_push($data, $arr);
    }
    $response["data"] = $data;


    
    $response["data"] = $data;    
    
    echo json_encode($response);
    } else {
        //company is not found
        $response["error"] = TRUE;
        $response["error_msg"] = "정보가 없습니다.";
        echo json_encode($response);
    }

?>