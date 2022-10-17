<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/M_StatusDto.php';

/**
 * DAOクラス
 */
class M_StatusDao extends BaseDao {

	/**
	 * システムステータスを取得する
	 *
	 */
	public function getStatus($system_kbn) {

		$query = "SELECT ";
		$query .= " system_status";
		$query .= " FROM M_STATUS ";
		$query .= " WHERE system_kbn = :system_kbn ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":system_kbn",  $system_kbn, PDO::PARAM_STR );
		return parent::getDataList ( $stmt, get_class(new M_StatusDto()) );
	}

	public function updateSystemStatusInfo($dto){

		$query = " UPDATE ";
		$query .= " M_STATUS ";
		$query .= " SET";
		$query .= " system_status  = :system_status ";
		$query .= " WHERE system_kbn = :system_kbn ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":system_status",  $dto->system_status, PDO::PARAM_STR );
		$stmt->bindParam ( ":system_kbn",  $dto->system_kbn, PDO::PARAM_STR );
		return parent::update ( $stmt );
	}

	/**
	 * システムステータスを取得する
	 *
	 */
	public function getMaintenanceStatus($category) {

		$query = "SELECT ";
		$query .= " s.system_status";
		$query .= " , s.system_kbn";
		$query .= " ,(SELECT name FROM M_TYPE t WHERE category=:category AND t.type=s.system_kbn) AS name ";
		$query .= " FROM M_STATUS s";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":category",  $category, PDO::PARAM_STR );
		return parent::getDataList ( $stmt, get_class(new M_StatusDto()) );
	}

}

?>