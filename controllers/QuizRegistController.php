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
require_once 'dto/PageDto.php';
require_once 'dto/M_TypeDto.php';
require_once 'dao/M_TypeDao.php';
require_once 'service/TypeService.php';
require_once 'service/QuizService.php';
require_once 'service/AudioService.php';

/**
 * クイズ登録コントローラー
 */
class QuizRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ($this->check_login() == true){

			$screen_mode = $this->form->screen_mode;
			$org_no = $this->form->org_no;
			$type_service = new TypeService($this->pdo);
			$quiz_service=new QuizService($this->pdo);

			// 更新
			if($this->form->screen_mode =='update'){
				// 課題管理№のチェック
				if(!empty($this->form->quiz_no)){
					// 課題データ取得
					$quizInfo = $quiz_service->getQuizDataByQuizNo($this->form);

					if(count($quizInfo) == 1){
						// formにデータをセットする
						$this->form->quiz_no=$quizInfo->quiz_no;
						$this->form->quiz_name=$quizInfo->quiz_name;
						$this->form->quiz_type=$quizInfo->quiz_type;
						$this->form->answer_time=$quizInfo->answer_time;
						$this->form->quiz_content=$quizInfo->quiz_content;
						$this->form->audio_file=$quizInfo->audio_name;
						$this->form->correct1=$quizInfo->correct1;
						$this->form->correct2=$quizInfo->correct2;
						$this->form->incorrect1=$quizInfo->incorrect1;
						$this->form->incorrect2=$quizInfo->incorrect2;
						$this->form->incorrect3=$quizInfo->incorrect3;
						$this->form->hint=$quizInfo->hint;
						$this->form->explanation=$quizInfo->explanation;
						$this->form->remarks=$quizInfo->remarks;
						$this->form->type_name=$quizInfo->type_name;
					}

					$this->form->audio_del_flg=1;
					$this->form->screen_mode = "update";

				}else{
					TransitionHelper::sendException ( E002 );
					return;
				}
			}else{
				// 202011/06 Cherry 画像にクイズ番号が設定してない不具合修正
				$next_quiz_no = $quiz_service->getNextId();
				$quiz_no = $next_quiz_no->id;

				$this->form->quiz_no = $quiz_no;
				$this->form->quiz_name = "";
				$this->form->quiz_content = "";
				$this->form->audio_del_flg=0;
				$this->form->screen_mode = "";
				$this->form->quiz_type="";
				$this->form->remarks="";

			}

			$quizType=$type_service->getQuizType($this->form);

			// メニュー情報を取得、セットする
			$this->setMenu();

			$this->smarty->assign ( 'quizType', $quizType);
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'quizRegist.html' );

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

			$quiz_service=new QuizService($this->pdo);
			$type_service = new TypeService($this->pdo);

			// 登録ボタン押下処理
			// メニュー情報を取得、セットする
			$this->setMenu();
			$org_no = $this->form->org_no;
			$screen_mode = $this->form->screen_mode;
			$audio_del_flg=$this->form->audio_del_flg;

			$quiz_name = $this->form->quiz_name;
			$quiz_type = $this->form->quiz_type;
			$answer_time = $this->form->answer_time;
			$quiz_content = $this->form->quiz_content;
			$blank_correct1=$this->form->blank_correct1;
			$choice_correct1=$this->form->choice_correct1;
			$correct2 =$this->form->correct2;
			$incorrect1 =$this->form->incorrect1;
			$incorrect2 =$this->form->incorrect2;
			$incorrect3 =$this->form->incorrect3;
			$hint =$this->form->hint;
			$remarks = $this->form->remarks;

			// テストデータ情報登録
			$quiz_dto = new T_QuizDto();
			$quiz_dto->org_no= COMMON_TEST_INFO_ORG;
			$quiz_dto->quiz_name= $quiz_name;
			$quiz_dto->quiz_type= $quiz_type;
			$quiz_dto->answer_time= $answer_time;
			$quiz_dto->quiz_content= $quiz_content;
			$quiz_dto->explanation= $this->form->explanation;
			$quiz_dto->remarks= $remarks;

			if(!empty($blank_correct1)){
				$quiz_dto->correct1 = $blank_correct1;
				$this->form->correct1  = $blank_correct1;
			} else {
				$quiz_dto->correct1= $choice_correct1;
				$this->form->correct1  = $choice_correct1;
			}

			if(!empty($correct2)){
				$quiz_dto->correct2= $correct2;
			}

			if(!empty($incorrect1)){
				$quiz_dto->incorrect1= $incorrect1;
			}

			if(!empty($incorrect2)){
				$quiz_dto->incorrect2= $incorrect2;
			}

			if(!empty($incorrect3)){
				$quiz_dto->incorrect3= $incorrect3;
			}

			if(!empty($hint)){
				$quiz_dto->hint= $hint;
			}

			$quiz_dto->quiz_no = $this->form->quiz_no;

			LogHelper::logDebug("screen_mode : " . $screen_mode);
			
			if($screen_mode == 'update' ){

				$quiz_no = $this->form->quiz_no;
				
				// クイズ名重複チェックを外す　2022/05/27 
				// $duplicate_count = $quiz_service->checkedExistInfo( $org_no,$quiz_no,$quiz_name );
				// LogHelper::logDebug("duplicate_count : " . $duplicate_count);
				
				//クイズ番号がない場合、エラー
				if ($quiz_dto->quiz_no != ""){
					
					$quiz_dto->org_no = $org_no;
					$quiz_dto->updater_id = $_SESSION['admin_no'];
					$quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

					$img_chk_del= $this->form->img_chk_del;
					$audio_chk_del= $this->form->audio_chk_del;

					// 音声ファイルがある場合、音声ファイルのアップロード処理を実施
					if (!empty($quiz_no)){

						$audioService = new AudioService($this->pdo);

						$audio_name = "QuizNo_".$this->form->quiz_no. AUDIO_EXT;
						if (!empty($this->form->audio_data)) {

							$quiz_dto->audio_name = $audio_name;

							$audioService->deleteAudio($quiz_dto->org_no,QUIZ_AUDIO_DIR, "QuizNo_".$this->form->quiz_no);

							// プロジェクト名/Files/組織管理№/Quiz/QuizNo_クイズ管理№.選択されたファイルの拡張子
							$this->SaveAudio($this->form);
						} else {
							if(!empty( $this->form->audio_file)){
								$quiz_dto->audio_name =  $this->form->audio_file;
							}
						}
						// 音声フィル削除チェックの場合、削除する
						if($this->form->audio_chk_del == "1"){
							$quiz_dto->audio_name = "";
							$audioService->deleteAudioQuiz($quiz_dto->org_no,QUIZ_AUDIO_DIR, "QuizNo_".$this->form->quiz_no);
						}

					}

					$dao = new QuizService($this->pdo);
					$result = $dao->updateQuizInfo($quiz_dto);

					// 更新処理が正常の場合、
					if($result == 1){

						//登録完了
						$_SESSION ['regist_msg'] = I004;

						$this->setBackData();
						$this->dispatch('QuizList/search');

						// 更新出来ない場合、
					} else {

						$error = sprintf(E007,'更新');
						$this->smarty->assign ( 'msg', $error );
						$this->smarty->assign('form', $this->form);
						$this->smarty->display ( 'quizRegist.html' );
						return;
					}
				}else {

					$error = sprintf(E019,'クイズ番号', '更新');
					$this->smarty->assign( 'msg', $error );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'quizRegist.html' );
					return;
				}
				// 登録状況
			} else {

				$org_no = COMMON_TEST_INFO_ORG;
				$this->form->org_no = $org_no;
				$duplicate_count = $quiz_service->checkedExistInfo( $org_no,"",$quiz_name );
				LogHelper::logDebug("duplicate_count : " . $duplicate_count);
				if ( $duplicate_count == 0 ){

					// 202011/06 Cherry 画像にクイズ番号が設定してない不具合修正
					// $next_quiz_no = $quiz_service->getNextId();
					// $quiz_no = $next_quiz_no->id;
					$quiz_no = $this->form->quiz_no;
					if(!empty( $this->form->audio_data)){

						$quiz_dto->audio_name =  "QuizNo_".$quiz_no.AUDIO_EXT;
						$this->SaveAudio($this->form);
					}
					$quiz_dto->quiz_no = $quiz_no;
					$quiz_dto->creater_id = $_SESSION['admin_no'];
					$quiz_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$quiz_dto->updater_id = $_SESSION['admin_no'];
					$quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

					$dao = new QuizService($this->pdo);

					$result = $dao->saveQuiz($quiz_dto);


					// 登録処理が正常の場合、クイズ一覧画面に遷移する。
					if($result == 1){
						//登録完了

						$this->setBackData();
						//登録完了
						$_SESSION ['regist_msg'] = I004;//修正

						//登録完了
						$this->setBackData();

						// クイズ一覧画面へ遷移する
						$this->dispatch('QuizList/Search');

						// 登録出来ない場合
					} else {

						$error= sprintf(E007,'登録');
						$this->smarty->assign ( 'msg', $error );
						$this->smarty->assign('form', $this->form);
						$this->smarty->display ( 'quizRegist.html' );
						return;
					}
				}else {

					$quizType = $type_service->getQuizType($this->form);
					$this->smarty->assign ( 'quizType', $quizType);
					$error = sprintf(E016,'クイズ名');
					$this->smarty->assign( 'msg', $error );
					$this->smarty->assign( 'form', $this->form );
					$this->smarty->display( 'quizRegist.html' );
					return;
				}
			}
		 }else {
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
			$audio_name = "QuizNo_".$form->quiz_no . AUDIO_EXT;
			$audioService->saveAudioQuiz($form->audio_data, COMMON_TEST_INFO_ORG, QUIZ_AUDIO_DIR, $audio_name);
		}
	}

	/*
	 * 削除ボタンのAction
	 */
	public function deleteAction() {

		if ($this->check_login() == true) {

			$quiz_dto = new T_QuizDto();
			$org_no = $this->form->org_no;

			$this->form->org_no = $org_no;
			$quiz_dto->org_no = $org_no;

			$quiz_service=new QuizService($this->pdo);
			// メニュー情報を取得、セットする
			$this->setMenu();

			$quiz_dto = new T_QuizDto();
			$quiz_dto->org_no= $org_no;
			$quiz_dto->quiz_no = $this->form->quiz_no;
			$quiz_dto->updater_id = $_SESSION['admin_no'];
			$quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$dao = new QuizService($this->pdo);
			$result = $dao->deleteQuizInfo($quiz_dto);

			// 登録処理が正常の場合、クイズ一覧画面に遷移する。
			if($result == 1){
				//登録完了
				$this->setBackData();

				// 受講者一覧画面へ遷移する
				$this->dispatch('QuizList/Search');
				// 登録出来ない場合
			} else {
				$error= sprintf(E007,'削除');
				$this->smarty->assign ( 'msg', $error );
				$this->smarty->assign('form', $this->form);
				$this->smarty->display ( 'quizRegist.html' );
				return;
			}
		}else {
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

		// クイズ一覧画面へ遷移する
		$this->dispatch('QuizList/Search');

	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {

		$_SESSION ['back_flg'] = true;

		$_SESSION ['search_quiz_name'] = $this->form->search_quiz_name;
		$_SESSION ['search_quiz_content'] = $this->form->search_quiz_content;
		$_SESSION ['search_remark'] = $this->form->search_remark;
		$_SESSION ['search_rd_status1'] = $this->form->search_rd_status1;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
		
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;

	}

}
?>