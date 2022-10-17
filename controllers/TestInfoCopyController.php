<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/TestInfoService.php';
require_once 'dto/T_Test_InfoDto.php';
require_once 'util/DateUtil.php';
require_once 'service/CourseOrgService.php';
require_once 'util/CommonUtil.php';
require_once 'service/QuizInfoService.php';
require_once 'service/QuizDetailsService.php';
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
require_once 'dto/T_Test_Info_ConfDto.php';

/**
 * テスト情報複写登録コントローラー
 */
class TestInfoCopyController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
			
			if ($this->check_login () == true) {
				
				$date_flg = 0;
				$this->form->page = 1;
				$screen_mode = $this->form->screen_mode;
				$service = new TestInfoService ( $this->pdo );
				$test_info_no = $this->form->test_info_no;
				
				if ($this->form->screen_mode == 'update') {
					if (! empty ( $test_info_no )) {

						$org_no = $this->form->org_no;
						// 検索結果を取得
						$list = $service->getTestInfo ( $org_no, $test_info_no );
						$today_date = DateUtil::getDate ( 'Y/m/d' );
						LogHelper::logDebug ( $list );
						if ($list != null) {
							foreach ( $list as $value ) {
								LogHelper::logDebug ( $value );
								$this->form->test_info_no = $value->test_info_no;
								$this->form->test_info_name = $value->test_info_name;
								$this->form->long_description = $value->long_description;
								$this->form->test_time = $value->test_time;
								$this->form->show_flg = $value->show_flg;
								$this->form->drill_flg = $value->drill_flg;
								$this->form->status = $value->status;
								$this->form->start_period = $value->start_period;
								$this->form->end_period = $value->end_period;
								$this->form->remarks = $value->remarks;
								$this->form->deadline_dt_old1 = $value->start_period;
								$diff = date_diff ( date_create ( $value->start_period ), date_create ( $today_date ) );
								if ($diff->format ( "%R%a" ) > 0) {
									
									$date_flg = 1;
								}
							}
						}
						$this->form->screen_mode = "update";
					} else {
						TransitionHelper::sendException ( E002 );
						return;
					}
				} else if ($this->form->screen_mode == 'copy') {
					
					if (! empty ( $this->form->test_info_no )) {
						
						$org_no = $this->form->org_no ;
						
						// 検索結果を取得
						$list = $service->getTestInfo ( $org_no, $test_info_no );
						
						if (count ( $list ) == 1) {
							
							$this->form->test_info_name = $list [0]->test_info_name;
							$this->form->test_time = $list [0]->test_time;
							$this->form->long_description = $list [0]->long_description;
							$this->form->show_flg = "0";
							$this->form->drill_flg = "0";
							$this->form->status = "1";
							
							$today_date = DateUtil::getDate ( 'Y/m/d' );
							
							$this->form->start_period = $today_date;
							$this->form->end_period = "2999/12/31";
							$this->form->remarks = $list [0]->remarks;
						}
						$this->form->screen_mode = "copy";
						$service = new TestInfoService ( $this->pdo );
						$next_test_info_no = $service->getNextId ();
						$this->form->test_info_no = $next_test_info_no->id;
						$this->form->ori_test_info_no = $test_info_no;
					} else {
						TransitionHelper::sendException ( E002 );
						return;
					}
				} else {
					// 登録
					$this->form->org_no = COMMON_TEST_INFO_ORG;
					$org_no = COMMON_TEST_INFO_ORG;
					$today_date = DateUtil::getDate ( 'Y/m/d' );
					$this->form->end_period = "2999/12/31";
					$this->form->start_period = $today_date;
					$this->form->screen_mode = "new";
					$service = new TestInfoService ( $this->pdo );
					$next_test_info_no = $service->getNextId ();
					$this->form->test_info_no = $next_test_info_no->id;
					$this->form->test_info_name = "";
					$this->form->test_time = "0";
					$this->form->drill_flg = "0";
					$this->form->status = '1';
				}
				$this->setMenu ();
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->assign ( 'btn_flg', '0' );
				$this->smarty->assign ( 'date_flg', $date_flg );
				$this->smarty->assign ( 'screen_mode', $this->form->screen_mode );
				$this->smarty->display ( 'testInfoCopy.html' );
			} else {
				TransitionHelper::sendException ( E002 );
				return;
			}
		
	}
	
	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {
			
			$this->setMenu ();
			
			// 登録ボタン押下処理
			if (isset ( $_POST ['insert'] )) {
				
				// メニューが開くかどうかを確認する
				$org_no = $this->form->org_no;
				$org_id = $this->form->org_id;
				
				$service = new CourseOrgService ($this->pdo);
				$result = $service->getOrgName($org_id);
				
				LogHelper::logDebug ("Error : " .  count($result));
				
				if ( count($result) <> 1 ){

					LogHelper::logDebug ("Error : " . E017);
					$this->smarty->assign( 'info_msg', "" );
					$this->smarty->assign( 'msg', E017 );
					
				}else {

					$new_org_no =  $result[0]->org_no;
					$screen_mode = $this->form->screen_mode;
					$date_flg = 0;
					$end_period = $this->form->end_period;
					
					// テストデータ情報登録
					$test_info_dto = new T_Test_InfoDto ();
					$test_info_dto->org_no =  $new_org_no;
					$test_info_dto->test_info_no = $this->form->test_info_no;
					$test_info_dto->test_info_name = $this->form->test_info_name;
					$test_info_dto->long_description = $this->form->long_description;
					$test_info_dto->test_time = $this->form->test_time;
					$test_info_dto->show_flg = $this->form->show_flg;
					$test_info_dto->drill_flg = $this->form->drill_flg;
					$test_info_dto->start_period = $this->form->start_period;
					$test_info_dto->end_period = DateUtil::changeEndDateFormat ( $end_period );
					$test_info_dto->status = $this->form->status;
					$test_info_dto->remarks = $this->form->remarks;
					$test_info_dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$test_info_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$test_info_dto->creater_id = $_SESSION['admin_no'];
					$test_info_dto->updater_id = $_SESSION['admin_no'];
					
					$service = new TestInfoService ( $this->pdo );
					$result = $service->insertData ( $test_info_dto );
					
					LogHelper::logDebug("test result is " . $result);

					if ($result == 1) {
						
						LogHelper::logDebug($org_no);
						LogHelper::logDebug($this->form->ori_test_info_no);
						
						// 管理者サイトで編集不可にするため、設定テーブルに登録
						$confDto = new T_Test_Info_ConfDto();
						$confDto->org_no = $new_org_no;
						$confDto->test_info_no = $this->form->test_info_no;
						$confDto->editable_flg = OK;
						$confDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
						$confDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
						$confDto->creater_id = $_SESSION['admin_no'];
						$confDto->updater_id = $_SESSION['admin_no'];
						$resultConf = $service->insertData ( $confDto );
						
						$result1 = $service->getListQuiz ( $org_no, $this->form->ori_test_info_no );
						$test_info_quiz_dto = new T_Test_Info_QuizDto ();
						
						$quiz_service = new QuizInfoService($this->pdo);
						$qzDetailService = new QuizDetailsService( $this->pdo );
						
						LogHelper::logDebug("result1");
						LogHelper::logDebug($result1);
						
						$quizList = array();
						$quizItemList = array();
						$quizOptionList = array();
						$testQuizList = array();
						
						for($i = 0; $i < count ( $result1 ); $i ++) {
							
							$value = $result1 [$i];
							$test_info_quiz_dto->test_info_no = $test_info_dto->test_info_no;

							// クイズ情報もコピーして登録
							$next_quiz_info_dto = $quiz_service->getNextId();
							$new_quiz_info_no = $next_quiz_info_dto->id;
							
							// クイズ情報取得して登録
							LogHelper::logDebug("quizInfoNo :"  . $value->quiz_info_no);
							$quizInfo = $quiz_service->getQuizData($org_no , $value->quiz_info_no);
							
							// 画像コピー処理（今はコピーしないのでコメントアウト）
							// $ori_str = "/" . COMMON_TEST_INFO_ORG . "/QuizInfo/image/";
							// $replace_str = "/" . $new_org_no . "/QuizInfo/image/";
							// $new_long_description = str_replace($ori_str , $replace_str , $quizInfo->long_description);
							
							//　音声ファイルがある場合、ファイルをコピーする
							if ($quizInfo->audio_name != ""){
								
								$ori_path = ADMIN_FILE_DIR . $org_no . "/" . QUIZ_INFO_AUDIO_DIR . $quizInfo->audio_name;
								$new_name = "QuizInfoNo_" . $new_quiz_info_no . "." .strtolower(pathinfo($quizInfo->audio_name, PATHINFO_EXTENSION));
								$des_path = ADMIN_FILE_DIR . $new_org_no . "/" . QUIZ_INFO_AUDIO_DIR . $new_name;
								
								LogHelper::logDebug ("ori_path  : " . $ori_path );
								LogHelper::logDebug ("des_path  : " . $des_path );
								
								$this->copyFile($ori_path , $des_path);
								$quizInfo->audio_name = $new_name;
							}

							$quizInfo->org_no = $new_org_no;
							$quizInfo->quiz_info_no = $new_quiz_info_no;
							// 画像コピー処理（今はコピーしないのでコメントアウト）
						//	$quizInfo->long_description = $new_long_description;
							
							$quizInfo->del_flg = '0';
							$quizInfo->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
							$quizInfo->creater_id = $_SESSION['admin_no'];
							$quizInfo->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
							$quizInfo->updater_id = $_SESSION['admin_no'];
							
							array_push($quizList , $quizInfo);
							LogHelper::logDebug("quizInfo");
							LogHelper::logDebug($quizInfo);

							// テスト情報・クイズ紐づけ登録
							$test_info_quiz_dto->quiz_info_no = $new_quiz_info_no;
							$test_info_quiz_dto->disp_no = $value->disp_no;
							$test_info_quiz_dto->del_flg = '0';
							$test_info_quiz_dto->org_no = $new_org_no;
							$test_info_quiz_dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
							$test_info_quiz_dto->creater_id = $_SESSION['admin_no'];
							$test_info_quiz_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
							$test_info_quiz_dto->updater_id = $_SESSION['admin_no'];
							$result = $service->insertData ( $test_info_quiz_dto );
							LogHelper::logDebug("result  is " . $result);
							LogHelper::logDebug($test_info_quiz_dto);
							array_push($testQuizList , $test_info_quiz_dto);
							
							// クイズアイテム情報登録
							$dataItem = $qzDetailService->getQzItemInfo($org_no , $value->quiz_info_no);
							LogHelper::logDebug($dataItem);
							
							for ($item = 0 ; $item < count($dataItem) ; $item++){
								$itemDto = $dataItem[$item];
								
								$itemDto->quiz_info_no = $new_quiz_info_no;
								$itemDto->del_flg = '0';
								$itemDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
								$itemDto->creater_id = $_SESSION['admin_no'];
								$itemDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
								$itemDto->updater_id = $_SESSION['admin_no'];
								LogHelper::logDebug("itemDto");
								LogHelper::logDebug($itemDto);

								array_push($quizItemList , $itemDto);
							}

							// クイズアイテムオプション登録
							$dataOpt = $qzDetailService->getQzItemOptionInfo($org_no , $value->quiz_info_no);
							LogHelper::logDebug($dataOpt);
							for ($opt = 0 ; $opt < count($dataOpt) ; $opt++){
								
								$optDto = $dataOpt[$opt];
								
								$optDto->quiz_info_no = $new_quiz_info_no;
								$optDto->del_flg = '0';
								$optDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
								$optDto->creater_id = $_SESSION['admin_no'];
								$optDto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
								$optDto->updater_id = $_SESSION['admin_no'];
								LogHelper::logDebug("optDto");
								LogHelper::logDebug($optDto);
								
								array_push($quizOptionList , $optDto);
							}

						}
						
						LogHelper::logDebug("quizList");
						LogHelper::logDebug($quizList);
						LogHelper::logDebug("quizItemList");
						LogHelper::logDebug($quizItemList);
						LogHelper::logDebug("quizOptionList");
						LogHelper::logDebug($quizOptionList);
						
						if (count($quizList) > 0 ){
							$result = $quiz_service->bulkInsertWithPdo($quizList);
							LogHelper::logDebug("result 1 is " . $result);
						}
						if (count($quizItemList) > 0 ){
							$result = $quiz_service->bulkInsertWithPdo($quizItemList);
							LogHelper::logDebug("result 2 is " . $result);
						}
						if (count($quizOptionList) > 0 ){
							$result = $quiz_service->bulkInsertWithPdo($quizOptionList);
							LogHelper::logDebug("result 3 is " . $result);
						}

					}
					
					// コピー処理が正常の場合、
					if ($result == 1) {
						
						$msg = sprintf ( I003 , "新組織にテスト情報の複写" );
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
				
			} else {
				$this->smarty->assign ( 'msg', '' );
				$this->smarty->assign ( 'btn_flg', '0' );
			}
			$this->smarty->assign ( 'date_flg', $date_flg );
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'testInfoCopy.html' );

	}
	
	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		// 登録完了
		$this->setBackData ();
		// テスト情報一覧画面へ遷移する
		$this->dispatch ( 'TestInfoList/Search' );
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
		$this->smarty->display( 'testInfoCopy.html' );
	}
		
	/*
	* ファイルをコピーする
	*/
	public function copyFile($srcfile , $dstfile){
		
		mkdir(dirname($dstfile), 0777, true);
		copy($srcfile, $dstfile);
	}
}