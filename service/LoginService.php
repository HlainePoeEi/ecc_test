<?php
/*****************************************************
 *	株式会社ECC 新商品開発プロジェクト
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_AdminDao.php';
require_once 'dto/T_AdminDto.php';
require_once 'service/BaseService.php';

/**
 * ログインサービス
 */
class LoginService extends BaseService{

	public function getUserData($user_id){
		// データベース接続
		$dao = new T_AdminDao();
		// ユーザ情報取得
		return $dao->getUserData($user_id);
	}
}
?>