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
 * 受講者契約情報エクセル登録Formクラス
 *
 */
class ExcelContract2SkillListForm extends BaseForm{

	// 組織管理№
	public $org_no;
	//ファイル名
	public $file_name;
	//ファイル名１
	public $file_name1;
	//ファイル
	public $file;
	// ファイルデータ
	public $file_data;
	// ファイルエクステンション
	public $file_ext;
	//インポートファイル
	public $input_file;
	// 画像ファイルフラグ
	public $img_flg;
	//コピー画像ファイル
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