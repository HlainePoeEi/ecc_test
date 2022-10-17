<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワークgetSearchResultCount
 *
 *****************************************************/

require_once 'dao/M_Subject_AreaDao.php';
require_once 'dto/M_Subject_AreaDto.php';
require_once 'dao/M_OrganizationDao.php';
require_once 'service/BaseService.php';

class Subject_AreaService extends BaseService{

	/* 教科情報を取得処理 */
	public function getSubjectAreaListData($form, $flg){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		return $dao-> getM_Subject_AreaListData($form, $flg);
	}

	/* 教科データカウントの取得処理 */
	public function getSearchResultCount($form){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		return $dao-> getSearchResultCount($form);
	}

	/* 組織開始期の開始日を取得処理 */
	public function getOrgStartDate($org_no){
		// データベース接続
		$dao = new M_OrganizationDao();
		// システムの組織開始期の開始日を取得する
		return $dao-> getOrgStartDate($org_no);
	}

	/* 科目があるかどうかのチェック */
	public function checkedExistSubjectInfo($org_no, $subject_area_no){
		$itemDao = new M_Subject_AreaDao();
		return $itemDao->checkedExistSubjectInfo($org_no, $subject_area_no);
	}

	/* 教科名か既にあるかどうかのチェック */
	public function checkedExistSubjectAreaInfo($org_no, $subject_area_name){
		$itemDao = new M_Subject_AreaDao();
		return $itemDao->checkedExistSubjectAreaInfo($org_no, $subject_area_name);
	}

	/* 科目情報を取得処理 */
	public function getSubjectInfo($org_no, $subject_area_no){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		// 教科管理№でデータ取得
		return $dao-> getSubjectInfo($org_no, $subject_area_no);
	}

	/* 次の教科管理№取得 */
	public function getNextId(){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		return $dao-> getNext();
	}

	/* 教科情報を登録処理 */
	public function insertWithTran($list){
		// データベース接続
		$dao = new M_Subject_AreaDao($this->pdo);
		// 教科情報登録
		return $dao-> insertWithTranPdo($list , $this->pdo);
	}

	/* 科目リストを取得処理 */
	public function getSubjectList($org_no){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		return $dao-> getSubjectList($org_no);
	}

	/* 科目管理№を取得処理 */
	public function getSubjectNo($org_no, $Arrsubject){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		return $dao-> getSubjectNo($org_no, $Arrsubject);
	}

	/* 組織IDにより教科:科目情報を取得する */
	public function getSubjectAreaSubjectCsvData($org_no){
		// データベース接続
		$dao = new M_Subject_AreaDao();
		return $dao->getSubjectAreaSubjectCsvData($org_no);
	}

}
?>