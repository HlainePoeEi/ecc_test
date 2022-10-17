<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_StudentDto.php';
require_once 'dto/T_GroupDto.php';
require_once 'dto/T_Group_StudentDto.php';

/**
 * グループ・受講者DAOクラス
 */
class T_Group_StudentDao extends BaseDao {

	/**
	 * Tグループ。受講者のデータを削除処理
	 *
	 * @param unknown $org_no,$group_no
	 */
	public function deleteGpStuData($org_no, $group_no) {
		$query = "DELETE";
		$query .= " FROM"; // FROM
		$query .= " T_GROUP_STUDENT";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND group_no = :group_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_no", $group_no, PDO::PARAM_STR );
		$stmt->execute ();
	}

	/**
	 * Tグループ。受講者のデータcount
	 *
	 * @param unknown $form
	 * @return int
	 */
	public function count($org_no, $group_no) {
		$query = " SELECT";
		$query .= " count(student_no)";
		$query .= " FROM"; // FROM
		$query .= " T_GROUP_STUDENT";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND group_no = :group_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_no", $group_no, PDO::PARAM_STR );

		$stmt->execute ();
		return $stmt->fetchColumn ();
	}

	/**
	 * Tグループ。受講者の複数データ登録処理
	 *
	 * @param unknown $form
	 * @return int
	 */
	public function insertData($resultList , $pdo){

		return parent::insertWithTranPdo($resultList , $pdo);
	}
	/**
	 * データ抽出ためグループと受講者情報を取得処理
	 * @param $org_no:組織№
	 * @param $param:画面からのデータ
	 * @return リスト
	 */
	public function getGroupStudentCsvData($org_no,$params) {
		$query = $this->getQueryCsvData($org_no,$params);
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
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
		$list = parent::getDataList ( $stmt, get_class ( new T_Group_StudentDto() ) );
		return $list;
	}

	/**
	 * データ抽出ためグループと受講者情報を取得クエリー
	 * @param $org_no:組織№
	 * @param $param:画面からのデータ
	 * @return クエリー
	 */
	public function getQueryCsvData($org_no,$params){
		$query  = "";
		$query  .= "SELECT ";
		$query  .= "gp.group_no ";
		$query  .= ",gp.group_name ";
		$query  .= ",gp.grade_no ";
		$query  .= ",grade.grade_name ";
		$query .= ",date_format(gp.start_period,'%Y/%m/%d') AS start_period ";
		$query .= ",date_format(gp.end_period,'%Y/%m/%d') AS end_period ";
		$query  .= ",student.student_no ";
		$query  .= ",student.login_id ";
		$query  .= ",student.student_name ";
		$query  .= ",student.student_name_romaji ";
		$query  .= ",student.no ";
		$query  .= ",CASE WHEN student.sex='2' THEN '女性' ";
		$query  .= "WHEN student.sex='1' THEN '男性' ";
		$query  .= "WHEN student.sex='0' AND student.student_no IS NOT NULL THEN '未指示' ";
		$query  .= "ELSE '' END AS sex";
		$query  .= ",date_format(student.enroll_dt,'%Y/%m/%d') AS enroll_dt ";
		$query  .= ",date_format(student.graduation_dt,'%Y/%m/%d') AS graduation_dt ";
		$query  .= "FROM T_GROUP gp ";
		$query  .= "LEFT JOIN M_GRADE grade ";
		$query  .= "ON gp.org_no = grade.org_no ";
		$query  .= "AND gp.grade_no = grade.grade_no ";
		$query  .= "AND gp.del_flg = '0' ";
		$query  .= "AND grade.del_flg = '0' ";
		$query  .= "LEFT JOIN T_GROUP_STUDENT gpStu ";
		$query  .= "ON gp.org_no = gpStu.org_no ";
		$query  .= "AND gp.group_no = gpStu.group_no ";
		$query  .= "AND gpStu.del_flg = '0' ";
		$query  .= "LEFT JOIN T_STUDENT student ";
		$query  .= "ON gpStu.org_no = student.org_no ";
		$query  .= "AND gpStu.student_no = student.student_no ";
		$query  .= "AND student.del_flg = '0' ";
		$query  .= "WHERE gp.org_no = :org_no ";
		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$query .= " AND gp.start_period >= :start_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$query .= " AND gp.start_period <= :start_period_end ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$query .= " AND gp.end_period >= :end_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$query .= " AND gp.end_period <= :end_period_end ";
		}
		return $query;
	}

	/**
	 * グループと受講者テーブルで登録する前、重複チェック処理-20190425修正
	 * Tグループ受講者のデータcount
	 *
	 * @param unknown $form
	 * @return int
	 */
	public function checkgpStudent($org_no, $group_no, $student_no) {
		$query = " SELECT";
		$query .= " group_no";
		$query .= " ,student_no";
		$query .= " FROM";
		$query .= " T_GROUP_STUDENT";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND group_no = :group_no";
		$query .= " AND student_no = :student_no";
		$query .= " AND del_flg = '0'";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_no", $group_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":student_no", $student_no, PDO::PARAM_STR );
		LogHelper::logDebug("GroupStudentCount org_no:".$org_no."group_no:".$group_no."student_no:".$student_no);
		return parent::getDataList( $stmt, get_class(new T_Group_StudentDto()) );
	}
}
?>