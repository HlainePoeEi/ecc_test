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
require_once 'dto/T_At_ReportDto.php';
require_once 'dao/T_At_ReportDao.php'; 
require_once 'service/AtReportService.php';

//excel関係
require 'vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx as XlsxReader;

/**
 * Atレポート登録コントローラー
 */
class AtReportRegistController extends BaseController {

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
			
			$service = new AtReportService($this->pdo);
			$screen_mode = $this->form->screen_mode;
			$org_no = $this->form->org_no;
			$at_report_no = $this->form->at_report_no;
			$screen_mode = $this->form->screen_mode;
			$this->smarty->assign ( 'info_msg',"");
			$date_flg = 0;
			
			$this->form->test_info_no1 = "";
			$this->form->test_info_no2 = "";
			
			$err_msg = "";
			if ( $screen_mode == 'update' ){
				if (! empty($at_report_no) ){
					// 検索結果を取得
					$list = $service->getReportInfo($org_no, $at_report_no);
					$today_date = DateUtil::getDate('Y/m/d');
					if ( $list != null && count($list) == 1){
						$this->form->test_info_no = $list[0]->test_info_no;
						$this->form->test_info_name = $list[0]->test_info_name;
						$this->form->org_no = $list[0]->org_no;
						$this->form->org_id = $list[0]->org_id;
						$this->form->org_name_official = $list[0]->org_name_official;
						$this->form->org_name = $list[0]->org_name;
						$this->form->show_flg = $list[0]->show_flg;
						$this->form->preview_flg = $list[0]->preview_flg;
						$this->form->file_name = $list[0]->file_name;
						$this->form->at_report_no = $at_report_no;
						$this->form->at_report_name = $list[0]->at_report_name;
						$this->form->status = $list[0]->status;
						$this->form->start_period = $list[0]->start_period;
						$this->form->end_period = $list[0]->end_period;
						$this->form->result_start_period = $list[0]->result_start_period;
						$this->form->result_end_period = $list[0]->result_end_period;
						
						$dataList = $service->getAtReportDisplayList($org_no, $at_report_no);
						
						LogHelper::logDebug($dataList);
						
						if(count($dataList) == 4 ){
							if ($dataList[1]->at_type == "001"){
								$this->form->test_info_no1 = $dataList[1]->at_no;
							}
							
							if ($dataList[2]->at_type == "001"){
								$this->form->test_info_no2 = $dataList[2]->at_no;
							}
							
						} 
					}
				}else {
					TransitionHelper::sendException ( E002 );
					return;
				}
			}else {
				// 登録
				$this->form->screen_mode = "new";
				$this->form->at_report_no =  "";
				$this->form->org_id =  "";
				$this->form->at_report_name =  "";
				$this->form->file_name = "";
			}
			$this->setMenu();
			$this->smarty->assign('form', $this->form);
			$this->smarty->assign('screen_mode', $this->form->screen_mode);
			$this->smarty->display('atReportRegist.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function orgShowAction(){
		
		if ( $this->check_login() == true ){

			$service = new AtReportService($this->pdo);
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

				$reportOrgDto = new T_At_ReportDto();
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
		$this->smarty->display( 'atReportRegist.html' );
	}

	public function saveAction() {

		$this->setMenu();

		// 登録ボタン押下処理
		if ( isset ( $_POST ['insert'] ) ) {

			// メニューが開くかどうかを確認する
			$admin_id = $_SESSION ['login_id'];

			$screen_mode = $this->form->screen_mode;
			$org_id = $this->form->org_id;
			$at_report_no = $this->form->at_report_no;
			$at_report_name = $this->form->at_report_name;
			$show_flg = $this->form->show_flg;
			$preview_flg = $this->form->preview_flg;
			$file_ext = $this->form->file_ext;
			$service = new AtReportService($this->pdo);
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
				$report_dto = new T_At_ReportDto();
				$report_dto->org_no = $org_no;
				$report_dto->at_report_no = $at_report_no;
				$report_dto->at_report_name = $this->form->at_report_name;
				$report_dto->status = $this->form->status;
				$report_dto->show_flg = $show_flg;
				$report_dto->preview_flg = $preview_flg;
				$report_dto->start_period = $this->form->start_period;
				$report_dto->end_period = $this->form->end_period;
				$report_dto->result_start_period = $this->form->result_start_period;
				$report_dto->result_end_period = $this->form->result_end_period;
				$report_dto->updater_id = $_SESSION['admin_no'];
				$report_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				$report_dto->at_report_no = $this->form->at_report_no;
				
				$file_chk_del= $this->form->file_chk_del;

				// 更新状況
				if ( $screen_mode == 'update' ){
					if (!empty($at_report_no)){
						$filedir = ADMIN_FILE_DIR.$org_no."/AT_Report";
						$template_name = "AT_ReportNo_".$at_report_no.$file_ext;

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
					$service= new AtReportService($this->pdo);
					$result = $service->updateReportInfo($report_dto);
					
					// 更新処理が正常の場合、
					if ( $result == 1 ){

						$msg = sprintf(I003 , '更新');
						$_SESSION['regist_msg'] = $msg;

						$this->backAction();
					} else {
						// 更新出来ない場合、
						$error = sprintf(E007,'更新');
						$this->smarty->assign ( 'msg', $error );
						$this->smarty->assign('form', $this->form);
						$this->smarty->display ( 'atReportRegist.html' );

					}
					// 登録状況
				} else if ( $screen_mode == 'new' ){
					
					// 新規レポート番号を取得
					$service= new AtReportService($this->pdo);
					$next_at_report_no = $service->getNextId();
					$this->form->at_report_no =  $next_at_report_no ->id;
					$report_dto->at_report_no = $this->form->at_report_no;
					$at_report_no = $report_dto->at_report_no;

					$report_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$report_dto->creater_id =  $_SESSION['admin_no'];
					$report_dto->file_name ='AT_ReportNo_'.$at_report_no.$file_ext;
					
					
					//エクセルファイルディレクトリ
					$filedir = ADMIN_FILE_DIR. $org_no."/AT_Report";
					$template_name = "AT_ReportNo_". $report_dto->at_report_no .$file_ext;

					if ( !empty($this->form->input_file) ) {
						$file_name = $this->form->file_name;
						$service->uploadFile($this->form->file_data, $filedir, $template_name);
					}
					$result = $service->insertData($report_dto);
					
					// 登録処理が正常の場合、
					if ( $result == 1 ){

						$_SESSION['regist_msg'] = I004;
						$this->backAction();
						
					} else {
						// 登録出来ない場合
					 	$error = sprintf(E007,'登録');
						$this->smarty->assign ( 'msg', $error );
						$this->smarty->assign('form',$this->form);
						$this->smarty->display( 'atReportRegist.html' ); 
						
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
			// ATレポート一覧画面へ遷移する
			$this->dispatch('AtReportList/Search');
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
		$_SESSION ['search_at_report_name'] = $this->form->search_at_report_name;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
	}
}
?>