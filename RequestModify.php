

<?php




require_once 'DB_Functions.php';
$db = new DB_Functions();
 
// json response array
$response = array("error" => FALSE);
//requestModify($company_id, $request)
if (isset($_POST['company_id']) and isset($_POST['request'])){
    $result = $db->requestModify($_POST['company_id'], $_POST['request']);

    if ($result != false) {
        $response["error"] = false;     
        $response["msg"] = "요청접수완료";
        require_once 'sendMail.php';
        $mail = new SEND_MAIL();
        $mail->sendRequestMail($_POST['request'], $_POST['company_id']);
    
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
