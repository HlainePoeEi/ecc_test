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
 * テストプレビューコントローラー
 */
class TestPreviewController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		
			if ($this->check_login() == true){

				$test_no = $this->form->test_no;

				$this->search($this->form);

				// メニュー情報を取得、セットする
				$this->setMenu();
				
				$org_no = $this->form->org_no;

				$image_file = sprintf(F001, AUDIO_FILE,$org_no,'Quiz','image');
				$audio_file = sprintf(F001, AUDIO_FILE,$org_no,'Quiz','audio');
				
				$folder_check_dir = $_SERVER["DOCUMENT_ROOT"].ADMIN_HOME_DIR;
				
				LogHelper::logDebug($folder_check_dir);

				$this->smarty->assign('folder_check', $folder_check_dir);
				$this->smarty->assign('image_file',$image_file);
				$this->smarty->assign('audio_file',$audio_file);

				$this->smarty->assign('form',$this->form);
				$this->smarty->display ( 'testPreview.html' );

			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
	
	}

	private function search($form){

		$org_no = $this->form->org_no;
		$test_no = $this->form->test_no;

		$service= new TestService($this->pdo);

		// 検索結果を取得
		$result = $service->getListQuiz1( $org_no,$test_no);

		LogHelper::logDebug ("quiz list is " . $result);

		if(count($result) > 0){

			$quiz = $this->shuffle_quiz($result);

			$this->smarty->assign('list', $result);
			$this->smarty->assign('err_msg','');
			$this->smarty->assign('form', $form);
			$this->smarty->assign('quiz_answer', $quiz);


		} else {
			// エラーメッセージを設定　「検索結果がありません」
			$err_msg = W005;
			$this->smarty->assign('list',"");
			$this->smarty->assign('err_msg',$err_msg);
		}
	}

	public function shuffle_quiz($result){

		$quiz = array();
		foreach ($result as $key => $value) {

			 $answer = array();
			 $arr = (array)$value;
			 if(isset($arr["correct1"]) && $arr["correct1"] != ""){
			 	$answer[] = $arr["correct1"];
			 }
			 if(isset($arr["incorrect1"]) && $arr["incorrect1"] != ""){
			 	$answer[] = $arr["incorrect1"];
			 }
			 if(isset($arr["incorrect2"]) && $arr["incorrect2"] != ""){
			 	$answer[] = $arr["incorrect2"];
			 }
			 if(isset($arr["incorrect3"]) && $arr["incorrect3"] != ""){
			 	$answer[] = $arr["incorrect3"];
			 }

			$keys = array_keys($answer);
       		shuffle($keys);

       		foreach($keys as $k) {
            	$quiz[$key][] = $answer[$k];
        	}
		}
		return $quiz;
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
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;

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