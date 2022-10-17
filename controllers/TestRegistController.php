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

/**
 * テスト登録コントローラー
 */
class TestRegistController extends BaseController {

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
					
					$org_no = COMMON_TEST_INFO_ORG;
					$this->form->org_no = $org_no;

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
				$this->smarty->display('testRegist.html' );
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

			if ( $screen_mode != 'new' ){
				$this->form->test_type = $this->form->hd_test_type;
			}else{
				$this->form->org_no = COMMON_TEST_INFO_ORG;
			}

			$org_no = $this->form->org_no;
			$test_no = $this->form->test_no;
			$test_quiz_count = $this->form->test_quiz_count;
			$description = $this->form->description;
			$status = $this->form->status;
			$start_period = $this->form->start_period;
			$end_period = $this->form->end_period;
			$remarks = $this->form->remarks;

			// テストデータ情報登録
			$test_dto = new T_TestDto();
			$test_dto->org_no = $org_no;
			$test_dto->test_no = $test_no;
			$test_dto->test_name = $this->form->test_name;
			$test_dto->test_type = $this->form->test_type;
			$test_dto->test_quiz_count = $test_quiz_count; //20190605 テストタイプ修正

			$test_dto->description = $description;
			$test_dto->start_period = $start_period;
			$test_dto->end_period = DateUtil::changeEndDateFormat($end_period);

			$test_dto->status = $status;
			$test_dto->remarks = $remarks;
			$test_dto->updater_id = $_SESSION['manager_no'];
			$test_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

			$test_dto->test_no = $this->form->test_no;

			$service= new TestService($this->pdo);

			// 更新状況
			if ( $screen_mode == 'update' ){

				$result = $service->updateTestInfo($test_dto);

				// 更新処理が正常の場合、
				if ( $result == 1 ){

					$msg = sprintf(I004);
					$this->smarty->assign ( 'msg', $msg );
					$this->smarty->assign('btn_flg', '1');
					$this->smarty->assign('screen_mode', $screen_mode);

					$screen_mode = 'update';
					$this->form->screen_mode = $screen_mode ;
					$this->smarty->assign('screen_mode', $screen_mode);

					$today_date = DateUtil::getDate('Y-m-d');
					$diff =  date_diff(date_create($test_dto->start_period), date_create($today_date));

					if ( $diff->format("%R%a") > 0 ){
						$date_flg = 1;
					}
					$this->smarty->assign('date_flg', $date_flg);

					// 更新出来ない場合、
				} else {

					$error = sprintf(E007,'更新');
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign('btn_flg', '0');
				}
				// 登録状況
			}else if ( $screen_mode == 'copy' ){

				$test_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$test_dto->creater_id =  $_SESSION['manager_no'];

				// 取得結果．Tシーケンス.現在シーケンス番号+1
				$test_dto->test_no = $this->form->test_no;
				$result = $service->insertData($test_dto);

				if ( $result == 1 ){

					$result1 = $service->getListQuiz( $org_no, $this->form->ori_test_no );
					$test_quiz_dto = new T_Test_QuizDto();

					for ( $i = 0 ; $i < count($result1); $i++ ){

						$value =  $result1[$i];
						$test_quiz_dto->test_no = $test_dto->test_no;
						$test_quiz_dto->quiz_no = $value->quiz_no;
						$test_quiz_dto->test_no = $test_no;
						$test_quiz_dto->disp_no = $value->disp_no;
						$test_quiz_dto->del_flg = '0';
						$test_quiz_dto->org_no = $org_no;
						$test_quiz_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
						$test_quiz_dto->creater_id=  $_SESSION['manager_no'];
						$test_quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
						$test_quiz_dto->updater_id = $_SESSION['manager_no'];
						$result = $service->insertData($test_quiz_dto);
					}
				}


				// 更新処理が正常の場合、
				if ( $result == 1 ){

					// 教科一覧（参照）画面に遷移する
					$msg = sprintf(I004);
					$this->smarty->assign ( 'msg', $msg );
					$this->smarty->assign('btn_flg', '1');
					$screen_mode = 'update';
					$this->form->screen_mode = $screen_mode ;
					$this->smarty->assign('screen_mode', $screen_mode);

					$today_date = DateUtil::getDate('Y-m-d');
					$diff =  date_diff(date_create($test_dto->start_period), date_create($today_date));

					if ( $diff->format("%R%a") > 0 ){
						$date_flg = 1;
					}
					$this->smarty->assign('date_flg', $date_flg);

					// 更新出来ない場合、
				} else {

					$error = sprintf(E007,'Copy');
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign('btn_flg', '0');
					$this->smarty->assign('screen_mode', $screen_mode);

				}
			} else if ( $screen_mode == 'new' ){

				$service = new TestService($this->pdo);
				$test_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$test_dto->creater_id =  $_SESSION['manager_no'];

				// 取得結果．Tシーケンス.現在シーケンス番号+1
				$next_test_no = $service->getNextId();

				$result = $service->insertData($test_dto);

				$this->form->test_no = $test_dto->test_no;

				// 登録処理が正常の場合、
				if ( $result == 1 ){

					$msg = sprintf(I004);
					$this->smarty->assign ( 'msg', $msg );
					$this->smarty->assign('btn_flg', '1');
					$screen_mode = 'update';
					$this->form->screen_mode = $screen_mode ;
					$this->smarty->assign('screen_mode', $screen_mode);

					$today_date = DateUtil::getDate('Y-m-d');
					$diff =  date_diff(date_create($test_dto->start_period), date_create($today_date));

					if ( $diff->format("%R%a") > 0 ){
						$date_flg = 1;
					}
					$this->smarty->assign('date_flg', $date_flg);

					// 登録出来ない場合
				} else {

					$error = sprintf(E007,'登録');
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign('btn_flg', '0');
				}
			}
		}else {
			$this->smarty->assign ( 'msg', '' );
			$this->smarty->assign('btn_flg', '0');
		}
		$this->smarty->assign('date_flg', $date_flg);
		$this->smarty->assign('form', $this->form);
		$this->smarty->display ( 'testRegist.html' );
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
}

?>