<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_ReportDto.php';

/**
 * T_ReportDaoクラス
 */
class T_ReportDao extends BaseDao {


	public function getReportList( $param , $flg ) {

		$query = $this->createQuery();
		$query .= $this->createSearchWhere($param);
		$stmt = $this->pdo->prepare( $query );
		$this->setSearchParam($stmt, $param);
		return parent::getDataList ($stmt, get_class(new T_ReportDto()));
	}

	/*
	 * レポート一覧画面のデータを取得する
	 */
	public function createQuery(){

		$query = " SELECT ";
		$query .= " report.report_no";
		$query .= " ,report.report_name report_name ";
		$query .= " ,org.org_no ";
		$query .= " ,org.org_name org_name ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,report.file_name file_name ";
		$query .= " ,GROUP_CONCAT(test_info.test_info_name SEPARATOR '、') test_info_name";
		$query .= " FROM ";
		$query .= " T_REPORT AS report ";
		$query .= " LEFT JOIN T_REPORT_TEST_INFO report_test ";
		$query .= "	ON report.report_no = report_test.report_no ";
		$query .= "	AND report.org_no = report_test.org_no ";
		$query .= "	AND report_test.del_flg = '0' ";
		$query .= " LEFT JOIN T_TEST_INFO AS test_info ";
		$query .= " ON report_test.test_info_no = test_info.test_info_no ";
		$query .= " AND report_test.org_no = test_info.org_no ";
		$query .= "	AND test_info.del_flg = '0' ";
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= "	ON report.org_no = org.org_no ";
		$query .= "	AND org.del_flg = '0' ";

		return $query;
	}

	/*
	 * レポート一覧画面の検索データ
	 */
	public function createSearchWhere ( $param ){

		$query  = " WHERE ";
		$query .= " 1 = 1";

		if ( ! StringUtil::isEmpty($param->report_name) ){
			$query .= " AND (report.report_name LIKE :report_name ) ";
		}
		if ( ! StringUtil::isEmpty($param->test_info_name) ){
			$query .= " AND (test_info.test_info_name LIKE :test_info_name) ";
		}
		if ( ! StringUtil::isEmpty($param->org_id) ){
			$query .= " AND (org.org_id LIKE :org_id) ";
		}
		$query .= " GROUP BY report.report_no,report.report_name,org.org_no,org.org_name,org.org_id";
		
		return $query;
	}

	/**
	 * パラメータバインド
	 *
	 */
	public function setSearchParam($stmt, $param){


		if ( ! StringUtil::isEmpty($param->report_name) ){

			$report_name =  '%'.$param->report_name.'%';
			$stmt->bindParam(":report_name", $report_name, PDO::PARAM_STR);
			
		}

		if ( ! StringUtil::isEmpty($param->test_info_name) ){

			$name =  '%'.$param->test_info_name.'%';
			$stmt->bindParam(":test_info_name", $name, PDO::PARAM_STR);
		}	

		if ( ! StringUtil::isEmpty($param->org_id) ){

			$org_id =  '%'.$param->org_id.'%';
			$stmt->bindParam(":org_id", $org_id, PDO::PARAM_STR);
		}	

	}	
	
	public function getOrgName($org_id) {

		$query = 'SELECT ';
		$query .= ' org_no';
		$query .= ' ,org_id';
		$query .= ' ,org_name';
		$query .= ' ,org_name_official';
		$query .= ' FROM M_ORGANIZATION ';
		$query .= 'WHERE del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $org_id ) ){
			$query .= ' AND org_id = :org_id ';
		}

		$stmt = $this->pdo->prepare ( $query );

		// 該当コースがある場合
		if ( ! StringUtil::isEmpty ( $org_id) ){
			$org_id = $org_id;
			$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		}

		return parent::getDataList ( $stmt, get_class ( new T_ReportDto()) );
	}

	/*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	public function getReportInfo($org_no, $report_no){

		$query = " SELECT ";
		$query .= " report.report_no";
		$query .= " ,report.report_name report_name ";
		$query .= " ,report.show_flg show_flg ";
		$query .= " ,report.file_name file_name ";
		$query .= " ,org.org_no ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,org.org_name org_name ";
		$query .= " ,org.org_name_official org_name_official ";
		$query .= " FROM ";
		$query .= " T_REPORT report";
		$query .= " LEFT JOIN M_ORGANIZATION as org ";
		$query .= "	ON report.org_no = org.org_no ";
		$query .= " WHERE report.org_no=:org_no";
		$query .= " AND report.report_no=:report_no";
		$query .= " AND report.del_flg = '0' ";
		$query .= " AND org.del_flg = '0' ";
		
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":report_no", $report_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_ReportDto()) );

	}

	/**
	 * 新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($dto){

		return parent::insert ( $dto );
	}

	public function countExisting($org_no,$report_no) {
		$query = " SELECT";
		$query .= " count(test_info_no)";
		$query .= " FROM"; // FROM
		$query .= " T_REPORT_TEST_INFO";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND report_no = :report_no";
	
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":report_no", $report_no, PDO::PARAM_STR );
		$stmt->execute ();
		return $stmt->fetchColumn ();
	}

	public function deleteTestOnReport($org_no, $report_no , $pdo) {
		$query = "DELETE";
		$query .= " FROM"; // FROM
		$query .= " T_REPORT_TEST_INFO";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND report_no = :report_no";
		$stmt = $pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":report_no", $report_no, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

	/**
	 * レポート情報更新処理
	 *
	 * @param $dto
	 */
	public function updateReportInfo($dto){

		$query = " UPDATE ";
		$query .= " T_REPORT ";
		$query .= " SET";

		if(!StringUtil::isEmpty($dto->report_name)){
			$query .= " report_name  = :report_name ";
		}

		if(!StringUtil::isEmpty($dto->file_name)){
			$query .= " ,file_name  = :file_name ";
		}

		if(!StringUtil::isEmpty($dto->show_flg)){
			$query .= " ,show_flg  = :show_flg ";
		}
		
		$query .= " ,update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";

		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND report_no = :report_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		if(!StringUtil::isEmpty($dto->report_name)){
			$stmt->bindParam ( ":report_name",  $dto->report_name, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->file_name)){
			$stmt->bindParam ( ":file_name",  $dto->file_name, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->show_flg)){
			$stmt->bindParam ( ":show_flg",  $dto->show_flg, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );

		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":report_no",  $dto->report_no, PDO::PARAM_STR );
		return parent::update ( $stmt);
	}

	/**
	 * レポート新規番号取得処理
	 *
	 * @param $dto
	 */
	public function getNextId() {

		return parent::getId("report_no");
	}

	/**
	 * 重複チェック
	 *
	 * @param count
	 */
	public function checkedExistReportInfo($org_no, $report_no){

	   $limitedDate = DateUtil::getDate("Y/m/d h:i:s");

	   $query = " SELECT ";
	   $query .= " report.org_no org_no";
	   $query .= " ,report.report_no report_no";
	   $query .= " FROM ";
	   $query .= " T_REPORT report";
	   $query .= " WHERE";
	   $query .= " report.org_no = :org_no ";
	   $query .= " AND report.report_no = :report_no ";
	   $query .= " AND report.del_flg = '0' ";

	   $stmt = $this->pdo->prepare ( $query );

	   $stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
	   $stmt->bindParam ( ":report_no", $report_no, PDO::PARAM_STR );

	   $list= parent::getDataList( $stmt, get_class(new T_ReportDto()) );
	   return count($list);
   }

   /*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	 public function getReportData($org_no, $report_no){

		$query = " SELECT *";
		$query .= " FROM ";
		$query .= " T_REPORT report";
		$query .= " WHERE";
		$query .= " report.org_no = :org_no ";
		$query .= " AND report.report_no = :report_no ";
		$query .= " AND report.del_flg = '0' ";
	
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":report_no", $report_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_ReportDto()) );
 
	}
}

?>