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
require_once 'dto/T_DetailDto.php';
/**
 * T_QuestionAssignmentDAOクラス
 */

class T_QuestionAssignmentDao extends BaseDao {

	//コース詳細のよりデータを取得する
	public function getDetailData($detail_no) {

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;

		$query = " SELECT ";
		$query .= " detail.course_detail_name course_detail_name";
		$query .= " ,detail.course_detail_romaji course_detail_romaji";
		$query .= " ,detail.course_detail_no course_detail_no";
		$query .= " ,detail.status status";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=detail.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=detail.test_kbn) AS test_kbn ";
		$query .= " ,date_format(detail.start_period,'%Y/%m/%d') AS start_period";
		$query .= " ,date_format(detail.end_period,'%Y/%m/%d') AS end_period";
		$query .= " FROM T_DETAIL detail";
		$query .= " WHERE ";
		$query .= " detail.del_flg = '0' ";
		$query .= " AND detail.course_detail_no = :detail_no ";
		$query .= " ORDER BY ";
		$query .= " detail.course_detail_no ASC";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);
		$stmt->bindParam(":detail_no", $detail_no, PDO::PARAM_STR);

		$list = parent::getDataList ( $stmt, get_class ( new T_DetailDto() ) );

		return $list;
	}

	//コース詳細のよりデータを取得する
	public function getDetailInfo($detail_no) {

		$query = " SELECT ";
		$query .= " detail.course_detail_name course_detail_name";
		$query .= " ,detail.course_detail_romaji course_detail_romaji";
		$query .= " ,detail.course_detail_no course_detail_no";
		$query .= " ,detail.status status";
		$query .= " ,detail.course_level course_level";
		$query .= " ,detail.test_kbn test_kbn ";
		$query .= " ,date_format(detail.start_period,'%Y/%m/%d') AS start_period";
		$query .= " ,date_format(detail.end_period,'%Y/%m/%d') AS end_period";
		$query .= " FROM T_DETAIL detail";
		$query .= " WHERE ";
		$query .= " detail.del_flg = '0' ";
		$query .= " AND detail.course_detail_no = :detail_no ";
		$query .= " ORDER BY ";
		$query .= " detail.course_detail_no ASC";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam(":detail_no", $detail_no, PDO::PARAM_STR);

		$list = parent::getDataList ( $stmt, get_class ( new T_DetailDto() ) );

		return $list;
	}

	//コース詳細のより問題一覧を取得する
	public function getQuestionListOnDetail($param, $offset){

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$sqa_pattern = SQA_PATTERN;
		$wqa_pattern = WQA_PATTERN;
		$score_pattern = SCORE_PATTERN;
		$stest_kbn = SPEAKING_TEST_KBN;
		$wtest_kbn = WRITING_TEST_KBN;

		$query = " SELECT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,question.question_no question_no ";
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
		$query .= " ,question.sample_answer sample_answer";
		$query .= " ,question.remarks remarks";
		$query .= " ,question.byosha_point byosha_point";
		$query .= " ,question.updater_id updater_id";
		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,T_DETAIL detail ";

		$query .= " INNER JOIN T_COURSE_DETAIL_QUESTION as detail_question ";
		$query .= " ON detail.course_detail_no = detail_question.course_detail_no ";
		$query .= " INNER JOIN T_QUESTION as question ";
		$query .= " ON detail_question.question_no = question.question_no ";

		$query .= " WHERE ";

		$query .= " detail.course_detail_no = :course_detail_no ";
		$query .= " AND detail.del_flg = '0' ";
		$query .= " AND question.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " detail_question.disp_no ASC";

		$stmt = $this->pdo->prepare ( $query );
		LogHelper::logDebug($query);

		$stmt->bindParam ( ":course_detail_no", $param->course_detail_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_kbn", $test_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_level", $course_level, PDO::PARAM_STR );
		$stmt->bindParam ( ":sqa_pattern", $sqa_pattern, PDO::PARAM_STR );
		$stmt->bindParam ( ":wqa_pattern", $wqa_pattern, PDO::PARAM_STR );
		$stmt->bindParam ( ":stest_kbn", $stest_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":score_pattern", $score_pattern, PDO::PARAM_STR );

		$list= parent::getDataList( $stmt, get_class(new T_QuestionDto()) );
		return $list;
	}

	//コース詳細のよりある問題を削除する
	public function deleteExistQuestions( $course_detail_no , $pdo) {

		$query = "DELETE";
		$query .= " FROM";
		$query .= " T_COURSE_DETAIL_QUESTION";
		$query .= " WHERE";
		$query .= " course_detail_no = :course_detail_no";
		$stmt = $pdo->prepare ( $query );
		$stmt->bindParam ( ":course_detail_no", $course_detail_no, PDO::PARAM_STR );
		$stmt->execute ();
		logHelper::logDebug($stmt);
		return;
	}

	/**
	 * 入出庫ヘッダー情報新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertData($dto , $pdo){
		return parent::insertWithPdo ( $dto , $pdo);
	}
}

?>