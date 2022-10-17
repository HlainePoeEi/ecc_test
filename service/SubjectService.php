<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/M_SubjectDao.php';
require_once 'dto/M_SubjectDto.php';
require_once 'service/BaseService.php';

class SubjectService extends BaseService{

	/* 科目管理№の存在チェック */
	public function checkedExistInfo($org_no, $subject_no){
		// データベース接続
		$itemDao = new M_SubjectDao();
		// 組織管理者テーブルに組織管理№が存在しているかをチェックすること
		return $itemDao->checkedExistInfo($org_no, $subject_no);
	}

	/*教科の有効期間のチェック*/
	public function getSubjectAreaListByName($org_no, $subj_area_name){
		// データベース接続
		$dao = new M_SubjectDao();
		// データベースから教科データを取得すること
		return $dao->getSubjectAreaListByName($org_no, $subj_area_name);
	}
	
	/*教科の有効期間のチェック*/
	public function getSubjectAreaListForCheck($org_no, $subj_area_name ,$start_dt , $end_dt){
		// データベース接続
		$dao = new M_SubjectDao();
		// データベースから教科データを取得すること
		return $dao->getSubjectAreaListForCheck($org_no, $subj_area_name , $start_dt , $end_dt);
	}

	/* 次の科目№を取得する */
	public function getNextSubjNo(){
		// データベース接続
		$dao = new M_SubjectDao();
		// Tシーケンステーブルから次の科目№を取得する
		return $dao-> getNextSubjNo();
	}

	/* 登録処理 */
	public function insertData($param){
		// データベース接続
		$dao = new M_SubjectDao($this->pdo);
		// 科目データを登録すること
		return $dao-> insertData($param , $this->pdo);
	}

}
?>