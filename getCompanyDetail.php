<?php




require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);

//$result = $db->getCompany();

if (isset($_POST['com_id'])){

    $result = $db->getCompanyDetail($_POST['com_id']);

    if ($result != false) {
        
        $response["error"] = false;     
        $data = [];
        
        $arr = array(
                "id" => $result->id,
                "title" => $result->title,
                "location" => $result->location,
                "address" => $result->address,
                "category" => $result->category,
                "tel" => $result->tel,
                "operate_time" => $result->operate_time,
                "best_menu" => $result->best_menu,
                "image" => $result->image,
                "like_count" => $result->like_count,
                "delivery" => $result->delivery);
        $data["info"] = $arr;

        //text_menu

        $text_menu = $db->getTextMenu($result->id);
        $tmenu = [];
        for($x = 0; $x<count($text_menu);$x++){
            $tarray = array(
                "title" => $text_menu[$x]->title,
                "subtitle" => $text_menu[$x]->subtitle,
                "price" => $text_menu[$x]->price
                );
            array_push($tmenu, $tarray);
        }
        $data["tmenu"] = $tmenu;


        //img_menu

        $img_menu = $db->getImageMenu($result->id);
        $imenu = [];
        for($x = 0; $x<count($img_menu);$x++){
            $iarray = array(
                "menu_title" => $img_menu[$x]->menu_title,
                "menu_subtitle" => $img_menu[$x]->menu_subtitle,
                "menu_image" => $img_menu[$x]->menu_image,
                "menu_writer" => $img_menu[$x]->menu_writer
                );
            array_push($imenu, $iarray);
        }
        $data["imenu"] = $imenu;



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
