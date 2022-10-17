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
 * Tコース詳細受講生DTOクラス
 */
class T_Course_Detail_StudentDto extends BaseDto {

	// 組織管理№
	public $org_no;
	// 組織コード
	public $org_id;
	// 組織名
	public $org_name;
	// 正式組織名
	public $org_name_official;
	// 申込管理№
	public $offer_no;
	// 受講者管理№
	public $student_no;
	// コースID
	public $course_id;
	// コース名
	public $course_name;
	// 更新備考
	public $remarks;
	// コース詳細管理№
	public $course_detail_no;
	// コース詳細の表示順
	public $course_detail_name;
	// コース詳細名
	public $course_detail_romaji;
	// 表示順
	public $disp_no;
	// 状態
	public $status;
	// コースレベル名
	public $course_level;
	// テスト区分名
	public $test_kbn;
	// 受講者名
	public $student_name;
	// 受講者名
	public $student_name_romaji;
	// ログインID
	public $login_id;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 利用開始日
	public $stu_course_start_period;
	// 利用終了日
	public $stu_course_end_period;
	// 回答日時
	public $answer_dt;
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
	// 利用開始日
	public $course_start_period;
	// 利用終了日
	public $course_end_period;
}

?>