<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * 受講生DTOクラス
 */
class T_StudentDto extends BaseDto {

	// 組織管理№
	public $org_no;
	// 受講者管理№
	public $student_no;
	// 受講者名
	public $student_name;
	// 受講者名ローマ字
	public $student_name_romaji;
	// 性別
	public $sex;
	// ログインID
	public $login_id;
	// パスワード
	public $password;
	// メールアドレス
	public $mail_address;
	// 番号
	public $no;
	// 入学日
	public $enroll_dt;
	// 卒業（退学）日
	public $graduation_dt;
	// 有効区分
	public $valid_kbn;
	// 設定
	public $setting;
	// 更新備考
	public $remarks;
	// 削除フラグ
	public $del_flg;
	//登録日
	public $create_dt;
	// 登録者ＩＤ
	public $creater_id;
	//更新日
	public $update_dt;
	// 更新者ＩＤ
	public $updater_id;
}

?>