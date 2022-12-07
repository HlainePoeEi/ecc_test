<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_YNSQuizDao.php';
require_once 'dao/T_Quiz_Info_AssignmentDao.php';
require_once 'dto/T_YNSQuizDto.php';
require_once 'dao/SequenceDao.php';
require_once 'service/BaseService.php';

class YNSQuizInfoService extends BaseService
{

    public function getQuizResultCount($form)
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        return $dao->getQuizResultCount($form);
    }

    public function getQuizSearchData($form, $flg)
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        return $dao->getQuizSearchData($form, $flg);
    }
    public function getQuizListData($form, $flg)
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        return $dao->getQuizListData($form, $flg);
    }

    public function getQuizDataByQuizNo($id)
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        return $dao->getQuizDataByQuizNo($id);
    }

    public function getQuizData($org_no, $quiz_info_no)
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        return $dao->getQuizData($org_no, $quiz_info_no);
    }

    public function saveQuiz($dto)
    {
        $quizDao = new T_YNSQuizDao();
        return $quizDao->saveQuiz($dto);
    }

    public function saveTestQuiz($dto)
    {
        $quizDao = new T_YNSQuizDao();
        return $quizDao->saveTestQuiz($dto);
    }

    public function getNextId()
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        // Tシーケンステーブルから次の管理者№を取得する
        return $dao->getNext();
    }

    public function getSequenceNo()
    {
        // データベース接続
        $dao = new SequenceDao();
        // Tシーケンステーブルから次の管理者№を取得する
        return $dao->getSequenceNo("quiz_info_no");
    }

    public function updateQuizInfo($dto)
    {
        // データベース接続
        $itemDao = new T_YNSQuizDao();
        // Ｔ管理者教師データを更新すること
        return $itemDao->updateQuizInfo($dto);
    }

    public function deleteQuizInfo($dto)
    {
        // データベース接続
        $itemDao = new T_YNSQuizDao();
        // Ｔ管理者教師データを更新すること
        return $itemDao->deleteQuizInfo($dto);
    }

    public function checkedExistInfo($org_no, $quiz_info_no, $quiz_name)
    {
        // データベース接続
        $orgDao = new T_YNSQuizDao();
        // 組織管理者テーブルに組織管理№が存在しているかをチェックすること
        return $orgDao->checkedExistInfo($org_no, $quiz_info_no, $quiz_name);
    }
    public function getQuizCountOnTest($form)
    {
        // データベース接続
        $dao = new T_Quiz_Info_AssignmentDao();
        $pageno = ($form->page - 1) * PAGE_ROW;
        return $dao->getQuizCountOnTest($form, ($form->page - 1) * PAGE_ROW);
    }

    public function getQuizListOnTest($form)
    {
        // データベース接続
        $dao = new T_YNSQuizInfoAssignmentDao();
        $pageno = ($form->page - 1) * PAGE_ROW;
        return $dao->getQuizListOnTest($form, $pageno);
    }

    public function countExistingQuiz($exam_id)
    {
        $dao = new T_YNSQuizInfoAssignmentDao();
        return $dao->countExistingQuiz($exam_id);
    }

    public function deleteQuizOnTest($exam_id)
    {
        // データベース接続
        $dao = new T_YNSQuizInfoAssignmentDao();
        return $dao->deleteQuizOnTest($exam_id, $this->pdo);
    }

    public function getRegisteredQuizList($org_no, $test_info_no)
    {
        // データベース接続
        $dao = new T_Quiz_Info_AssignmentDao();
        return $dao->getRegisteredQuizList($org_no, $test_info_no);
    }

    public function addQuizDataOnTest($dto)
    {
        // データベース接続
        $dao = new T_YNSQuizInfoAssignmentDao();
        return $dao->insertWithPdo($dto, $this->pdo);
    }

    public function getTestData($exam_id)
    {
        // データベース接続
        $dao = new T_YNSQuizInfoAssignmentDao();
        return $dao->getTestData($exam_id);
    }

    public function getQuizDataByQuizNoDisable($quizInfoNo)
    {
        // データベース接続
        $dao = new T_YNSQuizDao();
        return $dao->getQuizDataByQuizNoDisable($quizInfoNo);
    }

    public function bulkInsertWithPdo($list)
    {

        // データベース接続
        $quizDao = new T_YNSQuizDao($this->pdo);
        // Ｔ管理者教師データを更新すること
        return $quizDao->insertWithTranPdo($list, $this->pdo);
    }
}
