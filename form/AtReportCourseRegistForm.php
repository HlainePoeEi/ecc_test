<?php

require_once 'BaseForm.php';
/**
 * Atレポート．コース設定FORMクラス
 *
 */
class AtReportCourseRegistForm extends BaseForm{
	// 組織管理№
	public $org_no;
	public $at_report_no;
	public $at_report_name;
	public $org_id;
	public $checked_test;
	public $entryList;

	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;

	//戻り用
	public $back_flg;
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
	public $search_at_report_name;
	public $search_test_info_name;
	public $search_org_id;
	
}