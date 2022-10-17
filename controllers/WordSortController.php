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
require_once 'service/WordBookWordService.php';
require_once 'dto/T_WordBook_WordDto.php';
require_once 'util/DateUtil.php';
/**
 * 単語並び替えコントローラー
 */
class WordSortController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		if ($this->check_login() == true){
			$this->form->org_no = $this->form->org_no;
			$this->form->wordbook_id = $this->form->wordbook_id;
			$this->form->search_name= $this->form->search_name;
			$this->getWordBookName();
			$this->search();
			$this->smarty->assign ( 'form', $this->form);
			$this->smarty->display ( 'wordSort.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	private function search(){
		$wordbook_id = $this->form->wordbook_id;
		$org_no = $this->form->org_no;
		$service = new WordBookWordService( $this->pdo);
		// 単語リストを取得
		$list = $service->getWordBookItem($wordbook_id,$org_no);
		$count= count($list);
		$msg="";
		if($count > 0){
			$this->smarty->assign('wordList',$list);
		} else {
			$msg = W001;
			$this->smarty->assign('wordList',NULL);
		}
		$this->smarty->assign ( 'err_msg', $msg);
	}

	/**
	 * 単語の名前を取得する
	 */
	public function getWordBookName(){
		$wordbook_id = $this->form->wordbook_id;
		$org_no = $this->form->org_no;
		$service = new WordBookWordService( $this->pdo);
		// 単語リストを取得
		$list = $service->getWordBookName($wordbook_id,$org_no);
		$count= count($list);
		$msg="";
		if($count > 0){
			foreach ( $list as $value ) {
				$this->form->name = $value->name;
			}
		} else {
			$msg = W001;
		}
		$this->smarty->assign ( 'err_msg', $msg);
	}

	/**
	 * 登録ボタンを押す場合
	 */
	public function saveAction(){
		if ($this->check_login() == true){
			$service = new WordBookWordService($this->pdo);
			$org_no = $this->form->org_no;
			$wordbook_id = $this->form->wordbook_id;
			$count = $service->countExistingWord ( $org_no, $wordbook_id);
			if ($count > 0) {
				// 削除処理
				$service-> deleteWordBookItem( $org_no, $wordbook_id);
			}
			if(!empty($this->form->entryList)){
				$wordbook_dto = new T_WordBook_WordDto($this->pdo);
				$wordbook_dto->org_no = $org_no;
				$wordbook_dto->wordbook_id = $this->form->wordbook_id;
				$wordbook_dto->del_flg = '0';
				$wordbook_dto->updater_id = $_SESSION ['admin_no'];
				$wordbook_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$wordbook_dto->creater_id = $_SESSION ['admin_no'];
				$wordbook_dto->create_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
				$insertDataList = explode ( ',', $this->form->entryList );
				$display_no = 0;
				foreach ( $insertDataList as $insertData ) {
					if ($insertData != null || $insertData != "") {
						$wordbook_dto->word_id = $insertData;
						$wordbook_dto->disp_no = ++$display_no;
						$service->saveWord($wordbook_dto);
					}
				}
			}
			
			// 単語帳単語データ登録が正常の場合、単語セット情報登録をする。
			$rtn = $this->resetWordbookSetWordData($org_no, $wordbook_id);
			
			$this->getWordBookName();
			$this->search();
			$msg = I004;
			$this->smarty->assign ( 'err_msg', $msg);
			$this->smarty->assign ( 'form', $this->form);
			$this->smarty->display ( 'wordSort.html' );
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		$this->setBackData ();
		$this->setMenu ();
		$this->dispatch ( 'WordBookList/Search' );
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_name'] = $this->form->search_name;
		$_SESSION ['search_page_row'] = $this->form->search_page_row;
		$_SESSION ['search_page_order_column'] = $this->form->search_page_order_column;
		$_SESSION ['search_page_order_dir'] = $this->form->search_page_order_dir;
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
		$setList = $service->getWordBookWord($org_no , $wordbook_id);
		
		foreach ($setList as $set){
			$set->create_dt =  DateUtil::getDate('Y/m/d H:i:s');
			$set->update_dt =  DateUtil::getDate('Y/m/d H:i:s');
			$set->creater_id = $_SESSION['admin_no'];
			$set->updater_id = $_SESSION['admin_no'];
		}
		
		if(count($setList) > 0 ){
			//単語帳セット情報を登録
			$service->insertWordBookSetList($setList,$this->pdo);
		}
	}
}
?>