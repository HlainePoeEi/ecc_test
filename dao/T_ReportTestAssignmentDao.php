<?php
require_once 'BaseDao.php';
require_once 'dto/T_Test_InfoDto.php';
require_once 'dto/T_Report_Test_InfoDto.php';
/**
 * T_ReportTestAssignmentDaoクラス
 */
class T_ReportTestAssignmentDao extends BaseDao {
	
	public function getTestInfoListData($param, $flg) {
		
		$query = " SELECT ";
		$query .= " distinct test_info.test_info_no test_info_no ";
		$query .= " ,report_test.disp_no";
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
		$query .= " INNER JOIN T_REPORT as report ";
		$query .= " ON  report.org_no = test_info.org_no  ";
		$query .= " LEFT JOIN T_REPORT_TEST_INFO as report_test ";
		$query .= " ON test_info.org_no = report_test.org_no ";
		$query .= " AND test_info.test_info_no = report_test.test_info_no ";
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= " ON test_info.org_no = org.org_no ";
		$query .= " AND org.del_flg =  '0' ";
		$query .= " WHERE test_info.start_period <= :end_period ";
		$query .= " AND test_info.end_period >= :start_period ";
		
		if (! StringUtil::isEmpty ( $param->org_no )) {
			$query .= " AND (test_info.org_no=:org_no ) ";
		}

		if (! StringUtil::isEmpty ( $param->test_info_name )) {
			$query .= " AND (test_info.test_info_name LIKE :test_info_name) ";
		}

		if (! StringUtil::isEmpty ( $param->status )) {
			$query .= " AND test_info.status IN (" . $param->status . ") ";
		}
		if (! StringUtil::isEmpty ( $param->updater_id )) {
			$query .= " AND (test_info.updater_id=:updater_id ) ";
		}

		$query .= " AND test_info.del_flg = '0' ";
		$query .= " GROUP BY org.org_no, report.report_no, test_info.test_info_no,report_test.disp_no, test_info.test_info_name, test_info.remarks, start_period,end_period ";
		$query .= " ORDER BY ";
		$query .= " report_test.disp_no,test_info.test_info_no ASC";
	
		if ($flg == "1") {
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}
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
		return parent::getDataList ( $stmt, get_class ( new T_Test_InfoDto () ) );
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($dto , $pdo) {
		return parent::insertWithPdo ( $dto , $pdo);
	}
	
	
	/*
	*
	* 試験結果詳細データを取得する
	*
	*/
	public function getRegisteredTestList($org_no, $report_no){
		
		$query = "SELECT ";
		$query .= "org.org_no, ";
		$query .= "report.report_no, ";
		$query .= "report.report_name,";
		$query .= "test_info.test_info_no, ";
		$query .= "test_info.test_info_name, ";
		$query .= "test_info.remarks, ";
		$query .= "test_info.start_period, ";
		$query .= "test_info.end_period, ";
		$query .= "report_test.disp_no ";
		$query .= "FROM ";
		$query .= "T_REPORT_TEST_INFO report_test ";
		$query .= "LEFT JOIN M_ORGANIZATION AS org ";
		$query .= "ON report_test.org_no = org.org_no ";
		$query .= "LEFT JOIN T_REPORT AS report ";
		$query .= "ON report_test.report_no = report.report_no ";
		$query .= "LEFT JOIN T_TEST_INFO AS test_info ";
		$query .= "ON report_test.test_info_no = test_info.test_info_no ";
		$query .= "WHERE ";
		$query .= "report.org_no = report_test.org_no  ";
		$query .= "AND report_test.org_no = test_info.org_no  ";
		$query .= "AND report.del_flg = '0'  ";
		$query .= "AND test_info.del_flg = '0'  ";
		$query .= "AND report_test.del_flg = '0' ";
		$query .= "AND org.org_no=:org_no AND report_test.report_no=:report_no ";
		$query .= " GROUP BY org.org_no, report.report_no, test_info.test_info_no, test_info.test_info_name, test_info.remarks, report_test.disp_no, start_period,end_period ";
		$query .= "ORDER BY report_test.disp_no ASC ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":report_no", $report_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_Report_Test_InfoDto()) );
	}
}