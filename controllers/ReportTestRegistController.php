<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';
require_once 'service/ReportService.php';
require_once 'service/ReportService.php';
require_once 'dto/T_Report_Test_InfoDto.php';
/**
 * レポート試験設定コントローラー
 */
class ReportTestRegistController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		
			if ($this->check_login () == true) {

				$this->setMenu();
				$service = new ReportService ( $this->pdo );

				$org_no = $this->form->org_no;
				$org_id = $this->form->org_id;
				$report_no = $this->form->report_no;
				$report_name = $this->form->report_name;
				$screen_mode = $this->form->screen_mode;

				$this->form->search_page_til = 0;
				$this->form->search_page_row_til = 10;
				$this->form->search_page_order_column_til = 1;
				$this->form->search_page_order_dir_til = true;
				
				
				$start_period = DateUtil::getPreviousDate ( 'Y/m/d' );
				$end_period = DateUtil::getNextDate ( 'Y/m/d' );
				
				$this->form->start_period = $start_period;
				$this->form->end_period = $end_period;
				$this->form->test_info_name = "";
				$this->form->screen_mode = "new";
				$this->form->org_no = $org_no;
				
				$this->search ();
				
				// メニュー情報を取得、セットする
				$this->setMenu ();
				
				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->display ( 'reportTestRegist.html' );
				
			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}
	private function search() {
		$err_msg = "";
		$entryList = "";
		$registerList = [];
		$registerTestList = [];
		$exist_test_list = [];
		$nonexist_test_list = [];
		$resultList = [];
		if (empty ( $this->form->search_page_til )) {
			$this->form->search_page_til = 0;
		}
		
		$service = new ReportService ( $this->pdo );
		
		// 検索結果を取得
		$list = $service->getTestInfoListData ( $this->form, "0" );
		$count = count($list);
		
		if ($count > 0) {
			$registerList = $service->getRegisteredTestList($this->form->org_no, $this->form->report_no);

			if(count($registerList) > 0){
				//get register quiz_no list
				foreach ($registerList as $value){
					array_push($registerTestList, $value->test_info_no);
				}

				LogHelper::logDebug("registerTestList");
				LogHelper::logDebug($registerTestList);
				
				foreach ($list as $value){

					if(in_array($value->test_info_no,$registerTestList)){
						array_push($exist_test_list, $value);
					}else {
						array_push($nonexist_test_list, $value);
					}
				}
				
				$resultList = array_merge($exist_test_list, $nonexist_test_list);

				if($this->form->entryList == ""){
					foreach ($registerTestList as $value){
						$entryList .= $value. ",";
					}
					$this->form->entryList = $entryList;
				}else{

					$registerTestList= explode ( ',', $this->form->entryList );

				}

			}else{
				$resultList = $list;
				$registerTestList= explode ( ',', $this->form->entryList );
			}

			$this->smarty->assign ( 'err_msg', $err_msg );
			$this->smarty->assign ('list', $resultList);
			$this->smarty->assign('data_list',$registerTestList);

		} else {
			// エラーメッセージを設定 「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign ( 'list', "" );
			$this->smarty->assign('data_list', "");
			$this->smarty->assign ( 'err_msg', $err_msg );

		}

	}
	public function searchAction() {
			
		if (isset ( $_SESSION ['back_flg'] ) && ($_SESSION ['back_flg'])) {
			$this->form->search_page_til = $_SESSION ['search_page_til'];
			$this->form->search_page_row_til = $_SESSION ['search_page_row_til'];
			$this->form->search_page_order_column_til = $_SESSION ['search_page_order_column_til'];
			$this->form->search_page_order_dir_til = $_SESSION ['search_page_order_dir_til'];
			$this->form->search_org_id = $_SESSION ['search_org_id'];
			$this->form->start_period = $_SESSION ['search_start_period'];
			$this->form->end_period = $_SESSION ['search_end_period'];
			$this->form->test_info_name = $_SESSION ['search_test_info_name'];
			$this->form->remark = $_SESSION ['search_remark'];
			$this->form->rd_status1 = $_SESSION ['search_rd_status1'];
			$this->form->rd_status2 = $_SESSION ['search_rd_status2'];
			$this->form->rdstatus = $_SESSION ['search_rdstatus'];
			$this->form->chk_status1 = $_SESSION ['search_chk_status1'];
			$this->form->chk_status2 = $_SESSION ['search_chk_status2'];
			$this->form->status = $_SESSION ['search_status'];
			
			if (empty ( $this->form->start_period )) {
				$this->form->start_period = DateUtil::getPreviousDate ( 'Y/m/d' );
				$this->form->end_period = DateUtil::getNextDate ( 'Y/m/d' );
				
				$this->form->search_page_til = 0;
				$this->form->search_page_row_til = 10;
				$this->form->search_page_order_column_til = 1;
				$this->form->search_page_order_dir_til = true;
			}
			
			$_SESSION ['search_page_til'] = "";
			$_SESSION ['search_page_row_til'] = "";
			$_SESSION ['search_page_order_column_til'] = "";
			$_SESSION ['search_page_order_dir_til'] = "";
			$_SESSION ['search_start_period'] = "";
			$_SESSION ['search_end_period'] = "";
			$_SESSION ['search_test_info_name'] = "";
			$_SESSION ['search_remark'] = "";
			$_SESSION ['search_rd_status1'] = "";
			$_SESSION ['search_rd_status2'] = "";
			$_SESSION ['search_rdstatus'] = "";
			$_SESSION ['search_chk_status1'] = "";
			$_SESSION ['search_chk_status2'] = "";
			$_SESSION ['search_status'] = "";
			$_SESSION ['search_org_id'] = "";
			$_SESSION ['back_flg'] = false;
		}
		
		if ($this->check_login () == true) {
			if ($this->form->rd_status1 == "1") {
				$this->form->updater_id = $_SESSION['admin_no'];
			} else {
				$this->form->updater_id = "";
			}
			
			if (empty ( $this->form->page )) {
				$this->form->page = 1;
			}
			$this->search ( $this->form );
			
			if (isset ( $_SESSION ['copy_msg'] ) && $_SESSION ['copy_msg'] != "") {
				$msg = $_SESSION ['copy_msg'];
				$this->smarty->assign ( 'err_msg', $msg  );
				unset ( $_SESSION ['copy_msg'] );
			}
			
			// メニュー情報を取得、セットする
			$this->setMenu ();
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'reportTestRegist.html' );
			return;
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}

	public function saveAction() {
		if ($this->check_login () == true) {

			$org_no = $this->form->org_no;
			$report_no = $this->form->report_no;
			$test_info_no = $this->form->test_info_no;
			$display_no = 0;
			$error_msg = "";
			$service = new ReportService ( $this->pdo );
			$count = $service->countExisting( $org_no, $report_no);
			if ($count > 0) {
				// 削除処理
				$service-> deleteTestOnReport( $org_no, $report_no);
				
			}
			$insertDataList = explode ( ',', $this->form->entryList );
			
			foreach ( $insertDataList as $insertData ) {
				if ($insertData != "") {
					$t_report_test_info = new T_Report_Test_InfoDto ();
					$t_report_test_info->org_no = $org_no;
					$t_report_test_info->report_no = $report_no;
					$t_report_test_info->test_info_no = $insertData;
					$t_report_test_info->disp_no = ++$display_no;
					$t_report_test_info->del_flg = '0';
					$t_report_test_info->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$t_report_test_info->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$t_report_test_info->creater_id = $_SESSION ['admin_no'];
					$t_report_test_info->updater_id = $_SESSION ['admin_no'];
				
					$result = $service->addTestDataOnReport($t_report_test_info);
					
					if ($result == 0){

						$error_msg = sprintf( E007, '更新' );
						$this->smarty->assign ( 'err_msg', $error_msg);
						return;
					}
				}
			}
			if($error_msg == ""){
				$error_msg = sprintf( I004, '更新' );
			}
			$this->search();
			$this->smarty->assign ( 'err_msg', $error_msg);
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'reportTestRegist.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function backAction() {
		//登録完了
		$this->setBackData();
		// レポート一覧画面へ遷移する
		$this->dispatch('ReportList/Search');
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