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
 * 担当者．教科．レッスンDTOクラス
 */
class T_Manager_SubjectArea_LessonDto extends BaseDto {

	// 担当者管理番号
	public $manager_no;
	// 担当者名
	public $manager_name;
	// 担当者ログインＩＤ
	public $login_id;
	// 担当者利用開始
	public $manager_start_period;
	// 担当者利用終了
	public $manager_end_period;
	// 教科名
	public $subject_area_name;
	// レッスン管理番号
	public $lesson_no;
	// レッスン名
	public $lesson_name;
	// レッスン利用開始
	public $lesson_start_period;
	// レッスン利用終了
	public $lesson_end_period;
	// 科目名
	public $subject_name;
}

?>