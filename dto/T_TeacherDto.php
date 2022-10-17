<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

class T_TeacherDto extends BaseDto {

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
	// ＰＷ更新日
	public $pw_update_dt;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 更新備考
	public $remarks;
	// 削除フラグ
	public $del_flg;
	// 登録日時
	public $create_dt;
	// 登録者ＩＤ
	public $creater_id;
	// 更新日時
	public $update_dt;
	// 更新者ＩＤ
	public $updater_id;
}

?>