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
 * コース受講生登録FORMクラス
 *
 */
class CourseStudentRegistForm extends BaseForm{

	// コースID
	public $course_id;
	// コース名
	public $course_name;
	// コース名ローマ字
	public $course_name_romaji;
	// 申込管理№
	public $offer_no;
	// 組織管理№
	public $org_no;
	// 組織名
	public $org_name;
	// 正式組織名
	public $org_name_official;
	// 組織管理Id
	public $org_id;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// ログインID
	public $login_id;
	// グループ名
	public $group_name;
	// 検索グループ名
	public $search_group;
	// 検索ログインID
	public $search_login_id;
	// コース詳細利用開始日
	public $course_detail_start_period;
	// コース詳細 利用終了日
	public $course_detail_end_period;

	public $se_course_id;
	public $search_page;
	public $contract_start_period;
	public $contract_end_period;
	public $search_start_period;
	public $search_end_period;
	public $search_org_id;
	public $search_org_name;
	public $search_test_kbn;
	public $search_course_level;
	public $search_course_name;
	public $remarks;
	public $btn_flag;
	public $contract_list_start_period;
	public $contract_list_end_period;

	public $student_noString;
	public $course_noString;
	public $course_dt_start_period;
	public $course_dt_end_period;
	public $course_dt_list;
	
	public $page_ccl;
	public $page_row_ccl;
	public $page_order_column_ccl;
	public $page_order_dir_ccl;
}

?>