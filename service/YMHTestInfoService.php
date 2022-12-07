<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_YMHTestInfoDao.php';
require_once 'dto/T_YNSExamDto.php';
require_once 'service/BaseService.php';

class YMHTestInfoService extends BaseService{

	public function getExamList($form){
		// データベース接続
		$dao = new T_YMHTestInfoDao();
		return $dao-> getExamList($form);
	}

	public function getTestResultCount($form){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao-> getTestResultCount($form);
	}

	public function getTestListData($form){
		// データベース接続
		$dao = new T_YMHTestInfoDao();
		return $dao-> getTestListData($form);
	}
 
	//テストプレビュー
	public function getListQuiz($org_no, $test_no){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao-> getListQuiz($org_no, $test_no);
	}
	
	public function getItemList($quiz_info_no){
	    // データベース接続
	    $dao = new T_Test_InfoDao();
	    return $dao-> getItemList($quiz_info_no);
	}
	public function getOptionList( $item_no,$quiz_info_no){
	    // データベース接続
	    $dao = new T_Test_InfoDao();
	    return $dao-> getOptionList( $item_no,$quiz_info_no);
	}

	//テストプレビュー
	public function registTestInfoResult($dto){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->updateTestInfoResult($dto);
	}

	public function insertData($param){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->insertData($param);
	}

	public function getQuizData($param){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->getQuizData($param);
	}

	public function getTestResultData($param){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->getTestResultData($param);
	}
	
	public function getItemData($test_no,$org_no){
	   	    $dao = new T_Test_InfoDao();
	   	    return $dao->getItemData($test_no,$org_no);
	}
	
	public function updateShowFlag($org_no,$test_no){
	    $dao = new T_Test_InfoDao();
	    return $dao->updateShowFlag($org_no,$test_no);
	}
	
	public function updateAnsOptNo($org_no,$test_no,$student_no){
	    $dao = new T_Test_InfoDao();
	    return $dao->updateAnsOptNo($org_no,$test_no,$student_no);
	}
	
	// メニュー画面用、未読の試験データ取得
	public function getTestListForMenu($org , $student_no){
		
		// データベース接続
		$dao = new T_Test_InfoDao($this->pdo);
		return $dao->getTestListForMenu($org , $student_no,$this->pdo);
	}
	
	//テスト回答履歴番号取得
	public function getMaxHistoryNumber($param) {

		// データベース接続
		$dao = new T_Test_InfoDao($this->pdo);
		return $dao->getMaxHistoryNumber($param , $this->pdo);
	}
	
	//試験結果履歴データ更新
	public function updateTestInfoResultHistory($dto){
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->updateTestInfoResultHistory($dto);
	}
	
	public function getQuizListForDrill($org_no, $student_no){
		
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->getQuizListForDrill($org_no, $student_no);
	}
	
	public function getQuizListForDrillChart2($org_no, $student_no){
		
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->getQuizListForDrillChart2($org_no, $student_no);
	}
	
	public function getQuizListForDrillChart3($org_no, $student_no){
		
		// データベース接続
		$dao = new T_Test_InfoDao();
		return $dao->getQuizListForDrillChart3($org_no, $student_no);
	}
	
}

?>