<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Quiz_InfoDto.php';
require_once 'dto/T_Test_Info_QuizDto.php';
require_once 'dto/T_YNSEXAMDto.php';
require_once 'dto/T_YNSQUIZDto.php';
require_once 'dto/T_YNS_EXAM_QUIZDto.php';
/**
 * T_QuizInfoAssignDAOクラス
 */

//QuizInfoAssignment Screen
class T_YNS_Exam_QuizDao extends BaseDao {

	public function getQuizCountOnTest($param, $offset){

		$mcategory1 = TEST_TYPE_KBN;
		$mcategory2 = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,T_TEST_INFO ttest ";
		$query .= " LEFT JOIN T_TEST_INFO_QUIZ as testquiz ";
		$query .= " ON ttest.org_no = testquiz.org_no ";
		$query .= " AND ttest.test_info_no = testquiz.test_info_no ";
		$query .= " LEFT JOIN T_QUIZ_INFO as quiz ";
		$query .= " ON ttest.org_no = quiz.org_no ";
		$query .= " AND testquiz.quiz_info_no = quiz.quiz_info_no ";
		$query .= " WHERE ttest.test_info_no = :test_info_no ";
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
		$query .= " quiz_info_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":test_info_no", $param->test_info_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {

			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_Quiz_InfoDto()) );

		return count($list);
	}

	public function getQuizListOnTest($param, $offset){

		$mcategory1 = TEST_TYPE_KBN;
		$mcategory2 = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,t_test_info ttest ";
		$query .= " LEFT JOIN T_TEST_INFO_QUIZ as testquiz ";
		$query .= " ON ttest.org_no = testquiz.org_no ";
		$query .= " AND ttest.test_info_no = testquiz.test_info_no ";
		$query .= " LEFT JOIN T_QUIZ_INFO as quiz ";
		$query .= " ON ttest.org_no = quiz.org_no ";
		$query .= " AND testquiz.quiz_info_no = quiz.quiz_info_no ";
		$query .= " WHERE ttest.test_info_no = :test_info_no ";
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
		LogHelper::logDebug ( "------------QuizInfo Select-----------------".$query);
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":test_info_no", $param->test_info_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if ( isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if ( isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_Quiz_InfoDto()) );

		return $list;
	}

	public function getRegisteredQuizList($exam_id){

		$query = "SELECT ";
		$query .= "TEQ.exam_id AS exam_id, ";
		$query .= "TEQ.quiz_id AS quiz_id ";
		$query .= "FROM   T_YNS_EXAM_QUIZ TEQ ";
		$query .= "INNER JOIN T_YNSQUIZ TQ ON ";
		$query .= "TEQ.quiz_id=TQ.quiz_id ";
		$query .= "INNER JOIN T_YNSEXAM TE ON TEQ.exam_id=TE.exam_id ";
		$query .= "WHERE TEQ.exam_id=:exam_id ";
		//$query .= "ORDER BY TTQ.disp_no ASC ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":exam_id", $exam_id, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_YNS_Exam_QuizDto()) );
	}

	public function countExistingQuiz($exam_id) {
		$query = " SELECT";
		$query .= " count(quiz_id)";
		$query .= " FROM";
		$query .= " T_YNS_EXAM_QUIZ";
		$query .= " WHERE";
		$query .= " exam_id = :exam_id";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":exam_id", $exam_id, PDO::PARAM_STR );
		$stmt->execute ();
		return $stmt->fetchColumn ();
	}

	public function deleteQuizOnTest($exam_id) {

		$query = "DELETE";
		$query .= " FROM";
		$query .= " T_YNS_EXAM_QUIZ";
		$query .= " WHERE";
		$query .= " exam_id = :exam_id";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":exam_id", $exam_id, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

	public function getSearchQuizList($param, $offset){

		$query = " SELECT";
		$query .= " quiz.*";
		$query .= " FROM";
		$query .= " T_YNSQUIZ quiz";

		if(!StringUtil::isEmpty($param->quiz_name) || !StringUtil::isEmpty($param->remarks)){
			$query .= " WHERE ";
		}
	
		if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
			$query .= " (quiz.name LIKE :quiz_name) ";
		}

		if(isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name) && isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
			$query .= " AND";
		}

		if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
			$query .= " (quiz.remarks LIKE :remarks ) ";
		}

		// if (! StringUtil::isEmpty($param->rd_status) && $param->rd_status == "1") {
		// 	$query .= " AND quiz.updater_id = :updater_id  ";
		// }

		$query .= " ORDER BY ";
		$query .= " name ASC";
		$query .= " ,content ASC";

		$stmt = $this->pdo->prepare ( $query );

		if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {

			$remarks = '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		// if (isset($param->rd_status) && !StringUtil::isEmpty($param->rd_status) && $param->rd_status == "1") {
		// 	$stmt->bindParam ( ":updater_id",  $_SESSION ['manager_no'] , PDO::PARAM_STR );
		// }

		$list = parent::getDataList( $stmt, get_class(new T_YNSQuizDto()) );
		return $list;
	}

	public function getSearchQuizListJI($param, $offset){

		$mcategory = QUIZ_CATEG_KBN;
		$query = " SELECT DISTINCT";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " , T_QUIZ_INFO quiz ";
		$query .= " LEFT JOIN M_TYPE as mtype ";
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
		$query .= " quiz_info_no ASC";

		$stmt = $this->pdo->prepare ( $query );

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
		$list = parent::getDataList( $stmt, get_class(new T_Quiz_InfoDto()) );
		return $list;
	}


	public function getTestData($org_no, $exam_id) {
		$query = " SELECT";
		$query .= " exam.exam_id as exam_id ";
		$query .= " ,exam.name as name ";
		$query .= " ,date_format(exam.start_date,"."'%Y/%m/%d') as start_date";
		$query .= " ,date_format(exam.end_date,"."'%Y/%m/%d') as end_date";

		$query .= " FROM";
		$query .= " T_YNSEXAM exam";
		$query .= " WHERE";
		$query .= " exam_id = :exam_id";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":exam_id", $exam_id, PDO::PARAM_STR );

		$list = parent::getDataList( $stmt, get_class(new T_YNSExamDto()));

		return $list;
	}
}

?>