<?php

//require 'S3Config.php';

// Include the AWS SDK using the Composer autoloader
require 'vendor/autoload.php';

require_once 'DB_Functions.php';
$db = new DB_Functions();

// json response array

$response = array("error" => FALSE);

//requestModify($company_id, $request)
if (
	isset($_POST['company_id']) and isset($_POST['title']) 
	and isset($_POST['subtitle']) and isset($_POST['writer']) and isset($_FILES['image']) ){
	
	$param = Array('region'=>'ap-northeast-2', 'version'=>'latest');
	$s3Client = new Aws\S3\S3Client($param);

	$s3Client->putObject(Array(
	    'ACL'=>'public-read',
	    'SourceFile'=>$_FILES['image']['tmp_name'],
	    'Bucket'=>'jdmzphoto',
	    'Key'=>'request/' . basename($_FILES['image']['name']),
	    'ContentType'=>$_FILES['image']['type']
	));

	$imgUrl = basename($_FILES['image']['name']);

	$result = $db->requestPhotoMenu($_POST['company_id'], $_POST['title'],
		$_POST['subtitle'], $_POST['writer'], $imgUrl);

	if($result){
		$response["error"] = false;
		$response["mgs"] = "요청완료";

		require_once 'sendMail.php';
        $mail = new SEND_MAIL();
        $mail->sendPhotoRequest($_POST['title'], $_POST['subtitle'],$_POST['writer'], $_POST['company_id']);
        
		echo json_encode($response);
	}else{
		$response["error"] = TRUE;
		$response["mgs"] = "데이터 입력 오류발생";
		echo json_encode($response);
	}
}else {
    $response["error"] = TRUE;
    $response["error_msg"] = "post가 아닙니다.";
    echo json_encode($response);
}
        


?>
