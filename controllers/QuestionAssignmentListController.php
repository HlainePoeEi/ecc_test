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
require_once 'dao/T_QuestionAssignmentDao.php';
require_once 'service/Detail_QuestionService.php';
require_once 'dto/T_QuestionDto.php';
require_once 'dto/T_Course_Detail_QuestionDto.php';
require_once 'dto/PageDto.php';
require_once 'util/DateUtil.php';


/**
 * 詳細・問題割当コントローラー
 */
class QuestionAssignmentListController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {

		if ($this->check_login() == true){

			$this->form->page = 1;
			$this->dataSearch();
			$this->form->chk_status2 = "";
			$this->form->chk_status1 = "";
			// メニュー情報を取得、セットする
			$this->smarty->assign ( 'err_msg', "" );
			$this->smarty->assign('form',$this->form);
			$this->smarty->display ( 'questionAssignment.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	//上位テーブルのデータ検索
	public function searchAllWocAction() {

		if ($this->check_login() == true){

			$question_name = $this->form->question_name;
			$course_level = $this->form->course_level;
			$course_detail_no = $this->form->course_detail_no;
			$test_kbn = $this->form->test_kbn;
			$status = $this->form->status;
			$service = new Detail_QuestionService($this->pdo);

			if(isset($_SESSION['admin_no'])){
				$this->form->admin_no= $_SESSION['admin_no'];
			}
			// コース詳細の情報を取得する
			$temp = $service->getDetailInfo($course_detail_no);

			if($temp != null){
				foreach ($temp as $value){
					$this->form->course_detail_name = $value->course_detail_name;
					$this->form->course_detail_no = $value->course_detail_no;
					$this->form->course_level = $value->course_level;
					$this->form->search_course_level = $value->course_level;
					$this->form->course_detail_romaji = $value->course_detail_romaji;
					$this->form->test_kbn = $value->test_kbn;
					$this->form->search_test_kbn = $value->test_kbn;
					}
				}
			$list = $service->getQuestionListData($this->form, '');
			$count = count($list);

			if($count > 0){

				$this->form->msg = sprintf(I001,$count);
				$this->form->searchList = $list;

				$err_msg = "";
				echo json_encode ( $this->form->searchList );
			} else {

				$err_msg = W001;
				$this->smarty->assign ( 'error_msg', $err_msg );
				echo ( $err_msg );
			}

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	// コース詳細よに問題を保存する
	public function saveAction() {

		if ($this->check_login () == true) {

			$service = new Detail_QuestionService ( $this->pdo );

			if (isset ( $_SESSION ['admin_no'] )) {
				$login_id = $_SESSION ['admin_no'];
			}

			$course_detail_no = $this->form->course_detail_no;
			// 詳細に疑問があるか
			$count = count ( $service->getQuestionListOnDetail ( $this->form ) );

			if ($count > 0) {
				// 既存の質問をすべて削除する
				$service-> deleteExistQuestions( $course_detail_no);
			}

			$insertDataList = explode ( ',', $this->form->entryList );
			$display_no = 0;

			// 各データを追加する
			foreach ( $insertDataList as $insertData ) {

				if ($insertData != null || $insertData != "") {

					$detail_questionDto = new T_Course_Detail_QuestionDto ();

					$detail_questionDto->course_detail_no = $course_detail_no;
					$detail_questionDto->question_no = $insertData;
					$detail_questionDto->disp_no = ++$display_no;
					$detail_questionDto->del_flg = '0';
					$detail_questionDto->create_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$detail_questionDto->update_dt = DateUtil::getDate("Y/m/d H:i:s");;
					$detail_questionDto->creater_id = $_SESSION ['admin_no'];
					$detail_questionDto->updater_id = $_SESSION ['admin_no'];

					$result = $service->addDetailQuestions ( $detail_questionDto );
				}
			}

			$this->dataSearch();
			$err_msg = I004;
			$this->smarty->assign ( 'err_msg', $err_msg );
			$this->smarty->assign('form',$this->form);
			$this->smarty->display('questionAssignment.html');
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	// データを検索する
	public function dataSearch(){
		$course_detail_no = $this->form->course_detail_no;
		$service = new Detail_QuestionService ( $this->pdo );
		if($course_detail_no != Null){

			$list = $service->getDetailData($course_detail_no);
			if($list != null){
				foreach ($list as $value){
					$this->form->course_detail_name= $value->course_detail_name;
					$this->form->course_detail_no= $value->course_detail_no;
					$this->form->course_level = $value->course_level;
					$this->form->course_detail_romaji= $value->course_detail_romaji;
					$this->form->test_kbn= $value->test_kbn;
					$this->form->start_period= $value->start_period;
					$this->form->end_period= $value->end_period;
					}
				}
			$this->search($this->form);
		}
	}

	// データ検索
	private function search($form){

		if(empty($this->form->page)){
			$this->form->page = 1;
		}

		$service = new Detail_QuestionService($this->pdo);

		//検索結果を取得
		$count = count($service->getQuestionListOnDetail($this->form));

		if($count > 0){
			$existlist = $service->getQuestionListOnDetail($this->form);
			$this->smarty->assign('existlist',$existlist);
			$this->smarty->assign('searchList',NULL);

		} else {
			$this->smarty->assign('existlist',NULL);
			$this->smarty->assign('searchList',NULL);
		}
	}
}

?>