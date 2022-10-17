<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';
require_once 'dto/PageDto.php';
require_once 'dto/T_ReportDto.php';
require_once 'dao/T_ReportDao.php';
require_once 'service/ReportService.php';
//excell関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * レポート登録コントローラー
 */
class ReportRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {
		if ( $this->check_login () == true ) {
	
			if(isset($_SESSION['regist_msg'])){
				if ($_SESSION ['regist_msg'] != ""){
					$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
					$_SESSION ['regist_msg'] = "";
				}
			}
			
			$service = new ReportService($this->pdo);
			$screen_mode = $this->form->screen_mode;
			$org_no = $this->form->org_no;
			$report_no = $this->form->report_no;
			$screen_mode = $this->form->screen_mode;
			$this->smarty->assign ( 'info_msg',"");
			$date_flg = 0;
			
			$err_msg = "";
			if ( $screen_mode == 'update' ){
				if (! empty($report_no) ){
					// 検索結果を取得
					$list = $service->getReportInfo($org_no, $report_no);
					$today_date = DateUtil::getDate('Y/m/d');
					if ( $list != null && count($list) == 1){
						$this->form->test_info_no = $list[0]->test_info_no;
						$this->form->test_info_name = $list[0]->test_info_name;
						$this->form->org_no = $list[0]->org_no;
						$this->form->org_id = $list[0]->org_id;
						$this->form->org_name_official = $list[0]->org_name_official;
						$this->form->org_name = $list[0]->org_name;
						$this->form->show_flg = $list[0]->show_flg;
						$this->form->file_name = $list[0]->file_name;
						$this->form->report_no = $report_no;
						$this->form->report_name = $list[0]->report_name;
					}
				}else {
					TransitionHelper::sendException ( E002 );
					return;
				}
			}else {
				// 登録
				$this->form->screen_mode = "new";
				$service= new ReportService($this->pdo);
				$next_report_no = $service->getNextId();
				$this->form->report_no =  $next_report_no ->id;
				$this->form->org_id =  "";
				$this->form->report_name =  "";
				$this->form->file_name = "";
			}
			$this->setMenu();
			$this->smarty->assign('form', $this->form);
			$this->smarty->assign('screen_mode', $this->form->screen_mode);
			$this->smarty->display('reportRegist.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function orgShowAction(){
		
		if ( $this->check_login() == true ){

			$service = new ReportService($this->pdo);
			$org_id = $this->form->org_id;
			$result = $service->getOrgName($org_id);
			if ( count($result) > 1 ){
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E016 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else if ( count($result) == 0 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E015 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else {

				$reportOrgDto = new T_ReportDto();
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign ( 'org_name', $result[0]->org_name);
				$this->form->org_name = $result[0]->org_name;
				$this->form->org_name_official = $result[0]->org_name_official;
				$this->form->org_no = $result[0]->org_no;
				$this->form->org_id =  $result[0]-> org_id;
				$this->displayValue($this->form);
			
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	public function displayValue($myForm) {

		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'reportRegist.html' );
	}

	public function saveAction() {

		$this->setMenu();

		// 登録ボタン押下処理
		if ( isset ( $_POST ['insert'] ) ) {

			// メニューが開くかどうかを確認する
			$admin_id = $_SESSION ['login_id'];

			$screen_mode = $this->form->screen_mode;
			$org_id = $this->form->org_id;
			$report_no = $this->form->report_no;
			$report_name = $this->form->report_name;
			$show_flg = $this->form->show_flg;
			$file_ext = $this->form->image_ext;
			$service = new ReportService($this->pdo);
			$result = $service->getOrgName($org_id);
			if ( count($result) > 1 || count($result) == 0 ){
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'error_msg', E017 );
				$this->displayValue($this->form);
			}else {
				$org_no = $result[0]->org_no;
				$org_name = $result[0]->org_name;
				$org_name_official = $result[0]->org_name_official;
				// レポートデータ情報登録
				$report_dto = new T_ReportDto();
				$report_dto->org_no = $org_no;
				$report_dto->report_no = $report_no;
				$report_dto->report_name = $this->form->report_name;
				$report_dto->show_flg = $show_flg; 
				$report_dto->updater_id = $_SESSION['admin_no'];
				$report_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				$report_dto->report_no = $this->form->report_no;
				
				$file_chk_del= $this->form->file_chk_del;

				// 更新状況
				if ( $screen_mode == 'update' ){
					if (!empty($report_no)){
						$filedir = ADMIN_FILE_DIR.$org_no."/Report";
						$template_name = "ReportNo_".$report_no.$file_ext;

						if ( !empty($this->form->input_file) ) {
							$report_dto->file_name = $template_name; 
							$service->deleteFile($template_name,$filedir);
							$service->uploadFile($this->form->file_data, $filedir, $template_name);
						} 
						if($this->form->file_chk_del == "1"){
							$report_dto->file_name = " ";
							$service->deleteFile($template_name,$filedir);
						}
					}
					$service= new ReportService($this->pdo);
					$result = $service->updateReportInfo($report_dto);
					
					// 更新処理が正常の場合、
					if ( $result == 1 ){

						$msg = sprintf(I004);
						$this->smarty->assign ( 'info_msg', $msg );
						$this->form->screen_mode = 'update' ;
						$this->smarty->assign('screen_mode', $screen_mode);
						$this->form->org_name = $org_name ;
						$this->form->org_no = $org_no ;
						$this->form->org_name_official = $org_name_official;
						$this->smarty->assign('org_name', $org_name);
						$this->smarty->assign('org_name_official', $org_name_official);
						$this->smarty->assign('org_no', $org_no);
						// メニュー情報を取得、セットする
						$this->setMenu();
						$this->smarty->assign('form',$this->form);
						$this->smarty->display ( 'reportRegist.html' );
				
						// 更新出来ない場合、
					} else {
						$error = sprintf(E007,'更新');
						$this->smarty->assign ( 'msg', $error );
						$this->smarty->assign('form', $this->form);
						$this->smarty->display ( 'reportRegist.html' );
					}
					// 登録状況
				} else if ( $screen_mode == 'new' ){

					$report_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$report_dto->creater_id =  $_SESSION['admin_no'];
					$report_dto->file_name ='ReportNo_'.$report_no.$file_ext;
					$report_dto->str_sql = ' ';
					$this->form->report_no = $report_dto->report_no;
					
					//エクセルファイルディレクトリ
					$filedir = ADMIN_FILE_DIR. $org_no."/Report";
					$template_name = "ReportNo_".$report_no.$file_ext;

					if ( !empty($this->form->input_file) ) {
						$file_name = $this->form->file_name;
						$service->uploadFile($this->form->file_data, $filedir, $template_name);
					}
					$result = $service->insertData($report_dto);
					
					// 登録処理が正常の場合、
					if ( $result == 1 ){

						$this->smarty->assign ( 'info_msg',I004);
						$this->smarty->assign ( 'error_msg', "");
						$this->form->screen_mode = 'update' ;
						$this->smarty->assign('screen_mode', $screen_mode);
						$this->form->org_name = $org_name ;
						$this->form->org_no = $org_no ;
						$this->form->org_name_official = $org_name_official;
						$this->smarty->assign('org_name', $org_name);
						$this->smarty->assign('org_name_official', $org_name_official);
						$this->smarty->assign('org_no', $org_no);
					
						// メニュー情報を取得、セットする
						$this->setMenu();
						$this->smarty->assign('form',$this->form);
						$this->smarty->display ( 'reportRegist.html' );
						// 登録出来ない場合
					} else {
						$error = sprintf(E007,'登録');
						$this->smarty->assign ( 'msg', $error );
						$this->smarty->assign('form',$this->form);
						$this->smarty->display ( 'reportRegist.html' );
						return;
					}
				}
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	
	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		if ($this->check_login() == true) {
			//登録完了
			$this->setBackData();
			// レポート一覧画面へ遷移する
			$this->dispatch('ReportList/Search');
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;
		$_SESSION ['search_test_info_name'] = $this->form->search_test_info_name;
		$_SESSION ['search_report_name'] = $this->form->search_report_name;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
	}
}
?>