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
 * パスワード変更FORMクラス
 *
 */
class PasswordChangeForm extends BaseForm{
	public $login_id;
	public $admin_no;
	public $old_psw;
	public $new_psw;
	public $new_psw_confirm;
}