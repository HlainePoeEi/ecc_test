<?php
/*****************************************************
 *	株式会社ECC 新商品開発プロジェクト
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_WordBookDto.php';
require_once 'dto/M_OrganizationDto.php';
/**
 * T_WordBookDAOクラス
 * 
 */
class T_WordBookDao extends BaseDao {
	/**
	 * 入出庫ヘッダー情報新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($dto , $pdo){
		return parent::insertWithPdo ( $dto , $pdo );
	}

	/**
	 * 
	 *	@param $dto
	 */
	public function getNextId() {
		return parent::getId("wordbook_id");
	}
	
	/**
	 * 
	 *	@param $dto
	 */
	public function getwordNextId() {
		return parent::getId("word_id");
	}

	 //組織IDによって組織データを取る
	public function getOrgData($org_id){
		$query = " SELECT ";
		$query .= " org_no,org_name,org_name_official";
		$query .= " FROM ";
		$query .= " M_ORGANIZATION";
		$query .= " WHERE";
		$query .= " org_id = :org_id ";
		$query .= " AND del_flg = '0' ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		return parent::getDataList($stmt, get_class(new T_WordBookDto()));
	}

	//数字のため単語帳のデータを取る
	public function getAllData(){
		$query = " SELECT ";
		$query .= " *";
		$query .= " FROM ";
		$query .= " T_WORDBOOK";
		$stmt = $this->pdo->prepare ( $query );
		return parent::getDataList($stmt, get_class(new T_WordBookDto()));
	}

	//表示順番を取る
	public function getDispNo(){
		$query = " SELECT ";
		$query .= " MAX(disp_no) as max";
		$query .= " FROM ";
		$query .= " T_WORDBOOK";
		$stmt = $this->pdo->prepare ( $query );
		return parent::getDataList($stmt, get_class(new T_WordBookDto()));
	}

	//単語帳のデータを取る
	public function getWordBookData($id, $org_no){
		$query = " SELECT wb.org_no,";
		$query .= " wb.wordbook_id, wb.word_system_kbn, wb.tag,";
		$query .= " wb.name, wb.word_lang_type, ";
		$query .= " wb.trans_lang_type,";
		$query .= " wb.status,wb.disp_no,wb.del_flg,";
		$query .= " wb.create_dt,wb.creater_id,";
		$query .= " wb.update_dt,wb.updater_id, ";
		$query .= " org.org_name,org.org_id ,";
		$query .= " org.org_name_official,";
		$query .= " wbw.word_id";
		$query .= " FROM T_WORDBOOK wb";
		$query .= " Inner Join M_ORGANIZATION org ";
		$query .= " ON wb.org_no=org.org_no ";
		$query .= " AND org.org_no=:org_no";
		$query .= " Left Join T_WORDBOOK_WORD  wbw ";
		$query .= " ON wb.org_no=wbw.org_no ";
		$query .= " AND wb.wordbook_id=wbw.wordbook_id";
		$query .= " WHERE wb.wordbook_id=:id";
		$query .= " AND wb.del_flg = '0' ";
		$query .= " AND org.del_flg = '0' ";
		$stmt = $this->pdo->prepare ( $query );
		LogHelper::logDebug($query);
		$stmt->bindParam ( ":id", $id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_WordBookDto()));
	}

	//単語帳を更新する
	public function updateWordBookInfo($dto)
	{
		$query = " UPDATE T_WORDBOOK ";
		$query .= " SET update_dt = :update_dt";
		$query .= ",updater_id=:update_id ";
		
		if (! StringUtil::isEmpty ( $dto->tag)) {
			$query .= " ,tag=:tag";
		}else{
			$query .= " ,tag = NULL";
		}
		
		if (! StringUtil::isEmpty ( $dto->name)) {
		$query .= " ,name=:name";
		}
		if (! StringUtil::isEmpty ( $dto->word_lang_type)) {
			$query .= " ,word_lang_type=:word_lang_type";
		}
		if (! StringUtil::isEmpty ( $dto->trans_lang_type)) {
			$query .= " ,trans_lang_type=:trans_lang_type ";
		}
		if (! StringUtil::isEmpty ( $dto->status)) {
			$query .= " ,status=:status ";
		}
		
		$query .= " WHERE";
		$query .= " org_no=:org_no";
		$query .= " AND wordbook_id = :wordbook_id ";
		$query .= " And del_flg = '0' ";
		
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_id", $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":wordbook_id", $dto->wordbook_id, PDO::PARAM_STR );
		
		if (! StringUtil::isEmpty ( $dto->tag)) {
			$stmt->bindParam ( ":tag", $dto->tag, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->name)) {
			$stmt->bindParam ( ":name", $dto->name, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->word_lang_type)) {
			$stmt->bindParam ( ":word_lang_type", $dto->word_lang_type, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->trans_lang_type)) {
			$stmt->bindParam ( ":trans_lang_type", $dto->trans_lang_type, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->status)) {
			$stmt->bindParam ( ":status", $dto->status, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	public function deleteWordBook($dto)
	{
		$query = " UPDATE T_WORDBOOK";
		$query .= " SET del_flg='1'";
		$query .= ",update_dt = :update_dt";
		$query .= " ,updater_id=:update_id ";
		$query .= " WHERE ";
		$query .= "wordbook_id = :wordbook_id ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":wordbook_id",$dto->wordbook_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_id", $dto->updater_id, PDO::PARAM_STR );
		return parent::update ( $stmt );
	}

	//言語データを取る
	public function getLanguage($category)
	{
		$query = " SELECT";
		$query .= " name,category,type";
		$query .= " FROM ";
		$query .= " M_TYPE m_type";
		$query .= " WHERE ";
		$query .= " m_type.category=:category";
		$query .= " ORDER BY m_type.disp_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam (":category",$category, PDO::PARAM_STR);
		return parent::getDataList( $stmt, get_class(new T_WordBookDto()));
	}
}

?>