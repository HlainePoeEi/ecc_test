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
 * サブ管理者一覧（参照）Formクラス
 *
 */
class TeacherRegistForm extends BaseForm{

	// 講師管理№
	public $teacher_no;
	// ログインID
	public $login_id;
	// 名前
	public $name;
	// ニックネーム
	public $nickname;
	// 表示名
	public $display_name;
	// 所属校舎区分
	public $school_kbn;
	// 練習フラグ
	public $training_flg;
	// パスワード
	public $password;
	// パスワード更新日
	public $confirm_password;
	// パスワード更新日
	public $pw_update_dt;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 更新備考
	public $remarks;
	// 削除フラグ
	public $del_flg;
	// 登録者ＩＤ
	public $creater_id;
	// 登録者ＩＤ
	public $updater_id;
	// 登録日時
	public $create_dt;
	// 更新日時
	public $update_dt;
	// 所属校舎区分一覧
	public $school_kbn_list;
	// 画面モード
	public $screen_mode;
	// 戻り用
	public $back_flg;
	// 検索ページ
	public $search_page;
	// 検索名
	public $search_name;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索所属校舎区分
	public $search_school_kbn;
}

?>