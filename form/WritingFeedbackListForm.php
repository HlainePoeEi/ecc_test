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
 * WritingFeedBack一覧FORMクラス
 *
 */
class WritingFeedbackListForm extends BaseForm {

	// コースID
	public $course_id;
	// コース詳細番号
	public $course_detail_no;
	// コースID
	public $course_no;
	// テスト区分
	public $test_kbn;
	// コース名
	public $course_name;
	// コース名ふりがな
	public $course_name_kana;
	// コースレベル
	public $course_level;
	// 状態
	public $status;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// バリュー
	public $value;
	// 受講者管理№
	public $student_no;
	// 組織管理№
	public $org_no;
	// コース詳細名
	public $course_detail_name;
	// 申込管理№
	public $offer_no;
	// リスト
	public $list;
	// 結果
	public $result;
	// 回答日時
	public $answer_dt;
	// 戻し用
	public $back_flg;
	// 検索ページ
	public $search_page;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索詳細名
	public $search_detail_name;
	// 検索チェック状態
	public $search_chk_status;
	// 検索受講者名
	public $search_student_name;
	// 検索ログインId
	public $search_login_id;
	// 検索組織ID
	public $search_org_id;
	//組織名
	public $org_name;
	//ログインID
	public $stu_login_in;
	//氏名
	public $student_name;
}