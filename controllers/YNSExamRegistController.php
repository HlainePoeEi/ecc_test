<?php
require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/YNSExamService.php';
require_once 'dto/T_YNSExamDto.php';
require_once 'util/DateUtil.php';
require_once 'util/CommonUtil.php';

/**
 * テスト情報登録コントローラー
 */
class YNSExamRegistController extends BaseController
{
	/**
	 * 初期処理
	 */
	public function indexAction()
	{
		if ($this->check_maintenance() == true) {

			if ($this->check_login() == true) {

				//$this->form->org_no = $_SESSION['org_no'];
				//$org_no = $this->form->org_no;
				$date_flg = 0;
				$this->form->page = 1;
				$screen_mode = $this->form->screen_mode;
				$service = new YNSExamService($this->pdo);
				$exam_id = $this->form->exam_id;

				if ($this->form->screen_mode == 'update') {
					if (!empty($exam_id)) {
						// 検索結果を取得
						$list = $service->getExamInfo($exam_id);
						$today_date = DateUtil::getDate('Y/m/d');
						LogHelper::logDebug($list);
						if ($list != null) {
							foreach ($list as $value) {
								LogHelper::logDebug($value);
								$this->form->exam_id = $value->exam_id;
								$this->form->name = $value->name;
								$this->form->description = $value->description;
								$this->form->time = $value->time;
								$this->form->status = $value->status;
								$this->form->start_date = $value->start_date;
								$this->form->end_date = $value->end_date;
								$this->form->remarks = $value->remarks;
								$this->form->deadline_dt_old1 = $value->start_date;
								$diff = date_diff(date_create($value->start_date), date_create($today_date));
								if ($diff->format("%R%a") > 0) {

									$date_flg = 1;
								}
							}
						}
						$this->form->screen_mode = "update";
					} else {
						TransitionHelper::sendException(E002);
						return;
					}
				} else if ($this->form->screen_mode == 'copy') {

					if (!empty($this->form->exam_id)) {

						// 検索結果を取得
						$list = $service->getExamInfo($org_no, $exam_id);

						if (count($list) == 1) {

							$this->form->name = $list[0]->name;
							$this->form->time = "0";
							$this->form->description = $list[0]->description;
							$this->form->status = "1";

							$today_date = DateUtil::getDate('Y/m/d');

							$this->form->start_date = $today_date;
							$this->form->end_date = "2999/12/31";
							$this->form->remarks = $list[0]->remarks;
						}
						$this->form->screen_mode = "copy";
						$service = new YNSExamService($this->pdo);
						$next_exam_id = $service->getNextId();
						$this->form->exam_id = $next_exam_id->id;
						$this->form->ori_test_info_no = $exam_id;
					} else {
						TransitionHelper::sendException(E002);
						return;
					}
				} else {
					// 登録

					$today_date = DateUtil::getDate('Y/m/d');
					$this->form->end_date = "2999/12/31";
					$this->form->start_date = $today_date;
					$this->form->screen_mode = "new";
					$service = new YNSExamService($this->pdo);
					$next_exam_id = $service->getNextId();
					$this->form->exam_id = $next_exam_id->id;
					$this->form->name = "";
					$this->form->time = "0";
					$this->form->status = '1';
				}
				$this->setMenu();
				$this->smarty->assign('form', $this->form);
				$this->smarty->assign('btn_flg', '0');
				$this->smarty->assign('date_flg', $date_flg);
				$this->smarty->assign('screen_mode', $this->form->screen_mode);
				$this->smarty->display('ynsExamRegist.html');
			} else {
				TransitionHelper::sendException(E002);
				return;
			}
		} else {
			TransitionHelper::sendMaintenance($_SESSION['error_message']);
			return;
		}
	}

	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction()
	{
		if ($this->check_maintenance() == true) {

			$this->setMenu();

			// 登録ボタン押下処理
			if (isset($_POST['insert'])) {

				// メニューが開くかどうかを確認する
				$org_no = $_SESSION['org_no'];
				$screen_mode = $this->form->screen_mode;
				$date_flg = 0;
				$test_info_no = $this->form->test_info_no;
				$long_description = $this->form->long_description;
				$test_time = $this->form->test_time;
				$show_flg = $this->form->show_flg;
				$drill_flg = $this->form->drill_flg;
				$status = $this->form->status;
				$start_period = $this->form->start_period;
				$end_period = $this->form->end_period;
				$remarks = $this->form->remarks;

				// テストデータ情報登録
				$test_info_dto = new T_Test_InfoDto();
				$test_info_dto->org_no = $_SESSION['org_no'];
				$test_info_dto->test_info_no = $test_info_no;
				$test_info_dto->test_info_name = $this->form->test_info_name;

				$test_info_dto->long_description = $long_description;
				$test_info_dto->test_time = $test_time;
				$test_info_dto->show_flg = $show_flg;
				$test_info_dto->drill_flg = $drill_flg;
				$test_info_dto->start_period = $start_period;
				$test_info_dto->end_period = DateUtil::changeEndDateFormat($end_period);

				$test_info_dto->status = $status;
				$test_info_dto->remarks = $remarks;
				$test_info_dto->updater_id = $_SESSION['manager_no'];
				$test_info_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');

				$service = new TestInfoService($this->pdo);

				// 更新状況
				if ($screen_mode == 'update') {

					$result = $service->updateTestInfo($test_info_dto);

					// 更新処理が正常の場合、
					if ($result == 1) {

						$msg = sprintf(I004);
						$this->smarty->assign('msg', $msg);
						$this->smarty->assign('btn_flg', '1');
						$this->smarty->assign('screen_mode', $screen_mode);

						$screen_mode = 'update';
						$this->form->screen_mode = $screen_mode;
						$this->smarty->assign('screen_mode', $screen_mode);

						$today_date = DateUtil::getDate('Y-m-d');
						$diff = date_diff(date_create($test_info_dto->start_period), date_create($today_date));

						if ($diff->format("%R%a") > 0) {
							$date_flg = 1;
						}
						$this->smarty->assign('date_flg', $date_flg);

						// 更新出来ない場合、
					} else {

						$error = sprintf(E007, '更新');
						$this->smarty->assign('msg', $error);
						$this->smarty->assign('btn_flg', '0');
					}
					// 登録状況
				} else if ($screen_mode == 'copy') {

					$test_info_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$test_info_dto->creater_id = $_SESSION['manager_no'];

					// 取得結果．Tシーケンス.現在シーケンス番号+1
					$test_info_dto->test_info_no = $this->form->test_info_no;
					$result = $service->insertData($test_info_dto);

					if ($result == 1) {

						$result1 = $service->getListQuiz($org_no, $this->form->ori_test_info_no);
						$test_info_quiz_dto = new T_Test_Info_QuizDto();

						for ($i = 0; $i < count($result1); $i++) {

							$value = $result1[$i];
							$test_info_quiz_dto->test_info_no = $test_info_dto->test_info_no;
							$test_info_quiz_dto->quiz_info_no = $value->quiz_info_no;
							$test_info_quiz_dto->test_info_no = $test_info_no;
							$test_info_quiz_dto->disp_no = $value->disp_no;
							$test_info_quiz_dto->del_flg = '0';
							$test_info_quiz_dto->org_no = $org_no;
							$test_info_quiz_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
							$test_info_quiz_dto->creater_id = $_SESSION['manager_no'];
							$test_info_quiz_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
							$test_info_quiz_dto->updater_id = $_SESSION['manager_no'];
							$result = $service->insertData($test_info_quiz_dto);
						}
					}

					// 更新処理が正常の場合、
					if ($result == 1) {

						$msg = sprintf(I004);
						$this->smarty->assign('msg', $msg);
						$this->smarty->assign('btn_flg', '1');
						$screen_mode = 'update';
						$this->form->screen_mode = $screen_mode;
						$this->smarty->assign('screen_mode', $screen_mode);

						$today_date = DateUtil::getDate('Y-m-d');
						$diff = date_diff(date_create($test_info_dto->start_period), date_create($today_date));

						if ($diff->format("%R%a") > 0) {
							$date_flg = 1;
						}
						$this->smarty->assign('date_flg', $date_flg);

						// 更新出来ない場合、
					} else {

						$error = sprintf(E007, 'Copy');
						$this->smarty->assign('msg', $error);
						$this->smarty->assign('btn_flg', '0');
						$this->smarty->assign('screen_mode', $screen_mode);
					}
				} else if ($screen_mode == 'new') {

					$service = new TestInfoService($this->pdo);
					$test_info_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$test_info_dto->creater_id = $_SESSION['manager_no'];

					$result = $service->insertData($test_info_dto);

					$this->form->test_info_no = $test_info_dto->test_info_no;

					// 登録処理が正常の場合、
					if ($result == 1) {

						$msg = sprintf(I004);
						$this->smarty->assign('msg', $msg);
						$this->smarty->assign('btn_flg', '1');
						$screen_mode = 'update';
						$this->form->screen_mode = $screen_mode;
						$this->smarty->assign('screen_mode', $screen_mode);

						$today_date = DateUtil::getDate('Y-m-d');
						$diff = date_diff(date_create($test_info_dto->start_period), date_create($today_date));

						if ($diff->format("%R%a") > 0) {
							$date_flg = 1;
						}
						$this->smarty->assign('date_flg', $date_flg);

						// 登録出来ない場合
					} else {

						$error = sprintf(E007, '登録');
						$this->smarty->assign('msg', $error);
						$this->smarty->assign('btn_flg', '0');
					}
				}
			} else {
				$this->smarty->assign('msg', '');
				$this->smarty->assign('btn_flg', '0');
			}
			$this->smarty->assign('date_flg', $date_flg);
			$this->smarty->assign('form', $this->form);
			$this->smarty->display('testInfoRegist.html');
		} else {

			TransitionHelper::sendMaintenance($_SESSION['error_message']);
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction()
	{
		if ($this->check_maintenance() == true) {
			// テスト情報登録画面 の場合
			if ($this->form->btn_flg_type == "2") {
				$this->form->org_no = $this->form->org_no;
				$this->form->test_info_no = $this->form->test_info_no;
				$this->form->test_info_name = $this->form->test_info_test_info_name;
				$this->form->test_time = $this->form->test_info_test_time;
				$this->form->show_flg = $this->form->show_flg;
				$this->form->long_description = $this->form->long_description;
				$this->form->status = $this->form->status;
				$this->form->start_period = $this->form->test_info_start_period;
				$this->form->end_period = $this->form->test_info_end_period;
				$this->form->remarks = $this->form->test_info_remarks;
				$this->form->deadline_dt_old1 = $this->form->test_info_start_period;
				$this->form->screen_mode = $this->form->screen_mode;
				$this->form->btn_value = $this->form->btn_value;
				$this->form->ori_test_info_no = $this->form->ori_test_info_no;
				$this->form->btn_flg = $this->form->test_info_btn_flg;
				$this->form->date_flg = $this->form->test_info_date_flg;
				$this->smarty->assign('btn_flg', $this->form->btn_flg);
				$this->smarty->assign('status', $this->form->status);
				$this->smarty->assign('date_flg', $this->form->date_flg);
				$this->smarty->assign('screen_mode', $this->form->screen_mode);
				$this->smarty->assign('form', $this->form);
				$this->smarty->display('testInfoRegist.html');
			} else {
				// 登録完了
				$this->setBackData();
				// 受講者一覧画面へ遷移する
				$this->dispatch('TestInfoList/Search');
			}
		} else {
			TransitionHelper::sendMaintenance($_SESSION['error_message']);
			return;
		}
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData()
	{
		$_SESSION['back_flg'] = true;
		$_SESSION['search_start_period'] = $this->form->search_start_period;
		$_SESSION['search_end_period'] = $this->form->search_end_period;
		$_SESSION['search_test_info_name'] = $this->form->search_test_info_name;
		$_SESSION['search_remark'] = $this->form->search_remark;
		$_SESSION['search_rd_status1'] = $this->form->search_rd_status1;
		$_SESSION['search_rd_status2'] = $this->form->search_rd_status2;
		$_SESSION['search_rdstatus'] = $this->form->search_rdstatus;
		$_SESSION['search_chk_status1'] = $this->form->search_chk_status1;
		$_SESSION['search_chk_status2'] = $this->form->search_chk_status2;
		$_SESSION['search_status'] = $this->form->search_status;

		$_SESSION['search_page_til'] = $this->form->search_page_til;
		$_SESSION['search_page_row_til'] = $this->form->search_page_row_til;
		$_SESSION['search_page_order_column_til'] = $this->form->search_page_order_column_til;
		$_SESSION['search_page_order_dir_til'] = $this->form->search_page_order_dir_til;
	}
}
