<?php

define ( "TOP_DIR", "/var/www/html" );
define ( "STU_FILE_DIR", "/student_dev/" );
define ( "FOLDER_DIR", "files/" );
define ( "IMAGE_DIR", "image/" );

if(isset($_FILES['image']))
{

	$img = $_FILES['image'];

	//保存するファイルパス設定
	$stu_dir = TOP_DIR. STU_FILE_DIR. FOLDER_DIR. IMAGE_DIR;

	if (! is_dir ( $stu_dir)) {
		$res = mkdir ( $stu_dir, 0777 ,true);
	}

	//ファイルの拡張子設定
	$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
	
	//ファイル名設定
	$fileName = "V_"  . $_POST['name'] ."_001." .  $ext;

	$link = STU_FILE_DIR. FOLDER_DIR. IMAGE_DIR. $fileName;

	//ファイルをアップロード先フォルダへアップ
	move_uploaded_file($img['tmp_name'], $stu_dir. $fileName);

	//画像データ設定
	$data = getimagesize($stu_dir. $fileName);

	//画像情報をJSON Objectに設定
	$res = array("data" => array(
			"link" => $link,
			"width" => $data[0],
			"height" => $data[1]));
	//戻り値 JSON
	echo json_encode($res);

}
?>