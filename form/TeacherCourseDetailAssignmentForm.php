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
 * 講師コース詳細割当FORMクラス
 *
 */
class TeacherCourseDetailAssignmentForm extends BaseForm{

	// 講師管理№
	public $teacher_no;
	// ログインID
	public $login_id;
	// 名前
	public $t_name;
	// ニックネーム
	public $nick_name;
	// 表示名
	public $display_name;
	// コースレベル
	public $course_level;
	// テスト区分
	public $test_kbn;
	// 名前
	public $teacher_name;
	// テスト区分
	public $search_test_kbn;
	// コースレベル
	public $search_course_level;
	public $entryList;
	// 検索名前
	public $search_name;
	// 検索ページ
	public $search_page;
	// 戻り用
	public $back_flg;
	// 検索利用開始日
	public $search_end_period;
	// 検索利用終了日
	public $search_start_period;
	// 検索所属校舎区分
	public $search_school_kbn;
}

?>