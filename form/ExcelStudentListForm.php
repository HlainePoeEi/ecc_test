<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * 受講者エクセル登録Formクラス
 *
 */
class ExcelStudentListForm extends BaseForm{

	// 組織管理№
	public $org_no;
	//ファイル名
	public $file_name;
	//ファイル名１
	public $file_name1;
	//ファイル
	public $file;
	// 画像ファイルデータ
	public $image_data;
	// 画像ファイルエクステンション
	public $image_ext;
	//日付フラグ
	public $date_flg;
	//インプットファイル
	public $input_file;
	// 画像ファイルフラグ
	public $img_flg;
	//コーピ画像ファイル
	public $copy_image_file;
	//受講者データ
	public $student_data;
	// 組織管理ID
	public $org_id;
	// 組織フラグ
	public $org_name_flg;
	// DB組織名
	public $db_org_name;
}

?>