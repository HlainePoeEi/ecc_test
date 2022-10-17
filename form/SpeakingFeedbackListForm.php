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
 * SpeakingFeedBack一覧FORMクラス
 *
 */

class SpeakingFeedbackListForm extends BaseForm{

	// コース詳細管理№
	public $course_detail_no;
	// 受講番号
	public $student_no;
	// 問題No
	public $question_no;
	// 申込管理№
	public $offer_no;
	// コース詳細名
	public $course_detail_name;
	// コース名
	public $course_name;
	// テスト区分
	public $test_kbn;
	// コースID
	public $course_id;
	// 組織管理№
	public $org_no;
	// 利用終了日
	public $end_period;
	// 戻し用
	public $back_flg;
	// 検索ページ
	public $search_page;
	// 検索組織ID
	public $search_org_id;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索詳細名
	public $search_detail_name;
	// 検索受講者名
	public $search_student_name;
	// 検索ログインId
	public $search_login_id;
	// 検索チェック状態
	public $search_chk_status;
	//組織名
	public $org_name;
	//ログインID
	public $stu_login_in;
	//氏名
	public $student_name;
}

?>