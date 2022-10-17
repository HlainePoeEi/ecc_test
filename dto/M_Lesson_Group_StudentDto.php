<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * 受講生DTOクラス
 */
class M_Lesson_Group_StudentDto extends BaseDto {

	// レッスン管理№
	public $lesson_no;
	// レッスン名
	public $lesson_name;
	// レッスン学年
	public $gradeName;
	// レッスン利用開始
	public $lesson_start_period;
	// レッスン利用終了
	public $lesson_end_period;
	// グループ管理番号
	public $group_no;
	// グループ名
	public $group_name;
	// グループ学年
	public $groupGradeName;
	// グループ利用開始
	public $gp_start_period;
	// グループ利用終了
	public $gp_end_period;
	// 受講者管理番号
	public $student_no;
	// 受講者ログインＩＤ
	public $login_id;
	// 受講者名
	public $student_name;
	// 番号
	public $no;
	// 性別
	public $sex;
	// 受講者利用開始
	public $stu_enroll_dt;
	// 受講者利用終了
	public $stu_graduation_dt;
}

?>