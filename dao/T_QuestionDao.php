<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_QuestionDto.php';
require_once 'dto/M_TypeDto.php';

/**
 * T_QuestionDAOクラス
 */
class T_QuestionDao extends BaseDao {

	/*
	 * 一覧画面の初期表示をデータベースから取得する
	 */
	public function getQuestionListData($param, $flg) {

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$sqa_pattern = SQA_PATTERN;
		$wqa_pattern = WQA_PATTERN;
		$score_pattern = SCORE_PATTERN;
		$stest_kbn = SPEAKING_TEST_KBN;
		$wtest_kbn = WRITING_TEST_KBN;
		$offset = ($param->page-1) * PAGE_ROW;

		$query = " SELECT";
		$query .= " question.question_no question_no ";
		$query .= " ,question.question_name question_name ";
		$query .= " ,question.qa_description qa_description ";
		$query .= " ,question.description description ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=question.test_kbn) AS test_kbn ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=question.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE a.type=question.qa_pattern AND CASE WHEN question.test_kbn = :stest_kbn THEN a.category=:sqa_pattern ELSE a.category=:wqa_pattern END) AS qa_pattern ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:score_pattern AND a.type=question.score_pattern) AS score_pattern ";
		$query .= " ,question.audio_name audio_name ";
		$query .= " ,question.audio_description audio_description ";
		$query .= " ,question.prepare_time prepare_time ";
		$query .= " ,question.answer_time answer_time ";
		$query .= " ,question.audio_yes audio_yes";
		$query .= " ,question.yes_description yes_description";
		$query .= " ,question.audio_no audio_no";
		$query .= " ,question.no_description no_description";
		$query .= " ,CASE WHEN question.status = 0 THEN '非公開' ";
		$query .= " ELSE '公開' END AS status ";
		$query .= " ,question.sample_answer sample_answer ";
		$query .= " ,question.remarks remarks";
		$query .= " ,question.sample_answer sample_answer ";
		$query .= " ,question.updater_id updater_id";

		$query .= " FROM ";
		$query .= " T_QUESTION question ";
		$query .= " WHERE ";

		if (! StringUtil::isEmpty($param->question_name)){
			$query .= " (question.question_name LIKE :param_question_name) AND";
		}
		logHelper::logDebug($param);
		if (! StringUtil::isEmpty($param->search_test_kbn) && ($param->search_test_kbn!= '')){
			$query .= " (question.test_kbn IN (".$param->search_test_kbn.")) AND";
		}

		if (! StringUtil::isEmpty($param->search_course_level) && ($param->search_course_level!= '')){
			$query .= " (question.course_level IN (".$param->search_course_level.")) AND";
		}

		if (! StringUtil::isEmpty($param->status)){
			$query .= " question.status IN (".$param->status.") AND ";
		}

		$query .= " question.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " question_name ASC";

		if ( $flg == "1"){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}
		$stmt = $this->pdo->prepare ( $query );
		if (! StringUtil::isEmpty($param->question_name)){
			$name = '%'.$param->question_name.'%';
			$stmt->bindParam(":param_question_name",$name, PDO::PARAM_STR);
		}

		$stmt->bindParam ( ":test_kbn", $test_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_level", $course_level, PDO::PARAM_STR );
		$stmt->bindParam ( ":sqa_pattern", $sqa_pattern, PDO::PARAM_STR );
		$stmt->bindParam ( ":wqa_pattern", $wqa_pattern, PDO::PARAM_STR );
		$stmt->bindParam ( ":stest_kbn", $stest_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":score_pattern", $score_pattern, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_QuestionDto()) );

	}

	/*
	 * 登録画面の初期表示をデータベースから取得する
	 */
	public function getQuestionInfo($question_no) {

		$query = " SELECT ";
		$query .= " question.question_no question_no";
		$query .= " ,question.question_name question_name ";
		$query .= " ,question.qa_description qa_description ";
		$query .= " ,question.description description ";
		$query .= " ,question.test_kbn test_kbn ";
		$query .= " ,question.course_level course_level ";
		$query .= " ,question.qa_pattern qa_pattern ";
		$query .= " ,question.score_pattern score_pattern ";
		$query .= " ,question.audio_name audio_name ";
		$query .= " ,question.audio_description audio_description ";
		$query .= " ,question.prepare_time prepare_time ";
		$query .= " ,question.answer_time answer_time ";
		$query .= " ,question.audio_yes audio_yes";
		$query .= " ,question.yes_description yes_description";
		$query .= " ,question.audio_no audio_no";
		$query .= " ,question.no_description no_description";
		$query .= " ,CASE WHEN question.status = 0 THEN '非公開' ";
		$query .= " ELSE '公開' END AS status ";
		$query .= " ,question.sample_answer sample_answer";
		$query .= " ,question.byosha_point byosha_point";
		$query .= " ,question.remarks remarks";
		$query .= " ,question.updater_id updater_id";
		$query .= " FROM ";
		$query .= " T_QUESTION question";
		$query .= " WHERE question.question_no = :question_no ";
		$query .= " AND question.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":question_no", $question_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_QuestionDto()) );

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
	 * 問題情報更新処理
	 *
	 * @param $dto
	 */
	public function updateQuestionInfo($dto) {

		$query = " UPDATE ";
		$query .= " T_QUESTION ";
		$query .= " SET";

		if (!StringUtil::isEmpty($dto->test_kbn)){
			$query .= " test_kbn = :test_kbn ";
		}

		if (!StringUtil::isEmpty($dto->question_name)){
			$query .= " ,question_name = :question_name ";
		}

		$query .= " ,qa_description  = :qa_description ";
		$query .= " ,description = :description ";

		if (!StringUtil::isEmpty($dto->course_level)){
			$query .= " ,course_level = :course_level ";
		}

		if (!StringUtil::isEmpty($dto->qa_pattern)){
			$query .= " ,qa_pattern = :qa_pattern ";
		}

		if (!StringUtil::isEmpty($dto->score_pattern)){
			$query .= " ,score_pattern = :score_pattern ";
		}

		$query .= " ,audio_name = :audio_name ";
		$query .= " ,audio_description = :audio_description ";
		$query .= " ,prepare_time = :prepare_time ";

		if (!StringUtil::isEmpty($dto->answer_time)){
			$query .= " ,answer_time = :answer_time ";
		}

		$query .= " ,audio_yes = :audio_yes ";
		$query .= " ,yes_description = :yes_description ";
		$query .= " ,audio_no = :audio_no ";
		$query .= " ,no_description = :no_description ";

		if (!StringUtil::isEmpty($dto->status)){
			$query .= " ,status = :status ";
		}

		$query .= " ,sample_answer = :sample_answer ";
		$query .= " ,byosha_point = :byosha_point ";
		$query .= " ,remarks = :remarks ";
		$query .= " ,update_dt = :update_dt ";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE ";
		$query .= " question_no = :question_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		if (!StringUtil::isEmpty($dto->question_name)){
			$stmt->bindParam ( ":question_name", $dto->question_name, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":qa_description", $dto->qa_description, PDO::PARAM_STR );
		$stmt->bindParam ( ":description", $dto->description, PDO::PARAM_STR );

		if (!StringUtil::isEmpty($dto->test_kbn)){
			$stmt->bindParam ( ":test_kbn", $dto->test_kbn, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->course_level)){
			$stmt->bindParam ( ":course_level", $dto->course_level, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->qa_pattern)){
			$stmt->bindParam ( ":qa_pattern", $dto->qa_pattern, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->score_pattern)){
			$stmt->bindParam ( ":score_pattern", $dto->score_pattern, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":audio_name", $dto->audio_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":audio_description", $dto->audio_description, PDO::PARAM_STR );
		$stmt->bindParam ( ":prepare_time", $dto->prepare_time, PDO::PARAM_STR );

		if (!StringUtil::isEmpty($dto->answer_time)){
			$stmt->bindParam ( ":answer_time", $dto->answer_time, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":audio_yes", $dto->audio_yes, PDO::PARAM_STR );
		$stmt->bindParam ( ":yes_description", $dto->yes_description, PDO::PARAM_STR );
		$stmt->bindParam ( ":audio_no", $dto->audio_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":no_description", $dto->no_description, PDO::PARAM_STR );

		if (!StringUtil::isEmpty($dto->status)){
			$stmt->bindParam ( ":status", $dto->status, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":sample_answer", $dto->sample_answer, PDO::PARAM_STR );
		$stmt->bindParam ( ":byosha_point", $dto->byosha_point, PDO::PARAM_STR );
		$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":question_no",  $dto->question_no, PDO::PARAM_STR );

		return parent::update ( $stmt );
	}

	/**
	 * 次の問題番号を取得処理
	 *
	 * @param $dto
	 */
	public function getNextId() {

		return parent::getId("question_no");

	}

	//問題を削除する
	public function deleteQuestion($dto) {

		$query = " UPDATE ";
		$query .= " T_QUESTION ";
		$query .= " SET";
		$query .= " del_flg = '1' ";
		$query .= " ,update_dt = :update_dt ";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE ";
		$query .= " question_no = :question_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":question_no", $dto->question_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

	public function getQuestionDetailListData($param){

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$score_pattern = SCORE_PATTERN;

		if($param->search_test_kbn_type == 001){
			$pattern = SQA_PATTERN;
		}else{
			$pattern = WQA_PATTERN;
		}
		$query = "SELECT";
		$query .= " DISTINCT question.question_no AS question_no";
		$query .= " ,course_detail_question.disp_no AS disp_no";
		$query .= " ,question.question_name AS question_name";
		$query .= " ,question.qa_description AS question_description";
		$query .= " ,question.description AS description";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category = :question_pattern AND a.type = question.qa_pattern) AS q_pattern ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:score1_pattern AND a.type=question.score_pattern) AS sc_pattern ";
		$query .= " ,question.audio_name AS audio_name";
		$query .= " ,question.audio_description AS audio_description";
		$query .= " ,question.prepare_time AS prepare_time";
		$query .= " ,question.answer_time AS answer_time";
		$query .= " ,question.audio_yes AS audio_yes";
		$query .= " ,question.yes_description AS yes_description";
		$query .= " ,question.audio_no AS audio_no";
		$query .= " ,question.no_description AS no_description";
		$query .= " ,question.sample_answer AS sample_answer";
		$query .= " ,question.byosha_point AS byosha_point";

		$query .= " FROM T_COURSE AS course";
		$query .= " INNER JOIN T_COURSE_DETAIL AS course_detail";
		$query .= " ON course.course_id = course_detail.course_id";

		$query .= " INNER JOIN T_COURSE_DETAIL_QUESTION AS course_detail_question";
		$query .= " ON course_detail.course_detail_no = course_detail_question.course_detail_no";
		$query .= " INNER JOIN T_QUESTION AS question";
		$query .= " ON course_detail_question.question_no = question.question_no";

		$query .= " INNER JOIN M_TYPE AS M_TYPE1";
		$query .= " ON course.course_level = M_TYPE1.type";
		$query .= " INNER JOIN M_TYPE AS M_TYPE2";
		$query .= " ON course.test_kbn = M_TYPE2.type";

		$query .= " INNER JOIN M_TYPE AS M_TYPE3";
		$query .= " ON question.score_pattern = M_TYPE3.type";
		$query .= " INNER JOIN M_TYPE AS M_TYPE4";
		$query .= " ON question.qa_pattern = M_TYPE4.type";

		$query .= " WHERE course.course_id = :course_id";
		$query .= " AND M_TYPE1.category = :course_level";
		$query .= " AND M_TYPE2.category = :test_kbn";
		$query .= " AND course_detail.course_detail_no = :course_detail_no";
		$query .= " AND question.qa_pattern = M_TYPE4.type";
		$query .= " AND M_TYPE4.category = :pattern";
		$query .= " AND question.score_pattern = M_TYPE3.type";
		$query .= " AND M_TYPE3.category = :score_pattern";
		$query .= " AND course.del_flg = 0";
		$query .= " AND course_detail.del_flg = 0";
		$query .= " AND course_detail_question.del_flg =0";
		$query .= " AND question.del_flg =0";
		$query .= " AND M_TYPE1.del_flg = 0";
		$query .= " ORDER BY course_detail_question.disp_no ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":course_id", $param->search_course_id,  PDO::PARAM_STR );
		$stmt->bindParam ( ":course_level", $course_level,  PDO::PARAM_STR );
		$stmt->bindParam ( ":test_kbn", $test_kbn,  PDO::PARAM_STR );
		$stmt->bindParam ( ":course_detail_no", $param->search_course_detail_no,  PDO::PARAM_STR );
		$stmt->bindParam ( ":score_pattern", $score_pattern,  PDO::PARAM_STR );
		$stmt->bindParam ( ":pattern", $pattern,  PDO::PARAM_STR );
		$stmt->bindParam ( ":question_pattern", $pattern,  PDO::PARAM_STR );
		$stmt->bindParam ( ":score1_pattern", $score_pattern,  PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_QuestionDto()) );
	}
}

?>