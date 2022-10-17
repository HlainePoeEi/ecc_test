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
 * クイズ情報結果詳細FORMクラス
 *
 */
class QuizInfoResultDetailForm extends BaseForm{
	// 組織管理№
	public $org_no;
	//テスト管理№
	public $test_info_no;
	//レッスン管理№
	public $lesson_no;
	//グループ管理№
	public $group_no;
	//受講者管理№
	public $student_no;
	//テスト名
	public $test_info_name;
	//レッスン名
	public $lesson_name;
	//グループ名
	public $group_name;
	//ログインID
	public $login_id;
	//受講者名
	public $student_name;
	//クイズ内容
	public $long_description;
	//回答数
	public $answer_cnt;
	//正解数
	public $correct_cnt;
	//回答日時
	public $answer_dt;
	//件数
	public $count;
	// 現ページ
	public $page_qird;
	//最大ページ
	public $max_page;

	//戻る用
	public $back_flg;
	public $search_page;
	public $search_result_list_page;
	public $search_lesson_name;
	public $search_test_info_name;
	public $search_start_period;
	public $search_end_period;
	public $col;
	
	public $page_row_qird;
	public $page_order_column_qird;
	public $page_order_dir_qird;
	
	// QuizInfoResultList データテーブル用
	public $page_row_qirl;
	public $page_order_column_qirl;
	public $page_order_dir_qirl;
	public $page_qirl;
	
	// TestInfoResultListデータテーブル用
	public $page_row_tirl;
	public $page_order_column_tirl;
	public $page_order_dir_tirl;
	// 現ページ
	public $page_tirl;

}

?>

