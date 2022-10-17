<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * テストDTOクラス
 */
class T_TestDto extends BaseDto {
	//組織管理№
	public $org_no;
	//テスト管理№
	public $test_no;
	//テスト名
	public $test_name;
	//テストタイプ
	public $test_type;
	//テストタイプ
	public $test_type_name;
	//テスト問題数
	public $test_quiz_count;
	//説明
	public $description;
	//状態
	public $status;
	//状態
	public $start_period;
	//利用終了日
	public $end_period;
	//更新備考
	public $remarks;

}

?>