<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_Quiz_InfoDao.php';
require_once 'dto/T_Quiz_InfoDto.php';
require_once 'dto/M_TypeDto.php';
require_once 'dao/SequenceDao.php';
require_once 'service/BaseService.php';

class QuizInfoAssignService extends BaseService{

	public function getQuizResultCount($form){
		// データベース接続
		$dao = new T_Quiz_InfoDao();
		return $dao-> getQuizResultCount($form);
	}

	public function getQuizListData($form, $flg){
		// データベース接続
		$dao = new T_Quiz_InfoDao();
		return $dao-> getQuizListData($form, $flg);
	}

	public function getQuizCountOnTest($form){
		// データベース接続
		$dao = new T_QuizInfoAssignDao();
		$pageno= ($form->page - 1) * PAGE_ROW;
		return $dao-> getQuizCountOnTest($form , ($form->page - 1) * PAGE_ROW);
	}

	public function getQuizListOnTest($form){
		// データベース接続
		$dao = new T_QuizInfoAssignDao();
		$pageno= ($form->page - 1) * PAGE_ROW;
		return $dao-> getQuizListOnTest($form , ($form->page - 1) * PAGE_ROW);
	}

	public function countExistingQuiz($org_no, $lesson_no) {
		$dao = new T_QuizInfoAssignDao ();
		return $dao->countExistingQuiz ( $org_no, $lesson_no );
	}

	public function deleteQuizOnTest($org_no, $test_no) {
		// データベース接続
		$dao = new T_QuizInfoAssignDao ($this->pdo);
		return $dao->deleteQuizOnTest ( $org_no, $test_no , $this->pdo);
	}

	public function getRegisteredQuizList($org_no, $test_no) {
		// データベース接続
		$dao = new T_QuizInfoAssignDao ();
		return $dao->getRegisteredQuizList($org_no, $test_no);
	}

	public function addQuizDataOnTest($dto) {
		// データベース接続
		$dao = new T_QuizInfoAssignDao ( $this->pdo );
		return $dao->insertWithPdo ( $dto , $this->pdo );
	}

	public function getSearchQuizList($dto){
		// データベース接続
		$dao = new T_QuizInfoAssignDao();
		return $dao-> getSearchQuizList($dto, 1);
	}

	public function getSearchQuizListJI($dto){
		// データベース接続
		$dao = new T_QuizInfoAssignDao();
		return $dao-> getSearchQuizListJI($dto, 1);
	}

	public function getTestData($org_no, $test_no){
		// データベース接続
		$dao = new T_QuizInfoAssignDao();
		return $dao-> getTestData($org_no, $test_no);
	}

	public function getQuizDataByQuizNo($form){
		// データベース接続
		$dao = new T_Quiz_InfoDao();
		return $dao-> getQuizDataByQuizNo($form);
	}

	public function saveQuiz($dto){
		$quizDao = new T_Quiz_InfoDao();
		return $quizDao->saveQuiz($dto);
	}

	public function saveTestQuiz($dto){
		$quizDao = new T_Quiz_InfoDao();
		return $quizDao->saveTestQuiz($dto);
	}

	public function getNextId(){
		// データベース接続
		$dao = new T_Quiz_InfoDao();
		// Tシーケンステーブルから次の管理者№を取得する
		return $dao-> getnextId();
	}

	public function getSequenceNo(){
		// データベース接続
		$dao = new SequenceDao();
		// Tシーケンステーブルから次の管理者№を取得する
		return $dao-> getSequenceNo("quiz_no");
	}

	public function updateQuizInfo($dto){
		// データベース接続
		$itemDao = new T_Quiz_InfoDao();
		// Ｔ管理者教師データを更新すること
		return $itemDao->updateQuizInfo($dto);
	}

	public function deleteQuizInfo($dto){
		// データベース接続
		$itemDao = new T_Quiz_InfoDao();
		// Ｔ管理者教師データを更新すること
		return $itemDao->deleteQuizInfo($dto);
	}

	public function checkedExistInfo($org_no, $quiz_no, $quiz_name){
		// データベース接続
		$orgDao = new T_Quiz_InfoDao();
		// 組織管理者テーブルに組織管理№が存在しているかをチェックすること
		return $orgDao->checkedExistInfo($org_no, $quiz_no, $quiz_name);
	}
}

?>