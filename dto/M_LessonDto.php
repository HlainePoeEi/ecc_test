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
 * レッソンDTOクラス
 */
class M_LessonDto extends BaseDto{

	//組織管理№
	public $org_no;
	//レッスン管理№
	public $lesson_no;
	//レッスン名
	public $lesson_name;
	//レッスン名ふりがな
	public $lesson_name_kana;
	//学年管理№
	public $grade_no;
	//科目管理№
	public $subject_no;
	//出欠対象
	public $attendance_flg;
	//レッスン回数
	public $lesson_count;
	//状態
	public $status;
	//利用開始日
	public $start_period;
	//利用終了日
	public $end_period;
	//更新備考
	public $remarks;

}

?>