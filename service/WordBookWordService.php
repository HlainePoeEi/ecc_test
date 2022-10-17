<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'dao/T_WordBook_WordDao.php';
require_once 'service/BaseService.php';

/*
 * 単語追加 Service
 * 
 */
class WordBookWordService extends BaseService{

	//単語リストを取得する
	public function getWordList($form,$flg) {
		$wordDao = new T_WordBook_WordDao($this->pdo );
		return $wordDao->getWordList($form,$flg);
	}

	//選択した単語を削除する
	public function deleteSelectedWord($form){
		$wordDao = new T_WordBook_WordDao($this->pdo );
		return $wordDao->deleteSelectedWord($form , $this->pdo);
	}

	//単語帳リスト
	public function wordBookList() {
		$wordDao = new T_WordBook_WordDao($this->pdo );
		return $wordDao->wordBookList();
	}

	//表示番号を取得
	public function getDisplayNo() {
		$wordDao = new T_WordBook_WordDao($this->pdo );
		return $wordDao->getDisplayNo();
	}

	//単語登録
	public function wordRegist($param) {
		$wordDao = new T_WordBook_WordDao( $this->pdo);
		return $wordDao->wordRegist($param ,$this->pdo);
	}

	//単語登録
	public function wordbookwordRegist($param) {
		$wordDao = new T_WordBook_WordDao( $this->pdo);
		return $wordDao->wordRegist($param ,$this->pdo);
	}

	//選択した単語を取得
	public function getSelectedWord($form)
	{
		$wordDao = new T_WordBook_WordDao( );
		return $wordDao->getSelectedWord($form);
	}
	
	public function getWordBookItem($wordbook_id,$org_no) {
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo);
		// 単語リストを取得
		return $wordDao->getWordBookItem($wordbook_id,$org_no);
	}

	public function saveWord($wordbook_dto){
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo);
		// 表示番号を登録する
		return $wordDao->saveWord($wordbook_dto);
	}

	public function deleteWordBookItem($org_no, $wordbook_id){
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo);
		// 単語帳の情報を削除する
		return $wordDao->deleteWordBookItem($org_no, $wordbook_id);
	}

	public function getWordBookName($wordbook_id,$org_no){
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo);
		// 単語の名前を取得する
		return $wordDao->getWordBookName($wordbook_id,$org_no);
	}

	public function countExistingWord($org_no, $wordbook_id) {
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo);
		// 単語を数える
		return $wordDao->countExistingWord($org_no, $wordbook_id);
	}
	
	public function getCopyWord($form)
    {
        $wordDao = new T_WordBook_WordDao();
        return $wordDao->getCopyWord($form);
    }
	
	public function deletewordHistory($form){
        $wordDao = new T_WordBook_WordDao($this->pdo );
        return $wordDao->deletewordHistory($form);
    }

	public function getwordNextId(){
		$dao = new T_WordBook_WordDao();
		return $dao-> getwordNextId();
	}
	
	public function delWordBookSetWord($org_no, $wordbook_id){
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo );
		// 単語履歴を削除する
		return $wordDao->delWordBookSetWord($org_no, $wordbook_id);
	}
	
	public function getWordBookWord($org_no, $wordbook_id){
		// データベース接続
		$wordDao = new T_WordBook_WordDao($this->pdo );
		// 単語履歴を削除する
		return $wordDao->getWordBookWord($org_no, $wordbook_id, $this->pdo);
	}
	
	public function insertWordBookSetList($list, $pdo){
		$dao = new T_WordBook_WordDao($this->pdo);
		
		return $dao->bulkInsertWithPdo($list , $pdo);
	}
}
?>