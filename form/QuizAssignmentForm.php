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
 * サブ管理者一覧FORMクラス
 *
 */
class QuizAssignmentForm extends BaseForm{

	//組織管理№
	public $org_no;
	//行数
	public $rowno;
	//テストタイプ
	public $quiz_type;
	//テストタイプ
	public $test_type;
	//日付(From)
	public $start_period;
	//日付(To)
	public $end_period;
	//件数
	public $count;
	// 現ページ
	public $page;
	//最大ページ
	public $max_page;
	//レッスン管理№
	public $test_no;
	//レッスン名
	public $test_name;
	//テスト管理№
	public $quiz_no;
	//リスト
	public $entryList;
	
	// TestList Datatable用
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;

    //戻り用
	public $back_flg;
	public $search_page;
	public $search_start_period;
	public $search_end_period;
	public $search_test_name;
	public $search_remark;
	public $search_rd_status1;
	public $search_rd_status2;
	public $search_rdstatus;
	public $search_chk_status1;
	public $search_chk_status2;
	public $search_status;
	public $search_org_id;
}

?>