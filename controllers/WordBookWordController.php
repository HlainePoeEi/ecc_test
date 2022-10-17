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
require_once 'dto/T_WordBook_WordDto.php';
require_once 'dto/T_Word_HistoryDto.php';
require_once 'service/WordBookWordService.php';
require_once 'service/WordBookService.php';
require_once 'util/DateUtil.php';
/**
 * 単語追加コントローラー
 * 
 */
class WordBookWordController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction(){
		if ($this->check_login() == true){
			$_SESSION ['search_org_id']=$this->form->search_org_id;
			$this->search();

			$this->setMenu();
			$this->smarty->assign ( 'form', $this->form);
			$this->smarty->display ( 'wordBookWordRegist.html' );
		}else {
				TransitionHelper::sendException ( E002 );
				return;
			}
	}

	/**
	 * リスト処理
	 */
	private function search(){
		$entryList = "";
		$registerList = [];
		$registerWordList = [];
		$exist_word_list = [];
		$nonexist_word_list = [];
		$resultList = [];
		if (empty ( $this->form->search_page )) {
			$this->form->search_page = 0;
		}

		$service = new WordBookWordService( $this->pdo);
		$list = $service->getWordList($this->form,"0");
		$count= count($list);
		if($count > 0){
			$registerList = $service->getSelectedWord($this->form);
			if(count($registerList) > 0){
				//get register quiz_no list
				foreach ($registerList as $value){
					array_push($registerWordList, $value->word_id);
				}
				foreach ($list as $value){
					if(in_array($value->word_id,$registerWordList)){
						array_push($exist_word_list, $value);
					}else {
						array_push($nonexist_word_list, $value);
					}
				}
				$resultList = array_merge($exist_word_list, $nonexist_word_list);
				if($this->form->entryList == ""){
					foreach ($registerWordList as $value){
						$entryList .= $value. ",";
					}
					$this->form->initialList = $entryList;
					$this->form->entryList = $entryList;
				}else{
					$registerWordList= explode ( ',', $this->form->entryList );
				}
			}else{
				$resultList = $list;
				$registerWordList= explode ( ',', $this->form->entryList );
			}
			$this->smarty->assign ('list', $resultList);
			$this->smarty->assign('data_list',$registerWordList);
		} else {
			// エラーメッセージを設定　「検索条件に該当するデータが存在しません。」
			$err_msg = W001;
			$this->smarty->assign ( 'list', "" );
			$this->smarty->assign('data_list', "");
			$this->smarty->assign ( 'err_msg', $err_msg );
		}
	}

	/**
	 * 検索ボタン押下処理
	 */
	public function searchAction() {

		if ( isset( $_SESSION ['back_flg']) && ($_SESSION ['back_flg'] != "") ){
			$this->form->search_page = $_SESSION ['search_page'];
			$this->form->search_page_row = $_SESSION ['search_page_row'];
			$this->form->search_page_order_column = $_SESSION ['search_page_order_column'];
			$this->form->search_page_order_dir = $_SESSION ['search_page_order_dir'];
			if(empty($this->form->search_page)) {
				$this->form->search_page = 0;
				$this->form->search_page_row = 10;
				$this->form->search_page_order_column = 1;
				$this->form->search_page_order_dir = true;
			}
			$_SESSION ['search_page'] = "";
			$_SESSION ['search_page_row'] = "";
			$_SESSION ['search_page_order_column'] = "";
			$_SESSION ['search_page_order_dir'] = "";
			$_SESSION ['back_flg'] = false;
		}
		if ($this->check_login() == true){
			$service = new WordBookWordService($this->pdo);
			// メニュー情報を取得、セットする
			$this->setMenu();
			// 検索結果を取得
			$this->search();
			$this->smarty->assign('form',$this->form);
			$this->smarty->display('wordBookWordRegist.html');
			return;
		} else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}

	/*
	 * 単語データ情報登録
	 */
	public function vocubRegistAction(){
		$org_no= $this->form->org_no;
		$wordbook_id = $this->form->wordbook_id;
		$displayNo = 0;
		$insertDataList = explode ( ',', $this->form->entryList );
		if(!empty($insertDataList)){
			$service = new WordBookWordService( $this->pdo);
			$service->deleteSelectedWord($this->form);
			$displayNoCount = $service->wordBookList();
			$count = count($displayNoCount);
			
			//削除した単語リストのフラグ=1
			$initialDataList=explode( ',', $this->form->initialList );
            $wordIDList=array_diff($initialDataList,$insertDataList);
            foreach ($wordIDList as $value) {
                $this->form->word_id=$value;
                $service->deletewordHistory($this->form);
            }
			
			foreach ($insertDataList as $value) {
				if ($value != "") {
					$wordbook_worddto = new T_WordBook_WordDto();
					$wordbook_worddto->org_no = $org_no;
					$wordbook_worddto->wordbook_id = $wordbook_id;
					$wordbook_worddto->word_id = $value;
					$wordbook_worddto->disp_no = ++$displayNo;
					$wordbook_worddto->creater_id = $_SESSION['admin_no'];
					$wordbook_worddto->updater_id = $_SESSION['admin_no'];
					$wordbook_worddto->del_flg = '0';
					$wordbook_worddto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
					$wordbook_worddto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
					$result=$service->wordRegist($wordbook_worddto);
				}
			}
			if($result==1){

				// 単語帳単語データ登録が正常の場合、単語セット情報登録をする。
				$rtn = $this->resetWordbookSetWordData($org_no, $wordbook_id);
				$err_msg = I004;
				$this->smarty->assign('err_msg', $err_msg );
			}else{
				$err_msg="";
				$this->smarty->assign('err_msg', $err_msg );
			}

			$this->setBackData();
		}else {
			$err_msg = "登録するアイテムを選択してください。";
			$this->smarty->assign('err_msg', $err_msg);
		}
		$this->search();
		$this->smarty->assign ( 'form', $this->form);
		$this->smarty->display ( 'wordBookWordRegist.html' );
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		$this->form->search_org_id=$_SESSION['search_org_id'];
		$screen_name=$this->form->screen_name;
		if($screen_name=="list"){
			$this->setBackData();
			$this->dispatch('WordBookList/Search');
		}else if($screen_name=="regist"){
				$screen_mode=$this->form->screen_mode;
				if($screen_mode=="copy"){
					$wordbook_id="";
					$this->form->screen_mode="new";
				}else{
					$wordbook_id=$this->form->wordbook_id;
					$this->form->screen_mode="update";
				}
				$org_no = $this->form->org_no;
				$service = new WordBookService($this->pdo);
				$list = $service->getWordBookData($wordbook_id,$org_no);
				if ( $list != null ){
					foreach ( $list as $value ){
						$org_name_official=$value->org_name_official;
						$orgId=$value->org_id;
						$this->form->org_name_official=$org_name_official;
						$this->form->org_name=$value->org_name;
						$this->form->org_id=$orgId;
					}
				}
				$word_category=$service->getLanguage('028');
				$trans_category=$service->getLanguage('029');
				if(count($word_category)>0){
					$this->smarty->assign('word_category',$word_category);
				}else{
					$this->smarty->assign('word_category',"");
					$this->smarty->assign('err_msg',"ドロップダウンリストのデータがありません。");
				}
				if(count($trans_category)>0){
					$this->smarty->assign('trans_category',$trans_category);
				}else{
					$this->smarty->assign('trans_category',"");
					$this->smarty->assign('err_msg',"ドロップダウンリストのデータがありません。");
				}
			$this->smarty->assign('form',$this->form);	
			$this->smarty->display('wordBookRegist.html');
		}
	}

	/*
	 * 戻る場合のデータセット
	 */
	public function setBackData() {
		$_SESSION ['back_flg'] = true;
		$_SESSION ['search_page'] = $this->form->search_page;
		$_SESSION ['search_name'] = $this->form->search_name;
		$_SESSION ['search_org_id'] = $this->form->search_org_id;
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