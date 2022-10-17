<?php
/*****************************************************
 *	株式会社ECC 新商品開発プロジェクト
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2018 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/M_Org_ConfDao.php';
require_once 'dto/M_Org_ConfDto.php';
require_once 'service/BaseService.php';

/**
 *
 */
class Org_ConfService extends BaseService{

	public function saveOrg_Conf($dto){
		$orgDao = new M_Org_ConfDao();
		return $orgDao->saveOrg_Conf($dto);
	}

	public function updateOrg_ConfInfo($dto){
		// データベース接続
		$orgDao = new M_Org_ConfDao();

		return $orgDao->updateOrg_ConfInfo($dto);
	}
}
?>