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
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';
require_once 'service/TestService.php';
require_once 'dto/T_Test_QuizDto.php';
require_once 'dto/T_TestDto.php';
/**
 * テスト一覧コントローラー
 */
class TestListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

			if ($this->check_login() == true){

				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column =1;
				$this->form->search_page_order_dir= true;

				$start_period = DateUtil::getPreviousDate('Y/m/d');
				$end_period = DateUtil::getNextDate('Y/m/d');

				$this->form->start_period= $start_period;
				$this->form->end_period= $end_period;
				$this->form->chk_status1 = "";
				$this->form->chk_status2 = "";
				$this->form->test_name = "";
				$this->form->remarks = "";
				$this->form->search_org_id = COMMON_TEST_INFO_ORG;
				$this->search($this->form);

				// メニュー情報を取得、セットする
				$this->setMenu();

				$this->smarty->assign('err_msg','');
				$this->smarty->assign('form',$this->form);
				$this->smarty->display ( 'testList.html' );

			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}

	private function search($form){

		if(empty($this->form->page)){
			$this->form->search_page = 0;
		}

		$service= new TestService($this->pdo);
		
		LogHelper::logDebug($this->form);
		$this->form->search_org_id = COMMON_TEST_INFO_ORG;

		// 検索結果を取得
		$list = $service->getTestListData($this->form , "0");
		$count = count($list);
		
		LogHelper::logDebug( "count of list :" . $count);

		if(count($list) > 0){

			$this->smarty->assign('err_msg','');
			$this->smarty->assign('list',$list);

		} else {
			// エラーメッセージを設定　「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign('list',"");
			$this->smarty->assign('err_msg',$err_msg);
		}
	}

	public function searchAction() {

		if ($_SESSION ['back_flg']){
			$this->form->search_page = $_SESSION ['search_page'];
			$this->form->search_page_row = $_SESSION ['search_page_row'];
			$this->form->search_page_order_column = $_SESSION ['search_page_order_column'];
			$this->form->search_page_order_dir = $_SESSION ['search_page_order_dir'];
			$this->form->start_period = $_SESSION ['search_start_period'];
			$this->form->end_period = $_SESSION ['search_end_period'];

			$this->form->test_name = $_SESSION ['search_test_name'];
			$this->form->remark = $_SESSION ['search_remark'];
			$this->form->rd_status1 = $_SESSION ['search_rd_status1'];
			$this->form->rd_status2 = $_SESSION ['search_rd_status2'];
			$this->form->rdstatus = $_SESSION ['search_rdstatus'];
			$this->form->chk_status1 = $_SESSION ['search_chk_status1'];
			$this->form->chk_status2 = $_SESSION ['search_chk_status2'];
			$this->form->status = $_SESSION ['search_status'];
			$this->form->search_org_id = $_SESSION ['search_org_id'];

			if(empty($this->form->start_period)) {
				$this->form->search_page = 0;
				$this->form->start_period= DateUtil::getPreviousDate('Y/m/d');
				$this->form->end_period= DateUtil::getNextDate('Y/m/d');
				
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column =1;
				$this->form->search_page_order_dir= true;
			}

			$_SESSION ['search_page'] = "";
			$_SESSION ['search_page_row'] = "";
			$_SESSION ['search_page_order_column'] = "";
			$_SESSION ['search_page_order_dir'] = "";
			$_SESSION ['search_start_period'] = "";
			$_SESSION ['search_end_period'] = "";
			$_SESSION ['search_test_name'] = "";
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

		if ($this->check_login() == true){

			if($this->form->rd_status1== "1"){
				$this->form->updater_id = $_SESSION['manager_no'];
			}else{
				$this->form->updater_id = "";
			}

			if(empty($this->form->page)){
				$this->form->page = 0;
			}

			$service= new TestService($this->pdo);
			$this->form->org_no= COMMON_TEST_INFO_ORG;
			
			LogHelper::logDebug($this->form);
			// メニュー情報を取得、セットする
			$this->setMenu();

			// 検索結果を取得
			$list = $service->getTestListData($this->form , "0");
			$count= count($list);

			if($count > 0){

				LogHelper::logDebug($list);
				$this->smarty->assign('list',$list);
				$this->smarty->assign ( 'err_msg', '');

			} else {
				// エラーメッセージを設定　「検索結果がありません」
				$err_msg = sprintf(W001);
				$this->smarty->assign('list',"");
				$this->smarty->assign('err_msg',$err_msg);
			}

			if (isset ( $_SESSION ['copy_msg'] ) && $_SESSION ['copy_msg'] != "") {
				$msg = $_SESSION ['copy_msg'];
				$this->smarty->assign ( 'err_msg', $msg  );
				unset ( $_SESSION ['copy_msg'] );
			}

			$this->smarty->assign('form',$this->form);
			$this->smarty->display('testList.html');
			return;

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}
}
?>