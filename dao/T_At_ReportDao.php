<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_At_ReportDto.php';
require_once 'dto/T_At_Report_DetailDto.php';
require_once 'dto/T_Test_InfoDto.php';

/**
 * T_AT_REPORTDaoクラス
 */
class T_At_ReportDao extends BaseDao {

	/*
	 * レポート一覧画面のデータを取得する
	 */
	public function getReportList( $param) {

		$query = $this->createQuery();
		$query .= $this->createSearchWhere($param);
		$stmt = $this->pdo->prepare( $query );
		$this->setSearchParam($stmt, $param);
		return parent::getDataList ($stmt, get_class(new T_At_ReportDto()));
	}

	/*
	 * レポート一覧画面のデータを取得する
	 */
	public function createQuery(){

		$query = " SELECT ";
		$query .= " report.at_report_no";
		$query .= " ,report.at_report_name at_report_name ";
		$query .= " ,org.org_no ";
		$query .= " ,org.org_name org_name ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,report.file_name file_name ";
		$query .= " ,GROUP_CONCAT( DISTINCT 
						CASE 
						WHEN rpt_detail.at_type = '001' then
						test.test_info_name 
						ELSE course.course_name END
						ORDER BY 1 SEPARATOR ', ')test_info_name";
	
		$query .= " FROM ";
		$query .= " T_AT_REPORT AS report ";
		
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= "	ON report.org_no = org.org_no ";
		$query .= "	AND org.del_flg = '0' ";
		
		$query .= " LEFT JOIN T_AT_REPORT_DETAIL as rpt_detail ";
		$query .= "	ON report.org_no = rpt_detail.org_no ";
		$query .= "	AND report.at_report_no = rpt_detail.at_report_no ";
		$query .= "	AND rpt_detail.del_flg = '0' ";
		
		$query .= " LEFT JOIN T_TEST_INFO as test ";
		$query .= "	ON report.org_no = test.org_no ";
		$query .= "	AND rpt_detail.at_no = test.test_info_no ";
		$query .= "	AND rpt_detail.at_type = '001' ";
		$query .= "	AND test.del_flg = '0' ";
		
		$query .= " LEFT JOIN T_COURSE as course ";
		$query .= "	ON rpt_detail.at_no = course.course_id ";
		$query .= "	AND rpt_detail.at_type = '002' ";
		$query .= "	AND course.del_flg = '0' ";
		
		$query .= "	AND rpt_detail.del_flg = '0' ";
		
		return $query;
	}

	/*
	 * レポート一覧画面の検索データ
	 */
	public function createSearchWhere ( $param ){

		$query  = " WHERE ";
		$query .= " 1 = 1";

		if ( ! StringUtil::isEmpty($param->at_report_name) ){
			$query .= " AND (report.at_report_name LIKE :at_report_name ) ";
		}
		
		if ( ! StringUtil::isEmpty($param->test_info_name) ){
			$query .= " AND (test.test_info_name LIKE :test_info_name) ";
		}
		
		if ( ! StringUtil::isEmpty($param->org_id) ){
			$query .= " AND (org.org_id LIKE :org_id) ";
		}
		$query .= " GROUP BY report.at_report_no,report.at_report_name,org.org_no,org.org_name,org.org_id";
		
		return $query;
	}

	/**
	 * パラメータバインド
	 *
	 */
	public function setSearchParam($stmt, $param){

		if ( ! StringUtil::isEmpty($param->at_report_name) ){
			$at_report_name =  '%'.$param->at_report_name.'%';
			$stmt->bindParam(":at_report_name", $at_report_name, PDO::PARAM_STR);
			
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

		return parent::getDataList ( $stmt, get_class ( new T_At_ReportDto()) );
	}

	/*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	public function getReportInfo($org_no, $at_report_no){

		$query = " SELECT ";
		$query .= " report.at_report_no";
		$query .= " ,report.at_report_name at_report_name ";
		$query .= " ,report.show_flg show_flg ";
		$query .= " ,report.preview_flg preview_flg ";
		$query .= " ,report.file_name file_name ";
		$query .= " ,date_format(report.start_period,'%Y/%m/%d') start_period ";
		$query .= " ,date_format(report.end_period,'%Y/%m/%d') end_period ";
		$query .= " ,date_format(report.result_start_period,'%Y/%m/%d') result_start_period ";
		$query .= " ,date_format(report.result_end_period,'%Y/%m/%d') result_end_period ";
		$query .= " ,report.status status ";
		$query .= " ,org.org_no ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,org.org_name org_name ";
		$query .= " ,org.org_name_official org_name_official ";
		$query .= " FROM ";
		$query .= " T_AT_REPORT report";
		$query .= " LEFT JOIN M_ORGANIZATION as org ";
		$query .= "	ON report.org_no = org.org_no ";
		$query .= " WHERE report.org_no=:org_no";
		$query .= " AND report.at_report_no=:at_report_no";
		$query .= " AND report.del_flg = '0' ";
		$query .= " AND org.del_flg = '0' ";
		
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_At_ReportDto()) );

	}

	/**
	 * 設定している試験削除処理
	 *
	 * @param unknown $org_no,$at_report_no,$pdo
	 */

	public function deleteDataOnReport($org_no, $at_report_no , $type , $pdo) {
		$query = "DELETE";
		$query .= " FROM"; 
		$query .= " T_AT_REPORT_DETAIL";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND at_report_no = :at_report_no";
		$query .= " AND at_type = :type";
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":type", $type, PDO::PARAM_STR );
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );
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
		$query .= " T_AT_REPORT ";
		$query .= " SET";

		$query .= " update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";
		
		if(!StringUtil::isEmpty($dto->at_report_name)){
			$query .= " ,at_report_name  = :at_report_name ";
		}
		if(!StringUtil::isEmpty($dto->file_name)){
			$query .= " ,file_name  = :file_name ";
		}
		if(!StringUtil::isEmpty($dto->show_flg)){
			$query .= " ,show_flg  = :show_flg ";
		}
		if(!StringUtil::isEmpty($dto->preview_flg)){
			$query .= " ,preview_flg  = :preview_flg ";
		}
		if(!StringUtil::isEmpty($dto->status)){
			$query .= " ,status  = :status ";
		}
		if(!StringUtil::isEmpty($dto->start_period)){
			$query .= " ,start_period  = :start_period ";
		}
		if(!StringUtil::isEmpty($dto->end_period)){
			$query .= " ,end_period  = :end_period ";
		}
		if(!StringUtil::isEmpty($dto->result_start_period)){
			$query .= " ,result_start_period  = :result_start_period ";
		}
		if(!StringUtil::isEmpty($dto->result_end_period)){
			$query .= " ,result_end_period  = :result_end_period ";
		}

		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND at_report_no = :at_report_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		if(!StringUtil::isEmpty($dto->at_report_name)){
			$stmt->bindParam ( ":at_report_name",  $dto->at_report_name, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->file_name)){
			$stmt->bindParam ( ":file_name",  $dto->file_name, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->show_flg)){
			$stmt->bindParam ( ":show_flg",  $dto->show_flg, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->preview_flg)){
			$stmt->bindParam ( ":preview_flg",  $dto->preview_flg, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->status)){
			$stmt->bindParam ( ":status",  $dto->status, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->start_period)){
			$stmt->bindParam ( ":start_period",  $dto->start_period, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->end_period)){
			$stmt->bindParam ( ":end_period",  $dto->end_period, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->result_start_period)){
			$stmt->bindParam ( ":result_start_period",  $dto->result_start_period, PDO::PARAM_STR );
		}
		if(!StringUtil::isEmpty($dto->result_end_period)){
			$stmt->bindParam ( ":result_end_period",  $dto->result_end_period, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );

		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":at_report_no",  $dto->at_report_no, PDO::PARAM_STR );
		return parent::update ( $stmt);
	}

	/**
	 * レポート新規番号取得処理
	 *
	 * @param $dto
	 */
	public function getNextId() {

		return parent::getId("at_report_no");
	}

	/**
	 * 重複チェック
	 *
	 * @param count
	 */
	public function checkedExistReportInfo($org_no, $at_report_no){

	   $limitedDate = DateUtil::getDate("Y/m/d h:i:s");

	   $query = " SELECT ";
	   $query .= " report.org_no org_no";
	   $query .= " ,report.at_report_no at_report_no";
	   $query .= " FROM ";
	   $query .= " T_AT_REPORT report";
	   $query .= " WHERE";
	   $query .= " report.org_no = :org_no ";
	   $query .= " AND report.at_report_no = :at_report_no ";
	   $query .= " AND report.del_flg = '0' ";

	   $stmt = $this->pdo->prepare ( $query );

	   $stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
	   $stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );

	   $list= parent::getDataList( $stmt, get_class(new T_At_ReportDto()) );
	   return count($list);
   }

   /*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	 public function getReportData($org_no, $at_report_no){

		$query = " SELECT *";
		$query .= " FROM ";
		$query .= " T_AT_REPORT report";
		$query .= " WHERE";
		$query .= " report.org_no = :org_no ";
		$query .= " AND report.at_report_no = :at_report_no ";
		$query .= " AND report.del_flg = '0' ";
	
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_At_ReportDto()) );
 
	}
	
	public function getTestInfoListData($param) {
		
		$query = " SELECT ";
		$query .= " distinct test_info.test_info_no test_info_no ";
		$query .= " ,test_info.test_info_name test_info_name ";
		$query .= " ,test_info.remarks remarks";
		$query .= " ,org.org_no org_no";
		$query .= " ,org.org_id org_id";
		$query .= " ,date_format(test_info.start_period,'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(test_info.end_period,'%Y/%m/%d') as end_period ";
		$query .= " ,CASE WHEN test_info.status = 0 THEN  '非公開' ";
		$query .= " ELSE '公開' END AS status ";
		$query .= " FROM ";
		$query .= " T_TEST_INFO test_info ";
		$query .= " LEFT JOIN T_AT_REPORT as report ";
		$query .= " ON  report.org_no = test_info.org_no  ";
		$query .= " LEFT JOIN T_AT_REPORT_DETAIL as report_detail ";
		$query .= " ON test_info.org_no = report_detail.org_no ";
		$query .= " AND test_info.test_info_no = report_detail.at_no ";
		$query .= " AND report_detail.at_type =  '001' ";
		$query .= " AND report_detail.del_flg =  '0' ";
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= " ON test_info.org_no = org.org_no ";
		$query .= " AND org.del_flg =  '0' ";
		$query .= " WHERE test_info.start_period <= :end_period ";
		$query .= " AND test_info.end_period >= :start_period ";
		$query .= " AND test_info.status = '1'";
		
		if (! StringUtil::isEmpty ( $param->org_no )) {
			$query .= " AND (test_info.org_no=:org_no ) ";
		}

		if (! StringUtil::isEmpty ( $param->test_info_name )) {
			$query .= " AND (test_info.test_info_name LIKE :test_info_name) ";
		}

		$query .= " AND test_info.del_flg = '0' ";
		$query .= " GROUP BY org.org_no, report.at_report_no, test_info.test_info_no, test_info.test_info_name, test_info.remarks, start_period,end_period ";
		$query .= " ORDER BY ";
		$query .= " test_info.test_info_no ASC";
	
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":start_period", $param->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $param->end_period, PDO::PARAM_STR );

		if (! StringUtil::isEmpty ( $param->test_info_name )) {

			$name = '%' . $param->test_info_name . '%';
			$stmt->bindParam ( ":test_info_name", $name, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $param->org_no )) {
			$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $param->updater_id )) {
			$stmt->bindParam ( ":updater_id", $param->updater_id, PDO::PARAM_STR );
		}
		
		LogHelper::logDebug("getTestInfoListData");
		LogHelper::logDebug($query);
		
		return parent::getDataList ( $stmt, get_class ( new T_Test_InfoDto () ) );
	}
	
	/*
	*
	* 試験結果詳細データを取得する
	*
	*/
	public function getRegisteredTestList($org_no, $at_report_no){
		
		$query = "SELECT ";
		$query .= "DISTINCT org.org_no, ";
		$query .= "report.at_report_no, ";
		$query .= "report.at_report_name,";
		$query .= "test_info.test_info_no, ";
		$query .= "test_info.test_info_name, ";
		$query .= "test_info.remarks, ";
		$query .= "test_info.start_period, ";
		$query .= "test_info.end_period ";
		$query .= "FROM ";
		$query .= "T_AT_REPORT_DETAIL report_detail ";
		$query .= "LEFT JOIN M_ORGANIZATION AS org ";
		$query .= "ON report_detail.org_no = org.org_no ";
		$query .= "LEFT JOIN T_AT_REPORT AS report ";
		$query .= "ON report_detail.at_report_no = report.at_report_no ";
		$query .= "LEFT JOIN T_TEST_INFO AS test_info ";
		$query .= "ON report_detail.at_no = test_info.test_info_no ";
		$query .= "AND report_detail.at_type = '001' ";
		$query .= "AND test_info.status = '1'";
		$query .= "WHERE ";
		$query .= "report.org_no = report_detail.org_no  ";
		$query .= "AND report_detail.org_no = test_info.org_no  ";
		$query .= "AND report.del_flg = '0'  ";
		$query .= "AND test_info.del_flg = '0'  ";
		$query .= "AND report_detail.del_flg = '0' ";
		$query .= "AND org.org_no=:org_no AND report_detail.at_report_no=:at_report_no ";
		$query .= " GROUP BY org.org_no, report.at_report_no, test_info.test_info_no, test_info.test_info_name, test_info.remarks,  start_period,end_period ";
		$query .= "ORDER BY test_info.test_info_no ASC ";
		$stmt = $this->pdo->prepare ( $query );
		
		LogHelper::logDebug("getRegisteredTestList");
		LogHelper::logDebug($query);
		
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_Report_Test_InfoDto()) );
	}
	
		
	public function getCourseListData($param) {
		
		$query = " SELECT ";
		$query .= " distinct tco.offer_no, course.course_id course_id ";
		$query .= " ,course.course_name course_name ";
		$query .= " ,course.remarks remarks";
		$query .= " ,org.org_no org_no";
		$query .= " ,org.org_id org_id";
		$query .= " ,date_format(course.start_period,'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(course.end_period,'%Y/%m/%d') as end_period ";
		$query .= " ,CASE WHEN course.status = 0 THEN  '非公開' ";
		$query .= " ELSE '公開' END AS status ";
		$query .= " FROM ";
		$query .= " T_COURSE course ";
		$query .= " INNER JOIN T_COURSE_ORG as tco ";
		$query .= " ON course.course_id = tco.course_id  ";
		$query .= " AND course.del_flg =  '0' ";
		
		$query .= " LEFT JOIN T_AT_REPORT as report ";
		$query .= " ON  tco.org_no = report.org_no  ";
		$query .= " AND report.del_flg =  '0' ";
		
		$query .= " LEFT JOIN T_AT_REPORT_DETAIL as report_detail ";
		$query .= " ON tco.org_no = report_detail.org_no ";
		$query .= " AND course.course_id = report_detail.at_no ";
		$query .= " AND report_detail.at_type =  '002' ";
		$query .= " AND report_detail.del_flg =  '0' ";
		
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= " ON tco.org_no = org.org_no ";
		$query .= " AND org.del_flg =  '0' ";
		$query .= " WHERE tco.start_period <= :end_period ";
		$query .= " AND tco.end_period >= :start_period ";
		$query .= " AND course.status = '1'";
		
		if (! StringUtil::isEmpty ( $param->org_no )) {
			$query .= " AND (tco.org_no =:org_no ) ";
		}

		if (! StringUtil::isEmpty ( $param->course_name )) {
			$query .= " AND (course.course_name LIKE :course_name) ";
		}

		$query .= " AND course.del_flg = '0' ";
		$query .= " GROUP BY org.org_no,tco.offer_no, report.at_report_no, course.course_id,course.course_name , course.remarks, start_period,end_period ";
		$query .= " ORDER BY ";
		$query .= " course.course_id ASC";
	
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":start_period", $param->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $param->end_period, PDO::PARAM_STR );

		if (! StringUtil::isEmpty ( $param->course_name )) {

			$name = '%' . $param->course_name . '%';
			$stmt->bindParam ( ":course_name", $name, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $param->org_no )) {
			$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		}
		
		LogHelper::logDebug("getCourseListData");
		LogHelper::logDebug($query);
		
		return parent::getDataList ( $stmt, get_class ( new T_Test_InfoDto () ) );
	}
	
		/*
	*
	* 試験結果詳細データを取得する
	*
	*/
	public function getRegisteredCourseList($org_no, $at_report_no,$start_period,$end_period){
		
		$query = "SELECT ";
		$query .= "org.org_no, ";
		$query .= "report.at_report_no, ";
		$query .= "report.at_report_name,";
		$query .= "report_detail.offer_no offer_no, ";
		$query .= "course.course_id course_id, ";
		$query .= "course.course_name course_name, ";
		$query .= "course.remarks, ";
		$query .= "course.start_period, ";
		$query .= "course.end_period ";
		$query .= "FROM ";
		$query .= "T_AT_REPORT_DETAIL report_detail ";
		$query .= "LEFT JOIN M_ORGANIZATION AS org ";
		$query .= "ON report_detail.org_no = org.org_no ";
		$query .= "LEFT JOIN T_AT_REPORT AS report ";
		$query .= "ON report_detail.at_report_no = report.at_report_no ";
		$query .= "LEFT JOIN T_COURSE AS course ";
		$query .= "ON report_detail.at_no = course.course_id ";
		$query .= "AND report_detail.at_type = '002' ";
		$query .= "AND course.status = '1'";
		$query .= "INNER JOIN T_COURSE_ORG AS co ";
		$query .= "ON course.course_id = co.course_id ";
		$query .= "AND report_detail.org_no = co.org_no ";
		$query .= "AND report_detail.offer_no = co.offer_no ";
		$query .= "WHERE ";
		$query .= "report.org_no = report_detail.org_no  ";
		$query .= "AND report.del_flg = '0'  ";
		$query .= "AND course.del_flg = '0'  ";
		$query .= "AND report_detail.del_flg = '0' ";
		$query .= " AND course.start_period <= :end_period ";
		$query .= " AND course.end_period >= :start_period ";
		$query .= "AND org.org_no=:org_no AND report_detail.at_report_no=:at_report_no ";
		$query .= " GROUP BY org.org_no, report.at_report_no, course.course_id, course.course_name, course.remarks, start_period,end_period ";
		$query .= "ORDER BY report_detail.disp_no ASC ";
		$stmt = $this->pdo->prepare ( $query );
		
		LogHelper::logDebug("getRegisteredCourseList");
		LogHelper::logDebug($query);
		
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_period", $start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $end_period, PDO::PARAM_STR );
		
		return parent::getDataList( $stmt, get_class(new T_At_Report_DetailDto()) );
	}
	
	public function getAtReportDisplayList($org_no, $at_report_no){
		
		$query = " SELECT ";
		$query .= " report.at_report_no";
		$query .= " ,report.at_report_name at_report_name ";
		$query .= " ,org.org_no ";
		$query .= " ,org.org_name org_name ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,rpt_detail.at_type ";
		$query .= " ,rpt_detail.at_no ";
		$query .= " ,rpt_detail.offer_no ";
		$query .= " ,( 
						CASE 
						WHEN rpt_detail.at_type = '001' then
						test.test_info_name 
						ELSE course.course_name END
					) test_info_name";
		$query .= " ,( 
						CASE 
						WHEN rpt_detail.at_type = '001' then
						type1.name
						ELSE type2.name END
					) at_type_name";
					
		$query .= " FROM ";
		$query .= " T_AT_REPORT AS report ";
		
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= "	ON report.org_no = org.org_no ";
		$query .= "	AND org.del_flg = '0' ";
		
		$query .= " INNER JOIN T_AT_REPORT_DETAIL as rpt_detail ";
		$query .= "	ON report.org_no = rpt_detail.org_no ";
		$query .= "	AND report.at_report_no = rpt_detail.at_report_no ";
		$query .= "	AND rpt_detail.del_flg = '0' ";
		
		$query .= " LEFT JOIN T_TEST_INFO as test ";
		$query .= "	ON report.org_no = test.org_no ";
		$query .= "	AND rpt_detail.at_no = test.test_info_no ";
		$query .= "	AND rpt_detail.at_type = '001' ";
		$query .= "	AND test.del_flg = '0' ";
		
		$query .= " INNER JOIN M_TYPE as type1 ";
		$query .= "	ON rpt_detail.at_type = type1.type ";
		$query .= "	AND type1.category = '036' ";
		
		$query .= " LEFT JOIN T_COURSE as course ";
		$query .= "	ON rpt_detail.at_no = course.course_id ";
		$query .= "	AND rpt_detail.at_type = '002' ";
		$query .= "	AND course.del_flg = '0' ";
		
		$query .= " INNER JOIN M_TYPE as type2 ";
		$query .= "	ON rpt_detail.at_type = type2.type ";
		$query .= "	AND type2.category = '036' ";
		
		$query .= "	AND rpt_detail.del_flg = '0' ";

		$query .= "WHERE ";
		$query .= "report.org_no = :org_no  ";
		$query .= "AND report.at_report_no = :at_report_no ";
		$query .= "AND report.del_flg = '0'  ";
		
		$query .= "ORDER BY rpt_detail.disp_no ASC ";
		
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		
		return parent::getDataList( $stmt, get_class(new T_At_Report_DetailDto()) );
	}
	
	public function deleteDataOnAtReport($org_no, $at_report_no , $pdo){
		
		$query = " DELETE ";
		$query .= " FROM ";
		$query .= " T_AT_REPORT_DETAIL ";
		$query .= " WHERE";
		$query .= " org_no = :org_no ";
		$query .= " AND at_report_no = :at_report_no ";
	
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":at_report_no", $at_report_no, PDO::PARAM_STR );

		$stmt->execute ();
		return;
	}
}

?>