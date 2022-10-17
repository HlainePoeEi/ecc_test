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
require_once 'dao/T_QuizAssignmentDao.php';
require_once 'service/QuizService.php';
require_once 'dto/T_QuizDto.php';
require_once 'dto/T_Test_QuizDto.php';
require_once 'dao/TypeDao.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';


/**
 * テスト・クイズ割当コントローラー
 */
class QuizAssignmentController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ($this->check_login() == true){

			$this->dataSearch("");
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	
	}

	private function search($form){

		if(empty($this->form->page)){
			$this->form->page = 1;
		}

		$service = new QuizService($this->pdo);

		//検索結果を取得
		$count= count($service->getQuizListOnTest($this->form));


		if($count > 0){

			$addlist = $service->getQuizListOnTest($this->form);
			LogHelper::logDebug(count($addlist));
			$this->smarty->assign('addlist',$addlist);
			$this->smarty->assign('list',NULL);

		} else {
			// エラーメッセージを設定　「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign('addlist',NULL);
			$this->smarty->assign('list',NULL);
			$this->smarty->assign('err_msg',$err_msg);
		}
	}
	public function saveAction() {

		if ($this->check_login () == true) {
			
			$org_no = $this->form->org_no;

			$service = new QuizService ( $this->pdo );

			if (isset ( $_SESSION ['login_id'] )) {
				$login_id = $_SESSION ['login_id'];
			}

			$test_no = $this->form->test_no;
			$count = $service->countExistingQuiz ( $org_no, $test_no);

			if ($count > 0) {
				// 削除処理
				$service-> deleteQuizOnTest( $org_no, $test_no);
			}
			$insertDataList = explode ( ',', $this->form->entryList );

			LogHelper::logDebug ( $insertDataList );

			$display_no = 0;
			foreach ( $insertDataList as $insertData ) {

				if ($insertData != null || $insertData != "") {

					$test_quizDto = new T_Test_QuizDto ();
					$test_quizDto->org_no = $org_no;
					$test_quizDto->test_no = $test_no;
					$test_quizDto->quiz_no = $insertData;
					$test_quizDto->disp_no = ++$display_no;
					$test_quizDto->del_flg = '0';
					$test_quizDto->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$test_quizDto->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$test_quizDto->creater_id = $_SESSION ['admin_no'];
					$test_quizDto->updater_id = $_SESSION ['admin_no'];

					$result = $service->addQuizDataOnTest ( $test_quizDto );
				}
			}
			LogHelper::logDebug ( "saveAction End Controller" );
			$this->dataSearch(I004);
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 登録した後、最新データを取得する処理
	 */
	public function dataSearch($err_msg) {

		$this->form= $this->form;

		 $this->form->page = 1;

		$test_no = $this->form->test_no;
		if($test_no != Null){
			if(isset($_SESSION['org_no'])){

				$service = new QuizService($this->pdo);
				$list = $service->getTestData($this->form->org_no, $test_no);

				if($list != null){
					foreach ($list as $value){

						$this->form->test_name= $value->test_name;
						$this->form->test_no= $value->test_no;
						$this->form->test_type= $value->test_type;

						$this->form->start_period= $value->start_period;
						$this->form->end_period= $value->end_period;
					}
				}
			}

			$this->search($this->form);

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->smarty->assign ( 'err_msg', $err_msg );
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'quizAssignment.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		logHelper::logDebug("Hello Hello btn_flg_type:".$this->form->btn_flg_type);
		//登録完了
		$this->setBackData();

		// 受講者一覧画面へ遷移する
		$this->dispatch('TestList/Search');
		
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_test_name'] = $this->form->search_test_name;
		$_SESSION ['search_remark'] = $this->form->search_remark;
		$_SESSION ['search_rd_status1'] = $this->form->search_rd_status1;
		$_SESSION ['search_rd_status2'] = $this->form->search_rd_status2;
		$_SESSION ['search_rdstatus'] = $this->form->search_rdstatus;
		$_SESSION ['search_chk_status1'] = $this->form->search_chk_status1;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION ['search_status'] = $this->form->search_status;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
	}
}

?>