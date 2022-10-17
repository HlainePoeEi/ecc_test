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
 * AtReportListFormクラス
 *
 */
class AtReportListForm extends BaseForm{

	// 組織管理№
	public $org_no;
	public $org_id;
	// レポート管理№
	public $at_report_no;
	//レポート名
	public $at_report_name;
	// 試験番号
	public $test_info_no;
	// 試験名
	public $test_info_name;

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

?>