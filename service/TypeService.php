<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dto/M_TypeDto.php';
require_once 'dao/M_TypeDao.php';
require_once 'service/BaseService.php';

class TypeService extends BaseService{

	public function getCategoryTypeAll($categoryId){
		// データベース接続
		$dao = new M_TypeDao();
		return $dao->getCategoryTypeAll($categoryId);
	}

	public function getquizType($form){
		// データベース接続
		$dao = new M_TypeDao();
		return $dao->getquizType($form);
	}
}

?>