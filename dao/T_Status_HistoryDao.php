<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Status_HistoryDto.php';

/**
 * DAOクラス
 */
class T_Status_HistoryDao extends BaseDao {

	/**
	 * システムステータスを取得する
	 *
	 */
	public function getStatusHistory($param , $flg ) {

		$kbn = TARGET_KBN;
		$offset = ($param->page-1) * PAGE_ROW;
		$query = "SELECT ";
		$query .= " status.no";
		$query .= ", type.name";
		$query .= ", status.system_status ";
		$query .= ",CASE WHEN status.system_status = '0' THEN '起動' ";
		$query .= " WHEN status.system_status = '1' THEN '停止' END AS system_status ";
		$query .= ", status.description ";
		$query .= ' ,date_format(status.update_dt,' . "'%Y/%m/%d %H:%i') as update_dt ";
		$query .= ", status.updater_id ";
		$query .= ", admin.login_id ";
		$query .= ", admin.admin_name";
		$query .= " FROM T_STATUS_HISTORY status";
		$query .= ' INNER JOIN T_ADMIN as admin ';
		$query .= ' ON admin.admin_no = status.creater_id ';
		$query .= " AND status.del_flg = '0' ";
		$query .= " AND admin.del_flg = '0' ";
		$query .= ' INNER JOIN M_TYPE as type ';
		$query .= ' ON type.type = status.system_kbn ';
		$query .= " AND type.del_flg = '0' ";
		$query .= " WHERE category = :kbn ";
		$query .= " ORDER BY ";
		$query .= " status.create_dt DESC";
		if ( $flg == "1"){
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );
		LogHelper::logDebug($query);
		$stmt->bindParam ( ":kbn", $kbn, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_Status_HistoryDto()) );
	}

	public function getNextId() {

		return parent::getId( "no" );
	}

	public function saveStatusHistory($dto){

		return parent::insert ( $dto );

	}

}

?>