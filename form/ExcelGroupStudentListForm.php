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
 * グループ・受講者エクセル登録Formクラス
 *
 */
class ExcelGroupStudentListForm extends BaseForm{

	//ファイル名
	public $file_name;
	//ファイル
	public $file;
	//画像ファイルデータ
	public $image_data;
	//画像ファイルエクステンション
	public $image_ext;
	//日付フラグ
	public $date_flg;
	//インプットファイル
	public $input_file;
	//画像ファイルフラグ
	public $img_flg;
	//コーピ画像ファイル
	public $copy_image_file;
	//受講者データ
	public $group_student_data;
	//組織管理ID
	public $org_id;
	//組織名フラグ
	public $org_name_flg;
	//組織名
	public $db_org_name;
	//組織ID
	public $db_org_id;
	//グループ管理№リスト
	public $grpNoList;
	//受講者管理№リスト
	public $stuNoList;
	// グループ・受講者登録行
	public $groupstu_max_count;

}
?>