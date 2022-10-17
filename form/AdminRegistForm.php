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
 * 運用管理者登録Formクラス
 *
 */
class AdminRegistForm extends BaseForm{

	public $org_no;
	public $admin_no;
	public $login_id;
	public $admin_name;
	public $romaji_name;
	public $admin_kbn;
	public $txt_admin_kbn;
	public $password;
	public $confirm_password;
	public $start_period;
	public $end_period;
	public $mail_address;
	public $remarks;
	public $del_flg;
	public $btn_value;
	public $search_start_period;
	public $search_end_period;
	public $search_admin_name;
	public $search_page;
	public $date_flg;
}

?>