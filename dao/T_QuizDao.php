<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';

require_once 'dto/T_QuizDto.php';
require_once 'dto/M_TypeDto.php';
/**
 * T_QuizDAOクラス
 */
class T_QuizDao extends BaseDao {

	  public function getQuizResultCount($param){

	  	$quiz_category = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= " distinct quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.quiz_content quiz_content ";
		$query .= " ,type.name name ";
		$query .= " FROM ";
		$query .= " T_QUIZ quiz ";
		$query .= " LEFT JOIN M_TYPE as type ";
		$query .= " ON quiz.quiz_type=type.type ";
		$query .= " WHERE quiz.org_no = :org_no ";

		if (! StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (! StringUtil::isEmpty($param->quiz_content)) {
			$query .= " AND (quiz.quiz_content LIKE :quiz_content ) ";
		}

		if (! StringUtil::isEmpty($param->remark)) {
			$query .= " AND (quiz.remarks LIKE :remark ) ";
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (quiz.updater_id=:updater_id ) ";
		}

		$query .= " AND type.category = :quiz_category  ";
		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " quiz_name ASC";
		$query .= " ,quiz_content ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_category", $quiz_category, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->quiz_content)) {

			$quiz_content = '%'.$param->quiz_content.'%';
			$stmt->bindParam(":quiz_content",$quiz_content, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = '%'.$param->remark.'%';
			$stmt->bindParam(":remark",$remark, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id",$param->updater_id, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_QuizDto()) );
		return count($list);
	}

	public function getQuizListData($param, $flg){

		$quiz_category = QUIZ_CATEG_KBN;

		$offset = ($param->page-1) * PAGE_ROW;

		$query = " SELECT ";
		$query .= " distinct quiz.quiz_no quiz_no ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,org.org_no org_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.quiz_content quiz_content ";
		$query .= " ,type.name name ";
		$query .= " FROM ";
		$query .= " T_QUIZ quiz ";
		$query .= " LEFT JOIN M_TYPE as type ";
		$query .= " ON quiz.quiz_type=type.type ";
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= " ON quiz.org_no = org.org_no ";
		$query .= " AND org.del_flg =  '0' ";
		$query .= " WHERE 1 = 1 ";

		if (! StringUtil::isEmpty ( $param->search_org_id )) {
			$query .= " AND org.org_id LIKE :org_id ";
		}

		if (! StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (! StringUtil::isEmpty($param->quiz_content)) {
			$query .= " AND (quiz.quiz_content LIKE :quiz_content ) ";
		}

		if (! StringUtil::isEmpty($param->remark)) {
			$query .= " AND (quiz.remarks LIKE :remark ) ";
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (quiz.updater_id=:updater_id ) ";
		}

		$query .= " AND type.category = :quiz_category ";
		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " quiz_name ASC";
		$query .= " ,quiz_content ASC";

		if( $flg == "1"){
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":quiz_category", $quiz_category, PDO::PARAM_STR );

		if (! StringUtil::isEmpty ( $param->search_org_id )) {

			$org_id = '%' . $param->search_org_id . '%';
			$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		}
		
		if (! StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->quiz_content)) {

			$quiz_content = '%'.$param->quiz_content.'%';
			$stmt->bindParam(":quiz_content",$quiz_content, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = '%'.$param->remark.'%';
			$stmt->bindParam(":remark",$remark, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id",$param->updater_id, PDO::PARAM_STR);
		}

		return parent::getDataList( $stmt, get_class(new T_QuizDto()) );

	}

	/**
	 * 更新画面のため、データ取得処理
	 *
	 * @param unknown $form
	 * @return string
	 */
	public function getQuizDataByQuizNo($form){

		$quiz_category = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= " quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.quiz_type quiz_type ";
		$query .= " ,quiz.answer_time answer_time";
		$query .= " ,quiz.quiz_content quiz_content ";
		$query .= " ,quiz.image_name image_name ";
		$query .= " ,quiz.audio_name audio_name ";
		$query .= " ,quiz.correct1 correct1 ";
		$query .= " ,quiz.correct2 correct2 ";
		$query .= " ,quiz.incorrect1 incorrect1 ";
		$query .= " ,quiz.incorrect2 incorrect2 ";
		$query .= " ,quiz.incorrect3 incorrect3 ";
		$query .= " ,quiz.hint hint ";
		$query .= " ,quiz.explanation explanation ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,type.name type_name ";
		$query .= " FROM ";
		$query .= " T_QUIZ quiz ";
		$query .= " LEFT JOIN M_TYPE as type ";
		$query .= " ON quiz.quiz_type=type.type ";
		$query .= " WHERE type.category = :quiz_category ";
		$query .= "	AND quiz.del_flg = '0'  ";

		if (! StringUtil::isEmpty ( $form->org_no )) {
			$query .= "AND quiz.org_no = :org_no ";
		}

		if (! StringUtil::isEmpty ( $form->quiz_no)) {
			$query .= "AND quiz.quiz_no = :quiz_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":quiz_category", $quiz_category, PDO::PARAM_STR );

		if (! StringUtil::isEmpty ( $form->org_no )) {
			$stmt->bindParam ( ":org_no", $form->org_no, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $form->quiz_no )) {
			$stmt->bindParam ( ":quiz_no", $form->quiz_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_QuizDto() ) );
	}

	public function saveQuiz($dto){

		return parent::insert ( $dto );

	}

	public function saveTestQuiz($dto){

		return parent::insert ( $dto );

	}

	public function getNextId() {

		return parent::getId("quiz_no");
	}

	public function updateQuizInfo($dto){

		$query = " UPDATE ";
		$query .= " T_QUIZ ";
		$query .= " SET";
		$query .= " quiz_name   = :quiz_name ";
		$query .= " ,quiz_type   = :quiz_type ";
		$query .= " ,answer_time   = :answer_time ";
		$query .= " ,correct1   = :correct1 ";
		$query .= " ,correct2  = :correct2 ";
		$query .= " ,incorrect1  = :incorrect1 ";
		$query .= " ,incorrect2  = :incorrect2 ";
		$query .= " ,incorrect3  = :incorrect3 ";
		$query .= " ,hint  = :hint ";
		$query .= " ,explanation  = :explanation ";
		$query .= " ,remarks  = :remarks ";

		if(!StringUtil::isEmpty($dto->quiz_content)){
			$query .= " ,quiz_content  = :quiz_content ";
		}

		if(!StringUtil::isEmpty($dto->image_name)){
			$query .= " ,image_name  =  :image_name ";
		} else {
			$query .= " ,image_name  =  '' ";
		}

		if(!StringUtil::isEmpty($dto->audio_name)){
			$query .= " ,audio_name  =  :audio_name ";
		} else {
			$query .= " ,audio_name  =  '' ";
		}

		if (! StringUtil::isEmpty ( $dto->update_dt )) {
			$query .= " ,update_dt = :update_dt";
		}
		if (! StringUtil::isEmpty ( $dto->updater_id )) {
			$query .= " ,updater_id = :updater_id ";
		}

		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND quiz_no = :quiz_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		if(!StringUtil::isEmpty($dto->quiz_content)){
			$stmt->bindParam ( ":quiz_content",  $dto->quiz_content, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->image_name)){
			$stmt->bindParam ( ":image_name",  $dto->image_name, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->audio_name)){
			$stmt->bindParam ( ":audio_name",  $dto->audio_name, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $dto->update_dt )) {
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->updater_id )) {
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":quiz_name",  $dto->quiz_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_type",  $dto->quiz_type, PDO::PARAM_STR );
		$stmt->bindParam ( ":answer_time",  $dto->answer_time, PDO::PARAM_STR );
		$stmt->bindParam ( ":correct1",  $dto->correct1, PDO::PARAM_STR );
		$stmt->bindParam ( ":correct2",  $dto->correct2, PDO::PARAM_STR );
		$stmt->bindParam ( ":incorrect1",  $dto->incorrect1, PDO::PARAM_STR );
		$stmt->bindParam ( ":incorrect2",  $dto->incorrect2, PDO::PARAM_STR );
		$stmt->bindParam ( ":incorrect3",  $dto->incorrect3, PDO::PARAM_STR );
		$stmt->bindParam ( ":hint",  $dto->hint, PDO::PARAM_STR );
		$stmt->bindParam ( ":explanation",  $dto->explanation, PDO::PARAM_STR );
		$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_no",  $dto->quiz_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

	public function deleteQuizInfo($dto){

		$query = " UPDATE ";
		$query .= " T_QUIZ ";
		$query .= " SET";
		$query .= " del_flg   = '1' ";
		$query .= " ,update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";
		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND quiz_no = :quiz_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_no",  $dto->quiz_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

	/**
	 * クイズ名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($org_no, $quiz_no, $quiz_name) {

		$query = " SELECT ";
		$query .= " quiz.quiz_no";
		$query .= " FROM ";
		$query .= " T_QUIZ quiz";
		$query .= " WHERE quiz.org_no = :org_no ";
		$query .= " AND quiz.quiz_name = :quiz_name ";
		$query .= " AND quiz.del_flg = '0' ";

		if (!StringUtil::isEmpty($quiz_no)){
			$query .= " AND quiz.quiz_no != :quiz_no ";
		}

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":quiz_name", $quiz_name, PDO::PARAM_STR );

		if (!StringUtil::isEmpty($org_no)){

			$stmt->bindParam ( ":org_no",  $org_no, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($quiz_no)){

			$stmt->bindParam ( ":quiz_no",  $quiz_no, PDO::PARAM_STR );
		}

		$list= parent::getDataList( $stmt, get_class(new T_QuizDto()) );

		return count( $list );
	}
	
	/**
	 * 更新画面のため、データ取得処理
	 *
	 * @param unknown $form
	 * @return string
	 */
	public function getQuizData($org_no , $quiz_no ){

		$quiz_category = QUIZ_CATEG_KBN;

		$query = " SELECT ";
		$query .= " quiz.quiz_no quiz_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.quiz_type quiz_type ";
		$query .= " ,quiz.answer_time answer_time";
		$query .= " ,quiz.quiz_content quiz_content ";
		$query .= " ,quiz.image_name image_name ";
		$query .= " ,quiz.audio_name audio_name ";
		$query .= " ,quiz.correct1 correct1 ";
		$query .= " ,quiz.correct2 correct2 ";
		$query .= " ,quiz.incorrect1 incorrect1 ";
		$query .= " ,quiz.incorrect2 incorrect2 ";
		$query .= " ,quiz.incorrect3 incorrect3 ";
		$query .= " ,quiz.hint hint ";
		$query .= " ,quiz.explanation explanation ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " ,type.name type_name ";
		$query .= " FROM ";
		$query .= " T_QUIZ quiz ";
		$query .= " LEFT JOIN M_TYPE as type ";
		$query .= " ON quiz.quiz_type=type.type ";
		$query .= " WHERE type.category = :quiz_category ";
		$query .= "	AND quiz.del_flg = '0'  ";

		if (! StringUtil::isEmpty ( $org_no )) {
			$query .= "AND quiz.org_no = :org_no ";
		}

		if (! StringUtil::isEmpty ( $quiz_no)) {
			$query .= "AND quiz.quiz_no = :quiz_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":quiz_category", $quiz_category, PDO::PARAM_STR );

		if (! StringUtil::isEmpty ( $org_no )) {
			$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $quiz_no )) {
			$stmt->bindParam ( ":quiz_no", $quiz_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_QuizDto() ) );
	}
}

?>