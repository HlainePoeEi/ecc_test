<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/M_SubjectDto.php';
require_once 'dto/M_Subject_AreaDto.php';
require_once 'dto/M_OrganizationDto.php';

/**
 * M＿科目DAOクラス
 */
class M_SubjectDao extends BaseDao {

	/**
	 * 科目管理№を取得する
	 */
	public function getNextSubjNo() {
		return parent::getId("subject_no");
	}

	/**
	 * 科目名の重複チェック
	 *
	 */
	public function checkedExistInfo($org_no, $subject_name){
		$query = " SELECT ";
		$query .= " sub.org_no org_no";
		$query .= " FROM ";
		$query .= " M_SUBJECT sub";
		$query .= " WHERE";
		$query .= " sub.org_no = :org_no ";
		$query .= " AND sub.subject_name LIKE :subject_name ";
		$query .= " AND sub.del_flg = '0' ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":subject_name", $subject_name, PDO::PARAM_STR );
		$list= parent::getDataList( $stmt, get_class(new M_SubjectDto()) );
		return count($list);
	}

	/**
	 * 教科の有効期間チェック
	 *
	 */
	public function getSubjectAreaListByName($org_no,$subj_area_name){
		$today_date = DateUtil::getDate('Y/m/d');
		$query = " SELECT ";
		$query .= " subject_area_no,subject_area_name ";
		$query .= " FROM ";
		$query .= " M_SUBJECT_AREA";
		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND subject_area_name = :subject_area_name ";
	//	$query .= " AND start_period <= :start_period ";
		$query .= " AND end_period >= :today_date";
		$query .= " AND del_flg = '0' ";
		$query .= " GROUP BY ";
		$query .= " subject_area_no, subject_area_name ";
		$query .= " ORDER BY ";
		$query .= " subject_area_no ASC ,subject_area_name ASC ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":subject_area_name",$subj_area_name, PDO::PARAM_STR );
	//	$stmt->bindParam ( ":start_period", $today_date, PDO::PARAM_STR );
		$stmt->bindParam ( ":today_date", $today_date, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new M_Subject_AreaDto()) );
	}

	/**
	* 教科の登録
	* @param unknown $dto
	*/
	public function insertData($resultList , $pdo){
		return parent::insertWithTranPdo($resultList , $pdo);
	}
	
	/**
	 * 教科の有効期間チェック
	 *
	 */
	public function getSubjectAreaListForCheck($org_no,$subj_area_name , $start_dt , $end_dt){
		$today_date = DateUtil::getDate('Y/m/d');
		$query = " SELECT ";
		$query .= " subject_area_no,subject_area_name ";
		$query .= " FROM ";
		$query .= " M_SUBJECT_AREA";
		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND subject_area_name LIKE :subject_area_name ";
		
		$query .= " AND end_period >= :today_date";
		
		$query .= " AND start_period <= :start_dt1 ";
		$query .= " AND end_period >= :start_dt2 ";
		$query .= " AND start_period <= :end_dt1 ";
		$query .= " AND end_period >= :end_dt2";
		$query .= " AND del_flg = '0' ";
		$query .= " GROUP BY ";
		$query .= " subject_area_no, subject_area_name ";
		$query .= " ORDER BY ";
		$query .= " subject_area_no ASC ,subject_area_name ASC ";
		$stmt = $this->pdo->prepare ( $query );
		LogHelper::logDebug($query);
		
		$start = DateUtil::getYmd($start_dt);
		$end = DateUtil::getYmd($end_dt);
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":subject_area_name",$subj_area_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":today_date", $today_date, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_dt1", $start, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_dt2", $start, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_dt1", $end, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_dt2", $end, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new M_Subject_AreaDto()) );
	}

}

?>