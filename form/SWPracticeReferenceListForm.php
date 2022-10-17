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
 *
 * SW Practice 参照一覧FORMクラス
 */
class SWPracticeReferenceListForm extends BaseForm{

	// コース名
	public $name;
	// 更新備考
	public $remarks;
	// テスト区分
	public $test_kbn;
	// コースレベル
	public $course_level;
	// 現ページ
	public $page;
	// 最大ページ
	public $max_page;
	// 検索テスト区分
	public $search_test_kbn;
	// 検索コースレベル
	public $search_course_level;
	// 状態
	public $status;
	// 検索コースID
	public $search_course_id;
	// 検索コース詳細管理№
	public $search_course_detail_no;
	// 検索テスト区分
	public $search_test_kbn_type;
	// 検索名
	public $search_name;
	// 検索備考
	public $search_remarks;
	// 戻り用
	public $btn_flg;
	public $back_flg;
	//
	public $chk_status1;
	//
	public $chk_status2;
	// 検索状態
	public $search_status;
	// 検索ページ
	public $search_page;
}

?>