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
require_once 'dto/T_YNSExamDto.php';
/**
 * T_Quiz_Info_AssignmentDAOクラス
 */

//Test_Assignment Screen
class T_YNSQuizInfoAssignmentDao extends BaseDao
{

    public function getQuizCountOnTest($param, $offset)
    {


        $query = " SELECT ";
        $query .= "@rownum:=@rownum+1 as rowno ";
        $query .= " ,quiz.quiz_info_no quiz_info_no ";
        $query .= " ,quiz.quiz_name quiz_name ";
        $query .= " ,quiz.remarks remarks ";
        $query .= " ,quiz.long_description long_description";

        $query .= " FROM ";
        $query .= " (SELECT @rownum:=$offset) as dummy ";
        $query .= " ,T_TEST ttest ";
        $query .= " LEFT JOIN T_TEST_INFO_QUIZ as testquiz ";
        $query .= " ON ttest.org_no = testquiz.org_no ";
        $query .= " AND ttest.test_info_no = testquiz.test_info_no ";
        $query .= " LEFT JOIN T_QUIZ as quiz ";
        $query .= " ON ttest.org_no = quiz.org_no ";
        $query .= " AND testquiz.quiz_info_no = quiz.quiz_info_no ";

        $query .= " WHERE ttest.org_no = :org_no ";
        $query .= " AND ttest.test_info_no = :test_info_no ";

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

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":test_info_no", $param->test_info_no, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);

        if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {

            $name = '%' . $param->quiz_name . '%';
            $stmt->bindParam(":quiz_name", $name, PDO::PARAM_STR);
        }

        if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {

            $remarks = '%' . $param->remarks . '%';
            $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
        }

        $list = parent::getDataList($stmt, get_class(new T_Quiz_InfoDto()));

        return count($list);
    }

    public function getQuizListOnTest($param, $offset)
    {

        $query = "SELECT ";
        $query .= "@rownum:=@rownum+1 as rowno ";
		$query .= ",TQ.* ";
        $query .= "FROM ";
        $query .= "(SELECT @rownum:=$offset) as dummy ";
		$query .= ",T_YNS_EXAM_QUIZ TEQ ";
		$query .= "INNER JOIN T_YNSQUIZ TQ ON ";
		$query .= "TEQ.quiz_id=TQ.quiz_id ";
		$query .= "INNER JOIN T_YNSEXAM TE ON TEQ.exam_id=TE.exam_id ";
		$query .= "WHERE TEQ.exam_id=:exam_id ";

        // if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
        //     $query .= " AND (quiz.name LIKE :quiz_name) ";
        // }

        // if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
        //     $query .= " AND (quiz.remarks LIKE :remarks ) ";
        // }

        $query .= " ORDER BY ";
        $query .= " TEQ.disp_no ASC";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":exam_id", $param->exam_id, PDO::PARAM_STR);
        //$stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);

        // if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
        //     $name = '%' . $param->quiz_name . '%';
        //     $stmt->bindParam(":quiz_name", $name, PDO::PARAM_STR);
        // }

        // if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
        //     $remarks = '%' . $param->remarks . '%';
        //     $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
        // }

        $list = parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
        return $list;
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

    public function deleteQuizOnTest($exam_id , $pdo) {

		$query = "DELETE";
		$query .= " FROM";
		$query .= " T_YNS_EXAM_QUIZ";
		$query .= " WHERE";
		$query .= " exam_id = :exam_id";
		$stmt = $pdo->prepare ( $query );
		$stmt->bindParam ( ":exam_id", $exam_id, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

    public function getTestData($exam_id) {
		$query = " SELECT";
		$query .= " test.exam_id as exam_id ";
		$query .= " ,test.name as name ";
		$query .= " ,date_format(test.start_date,"."'%Y/%m/%d') as start_date";
		$query .= " ,date_format(test.end_date,"."'%Y/%m/%d') as end_date";

		$query .= " FROM";
		$query .= " T_YNSEXAM test";
		$query .= " WHERE";
		$query .= " exam_id = :exam_id";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":exam_id", $exam_id, PDO::PARAM_STR );

		$list = parent::getDataList( $stmt, get_class(new T_YNSExamDto()) );
		return $list;
	}
}
