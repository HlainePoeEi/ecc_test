<?php
require_once 'BaseDto.php';

/**
 * テスト情報DTOクラス
 */
class T_Test_InfoDto extends BaseDto {
	// 組織管理№
	public $org_no;
	// テスト管理№
	public $test_info_no;
	// テスト名
	public $test_info_name;
	// 説明
	public $long_description;
	// 結果表示
	public $show_flg;
	// ドリルフラグ
	public $drill_flg;
	// 受講時間
	public $test_time;
	// 状態
	public $status;
	// 状態
	public $start_period;
	// 利用終了日
	public $end_period;
	// 更新備考
	public $remarks;
}

?>