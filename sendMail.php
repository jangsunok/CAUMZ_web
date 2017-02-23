<?php

class SEND_MAIL {
	public function sendRequestMail($request, $com_id){
		$to = "okkidev@gmail.com";
		$subject = "중앙대맛집 수정요청";
		$message = "request = ".$request."\ncom_id = ".$com_id;
		$from = " caumz@example.com";
		$headers = "com_id:" . $com_id;
		mail($to,$subject,$message,$headers);
	}

	public function sendPhotoRequest($title, $subtitle, $writer, $com_id){
		$to = "okkidev@gmail.com";
		$subject = "중앙대맛집 사진제보";
		$message = "title : ".$title ."\nsubtitle : ".$subtitle."\nwriter : ". $writer."\ncom_id : ".$com_id;
		$from = " caumz@example.com";
		$headers = "com_id:" . $com_id;
		mail($to,$subject,$message,$headers);
	}
} 

?>