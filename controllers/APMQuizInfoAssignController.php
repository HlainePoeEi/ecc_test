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
require_once 'dao/T_YNS_Exam_QuizDao.php';
require_once 'service/APMQuizInfoAssignService.php';
require_once 'dto/T_Quiz_InfoDto.php';
require_once 'dto/T_Test_Info_QuizDto.php';
require_once 'util/DateUtil.php';


/**
 * テスト・クイズ割当コントローラー
 */
class APMQuizInfoAssignController extends BaseController {
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
			$this->smarty->display ( 'APMQuizInfoAssign.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}

	}

	private function getTestData(){

		$exam_id = $this->form->exam_id;
		LogHelper::logDebug("org :" . $this->form->org_no);
		//$this->form->btn_flg_type = $this->form->btn_flg_type;

		$service = new APMQuizInfoAssignService($this->pdo);
		$examList = $service->getTestData($this->form->org_no, $exam_id);
		if( count($examList) > 0 ){
			foreach ($examList as $value){
				$this->form->exam_name= $value->name;
				$this->form->end_date= $value->end_date;
				$this->form->exam_id= $value->exam_id;
				$this->form->start_date= $value->start_date;
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

		$service = new APMQuizInfoAssignService($this->pdo);
		$quizList= $service->getSearchQuizList($this->form);

		if(count($quizList) > 0){

			$this->getTestData();

			$registerList = $service->getRegisteredQuizList( $this->form->exam_id);

			if(count($registerList) > 0){
				//get register quiz_info_no list
				foreach ($registerList as $value){
					array_push($registerQuizList, $value->quiz_id);
				}

				foreach ($quizList as $value){

					if(in_array($value->quiz_id,$registerQuizList)){
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

		if($this->form->rd_status == 0)
			$this->smarty->assign ('list', $resultList);
		elseif($this->form->rd_status == 1)
			$this->smarty->assign ('list', $exist_quiz_list);

		$this->smarty->assign('data_list',$registerQuizList);
	}

	public function searchAction() {

		if ($this->check_login() == true){

			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->search();
			$this->getTestData();

			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display( 'APMQuizInfoAssign.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
		
	}

	public function saveAction() {

		if ($this->check_login () == true) {

			$org_no = $this->form->org_no;
			$exam_id = $this->form->exam_id;
			$display_no = 0;
			$error_msg = "";

			$service = new APMQuizInfoAssignService( $this->pdo );
			$count = $service->countExistingQuiz ($exam_id);

			if ($count > 0) {
				// 削除処理
				$service-> deleteQuizOnTest($exam_id);
			}

			$insertDataList = explode ( ',', $this->form->entryList );

			foreach ( $insertDataList as $insertData ) {

				if ($insertData != "") {
					$t_yns_exam_quizDto = new T_YNS_Exam_QuizDto ();
					$t_yns_exam_quizDto->exam_id = $exam_id;
					$t_yns_exam_quizDto->quiz_id = $insertData;
					
					// $test_Info_quizDto->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
					// $test_Info_quizDto->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
					// $test_Info_quizDto->creater_id = $_SESSION ['manager_no'];
					// $test_Info_quizDto->updater_id = $_SESSION ['manager_no'];

					$result = $service->addQuizDataOnTest ( $t_yns_exam_quizDto );
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
			$this->smarty->display( 'APMQuizInfoAssign.html' );
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
		$this->dispatch('YNSExamList/Search');

	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {

		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_test_info_name'] = $this->form->search_test_info_name;
		$_SESSION ['search_remark'] = $this->form->search_remark;
		$_SESSION ['search_rd_status1'] = $this->form->search_rd_status1;
		$_SESSION ['search_rd_status2'] = $this->form->search_rd_status2;
		$_SESSION ['search_rdstatus'] = $this->form->search_rdstatus;
		$_SESSION ['search_chk_status1'] = $this->form->search_chk_status1;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION ['search_status'] = $this->form->search_status;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
		
		$_SESSION ['search_page_til'] = $this->form->search_page_til;
		$_SESSION ['search_page_row_til'] = $this->form->search_page_row_til;
		$_SESSION ['search_page_order_column_til'] = $this->form->search_page_order_column_til ;
		$_SESSION ['search_page_order_dir_til'] = $this->form->search_page_order_dir_til ;

	}

	public function resetAction() {

		$this->getTestData();

		$this->form->entryList = "";
		$this->form->quiz_name = "";
		$this->form->remarks = "";
		$this->form->rd_status = "";
		$this->smarty->assign ( 'list',[] );
		$this->smarty->assign( 'form', $this->form );
		$this->smarty->display( 'APMQuizInfoAssign.html' );
	
	}

}