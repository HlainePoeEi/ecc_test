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
class QuizAssignmentCheckboxController extends BaseController {
	/**
	* 初期処理
	*/
	public function indexAction() {

		if ($this->check_login() == true){

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->getTestData();
			$this->form->quiz_name = "";
			$this->form->remarks = "";
			$this->form->rd_status ='0';
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'quizAssignmentCheckbox.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}

	private function getTestData(){

		$test_no = $this->form->test_no;
		$this->form->btn_flg_type = $this->form->btn_flg_type;

		$service = new QuizService($this->pdo);
		$testList = $service->getTestData($this->form->org_no, $test_no);
		if( count($testList) > 0 ){
			foreach ($testList as $value){
				$this->form->test_name= $value->test_name;
				$this->form->end_period= $value->end_period;
				$this->form->test_no= $value->test_no;
				$this->form->test_type= $value->test_type;
				$this->form->start_period= $value->start_period;
			}
		}

	}

	private function search() {

		$err_msg = "";
		$entryList = "";
		$registerList = [];
		$registerQuizList = [];
		$exist_quiz_list = [];
		$nonexist_quiz_list = [];
		$resultList = [];

		$service = new QuizService($this->pdo);
		$quizList= $service->getSearchQuizList($this->form, '1');

		if(count($quizList) > 0){

			$this->getTestData();

			$registerList = $service->getRegisteredQuizList($this->form->org_no, $this->form->test_no);

			if(count($registerList) > 0){
				//get register quiz_no list
				foreach ($registerList as $value){
					array_push($registerQuizList, $value->quiz_no);
				}

				foreach ($quizList as $value){

					if(in_array($value->quiz_no,$registerQuizList)){
						array_push($exist_quiz_list, $value);
					}else {
						array_push($nonexist_quiz_list, $value);
					}
				}

				$resultList = array_merge($exist_quiz_list, $nonexist_quiz_list);

				if($this->form->entryList == ""){
					foreach ($registerQuizList as $value){
						$entryList .= $value. ",";
					}
					$this->form->entryList = $entryList;
				}else{

					$registerQuizList= explode ( ',', $this->form->entryList );

				}

			}else{
				$resultList = $quizList;
				$registerQuizList= explode ( ',', $this->form->entryList );
			}

		}else{

			$err_msg = W001;
		}

		$this->smarty->assign ( 'err_msg', $err_msg );
		$this->smarty->assign ('list', $resultList);
		$this->smarty->assign('data_list',$registerQuizList);
	}

	public function searchAction() {

		if ($this->check_login() == true){

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->search();

			$this->getTestData();

			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'quizAssignmentCheckbox.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}

	public function saveAction() {

		if ($this->check_login () == true) {

			$org_no = $this->form->org_no;
			$test_no = $this->form->test_no;
			$display_no = 0;
			$error_msg = "";

			$service = new QuizService ( $this->pdo );
			$count = $service->countExistingQuiz ( $org_no, $test_no);

			if ($count > 0) {
				// 削除処理
				$service-> deleteQuizOnTest( $org_no, $test_no);
			}

			$insertDataList = explode ( ',', $this->form->entryList );

			foreach ( $insertDataList as $insertData ) {

				if ($insertData != "") {
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
			$this->form->quiz_name ="";
			$this->form->remarks ="";
			$this->form->rd_status ='0';

			$this->search();

			$this->smarty->assign ( 'err_msg', $error_msg);
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'quizAssignmentCheckbox.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
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

	public function resetAction() {

		$this->getTestData();

		$this->form->entryList = "";
		$this->form->quiz_name = "";
		$this->form->remarks = "";
		$this->form->rd_status = "";
		$this->smarty->assign ( 'list',[] );
		$this->smarty->assign( 'form', $this->form );
		$this->smarty->display( 'quizAssignmentCheckbox.html' );
	
	}
}