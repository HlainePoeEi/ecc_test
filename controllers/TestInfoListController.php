<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';
require_once 'service/TestInfoService.php';
require_once 'dto/T_Test_InfoDto.php';
/**
 * テスト情報一覧コントローラー
 */
class TestInfoListController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		
			if ($this->check_login () == true) {
				
				$this->form->search_page_til = 0;
				$this->form->search_page_row_til = 10;
				$this->form->search_page_order_column_til = 1;
				$this->form->search_page_order_dir_til = true;

				
				$start_period = DateUtil::getPreviousDate ( 'Y/m/d' );
				$end_period = DateUtil::getNextDate ( 'Y/m/d' );
				
				$this->form->start_period = $start_period;
				$this->form->end_period = $end_period;
				$this->form->chk_status1 = "";
				$this->form->chk_status2 = "";
				$this->form->test_info_name = "";
				$this->form->remarks = "";
				$this->form->org_no = COMMON_TEST_INFO_ORG;
				$this->form->search_org_id = COMMON_TEST_INFO_ORG;
				$this->search ( $this->form );
				
				// メニュー情報を取得、セットする
				$this->setMenu ();
				
				$this->smarty->assign ( 'err_msg', '' );
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->display ( 'testInfoList.html' );
			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}
	private function search($form) {
		if (empty ( $this->form->search_page_til )) {
			$this->form->search_page_til = 0;
		}
		
		$service = new TestInfoService ( $this->pdo );
		
		// 検索結果を取得
		$list = $service->getTestInfoListData ( $this->form, "0" );
		$count = count($list);
		
		LogHelper::logDebug("test List count:" . $count);
		
		if ($count > 0) {
			$this->smarty->assign ( 'err_msg', '' );
			$this->smarty->assign ( 'list', $list );
		} else {
			// エラーメッセージを設定 「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign ( 'list', "" );
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
			LogHelper::logDebug("org_id" . $this->form->search_org_id);
			$this->search ( $this->form );
			
			if (isset ( $_SESSION ['copy_msg'] ) && $_SESSION ['copy_msg'] != "") {
				$msg = $_SESSION ['copy_msg'];
				$this->smarty->assign ( 'err_msg', $msg  );
				unset ( $_SESSION ['copy_msg'] );
			}
			
			// メニュー情報を取得、セットする
			$this->setMenu ();
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'testInfoList.html' );
			return;
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}
}
?>