<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/AdminService.php';
require_once 'util/DateUtil.php';

/**
 * 運用管理者一覧コントローラー
 */
class AdminListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ($this->check_login() == true){

			LogHelper::logDebug("indexAction");

			$this->form->page = 1;

			$this->form->start_period = DateUtil::getDateAddMonth(-1,'Y/m/d');
			$this->form->end_period= DateUtil::getDateAddMonth(1,'Y/m/d');
			$this->form->admin_name = "";

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->search($this->form);

			if (isset($_SESSION ['regist_msg_admin'])){
				$this->smarty->assign('err_msg',$_SESSION ['regist_msg_admin']);
				$_SESSION ['regist_msg_admin'] = "";
			}

			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'adminList.html' );

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 検索処理
	 */
	private function search($form){

		if(empty($this->form->page)){
			$this->form->page = 1;
		}

		$service= new AdminService($this->pdo);

		// 検索結果を取得
		$countlist　= $service->getAdminListData($this->form , "0");

		$count = sizeof($countlist　);

		LogHelper::logDebug($countlist);

		if($count > 0){

			$this->form->max_page = ceil($count/ PAGE_ROW);
			$list = $service->getAdminListData($this->form , "1");
			$this->smarty->assign('list',$list);
			$this->smarty->assign('form',$this->form);

		} else {
			// エラーメッセージを設定　「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign('err_msg',$err_msg);
		}
	}

	/**
	 * 検索ボタン押下処理
	 */
	 public function searchAction() {

	 	if ($this->check_login() == true){

	 		$manager_name = $this->form->manager_name;

	 		if(empty($this->form->page)){
	 			$this->form->page = 1;
	 		}

	 		// メニュー情報を取得、セットする
	 		$this->setMenu();

			//他の画面から戻った場合、検索条件リセット処理
			$this->resetBackParam();

			$this->search($this->form);

	 		$this->smarty->assign('form',$this->form);
	 		$this->smarty->display('adminList.html');
	 		return;

	 	} else {
	 		TransitionHelper::sendException ( E002 );
	 		return;
	 	}
	}

	/**
	 * 他の画面から戻った場合、検索条件リセット処理
	 */
	public function resetBackParam(){

		if ($_SESSION ['back_flg']){
			$this->form->page = $_SESSION ['search_page'];
			$this->form->admin_name = $_SESSION ['search_admin_name'];
			$this->form->start_period = $_SESSION ['search_start_period'];
			$this->form->end_period = $_SESSION ['search_end_period'];

			//クリア
			$_SESSION ['back_flg'] = false;
			$_SESSION ['search_page'] = "";
			$_SESSION ['search_start_period'] = "";
			$_SESSION ['search_end_period'] = "";
			$_SESSION ['search_admin_name'] = "";
		}
	}
}

?>