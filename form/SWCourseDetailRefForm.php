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
 * SW Practiceコース詳細参照FORMクラス
 */
class SWCourseDetailRefForm extends BaseForm{

	// 検索コースレベル
	public $search_course_level;
	// 検索コースID
	public $search_course_id;
	// 検索コース詳細管理№
	public $search_course_detail_no;
	// 検索テスト区分タイプ
	public $search_test_kbn_type;
	// 検索名
	public $search_name;
	// 検索更新備考
	public $search_remarks;
	// 検索テスト区分
	public $search_test_kbn;
	// 戻り用
	public $btn_flg;
	// 状態
	public $status;
	// 検索ページ
	public $search_page;
}

?>