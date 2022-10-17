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
 * 管理者教師テーブルDTOクラス
 */
class T_ManagerDto extends BaseDto{

	//組織管理№
	public $org_no;
	//組織コード
	public $org_id;
	//組織名
	public $org_name;
	//組織名ふりがな
	//public $org_name_kana;
	//正式組織名
	//public $org_name_official;
	//管理者№
	public $manager_no;
	//ログインID
	public $login_id;
	//管理者名
	public $manager_name;
	//管理者名ふりがな
	public $manager_name_kana;
	//管理者権限
	public $manager_kbn;
	//パスワード
	public $password;
	//利用開始日
	public $start_period;
	//利用終了日
	public $end_period;
	//メールアドレス
	public $mail_address;
	//備考
	public $remarks;
}

?>