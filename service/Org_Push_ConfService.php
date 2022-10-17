<?php
/*****************************************************
 *	株式会社ECC 新商品開発プロジェクト
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2018 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_Org_Push_ConfDao.php';
require_once 'dto/T_Org_Push_ConfDto.php';
require_once 'service/BaseService.php';

/**
 *
 */
class Org_Push_ConfService extends BaseService{

	public function saveOrgPushConf($dto){
		$orgDao = new T_Org_Push_ConfDao($this->pdo);
		return $orgDao->saveOrgPushConf($dto);
	}

	public function updateOrgPushConf($dto){
		// データベース接続
		$orgDao = new T_Org_Push_ConfDao($this->pdo);

		return $orgDao->updateOrgPushConf($dto);
	}
}
?>