<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_TestDto.php';
require_once 'dto/T_Test_QuizDto.php';
/**
 * T_TestDAOクラス
 */
class T_TestDao extends BaseDao {

	 public function getTestResultCount($param){
		$query = " SELECT ";
		$query .= " distinct test.test_no test_no ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,test.remarks remarks ";
		$query .= " ,test.status status ";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(test.end_period,'%Y/%m/%d') as end_period ";
		$query .= " FROM ";
		$query .= " T_TEST test ";
		$query .= " LEFT JOIN T_TEST_QUIZ as test_quiz ";
		$query .= " ON test.org_no = test_quiz.org_no ";
		$query .= " AND test.test_no = test_quiz.test_no ";
		$query .= " WHERE test.start_period <= :end_period ";
		$query .= " AND test.end_period >= :start_period ";
		$query .= " AND test.org_no = :org_no ";

		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remark)) {
			$query .= " AND (test.remarks LIKE :remark ) ";
		}

		if (! StringUtil::isEmpty($param->status)) {
			$query .= " AND test.status IN (".$param->status.") ";
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (test.updater_id=:updater_id ) ";
		}

		$query .= " AND test.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " test_name ASC";
		$query .= " ,remarks ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":start_period",$param->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $param->end_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = '%'.$param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = '%'.$param->remark.'%';
			$stmt->bindParam(":remark",$remark, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id",$param->updater_id, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_TestDto()) );
		return count($list);
	}

	public function getTestListData($param, $flg){

		$offset = ($param->page-1) * PAGE_ROW;
		$mcategory = TEST_TYPE_KBN;

		$query = " SELECT ";
		$query .= " distinct test.test_no test_no ";
		$query .= " ,test.org_no org_no ";
		$query .= " ,org.org_id org_id ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,mtype.name test_type_name ";
		$query .= " ,test.remarks remark";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(test.end_period,'%Y/%m/%d') as end_period ";
		$query .= " ,CASE WHEN test.status = 0 THEN  '非公開' ";
		$query .= " ELSE '公開' END AS status ";
		$query .= " FROM ";
		$query .= " T_TEST test ";
		$query .= " LEFT JOIN T_TEST_QUIZ as test_quiz ";
		$query .= " ON test.org_no = test_quiz.org_no ";
		$query .= " AND test.test_no = test_quiz.test_no ";
		$query .= " INNER JOIN M_TYPE mtype";
		$query .= " ON test.test_type = mtype.type ";
		$query .= " AND mtype.category = :mcategory ";
		$query .= " INNER JOIN M_ORGANIZATION as org ";
		$query .= " ON test.org_no = org.org_no ";
		$query .= " AND org.del_flg =  '0' ";
		$query .= " WHERE test.start_period <= :end_period ";
		$query .= " AND test.end_period >= :start_period ";
	//	$query .= " AND test.org_no = :org_no ";
		
		if (! StringUtil::isEmpty ( $param->search_org_id )) {
			$query .= " AND org.org_id LIKE :org_id ";
		}

		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remark)) {
			$query .= " AND (test.remarks LIKE :remark) ";
		}

		if (! StringUtil::isEmpty($param->status)) {
			$query .= " AND test.status IN (".$param->status.") ";
		}
		if (! StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (test.updater_id=:updater_id ) ";
		}

		$query .= " AND test.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " test_name ASC";
		$query .= " ,remark ASC";

		if( $flg == "1"){
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );
		
		LogHelper::logDebug($query);

		$stmt->bindParam ( ":start_period",$param->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $param->end_period, PDO::PARAM_STR );
	//	$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );
		
		if (! StringUtil::isEmpty ( $param->search_org_id )) {

			$org_id = '%' . $param->search_org_id . '%';
			$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = '%'.$param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = '%'.$param->remark.'%';
			$stmt->bindParam(":remark",$remark, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id",$param->updater_id, PDO::PARAM_STR);
		}

		return parent::getDataList( $stmt, get_class(new T_TestDto()) );

	}
/**
	 * 	選択したテスト管理№のクイズ管理№をデータベースから取得する
	 */
	public function getTestQuizDataList($test_no){

		$query = " SELECT ";
		$query .= " test_quiz.quiz_no quiz_no";
		$query .= " FROM ";
		$query .= " T_TEST_QUIZ  test_quiz ";
		$query .= " LEFT JOIN T_TEST as test ";
		$query .= " ON test.org_no = test_quiz.org_no ";
		$query .= " AND test.test_no = test_quiz.test_no ";
		$query .= " WHERE test_quiz.test_no = :test_no ";
		$query .= " AND test.del_flg = '0' ";
		$query .= " AND test_quiz.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_Test_QuizDto()) );
	}

	/*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	public function getTestInfo($org_no, $test_no){

		$mcategory = TEST_TYPE_KBN;

		$query = " SELECT ";
		$query .= " test.test_no test_no";
		$query .= " ,test.test_name test_name";
		$query .= " ,test.test_type test_type";
		$query .= " ,test.test_quiz_count test_quiz_count";
		$query .= " ,test.description description";
		$query .= " ,test.status status";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";
		$query .= " ,test.remarks remarks";
		$query .= " FROM ";
		$query .= " T_TEST test";
		$query .= " INNER JOIN M_TYPE mtype";
		$query .= " ON test.test_type = mtype.type ";
		$query .= " AND mtype.category = :mcategory ";
		$query .= " WHERE test.test_no = :test_no ";
		$query .= " AND test.org_no = :org_no ";
		$query .= " AND test.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":mcategory", $mcategory, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_TestDto()) );

	}

	/**
	 * 入出庫ヘッダー情報新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($dto){

		return parent::insert ( $dto );
	}

	/**
	 * シアイテム情報更新処理
	 *
	 * @param $dto
	 */
	public function updateTestInfo($dto){

		$query = " UPDATE ";
		$query .= " T_TEST ";
		$query .= " SET";

		if(!StringUtil::isEmpty($dto->test_type)){
			$query .= " test_type  = :test_type ";
		}

		if(!StringUtil::isEmpty($dto->test_name)){
			$query .= " ,test_name  = :test_name ";
		}

		if(!StringUtil::isEmpty($dto->test_quiz_count)){
			$query .= " ,test_quiz_count  = :test_quiz_count ";
		}

		if(!StringUtil::isEmpty($dto->description)){
			$query .= " ,description  = :description ";
		}

		if(!StringUtil::isEmpty($dto->start_period)){
			$query .= " ,start_period  = :start_period ";
		}

		if(!StringUtil::isEmpty($dto->end_period)){
			$query .= " ,end_period  = :end_period ";
		}

		if(!StringUtil::isEmpty($dto->status)){
			$query .= " ,status  = :status ";
		}

		$query .= " ,remarks  = :remarks ";
		$query .= " ,update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";

		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND test_no = :test_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		if(!StringUtil::isEmpty($dto->test_name)){
			$stmt->bindParam ( ":test_name",  $dto->test_name, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->test_type)){
			$stmt->bindParam ( ":test_type",  $dto->test_type, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->test_quiz_count)){
			$stmt->bindParam ( ":test_quiz_count",  $dto->test_quiz_count, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->description)){
			$stmt->bindParam ( ":description",  $dto->description, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->status)){
			$stmt->bindParam ( ":status",  $dto->status, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->start_period)){
			$stmt->bindParam ( ":start_period",  $dto->start_period, PDO::PARAM_STR );
		}

		if(!StringUtil::isEmpty($dto->end_period)){
			$stmt->bindParam ( ":end_period",  $dto->end_period, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );

		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no",  $dto->test_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

	/**
	 * シアイテム情報更新処理
	 *
	 * @param $dto
	 */
    public function getNextId() {

   	    return parent::getId("test_no");
    }

    /**
     * 修復チェック処理
     *
     * @param count
     */
   	public function checkedExistTestInfo($org_no, $test_no){

	   $limitedDate = DateUtil::getDate("Y/m/d h:i:s");

	   $query = " SELECT ";
	   $query .= " test.org_no org_no";
	   $query .= " FROM ";
	   $query .= " T_TEST test";
	   $query .= " WHERE";
	   $query .= " test.org_no = :org_no ";
	   $query .= " AND test.test_no = :test_no ";
	   $query .= " AND test.del_flg = '0' ";

	   $stmt = $this->pdo->prepare ( $query );

	   $stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
	   $stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );

	   $list= parent::getDataList( $stmt, get_class(new T_TestDto()) );
	   return count($list);
   }

   /*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	public function getListQuiz($org_no, $test_no){

		$query = " SELECT ";
		$query .= " testquiz.quiz_no as quiz_no";
		$query .= " ,testquiz.disp_no as disp_no";
		$query .= " FROM ";
		$query .= " T_TEST_QUIZ testquiz";
		$query .= " INNER JOIN T_TEST test";
		$query .= " ON testquiz.test_no = test.test_no ";
		$query .= " WHERE test.test_no = :test_no ";
		$query .= " AND test.org_no = :org_no ";
		$query .= " AND test.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_Test_QuizDto()) );

	}




//Test_Assignment Screen

	public function getTestCountOnLesson($param){

		$query = " SELECT ";
		$query .= "  test.test_no test_name ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,test.remarks remarks ";
		$query .= " ,test.test_type test_type ";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";

		$query .= " FROM ";
		$query .= " M_LESSON mlesson ";
		$query .= " LEFT JOIN T_LESSON_TEST as lesstest ";
		$query .= " ON mlesson.org_no = lesstest.org_no ";
		$query .= " AND mlesson.lesson_no = lesstest.lesson_no ";
		$query .= " LEFT JOIN T_TEST as test ";
		$query .= " ON mlesson.org_no = test.org_no ";
		$query .= " AND lesstest.test_no = test.test_no ";
		$query .= " LEFT JOIN M_TYPE as mtype ";
		$query .= " ON mtype.type = test.test_type ";

		$query .= " WHERE test.test_type =  '009' ";
		$query .= " AND mlesson.lesson_no = :lesson_no ";
		$query .= " AND mlesson.org_no = :org_no ";

		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (test.remarks LIKE :remarks ) ";
		}

		$query .= " AND test.del_flg = '0' ";
		$query .= " AND mlesson.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " test_name ASC";

		$stmt = $this->pdo->prepare ( $query );


		$stmt->bindParam ( ":lesson_no", $param->lesson_no, PDO::PARAM_STR );

		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = $param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remarks)) {

			$remark = $param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list= parent::getDataList( $stmt, get_class(new T_TestDto()) );
		return count($list);
	}

	public function getTestListOnLesson($param){

		$query = " SELECT ";
		$query .= "  test.test_name test_name ";
		$query .= " ,test.test_name test_name ";
		$query .= " ,test.remarks remarks ";
		$query .= " ,test.test_type test_type ";
		$query .= " ,test.test_quiz_count quiz_count";
		$query .= " ,date_format(test.start_period,"."'%Y/%m/%d') as start_period";
		$query .= " ,date_format(test.end_period,"."'%Y/%m/%d') as end_period";

		$query .= " FROM ";
		$query .= " M_LESSON mlesson ";
		$query .= " LEFT JOIN T_LESSON_TEST as lesstest ";
		$query .= " ON mlesson.org_no = lesstest.org_no ";
		$query .= " AND mlesson.lesson_no = lesstest.lesson_no ";
		$query .= " LEFT JOIN T_TEST as test ";
		$query .= " ON mlesson.org_no = test.org_no ";
		$query .= " AND lesstest.test_no = test.test_no ";
		$query .= " LEFT JOIN M_TYPE as mtype ";
		$query .= " ON mtype.type = test.test_type ";

		$query .= " WHERE test.test_type =  '009' ";
		$query .= " AND mlesson.lesson_no = :lesson_no ";

		if (! StringUtil::isEmpty($param->test_name)) {
			$query .= " AND (test.test_name LIKE :test_name) ";
		}

		if (! StringUtil::isEmpty($param->remarks)) {
			$query .= " AND (test.remarks LIKE :remarks ) ";
		}

		$query .= " AND test.del_flg = '0' ";
		$query .= " AND mlesson.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " test_name ASC";

		$stmt = $this->pdo->prepare ( $query );


		$stmt->bindParam ( ":lesson_no", $param->lesson_no, PDO::PARAM_STR );

		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );

		if (! StringUtil::isEmpty($param->test_name)) {

			$name = $param->test_name.'%';
			$stmt->bindParam(":test_name",$name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->remark)) {

			$remark = $param->remark.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		$list = parent::getDataList( $stmt, get_class(new T_TestDto()) );
		return $list;
	}
	 // テストプレビュー
	public function getListQuiz1($org_no, $test_no){

		$query = " SELECT ";
		$query .= " test.test_name test_name ";
		$query .= " ,test.description description ";
		$query .= " ,tquiz.quiz_type quiz_type ";
		$query .= " ,tquiz.answer_time answer_time ";
		$query .= " ,tquiz.quiz_content quiz_content ";
		$query .= " ,tquiz.image_name image_name ";
		$query .= " ,tquiz.audio_name audio_name ";
		$query .= " ,tquiz.correct1 correct1 ";
		$query .= " ,tquiz.correct2 correct2 ";
		$query .= " ,tquiz.incorrect1 incorrect1 ";
		$query .= " ,tquiz.incorrect2 incorrect2 ";
		$query .= " ,tquiz.incorrect3 incorrect3 ";
		$query .= " ,tquiz.hint hint ";
		$query .= " ,tquiz.explanation explanation "; // 20190708-クイズ解説追加
		$query .= " FROM ";
		$query .= " T_TEST_QUIZ testquiz";
		$query .= " INNER JOIN T_TEST test";
		$query .= " ON testquiz.test_no = test.test_no ";
		$query .= " AND test.org_no = testquiz.org_no ";
		$query .= " AND testquiz.del_flg = '0' ";
		$query .= " INNER JOIN T_QUIZ tquiz";
		$query .= " ON testquiz.quiz_no = tquiz.quiz_no ";
		$query .= " AND testquiz.org_no = tquiz.org_no ";
		$query .= " AND tquiz.del_flg = '0' ";
		$query .= " WHERE test.test_no = :test_no ";
		$query .= " AND test.org_no = :org_no ";
		$query .= " AND test.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " testquiz.disp_no ASC";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no",$org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_no", $test_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_Test_QuizDto()) );

	}
}

?>