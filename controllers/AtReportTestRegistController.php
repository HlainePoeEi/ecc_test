<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';
require_once 'service/AtReportService.php';
require_once 'service/AtReportService.php';
require_once 'dto/T_At_Report_DetailDto.php';
/**
 * Atレポート試験設定コントローラー
 */
class AtReportTestRegistController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		
			if ($this->check_login () == true) {

				$this->setMenu();
				$service = new AtReportService ( $this->pdo );

				$org_no = $this->form->org_no;
				$org_id = $this->form->org_id;
				$at_report_no = $this->form->at_report_no;
				$at_report_name = $this->form->at_report_name;
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
				$this->smarty->display ( 'atReportTestRegist.html' );
				
			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}
	/*
	*
	* 検索処理
	*/
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
		
		$service = new AtReportService ( $this->pdo );
		
		// 検索結果を取得
		$list = $service->getTestInfoListData ( $this->form);
		$count = count($list);
		
		if ($count > 0) {
			$registerList = $service->getRegisteredTestList($this->form->org_no, $this->form->at_report_no);

			if(count($registerList) > 0){
				//get register quiz_no list
				foreach ($registerList as $value){
					array_push($registerTestList, $value->test_info_no);
				}
				
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
	
	/*
	*
	* 検索ボタン押下処理
	*/
	public function searchAction() {
			
		if ($this->check_login () == true) {
			if ($this->form->rd_status1 == "1") {
				$this->form->updater_id = $_SESSION['admin_no'];
			} else {
				$this->form->updater_id = "";
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
			$this->smarty->display ( 'atReportTestRegist.html' );
			return;
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}

	/*
	*
	* 保存処理
	*/
	public function saveAction() {
		if ($this->check_login () == true) {

			$org_no = $this->form->org_no;
			$at_report_no = $this->form->at_report_no;
			$test_info_no = $this->form->test_info_no;
			$display_no = 0;
			$error_msg = "";
			$service = new AtReportService ( $this->pdo );

			// 既に設定している試験を一旦削除
			$service-> deleteDataOnReport( $org_no, $at_report_no , AT_TYPE_TEST);
			$insertDataList = explode ( ',', $this->form->entryList );
			
			foreach ( $insertDataList as $insertData ) {
				
				if ($insertData != "") {
					$report_detail = new T_At_Report_DetailDto ();
					$report_detail->org_no = $org_no;
					$report_detail->at_report_no = $at_report_no;
					$report_detail->at_type = AT_TYPE_TEST;
					$report_detail->at_no = $insertData;
					$report_detail->disp_no = ++$display_no;
					$report_detail->del_flg = '0';
					$report_detail->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$report_detail->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$report_detail->creater_id = $_SESSION ['admin_no'];
					$report_detail->updater_id = $_SESSION ['admin_no'];

					$result = $service->insertReportDetail($report_detail);
					
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
			$this->smarty->display( 'atReportTestRegist.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	public function backAction() {
		//登録完了
		$this->setBackData();
		// Atレポート一覧画面へ遷移する
		$this->dispatch('AtReportList/Search');
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