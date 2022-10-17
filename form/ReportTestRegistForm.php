<?php

require_once 'BaseForm.php';
/**
 * レポート．テスト設定FORMクラス
 *
 */
class ReportTestRegistForm extends BaseForm{
	// 組織管理№
	public $org_no;
	public $report_no;
	public $report_name;
	public $org_id;
	public $checked_test;
	public $entryList;
	// テスト管理№
	public $test_info_no;
	// テスト名
	public $test_info_name;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 更新備考
	public $remarks;
	// 削除フラグ
	public $del_flg;
	// 登録日時
	public $create_dt;
	// 登録者ＩＤ
	public $creater_id;
	// 更新日時
	public $update_dt;
	// 更新者ＩＤ
	public $updater_id;
	//件数
	public $count;
	// 現ページ
	public $page;
	//最大ページ
	public $max_page;
	public $rd_status1;
	public $rd_status2;
	public $chk_status1;
	public $chk_status2;
	public $quiz_count;
	public $status;
	public $rdstatus;
	public $screen_mode;
	//戻り用
	public $back_flg;
	public $search_start_period;
	public $search_end_period;
	public $search_test_info_name;
	public $search_remark;
	public $search_rd_status1;
	public $search_rd_status2;
	public $search_rdstatus;
	public $search_chk_status1;
	public $search_chk_status2;
	public $search_status;
	public $search_org_id;
	public $search_page_til;
	public $search_page_row_til;
	public $search_page_order_column_til;
	public $search_page_order_dir_til;
	public $search_report_name;
	public $search_page;
	
}