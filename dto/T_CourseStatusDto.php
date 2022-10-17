<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

class T_CourseStatusDto extends BaseDto {
	// コースID
	public $course_id;
	// コース名
	public $course_name;
	// コース名ふりがな
	public $course_name_romaji;
	//テスト区分
	public $test_kbn;
	// コースレベル
	public $course_level;
	// 状態
	public $status;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;

	public $student_mark;

	public $total_mark;
}

?>