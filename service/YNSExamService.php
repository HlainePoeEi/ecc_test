<?php
require_once 'dao/T_YNSExamDao.php';
require_once 'dto/T_YNSExamDto.php';
require_once 'service/BaseService.php';

class YNSExamService extends BaseService
{

    public function getTestInfoListData($form, $flg)
    {
        // データベース接続
        $dao = new T_YNSExamDao();
        return $dao->getTestInfoListData($form, $flg);
    }

    public function getTestInfoResultCount($form)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getTestInfoResultCount($form);
    }

    public function getTestInfo($org_no, $test_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getTestInfo($org_no, $test_info_no);
    }

    public function updateTestInfo($dto)
    {
        $itemDao = new T_TestInfoDao($this->pdo);
        return $itemDao->updateTestInfo($dto, $this->pdo);
    }

    public function getNextId()
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getNextId();
    }

    public function insertData($param)
    {
        // データベース接続
        $dao = new T_TestInfoDao($this->pdo);
        return $dao->insertData($param, $this->pdo);
    }

    public function getListQuiz($org_no, $test_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getListQuiz($org_no, $test_info_no);
    }

    //テスト情報プレビュー、クイズリストを取得
    public function getQuizList($org_no, $test_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getQuizList($org_no, $test_info_no);
    }

    //テスト情報プレビュー、アイテムリストを取得
    public function getQuizItemList($org_no, $test_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getQuizItemList($org_no, $test_info_no);
    }

    //テスト情報プレビュー、オプションリストを取得
    public function getQuizItemOptionList($org_no, $test_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getQuizItemOptionList($org_no, $test_info_no);
    }

    /*
	* 試験結果詳細データを取得する
	*/
    public function getQuizResultDetailListData($form)
    {
        // データベース接続
        $dao = new T_TestInfoDao($this->pdo);
        return $dao->getQuizResultDetailListData($form, $this->pdo);
    }

    public function getItemList($quiz_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getItemList($quiz_info_no);
    }

    public function getOptionList($item_no, $quiz_info_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getOptionList($item_no, $quiz_info_no);
    }
    //テストプレビュー
    public function getListQuizForPreview($org_no, $test_no)
    {
        // データベース接続
        $dao = new T_TestInfoDao();
        return $dao->getListQuizForPreview($org_no, $test_no);
    }
}
