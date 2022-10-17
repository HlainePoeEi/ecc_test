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
require_once 'service/WordBookService.php';
/**
 * 単語帳一覧コントローラー
 * 
 */
class WordBookListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {
			if ( $this->check_login() == true ){
				$err_msg = "";
				if(isset($_SESSION['regist_msg'])){
					if ($_SESSION ['regist_msg'] != ""){
						$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
						$_SESSION ['regist_msg'] = "";
					}
				}
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column =1;
				$this->form->search_page_order_dir= true;
				$this->form->name = "";
				$this->form->org_id = "";
				$this->form->org_no = "";
				$service= new WordBookService($this->pdo);
				// メニュー情報を取得、セットする
				$this->setMenu();
				$this->search($this->form);
				$this->smarty->assign('form',$this->form);
				$this->smarty->display ( 'wordBookList.html' );
			}else{
				TransitionHelper::sendException( E002 );
				return;
			}
	}

	/**
	 * リスト処理
	 */
    private function search($form){		
		$service= new WordBookService($this->pdo);
		// 検索結果を取得
		$list = $service->getWordBookListData($this->form , "0");
		$count= count($list);
		if($count > 0){
			$this->smarty->assign('err_msg','');
			$this->smarty->assign('list',$list);
		} else {
			// エラーメッセージを設定　「検索条件に該当するデータが存在しません。」
			$err_msg = W001;
			$this->smarty->assign('list',"");
			$this->smarty->assign('err_msg',$err_msg);
		}
	}

	/**
	 * 検索処理
	 */
	public function searchAction() {
		$err_msg = "";
		if(isset($_SESSION['regist_msg'])){
			if ($_SESSION ['regist_msg'] != ""){
				$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
				$_SESSION ['regist_msg'] = "";
			}
		}
		if ( isset( $_SESSION ['back_flg']) && ($_SESSION ['back_flg'] != "") ){
			$this->form->search_page = $_SESSION ['search_page'];
			$this->form->search_page_row = $_SESSION ['search_page_row'];
			$this->form->search_page_order_column = $_SESSION ['search_page_order_column'];
			$this->form->search_page_order_dir = $_SESSION ['search_page_order_dir'];
			$this->form->search_name = $_SESSION ['search_name'];
			$this->form->search_org_id = $_SESSION ['search_org_id'];
			if(empty($this->form->search_page)) {
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column = 1;
				$this->form->search_page_order_dir = true;
			}
			$_SESSION ['search_page'] = "";
			$_SESSION ['search_page_row'] = "";
			$_SESSION ['search_page_order_column'] = "";
			$_SESSION ['search_page_order_dir'] = "";
			$_SESSION ['search_name'] = "";
			$_SESSION ['search_org_id'] = "";
			$_SESSION ['back_flg'] = false;
		}
		if ($this->check_login() == true){
			$service= new WordBookService($this->pdo);
			// メニュー情報を取得、セットする
			$this->setMenu();
			// 検索結果を取得
			$list = $service->getWordBookListData($this->form , "0");
			$count= count($list);
			if($count > 0){
				$this->smarty->assign('list',$list);
				$this->smarty->assign ('err_msg','');
			} else {
				// エラーメッセージを設定　「検索条件に該当するデータが存在しません。」
				$err_msg = sprintf(W001);
				$this->smarty->assign('list',"");
				$this->smarty->assign('err_msg',$err_msg);
			}
			$this->smarty->assign('form',$this->form);
			$this->smarty->display('wordBookList.html');
			return;
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}
?>