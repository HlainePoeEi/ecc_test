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
require_once 'util/DateUtil.php';
require_once 'service/QuizInfoService.php';
require_once 'service/AudioService.php';

/**
 * クイズ情報登録コントローラー
 */
class QuizInfoRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ($this->check_login() == true){

			$screen_mode = $this->form->screen_mode;
			$orgNo = $this->form->org_no;
			$this->smarty->assign ( 'error_msg', "");
			$this->smarty->assign ( 'info_msg',"");

			$quiz_service=new QuizInfoService($this->pdo);
			
			LogHelper::logDebug("org_no : " . $this->form->org_no);

			// 更新
			if($this->form->screen_mode =='update'){
				// 課題管理№のチェック
				if(!empty($this->form->quiz_info_no)){
					// 課題データ取得
					$quizInfo = $quiz_service->getQuizDataByQuizNo($this->form);
					
					$quizInfoNo = $this->form->quiz_info_no;

					if(count($quizInfo) == 1){
						// formにデータをセットする
						$this->form->quiz_info_no = $quizInfo->quiz_info_no;
						$this->form->quiz_name = $quizInfo->quiz_name;
						$this->form->long_description = $quizInfo->long_description;
						$this->form->audio_file = $quizInfo->audio_name;
						$this->form->remarks = $quizInfo->remarks;

					}

					$this->form->audio_del_flg=1;
					$this->form->screen_mode = "update";
					
					$this->form->disable_mode = "";
					// 管理者は利用しないのでコメントアウト
					/* 
					$quizInfoDisable = $quiz_service->getQuizDataByQuizNoDisable($orgNo, $quizInfoNo);
					LogHelper::logDebug ( "quizInfoDisable count:".$quizInfoDisable);
					
					if ($quizInfoDisable > 0) {
						$this->form->disable_mode = "disable";
					}else{
						$this->form->disable_mode = "";
					} */

				}else{
					TransitionHelper::sendException ( E002 );
					return;
				}
			}else{
				
				$this->form->org_no = COMMON_TEST_INFO_ORG;
				$next_quiz_info_no = $quiz_service->getNextId();
				$quiz_info_no = $next_quiz_info_no->id;
				
				$this->form->quiz_info_no = $quiz_info_no;
				$this->form->quiz_name = "";
				$this->form->long_description = "";
				$this->form->audio_del_flg=0;
				$this->form->screen_mode = "";
				$this->form->remarks="";
				$this->smarty->assign ( 'error_msg', "");
				$this->smarty->assign ( 'info_msg',"");

			}

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'quizInfoRegist.html' );

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	
	}

	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {

		if ($this->check_login() == true) {

			$quiz_service=new QuizInfoService($this->pdo);

			// 登録ボタン押下処理
			// メニュー情報を取得、セットする
			$this->setMenu();

			$org_no = $this->form->org_no;
			$screen_mode = $this->form->screen_mode;
			$audio_del_flg=$this->form->audio_del_flg;
			$quiz_name = $this->form->quiz_name;
			$long_description = $this->form->long_description;
			$remarks = $this->form->remarks;

			// テストデータ情報登録
			$quiz_dto = new T_Quiz_InfoDto();
			
			$quiz_dto->quiz_name= $quiz_name;
			$quiz_dto->long_description= $long_description;
			$quiz_dto->remarks= $remarks;

			$quiz_dto->quiz_info_no = $this->form->quiz_info_no;
			$this->form->quiz_info_no = $quiz_dto->quiz_info_no;
			
			LogHelper::logDebug("org_no : " . $this->form->org_no);

			if($screen_mode == 'update' ){

				$quiz_dto->org_no= $this->form->org_no;
				$quiz_info_no = $this->form->quiz_info_no;

				$quiz_dto->updater_id = $_SESSION['admin_no'];
				$quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

				$audio_chk_del= $this->form->audio_chk_del;

				// 音声ファイルがある場合、音声ファイルのアップロード処理を実施
				if (!empty($quiz_info_no)){

					$audioService = new AudioService($this->pdo);

					$audio_name = "QuizInfoNo_".$this->form->quiz_info_no. AUDIO_EXT;
					if (!empty($this->form->audio_data)) {

						$quiz_dto->audio_name = $audio_name;

						$audioService->deleteAudioQuiz($quiz_dto->org_no,QUIZ_INFO_AUDIO_DIR, "QuizInfoNo_".$this->form->quiz_info_no);

						// プロジェクト名/Files/組織管理№/Quiz/QuizInfoNo_クイズ管理№.選択されたファイルの拡張子
						$this->SaveAudio($this->form);
					} else {
						if(!empty( $this->form->audio_file)){
							$quiz_dto->audio_name =  "QuizInfoNo_".$this->form->quiz_info_no .AUDIO_EXT;
						}
					}
					// 音声フィル削除チェックの場合、削除する
					if($this->form->audio_chk_del == "1"){
						$quiz_dto->audio_name = "";
						$audioService->deleteAudioQuiz($quiz_dto->org_no,QUIZ_INFO_AUDIO_DIR, "QuizInfoNo_".$this->form->quiz_info_no);
					}

				}

				$dao = new QuizInfoService($this->pdo);
				$result = $dao->updateQuizInfo($quiz_dto);

				// 更新処理が正常の場合、
				if($result == 1){

					//登録完了
					$_SESSION ['regist_msg'] = I004;

					$this->setBackData();
					$this->dispatch('QuizInfoList/search');

					// 更新出来ない場合、
				} else {

					$error = sprintf(E007,'更新');
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign('form', $this->form);
					$this->smarty->display ( 'quizInfoRegist.html' );
					return;
				}
				// 登録状況
			} else {

				$quiz_dto->org_no = COMMON_TEST_INFO_ORG;
				$next_quiz_info_no = $quiz_service->getNextId();
				$quiz_info_no = $next_quiz_info_no->id;

				$this->form->quiz_info_no = $quiz_info_no;
				if(!empty( $this->form->audio_data)){

					$quiz_dto->audio_name =  "QuizInfoNo_".$quiz_info_no.AUDIO_EXT;
					$this->SaveAudio($this->form);
				}
				$quiz_dto->quiz_info_no = $quiz_info_no;
				$quiz_dto->creater_id = $_SESSION['admin_no'];
				$quiz_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$quiz_dto->updater_id = $_SESSION['admin_no'];
				$quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

				$dao = new QuizInfoService($this->pdo);

				$result = $dao->saveQuiz($quiz_dto);

				// 登録処理が正常の場合、クイズ一覧画面に遷移する。
				if($result == 1){

					$this->smarty->assign ( 'info_msg',I004);
					$this->smarty->assign ( 'error_msg', "");

					// メニュー情報を取得、セットする
					$this->setMenu();
					$this->smarty->assign('form',$this->form);
					$this->smarty->display ( 'quizInfoRegist.html' );

					// 登録出来ない場合
				} else {

					$error= sprintf(E007,'登録');
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign('form', $this->form);
					$this->smarty->display ( 'quizInfoRegist.html' );
					return;
				}
			}
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	/**
	 *
	 */
	private function SaveAudio($form){

		$audioService = new AudioService($this->pdo);
		if ($form->audio_data != null && $form->audio_data != ""){
			$audio_name = "QuizInfoNo_".$form->quiz_info_no . AUDIO_EXT;
			$audioService->saveAudioQuiz($form->audio_data, $form->org_no, QUIZ_INFO_AUDIO_DIR, $audio_name);
		}
	}

	/*
	 * 削除ボタンのAction
	 */
	public function deleteAction() {

		if ($this->check_login() == true) {

			$quiz_dto = new T_Quiz_InfoDto();
		//	$org_no = COMMON_TEST_INFO_ORG;

		//	$this->form->org_no = $org_no;
		
			$org_no = $this->form->org_no;

			$quiz_service=new QuizInfoService($this->pdo);

			// メニュー情報を取得、セットする
			$this->setMenu();

			$quiz_dto->org_no = $org_no;
			$quiz_dto->quiz_info_no = $this->form->quiz_info_no;
			$quiz_dto->updater_id = $_SESSION['admin_no'];
			$quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$dao = new QuizInfoService($this->pdo);
			$result = $dao->deleteQuizInfo($quiz_dto);

			// 登録処理が正常の場合、クイズ一覧画面に遷移する。
			if($result == 1){
				//登録完了
				$this->setBackData();

				// 受講者一覧画面へ遷移する
				$this->dispatch('QuizInfoList/Search');
				// 登録出来ない場合
			} else {
				$error= sprintf(E007,'削除');
				$this->smarty->assign ( 'msg', $error );
				$this->smarty->assign('form', $this->form);
				$this->smarty->display ( 'quizInfoRegist.html' );
				return;
			}
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		if ($this->check_login() == true) {

			//登録完了
			$this->setBackData();

			// クイズ一覧画面へ遷移する
			$this->dispatch('QuizInfoList/Search');
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;

		$_SESSION ['search_quiz_name'] = $this->form->search_quiz_name;
		$_SESSION ['search_quiz_content'] = $this->form->search_long_description;
		$_SESSION ['search_remark'] = $this->form->search_remark;
		$_SESSION ['search_rd_status1'] = $this->form->search_rd_status1;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
		
		$_SESSION ['search_page_qil'] = $this->form->search_page_qil;
		$_SESSION ['search_page_row_qil'] = $this->form->search_page_row_qil;
		$_SESSION ['search_page_order_column_qil'] = $this->form->search_page_order_column_qil ;
		$_SESSION ['search_page_order_dir_qil'] = $this->form->search_page_order_dir_qil ;

	}

}
?>