<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_QuizDto.php';
require_once 'dto/T_Test_QuizDto.php';
/**
 * T_TestDAOクラス
 */

//Test_Assignment Screen
class T_QuizAssignmentDao extends BaseDao {

	public function getQuizCountOnTest($param, $offset){

		$mcategory1 = TEST_TYPE_KBN;
		$mcategory2 = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,CASE WHEN quiz.quiz_type = '001' THEN '4択' ELSE '穴埋め' END AS quiz_type ";
		$query .= " ,quiz.quiz_content quiz_content";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,T_TEST ttest ";
		$query .= " LEFT JOIN T_TEST_QUIZ as testquiz ";
		$query .= " ON ttest.org_no = testquiz.org_no ";
		$query .= " AND ttest.test_no = testquiz.test_no ";
		$query .= " LEFT JOIN T_QUIZ as quiz ";
		$query .= " ON ttest.org_no = quiz.org_no ";
		$query .= " AND testquiz.quiz_no = quiz.quiz_no ";

		$query .= " LEFT JOIN M_TYPE as mtype1 ";
		$query .= " ON ttest.test_type = mtype1.type ";

		$query .= " LEFT JOIN M_TYPE as mtype2 ";
		$query .= " ON quiz.quiz_type = mtype2.type ";

		$query .= " WHERE mtype1.category = :mcategory1 ";
		$query .= " AND mtype2.category = :mcategory2 ";
		$query .= " AND ttest.test_no = :test_no ";
		$query .= " AND ttest.org_no = :org_no ";


		if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (quiz.remarks LIKE :remarks ) ";
		}

		$query .= " AND ttest.del_flg = '0' ";
		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " quiz_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":test_no", $param->test_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory1", $mcategory1, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory2", $mcategory2, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {

			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_QuizDto()) );

		return count($list);
	}

	public function getQuizListOnTest($param, $offset){

		$mcategory1 = TEST_TYPE_KBN;
		$mcategory2 = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,CASE WHEN quiz.quiz_type = '001' THEN '4択' ELSE '穴埋め' END AS quiz_type ";
		$query .= " ,quiz.quiz_content quiz_content";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,T_TEST ttest ";
		$query .= " LEFT JOIN T_TEST_QUIZ as testquiz ";
		$query .= " ON ttest.org_no = testquiz.org_no ";
		$query .= " AND ttest.test_no = testquiz.test_no ";
		$query .= " LEFT JOIN T_QUIZ as quiz ";
		$query .= " ON ttest.org_no = quiz.org_no ";
		$query .= " AND testquiz.quiz_no = quiz.quiz_no ";

		$query .= " LEFT JOIN M_TYPE as mtype1 ";
		$query .= " ON ttest.test_type = mtype1.type ";

		$query .= " LEFT JOIN M_TYPE as mtype2 ";
		$query .= " ON quiz.quiz_type = mtype2.type ";

		$query .= " WHERE mtype1.category = :mcategory1 ";
		$query .= " AND mtype2.category = :mcategory2 ";
		$query .= " AND ttest.test_no = :test_no ";
		$query .= " AND ttest.org_no = :org_no ";

		if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (isset($param->remarks) && ! StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (quiz.remarks LIKE :remarks ) ";
		}

		$query .= " AND ttest.del_flg = '0' ";
		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " testquiz.disp_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":test_no", $param->test_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory1", $mcategory1, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory2", $mcategory2, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if ( isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if ( isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_QuizDto()) );
		return $list;
	}

	public function getRegisteredQuizList($org_no, $test_no){
		
		$query = "SELECT TTQ.org_no  AS org_no, ";
		$query .= "TTQ.test_no AS test_no, ";
		$query .= "TTQ.quiz_no AS quiz_no ";
		$query .= "FROM   T_TEST_QUIZ TTQ ";
		$query .= "INNER JOIN T_QUIZ TQ ON ";
		$query .= "TTQ.org_no=TQ.org_no AND TTQ.quiz_no=TQ.quiz_no ";
		$query .= "INNER JOIN T_TEST TT ON TTQ.org_no=TT.org_no AND TTQ.test_no=TT.test_no ";
		$query .= "WHERE TTQ.org_no=:org_no AND TTQ.test_no=:test_no AND TTQ.del_flg=0 ";
		$query .= "ORDER BY TTQ.disp_no ASC ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_Test_QuizDto()) );
	}

	public function countExistingQuiz($org_no, $test_no) {
		$query = " SELECT";
		$query .= " count(quiz_no)";
		$query .= " FROM"; // FROM
		$query .= " T_TEST_QUIZ";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND test_no = :test_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );
		$stmt->execute ();
		return $stmt->fetchColumn ();
	}

	public function deleteQuizOnTest($org_no, $test_no , $pdo) {

		$query = "DELETE";
		$query .= " FROM"; // FROM
		$query .= " T_TEST_QUIZ";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND test_no = :test_no";
		$stmt = $pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

	public function getSearchQuizList($param, $offset){

		$mcategory = QUIZ_CATEG_KBN;
		$query = " SELECT DISTINCT";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,CASE WHEN quiz.quiz_type = '001' THEN '4択' ELSE '穴埋め' END AS quiz_type ";
		$query .= " ,quiz.quiz_content quiz_content";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " , T_QUIZ quiz ";
		$query .= " LEFT JOIN M_TYPE as mtype ";

		$query .= " ON quiz.quiz_type = mtype.type ";

		$query .= " WHERE mtype.category = :mcategory ";


		if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (quiz.remarks LIKE :remarks ) ";
		}
		if (! StringUtil::isEmpty($param->rd_status) && $param->rd_status == "1") {
			$query .= " AND quiz.updater_id = :updater_id  ";
		}

		$query .= " AND quiz.del_flg = '0' ";
		$query .= " AND quiz.org_no = :org_no ";

		$query .= " ORDER BY ";
		$query .= " quiz_no ASC";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {

			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		if (isset($param->rd_status) && !StringUtil::isEmpty($param->rd_status) && $param->rd_status == "1") {
			$stmt->bindParam ( ":updater_id",  $_SESSION ['manager_no'] , PDO::PARAM_STR );
		}

		$list = parent::getDataList( $stmt, get_class(new T_QuizDto()) );
		return $list;
	}

	public function getSearchQuizListJI($param, $offset){

		$mcategory = QUIZ_CATEG_KBN;
		$query = " SELECT DISTINCT";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,CASE WHEN quiz.quiz_type = '001' THEN '4択' ELSE '穴埋め' END AS quiz_type ";
		$query .= " ,quiz.quiz_content quiz_content";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " , T_QUIZ quiz ";
		$query .= " LEFT JOIN M_TYPE as mtype ";

		$query .= " ON quiz.quiz_type = mtype.type ";

		$query .= " WHERE mtype.category = :mcategory ";
		$query .= " AND quiz.updater_id = :login_id ";
		$query .= " AND quiz.org_no = :org_no ";


		if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (quiz.remarks LIKE :remarks ) ";
		}

		$query .= " AND quiz.del_flg = '0' ";

		$query .= " ORDER BY ";
		$query .= " quiz_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );
		$stmt->bindParam ( ":login_id", $param->login_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {
			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {
			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}
		$list = parent::getDataList( $stmt, get_class(new T_QuizDto()) );
		return $list;
	}


	public function getTestData($org_no, $test_no) {
		$query = " SELECT";
		$query .= " test.test_no as test_no ";
		$query .= " ,test.test_name as test_name ";
		$query .= " ,test.test_type as test_type ";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";

		$query .= " FROM";
		$query .= " T_TEST test";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND test_no = :test_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );

		$list = parent::getDataList( $stmt, get_class(new T_QuizDto()) );
		return $list;
	}
}

?>