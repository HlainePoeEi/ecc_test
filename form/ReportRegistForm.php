<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * レポート登録FORMクラス
 *
 */
class ReportRegistForm extends BaseForm{
	
	// 組織管理№
	public $org_no;
    public $org_id;
	public $org_name;
	public $org_name_official;
	// レポート管理№
	public $report_no;
	// レポート名
	public $report_name;
	//テスト管理№
	public $test_info_no;
	// 更新備考
	public $file_name;
	public $file_data;
	public $file_chk_del;
	public $chk_status2;
	// 更新者ID
	public $updater_id;
	// 現ページ
	public $page;
	//最大ページ
	public $max_page;
	public $screen_mode;
    public $show_flg;
    public $input_file;
	public $exit_file;
	public $image_ext;
	//戻り用
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
	public $search_report_name;
	public $search_test_info_name;
	public $search_org_id;

}