<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'service/BaseService.php';
require_once 'conf/config.php';
require_once 'dao/T_QuizDetailDao.php';

class QuizDetailsService extends BaseService {

	// Tアイテム情報登録
	public function registQzDtlData($dto) {
		// データベース接続
		$dao = new T_QuizDetailDao($this->pdo);
		return $dao->insert ( $dto );
	}

	//Tオプション情報登録
	public function registQzOptDtlData($dto) {
		// データベース接続
		$dao = new T_QuizDetailDao($this->pdo);
		return $dao->insert ( $dto );
	}

	//クイズアイテム情報を取得
	public function getQzItemInfo($org_no, $quiz_info_no) {

		$qzDao = new T_QuizDetailDao($this->pdo );
		return $qzDao->getQzItemInfo($org_no, $quiz_info_no);
	}

	//クイズアイテムオプションを取得
	public function getQzItemOptionInfo($org_no , $quiz_info_no) {

		$qzDao = new T_QuizDetailDao($this->pdo );
		return $qzDao->getQzItemOptionInfo($org_no , $quiz_info_no);
	}

	//削除
	public function deleteQuizItemInfoDetails($org_no,$quiz_info_no) {
		$qzDelDao = new T_QuizDetailDao( $this->pdo );
		return  $qzDelDao->deleteQuizItemInfoDetails($org_no,$quiz_info_no);
	}

	//クイズ情報番号の存在チェック処理
	public function checkExistQInfoNo($org_no,$quiz_info_no){
		$qzChkDao = new T_QuizDetailDao( $this->pdo );
		return  $qzChkDao->checkExistQInfoNo($org_no,$quiz_info_no);
	}
	
	//クイズが回答したチェック処理
	public function checkTestedQuiz($org_no,$quiz_info_no){
		$qzTestedDao = new T_QuizDetailDao( $this->pdo );
		return  $qzTestedDao->checkTestedQuiz($org_no,$quiz_info_no);
	}

}

?>