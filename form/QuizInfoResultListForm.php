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
 * クイズ結果一覧Formクラス
 *
 */
class QuizInfoResultListForm extends BaseForm{

	//レッスン名
	public $lesson_name;
	//テスト名
	public $test_info_name;
	//グループ名
	public $group_name;
	//受講者管理№
	public $student_no;
	//受講者名
	public $student_name;
	//レッスン管理№
	public $lesson_no;
	//テスト管理№
	public $test_info_no;
	//グループ管理№
	public $group_no;
	//番号
	public $no;
	//ログインID
	public $login_id;
	//件数
	public $count;
	// 現ページ
	public $page;
	//最大ページ
	public $max_page;
	
	public $create_dt;

	//戻る用
	public $back_flg;
	public $search_page;
	public $search_result_list_page;
	public $search_lesson_name;
	public $search_group_name;
	public $search_test_info_name;
	public $search_start_period;
	public $search_end_period;
	
	// TestInfoResultListデータテーブル用
	public $page_row_tirl;
	public $page_order_column_tirl;
	public $page_order_dir_tirl;
	// 現ページ
	public $page_tirl;
	
	// データテーブル用
	public $page_row_qirl;
	public $page_order_column_qirl;
	public $page_order_dir_qirl;
	public $page_qirl;
}

?>