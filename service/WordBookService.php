<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_WordBookListDao.php';
require_once 'service/BaseService.php';
require_once 'dao/T_WordBookDao.php';
/*
 *　単語帳サービス
 * 
 */
class WordBookService extends BaseService{

	public function insertData($param){
		$dao = new T_WordBookDao($this->pdo);
		return $dao-> insertData($param , $this->pdo);
	}

	public function getNextId(){
		$dao = new T_WordBookDao();
		return $dao-> getNextId();
	}


	public function getOrgData($org_id){
		$dao = new T_WordBookDao();
		return $dao-> getOrgData($org_id);
	}

	public function getWordBookListData($form, $flg){
		$dao = new T_WordBookListDao();
		return $dao-> getWordBookListData($form, $flg);
	}

	public function getWordBookData($id,$org_no){
		$dao = new T_WordBookDao();
		return $dao-> getWordBookData($id,$org_no);
	}

	public function deleteWordBook($dto)
	{
		$dao = new T_WordBookDao($this->pdo);
		return $dao-> deleteWordBook($dto);
	}

	public function updateWordBookInfo($dto)
	{
		$dao = new T_WordBookDao($this->pdo);
		return $dao-> updateWordBookInfo($dto);
	}

	public function getAllData()
	{
	//数字のためデータを取る
		$dao = new T_WordBookDao();
		return $dao-> getAllData();
	}

	public function getDispNo()
	{
	//一番大きいDisp_Noを取る
		$dao = new T_WordBookDao();
		return $dao-> getDispNo();
	}

	public function getLanguage($category)
	{
		$dao = new T_WordBookDao();
		return $dao->getLanguage($category);
	}

}
?>