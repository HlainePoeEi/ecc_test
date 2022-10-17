<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_TestAssignmentDao.php';
require_once 'dao/T_TestDao.php';
require_once 'dto/T_Test_QuizDto.php';
require_once 'dto/T_TestDto.php';
require_once 'dao/M_OrganizationDao.php';
require_once 'service/BaseService.php';

class TestService extends BaseService{

	 public function getTestResultCount($form){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getTestResultCount($form);
	}

	public function getTestListData($form, $flg){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getTestListData($form, $flg);
	}

	public function getTestQuizDataList($test_no){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getTestQuizDataList($test_no);
	}

	public function getTestInfo($org_no, $test_no){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getTestInfo($org_no, $test_no);
	}

	public function getOrgStartDate($org_no){
		// データベース接続
		$dao = new M_OrganizationDao();
		return $dao-> getOrgStartDate($org_no);
	}

	public function insertData($param){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> insertData($param);
	}

	public function getNextId(){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getNextId();

	}

	public function updateTestInfo($dto){
		$itemDao = new T_TestDao();
		return $itemDao->updateTestInfo($dto);
	}


	public function copyTestInfo($dto){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> copyTestInfo($dto);
	}

	public function getListQuiz($org_no, $test_no){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getListQuiz($org_no, $test_no);
	}

	public function checkedExistTestInfo($org_no, $test_no){

		// データベース接続
		$itemDao = new T_TestDao();
		return $itemDao->checkedExistTestInfo($org_no, $test_no);

	}

	 public function getTestCountOnLesson($form){
		// データベース接続
		$dao = new T_TestAssignmentDao();
		$pageno= ($form->page - 1) * PAGE_ROW;
		return $dao-> getTestCountOnLesson($form , ($form->page - 1) * PAGE_ROW);
	}


public function getTestListOnLesson($form){
		// データベース接続
		$dao = new T_TestAssignmentDao();
		$pageno= ($form->page - 1) * PAGE_ROW;
		return $dao-> getTestListOnLesson($form , ($form->page - 1) * PAGE_ROW);
	}

	public function countExistingAssingment($org_no, $lesson_no) {
		$dao = new T_TestAssignmentDao ();
		return $dao->countExistingAssingment ( $org_no, $lesson_no );
	}

	public function deleteAssignmentDataOnLesson($org_no, $lesson_no) {
		// データベース接続
		$dao = new T_TestAssignmentDao ();
		return $dao->deleteAssignmentDataOnLesson ( $org_no, $lesson_no );
	}

	public function addAssignmentDataOnLesson($dto) {
		// データベース接続
		$dao = new T_TestAssignmentDao ( $this->pdo );
		return $dao->insert ( $dto );
	}

	public function getSearchTestList($dto){
		// データベース接続
		$dao = new T_TestAssignmentDao();
		return $dao-> getSearchTestList($dto, 1);
	}

	public function getLessonName($org_no, $lesson_no){
		// データベース接続
		$dao = new T_TestAssignmentDao();
		return $dao-> getLessonName($org_no, $lesson_no);
	}
	//テストプレビュー
	public function getListQuiz1($org_no, $test_no){
		// データベース接続
		$dao = new T_TestDao();
		return $dao-> getListQuiz1($org_no, $test_no);
	}
}

?>