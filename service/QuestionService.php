<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_QuestionDao.php';
require_once 'dao/T_QuestionAssignmentDao.php';
require_once 'dao/M_TypeDao.php';
require_once 'service/BaseService.php';

class QuestionService extends BaseService{

	 public function getQuestionResultCount($form){
		// データベース接続
		$dao = new T_QuestionDao();
		return $dao-> getQuestionResultCount($form);
	}

	public function getCategoryTypeAll($param) {
		// データベース接続
		$dao = new M_TypeDao();
		return $dao->getCategoryTypeAll($param);
	}

	public function getQuestionListData($form, $flg){
		// データベース接続
		$dao = new T_QuestionDao();
		return $dao-> getQuestionListData($form, $flg);
	}

	public function getQuestionInfo( $question_no ){
		// データベース接続
		$dao = new T_QuestionDao();
		return $dao-> getQuestionInfo( $question_no );
	}

	public function insertData($param){
		// データベース接続
		$dao = new T_QuestionDao();
		return $dao-> insertData($param);
	}

	public function getNextId(){
		// データベース接続
		$dao = new T_QuestionDao();
		return $dao-> getNextId();
	}

	public function updateQuestionInfo($dto){
		// データベース接続
		$itemDao = new T_QuestionDao();
		return $itemDao->updateQuestionInfo($dto);
	}

	public function checkedExistTestInfo($org_no, $question_no){
		// データベース接続
		$itemDao = new T_QuestionDao();
		return $itemDao->checkedExistTestInfo($org_no, $question_no);
	}

	public function getSearchQuestionList($dto){
		// データベース接続
		$dao = new T_TestAssignmentDao();
		return $dao-> getSearchQuestionList($dto, 1);
	}

	public function deleteQuestion($dto){
		// データベース接続
		$itemDao = new T_QuestionDao();
		return $itemDao->deleteQuestion($dto);
	}

	public function getQuestionDetailListData($param){
		// データベース接続
		$dao = new T_QuestionDao();
		return $dao->getQuestionDetailListData($param);
	}
}

?>