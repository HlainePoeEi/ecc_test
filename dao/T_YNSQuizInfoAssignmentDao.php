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

        $query = " SELECT ";
        $query .= "@rownum:=@rownum+1 as rowno ";
        $query .= " ,quiz.quiz_id quiz_id";
        $query .= " ,quiz.name name ";
        $query .= " ,quiz.remarks remarks ";
        $query .= " ,quiz.content content";
        $query .= " FROM ";
        $query .= " (SELECT @rownum:=$offset) as dummy ";
        $query .= " ,t_ynsexam ttest ";
        $query .= " LEFT JOIN t_ynsquiz as testquiz ";
        $query .= " ON ttest.org_no = testquiz.org_no ";
        $query .= " AND ttest.exam_id = testquiz.quiz_id ";
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
        $query .= " testquiz.disp_no ASC";

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
        return $list;
    }

    public function getRegisteredQuizList($org_no, $test_info_no)
    {

        $query = "SELECT TTQ.org_no  AS org_no, ";
        $query .= "TTQ.test_info_no AS test_info_no, ";
        $query .= "TTQ.quiz_info_no AS quiz_info_no ";
        $query .= "FROM   T_TEST_INFO_QUIZ TTQ ";
        $query .= "INNER JOIN T_QUIZ_INFO TQ ON ";
        $query .= "TTQ.org_no=TQ.org_no AND TTQ.quiz_info_no=TQ.quiz_info_no ";
        $query .= "INNER JOIN T_TEST_INFO TT ON TTQ.org_no=TT.org_no AND TTQ.test_info_no=TT.test_info_no ";
        $query .= "WHERE TTQ.org_no=:org_no AND TTQ.test_info_no=:test_info_no AND TTQ.del_flg=0 ";
        $query .= "ORDER BY TTQ.disp_no ASC ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    }

    public function countExistingQuiz($org_no, $test_info_no)
    {
        $query = " SELECT";
        $query .= " count(quiz_info_no)";
        $query .= " FROM";
        $query .= " T_TEST_INFO_QUIZ";
        $query .= " WHERE";
        $query .= " org_no = :org_no";
        $query .= " AND test_info_no = :test_info_no";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function deleteQuizOnTest($org_no, $test_info_no, $pdo)
    {

        $query = "DELETE";
        $query .= " FROM";
        $query .= " T_TEST_INFO_QUIZ";
        $query .= " WHERE";
        $query .= " org_no = :org_no";
        $query .= " AND test_info_no = :test_info_no";
        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);
        $stmt->execute();
        return;
    }

    public function getSearchQuizList($param, $offset)
    {

        $query = " SELECT DISTINCT";
        $query .= "@rownum:=@rownum+1 as rowno ";
        $query .= " ,quiz.quiz_info_no quiz_info_no ";
        $query .= " ,quiz.quiz_name quiz_name ";
        $query .= " ,quiz.remarks remarks ";
        $query .= " ,quiz.long_description long_description";

        $query .= " FROM ";
        $query .= " (SELECT @rownum:=$offset) as dummy ";
        $query .= " , T_QUIZ_INFO quiz ";

        $query .= " WHERE quiz.org_no = :org_no ";


        if (isset($param->quiz_name) && !StringUtil::isEmpty($param->quiz_name)) {
            $query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
        }

        if (isset($param->remarks) && !StringUtil::isEmpty($param->remarks)) {
            $query .= " AND (quiz.remarks LIKE :remarks ) ";
        }
        if (!StringUtil::isEmpty($param->rd_status) && $param->rd_status == "1") {
            $query .= " AND quiz.updater_id = :updater_id  ";
        }

        $query .= " AND quiz.del_flg = '0' ";

        $query .= " ORDER BY ";
        $query .= " quiz_info_no ASC";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);

        if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {

            $name = '%' . $param->quiz_name . '%';
            $stmt->bindParam(":quiz_name", $name, PDO::PARAM_STR);
        }

        if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {

            $remarks = '%' . $param->remarks . '%';
            $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
        }

        if (isset($param->rd_status) && !StringUtil::isEmpty($param->rd_status) && $param->rd_status == "1") {
            $stmt->bindParam(":updater_id",  $_SESSION['manager_no'], PDO::PARAM_STR);
        }

        $list = parent::getDataList($stmt, get_class(new T_Quiz_InfoDto()));
        return $list;
    }

    public function getSearchQuizListJI($param, $offset)
    {


        $query = " SELECT DISTINCT";
        $query .= "@rownum:=@rownum+1 as rowno ";
        $query .= " ,quiz.quiz_info_no quiz_info_no ";
        $query .= " ,quiz.quiz_name quiz_name ";
        $query .= " ,quiz.remarks remarks ";
        $query .= " ,quiz.long_description long_description";

        $query .= " FROM ";
        $query .= " (SELECT @rownum:=$offset) as dummy ";
        $query .= " , T_QUIZ_INFO quiz ";

        $query .= " WHERE quiz.org_no = :org_no ";
        $query .= " AND quiz.updater_id = :login_id ";


        if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {
            $query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
        }

        if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {
            $query .= " AND (quiz.remarks LIKE :remarks ) ";
        }

        $query .= " AND quiz.del_flg = '0' ";

        $query .= " ORDER BY ";
        $query .= " quiz_info_no ASC";

        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":login_id", $param->login_id, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);

        if (isset($param->quiz_name) &&  !StringUtil::isEmpty($param->quiz_name)) {
            $name = '%' . $param->quiz_name . '%';
            $stmt->bindParam(":quiz_name", $name, PDO::PARAM_STR);
        }

        if (isset($param->remarks) &&  !StringUtil::isEmpty($param->remarks)) {
            $remarks = '%' . $param->remarks . '%';
            $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
        }
        $list = parent::getDataList($stmt, get_class(new T_Quiz_InfoDto()));
        return $list;
    }


    public function getTestData($org_no, $test_info_no)
    {
        $query = " SELECT";
        $query .= " test.test_info_no as test_info_no ";
        $query .= " ,test.test_info_name as test_info_name ";
        $query .= " ,date_format(test.start_period," . "'%Y/%m/%d') as start_period";
        $query .= " ,date_format(test.end_period," . "'%Y/%m/%d') as end_period";

        $query .= " FROM";
        $query .= " T_TEST_INFO test";
        $query .= " WHERE";
        $query .= " org_no = :org_no";
        $query .= " AND test_info_no = :test_info_no";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

        $list = parent::getDataList($stmt, get_class(new T_Quiz_InfoDto()));
        return $list;
    }
}
