<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co.; Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * レポートテスト情報テーブルDTOクラス
 */
class T_Report_Test_InfoDto extends BaseDto {

	public $org_no;
	public $org_id;
	public $report_no;
	public $report_name;
	public $show_flg;
	public $file_name;
	public $test_info_no;
	public $test_info_name;
	public $lesson_no;
	public $lesson_name;
	public $group_name;
	public $disp_no;
	public $student_no;
	public $student_name;
	public $answer_dt;
	public $quiz_info_no;
	public $quiz_item_no;
	public $ans_option_no;
	public $correct_flag;
	public $totalM;
	public $answer_detail;
}

?>