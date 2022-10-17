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
require_once 'service/QuestionService.php';
require_once 'dto/T_QuestionDto.php';

/**
 * 問題一覧コントローラー
 */
class QuestionListController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ( $this->check_login() == true ){

			$this->form->page = 1;
			$service = new QuestionService($this->pdo);
			$this->form->test_kbn_list = $service->getCategoryTypeAll(TEST_KBN);
			$this->form->course_level_list = $service->getCategoryTypeAll(COURSE_LEVEL_KBN);
			//全部のデータを表示する
			$this->search($this->form);

			if ( isset($_SESSION ['msg']) ){

				if ( $_SESSION ['msg'] != "" ){
					$this->smarty->assign( 'err_msg', $_SESSION ['msg'] );
					$_SESSION ['msg'] = "";
				}
			}

			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->smarty->assign( 'form', $this->form );
			$this->smarty->display('questionList.html');

		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	private function search($form) {

		if ( empty($this->form->page) ){

			$this->form->page = 1;
		}

		$service = new QuestionService($this->pdo);
		$list = $service->getQuestionListData($this->form , "0");
		$count = count($list);

		if ( $count > 0 ){

			$this->form->max_page = ceil($count / PAGE_ROW);
			$list = $service->getQuestionListData($this->form , "1");
			// <br/>置き換える
			for ( $i = 0; $i < count($list); $i++ ) {
				if($list[$i]->qa_description != ''){
					$list[$i]->qa_description = str_replace("<br/>", "\n", $list[$i]->qa_description);
				}
			}
			$search_test_kbn = explode(',',$this->form->search_test_kbn);
			$search_course_level = explode(' ',str_replace(',',' ',$this->form->search_course_level));
			$this->smarty->assign( 'list', $list );
			$this->smarty->assign( 'search_test_kbn', $search_test_kbn );
			$this->smarty->assign( 'search_course_level', $search_course_level );

		}else {
			// エラーメッセージを設定「検索結果がありません」
			$err_msg = W001;
			$this->smarty->assign( 'list', "" );
			$this->smarty->assign( 'err_msg', $err_msg );
		}
	}

	// 検索処理
	public function searchAction() {

		if ( $this->check_login() == true ){

			$err_msg = "";
			// back flag をセットした場合
			if ( isset($_SESSION ['back_flg']) ){

				// back バートンを押して一覧へ遷移する場合
				if ( $_SESSION ['back_flg'] ){

					$this->form->page = $_SESSION ['search_page'];
					$this->form->question_name = $_SESSION ['search_question_name'];
					$this->form->search_test_kbn = $_SESSION ['search_test_kbn'];
					$this->form->search_course_level = $_SESSION ['search_course_level'];
					$this->form->status = $_SESSION ['search_status'];
					$this->form->chk_status1 = $_SESSION ['search_chk_status1'];
					$this->form->chk_status2 = $_SESSION ['search_chk_status2'];
					$_SESSION ['search_page'] = "";
					$_SESSION ['search_question_name'] = "";
					$_SESSION ['search_test_kbn'] = "";
					$_SESSION ['search_course_level'] = "";
					$_SESSION ['search_chk_status1'] = "";
					$_SESSION ['search_chk_status2'] = "";
					$_SESSION ['back_flg'] = false;

				}
			}

			if ( empty($this->form->page) ){

				$this->form->page = 1;
			}

			$service = new QuestionService($this->pdo);
			$this->form->test_kbn_list = $service->getCategoryTypeAll(TEST_KBN);
			$this->form->course_level_list = $service->getCategoryTypeAll(COURSE_LEVEL_KBN);
			$search_test_kbn = explode(',',$this->form->search_test_kbn);
			$search_course_level = explode(' ',str_replace(',',' ',$this->form->search_course_level));
			// メニュー情報を取得、セットする
			$this->setMenu();
			logHelper::logDebug($this->form);
			// 検索結果を取得
			$list = $service->getQuestionListData($this->form, "0");
			$count = count($list);

			if ( $count > 0 ){

				$this->form->max_page = ceil($count/ PAGE_ROW);
				$list = $service->getQuestionListData($this->form , "1");
				// <br/>置き換える
				for ( $i = 0; $i < count($list); $i++ ) {
					if($list[$i]->qa_description != ''){
						$list[$i]->qa_description = str_replace("<br/>", "\n", $list[$i]->qa_description);
					}
				}
				$this->smarty->assign( 'list', $list );
				$this->smarty->assign( 'err_msg', '');

			}else {
				// エラーメッセージを設定「検索結果がありません」
				$err_msg = sprintf(W001);
				$this->smarty->assign( 'list', "" );
				$this->smarty->assign( 'err_msg', $err_msg );
			}
			
			if ( isset($_SESSION ['regist_msg'] ) ){

				if ($_SESSION ['regist_msg']  != "" ){
					$this->smarty->assign( 'err_msg', $_SESSION ['regist_msg']  );
					unset($_SESSION ['regist_msg']);
				}
			}

			$this->smarty->assign( 'form', $this->form );
			$this->smarty->assign( 'search_course_level', $search_course_level );
			$this->smarty->assign( 'search_test_kbn', $search_test_kbn );
			$this->smarty->display('questionList.html');
			return;

		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 削除ボタンのAction
	 */
	public function deleteAction() {

		if ( $this->check_login() == true ){

			$question_dto = new T_QuestionDto();
			$question_service = new QuestionService($this->pdo);

			// メニュー情報を取得、セットする
			$this->setMenu();
			$question_dto = new T_QuestionDto();
			$question_dto->question_no = $this->form->question_no;
			$question_dto->updater_id = $_SESSION ['admin_no'];
			$question_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
			$dao = new QuestionService($this->pdo);
			$result = $dao->deleteQuestion($question_dto);

			// 削除処理が正常の場合、 メッセージを表示する
			if ( $result == 1 ){

				$msg = sprintf(I005);
				$_SESSION ['msg'] = $msg;
			}else {
				// 削除できない場合
				$error = sprintf( E007, '削除' );
				$this->smarty->assign( 'err_msg', $error );
			}

			$this->smarty->assign( 'form', $this->form );
			$this->indexAction();
			return;
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
}
?>