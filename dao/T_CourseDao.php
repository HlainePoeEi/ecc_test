<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_CourseDto.php';
require_once 'dto/T_DetailDto.php';
require_once 'dto/T_SequenceDto.php';
require_once 'conf/config.php';

class T_CourseDao extends BaseDao {

	/*
	 * コース一覧画面のデータを取得する
	 */
	public function getCourseList( $param , $flg ) {

		$offset = ($param->page-1) * PAGE_ROW;

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");

		$query = $this->createQuery();

		$query .= $this->createSearchWhere($param);

		if ( $flg == "1" ){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}
		$stmt = $this->pdo->prepare ( $query );

		$this->setSearchParam($stmt, $param);

		return parent::getDataList ( $stmt, get_class ( new T_CourseDto() ) );
	}

	public function createQuery(){

		$query = " SELECT  ";
		$query .= " c.course_id ";
		$query .= " ,c.course_name ";
		$query .= " ,c.course_name_romaji ";
		$query .= " ,c.course_id ";
		$query .= " ,c.status ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category = :course_level AND a.type = c.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category = :test_kbn AND a.type = c.test_kbn) AS test_kbn ";
		$query .= " ,date_format(c.start_period,'%Y/%m/%d') AS start_period    ";
		$query .= " ,date_format(c.end_period,'%Y/%m/%d') AS end_period    ";
		$query .= " FROM T_COURSE c ";

		return $query;
	}

	public function createSearchWhere ( $param ){

		$query = " WHERE ";
		$query .= "  '1' = '1' ";
		$query .= " AND c.del_flg = '0' ";

		if ( ! StringUtil::isEmpty($param->course_name) ){

			$query .= " AND (c.course_name LIKE :course_name OR c.course_name_romaji LIKE :course_name_romaji ) ";
		}

		if (! StringUtil::isEmpty($param->search_test_kbn) && ($param->search_test_kbn!= '')){
			$query .= " AND (c.test_kbn IN (".$param->search_test_kbn."))";
		}

		if (! StringUtil::isEmpty($param->search_course_level) && ($param->search_course_level!= '')){
			$query .= " AND (c.course_level IN (".$param->search_course_level.")) ";
		}

		if (! StringUtil::isEmpty($param->status)){
			$query .= " AND c.status IN (".$param->status.") ";
		}
		$query .= " AND c.end_period >= :start_period ";
		$query .= " AND c.start_period <= :end_period ";
		$query .= " GROUP BY c.course_id, c.course_name, c.course_name_romaji, c.start_period, c.end_period,c.status, c.course_level ,c.test_kbn ";
		$query .= " ORDER BY ";
		$query .= " c.course_id ASC";

		return $query;
	}

	/**
	 * パラメータバインド
	 *
	 */
	public function setSearchParam($stmt, $param){

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;

		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);

		if ( ! StringUtil::isEmpty($param->course_name) ){

			$name =  '%'.$param->course_name.'%';
			$stmt->bindParam(":course_name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":course_name_romaji", $name, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->end_period) ){

			$end_period = DateUtil::changeEndDateFormat($param->end_period);
			$stmt->bindParam(":end_period", $end_period, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->start_period) ){

			$start_period = DateUtil::changeEndDateFormat($param->start_period);
			$stmt->bindParam(":start_period", $start_period, PDO::PARAM_STR);
		}

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);
	}

	/**
	 * コースIDを取得する
	 */
	public function getNextCourseNo() {
		return parent::getId ( "course_id" );
	}

	public function getCourseInfo($form) {

		$query = $this->getQuery ( $form );

		$stmt = $this->pdo->prepare ( $query );
		if ( ! StringUtil::isEmpty ( $form->course_id) ){
			$course_id = $form->course_id;
			$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_CourseDto()) );
	}

	private function getQuery($form) {

		$query = 'SELECT ';
		$query .= ' course_name';
		$query .= ' ,course_id';
		$query .= ' ,course_name_romaji';
		$query .= ' ,course_level';
		$query .= ' ,test_kbn';
		$query .= ' ,status';
		$query .= ' ,date_format(start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' ,remarks';
		$query .= ' FROM T_COURSE ';
		$query .= 'WHERE del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $form->course_id ) ){
			$query .= ' AND course_id = :course_id ';
		}

		return $query;
	}

	private function setParamCourseValue($stmt, $form) {

		// 該当コースがある場合
		if ( ! StringUtil::isEmpty ( $form->course_name ) ){
			$course_name = $form->course_name;
			$stmt->bindParam ( ":course_name", $course_name, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->course_name_romaji) ){
			$course_name_romaji = $form->course_name_romaji;
			$stmt->bindParam ( ":course_name_romaji", $course_name_romaji, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->course_level ) ){
			$course_level = $form->course_level;
			$stmt->bindParam ( ":course_level", $course_level, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->test_kbn ) ){
			$test_kbn = $form->test_kbn;
			$stmt->bindParam ( ":test_kbn", $test_kbn, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->status) ){
			$status = $form->status;
			$stmt->bindParam ( ":status", $status, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->start_period) ){
			$start_period = $form->start_period;
			$stmt->bindParam ( ":start_period", $start_period, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->end_period) ){
			$end_period = $form->end_period;
			$stmt->bindParam ( ":end_period", $end_period, PDO::PARAM_STR );
		}
	}

	/**
	 * コース情報更新
	 */
	public function updateCourseData($dto) {

		$query = "UPDATE ";
		$query .= "T_COURSE SET course_name = :course_name";
		$query .= " ,course_name_romaji = :course_name_romaji ";
		$query .= " ,course_level = :course_level";
		$query .= " ,test_kbn = :test_kbn";
		$query .= " ,status = :status";
		$query .= " ,start_period = :start_period ";
		$query .= " ,end_period = :end_period ";
		if (!StringUtil::isEmpty($dto->remarks)){
			$query .= " ,remarks  = :remarks ";
		}
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$query .= " AND course_id = :course_id ";
		}
		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty ( $dto->course_name ) ){
			$stmt->bindParam ( ":course_name", $dto->course_name, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty ( $dto->course_name_romaji ) ){
			$stmt->bindParam ( ":course_name_romaji", $dto->course_name_romaji, PDO::PARAM_STR );
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
		if ( ! StringUtil::isEmpty ( $dto->remarks ) ){
			$stmt->bindParam ( ":remarks", $dto->remarks, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty ( $dto->update_dt ) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty ( $dto->updater_id ) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	public function delCourseData($dto) {

		$query = "UPDATE ";
		$query .= "T_COURSE SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE course_id = :course_id ";

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	/**
	 * コース契約一覧を取得する
	 */
	public function getCourseContractList($param, $flg) {

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$offset = ($param->page-1) * PAGE_ROW;

		$query = " SELECT";
		$query .= " org.org_id org_id ";
		$query .= " ,org.org_no org_no ";
		$query .= " ,org.org_name org_name ";
		$query .= " ,course.course_name course_name ";
		$query .= " ,course.course_id course_id ";
		$query .= " ,course_org.offer_no offer_no ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=course.test_kbn) AS test_kbn ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=course.course_level) AS course_level ";
		$query .= " ,date_format(course_org.start_period,'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(course_org.end_period,'%Y/%m/%d') as end_period ";
		$query .= " ,COUNT(course_student.student_no) as student_count";

		$query .= " FROM ";
		$query .= " T_COURSE_ORG course_org ";
		$query .= " LEFT JOIN T_COURSE as course ";
		$query .= " ON course.course_id = course_org.course_id ";
		$query .= " AND course.del_flg = '0' "; //20190605削除フラグ追加
		$query .= " LEFT JOIN M_ORGANIZATION as org ";
		$query .= " ON org.org_no = course_org.org_no ";
		$query .= " AND org.del_flg = '0' "; //20190605削除フラグ追加
		$query .= " LEFT JOIN T_COURSE_STUDENT as course_student ";
		$query .= " ON course_org.offer_no = course_student.offer_no ";
		$query .= " AND course.course_id = course_student.course_id ";
		$query .= " AND course_org.org_no = course_student.org_no ";
		$query .= " AND course_student.del_flg = '0' "; //20190605削除フラグ追加
		$query .= " WHERE";

		if (! StringUtil::isEmpty($param->sc_org_name)){
			$query .= " (org.org_name LIKE :org_name OR org.org_name_kana LIKE :org_name_kana ) AND";
		}

		if (! StringUtil::isEmpty($param->sc_org_id)){
			$query .= " (org.org_id LIKE :param_org_id) AND";
		}

		if (! StringUtil::isEmpty($param->sc_test_kbn) && ($param->sc_test_kbn != '')){
			$query .= " (course.test_kbn IN (".$param->sc_test_kbn.")) AND";
		}

		if (! StringUtil::isEmpty($param->sc_course_level) && ($param->sc_course_level != '')){
			$query .= " (course.course_level IN (".$param->sc_course_level.")) AND";
		}

		if (! StringUtil::isEmpty($param->sc_course_name)){
			$query .= " (course.course_name LIKE :course_name OR course.course_name_romaji LIKE :course_name_romaji ) AND";
		}

		$query .= " course_org.end_period >= :start_period";
		$query .= " AND course_org.start_period <= :end_period ";
		$query .= " AND course_org.del_flg = '0' "; //20190605削除フラグ追加
		$query .= " GROUP BY org_id, org_name, org_no, course_name, test_kbn, course_level, start_period, end_period, offer_no, course_id ";
		$query .= " ORDER BY ";
		$query .= " org_no, offer_no, course_id";

		if ( $flg == "1"){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );

		if (! StringUtil::isEmpty($param->sc_org_name)){
			$sc_org_name = '%'.$param->sc_org_name.'%';
			$stmt->bindParam(":org_name",$sc_org_name, PDO::PARAM_STR);
			$stmt->bindParam(":org_name_kana",$sc_org_name, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->sc_org_id)){
			$sc_org_id = '%'.$param->sc_org_id.'%';
			$stmt->bindParam(":param_org_id",$sc_org_id, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->sc_course_name)){
			$sc_course_name = '%'.$param->sc_course_name.'%';
			$stmt->bindParam(":course_name",$sc_course_name, PDO::PARAM_STR);
			$stmt->bindParam(":course_name_romaji", $sc_course_name, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->end_period) ){

			$end_period = DateUtil::changeEndDateFormat($param->end_period);
			$stmt->bindParam( ":end_period", $end_period, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty($param->start_period) ){

			$start_period = DateUtil::changeEndDateFormat($param->start_period);
			$stmt->bindParam( ":start_period", $start_period, PDO::PARAM_STR );
		}
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);
		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);

		return parent::getDataList( $stmt, get_class(new T_CourseDto()) );

	}

	/**
	 * コース契約確認画面のデータを取得する
	 */
	public function getCourseContractConfirmList( $param , $flg ) {

		$offset = ($param->page-1) * PAGE_ROW;

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");

		$query = $this->createContractConfirmQuery();
		$query .= $this->createContractConfirmSearchWhere($param);

		if ( $flg == "1" ){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}
		
		$stmt = $this->pdo->prepare ( $query );
		
		LogHelper::logDebug("CourseContractConfirmList　Query");
		LogHelper::logDebug($query);

		$this->setContractConfirmSearchParam($stmt, $param);

		return parent::getDataList ( $stmt, get_class ( new T_CourseDto() ) );
	}

	public function createContractConfirmQuery(){

		$query = " SELECT  ";
		$query .= " o.org_no   ";
		$query .= " ,o.org_id ";
		$query .= " ,o.org_name ";
		$query .= " ,o.org_name_official ";
		$query .= " ,c.course_id ";
		$query .= " ,c.course_name ";

		$query .= " ,date_format(co.start_period,'%Y/%m/%d') AS  co_start_period";
		$query .= " ,date_format(co.end_period,'%Y/%m/%d') AS  co_end_period";

		$query .= " ,co.remarks ";
		$query .= " ,co.offer_no ";
		$query .= " ,d.course_detail_no ";
		$query .= " ,d.course_detail_name ";
		$query .= " ,s.student_no ";
		$query .= " ,s.student_name ";
		$query .= " ,s.login_id ";

		$query .= " ,date_format(cds.start_period,'%Y/%m/%d') AS cds_start_period ";
		$query .= " ,date_format(cds.end_period,'%Y/%m/%d') AS cds_end_period ";

		$query .= " ,date_format(answer.answer_dt,'%Y/%m/%d') AS a_answer_dt ";
		$query .= " ,date_format(r.update_dt,'%Y/%m/%d') AS u_update_dt ";
		$query .= " ,teacher.display_name AS display_name ";

		$query .= " ,teacher.login_id AS teacher_code";
		$query .= " ,teacher.name AS teacher_name";
		
		//SQL修正 2019.7.29 start
		$query .= " ,teacher.school_kbn AS teacher_school  ";
		$query .= " ,CONCAT(if (student_mark.result_marks IS NULL,'-', student_mark.result_marks ),'/',total_mark.marks) AS result ";

		//$query .= " ,CASE WHEN teacher.school_kbn = '001' THEN 'Philippines' ";
		//$query .= "  WHEN teacher.school_kbn = '002' THEN 'Japan' ";
		//$query .= "  ELSE NULL END AS teacher_school ";
		//$query .= " ,GROUP_CONCAT(DISTINCT CONCAT(if (student_mark.result_marks IS NULL,'-', student_mark.result_marks ),'/',total_mark.marks)) AS result ";
		//SQL修正 2019.7.29 end

		// データ多い場合画面表示遅いので修正
		$query .= " FROM M_ORGANIZATION o ";

		$query .= " INNER JOIN T_COURSE_ORG as co ";
		$query .= " ON co.org_no = o.org_no ";
		$query .= " AND co.del_flg = '0' ";
		$query .= " AND o.del_flg = '0' "; //20190617-削除フラグ追加

		$query .= " INNER JOIN T_COURSE as c ";
		$query .= " ON c.course_id = co.course_id ";
		$query .= " AND c.del_flg = '0' ";

		$query .= " INNER JOIN T_COURSE_DETAIL as cd ";
		$query .= " ON cd.course_id = c.course_id ";
		$query .= " AND cd.del_flg = '0' ";

		$query .= " INNER JOIN T_DETAIL as d ";
		$query .= " ON d.course_detail_no = cd.course_detail_no ";
		$query .= " AND c.course_level = d.course_level ";
		$query .= " AND c.test_kbn = d.test_kbn ";
		$query .= " AND d.del_flg = '0' ";

		$query .= " LEFT JOIN T_COURSE_DETAIL_STUDENT as cds "; //20190617-修正
		$query .= " ON cds.offer_no = co.offer_no ";
		$query .= " AND cds.course_id = c.course_id ";
		$query .= " AND cds.course_detail_no = cd.course_detail_no ";
		$query .= " AND cds.del_flg = '0' ";

		$query .= " LEFT JOIN T_STUDENT as s ";
		$query .= " ON s.org_no = co.org_no ";
		$query .= " AND s.student_no = cds.student_no ";
		$query .= " AND s.del_flg = '0' ";

		$query .= " LEFT JOIN T_4SKILL_RESULT as r ";
		$query .= " ON r.offer_no = co.offer_no ";
		$query .= " AND r.course_id = c.course_id ";
		$query .= " AND r.course_detail_no = cd.course_detail_no ";
		$query .= " AND r.student_no = cds.student_no ";
		$query .= " AND r.del_flg = '0' ";

		//SQL修正 2019.7.29 start
		$query .= " LEFT JOIN (";
		$query .= " SELECT teacher_no, ";
		$query .= " del_flg, display_name,";
		$query .= " login_id,";
		$query .= " name,";
		$query .= " CASE WHEN school_kbn = '001' THEN 'Philippines' ";
		$query .= " WHEN school_kbn = '002' THEN 'Japan' ELSE NULL END AS school_kbn ";
		$query .= " FROM T_TEACHER) teacher ";

		//$query .= " LEFT JOIN T_TEACHER_COURSE_DETAIL tcd ";
		//$query .= " ON d.course_detail_no = tcd.course_detail_no ";
		//$query .= " AND tcd.del_flg = '0' ";
		//$query .= " LEFT JOIN T_TEACHER teacher ";
		//SQL修正 2019.7.29 end
		$query .= " ON r.updater_id = teacher.teacher_no ";
		$query .= " AND teacher.del_flg = '0' ";

		$query .= " LEFT JOIN (  SELECT offer_no ";
		$query .= " 	,course_id course_id ";
		$query .= " 	,course_detail_no course_detail_no ";
		$query .= " 	,student_no ";
		$query .= " 	,MIN(answer_dt) answer_dt ";//20190827 - 受講時間取得修正
		$query .= " 	FROM T_4SKILL_ANSWER ";
		// 2019/10/10 削除フラグ追加 Cherry
		$query .= " 	WHERE del_flg = '0'  ";
		$query .= " 	GROUP BY offer_no,course_id,course_detail_no,student_no ) answer ";
		$query .= " ON c.course_id = answer.course_id ";
		$query .= " AND cd.course_detail_no = answer.course_detail_no ";
		$query .= " AND co.offer_no = answer.offer_no ";
		$query .= " AND s.student_no = answer.student_no ";
		$query .= " LEFT JOIN ( ";
		$query .= " 	SELECT a.offer_no ,a.student_no,a.course_id,a.course_detail_no,SUM(a.marks) as result_marks ";
		$query .= " 	FROM ( ";
		$query .= " 		SELECT skill_answer.offer_no ";
		$query .= " 		,skill_answer.student_no ";
		$query .= " 		,skill_answer.course_id ";
		$query .= " 		,skill_answer.course_detail_no ";
		$query .= " 		,skill_result_detail.rule_no ";
		$query .= " 		,skill_result_detail.sub_rule_no ";
		$query .= " 		,skill_result_detail.rule_detail_no ";
		$query .= " 		,mark_detail.marks ";
		$query .= " 		FROM T_4SKILL_ANSWER skill_answer ";
		$query .= " 		LEFT JOIN T_4SKILL_RESULT skill_result ";
		$query .= " 		ON skill_answer.offer_no = skill_result.offer_no ";
		$query .= " 		AND skill_answer.student_no = skill_result.student_no ";
		$query .= " 		AND skill_answer.course_id = skill_result.course_id ";
		$query .= " 		AND skill_answer.course_detail_no = skill_result.course_detail_no ";
		$query .= " 		INNER JOIN T_4SKILL_RESULT_DETAIL skill_result_detail ";
		$query .= " 		ON skill_result.result_no = skill_result_detail.result_no ";
		$query .= " 		INNER JOIN M_MARK_DETAIL mark_detail ";
		$query .= " 		ON skill_result_detail.rule_no = mark_detail.rule_no ";
		$query .= " 		AND skill_result_detail.sub_rule_no = mark_detail.sub_rule_no ";
		$query .= " 		AND skill_result_detail.rule_detail_no = mark_detail.rule_detail_no ";
		// 2019/10/10 削除フラグ追加 Cherry
		$query .= " 		AND skill_answer.del_flg = '0' ";
		$query .= " 		AND skill_result.del_flg = '0' ";
		$query .= " 		GROUP BY skill_answer.offer_no ,skill_answer.student_no ,skill_answer.course_id,mark_detail.marks ";
		$query .= " 		,skill_answer.course_detail_no ,skill_result_detail.rule_no ";
		$query .= " 		,skill_result_detail.sub_rule_no ,skill_result_detail.rule_detail_no ";
		$query .= " 	) as a ";
		$query .= " 	GROUP BY a.offer_no ";
		$query .= " ,a.student_no ";
		$query .= " ,a.course_id ";
		$query .= " ,a.course_detail_no ";
		$query .= " ) as student_mark ";
		$query .= " ON s.student_no = student_mark.student_no ";
		$query .= " AND co.offer_no = student_mark.offer_no ";
		$query .= " AND co.course_id = student_mark.course_id ";
		$query .= " AND cd.course_detail_no = student_mark.course_detail_no ";
		$query .= " LEFT JOIN  ( ";
		$query .= " 	SELECT mark_rule.course_level ";
		$query .= " 	, mark_rule.test_kbn ";
		$query .= " 	, course.course_id ";
		$query .= " 	, course_detail.course_detail_no ";
		$query .= " 	, SUM(mark_detail.max_marks) marks ";
		$query .= " 	FROM T_COURSE course ";
		$query .= " 	INNER JOIN T_COURSE_DETAIL course_detail ";
		$query .= " 	ON course.course_id = course_detail.course_id ";
		$query .= " 	AND course.del_flg = '0' "; //20190628-条件追加
		$query .= " 	AND course_detail.del_flg = '0' "; //20190628-条件追加
		$query .= " 	INNER JOIN T_COURSE_DETAIL_QUESTION course_detail_qa ";
		$query .= " 	ON course_detail.course_detail_no = course_detail_qa.course_detail_no ";
		$query .= " 	AND course_detail_qa.del_flg = '0' "; //20190628-条件追加
		$query .= " 	INNER JOIN T_QUESTION ques ";
		$query .= " 	ON course_detail_qa.question_no = ques.question_no ";
		$query .= " 	AND ques.del_flg = '0' "; //20190628-条件追加
		$query .= " 	INNER JOIN  M_MARK_RULE mark_rule ";
		$query .= " 	ON ques.score_pattern = mark_rule.score_pattern ";
		$query .= " 	AND course.course_level = mark_rule.course_level ";
		$query .= " 	AND course.test_kbn = mark_rule.test_kbn ";
		$query .= " 	INNER JOIN  ( ";
		$query .= " 		SELECT  rule_no ";
		$query .= " 			,SUM(max_marks) AS max_marks ";
		$query .= " 			FROM ( ";
		$query .= " 				SELECT rule_no ";
		$query .= " 				,sub_rule_no ";
		$query .= " 				,MAX(marks) AS max_marks ";
		$query .= " 				FROM M_MARK_DETAIL ";
		$query .= " 				WHERE del_flg = '0' ";
		$query .= " 				GROUP BY rule_no,sub_rule_no) AS max ";
		$query .= " 			GROUP BY rule_no ";
		$query .= " 		) mark_detail ";
		$query .= " 	ON mark_rule.rule_no = mark_detail.rule_no ";
		$query .= " 	GROUP BY mark_rule.course_level      ,mark_rule.test_kbn, course.course_id, course_detail.course_detail_no ";
		$query .= " ) as total_mark ";
		$query .= " ON c.course_id = total_mark.course_id ";
		$query .= " AND cd.course_detail_no = total_mark.course_detail_no ";
		$query .= " AND c.course_level =  total_mark.course_level ";
		$query .= " AND c.test_kbn =  total_mark.test_kbn ";
		
		return $query;
	}

	public function createContractConfirmSearchWhere ( $param ){

		$query = " WHERE ";
		$query .= " '1' = '1' ";

		if (! StringUtil::isEmpty ( $param->org_id ) ) {

			$query .= ' AND o.org_id LIKE :org_id ';
		}

		if (! StringUtil::isEmpty ( $param->course_id_from ) && ! StringUtil::isEmpty ( $param->course_id_to )) {

			$query .= ' AND c.course_id >= :course_id_from ';
			$query .= ' AND c.course_id <= :course_id_to ';
		}elseif (! StringUtil::isEmpty ( $param->course_id_from ) ){

			$query .= ' AND c.course_id = :course_id_from ';
		}elseif (! StringUtil::isEmpty ( $param->course_id_to )){

			$query .= ' AND c.course_id = :course_id_to ';
		}

		$query .= " AND co.end_period >= :start_period ";
		$query .= " AND co.start_period <= :end_period ";

		if (! StringUtil::isEmpty ( $param->login_id_from ) && ! StringUtil::isEmpty ( $param->login_id_to )) {

			$query .= ' AND s.login_id >= :login_id_from ';
			$query .= ' AND s.login_id <= :login_id_to ';
		}elseif (! StringUtil::isEmpty ( $param->login_id_from ) ){

			$query .= ' AND s.login_id = :login_id_from ';
		}elseif (! StringUtil::isEmpty ( $param->login_id_to )){

			$query .= ' AND s.login_id = :login_id_to ';
		}
		$query .= " GROUP BY o.org_no,o.org_id,o.org_name,o.org_name_official,c.course_id,c.course_name,co_start_period,co_end_period,co.remarks,co.offer_no, d.course_detail_no, d.course_detail_name,s.student_no,s.student_name,s.login_id,cds_start_period,cds_end_period,a_answer_dt,u_update_dt,display_name,teacher.login_id,teacher_name,teacher.school_kbn";
		$query .= " ORDER BY o.org_no,co.offer_no, c.course_id, cd.disp_no, cds.course_detail_no,s.login_id";
		return $query;
	}

	public function setContractConfirmSearchParam($stmt, $param){

		if ( ! StringUtil::isEmpty($param->end_period) ){

			$end_period = DateUtil::changeEndDateFormat($param->end_period);
			$stmt->bindParam(":end_period", $end_period, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->start_period) ){

			$start_period = DateUtil::changeEndDateFormat($param->start_period);
			$stmt->bindParam(":start_period", $start_period, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->org_id) ){

			$org_id = '%'.$param->org_id.'%';
			$stmt->bindParam(":org_id",$org_id, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->course_id_from) ){

			$stmt->bindParam(":course_id_from", $param->course_id_from, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->course_id_to) ){

			$stmt->bindParam(":course_id_to", $param->course_id_to, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->login_id_from) ){

			$stmt->bindParam(":login_id_from", $param->login_id_from, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->login_id_to) ){

			$stmt->bindParam(":login_id_to", $param->login_id_to, PDO::PARAM_STR);
		}
	}

	/**
	 * SW Practice 参照一覧を取得する
	 */
	public function getSWPracticeCourseList($param, $flg){

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$offset = ($param->page-1) * PAGE_ROW;

		$query = "SELECT";
		$query .= " DISTINCT course.course_id as course_id";
		$query .= " ,course.test_kbn as test_kbn";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=course.course_level) AS name1 ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=course.test_kbn) AS name2 ";
		$query .= " ,course.course_name as course_name";
		$query .= " ,course.course_name_romaji as course_name_romaji";
		$query .= " ,detail.course_detail_no as course_detail_no";
		$query .= " ,detail.course_detail_name as course_detail_name";
		$query .= " ,detail.course_detail_romaji as course_detail_romaji";
		$query .= " ,course.remarks as remarks";
		$query .= " ,course_detail.disp_no as disp_no";
		$query .= " ,date_format(course.create_dt,'%Y/%m/%d') as date ";
		$query .= " FROM";
		$query .= " T_COURSE course";
		$query .= " LEFT JOIN T_COURSE_DETAIL course_detail";
		$query .= " ON course.course_id = course_detail.course_id";
		$query .= " LEFT JOIN T_DETAIL detail";
		$query .= " ON course_detail.course_detail_no = detail.course_detail_no";
		$query .= " AND course.course_level = detail.course_level";
		$query .= " AND course.test_kbn = detail.test_kbn";
		$query .= " WHERE";
		$query .= " course.del_flg = 0";

		if (! StringUtil::isEmpty($param->remarks)){
			$query .= " AND (course.remarks LIKE :remarks)";
		}

		if (! StringUtil::isEmpty($param->name)){
			$query .= " AND (course.course_name LIKE :name)";
		}

		if (! StringUtil::isEmpty($param->search_test_kbn) && ($param->search_test_kbn!= '')){
			$query .= " AND (course.test_kbn IN (".$param->search_test_kbn."))";
		}

		if (! StringUtil::isEmpty($param->search_course_level) && ($param->search_course_level!= '')){
			$query .= " AND (course.course_level IN (".$param->search_course_level.")) ";
		}

		if (! StringUtil::isEmpty($param->status)){
			$query .= " AND course.status IN (".$param->status.") ";
		}

		$query .= " ORDER BY course_id, course_detail.disp_no ASC ";

		if ( $flg == "1"){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}
		$stmt = $this->pdo->prepare ( $query );

		if (! StringUtil::isEmpty($param->remarks)){
			$remarks= '%'.$param->remarks.'%';
			$stmt->bindParam(":remarks",$remarks, PDO::PARAM_STR);
		}

		if (! StringUtil::isEmpty($param->name)){
			$name = '%'.$param->name.'%';
			$stmt->bindParam(":name",$name, PDO::PARAM_STR);
		}

		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);

		return parent::getDataList( $stmt, get_class(new T_CourseDto()) );
	}

}