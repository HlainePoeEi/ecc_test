<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/M_StatusDao.php';
require_once 'dao/T_Status_HistoryDao.php';
require_once 'service/BaseService.php';

/**
 * StatusServiceクラス
 *
 */
class MaintenanceService extends BaseService{

	public function getSystemStatus($system_kbn){
		$dao = new M_StatusDao();

		return $dao->getStatus($system_kbn);
	}

	public function getSystemStatusHistory($form,$flg){
		$dao = new T_Status_HistoryDao($this->pdo);

		return $dao->getStatusHistory($form,$flg);
	}

	public function updateSystemStatusInfo($dto){
		$dao = new M_StatusDao();
		return $dao->updateSystemStatusInfo($dto);
	}

	public function getNextId(){

		$dao = new T_Status_HistoryDao($this->pdo);
		return $dao-> getNextId();
	}

	public function saveStatusHistory($dto){
		$dao = new T_Status_HistoryDao($this->pdo);
		return $dao->saveStatusHistory($dto);
	}

	public function  getMaintenanceStatus($category){
		$dao = new M_StatusDao();
		return $dao->getMaintenanceStatus($category);

	}
}
?>