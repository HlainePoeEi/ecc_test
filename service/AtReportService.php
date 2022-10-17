<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_At_ReportDao.php';
require_once 'dao/T_ReportTestAssignmentDao.php';
require_once 'dto/T_At_ReportDto.php';
require_once 'service/BaseService.php';

class AtReportService extends BaseService{

	public function getReportList($form){
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao-> getReportList($form);
	}

	public function getOrgName($org_id) {
		// データベース接続
		$dao = new T_At_ReportDao();
		// ユーザ名とパスワード取得
		return $dao->getOrgName($org_id);
	}

    public function getReportResultCount($form){
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao-> getReportResultCount($form);
	}
	
	 public function getReportData($org_no, $at_report_no){
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao-> getReportData($org_no, $at_report_no);
	} 

	public function getReportInfo($org_no, $at_report_no){
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao-> getReportInfo($org_no, $at_report_no);
	}

	public function insertReportDetail($dto) {
		// データベース接続
		$dao = new T_At_ReportDao ( $this->pdo );
		return $dao->insert ( $dto );
	}

	/**
	 * 新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($param){
		// データベース接続
		$dao = new T_At_ReportDao($this->pdo);
		return $dao->insert ( $param );
	}

	public function getNextId(){
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao-> getNextId();
	}

	public function updateReportInfo($dto){
		$itemDao = new T_At_ReportDao();
		return $itemDao->updateReportInfo($dto);
	}

	public function checkedExistReportInfo($org_no, $at_report_no){
		// データベース接続
		$itemDao = new T_At_ReportDao();
		return $itemDao->checkedExistReportInfo($org_no, $at_report_no);
	}
	
	public function deleteDataOnReport($org_no, $at_report_no , $type) {
		// データベース接続
		$dao = new T_At_ReportDao ($this->pdo);
		return $dao->deleteDataOnReport ( $org_no, $at_report_no , $type , $this->pdo);
	}

	public function uploadFile($file_data, $filedir, $csv){
		// 保存先フォルダ存在チェック
		
		if (! is_dir ( $filedir )) {
			$res = mkdir ( $filedir, 0777 ,true);
		}
		$fileData = substr($file_data, strpos($file_data, ",") + 1);
		// デコード
		$decodedData = base64_decode ( $fileData );
		// 保存ファイル名
		$filename = $csv ;
		$filePath = $filedir .'/'.$filename;
		
		// ファイル書き込み
		$fp = fopen ( $filePath, 'wb');
		fwrite ( $fp, $decodedData );
		fclose ( $fp );
	} 

	//ファイルを削除する
	public function deleteFile($name,$file_dir) {
		if (! is_dir ( $file_dir )) {
			$flg = true;
		}else{
			$flg = false;
		}
	
		if($flg == 'true'){
			return;
		}
	
		//フォルダのファイルを削除する
		$file_data = $file_dir .'/'. $name;
		
		if (file_exists($file_data)) {
			unlink($file_data);
		}
	}

	public function getTestInfoListData($form) {
		// データベース接続
		$dao = new T_At_ReportDao ();
		return $dao->getTestInfoListData ( $form );
	}

	public function getRegisteredTestList($org_no, $at_report_no) {
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao->getRegisteredTestList($org_no, $at_report_no);
	}
	
	public function getCourseListData($form) {
		// データベース接続
		$dao = new T_At_ReportDao ();
		return $dao->getCourseListData ( $form );
	}
	
	public function getRegisteredCourseList($org_no, $at_report_no, $start , $end) {
		// データベース接続
		$dao = new T_At_ReportDao();
		return $dao->getRegisteredCourseList($org_no, $at_report_no, $start, $end);
	}
	
	public function getAtReportDisplayList($org_no, $at_report_no) {
		// データベース接続
		$dao = new T_At_ReportDao ();
		return $dao->getAtReportDisplayList ($org_no, $at_report_no);
	}

	public function deleteDataOnAtReport($org_no, $at_report_no) {
		// データベース接続
		$dao = new T_At_ReportDao ($this->pdo);
		return $dao->deleteDataOnAtReport ($org_no, $at_report_no , $this->pdo);
	}
}

?>