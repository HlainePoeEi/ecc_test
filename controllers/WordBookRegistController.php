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
require_once 'dto/T_WordBookDto.php';
require_once 'dto/T_WordDto.php';
require_once 'service/WordBookWordService.php';
require_once 'service/WordBookService.php';
require_once 'dto/T_WordBook_WordDto.php';
require_once 'util/DateUtil.php';

/**
 * 単語帳登録コントローラー
 *
 */
class WordBookRegistController extends BaseController {
	/**
	 * 初期処理
	 */
	public function indexAction() {
		if ( $this->check_login() == true ){
				$service = new WordBookService($this->pdo);
				$wordbook_id = $this->form->wordbook_id;
				$org_no = $this->form->org_no;
				$screen_mode = $this->form->screen_mode;
			
				$this->setDropDownList();
				
				// 更新処理
				if ( $wordbook_id != null && $org_no != null ){
					$today_date = DateUtil::getDate('Y/m/d');
					// 検索結果を取得
					$list = $service->getWordBookData($wordbook_id, $org_no);
					if ( $list != null ){
						foreach ( $list as $key=>$value ){
							$org_name_official=$value->org_name_official;
							$orgId=$value->org_id;
							$this->form->wordbook_id=$value->wordbook_id;
							$this->form->org_name_official=$org_name_official;
							$this->form->org_name=$value->org_name;
							$this->form->org_id=$orgId;
							$this->form->org_no = $value->org_no;
							$this->form->word_book_name = $value->name;
							$this->form->tag = $value->tag;
							$this->form->word_lang_type = $value->word_lang_type;
							$this->form->trans_lang_type = $value->trans_lang_type;
							$this->form->status =$value->status;
							$this->form->word_id =$value->word_id;
							if($screen_mode=="new"){
								$this->form->screen_mode = "new";
							}else if($screen_mode=="copy"){
								$this->form->screen_mode = "copy";
								$this->form->copy_wordbook_id=$value->wordbook_id;
								$this->form->copy_org_no=$value->org_no;
							}
							else{
								$this->form->screen_mode = "update";
							}
							$this->form->updater_id =$_SESSION['admin_no'];
							$this->form->updater_date=$today_date;
						}
					}
				}else {
					// 登録処理
							$this->form->org_name_official="";
							$this->form->org_name="";
							$this->form->word_system_kbn=$_SESSION['admin_kbn'];
							$this->form->org_no="";
							$this->form->org_id="";
							$this->form->word_book_name = "";
							$this->form->tag = "";
							$this->form->word_lang_type = "";
							$this->form->trans_lang_type = "";
							$this->form->status ="0";
							$this->form->screen_mode = "new";
							$this->form->creater_id =$_SESSION['admin_no'];
				}
				// メニュー情報を取得、セットする
				$this->setMenu();
				$this->smarty->assign('form', $this->form);
				$this->smarty->display ( 'wordBookRegist.html' );
			}else {
				TransitionHelper::sendException ( E002 );
				return;
			}
	}

	public function saveAction() {
		
			if ( $this->check_login() == true ){
				$this->setMenu();
			
				$wordBook_dto = new T_WordBookDto();
				$service = new WordBookService($this->pdo);	
				$org_id = $this->form->org_id;
				$data=$service->getAllData();
				if(count($data)==0){
					$display_no=1;
				}else if(count($data)>0){
					$max=$service->getDispNo();
					foreach($max as $m){
						$disp_no=$m->max;
					}
					$display_no=$disp_no+1;
				}
				$result=$service->getOrgData($org_id);
				//組織が存在しない場合は
				if(count($result)==0){
					$error_msg  = "入力した組織が存在しません。";
					
					// 検索結果を取得
					$list = $service->getWordBookData($this->form->wordbook_id, $this->form->org_no);
					if ( $list != null ){
						
						foreach ( $list as $key=>$value ){
							$org_name_official=$value->org_name_official;
							$orgId=$value->org_id;
							$this->form->wordbook_id=$value->wordbook_id;
							$this->form->org_name_official="";
							$this->form->org_name="";
							$this->form->org_id= $org_id;
							$this->form->org_no = "";
							$this->form->word_book_name = $value->name;
							$this->form->tag = $value->tag;
							$this->form->word_lang_type = $value->word_lang_type;
							$this->form->trans_lang_type = $value->trans_lang_type;
							$this->form->status =$value->status;
							$this->form->word_id =$value->word_id;
							if($screen_mode=="new"){
								$this->form->screen_mode = "new";
							}else if($screen_mode=="copy"){
								$this->form->screen_mode = "copy";
								$this->form->copy_wordbook_id=$value->wordbook_id;
								$this->form->copy_org_no=$value->org_no;
							}
							else{
								$this->form->screen_mode = "update";
							}

							$this->form->updater_id =$_SESSION['admin_no'];
							$this->form->updater_date=$today_date;
						}
					}
					
					$this->setDropDownList();
					
					$this->smarty->assign ('err_msg', $error_msg);
					$this->smarty->assign('form', $this->form);
					$this->smarty->display('wordBookRegist.html' );
				
				}else{
					if(count($result)==1){
						foreach($result as $d){
							$org_no=$d->org_no;
							$org_name=$d->org_name;
						}
					}
					$word_book_name=$this->form->word_book_name;
					$tag=$this->form->tag;
					$word_lang_type=$this->form->word_lang_type;
					$trans_lang_type=$this->form->trans_lang_type;
					$status = $this->form->status; 
					// 単語帳データ情報登録
					$wordBook_dto = new T_WordBookDto();
					$wordBook_dto->org_no =$org_no;
					$wordBook_dto->name = $word_book_name;
					$wordBook_dto->tag = $tag;
					$wordBook_dto->word_lang_type = $word_lang_type;
					$wordBook_dto->trans_lang_type = $trans_lang_type;
					$wordBook_dto->status = $status;
					$wordBook_dto->del_flg = 0;
					$wordBook_dto->word_system_kbn=$_SESSION['admin_kbn'];
					$wordBook_dto->disp_no=$display_no;	
					$wordBook_dto->updater_id =$_SESSION['admin_no'];
					$wordBook_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
						if ( $this->form->screen_mode == "update" ){
								$wordBook_dto->wordbook_id = $this->form->wordbook_id;
								$update_result = $service->updateWordBookInfo($wordBook_dto);
									if ( $update_result==1){
										$msg = sprintf(I003,'更新');
										$this->smarty->assign ('msg', $msg);
										$this->form->screen_mode = "update";
										$this->form->org_no = $org_no;
										$word_category = $service->getLanguage('028');
										$trans_category = $service->getLanguage('029');
										if(count($word_category)>0){
											$this->smarty->assign('word_category',$word_category);
										}else{
											$this->smarty->assign('word_category',"");
											$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
										}
										if(count($trans_category)>0){
											$this->smarty->assign('trans_category',$trans_category);
										}else{
											$this->smarty->assign('trans_category',"");
											$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
										}
									$this->smarty->assign('form', $this->form);
									$this->smarty->display ( 'wordBookRegist.html' );
									}else {
										$msg = sprintf(E007,'更新');
										$this->smarty->assign ('err_msg', $msg );
									}
						}
						else if($this->form->screen_mode == "new" || $this->form->screen_mode == "copy") {
								$wordBook_dto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
								$wordBook_dto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
								$wordBook_dto->creater_id =$_SESSION['admin_no'];
								$wordBook_dto->updater_id =$_SESSION['admin_no'];
								$previous_org_no = $this->form->copy_org_no;
								//次の単語帳IDを取得
								$next_id = $service->getNextId();
								$wordbook_id=$next_id->id;
								$this->form->wordbook_id=$wordbook_id;
								$wordBook_dto->wordbook_id=$wordbook_id;
								LogHelper::logDebug ("org no-----  : " . $org_no. COMMON_TEST_INFO_ORG );
								if($org_no != COMMON_TEST_INFO_ORG)
								{
									$wordBook_dto->word_system_kbn='002';
								}
								$result = $service->insertData($wordBook_dto);
								if ( $result==1){
									
									if($this->form->screen_mode=="copy"){
									
										$wbservice=new WordBookWordService($this->pdo);
										$word_List=$wbservice->getCopyWord($this->form);
										$wordDto=new T_WordDto();
										$wordBookWordDto=new T_WordBook_WordDto();
										if(count($word_List)>0){
											foreach($word_List as $word){
												
												$wordDto->org_no=$org_no;
												$next_id = $wbservice->getwordNextId();
												$next_word_id=$next_id->id;
												$wordDto->word_id=$next_word_id;
												
												if($org_no != COMMON_TEST_INFO_ORG)
												{
													$wordDto->word_system_kbn='002';
												}
												else
												{
													$wordDto->word_system_kbn=$word->word_system_kbn;
												}
												
												$wordDto->word=$word->word;
												$wordDto->translation=$word->translation;
												$wordDto->word_lang_type=$word->word_lang_type;
												$wordDto->trans_lang_type=$word->trans_lang_type;
												$wordDto->remarks=$word->remarks;
												$wordDto->del_flg='0';
												$wordDto->creater_id=$_SESSION['admin_no'];
												$wordDto->updater_id=$_SESSION['admin_no'];
												$wordDto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
												$wordDto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
												$wordDto->file_name = "";
												$result=$wbservice->wordRegist($wordDto);

												$wordBookWordDto->org_no=$org_no;
												$wordBookWordDto->wordbook_id=$this->form->wordbook_id;
												$wordBookWordDto->word_id=$next_word_id;
												$wordBookWordDto->disp_no=$word->disp_no;
												$wordBookWordDto->creater_id=$_SESSION['admin_no'];
												$wordBookWordDto->updater_id=$_SESSION['admin_no'];
												$wordBookWordDto->create_dt = DateUtil::getDate('Y/m/d H:i:s');
												$wordBookWordDto->update_dt = DateUtil::getDate('Y/m/d H:i:s');
												
												$result=$wbservice->wordbookwordRegist($wordBookWordDto);
											}
										}
										
									}
									$msg= I004;
									if($this->form->screen_mode=="new"){
										$this->form->screen_mode="update";
									}else{
										$this->form->screen_mode="copied";
									}
									$this->form->org_no=$org_no;
									$word_category=$service->getLanguage('028');
									$trans_category=$service->getLanguage('029');
									if(count($word_category)>0){
										$this->smarty->assign('word_category',$word_category);
									}else{
										$this->smarty->assign('word_category',"");
										$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
									}
									if(count($trans_category)>0){
										$this->smarty->assign('trans_category',$trans_category);
									}else{
										$this->smarty->assign('trans_category',"");
										$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
									}
									$this->smarty->assign ( 'msg', $msg);
									$this->smarty->assign('form', $this->form);
								}else {
									$msg  = sprintf(E007,'登録');
									$this->smarty->assign ( 'err_msg', $msg );
									}
						}
					$this->smarty->assign('form', $this->form);
					$this->smarty->display('wordBookRegist.html' );
				}
					}else {
						TransitionHelper::sendException (E002);
						return;
					}
	}

	/*
	 * 戻るボタンのAction
	 */
	public function backAction() {
		$this->setBackData();
		$this->dispatch('WordBookList/Search');
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

	public function deleteAction() {
		$wordBook_dto = new T_WordBookDto();
		$service = new WordBookService($this->pdo);
		$wordbook_id=$this->form->wordbook_id;
		$wordBook_dto->wordbook_id=$wordbook_id;
		$wordBook_dto->updater_id =$_SESSION['admin_no'];
		$wordBook_dto->update_dt = DateUtil::getDate ( 'Y/m/d H:i:s' );
		$delete_result=$service->deleteWordBook($wordBook_dto);
		if ( $delete_result==1){
			$this->setBackData();
			$this->dispatch('WordBookList/Search');
		}else {
			$msg= sprintf(E007,'削除');
			$this->smarty->assign ( 'err_msg', $msg);
			$this->smarty->assign('form', $this->form);
			$this->smarty->display ( 'wordBookRegist.html' );
			return;
		}
	}

	/**
	 * 画面上値設定処理
	 */
	public function displayValue($myForm) {
		$this->smarty->assign( 'form', $myForm );
		$this->smarty->display( 'wordBookRegist.html' );
	}

	/**
	 * 組織情報表示ボタン処理
	 */
	public function orgShowAction(){
		if ( $this->check_login() == true ){
			$service = new WordBookService($this->pdo);
			$org_id = $this->form->org_id;
			$result = $service->getOrgData($org_id);
				$word_category=$service->getLanguage('028');
				$trans_category=$service->getLanguage('029');
				if(count($word_category)>0){
					$this->smarty->assign('word_category',$word_category);
				}else{
					$this->smarty->assign('word_category',"");
					$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
				}
				if(count($trans_category)>0){
					$this->smarty->assign('trans_category',$trans_category);
				}else{
					$this->smarty->assign('trans_category',"");
					$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
				}
			if ( count($result) > 1 ){
				$this->smarty->assign( 'msg', "" );
				$this->smarty->assign( 'err_msg', E016 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else if ( count($result) == 0 ){
				$this->smarty->assign( 'info_msg', "" );
				$this->smarty->assign( 'err_msg', E015 );
				$this->form->org_name = "";
				$this->form->org_name_official = "";
				$this->displayValue($this->form);
			}else {
				$wordBook_dto = new T_WordBookDto();
				$this->smarty->assign ( 'org_name', $result[0]->org_name);
				$this->smarty->assign ( 'org_name_official', $result[0]->org_name_official);
				$this->form->org_name = $result[0]->org_name;
				$this->form->org_name_official = $result[0]->org_name_official;
				$wordBook_dto->org_name=$this->form->org_name;
				$wordBook_dto->org_name_official=$this->form->org_name_official;
				$this->displayValue($this->form);
			}
		}else {
			TransitionHelper::sendException ( E002 );
			return;
		}
	}
	
	public function setDropDownList(){
		
		$service = new WordBookService($this->pdo);
		$word_category=$service->getLanguage('028');
		$trans_category=$service->getLanguage('029');
		if(count($word_category)>0){
			$this->smarty->assign('word_category',$word_category);
		}else{
			$this->smarty->assign('word_category',"");
			$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
		}
		if(count($trans_category)>0){
			$this->smarty->assign('trans_category',$trans_category);
		}else{
			$this->smarty->assign('trans_category',"");
			$this->smarty->assign('error_msg',"ドロップダウンリストのデータがありません。");
		}
	}
}
?>
