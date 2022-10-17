<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * コース詳細一覧FORMクラス
 *
 */
class CourseContractListForm extends BaseForm {

	public $se_course_id;

	public $course_id;
	// コース名ふりがな
	public $course_detail_romaji;
	// テスト区分
	public $test_kbn;
	// コースレベル
	public $course_level;
	// 状態
	public $status;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 科目管理№
	public $value;
	// 受講管理No.
	public $student_no;
	// 組織管理Id
	public $org_id;
	// 最大ページ
	public $max_page;
	// コース詳細管理№
	public $course_detail_no;
	// 組織名
	public $org_name;
	// 詳細名
	public $detail_name;
	// コース詳細名
	public $course_detail_name;
	// ログインId
	public $login_id;
	// 問題No
	public $question_no;
	// 合計マーク
	public $total_marks;
	// 点数
	public $score;
	// 回答日時
	public $answer_dt;
	// 回答フラグ
	public $answer_flg;
	//件数
	public $count;
	// 現ページ
	public $page;
	// 戻り用
	public $back_flg;
	// 検索ページ
	public $search_page;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索状態
	public $search_status;
	// 検索コース詳細
	public $search_course_detail_name;
	// テスト区分リスト
	public $test_kbn_list;
	// 検索コースレベル
	public $course_level_list;
	// 組織番号
	public $org_no;
	// 申込管理番号
	public $offer_no;
	// コース名
	public $course_name;
	// 検査コース名
	public $search_course_name;
	// 検査テスト区分名
	public $search_test_kbn;
	// 検査レベル
	public $search_course_level;
	// 検査組織名
	public $search_org_name;
	// 検査組織コード
	public $search_org_id;
	// 受講生数
	public $student_count;
	// テスト区分
	public $sc_test_kbn;
	// コースレベル
	public $sc_course_level;
	// 検査組織名
	public $sc_org_name;
	// 検査組織コード
	public $sc_org_id;
	// コース名
	public $sc_course_name;
	
	public $page_ccl;
	public $page_row_ccl;
	public $page_order_column_ccl;
	public $page_order_dir_ccl;
}

?>