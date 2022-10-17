<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_TestDto.php';
require_once 'dto/T_Test_QuizDto.php';
/**
 * T_TestAssignmentDAOクラス
 */

//Test_Assignment Screen
class T_TestAssignmentDao extends BaseDao {

	 public function getTestCountOnLesson($param, $offset){

		$mcategory = STU_CATEGORG;

		$query = " SELECT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,test.test_no test_no ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,test.remarks remarks ";
		$query .= " ,test.test_type test_type ";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,M_LESSON mlesson ";
		$query .= " LEFT JOIN T_LESSON_TEST as lesstest ";
		$query .= " ON mlesson.org_no = lesstest.org_no ";
		$query .= " AND mlesson.lesson_no = lesstest.lesson_no ";
		$query .= " LEFT JOIN T_TEST as test ";
		$query .= " ON mlesson.org_no = test.org_no ";
		$query .= " AND lesstest.test_no = test.test_no ";
		$query .= " LEFT JOIN M_TYPE as mtype ";
		$query .= " ON mtype.type = test.test_type ";

		$query .= " WHERE mtype.category = :mcategory ";
		$query .= " AND mlesson.lesson_no = :lesson_no ";
		$query .= " AND mlesson.org_no = :org_no ";


		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (test.remarks LIKE :remarks ) ";
		}

		$query .= " AND test.del_flg = '0' ";
		$query .= " AND mlesson.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " test_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":lesson_no", $param->lesson_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = '%'.$param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remarks)) {

			$remark = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_TestDto()) );
		LogHelper::logDebug($list);

		return count($list);
	}

	public function getTestListOnLesson($param, $offset){

		$mcategory = STU_CATEGORG;
		/*$offset = ($form->page-1) * PAGE_ROW;*/

		$query = " SELECT DISTINCT";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,test.test_no test_no ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,test.remarks remarks ";
		$query .= " ,test.test_type test_type ";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " , M_LESSON mlesson ";
		$query .= " LEFT JOIN T_LESSON_TEST as lesstest ";
		$query .= " ON mlesson.org_no = lesstest.org_no ";
		$query .= " AND mlesson.lesson_no = lesstest.lesson_no ";
		$query .= " LEFT JOIN T_TEST as test ";
		$query .= " ON mlesson.org_no = test.org_no ";
		$query .= " AND lesstest.test_no = test.test_no ";
		$query .= " LEFT JOIN M_TYPE as mtype ";
		$query .= " ON mtype.type = test.test_type ";
		$query .= " WHERE mtype.category = :mcategory ";
		$query .= " AND mlesson.lesson_no = :lesson_no ";
		$query .= " AND mlesson.org_no = :org_no ";

		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (test.remarks LIKE :remarks ) ";
		}

		$query .= " AND test.del_flg = '0' ";
		$query .= " AND mlesson.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " test_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":lesson_no", $param->lesson_no, PDO::PARAM_STR );

		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = '%'.$param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remarks)) {

			$remark = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list = parent::getDataList( $stmt, get_class(new T_TestDto()) );

		return $list;
	}


	public function countExistingAssingment($org_no, $lesson_no) {
		$query = " SELECT";
		$query .= " count(test_no)";
		$query .= " FROM"; // FROM
		$query .= " T_LESSON_TEST";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND lesson_no = :lesson_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_no", $lesson_no, PDO::PARAM_STR );

		$stmt->execute ();
		return $stmt->fetchColumn ();
	}

	public function deleteAssignmentDataOnLesson($org_no, $lesson_no) {
		$query = "DELETE";
		$query .= " FROM"; // FROM
		$query .= " T_LESSON_TEST";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND lesson_no = :lesson_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_no", $lesson_no, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

	public function getSearchTestList($param, $offset){

		$mcategory = STU_CATEGORG;
		/*$offset = ($form->page-1) * PAGE_ROW;*/

		$query = " SELECT DISTINCT";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,test.test_no test_no ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,test.remarks remarks ";
		$query .= " ,test.test_type test_type ";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " , T_TEST test ";
		$query .= " LEFT JOIN M_TYPE as mtype ";

		$query .= " ON test.test_type = mtype.type ";

		$query .= " WHERE mtype.category = :mcategory ";


		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (test.remarks LIKE :remarks ) ";
		}

		$query .= " AND test.del_flg = '0' ";

		$query .= " ORDER BY ";
		$query .= " test_name ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = '%'.$param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remarks)) {

			$remark = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list = parent::getDataList( $stmt, get_class(new T_TestDto()) );
		return $list;
	}

	public function getLessonName($org_no, $lesson_no) {
		$query = " SELECT";
		$query .= " lesson_name";
		$query .= " FROM";
		$query .= " M_LESSON";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND lesson_no = :lesson_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_no", $lesson_no, PDO::PARAM_STR );

		$stmt->execute ();
		return $stmt->fetchColumn ();
	}


}

?>