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
require_once 'service/QuizService.php';
require_once 'dto/T_QuizDto.php';
require_once 'dto/M_TypeDto.php';
/**
 * クイズ一覧コントローラー
 */
class QuizListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

			if ($this->check_login() == true){

				$this->form->quiz_name = "";
				$this->form->quiz_content = "";
				$this->form->remark = "";
				
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column = 1;
				$this->form->search_page_order_dir = true;
				
				$this->form->org_no = "";
				$this->form->search_org_id = COMMON_TEST_INFO_ORG;

				$this->search($this->form);

				$this->smarty->assign('err_msg','');

				// メニュー情報を取得、セットする
				$this->setMenu();
				if(isset($_SESSION['regist_msg'])){
					if ($_SESSION ['regist_msg'] != ""){
						$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
						$_SESSION ['regist_msg'] = "";
					}
				}
				$this->smarty->assign('form',$this->form);
				$this->smarty->display ( 'quizList.html' );
				
			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}

	private function search($form){

		$service = new QuizService($this->pdo);

		// 検索結果を取得
		$list = $service->getQuizListData($form , "0");
		$count= count($list);

		if($count > 0){

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

		$err_msg = "";

		if ($_SESSION ['regist_msg'] != ""){
			$this->smarty->assign('err_msg',$_SESSION ['regist_msg']);
			$_SESSION ['regist_msg'] = "";
		}

		if ($_SESSION ['back_flg']){
			$this->form->search_page = $_SESSION ['search_page'];
			$this->form->search_page_row = $_SESSION ['search_page_row'];
			$this->form->search_page_order_column = $_SESSION ['search_page_order_column'];
			$this->form->search_page_order_dir = $_SESSION ['search_page_order_dir'];
			$this->form->quiz_name = $_SESSION ['search_quiz_name'];
			$this->form->quiz_content = $_SESSION ['search_quiz_content'];
			$this->form->remark = $_SESSION ['search_remark'];
			$this->form->rd_status1 = $_SESSION ['search_rd_status1'];
			$this->form->search_org_id = $_SESSION ['search_org_id'];
			
			if(empty($this->form->search_page)) {
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column = 1;
				$this->form->search_page_order_dir = true;
			}
			
			//クリア
			$_SESSION ['back_flg'] = false;
			$_SESSION ['search_page'] = "";
			$_SESSION ['search_quiz_name'] = "";
			$_SESSION ['search_quiz_content'] = "";
			$_SESSION ['search_remark'] = "";
			$_SESSION ['search_rd_status1'] = "";
			
			$_SESSION ['search_page'] = "";
			$_SESSION ['search_page_row'] = "";
			$_SESSION ['search_page_order_column'] = "";
			$_SESSION ['search_page_order_dir'] = "";
			$_SESSION ['search_org_id'] = "";
		}

		if ($this->check_login() == true){

			// 検索ボタン押下処理

			if($this->form->rd_status1 == "1"){
				$this->form->updater_id = $_SESSION['admin_no'];
			}else{
				$this->form->updater_id = "";
			}

			if(empty($this->form->page)){
				$this->form->page = 1;
			}

			$service= new QuizService($this->pdo);

			// メニュー情報を取得、セットする
			$this->setMenu();
			
			LogHelper::logDebug( "org id : " . $this->form->search_org_id);
			
			// 検索結果を取得
			$list = $service->getQuizListData($this->form , "0");
			$count= count($list);

			if($count > 0){
				$this->smarty->assign('list',$list);

			} else {
				// エラーメッセージを設定　「検索結果がありません」
				$err_msg = sprintf(W001);
				$this->smarty->assign('list',"");
				$this->smarty->assign('err_msg',$err_msg);
			}

			$this->smarty->assign('form',$this->form);
			$this->smarty->display('quizList.html');

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}
}
?>