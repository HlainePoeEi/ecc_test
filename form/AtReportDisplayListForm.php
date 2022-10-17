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
 * Atレポート試験・コース並び順設定FORMクラス
 *
 */
class AtReportDisplayListForm extends BaseForm{

	//組織管理№
	public $org_no;
	// レポート番号
	public $at_report_no;
	
	//リスト
	public $entryList;

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