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
require_once 'service/TestService.php';
require_once 'dto/T_TestDto.php';
require_once 'dto/T_Test_QuizDto.php';
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';
require_once 'service/QuizService.php';
require_once 'service/CourseOrgService.php';
require_once 'dto/T_Test_ConfDto.php';

/**
 * テスト複写コントローラー
 */
class TestCopyController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

			if ( $this->check_login () == true ) {

				$org_no = $this->form->org_no;
				$date_flg = 0;
				$this->form->page = 1;
				$screen_mode = $this->form->screen_mode;
				$service = new TestService($this->pdo);
				$test_no = $this->form->test_no;

				LogHelper::logDebug("org_no : " . $org_no);
				
				if ( $this->form->screen_mode == 'update' ){

					if (! empty($test_no) ){
						// 検索結果を取得
						$list = $service->getTestInfo($org_no, $test_no);
						$today_date = DateUtil::getDate('Y/m/d');
						if ( $list != null ){

							foreach ( $list as $value ){

								$this->form->test_no = $value->test_no;
								$this->form->test_name = $value->test_name;
								$this->form->test_type = $value->test_type;
								$this->form->test_quiz_count = $value->test_quiz_count;
								$this->form->description = $value->description;
								$this->form->status = $value->status;
								$this->form->start_period = $value->start_period;
								$this->form->end_period = $value->end_period;
								$this->form->remarks = $value->remarks;
								$this->form->deadline_dt_old1 = $value->start_period;
								$diff = date_diff(date_create($value->start_period), date_create($today_date));
								if ( $diff->format("%R%a") > 0 ){

									$date_flg = 1;
								}
							}
						}
						$this->form->screen_mode = "update";
					}else {
						TransitionHelper::sendException ( E002 );
						return;
					}
				}else if ( $this->form->screen_mode == 'copy' ){

					if (! empty($this->form->test_no) ){

						// 検索結果を取得
						$list = $service->getTestInfo($org_no, $test_no);

						if ( count($list) == 1 ){

							$this->form->test_name = $list[0]->test_name;
							$this->form->test_type = $list[0]->test_type;
							$this->form->test_quiz_count = $list[0]->test_quiz_count;
							$this->form->description = $list[0]->description;
							$this->form->status = '1';

							$today_date = DateUtil::getDate('Y/m/d');

							$this->form->start_period = $today_date;
							$this->form->end_period = "2999/12/31";
							$this->form->remarks = $list[0]->remarks;
						}
						$this->form->screen_mode = "copy";
						$service = new TestService($this->pdo);
						$next_test_no = $service->getNextId();
						$this->form->test_no =  $next_test_no ->id;
						$this->form->ori_test_no = $test_no;

					}else {
						TransitionHelper::sendException ( E002 );
						return;
					}
				}else {
					// 登録

					$today_date = DateUtil::getDate('Y/m/d');
					$this->form->end_period = "2999/12/31";
					$this->form->start_period = $today_date;
					$this->form->screen_mode = "new";
					$service= new TestService($this->pdo);
					$next_test_no = $service->getNextId();
					$this->form->test_no =  $next_test_no ->id;
					$this->form->test_name =  "";
					$this->form->test_type = '001';
					$this->form->status = '1';

				}
				$this->setMenu();
				$this->smarty->assign('form', $this->form);
				$this->smarty->assign('btn_flg', '0');
				$this->smarty->assign('date_flg', $date_flg);
				$this->smarty->assign('screen_mode', $this->form->screen_mode);
				$this->smarty->display('testCopy.html' );
			}else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}
	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {

		$this->setMenu();

		// 登録ボタン押下処理
		if ( isset ( $_POST ['insert'] ) ) {

			// メニューが開くかどうかを確認する
			$screen_mode = $this->form->screen_mode;

			$org_no = $this->form->org_no;
			$org_id = $this->form->org_id;
				
			if ( $screen_mode != 'new' ){
				$this->form->test_type = $this->form->hd_test_type;
			}
			
			$service = new CourseOrgService ($this->pdo);
			$result = $service->getOrgName($org_id);
			
			LogHelper::logDebug ("count of result : " .  count($result));
			
			if ( count($result) <> 1 ){

				LogHelper::logDebug ("Error : " . E017);
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'msg', E017 );
				
			}else {
				
				$new_org_no = $result[0]->org_no;;
				$test_no = $this->form->test_no;
				$test_quiz_count = $this->form->test_quiz_count;
				$description = $this->form->description;
				$status = $this->form->status;
				$start_period = $this->form->start_period;
				$end_period = $this->form->end_period;
				$remarks = $this->form->remarks;

				// テストデータ情報登録
				$test_dto = new T_TestDto();
				$test_dto->org_no = $new_org_no;
				$test_dto->test_no = $test_no;
				$test_dto->test_name = $this->form->test_name;
				$test_dto->test_type = $this->form->test_type;
				$test_dto->test_quiz_count = $test_quiz_count; //20190605 テストタイプ修正

				$test_dto->description = $description;
				$test_dto->start_period = $start_period;
				$test_dto->end_period = DateUtil::changeEndDateFormat($end_period);

				$test_dto->status = $status;
				$test_dto->remarks = $remarks;
				$test_dto->del_flg = "0";
				$test_dto->creater_id = $_SESSION['admin_no'];
				$test_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$test_dto->updater_id = $_SESSION['admin_no'];
				$test_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
				
				LogHelper::logDebug($test_dto);

				$service= new TestService($this->pdo);

				$test_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$test_dto->creater_id =  $_SESSION['admin_no'];

				// テスト管理番号設定
				$new_test_no = $this->form->test_no;
				$test_dto->test_no = $new_test_no;
				$result = $service->insertData($test_dto);
				
				$quiz_service = new QuizService($this->pdo);

				if ( $result == 1 ){
					
					// 管理者サイトで編集不可にするため、設定テーブルに登録
					$confDto = new T_Test_ConfDto();
					$confDto->org_no = $new_org_no;
					$confDto->test_no = $new_test_no;
					$confDto->editable_flg = OK;
					$confDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$confDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$confDto->creater_id = $_SESSION['admin_no'];
					$confDto->updater_id = $_SESSION['admin_no'];
					$resultConf = $service->insertData ( $confDto );

					$result1 = $service->getListQuiz( $org_no, $this->form->ori_test_no );
					
					LogHelper::logDebug ("testQuizList");
					LogHelper::logDebug ($result1);
					
					$quizList = array();
					$testQuizList = array();

					for ( $i = 0 ; $i < count($result1); $i++ ){
						
						$test_quiz_dto = new T_Test_QuizDto();
						
						// 新しいクイズ番号取得
						$next_quiz_info_dto = $quiz_service->getNextId();
						$new_quiz_info_no = $next_quiz_info_dto->id;

						$value =  $result1[$i];
						$test_quiz_dto->test_no = $new_test_no;
						$test_quiz_dto->quiz_no = $new_quiz_info_no;
						$test_quiz_dto->disp_no = $value->disp_no;
						$test_quiz_dto->del_flg = '0';
						$test_quiz_dto->org_no = $new_org_no;
						$test_quiz_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
						$test_quiz_dto->creater_id=  $_SESSION['admin_no'];
						$test_quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
						$test_quiz_dto->updater_id = $_SESSION['admin_no'];
						$result = $service->insertData($test_quiz_dto);
						
						// クイズデータ取得
						$quizInfo = $quiz_service->getQuizData($org_no , $value->quiz_no);
						
						if(count($quizInfo) == 1){
							
							// formにデータをセットする
							$quizInfo->org_no = $new_org_no;
							$quizInfo->quiz_no = $new_quiz_info_no;
							$quizInfo->del_flg = '0';
							$quizInfo->create_dt = DateUtil::getDate('Y/m/d H:i:s');
							$quizInfo->creater_id=  $_SESSION['admin_no'];
							$quizInfo->update_dt = DateUtil::getDate('Y/m/d H:i:s');
							$quizInfo->updater_id = $_SESSION['admin_no'];
							
							// audio_file がある場合、コピーする
							if ($quizInfo->audio_name != ""){
							
								$ori_path = ADMIN_FILE_DIR . $org_no . "/" . QUIZ_AUDIO_DIR . $quizInfo->audio_name;
								$new_name = "QuizInfoNo_" . $new_quiz_info_no . "." .strtolower(pathinfo($quizInfo->audio_name, PATHINFO_EXTENSION));
								$des_path = ADMIN_FILE_DIR . $new_org_no . "/" . QUIZ_AUDIO_DIR . $new_name;
								
								LogHelper::logDebug ("ori_path  : " . $ori_path );
								LogHelper::logDebug ("des_path  : " . $des_path );
								
								$this->copyFile($ori_path , $des_path);
								$quizInfo->audio_name = $new_name;
							}
							
							array_push($quizList , $quizInfo);
						}
						LogHelper::logDebug ("Quiz List");
						LogHelper::logDebug ($quizList);
					
					}
					
					if (count($quizList) > 0){
						$result2 = $quiz_service->bulkInsertWithPdo($quizList);

						LogHelper::logDebug ("Quiz List");
						LogHelper::logDebug ($quizList);
						LogHelper::logDebug (" result 2 : " . $result2);
						LogHelper::logDebug ("insert successfully.");
					}
						
				}
				// コピー処理が正常の場合、
				if ($result == 1) {
					
					$msg = sprintf ( I003 , "新組織にテストの複写" );
					$this->smarty->assign ( 'msg', $msg );
					$_SESSION ['copy_msg'] = $msg;
					
					$this->form->btn_flg_type = "";
					$this->backAction();
					
					// 更新出来ない場合、
				} else {
					
					$error = sprintf ( E007, '複写' );
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign ( 'btn_flg', '0' );
					$this->smarty->assign ( 'screen_mode', $screen_mode );
				}

			}

		}else {
			$this->smarty->assign ( 'msg', '' );
			$this->smarty->assign('btn_flg', '0');
		}
		$this->smarty->assign('date_flg', $date_flg);
		$this->smarty->assign('form', $this->form);
		$this->smarty->display ( 'testCopy.html' );
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		
			//テスト登録画面の場合
			if ( $this->form->btn_flg_type == "2" ){
				$this->form->org_no = $this->form->org_no;
				$this->form->test_no = $this->form->test_no;
				$this->form->test_name = $this->form->test_test_name;
				$this->form->test_type = $this->form->test_type;
				$this->form->test_quiz_count = $this->form->test_quiz_count;
				$this->form->description = $this->form->description;
				$this->form->status = $this->form->status;
				$this->form->start_period = $this->form->test_start_period;
				$this->form->end_period = $this->form->test_end_period;
				$this->form->remarks = $this->form->test_remarks;
				$this->form->deadline_dt_old1 = $this->form->test_start_period;
				$this->form->screen_mode = $this->form->screen_mode;
				$this->form->btn_value = $this->form->btn_value;
				$this->form->ori_test_no = $this->form->ori_test_no;
				$this->form->btn_flg = $this->form->test_btn_flg;
				$this->form->date_flg = $this->form->test_date_flg;
				$this->smarty->assign('btn_flg',$this->form->btn_flg);
				$this->smarty->assign('status',$this->form->status);
				$this->smarty->assign('date_flg',$this->form->date_flg);
				$this->smarty->assign('screen_mode', $this->form->screen_mode);
				$this->smarty->assign( 'form', $this->form );
				$this->smarty->display('testRegist.html');
			}else {
				//登録完了
				$this->setBackData();
				// 受講者一覧画面へ遷移する
				$this->dispatch('TestList/Search');
			}
		
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
	
	/**
	 * 組織情報表示ボタン処理
	 */
	public function orgShowAction(){

		if ( $this->check_login() == true ){

			$service = new CourseOrgService($this->pdo);
			$org_id = $this->form->org_id;
			$result = $service->getOrgName($org_id);
			if ( count($result) > 1 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'msg', E016 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else if ( count($result) == 0 ){

				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'msg', E017 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else {

				$courseOrgDto = new T_Course_OrgDto();
				$this->smarty->assign ( 'org_name', $result[0]->org_name);
				$this->form->org_name = $result[0]->org_name;
				$this->form->org_name_official = $result[0]->org_name_official;
				$this->displayValue($this->form);
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	
	/**
	 * 画面上値設定処理
	 */
	public function displayValue($myForm) {
		
		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'testCopy.html' );
	}
	
	/*
	* ファイルをコピーする
	*/
	public function copyFile($srcfile , $dstfile){
		
		mkdir(dirname($dstfile), 0777, true);
		copy($srcfile, $dstfile);
	}
	
}

?>