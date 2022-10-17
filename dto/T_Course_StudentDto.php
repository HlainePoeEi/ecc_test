<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDto.php';

/**
 * Tコース受講生DTOクラス
 */
class T_Course_StudentDto extends BaseDto {

	// 組織管理№
	public $org_no;
	// 組織名
	public $org_name;
	// 申込管理№
	public $offer_no;
	// 正式組織名
	public $org_name_official;
	// 組織コード
	public $org_id;
	// コースID
	public $course_id;
	// コース名
	public $course_name;
	// コース名ローマ字
	public $course_name_romaji;
	// 受講者管理№
	public $student_no;
	// 受講者名
	public $student_name;
	// ログインID
	public $login_id;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 削除フラグ
	public $del_flg;
	// 登録者ＩＤ
	public $creater_id;
	// 登録日時
	public $create_dt;
	// 更新者ＩＤ
	public $updater_id;
	// 更新日時
	public $update_dt;
}

?>