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
class APMQuizInfoAssignForm extends BaseForm{

	public $exam_id;

	public $exam_name;

	public $start_date;

	public $end_date;
	
	//組織管理№
	public $org_no;
	//テスト名
	public $quiz_name;
	//更新備考
	public $remarks;
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
	public $test_info_no;
	//レッスン名
	public $test_info_name;
	//テスト管理№
	public $quiz_info_no;
	//リスト
	public $entryList;

	public $rd_status;

	//戻り用
	public $back_flg;
	public $search_page;
	public $search_start_period;
	public $search_end_period;
	public $search_test_name;
	public $search_remark;
	public $search_quiz_name;
	public $search_rd_status1;
	public $search_rd_status2;
	public $search_rdstatus;
	public $search_chk_status1;
	public $search_chk_status2;
	public $search_status;
	public $search_org_id;
	/**
	 * 戻るの場合リストか登録かの画面を分けるため
	 * ないフィールドを追加
	 */
	public $btn_flg_type;
	public $ori_test_no;
	public $test_quiz_count;
	public $status;
	public $description;
	public $test_start_period;
	public $test_end_period;
	public $test_remarks;
	public $btn_value;
	public $screen_mode;
	public $hd_test_type;
	public $test_btn_flg;
	public $test_date_flg;
	public $test_test_info_name;
	
	//　試験一覧　Datatable用
	public $search_page_til;
	public $search_page_row_til;
	public $search_page_order_column_til;
	public $search_page_order_dir_til;
}

?>