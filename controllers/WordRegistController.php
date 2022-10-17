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
require_once 'dto/T_WordDto.php';
require_once 'util/DateUtil.php';
require_once 'service/WordService.php';
require_once 'service/WordBookWordService.php';
require_once 'dto/T_WordBook_Set_WordDto.php';

/**
 * 単語登録コントローラー
 */
class WordRegistController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		if ($this->check_login () == true) {
			$word_service = new WordService ( $this->pdo );
			$word_id = $this->form->word_id;
			$screen_mode = $this->form->screen_mode;
			$org_no = $this->form->org_no;
			$word_category = "";
			$trans_category = "";
			$err_msg = "";
			$word_category = $word_service->getWordLanguage ();
			$trans_category = $word_service->getTranslationLanguage ();
			if (count ( $word_category ) > 0) {
				$this->smarty->assign ( 'word_category', $word_category );
			} else {
				$this->smarty->assign ( 'word_category', "" );
				$this->smarty->assign ( 'error_msg', "ドロップダウンリストのデータがありません。" );
			}
			if (count ( $trans_category ) > 0) {
				$this->smarty->assign ( 'trans_category', $trans_category );
			} else {
				$this->smarty->assign ( 'trans_category', "" );
				$this->smarty->assign ( 'error_msg', "ドロップダウンリストのデータがありません。" );
			}
			// 更新処理
			if ($word_id != null) {
				$today_date = DateUtil::getDate ( 'Y/m/d' );
				// 検索結果を取得
				$list = $word_service->getWordData( $org_no, $word_id );
				if ($list != null) {
					foreach ( $list as $value ) {
						$this->form->org_no = $value->org_no;
						$this->form->word_id = $value->word_id;
						$this->form->word = $value->word;
						$this->form->remarks = $value->remarks;
						$this->form->file_name = $value->file_name;
						$this->form->word_lang_type = $value->word_lang_type;
						$this->form->trans_lang_type = $value->trans_lang_type;
						$this->form->translation = $value->translation;
						$this->form->screen_mode = "update";
						$this->form->word_system_kbn = '001';
						$this->form->updater_id = $_SESSION ['admin_no'];
						$this->form->updater_date = $today_date;
					}
				}
				// 登録処理
			} else {
				$word_services = new WordService ( $this->pdo );
				$next_word_id = $word_services->getNextId ();
				$this->form->word_id = $next_word_id->id;
				$this->form->org_no = COMMON_TEST_INFO_ORG;
				$this->form->word = "";
				$this->form->word_lang_type = "";
				$this->form->trans_lang_type = "";
				$this->form->translation = "";
				$this->form->screen_mode = "new";
				$this->form->creater_id = $_SESSION ['admin_no'];
			}
			// メニュー情報を取得、セットする
			$this->setMenu ();
			$this->smarty->assign ( 'form', $this->form );
			$this->smarty->display ( 'wordRegist.html' );
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/**
	 * 登録ボタン押下処理
	 */
	public function saveAction() {
		if ($this->check_login () == true) {
			$word_service = new WordService ( $this->pdo );
			// メニュー情報を取得、セットする
			$this->setMenu ();
			$word_category = "";
			$trans_category = "";
			$word_category = $word_service->getWordLanguage ();
			$trans_category = $word_service->getTranslationLanguage ();
			if (count ( $word_category ) > 0) {
				$this->smarty->assign ( 'word_category', $word_category );
			} else {
				$this->smarty->assign ( 'word_category', "" );
				$this->smarty->assign ( 'error_msg',"ドロップダウンリストのデータがありません。");
			}
			if (count ( $trans_category ) > 0) {
				$this->smarty->assign ( 'trans_category', $trans_category );
			} else {
				$this->smarty->assign ( 'trans_category', "" );
				$this->smarty->assign ( 'error_msg',"ドロップダウンリストのデータがありません。");
			}
			$screen_mode = $this->form->screen_mode;
			$org_name = $this->form->org_name;
			$word_id = $this->form->word_id;
			$org_no = $this->form->org_no;
			$word = $this->form->word;
			$translation = $this->form->translation;
			$word_lang_type = $this->form->word_lang_type;
			$trans_lang_type = $this->form->trans_lang_type;
			$remarks = $this->form->remarks;
			$file_name = "";
			// テストデータ情報登録
			$word_dto = new T_WordDto ();
			$word_dto->org_no = $org_no;
			$word_dto->word = $word;
			$word_dto->translation = $translation;
			$word_dto->word_lang_type = $word_lang_type;
			$word_dto->trans_lang_type = $trans_lang_type;
			$word_dto->file_name = $file_name;
			$word_dto->remarks = $remarks;
			$word_dto->word_system_kbn = "001";
			$word_dto->del_flg = 0;
			$word_dto->word_id = $this->form->word_id;
			$this->form->word_id = $word_dto->word_id;
			if ($screen_mode == 'update') {
				$word_id = $this->form->word_id;
				$word_dto->updater_id = $_SESSION ['admin_no'];
				$word_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$dao = new WordService ( $this->pdo );
				$result = $dao->updateWordInfo ( $word_dto );
				// 更新処理が正常の場合、
				if ($result == 1) {
					// 登録完了
					$this->setMenu ();
					$this->smarty->assign ( 'info_msg', I004);
					$this->form->screen_mode = 'update';
					$this->smarty->assign ( 'form', $this->form );
					$this->smarty->display ( 'wordRegist.html' );
					// 更新出来ない場合、
				} else {
					$this->setMenu ();
					$error = sprintf ( E007, '更新' );
					$this->smarty->assign ( 'msg', $error );
					$this->smarty->assign ( 'form', $this->form );
					$this->smarty->display ( 'WordRegist.html' );
					return;
				}
				// 登録状況
			} else {
				$word_dto->word_id = $this->form->word_id;
				$word_dto->creater_id = $_SESSION ['admin_no'];
				$word_dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$word_dto->updater_id = $_SESSION ['admin_no'];
				$word_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$dao = new WordService ( $this->pdo );
				$result = $dao->saveWord ( $word_dto );
				// 登録処理が正常の場合、クイズ一覧画面に遷移する。
				if ($result == 1) {
					// 登録完了
					//$this->setBackData ();
					// 登録完了
					$this->setMenu ();
					$this->smarty->assign ( 'info_msg', I004);
					$this->form->screen_mode = 'update';
					$this->smarty->assign ( 'form', $this->form );
					$this->smarty->display ( 'wordRegist.html' );
					// 登録出来ない場合
				} else {
					$this->setMenu ();
					$error = sprintf ( E007, '登録' );
					$this->smarty->assign ( 'error_msg', $error );
					$this->smarty->assign ( 'form', $this->form );
					$this->smarty->display ( 'wordRegist.html' );
					return;
				}
			}
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		// 登録完了
		$this->setBackData ();
		$this->setMenu ();
		// クイズ一覧画面へ遷移する
		$this->dispatch ( 'WordList/Search' );
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_word'] = $this->form->search_word;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
		$_SESSION ['search_translation'] = $this->form->search_translation;
		$_SESSION ['search_file_name'] = $this->form->search_file_name;
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;
	}

	/**
	 * 削除処理
	 */
	public function deleteAction() {
		if ($this->check_login () == true) {
			$word_service = new WordService ( $this->pdo );
			
			$org_no = $this->form->org_no;
			
			// メニュー情報を取得、セットする
			$this->setMenu ();
			$word_dto = new T_WordDto ();
			$word_dto->word_id = $org_no;
			$word_dto->word_id = $this->form->word_id;
			$word_dto->updater_id = $_SESSION ['admin_no'];
			$word_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
			$dao = new WordService ( $this->pdo );
			$result = $dao->deleteWordInfo ( $word_dto );
			// 登録処理が正常の場合、クイズ一覧画面に遷移する。
			if ($result == 1) {

				// 単語の単語帳情報を取得する
				$service = new WordBookWordService( $this->pdo );
				$wordbookList = $service->getWordBookListByWord($org_no, $word_dto->word_id);
				
				// 単語帳単語データを削除
				$rtn = $service->deleteWordBookWordByWord($org_no, $word_dto->word_id);
				
				LogHelper::logDebug("Delete Result : " . $rtn);
				
				foreach ($wordbookList as $wordbook){
					$wordbook_id = $wordbook->wordbook_id;
					$this->resetWordbookSetWordData($org_no, $wordbook_id);
					LogHelper::logDebug("Reset Wordbook : " . $wordbook_id);
				}
				
				$_SESSION ['regist_msg'] = I005;
				// 登録完了
				$this->setBackData ();
				// 受講者一覧画面へ遷移する
				$this->dispatch ( 'WordList/Search' );
				// 登録出来ない場合
			} else {
				$error = sprintf ( E007, '削除' );
				$this->smarty->assign ( 'msg', $error );
				$this->smarty->assign ( 'form', $this->form );
				$this->smarty->display ( 'WordList.html' );
				return;
			}
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	
	/*
	// 単語セット情報登録処理
	/
	*/
	public function resetWordbookSetWordData($org_no , $wordbook_id){
		
		$service = new WordBookWordService( $this->pdo);
		
		//単語帳セット情報を一旦削除
		$del_rtn = $service->delWordBookSetWord($org_no , $wordbook_id);

		// 単語帳単語情報を取得
		$wordbookWordList = $service->getWordBookWord($org_no , $wordbook_id);
		
		if ( count($wordbookWordList) > 0 ){
			
			foreach ($wordbookWordList as $dto){
			$dto->create_dt =  DateUtil::getDate('Y/m/d H:i:s');
			$dto->update_dt =  DateUtil::getDate('Y/m/d H:i:s');
			$dto->creater_id = $_SESSION['admin_no'];
			$dto->updater_id = $_SESSION['admin_no'];
			}
			
			//単語帳セット情報を登録
			$service->insertWordBookSetList($wordbookWordList,$this->pdo);
		}
		
	}
	
}
?>