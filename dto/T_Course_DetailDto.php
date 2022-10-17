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
 *Tコース詳細DTOクラス
 */
class T_Course_DetailDto extends BaseDto {

	// コースID
	public $course_id;
	// コース詳細管理№
	public $course_detail_no;
	// コース詳細名
	public $course_detail_name;
	// コース詳細ローマ字
	public $course_detail_romaji;
	// コースレベル
	public $course_level;
	// テスト区分
	public $test_kbn;
	// 状態
	public $status;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// コース名
	public $course_name;
	// 番号
	public $rowno;
	// 表示順
	public $disp_no;
}

?>