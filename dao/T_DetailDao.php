<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_DetailDto.php';

/**
 * T詳細DAOクラス
 */
class T_DetailDao extends BaseDao {

	/**
	 * Writingテストのためコースデータを取得する
	 *
	 */
	public function getWritingData($course_detail_no) {

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");
		$query = " Select tquestion.qa_description ";
		$query .= " ,tquestion.description ";
		$query .= " ,tquestion.question_no ";
		$query .= " ,tcoursedetailquestion.course_detail_no ";
		$query .= " ,tquestion.answer_time ";
		$query .= " From T_DETAIL tdetail ";
		$query .= " INNER JOIN T_COURSE_DETAIL_QUESTION tcoursedetailquestion ";
		$query .= " ON tdetail.course_detail_no = tcoursedetailquestion.course_detail_no ";
		$query .= " AND tcoursedetailquestion.del_flg = 0 ";
		$query .= " INNER JOIN T_QUESTION tquestion ";
		$query .= " ON tcoursedetailquestion.question_no = tquestion.question_no ";
		$query .= " AND tquestion.del_flg = 0 ";
		$query .= " AND tquestion.test_kbn = tdetail.test_kbn ";
		$query .= " WHERE tdetail.course_detail_no = :course_detail_no ";
		$query .= " AND tdetail.del_flg = '0' ";
		$query .= " AND :sysDate BETWEEN tdetail.start_period AND tdetail.end_period ";
		$query .= " AND tdetail.status = 1 ";
		$query .= " ORDER BY tcoursedetailquestion.disp_no ASC ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":course_detail_no", $course_detail_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":sysDate", $sysDate, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_DetailDto()) );
	}

	/**
	 *  Speakingテストのためデータを取得する
	 *
	 */
	public function getSpeakingQuestion($course_detail_no) {

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");

		$query = " SELECT detail.course_detail_no ";
		$query .= " ,detail.course_detail_name ";
		$query .= " ,detail.course_level ";
		$query .= " ,ques.question_no ";
		$query .= " ,ques.qa_description ";
		$query .= " ,REPLACE(CONVERT(ques.description USING utf8),'\"','\\\\\"') description ";
		$query .= " ,ques.qa_description ";
		$query .= " ,ques.test_kbn ";
		$query .= " ,ques.qa_pattern ";
		$query .= " ,ques.audio_name ";
		$query .= " ,ques.audio_description ";
		$query .= " ,ques.prepare_time ";
		$query .= " ,ques.answer_time ";
		$query .= " ,ques.audio_yes ";
		$query .= " ,ques.yes_description ";
		$query .= " ,ques.audio_no ";
		$query .= " ,ques.no_description ";
		$query .= " ,ques.sample_answer ";
		$query .= " ,ques.byosha_point ";
		$query .= " ,ques.remarks ";
		$query .= " FROM T_DETAIL detail ";
		$query .= " INNER JOIN T_COURSE_DETAIL_QUESTION course_detail_ques ";
		$query .= " ON detail.course_detail_no = course_detail_ques.course_detail_no ";
		$query .= " AND course_detail_ques.del_flg = 0 ";
		$query .= " INNER JOIN T_QUESTION ques ";
		$query .= " ON course_detail_ques.question_no = ques.question_no ";
		$query .= " AND detail.test_kbn = ques.test_kbn ";
		$query .= " AND ques.del_flg = 0 ";
		$query .= " WHERE detail.del_flg = 0 ";
		$query .= " AND ques.status = 1 ";
		$query .= " AND detail.status = 1 ";
		$query .= " AND :sysDate BETWEEN detail.start_period AND detail.end_period ";
		$query .= " AND detail.course_detail_no = :course_detail_no ";
		$query .= " ORDER BY course_detail_ques.disp_no ASC ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":course_detail_no", $course_detail_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":sysDate", $sysDate, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new T_DetailDto()) );
	}

	/**
	 * FeedBack画面用データ取得処理
	 *
	 */
	public function getWritingFeedbackData($org_no, $student_no, $course_id, $course_detail_no, $offer_no, $test_kbn) {

		$query = " SELECT ";
		$query .= " course.course_id ";
		$query .= " ,course.test_kbn ";
		$query .= " ,cou_detail.course_detail_no ";
		$query .= " ,cou_detail.disp_no ";
		$query .= " ,student_mark.rule_no ";
		$query .= " ,student_mark.offer_no ";
		$query .= " ,student_mark.sub_rule_no ";
		$query .= " ,student_mark.rule_detail_no ";
		$query .= " ,student_mark.result_kbn ";
		$query .= " ,student_mark.audio_name ";
		$query .= " ,student_mark.result_mark detail_result_marks  ";
		$query .= " ,student_rule_total_marks.total_marks rule_result_marks ";
		$query .= " ,sub_rule_marks.total_marks detail_total_marks ";
		$query .= " ,rule_marks.total_marks rule_total_marks ";
		$query .= " ,detail.course_detail_name ";
		$query .= " ,course.course_name course_name ";
		$query .= " ,REPLACE(REPLACE(REPLACE(CONVERT(ques.sample_answer USING utf8),'\"','\\\\\"'),'\r\n','<br />'),'\n','<br />') sample_answer ";
		$query .= " ,REPLACE(REPLACE(REPLACE(CONVERT(ques.byosha_point USING utf8),'\"','\\\\\"'),'\r\n','<br />'),'\n','<br />') byosha_point ";
		$query .= " ,stu.student_no ";
		$query .= " ,org.org_name as org_name ";//組織名
		$query .= " ,stu.login_id as stu_login_in ";//ログインID
		$query .= " ,stu.student_name as student_name ";//氏名
		$query .= " ,ques.question_no ";
		$query .= " ,student_mark.description description";
		$query .= " ,student_mark.reply_comment reply_comment ";
		$query .= " ,student_mark.sub_description sub_description ";
		$query .= " ,REPLACE(CONVERT(student_mark.answer_contents USING utf8),'\"','\\\\\"') answer_contents ";
		$query .= " ,student_mark.result_answer result_answer ";
		$query .= " ,date_format(student_mark.answer_dt,'%Y年%m月%d日') as answer_dt ";
		$query .= " ,cou_ques.disp_no ";//20190417 FB画面で問題表示修正
		// YES/NO どちらを選んだか表示 2019/11/25
		$query .= " ,student_mark.answer_flg ";
		$query .= " FROM T_STUDENT stu ";
		$query .= " INNER JOIN T_COURSE_STUDENT cstu ";
		$query .= " ON stu.student_no = cstu.student_no ";
		$query .= " AND stu.org_no = cstu.org_no ";
		$query .= " AND cstu.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE course ";
		$query .= " ON cstu.course_id = course.course_id ";
		$query .= " AND course.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE_ORG co ";
		$query .= " ON course.course_id = co.course_id ";
		$query .= " AND stu.org_no = co.org_no ";
		$query .= " AND co.offer_no = cstu.offer_no ";
		$query .= " AND co.del_flg = '0' ";
		$query .= " INNER JOIN M_ORGANIZATION org ";
		$query .= " ON org.org_no=co.org_no ";
		$query .= " AND org.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE_DETAIL cou_detail ";
		$query .= " ON course.course_id = cou_detail.course_id ";
		$query .= " AND cou_detail.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE_DETAIL_QUESTION cou_ques ";
		$query .= " ON cou_detail.course_detail_no = cou_ques.course_detail_no ";
		$query .= " AND cou_ques.del_flg= '0' ";
		$query .= " INNER JOIN T_QUESTION ques ";
		$query .= " ON cou_ques.question_no = ques.question_no ";
		$query .= " AND ques.del_flg= '0' ";
		$query .= " INNER JOIN T_DETAIL detail ";
		$query .= " ON cou_detail.course_detail_no = detail.course_detail_no ";
		$query .= " AND detail.del_flg = '0' ";
		$query .= " LEFT JOIN (   SELECT  skill_result.offer_no ";
		$query .= "  			,skill_result.course_id ";
		$query .= "  			,skill_result.course_detail_no ";
		$query .= "  			,skill_answer.answer_dt answer_dt ";
		$query .= "  			,skill_answer.answer_contents answer_contents ";
		$query .= "  			,skill_result_detail.result_answer result_answer ";
		$query .= "  			,skill_result.student_no student_no ";
		$query .= "  			,skill_result.question_no ";
		$query .= "  			,skill_answer.audio_name ";
		// YES/NO どちらを選んだか表示 2019/11/25
		$query .= "  			,skill_answer.answer_flg ";
		$query .= "  			,sub_rule.rule_no ";
		$query .= "  			,sub_rule.sub_rule_no ";
		$query .= "  			,m_detail.rule_detail_no ";
		$query .= "  			,m_detail.result_kbn ";
		$query .= "  			,mark_rule.description ";
		$query .= "  			,sub_rule.description sub_description ";
		$query .= "  			,REPLACE(CONVERT(m_detail.reply_comment USING utf8),'\"','\\\\\"') reply_comment ";
		$query .= "  			,m_detail.marks result_mark ";
		$query .= "  			,SUM(m_detail.marks) marks ";
		$query .= "  			,skill_result_detail.result_no ";
		$query .= "  			FROM T_4SKILL_RESULT  skill_result ";
		$query .= "  			INNER JOIN T_4SKILL_RESULT_DETAIL skill_result_detail ";
		$query .= "  			ON skill_result.result_no = skill_result_detail.result_no ";
		$query .= "  			INNER JOIN M_MARK_RULE mark_rule ";
		$query .= "  			ON skill_result_detail.rule_no = mark_rule.rule_no ";
		$query .= "  			INNER JOIN M_MARK_SUB_RULE sub_rule ";
		$query .= "  			ON mark_rule.rule_no = sub_rule.rule_no ";
		$query .= "  			AND skill_result_detail.rule_no = sub_rule.rule_no ";
		$query .= "  			AND skill_result_detail.sub_rule_no = sub_rule.sub_rule_no ";
		$query .= "  			INNER JOIN M_MARK_DETAIL m_detail ";
		$query .= "  			ON skill_result_detail.rule_no = m_detail.rule_no ";
		$query .= "  			AND skill_result_detail.sub_rule_no = m_detail.sub_rule_no ";
		$query .= "  			AND skill_result_detail.rule_detail_no = m_detail.rule_detail_no ";
		$query .= "  			LEFT JOIN T_4SKILL_ANSWER skill_answer  ";
		$query .= "  			ON skill_answer.offer_no = skill_result.offer_no ";
		$query .= "  			AND skill_answer.course_id = skill_result.course_id ";
		$query .= "  			AND skill_answer.course_detail_no = skill_result.course_detail_no ";
		$query .= "  			AND skill_answer.question_no = skill_result.question_no ";
		$query .= "  			AND skill_answer.student_no = skill_result.student_no ";
		$query .= "  			GROUP BY  skill_result.offer_no ,skill_result.course_id ,skill_result.course_detail_no ";
		$query .= "  			,skill_answer.answer_dt ,skill_answer.answer_contents ";
		$query .= "  			,skill_result_detail.result_answer ,skill_result.student_no ";
		$query .= "  			,skill_result.question_no ,sub_rule.rule_no ,sub_rule.sub_rule_no ";
		$query .= "  			,m_detail.rule_detail_no ";
		$query .= "  			,mark_rule.description ,sub_rule.description ,m_detail.description ";
		$query .= "  			,m_detail.marks, skill_result_detail.result_no ";
		$query .= "  			) as student_mark ";
		$query .= " ON course.course_id = student_mark.course_id ";
		$query .= " AND cou_detail.course_detail_no = student_mark.course_detail_no ";
		$query .= " AND cou_detail.course_id = student_mark.course_id ";
		$query .= " AND detail.course_detail_no = student_mark.course_detail_no ";
		$query .= " AND ques.question_no = student_mark.question_no ";
		$query .= " AND co.offer_no = student_mark.offer_no ";
		$query .= " AND stu.student_no = student_mark.student_no ";
		$query .= " INNER JOIN( ";
		$query .= "  	SELECT  rule_no ,sub_rule_no ";
		$query .= "  	,SUM(max_marks) total_marks ";
		$query .= "  	FROM(  SELECT m_detail.rule_no rule_no ";
		$query .= "  			,m_detail.sub_rule_no sub_rule_no ";
		$query .= "  			,MAX(m_detail.marks) max_marks ";
		$query .= "  			FROM M_MARK_DETAIL m_detail ";
		$query .= "  			GROUP BY m_detail.rule_no,m_detail.sub_rule_no ";
		$query .= "  		)as total_rule_marks ";
		$query .= "  	GROUP BY rule_no, sub_rule_no ";
		$query .= "  	) as sub_rule_marks ";
		$query .= " ON student_mark.rule_no  = sub_rule_marks.rule_no ";
		$query .= " AND student_mark.sub_rule_no = sub_rule_marks.sub_rule_no ";
		$query .= " INNER JOIN(  ";
		$query .= " 	SELECT  rule_no ";
		$query .= " 	,SUM(max_marks) total_marks ";
		$query .= " 	FROM(  SELECT m_detail.rule_no rule_no ";
		$query .= " 			,m_detail.sub_rule_no sub_rule_no ";
		$query .= " 			,MAX(m_detail.marks) max_marks ";
		$query .= " 			FROM M_MARK_DETAIL m_detail ";
		$query .= " 			GROUP BY m_detail.rule_no,m_detail.sub_rule_no ";
		$query .= " 		)as total_rule_marks ";
		$query .= " 	GROUP BY rule_no ";
		$query .= " 	) as rule_marks   ";
		$query .= " ON student_mark.rule_no = rule_marks.rule_no ";
		$query .= " INNER JOIN(  ";
		$query .= " SELECT r_detail.result_no, m_detail.rule_no rule_no ";
		$query .= " 		,SUM(m_detail.marks) total_marks ";
		$query .= " 		FROM  T_4SKILL_RESULT_DETAIL r_detail ";
		$query .= " 		, M_MARK_DETAIL m_detail ";
		$query .= " 		WHERE r_detail.rule_no = m_detail.rule_no ";
		$query .= " 		AND r_detail.sub_rule_no = m_detail.sub_rule_no ";
		$query .= " 		AND r_detail.rule_detail_no = m_detail.rule_detail_no ";
		$query .= " 		GROUP BY r_detail.result_no,m_detail.rule_no ";
		$query .= " 	) as student_rule_total_marks ";
		$query .= " ON student_mark.rule_no = student_rule_total_marks.rule_no ";
		$query .= " AND student_mark.result_no = student_rule_total_marks.result_no ";
		$query .= " WHERE course.del_flg = '0' ";

		if (!StringUtil::isEmpty($course_detail_no)){
			$query .= " AND detail.course_detail_no = :course_detail_no ";
		}

		$query .= " AND course.course_id = :course_id ";
		$query .= " AND course.test_kbn = :test_kbn ";
		$query .= " AND stu.student_no = :student_no  ";
		$query .= " AND org.org_no = :org_no ";
		$query .= " AND co.offer_no = :offer_no ";
		$query .= " ORDER BY cou_detail.disp_no, cou_ques.disp_no, offer_no, course_id, course_detail_no, question_no, rule_no, sub_rule_no, rule_detail_no  ";//20190417 FB画面で問題表示修正

		$stmt = $this->pdo->prepare ( $query );
		LogHelper::logDebug($query);

		$stmt->bindParam ( ":offer_no", $offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":student_no", $student_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_kbn", $test_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );

		if ( ! StringUtil::isEmpty($course_detail_no) ){
			$stmt->bindParam ( ":course_detail_no", $course_detail_no, PDO::PARAM_STR );
		}
		
		return parent::getDataList ( $stmt, get_class ( new T_DetailDto() ) );
	}

	/**
	 * 受講者管理No.を指定してコース完了データを取得する
	 */
	public function getCoursesFinishByStudent($student_no, $offer_no, $course_id, $test_kbn) {

		$query  = " SELECT ";
		$query .= " answer.student_no ";
		$query .= " ,answer.course_id ";
		$query .= " ,course.test_kbn ";
		$query .= " ,answer.offer_no ";
		$query .= " ,answer.course_detail_no ";
		$query .= " ,course_detail.disp_no ";
		$query .= " ,co.org_no ";
		$query .= " FROM ";
		$query .= " T_4SKILL_RESULT answer ";
		$query .= " INNER JOIN T_COURSE course ";
		$query .= " ON course.course_id = answer.course_id ";
		$query .= " INNER JOIN T_COURSE_ORG co ";
		$query .= " ON course.course_id = co.course_id ";
		$query .= " AND answer.offer_no = co.offer_no ";
		$query .= " AND co.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE_DETAIL course_detail ";
		$query .= " ON course_detail.course_detail_no = answer.course_detail_no ";
		$query .= " AND course_detail.course_id = answer.course_id ";
		$query .= " INNER JOIN (SELECT offer_no,course_id,course_detail_no,student_no,MIN(answer_dt) answer_dt ";
		$query .= " FROM T_4SKILL_ANSWER  ";
		$query .= " GROUP BY offer_no,course_id,course_detail_no,student_no )ans  ";
		$query .= " ON answer.offer_no = ans.offer_no ";
		$query .= " AND answer.course_id = ans.course_id ";
		$query .= " AND answer.course_detail_no = ans.course_detail_no ";
		$query .= " AND answer.student_no = ans.student_no ";
		$query .= " WHERE ";
		$query .= " answer.del_flg = 0 ";
		$query .= " AND answer.student_no = :student_no ";
		$query .= " AND answer.offer_no = :offer_no ";
		$query .= " AND answer.course_id = :course_id ";
		$query .= " AND course.test_kbn = :test_kbn ";
		$query .= " GROUP BY student_no ";
		$query .= " ,answer.offer_no ";
		$query .= " ,answer.course_id ";
		$query .= " ,answer.course_detail_no ";
		$query .= " ,course_detail.disp_no ";
		$query .= " ,ans.answer_dt ";
		$query .= " ,co.org_no ";
		$query .= " ORDER BY ans.answer_dt";
		
		LogHelper::logDebug($query);
		
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":student_no", $student_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":offer_no", $offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_kbn", $test_kbn, PDO::PARAM_STR );

		return parent::getDataList($stmt, get_class(new T_DetailDto()) );
	}

	/**
	 * コース詳細一覧画面のデータを取得する
	 */
	public function getCourseDetailList( $param , $flg ) {

		$offset = ($param->page-1) * PAGE_ROW;

		$query = " SELECT  ";
		$query .= " d.course_detail_name   ";
		$query .= " ,d.course_detail_romaji ";
		$query .= " ,d.course_detail_no ";
		$query .= " ,d.status ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=d.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=d.test_kbn) AS test_kbn ";
		$query .= " ,date_format(d.start_period,'%Y/%m/%d') AS start_period    ";
		$query .= " ,date_format(d.end_period,'%Y/%m/%d') AS end_period    ";
		$query .= " FROM T_DETAIL d";
		$query .= " WHERE ";
		$query .= "  '1' = '1' ";
		$query .= " AND d.del_flg = '0' ";

		if ( ! StringUtil::isEmpty($param->course_detail_name) ){

			$query .= " AND (d.course_detail_name LIKE :course_detail_name OR d.course_detail_romaji LIKE :course_detail_romaji ) ";
		}

		if (! StringUtil::isEmpty($param->search_test_kbn) && ($param->search_test_kbn!= '')){
			$query .= " AND (d.test_kbn IN (".$param->search_test_kbn."))";
		}

		if (! StringUtil::isEmpty($param->search_course_level) && ($param->search_course_level!= '')){
			$query .= " AND (d.course_level IN (".$param->search_course_level.")) ";
		}

		$query .= " AND d.end_period >= :start_period ";
		$query .= " AND d.start_period <= :end_period ";
		$query .= " GROUP BY d.course_detail_no, d.course_detail_name, d.course_detail_romaji, d.start_period, d.end_period ,d.status ,d.course_level,d.test_kbn";
		$query .= " ORDER BY ";
		$query .= " d.course_detail_no ASC";

		if ( $flg == "1" ){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}
		$stmt = $this->pdo->prepare ( $query );

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;

		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);

		if ( ! StringUtil::isEmpty($param->course_detail_name) ){

			$name =  '%'.$param->course_detail_name.'%';
			$stmt->bindParam( ":course_detail_name", $name, PDO::PARAM_STR );
			$stmt->bindParam( ":course_detail_romaji", $name, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty($param->end_period) ){

			$end_period = DateUtil::changeEndDateFormat($param->end_period);
			$stmt->bindParam( ":end_period", $end_period, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty($param->start_period) ){

			$start_period = DateUtil::changeEndDateFormat($param->start_period);
			$stmt->bindParam( ":start_period", $start_period, PDO::PARAM_STR );
		}

		return parent::getDataList ( $stmt, get_class ( new T_DetailDto() ) );
	}

	/**
	 * コース詳細データを削除する
	 */
	public function delCourseDetailData($dto) {

		$query = "UPDATE ";
		$query .= "T_DETAIL SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE course_detail_no = :course_detail_no ";

		$stmt = $this->pdo->prepare ( $query );

		if (! StringUtil::isEmpty ( $dto->course_detail_no)){
			$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $dto->updater_id)){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty ( $dto->update_dt)){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	/**
	 * コース詳細情報を取得する
	 */
	public function getCourseDetailInfo($form) {

		$query = 'SELECT ';
		$query .= ' course_detail_name';
		$query .= ' ,course_detail_no';
		$query .= ' ,course_detail_romaji';
		$query .= ' ,course_level';
		$query .= ' ,test_kbn';
		$query .= ' ,status';
		$query .= ' ,date_format(start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' FROM T_DETAIL ';
		$query .= 'WHERE del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $form->course_detail_no ) ){
			$query .= ' AND course_detail_no = :course_detail_no ';
		}

		$stmt = $this->pdo->prepare ( $query );

		// 該当コースがある場合
		if ( ! StringUtil::isEmpty ( $form->course_detail_no ) ){
			$course_detail_no = $form->course_detail_no;
			$stmt->bindParam ( ":course_detail_no", $course_detail_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_CourseDto()) );
	}

	/**
	 * 次のコース詳細IDを取得する
	 */
	public function getNextCourseDetailNo() {

		return parent::getId ( "course_detail_no" );
	}

	/**
	 * コース詳細情報更新
	 */
	public function updateCourseDetailData($dto) {

		$query = "UPDATE ";
		$query .= "T_DETAIL SET course_detail_name = :course_detail_name";
		$query .= " ,course_detail_romaji = :course_detail_romaji ";
		$query .= " ,course_level = :course_level";
		$query .= " ,test_kbn = :test_kbn";
		$query .= " ,status = :status";
		$query .= " ,start_period = :start_period ";
		$query .= " ,end_period = :end_period ";
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";

		if ( ! StringUtil::isEmpty ( $dto->course_detail_no ) ){
			$query .= " AND course_detail_no = :course_detail_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->course_detail_no) ){
			$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_detail_name ) ){
			$stmt->bindParam ( ":course_detail_name", $dto->course_detail_name, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_detail_romaji) ){
			$stmt->bindParam ( ":course_detail_romaji", $dto->course_detail_romaji, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_level ) ){
			$stmt->bindParam ( ":course_level", $dto->course_level, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->test_kbn ) ){
			$stmt->bindParam ( ":test_kbn", $dto->test_kbn, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->status ) ){
			$stmt->bindParam ( ":status", $dto->status, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->start_period ) ){
			$stmt->bindParam ( ":start_period", $dto->start_period, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->end_period ) ){
			$stmt->bindParam ( ":end_period", $dto->end_period, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt ) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->updater_id ) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}
}