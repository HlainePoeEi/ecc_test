<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Quiz_InfoDto.php';

/**
 * T_Quiz_InfoDaoクラス
 */
class T_Quiz_InfoDao extends BaseDao {

	public function getQuizResultCount($param){

		$query = " SELECT ";
		$query .= " distinct quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz ";
		$query .= " WHERE quiz.org_no = :org_no ";

		if (! StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (! StringUtil::isEmpty($param->long_description)) {
			$query .= " AND (quiz.long_description LIKE :long_description ) ";
		}

		if (! StringUtil::isEmpty($param->remark)) {
			$query .= " AND (quiz.remarks LIKE :remark ) ";
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (quiz.updater_id=:updater_id ) ";
		}

		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " quiz_name ASC";
		$query .= " ,long_description ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->long_description)) {

			$long_description = '%'.$param->long_description.'%';
			$stmt->bindParam(":long_description",$long_description, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = '%'.$param->remark.'%';
			$stmt->bindParam(":remark",$remark, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id",$param->updater_id, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_Quiz_InfoDto()) );
		logHelper::logDebug("count of quiz list"  . count($list));
		return count($list);
	}

	public function getQuizListData($param, $flg){

		$offset = ($param->page-1) * PAGE_ROW;

		$query = " SELECT ";
		$query .= " distinct quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " ,org.org_no org_no ";
		$query .= " ,org.org_id org_id ";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz ";
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= " ON quiz.org_no = org.org_no ";
		$query .= " AND org.del_flg =  '0' ";
		
	//	$query .= " WHERE quiz.org_no = :org_no ";
		$query .= " WHERE 1 = 1 ";
		
		if (! StringUtil::isEmpty ( $param->search_org_id )) {
			$query .= " AND org.org_id LIKE :org_id ";
		}

		if (! StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (! StringUtil::isEmpty($param->long_description)) {
			$query .= " AND (quiz.long_description LIKE :long_description ) ";
		}

		if (! StringUtil::isEmpty($param->remark)) {
			$query .= " AND (quiz.remarks LIKE :remark ) ";
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (quiz.updater_id=:updater_id ) ";
		}

		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " quiz_name ASC";
		$query .= " ,long_description ASC";

		if( $flg == "1"){
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );

	//	$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		
		if (! StringUtil::isEmpty ( $param->search_org_id )) {

			$org_id = '%' . $param->search_org_id . '%';
			$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty($param->quiz_name)) {

			$name = '%'.$param->quiz_name.'%';
			$stmt->bindParam(":quiz_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->long_description)) {

			$long_description = '%'.$param->long_description.'%';
			$stmt->bindParam(":long_description",$long_description, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = '%'.$param->remark.'%';
			$stmt->bindParam(":remark",$remark, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id",$param->updater_id, PDO::PARAM_STR);
		}

		return parent::getDataList( $stmt, get_class(new T_Quiz_InfoDto()) );

	}

	/**
	 * 更新画面のため、データ取得処理
	 *
	 * @param unknown $form
	 * @return string
	 */
	public function getQuizDataByQuizNo($form){

		$query = " SELECT ";
		$query .= " quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " ,quiz.audio_name audio_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz ";
		$query .= " WHERE quiz.del_flg = '0' ";

		if (! StringUtil::isEmpty ( $form->org_no )) {
			$query .= "AND quiz.org_no = :org_no ";
		}

		if (! StringUtil::isEmpty ( $form->quiz_info_no)) {
			$query .= "AND quiz.quiz_info_no = :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare ( $query );


		if (! StringUtil::isEmpty ( $form->org_no )) {
			$stmt->bindParam ( ":org_no", $form->org_no, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $form->quiz_info_no )) {
			$stmt->bindParam ( ":quiz_info_no", $form->quiz_info_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_Quiz_InfoDto() ) );
	}

	public function saveQuiz($dto){

		return parent::insert ( $dto );

	}

	public function saveTestQuiz($dto){

		return parent::insert ( $dto );

	}

	public function getNext() {

		return parent::getId("quiz_info_no");
	}

	public function updateQuizInfo($dto){

		$query = " UPDATE ";
		$query .= " T_QUIZ_INFO ";
		$query .= " SET";
		$query .= " quiz_name   = :quiz_name ";
		$query .= " ,long_description   = :long_description ";
		$query .= " ,remarks  = :remarks ";

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
		$query .= " AND quiz_info_no = :quiz_info_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		if(!StringUtil::isEmpty($dto->long_description)){
			$stmt->bindParam ( ":long_description",  $dto->long_description, PDO::PARAM_STR );
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
		$stmt->bindParam ( ":long_description",  $dto->long_description, PDO::PARAM_STR );
		$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_info_no",  $dto->quiz_info_no, PDO::PARAM_STR );

		loghelper::logdebug($query);
		return parent::update ( $stmt);
	}

	public function deleteQuizInfo($dto){

		$query = " UPDATE ";
		$query .= " T_QUIZ_INFO ";
		$query .= " SET";
		$query .= " del_flg   = '1' ";
		$query .= " ,update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";
		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND quiz_info_no = :quiz_info_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_info_no",  $dto->quiz_info_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

	/**
	 * クイズ名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($org_no, $quiz_info_no, $quiz_name) {

		$query = " SELECT ";
		$query .= " quiz.quiz_info_no";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz";
		$query .= " WHERE quiz.org_no = :org_no ";
		$query .= " AND quiz.quiz_name = :quiz_name ";
		$query .= " AND quiz.del_flg = '0' ";

		if (!StringUtil::isEmpty($quiz_info_no)){
			$query .= " AND quiz.quiz_info_no != :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":quiz_name", $quiz_name, PDO::PARAM_STR );

		if (!StringUtil::isEmpty($org_no)){

			$stmt->bindParam ( ":org_no",  $org_no, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($quiz_info_no)){

			$stmt->bindParam ( ":quiz_info_no",  $quiz_info_no, PDO::PARAM_STR );
		}


		$list= parent::getDataList( $stmt, get_class(new T_Quiz_InfoDto()) );
		return count( $list );
	}
	
	public function getQuizDataByQuizNoDisable($orgNo, $quizInfoNo){

		$query .= " SELECT  testquiz.quiz_info_no quiz_info_no   ";
		$query .= " FROM  T_LESSON_TEST_INFO lessontest   ";
		$query .= " INNER JOIN T_TEST_INFO_QUIZ testquiz ";
		$query .= " ON lessontest.org_no = testquiz.org_no ";
		$query .= " AND lessontest.test_info_no = testquiz.test_info_no ";
		$query .= " AND testquiz.del_flg = '0'  ";
		$query .= " WHERE lessontest.org_no = :org_no  ";
		$query .= " AND lessontest.del_flg = '0'  ";
		$query .= " AND testquiz.quiz_info_no = :quiz_info_no "; 

		LogHelper::logDebug ( "getQuizDataByQuizNoDisable Query : ". $query );
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $orgNo, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_info_no", $quizInfoNo, PDO::PARAM_STR );

		$list = parent::getDataList ( $stmt, get_class ( new T_Quiz_InfoDto() ) );
		LogHelper::logDebug ( "------------------list------------".count($list) );
		return count($list);
		
	}
	
	
	/**
	 * 更新画面のため、データ取得処理
	 *
	 * @param unknown $form
	 * @return string
	 */
	public function getQuizData($org_no , $quiz_info_no){

		$query = " SELECT ";
		$query .= " quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " ,quiz.audio_name audio_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz ";
		$query .= " WHERE quiz.del_flg = '0' ";

		if (! StringUtil::isEmpty ( $org_no )) {
			$query .= "AND quiz.org_no = :org_no ";
		}

		if (! StringUtil::isEmpty ( $quiz_info_no)) {
			$query .= "AND quiz.quiz_info_no = :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare ( $query );


		if (! StringUtil::isEmpty ( $org_no )) {
			$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $quiz_info_no )) {
			$stmt->bindParam ( ":quiz_info_no", $quiz_info_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_Quiz_InfoDto() ) );
	}

}

?>