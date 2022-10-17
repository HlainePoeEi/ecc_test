<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_WordBook_WordDto.php';
require_once 'dto/T_Word_HistoryDto.php';
require_once 'dto/T_WordBook_Set_WordDto.php';
/*
 * 単語追加 Dao
 * 
 */
class T_WordBook_WordDao extends BaseDao {
	//単語リストを取得する
	public function getWordList($param,$flg) {
	
		$query = $this->createQuery();
		$query .= $this->createSearchWhere($param);
		$stmt = $this->pdo->prepare ( $query );
		LogHelper::logDebug('unselected'.$query);
		$stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);
		$this->setSearchParam($stmt, $param);
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}

	public function createQuery(){
        $query = "SELECT ";
    	$query .= " tw.org_no";
		$query .= " ,tw.word_id ";
		$query .= " ,tw.word ";
		$query .= " ,tw.translation ";
		$query .= " FROM T_WORD as tw ";
		return $query;
		}

	public function createSearchWhere ( $param ){
		$query = " WHERE "; 
		$query .= " tw.org_no=:org_no ";
		$query .= " AND tw.del_flg ='0' ";
		if ( ! StringUtil::isEmpty($param->word) ){
			$query .= " AND (tw.word LIKE :word ) ";
		}
		$query .= " ORDER BY ";
		$query .= " tw.org_no,tw.word_id ASC";
		return $query;
	}

	public function setSearchParam($stmt, $param){
		if ( ! StringUtil::isEmpty($param->word) ){
		$word =  '%'.$param->word.'%';
		$stmt->bindParam(":word", $word, PDO::PARAM_STR);
		}
	}

	//選択した単語を削除する
	public function deleteSelectedWord($form , $pdo){
		$query = "DELETE ";
		$query .= " FROM T_WORDBOOK_WORD ";
		$query .= " WHERE ";
		$query .= " org_no = :org_no AND";
		$query .= " wordbook_id = :wordbook_id";
		$query .= " AND del_flg = '0'";
		$stmt = $pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $form->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":wordbook_id", $form->wordbook_id, PDO::PARAM_STR );
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}

	//単語帳リスト
	public function wordBookList(){
		$query = "SELECT ";
		$query .= " tw.disp_no ";
		$query .= " FROM T_WORDBOOK_WORD as tw ";
		$query .= " WHERE tw.del_flg = '0'";
		$stmt = $this->pdo->prepare ( $query );
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}

	//表示番号を取得
	public function getDisplayNo(){
		$query = "SELECT ";
		$query .= " MAX(DISP_NO) AS disp_no ";
		$query .= " FROM T_WORDBOOK_WORD as t_wbook ";
		$query .= " WHERE t_wbook.del_flg = '0'";
		$stmt = $this->pdo->prepare ( $query );
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}

	//単語登録
	public function wordRegist($dto , $pdo) {
		return parent::insertWithPdo ( $dto , $pdo);
	}

	//単語登録
	public function wordbookwordRegist($dto , $pdo) {
		return parent::insertWithPdo ( $dto , $pdo);
	}

	public function getSelectedWord($form){
		$query = "SELECT DISTINCT";
		$query .= " twb.word_id ";
		$query .= " ,tw.word ";
		$query .= " ,tw.translation ";
		$query .= " ,twb.disp_no ";
		$query .= " FROM T_WORDBOOK_WORD as twb ";
		$query .= " LEFT JOIN T_WORD as tw ";
		$query .= " ON twb.org_no=tw.org_no ";
		$query .= " AND twb.word_id = tw.word_id ";
		$query .= " LEFT JOIN T_WORDBOOK as wb ";
		$query .= " ON twb.org_no=wb.org_no ";
		$query .= " AND twb.wordbook_id=wb.wordbook_id ";
		$query .= " WHERE ";
		$query .= " twb.org_no = :org_no AND";
		$query .= " twb.wordbook_id = :wordbook_id";
		$stmt = $this->pdo->prepare ( $query );
		if (! StringUtil::isEmpty ( $form->org_no )) {
			$stmt->bindParam ( ":org_no", $form->org_no, PDO::PARAM_STR );
			$stmt->bindParam ( ":wordbook_id", $form->wordbook_id, PDO::PARAM_STR );
		}
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}
	
	/**
	 * 単語リストを取得する
	 *
	 */
	public function getWordBookItem($wordbook_id,$org_no) {
		$query = "SELECT ";
		$query .= " t_book.disp_no ";
		$query .= " ,t_book.word_id ";
		$query .= " ,t_word.word ";
		$query .= " ,t_word.translation ";
		$query .= " FROM T_WORDBOOK_WORD as t_book ";
		$query .= " JOIN T_WORD as t_word ON ";
		$query .= " t_book.word_id = t_word.word_id ";
		$query .= " WHERE ";
		$query .= " t_book.org_no=:org_no  ";
		$query .= " AND t_book.wordbook_id=:wordbook_id ";
		$query .= " AND t_book.del_flg = '0' ";
		$query .= " GROUP BY t_book.disp_no, t_book.word_id ,t_word.word ,t_word.translation ";
		$query .= " ORDER BY t_book.disp_no ASC ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":wordbook_id", $wordbook_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList ( $stmt, get_class ( new T_WordBook_WordDto() ) );
	}

	/**
	 * 表示番号を登録する
	 *
	 */
	public function saveWord($wordbook_dto){
		return parent::insert($wordbook_dto);
	}

	/**
	 * 単語帳の情報を削除する
	 *
	 */
	public function deleteWordBookItem($org_no, $wordbook_id){
		$query = "DELETE";
		$query .= " FROM";
		$query .= " T_WORDBOOK_WORD";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND wordbook_id = :wordbook_id";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":wordbook_id", $wordbook_id, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

	/**
	 * 単語帳の情報を削除する
	 *
	 */
	public function getWordBookName($wordbook_id,$org_no){
		$query = "SELECT ";
		$query .= " t_book.name ";
		$query .= " FROM T_WORDBOOK as t_book ";
		$query .= " WHERE ";
		$query .= " t_book.org_no=:org_no ";
		$query .= " AND t_book.wordbook_id=:wordbook_id ";
		$query .= " AND t_book.del_flg = '0' ";
		$query .= " GROUP BY t_book.name ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":wordbook_id", $wordbook_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList ( $stmt, get_class ( new T_WordBook_WordDto() ) );
	}

	/**
	 * 単語を数える
	 *
	 */
	public function countExistingWord($org_no, $wordbook_id) {
		$query = " SELECT";
		$query .= " count(word_id)";
		$query .= " FROM";
		$query .= " T_WORDBOOK_WORD";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND wordbook_id = :wordbook_id";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":wordbook_id", $wordbook_id, PDO::PARAM_STR );
		$stmt->execute ();
		return $stmt->fetchColumn ();
	}
	
	public function getCopyWord($form){
		$query = "SELECT DISTINCT";
		$query .= " tw.word_id ";
		$query .= " ,tw.word_system_kbn ";
		$query .= " ,tw.word ";
		$query .= " ,tw.translation ";
		$query .= " ,tw.word_lang_type ";
		$query .= " ,tw.trans_lang_type ";
		$query .= " ,tw.remarks ";
		$query .= " ,tw.file_name ";
		$query .= " ,twb.disp_no ";
		$query .= " FROM T_WORDBOOK_WORD as twb ";
		$query .= " LEFT JOIN T_WORD as tw ";
		$query .= " ON ";
		$query .= " twb.word_id = tw.word_id ";
		$query .= " LEFT JOIN T_WORDBOOK as wb ";
		$query .= " ON twb.org_no=wb.org_no ";
		$query .= " AND twb.wordbook_id=wb.wordbook_id ";
		$query .= " WHERE ";
		$query .= " twb.org_no = :org_no AND";
		$query .= " twb.wordbook_id = :wordbook_id";
		
		LogHelper::logDebug('word copy ------'.$query);
		LogHelper::logDebug('seleted ------'.$form->copy_org_no.$form->copy_wordbook_id);
		$stmt = $this->pdo->prepare ( $query );
			$stmt->bindParam ( ":org_no", $form->copy_org_no, PDO::PARAM_STR );
			$stmt->bindParam ( ":wordbook_id", $form->copy_wordbook_id, PDO::PARAM_STR );
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}
	
	public function deletewordHistory($form){
        $query = " UPDATE ";
        $query .= " T_WORD_HISTORY ";
        $query .= " SET ";
        $query .= " del_flg='1' ";
        $query .= " WHERE ";
        $query .= " org_no =:org_no ";
        $query .= " AND wordbook_id =:wordbook_id ";
		$query .= " AND word_id =:word_id ";
        $stmt = $this->pdo->prepare ( $query );
        LogHelper::logDebug($query);
        $stmt->bindParam ( ":org_no", $form->org_no, PDO::PARAM_STR );
        $stmt->bindParam ( ":wordbook_id", $form->wordbook_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":word_id", $form->word_id, PDO::PARAM_STR );
        return parent::getDataList($stmt, get_class (new T_Word_HistoryDto()) );
    }
	
	public function getwordNextId() {
		return parent::getId("word_id");
 	}
	
	/*
	/ 単語セット情報登録
	/
	*/
	public function getWordBookWord($org_no, $wordbook_id , $pdo){
		
		$query = "  SELECT wbw.org_no, wbw.wordbook_id ,wbw.word_id, wbw.disp_no  ";
		$query .= " , @rownum := @rownum + 1 as row_no ";
		$query .= " ,LEFT(LPAD(@rownum -1   , 5, '0'),length(LPAD(@rownum-1 , 5, '0'))-1) +1  as set_no ";
		$query .= " ,wbw.del_flg, wbw.create_dt , wbw.creater_id , wbw.update_dt, wbw.updater_id  ";
		$query .= " FROM T_WORDBOOK_WORD wbw  ";
		$query .= " INNER JOIN T_WORD AS word  ";
		$query .= " ON wbw.org_no = word.org_no  ";
		$query .= " AND wbw.word_id = word.word_id  ";
		$query .= " AND word.del_flg = '0' "; 
		$query .= " INNER JOIN(SELECT @rownum := 0) r  "; 
		$query .= " WHERE ";
		$query .= " wbw.org_no =:org_no ";
		$query .= " AND wbw.wordbook_id =:wordbook_id ";
		$query .= " ORDER BY org_no,wordbook_id,disp_no ";
	
		$stmt = $pdo->prepare($query);
		
		$stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":wordbook_id", $wordbook_id, PDO::PARAM_STR);

		return parent::getDataList($stmt, get_class (new T_WordBook_Set_WordDto()) );
	}
	
	/*
	/ 単語セット情報削除
	/
	*/
	public function delWordBookSetWord($org_no, $wordbook_id){
		
		$query = "DELETE ";
		$query .= " FROM T_WORDBOOK_SET_WORD ";
		$query .= " WHERE ";
		$query .= " org_no =:org_no ";
		$query .= " AND wordbook_id =:wordbook_id";

		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":wordbook_id", $wordbook_id, PDO::PARAM_STR );
		
		return parent::update($stmt);
	}
	
	//単語帳リスト
	public function getWordBookListByWord($org_no , $word_id){
		
		$query = "SELECT ";
		$query .= " tw.org_no ";
		$query .= " ,tw.wordbook_id ";
		$query .= " ,tw.word_id ";
		$query .= " ,tw.disp_no ";
		$query .= " FROM T_WORDBOOK_WORD as tw ";
		$query .= " WHERE tw.del_flg = '0'";
		$query .= " AND tw.word_id = :word_id ";
		$query .= " AND tw.org_no = :org_no ";
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":word_id", $word_id, PDO::PARAM_STR );
		
		return parent::getDataList($stmt, get_class(new T_WordBook_WordDto()) );
	}
	
	/**
	 * 単語帳単語情報を削除する
	 *
	 */
	public function deleteWordBookWordByWord($org_no, $word_id){
		$query = "DELETE";
		$query .= " FROM";
		$query .= " T_WORDBOOK_WORD";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND word_id = :word_id";
		
		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":word_id", $word_id, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}
}	
?>