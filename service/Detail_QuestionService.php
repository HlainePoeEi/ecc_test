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

class Detail_QuestionService extends BaseService{

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

	public function getQuestionListOnDetail($dto){
		// データベース接続
		$itemDao = new T_QuestionAssignmentDao();
		return $itemDao->getQuestionListOnDetail($dto, ($dto->page - 1) * PAGE_ROW);
	}

	public function getDetailData($dto){
		// データベース接続
		$itemDao = new T_QuestionAssignmentDao();
		return $itemDao->getDetailData($dto);
	}

	public function getDetailInfo($dto){
		// データベース接続
		$itemDao = new T_QuestionAssignmentDao();
		return $itemDao->getDetailInfo($dto);
	}

	public function deleteExistQuestions($course_detail_no){
		// データベース接続
		$itemDao = new T_QuestionAssignmentDao($this->pdo);
		return $itemDao->deleteExistQuestions($course_detail_no , $this->pdo);
	}

	public function addDetailQuestions($dto){
		// データベース接続
		$itemDao = new T_QuestionAssignmentDao($this->pdo);
		return $itemDao->insertData($dto , $this->pdo);
	}
}

?>