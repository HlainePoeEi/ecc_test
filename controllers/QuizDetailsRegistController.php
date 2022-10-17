<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseController.php';
require_once 'conf/config.php';
require_once 'service/TypeService.php';
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
require_once 'service/QuizDetailsService.php';
require_once 'service/QuizInfoService.php';
require_once 'util/DateUtil.php';

/**
 * クイズアイテム登録コントローラー
 */
class QuizDetailsRegistController extends BaseController {

	/**
	 * 初期処理
	 */
	public function indexAction() {

		if($this->check_login() == true) {
			$this->initDataSet();
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 画面データ取得・渡す処理
	 */
	public function getQzDetailsData($form , $msg) {

		$org_no = $this->form->org_no;
		$quiz_info_no = $this->form->quiz_info_no;

		$qzItemDtService = new QuizDetailsService( $this->pdo );
		$qzOptDtService = new QuizDetailsService( $this->pdo );

		//クイズ情報番号の存在チェック処理
		$count = $qzOptDtService->checkExistQInfoNo($org_no,$quiz_info_no);
		$this->smarty->assign ( 'qzInfoCount', $count);

		$screen_mode =$this->form->screen_mode;

		// クイズタイプ取得
		$type_service = new TypeService($this->pdo);
		$qzType=$type_service->getQuizType($this->form);
		$date_flg  = 0;

		if($screen_mode == "update") {

			if($quiz_info_no!= "") {

				// データベース接続
				$dataItem = $qzItemDtService->getQzItemInfo($org_no , $quiz_info_no);
				$dataOpt = $qzOptDtService->getQzItemOptionInfo($org_no , $quiz_info_no);

				if(sizeof($dataItem) > 0) {
					$this->smarty->assign ( 'qzList', $dataItem);
					$this->smarty->assign ( 'qzListOpt', $dataOpt);

				} else {
					$this->smarty->assign ( 'qzList', "");
					$this->smarty->assign ( 'qzListOpt', "");
				}

				$this->smarty->assign ( 'qztypeNo', $qzType);
				$this->smarty->assign ( 'error_msg',$msg);
			} else {
				TransitionHelper::sendException ( E001);
				return;
			}
			$this->smarty->assign ( 'date_flg', $date_flg);
			$this->smarty->assign ( 'form', $this->form);
			$this->smarty->display ( 'quizDetailsRegist.html' );
		} else {
			$this->form->qz_type = "001";
			$this->smarty->assign ( 'qzList', "");
			$this->smarty->assign ( 'qzListOpt', "");
			$this->smarty->assign ( 'qztypeNo', $qzType);
			$this->smarty->assign ( 'error_msg', $msg );
			$this->smarty->assign ( 'form', $this->form);
			$this->smarty->display ( 'quizDetailsRegist.html' );
		}
	}

	/**
	 * 登録処理
	 */
	public function saveAction() {

		if ($this->check_login () == true) {
			$form = $this->form;
			$qzDtService = new QuizDetailsService( $this->pdo );

			$org_no = $this->form->org_no;
			$uer_id= $_SESSION['admin_no'];
			$quiz_info_no = $this->form->quiz_info_no;
			
			//クイズが回答したチェック処理
			// 2021/07/14 チェリー修正
			/* $countTested = $qzDtService->checkTestedQuiz($org_no,$quiz_info_no);
			if($countTested > 0){
				return $this->registPage();
			} */

			// 管理者サイトでは利用しないのでコメントアウト
		/*	$quiz_service=new QuizInfoService($this->pdo);
			$quizInfoDisable = $quiz_service->getQuizDataByQuizNoDisable($org_no, $quiz_info_no);
			
			if ($quizInfoDisable > 0) {
				return $this->registPage();
			}
			*/
			
			$index=1;

			//クイズアイテム（Tクイズ情報テーブル）
			if(isset($this->form->arrTypeNameList)) {

				$insertDataList= json_decode(stripslashes($form->arrTypeNameList));

				//存在したアイテムの削除、更新するため
				$qzDtService->deleteQuizItemInfoDetails( $org_no, $quiz_info_no );

				 foreach ( $insertDataList as $insertData ) {

					$qzDtlDto = new T_Quiz_ItemDto ($this->pdo );

					$qzDtlDto->quiz_info_no = $form->quiz_info_no;
					$qzDtlDto->quiz_item_no= $index;
					$qzDtlDto->quiz_type= $insertData->qz_type;
					$qzDtlDto->description= $insertData->qz_content;
					$qzDtlDto->marks= $insertData->qz_mark;

					$qzDtlDto->del_flg = '0';
					$qzDtlDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$qzDtlDto->update_dt= DateUtil::getDate ( 'Y/m/d H:i:s' );
					$qzDtlDto->creater_id = $uer_id;
					$qzDtlDto->updater_id = $uer_id;
					$result = $qzDtService->registQzOptDtlData( $qzDtlDto );
					if ($result > 0) {
						$error_msg = I004;
					} else {

						$error_msg = sprintf ( E007, '登録' );

						break;
					}
					$index++;
				}
			}

			//4選択アイテム（Tオプションテーブル）

				$index=1;

				if(isset($this->form->arrTypeNameList1)) {

					$insertDataList= json_decode(stripslashes($form->arrTypeNameList1));

					foreach ( $insertDataList as $insertData ) {

						$qzDtlDto = new T_Quiz_Item_OptionDto($this->pdo );
						$qzDtlDto->quiz_info_no = $form->quiz_info_no;
						$qzDtlDto->quiz_item_no= $insertData->qzItemNo;
						$qzDtlDto->option_no= $index;
						$qzDtlDto->description= $insertData->content;
						$qzDtlDto->correct_flag= $insertData->cflag;

						$qzDtlDto->del_flg = '0';
						$qzDtlDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
						$qzDtlDto->update_dt= DateUtil::getDate ( 'Y/m/d H:i:s' );
						$qzDtlDto->creater_id = $uer_id;
						$qzDtlDto->updater_id = $uer_id;
						$result = $qzDtService->registQzOptDtlData( $qzDtlDto );
						if ($result > 0) {
							$error_msg = I004;
						} else {
							$error_msg = sprintf ( E007, '登録' );
							break;
						}
						$index++;
					}

			}

			//穴埋めアイテム（Tオプションテーブル）

			$index1=$index;

			if(isset($this->form->arrTypeNameList2)) {

				$insertDataList= json_decode(stripslashes($form->arrTypeNameList2));

				foreach ( $insertDataList as $insertData ) {

					$qzDtlDto = new T_Quiz_Item_OptionDto($this->pdo );
					$qzDtlDto->quiz_info_no = $form->quiz_info_no;
					$qzDtlDto->quiz_item_no= $insertData->qzItemNo;
					$qzDtlDto->option_no= $index1;
					$qzDtlDto->description= $insertData->content;
					$qzDtlDto->correct_flag= $insertData->cflag;

					$qzDtlDto->del_flg = '0';
					$qzDtlDto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
					$qzDtlDto->update_dt= DateUtil::getDate ( 'Y/m/d H:i:s' );
					$qzDtlDto->creater_id = $uer_id;
					$qzDtlDto->updater_id = $uer_id;
					$result = $qzDtService->registQzDtlData ( $qzDtlDto );
					if ($result > 0) {
						$error_msg = I004;
					} else {
						$error_msg = sprintf ( E007, '登録' );
						break;
					}
					$index1++;
				}

			}
			// セッションからデータ取得
			$this->form->org_no = $this->form->org_no;

			// メニュー情報を取得、セットする
			$this->setMenu();
			$this->form->screen_mode = "update";

			// クイズアイテム設定
			$this->getQzDetailsData($this->form , $error_msg);

		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	
	}

	//初期データ設定
	public function initDataSet(){

		// セッションからデータ取得
		$this->form->org_no = $this->form->org_no;
		
		$this->form->disable_mode = "";
		// 管理者サイトでは利用しないのでコメントアウト
	/* 	$quiz_service=new QuizInfoService($this->pdo);
		$quizInfoDisable = $quiz_service->getQuizDataByQuizNoDisable($this->form->org_no, $this->form->quiz_info_no);
		LogHelper::logDebug ( "quizInfoDisable count:".$quizInfoDisable);
		
		if ($quizInfoDisable > 0) {
			$this->form->disable_mode = "disable";
		}else{
			$this->form->disable_mode = "";
		} */

		// メニュー情報を取得、セットする
		$this->setMenu();

		// クイズアイテム設定
		$this->getQzDetailsData($this->form , "");
	}

/*
* 戻るボタンのAction
*/
public function backAction() {
	if ( $this->check_login() == true) {
		$this->setBackData();

		$this->smarty->assign( 'msg', "");
		$this->smarty->assign( 'error_msg', "");
		$this->smarty->assign( 'form', $this->form );
		$this->smarty->display('quizInfoRegist.html');
	}
	else {
		TransitionHelper::sendException( E002 );
		return;
	}


	}

	/*
	 * 戻る場合のデータセット
	*/
	public function setBackData() {

		$org_no= $this->form->org_no;
		$quiz_info_no= $this->form->quiz_info_no;
		$quiz_name= $this->form->quiz_name;
		$long_description= $this->form->long_description;
		$remarks= $this->form->remarks;
		$audio_file= $this->form->audio_file;
		$input_audio_file= $this->form->input_audio_file;
		$audio_del_flg= $this->form->audio_del_flg;
		$audio_chk_del= $this->form->audio_chk_del;


		$this->form->org_no = $org_no;
		$this->form->quiz_info_no = $quiz_info_no;
		$this->form->quiz_name = $quiz_name;
		$this->form->long_description = $long_description;
		$this->form->remarks = $remarks;
		$this->form->audio_file = $audio_file;
		$this->form->input_audio_file = $input_audio_file;
		$this->form->audio_del_flg = $audio_del_flg;
		$this->form->audio_chk_del = $audio_chk_del;
		$this->form->disable_mode = $this->form->disable_mode ;
		
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
		
		$_SESSION ['search_page_qil'] = $this->form->search_page_qil;
		$_SESSION ['search_page_row_qil'] = $this->form->search_page_row_qil;
		$_SESSION ['search_page_order_column_qil'] = $this->form->search_page_order_column_qil ;
		$_SESSION ['search_page_order_dir_qil'] = $this->form->search_page_order_dir_qil ;

	}

	//クイズが回答したらクイズ登録画面に移動
	public function registPage(){

		$this->setBackData();

		$this->smarty->assign( 'info_msg', "");
		$this->smarty->assign( 'msg', "クイズアイテムを変更できません");
		$this->smarty->assign( 'form', $this->form );
		$this->smarty->display('quizInfoRegist.html');
	}

}

?>