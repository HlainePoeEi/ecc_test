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
 * 運用管理者DTOクラス
 */
class T_AdminDto extends BaseDto{
	public $admin_no;
	public $login_id;
	public $admin_name;
	public $romaji_name;
	public $admin_kbn;
	public $password;
	public $pw_update_dt;
	public $mail_address;
	public $start_period;
	public $end_period;
	public $remarks;
	public $admin_kbn_name;
}

?>