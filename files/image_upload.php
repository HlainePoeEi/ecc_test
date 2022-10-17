<?php

define ( "TOP_DIR", "/var/www/html" );
define ( "STU_FILE_DIR", "/student_dev/" );
define ( "FOLDER_DIR", "files/" );
define ( "IMAGE_DIR", "image/" );
define ( "ADMIN_HOME_DIR", "/admin_dev/" );

if(isset($_FILES['image']))
{

	$img = $_FILES['image'];

	//ファイルの拡張子設定
	$ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);

	if ( $_POST['gamen_name'] ==  "TestInfo" || $_POST['gamen_name'] == "QuizInfo" || $_POST['gamen_name'] == "Quiz" || $_POST['gamen_name'] == "Test"){
		
		//保存するファイルパス設定
		$path =  TOP_DIR . ADMIN_HOME_DIR . FOLDER_DIR . $_POST['orgNo']."/" . $_POST['gamen_name']."/" . IMAGE_DIR;
		
		if (! is_dir ( $path)) {
			$res = mkdir ( $path, 0777 ,true);
		}
		
		//ファイルの連番設定
		$files = glob(  $path .$_POST['name'] . "*.{jpg,gif,png}", GLOB_BRACE);
		$imgCnt = count($files);
		$nextNo = str_pad(++$imgCnt, 3, "0", STR_PAD_LEFT);
		
		//ファイルのディレクトリ作成
	//	mkdir( TOP_DIR . ADMIN_HOME_DIR . FOLDER_DIR .$_POST['orgNo']."/" .$_POST['gamen_name']. IMAGE_DIR, 0777, TRUE);
		
		//ファイル名設定
		$fileName =  $_POST['name'] ."_" . $nextNo . "." .  $ext;

		//ファイルのディレクトリ作成
		$link =  ADMIN_HOME_DIR . FOLDER_DIR .$_POST['orgNo']."/" . $_POST['gamen_name']."/" . IMAGE_DIR . $fileName;
		
	}else if($_POST['gamen_name'] ==  "Question"){
		
		//保存するファイルパス設定
		$path = TOP_DIR. STU_FILE_DIR. FOLDER_DIR. IMAGE_DIR;
		
		if (! is_dir ( $path)) {
			$res = mkdir ( $path, 0777 ,true);
		}
	
		//ファイルの連番設定
		$files = glob( $path.$_POST['name'] . "*.{jpg,gif,png,jpeg,JPG,PNG,JPEG}", GLOB_BRACE);
		$imgCnt = count($files);
		$nextNo = str_pad(++$imgCnt, 3, "0", STR_PAD_LEFT);
		
		//ファイル名設定
		$fileName =  $_POST['name'] ."_" . $nextNo . "." .  $ext;
		
		$link = STU_FILE_DIR. FOLDER_DIR. IMAGE_DIR. $fileName;
	} 

	//ファイルをアップロード先フォルダへアップ
	move_uploaded_file($img['tmp_name'], $path. $fileName);

	//画像データ設定
	$data = getimagesize($path. $fileName);

	//画像情報をJSON Objectに設定
	$res = array("data" => array(
			"link" => $link,
			"width" => $data[0],
			"height" => $data[1]));
	//戻り値 JSON
	echo json_encode($res);

}
?>