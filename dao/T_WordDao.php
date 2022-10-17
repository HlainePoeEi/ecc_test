<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_WordDto.php';
require_once 'conf/config.php';
/**
 * 単語DAOクラス
 */
class T_WordDao extends BaseDao{
	/**
	 * 単語を登録する
	 *
	 */
	public function saveWord($dto, $pdo)
	{
		return parent::insertWithPdo ( $dto ,$pdo );
	}

	/**
	 * 単語言語を取得する
	 *
	 */
	public function getWordLanguage()
	{
		$query = " SELECT ";
		$query .= " category";
		$query .= " ,type";
		$query .= " ,name";
		$query .= " ,name_kana";
		$query .= " FROM ";
		$query .= " M_TYPE ";
		$query .= " WHERE category = '028' ";
		$query .= " AND del_flg = '0' ";
		$query .= " ORDER BY disp_no ASC ";
		$stmt = $this->pdo->prepare($query);
		return parent::getDataList($stmt, get_class(new T_WordDto()));
	}

	/**
	 * 訳言語を取得する
	 *
	 */
	public function getTranslationLanguage()
	{
		$query = " SELECT ";
		$query .= " category";
		$query .= " ,type";
		$query .= " ,name";
		$query .= " ,name_kana";
		$query .= " FROM ";
		$query .= " M_TYPE ";
		$query .= " WHERE category = '029' ";
		$query .= " AND del_flg = '0' ";
		$query .= " ORDER BY disp_no ASC ";
		$stmt = $this->pdo->prepare($query);
		return parent::getDataList($stmt, get_class(new T_WordDto()));
	}

	/**
	 * 単語№を取得する
	 *
	 */
	public function getNextId()
	{
		return parent::getId('word_id');
	}

	/**
	 * 単語リストを取得する
	 *
	 */
	public function getWordListData($param, $flg)
	{
		$query = $this->createQuery();
		$query .= $this->createSearchWhere($param);
		$stmt = $this->pdo->prepare($query);
		$this->setSearchParam($stmt, $param);
		return parent::getDataList($stmt, get_class(new T_WordDto()));
	}

	/**
	 * 	単語リストのSQLを作成する
	 *
	 */
	public function createQuery()
	{
		$query = " SELECT ";
		$query .= " t_word.org_no org_no ";
		$query .= " ,t_word.word_id word_id ";
		$query .= " ,t_word.word_system_kbn word_system_kbn ";
		$query .= " ,t_word.word word ";
		$query .= " ,t_word.translation translation ";
		$query .= " ,t_word.file_name file_name ";
		$query .= " ,t_word.word_lang_type word_lang_type ";
		$query .= " ,t_word.trans_lang_type trans_lang_type ";
		$query .= " ,t_word.create_dt create_dt ";
		$query .= " ,t_word.creater_id creater_id ";
		$query .= " ,t_word.update_dt update_dt ";
		$query .= " ,t_word.updater_id updater_id ";
		$query .= " ,m_organization.org_id org_id ";
		$query .= " FROM ";
		$query .= " T_WORD t_word ";
		$query .= " LEFT JOIN M_TYPE as type ";
		$query .= " ON t_word.word_system_kbn = type.type ";
		$query .= " AND type.del_flg =  '0' ";
		$query .= " INNER JOIN M_ORGANIZATION m_organization ";
		$query .= " ON t_word.org_no = m_organization.org_no ";
		$query .= " AND m_organization.del_flg =  '0' ";
		return $query;
	}

	/**
	 * 単語リストのSQL検索を作成する
	 *
	 */
	public function createSearchWhere($param)
	{
		$query = " WHERE ";
		$query .= " type.category = :word_category ";
		$query .= " AND (t_word.word_system_kbn = '001' or t_word.word_system_kbn = '002') ";
		$query .= " AND t_word.del_flg = '0' ";
		if (! StringUtil::isEmpty ( $param->search_org_id )) {
			$query .= " AND m_organization.org_id LIKE :org_id ";
		}
		if (!StringUtil::isEmpty($param->word)) {
			$query .= " AND (t_word.word LIKE :word ) ";
		}
		$query .= " ORDER BY ";
		$query .= " t_word.word_id DESC";
		return $query;
	}

	/**
	 * パラメータバインド
	 *
	 */
	public function setSearchParam($stmt, $param)
	{
		$word_category = WORD_CATEG_KBN;
		$stmt->bindParam(":word_category", $word_category, PDO::PARAM_STR);
		if (!StringUtil::isEmpty($param->search_org_id)) {
			$org_id = '%' . $param->search_org_id. '%';
			$stmt->bindParam(":org_id", $org_id, PDO::PARAM_STR);
		}
		if (!StringUtil::isEmpty($param->word)) {
			$word = '%' . $param->word . '%';
			$stmt->bindParam(":word", $word, PDO::PARAM_STR);
		}
	}

	/**
	 * 単語データを取得する
	 *
	 */
	public function getWordData($org_no, $word_id)
	{
		$query = " SELECT w.org_no,";
		$query .= " w.word_id, w.word_system_kbn, ";
		$query .= " w.word, w.word_lang_type, ";
		$query .= " w.trans_lang_type,";
		$query .= " w.translation,";
		$query .= " w.file_name,";
		$query .= " w.remarks,";
		$query .= " w.org_no,";
		$query .= " w.create_dt,w.creater_id,";
		$query .= " w.update_dt,w.updater_id ";
		$query .= " FROM T_WORD w";
		$query .= " WHERE w.word_id=:word_id";
		$query .= " AND w.org_no =:org_no ";
		$query .= " AND w.del_flg = '0' ";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":word_id", $word_id, PDO::PARAM_STR);
		return parent::getDataList($stmt, get_class(new T_WordDto()));
	}

	/**
	 * 単語データを更新する
	 *
	 */
	public function updateWordInfo($dto)
	{
		$query = " UPDATE ";
		$query .= " T_WORD ";
		$query .= " SET";
		$query .= "  word  = :word ";
		$query .= " ,org_no   = :org_no ";
		$query .= " ,translation   = :translation ";
		$query .= " ,word_lang_type   = :word_lang_type ";
		$query .= " ,trans_lang_type   = :trans_lang_type ";
		$query .= " ,file_name  = :file_name ";
		$query .= " ,remarks  = :remarks ";
		if (!StringUtil::isEmpty($dto->update_dt)) {
			$query .= " ,update_dt = :update_dt";
		}
		if (!StringUtil::isEmpty($dto->updater_id)) {
			$query .= " ,updater_id = :updater_id ";
		}
		$query .= " WHERE ";
		$query .= " word_id = :word_id ";
		$query .= " AND del_flg = '0' ";
		$stmt = $this->pdo->prepare($query);
		if (!StringUtil::isEmpty($dto->update_dt)) {
			$stmt->bindParam(":update_dt", $dto->update_dt, PDO::PARAM_STR);
		}
		if (!StringUtil::isEmpty($dto->updater_id)) {
			$stmt->bindParam(":updater_id", $dto->updater_id, PDO::PARAM_STR);
		}
		$stmt->bindParam(":word", $dto->word, PDO::PARAM_STR);
		$stmt->bindParam(":org_no", $dto->org_no, PDO::PARAM_STR);
		$stmt->bindParam(":translation", $dto->translation, PDO::PARAM_STR);
		$stmt->bindParam(":word_lang_type", $dto->word_lang_type, PDO::PARAM_STR);
		$stmt->bindParam(":trans_lang_type", $dto->trans_lang_type, PDO::PARAM_STR);
		$stmt->bindParam(":remarks", $dto->remarks, PDO::PARAM_STR);
		$stmt->bindParam(":file_name", $dto->file_name, PDO::PARAM_STR);
		$stmt->bindParam(":word_id", $dto->word_id, PDO::PARAM_STR);
		return parent::update($stmt);
	}

	/**
	 * 単語データを削除する
	 *
	 */
	public function deleteWordInfo($dto)
	{
		$query = " UPDATE ";
		$query .= " T_WORD ";
		$query .= " SET";
		$query .= " del_flg   = '1' ";
		$query .= " ,update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";
		$query .= " WHERE ";
		$query .= " word_id = :word_id ";
		$query .= " AND del_flg = '0' ";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":update_dt", $dto->update_dt, PDO::PARAM_STR);
		$stmt->bindParam(":updater_id", $dto->updater_id, PDO::PARAM_STR);
		$stmt->bindParam(":word_id", $dto->word_id, PDO::PARAM_STR);
		return parent::update($stmt);
	}
}
?>