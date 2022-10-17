<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * レポートテーブルDTOクラス
 */
class T_ReportDto extends BaseDto {

	//組織管理№
    public $org_no;
    public $org_id;
	//テストデータ
	public $test_info_name;
	public $test_info_no;
	public $org_name_official;
	public $disp_no;
	public $str_sql;
	//レポート管理№
	public $report_no;
	//レポート名
	public $report_name;
	// レポート．ファイル
	public $file_name;
	public $file_data;
	// 削除フラグ
	public $del_flg;
	// 更新者ID
	public $updater_id;
	// 現ページ
	public $page;
	//最大ページ
	public $max_page;
	public $screen_mode;
    public $show_flg;
    public $input_file;
	public $today_date;
	//戻り用
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
}

?>