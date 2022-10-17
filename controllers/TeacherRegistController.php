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
require_once 'service/TeacherService.php';
require_once 'service/TypeService.php';
require_once 'dto/T_TeacherDto.php';
require_once 'util/DateUtil.php';

/**
 * 組織管理者登録コントローラー
 */
class TeacherRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

			if ( $this->check_login() == true ){

				// 画面からデータ
				$this->form->date_flg = 0;

				$teacher_service = new TeacherService($this->pdo);
				$type_service = new TypeService($this->pdo);
				$teacher_no = $this->form->teacher_no;
				$screen_mode = $this->form->screen_mode;

				// 更新処理
				if ( $teacher_no != null ){

					$today_date = DateUtil::getDate('Y/m/d');

					// 検索結果を取得
					$list = $teacher_service->getTeacherInfo($teacher_no);

					if ( $list != null ){

						foreach ( $list as $value ){

							$this->form->teacher_no= $value->teacher_no;
							$this->form->name = $value->name;
							$this->form->nickname = $value->nickname;
							$this->form->login_id = $value->login_id;
							$this->form->display_name = $value->display_name;
							$this->form->password = "";
							$this->form->school_kbn = $value->school_kbn;
							$this->form->training_flg = $value->training_flg;
							$this->form->pw_update_dt = $value->pw_update_dt;
							$this->form->start_period = $value->start_period;
							$this->form->end_period = $value->end_period;
							$this->form->remarks = $value->remarks;
							$this->form->screen_mode = "update";
						}
					}
					// 登録処理
				}else {

					$this->form->teacher_no= "";
					$this->form->name = "";
					$this->form->nickname = "";
					$this->form->login_id = "";
					$this->form->display_name = "";
					$this->form->password = "";
					$this->form->school_kbn = "";
					$this->form->training_flg = 1;
					$this->form->pw_update_dt = "";
					$this->form->start_period = DateUtil::getDate('Y/m/d');
					$this->form->end_period = "2999/12/31";
					$this->form->remarks = "";
					$this->form->screen_mode = "new";
				}
				$this->form->school_kbn_list = $type_service->getCategoryTypeAll(SCHOOL_KBN);
				// メニュー情報を取得、セットする
				$this->setMenu();
				$this->smarty->assign('form', $this->form);
				$this->smarty->display ( 'teacherRegist.html' );
			}else {
				TransitionHelper::sendException ( E002 );
				return;
			}
	}
	/*
	 * 登録ボタン、更新ボタンのAction
	 */
	public function saveAction() {

		if ( $this->check_login() == true ){
			// メニュー情報を取得、セットする
			$this->setMenu();
			// 教師データ情報登録
			$teacher_dto = new T_TeacherDto();
			$type_service = new TypeService($this->pdo);
			// 教師データ情報登録
			$teacher_dto->login_id = $this->form->login_id;
			$teacher_dto->name = $this->form->name;
			$teacher_dto->nickname = $this->form->nickname;
			if ( !empty($this->form->password) ){

				$teacher_dto->password = CommonUtil::encryptPassword($this->form->password);
			}

			$teacher_dto->display_name = $this->form->display_name;
			$teacher_dto->school_kbn = $this->form->school_kbn;
			$teacher_dto->training_flg = $this->form->training_flg;
			$teacher_dto->start_period = $this->form->start_period;
			$teacher_dto->end_period = DateUtil::changeEndDateFormat($this->form->end_period);
			$teacher_dto->remarks = $this->form->remarks;
			$teacher_dto->update_dt = $this->form->update_dt;
			$teacher_dto->updater_id = $this->form->updater_id;

			$teacher_dto->del_flg = 0;
			$teacher_service = new TeacherService($this->pdo);

			// 編集状況
			if ( $this->form->screen_mode == "update" ){

				$teacher_dto->teacher_no = $this->form->teacher_no;

				if ( !empty($this->form->password) ){

					$teacher_dto->pw_update_dt = DateUtil::getDate('Y/m/d H:i:s');
				}
				// データベースに存在することをチェックする
				$result = $teacher_service->checkedExistInfo($teacher_dto->login_id);

				// データベースに存在していない場合、
				if ( count($result) == 0 || $result[0]->teacher_no == $teacher_dto->teacher_no ){
					$update_result = $teacher_service->updateTeacherInfo($teacher_dto);
					// 更新処理が正常の場合、組織管理者一覧（参照）画面に遷移する。
					if ( $update_result == 1 ){
						// 所属校舎のリストを取得する
						$this->form->school_kbn_list = $type_service->getCategoryTypeAll(SCHOOL_KBN);
						// 組織管理者一覧画面に遷移する
						//登録完了
						$_SESSION ['regist_msg_tchr'] = I004;
						$this->setBackData();
						$this->dispatch('TeacherList/Search');
						// 更新出来ない場合、
					}else {
						$error = sprintf(E007,'更新');
						$this->smarty->assign ( 'error_msg', $error );
					}
				}else {
					$error = sprintf(E014,'講師コード');
					$this->smarty->assign ( 'error_msg', $error );
				}
			// 登録状況
			}else {

				$teacher_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
				$teacher_dto->creater_id= $_SESSION['admin_no'];

				// データベースに存在することをチェックする
				$result = $teacher_service->checkedExistInfo($this->form->login_id);
				// データベースに存在していない場合、
				if ( count($result) == 0 ){
					// 取得結果．Tシーケンス.現在シーケンス番号+1
					$next_teacher_no = $teacher_service->getNextId();
					$teacher_dto->teacher_no = $next_teacher_no->id;
					$result = $teacher_service->insertData($teacher_dto);
					// 登録処理が正常の場合、組織管理者一覧画面に遷移する。
					if ( $result == 1 ){
						// 所属校舎のリストを取得する
						$this->form->school_kbn_list = $type_service->getCategoryTypeAll(SCHOOL_KBN);
						// 組織管理者一覧画面に遷移する
						//登録完了
						$_SESSION ['regist_msg_tchr'] = I004;
						$this->setBackData();
						$this->dispatch('TeacherList/Search');
						// 登録出来ない場合
					}else {
						$error = sprintf(E007,'登録');
						$this->smarty->assign ( 'error_msg', $error );
					}
					// データベースに存在している場合、
				}else {
					$error = sprintf(E014,'講師コード');
					$this->smarty->assign ( 'error_msg', $error );
				}
			}
			// 所属校舎のリストを取得する
			$this->form->school_kbn_list = $type_service->getCategoryTypeAll(SCHOOL_KBN);
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'teacherRegist.html' );
		}else {
			TransitionHelper::sendMaintenance ( $_SESSION ['error_message']);
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {

		if ( $this->check_login() == true ){

			//登録完了
			$this->setBackData();

			// 受講者一覧画面へ遷移する
			$this->dispatch('TeacherList/Search');
		}else {
			TransitionHelper::sendException( E002 );
			return;
		}
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {

		$_SESSION ['back_flg'] = true;

		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_start_period'] = $this->form->search_start_period;
		$_SESSION ['search_end_period'] = $this->form->search_end_period;
		$_SESSION ['search_name'] = $this->form->search_name;
		$_SESSION ['search_school_kbn'] = $this->form->search_school_kbn;
	}
}

?>