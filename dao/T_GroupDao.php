<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_GroupDto.php';
require_once 'util/DateUtil.php';

/**
 * グループDAOクラス
 */
class T_GroupDao extends BaseDao {

	/* シアイテム情報更新処理
	 *
	 * @param unknown $dto
	 */
	public function getNextGroupNo() {
		return parent::getId ( "group_no" );
	}

	/* 複数件データを挿入する
	 *
	 * @param unknown $dto
	 */
	public function insertWithTran($list , $pdo){
		loghelper::logdebug($list);
		return parent::insertWithTranPdo($list , $pdo);
	}

	/**
	 *  グループ名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistGpName($org_no, $group_name) {

		$query = 'SELECT ';
		$query .= 'group_no as group_no ';
		$query .= 'FROM T_GROUP ';
		$query .= 'WHERE del_flg = 0 ';
		$query .= 'AND org_no = :org_no ';
		$query .= 'AND group_name = :group_name ';

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_name", $group_name, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class ( new T_GroupDto() ) ) ;

	}

	/* グループの利用開始・利用終了日を取得処理
	 *
	 * @param unknown $dto
	 */
	public function getInfoByGroupName($org_no, $group_name){

		$query = " SELECT ";
		$query .= " group_no";
		$query .= " ,start_period";
		$query .= " ,end_period";

		$query .= " FROM T_GROUP";
		$query .= " WHERE org_no = :org_no ";
		$query .= " AND group_name = :group_name";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_name", $group_name, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_GroupDto()) );

	}
	/**
	 * グループデータを取得する
	 *
	 * @param count
	 */
	public function getGroupCsvData($params){
		$query = " SELECT ";
		$query .= "gp.group_no ";
		$query .= ",gp.group_name ";
		$query .= ",gp.group_name_kana ";
		$query .= ",grade.grade_name ";
		$query .= ",date_format(gp.start_period,'%Y/%m/%d') start_period ";
		$query .= ",date_format(gp.end_period,'%Y/%m/%d') end_period ";
		$query .= ",gp.remarks ";
		$query .= ",COUNT(gpStu.student_no) AS stuCount ";
		$query .= ",date_format(gp.create_dt,'%Y/%m/%d') create_dt ";
		$query .= ",date_format(gp.update_dt,'%Y/%m/%d') update_dt ";
		$query .= "FROM T_GROUP gp ";
		$query .= "LEFT JOIN M_GRADE grade ";
		$query .= "ON gp.org_no = grade.org_no ";
		$query .= "AND gp.grade_no = grade.grade_no ";
		$query .= "LEFT JOIN T_GROUP_STUDENT gpStu ";
		$query .= "ON gp.org_no = gpStu.org_no ";
		$query .= "AND gp.group_no = gpStu.group_no ";
		$query .= "AND gp.del_flg ='0' ";
		$query .= "AND gpStu.del_flg ='0' ";
		$query .= "WHERE gp.org_no = :org_no ";

		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$query .= "AND gp.start_period>= :start_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$query .= "AND gp.start_period <= :start_period_end ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$query .= "AND gp.end_period >= :end_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$query .= "AND gp.end_period <= :end_period_end ";
		}

		$query .= "GROUP BY gp.group_no, gp.group_name, gp.group_name_kana, gp.grade_no, gp.start_period, gp.end_period, gp.remarks,gp.create_dt, gp.update_dt, grade.grade_no, grade.grade_name ";

		$query .= "ORDER BY gp.group_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $params->org_no, PDO::PARAM_STR );

		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$stmt->bindParam ( ":start_period_start", $params->start_period_start, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$stmt->bindParam ( ":start_period_end", $params->start_period_end, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$stmt->bindParam ( ":end_period_start", $params->end_period_start, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$stmt->bindParam ( ":end_period_end", $params->end_period_end, PDO::PARAM_STR );
		}

		return parent::getDataList( $stmt, get_class(new T_GroupDto()));

	}

}