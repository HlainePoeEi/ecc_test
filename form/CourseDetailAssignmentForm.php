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
 * コース詳細割当FORMクラス
 *
 */
class CourseDetailAssignmentForm extends BaseForm {

	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// コース詳細管理№
	public $course_detail_no;
	// 詳細名
	public $detail_name;
	// コース詳細名
	public $course_detail_name;
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
	public $search_course_name;
	// 検索テスト区分
	public $search_test_kbn;
	// 検索コースレベル
	public $search_course_level;
	// コースID
	public $course_id;
	// 表示順
	public $disp_no;
	// コース名
	public $course_name;
	// コースレベル
	public $course_level;
	// テスト区分
	public $test_kbn;

	public $clevel;
	// リスト
	public $entryList;
	// 状態
	public $rd_status;
}