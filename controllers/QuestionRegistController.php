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
require_once 'dao/T_QuestionDao.php';
require_once 'service/QuestionService.php';
require_once 'service/AudioService.php';
require_once 'dto/PageDto.php';
require_once 'dto/T_QuestionDto.php';
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';

/**
 * 問題登録コントローラー
 */
class QuestionRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login () == true ){

			$this->form->page = 1;
			$service = new QuestionService($this->pdo);
			$screen_mode = $this->form->screen_mode;
			// インプット Drop Down のためカテゴリーをデータベースから取得する
			$this->form->test_kbn_list = $service->getCategoryTypeAll(TEST_KBN);
			$this->form->course_level_list = $service->getCategoryTypeAll(COURSE_LEVEL_KBN);
			$wqa_pattern_list = $service->getCategoryTypeAll(WQA_PATTERN);
			$sqa_pattern_list = $service->getCategoryTypeAll(SQA_PATTERN);
			$this->form->qa_pattern_list = array_merge( $sqa_pattern_list, $wqa_pattern_list );
			$this->form->score_pattern_list = $service->getCategoryTypeAll(SCORE_PATTERN);

			$question_no = $this->form->question_no;

			if ( $this->form->screen_mode == 'update' ){
				// 更新モードなら
				if ( !empty($question_no) ){
					// 検索結果を取得
					$list = $service->getQuestionInfo($question_no);
					logHelper::logDebug($list);
					if ( $list != null ){

						foreach ( $list as $value ) {

							$this->form->question_no = $value->question_no;
							$this->form->question_name = $value->question_name;
							$this->form->qa_description = str_replace('<br/>', "\n", $value->qa_description);
							$this->form->description = str_replace('<br/>', "\n", $value->description);
							$this->form->test_kbn = $value->test_kbn;
							$this->form->course_level = $value->course_level;
							$this->form->qa_pattern = $value->qa_pattern;
							$this->form->score_pattern = $value->score_pattern;
							$this->form->audio_name = $value->audio_name;
							$this->form->audio_description = str_replace('<br/>', "\n",$value->audio_description);
							$this->form->prepare_time = $value->prepare_time;
							$this->form->answer_time = $value->answer_time;
							$this->form->audio_yes = $value->audio_yes;
							$this->form->yes_description = $value->yes_description;
							$this->form->status = $value->status;
							$this->form->audio_no = $value->audio_no;
							$this->form->no_description = $value->no_description;
							$this->form->audio_namelbl = $value->audio_name;
							$this->form->audio_yeslbl = $value->audio_yes;
							$this->form->audio_nolbl = $value->audio_no;

							if (substr($value->sample_answer, -4) == '.mp3'){
								$this->form->sample_answer_audio = $value->sample_answer;
								$this->form->sample_answerlbl = $value->sample_answer;
								$this->form->sample_answer = "";
								$this->form->sample_status = '0';
							}else {
								$this->form->sample_answer_audio = "";
								$this->form->sample_answer = str_replace("<br/>", "\n", $value->sample_answer);
								$this->form->sample_status = '1';
							}

							$this->form->byosha_point = str_replace('<br/>', "\n", $value->byosha_point);
							$this->form->remarks = str_replace('<br/>', "\n", $value->remarks);
							$this->form->screen_mode = 'update';
						}
					}

				}else {
					TransitionHelper::sendException ( E002 );
					return;
				}
			}else {
				// 登録モードなら
				// 取得結果．Tシーケンス.現在シーケンス番号+1
				$service = new QuestionService($this->pdo);
				$next_question_no = $service->getNextId();
				$this->form->question_no = $next_question_no->id;
				$this->form->question_name = "";
				$this->form->status = '1';
				$this->form->sample_status = '0';
				$this->form->test_kbn = '';
				$this->form->course_level = '';
			}
			$this->setMenu();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display('questionRegist.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {

		if ( $this->check_login () == true ){

			$this->setMenu();
			// 登録ボタン押下処理
			if ( isset ( $_POST ['insert'] ) ){

				$audioService = new AudioService($this->pdo);
				$screen_mode = $this->form->screen_mode;

				$service = new QuestionService($this->pdo);
				$this->form->test_kbn_list = $service->getCategoryTypeAll(TEST_KBN);
				$this->form->course_level_list = $service->getCategoryTypeAll(COURSE_LEVEL_KBN);
				$wqa_pattern_list = $service->getCategoryTypeAll(WQA_PATTERN);
				$sqa_pattern_list = $service->getCategoryTypeAll(SQA_PATTERN);
				$this->form->qa_pattern_list = array_merge($wqa_pattern_list, $sqa_pattern_list);
				$this->form->score_pattern_list = $service->getCategoryTypeAll(SCORE_PATTERN);
				$question_dto = new T_QuestionDto();
				$question_dto->question_name = $this->form->question_name;
				$qa_description = preg_replace("/\r\n|\r/", "<br/>",$this->form->qa_description);
				$question_dto->qa_description = preg_replace("/\t+/", ' ', $qa_description);
				$description = preg_replace("/\r\n|\r/", "<br/>",$this->form->description);
				// 内容には Html tag だけあるかどうかチャックする
				$remove_space = preg_replace("/\s|&nbsp;/",'',$description);
				if($remove_space != ''){
					$is_only_html = preg_match("#^(<[^>]*>)+$#", $remove_space);
					if ($is_only_html){
						$is_image = preg_match('/(<img[^>]+>)/i', $description);
						if (!$is_image){
							$description = "";
						}
					}
				}else {
					$description = "";
				}

				$question_dto->description = preg_replace("/\t+/", ' ', $description);
				$question_dto->test_kbn = $this->form->test_kbn;
				$question_dto->course_level = $this->form->course_level;
				$question_dto->qa_pattern = $this->form->qa_pattern;
				$question_dto->score_pattern = $this->form->score_pattern;
				$question_dto->status = $this->form->status;
				$question_dto->prepare_time = $this->form->prepare_time;
				$question_dto->answer_time = $this->form->answer_time;

				if ( $this->form->sample_status == '0' ){

					$question_dto->sample_answer = $this->form->sample_answerlbl;
					$this->form->sample_answer = null;
				}else {

					$question_dto->sample_answer = preg_replace("/\r\n|\r/", "<br/>", $this->form->sample_answer);
					$this->form->sample_answerlbl = null;
				}

				if ( $this->form->test_kbn == '001' ){

					$question_dto->audio_name = $this->form->audio_namelbl;
					$question_dto->audio_description = preg_replace("/\r\n|\r/", "<br/>", $this->form->audio_description);
					$question_dto->audio_yes = $this->form->audio_yeslbl;
					$question_dto->yes_description = $this->form->yes_description;
					$question_dto->audio_no = $this->form->audio_nolbl;
					$question_dto->no_description = $this->form->no_description;
				}else {

					$question_dto->audio_name = " ";
					$question_dto->audio_yes = null;
					$question_dto->audio_no = null;
				}

				if ( $this->form->prepare_time == null ){

					$question_dto->prepare_time = 0;
				}else {

					$question_dto->prepare_time = $this->form->prepare_time;
				}

				$question_dto->byosha_point = preg_replace("/\r\n|\r/", "<br/>",$this->form->byosha_point) ;
				$question_dto->remarks = preg_replace("/\r\n|\r/", "<br/>",$this->form->remarks) ;
				$question_dto->updater_id = $_SESSION ['admin_no'];
				$question_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				
				$file_ext = $this->form->file_ext;
				LogHelper::logDebug("form ext : " . $file_ext);

				$service = new QuestionService($this->pdo);

				// 更新状況
				if ( $this->form->screen_mode == 'update' ){

					$question_dto->question_no = $this->form->question_no;

					if ( !empty($this->form->audio_data1) && !empty($this->form->audio_namelbl) ){

						$question_dto->audio_name = "Q_".$this->form->question_no .$file_ext;
						$audio_name = $question_dto->audio_name;
						$this->form->audio_namelbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
						$audioService->saveAudio($this->form->audio_data1, $this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}else if ( empty($this->form->audio_namelbl) ){

						$audio_name = "Q_".$this->form->question_no . file_ext;
						$question_dto->audio_name = "";
						$this->form->audio_namelbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);

					}

					if ( !empty($this->form->audio_data2) && !empty($this->form->audio_yeslbl) ){

						$question_dto->audio_yes = "Q_yes_".$this->form->question_no . AUDIO_EXT;
						$audio_name = $question_dto->audio_yes;
						$this->form->audio_yeslbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
						$audioService->saveAudio($this->form->audio_data2, $this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}else if ( empty($this->form->audio_yeslbl) ){

						$audio_name = "Q_yes_".$this->form->question_no . AUDIO_EXT;
						$question_dto->audio_yes = "";
						$this->form->audio_yeslbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}

					if ( !empty($this->form->audio_data3) && !empty($this->form->audio_nolbl) ){

						$question_dto->audio_no = "Q_no_".$this->form->question_no . AUDIO_EXT;
						$audio_name = $question_dto->audio_no;
						$this->form->audio_nolbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
						$audioService->saveAudio($this->form->audio_data3, $this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}else if ( empty($this->form->audio_nolbl) ){

						$audio_name = "Q_no_".$this->form->question_no . AUDIO_EXT;
						$question_dto->audio_no = "";
						$this->form->audio_nolbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}

					if ( !empty($this->form->audio_data4) && !empty($this->form->sample_answerlbl) ){

						$question_dto->sample_answer = "Q_Sample_".$this->form->question_no . AUDIO_EXT;
						$audio_name = $question_dto->sample_answer;
						$this->form->sample_answerlbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
						$audioService->saveAudio($this->form->audio_data4, $this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}else if ( empty($this->form->sample_answerlbl) && empty($this->form->sample_answer) ){

						$audio_name = "Q_Sample_".$this->form->question_no . AUDIO_EXT;
						$question_dto->sample_answer = "";
						$this->form->sample_answerlbl = $audio_name;
						$audioService->deleteAudio($this->form->question_no, Q_AUDIO_DIR, $audio_name);
					}

					$result = $service->updateQuestionInfo($question_dto);

					// 更新処理が正常の場合、
					if ( $result == 1 ){

						$_SESSION ['regist_msg'] = I004;
						$this->smarty->assign( 'msg', $_SESSION ['regist_msg'] );
					}else {

						$error = sprintf( E007, '更新' );
						$this->smarty->assign( 'err_msg', $error );
					}
					// 登録状況
				}else if ( $this->form->screen_mode == 'new' ){

					$question_dto->question_no = $this->form->question_no;
					$question_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$question_dto->creater_id = $_SESSION ['admin_no'];

					if ( !empty( $this->form->audio_data1) && !empty($this->form->audio_namelbl) ){

						$question_dto->audio_name = "Q_".$question_dto->question_no . $file_ext;
						$audio_name = $question_dto->audio_name;
						$this->form->audio_namelbl = $audio_name;
						$audioService->saveAudio($this->form->audio_data1, $question_dto->question_no, Q_AUDIO_DIR, $audio_name);
					}

					if ( !empty( $this->form->audio_data2) && !empty($this->form->audio_yeslbl) ){

						$question_dto->audio_yes = "Q_yes_".$question_dto->question_no . AUDIO_EXT;
						$audio_name = $question_dto->audio_yes;
						$this->form->audio_yeslbl = $audio_name;
						$audioService->saveAudio($this->form->audio_data2, $question_dto->question_no, Q_AUDIO_DIR, $audio_name);
					}

					if ( !empty( $this->form->audio_data3) && !empty($this->form->audio_nolbl) ){

						$question_dto->audio_no = "Q_no_".$question_dto->question_no . AUDIO_EXT;
						$audio_name = $question_dto->audio_no;
						$this->form->audio_nolbl = $audio_name;
						$audioService->saveAudio($this->form->audio_data3, $question_dto->question_no, Q_AUDIO_DIR, $audio_name);
					}

					if ( !empty( $this->form->audio_data4) && !empty($this->form->sample_answerlbl) ){

						$question_dto->sample_answer = "Q_Sample_".$question_dto->question_no . AUDIO_EXT;
						$audio_name = $question_dto->sample_answer;
						$this->form->sample_answerlbl = $audio_name;
						$audioService->saveAudio($this->form->audio_data4, $question_dto->question_no, Q_AUDIO_DIR, $audio_name);
					}

					$result = $service->insertData($question_dto);

					$this->form->question_no = $question_dto->question_no;
					// 登録処理が正常の場合、
					if ( $result == 1 ){

						$_SESSION ['regist_msg'] = I004;
						$this->smarty->assign( 'msg', $_SESSION ['regist_msg'] );
						// 登録出来ない場合
					}else {

						$error = sprintf( E007, '登録' );
						$_SESSION ['regist_msg'] = $error;
					}
				}
			}else {
				$_SESSION ['regist_msg'] = "";
			}
/*
			$_SESSION ['regist_msg'] = "";
			$this->form->screen_mode = 'update';
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display('questionRegist.html'); */
		
			$this->backAction();
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login () == true ){

			//登録完了
			$this->setBackData();

			// 受講者一覧画面へ遷移する
			$this->dispatch('QuestionList/Search');
		}else {
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
		$_SESSION ['search_question_name'] = $this->form->search_question_name;
		$_SESSION ['search_test_kbn'] = $this->form->search_test_kbn;
		$_SESSION ['search_course_level'] = $this->form->search_course_level;
		$_SESSION ['search_status'] = $this->form->search_status;
		$_SESSION ['search_chk_status1'] = $this->form->search_chk_status1;
		$_SESSION ['search_chk_status2'] = $this->form->search_chk_status2;
	}
}
?>