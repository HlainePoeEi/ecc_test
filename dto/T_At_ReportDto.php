<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * AT レポートテーブルDTOクラス
 */
class T_At_ReportDto extends BaseDto {

	//組織管理№
	public $org_no;
	public $org_id;
	//テストデータ
	public $test_info_name;
	public $test_info_no;
	public $org_name_official;
	public $disp_no;
	public $str_sql;
	//ATレポート管理№
	public $at_report_no;
	//ATレポート名
	public $at_report_name;
	// ATレポート．ファイル
	public $file_name;
	public $file_data;

	//最大ページ
	public $screen_mode;
	public $show_flg;
	public $preview_flg;
	public $start_period;
	public $end_period;
	public $result_start_period;
	public $result_end_period;
	public $status;
	public $input_file;
	public $today_date;
	//戻り用
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
}

?>