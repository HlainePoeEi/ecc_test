<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_CourseStatusDto.php';
require_once 'dto/T_SequenceDto.php';

class T_CourseStatusDao extends BaseDao {

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
		LogHelper::logDebug("course list query");
		LogHelper::logDebug($query);

		$this->setSearchParam($stmt, $param);

		return parent::getDataList ( $stmt, get_class ( new T_CourseStatusDto() ) );
	}

	public function createQuery(){

		$query = " SELECT  ";
		$query .= " co.offer_no    ";
		$query .= " ,m.org_no ";
		$query .= " ,m.org_id ";
		$query .= " ,m.org_name ";
		$query .= " ,cd.course_id   ";
		$query .= " ,c.course_name   ";
		$query .= " ,c.course_name_romaji ";
		$query .= " ,cd.course_detail_no    ";
		$query .= " ,s.student_no ";
		$query .= " ,s.login_id ";
		$query .= " ,s.student_name ";
		$query .= " ,cd.disp_no    ";
		$query .= " ,d.course_detail_name    ";
		$query .= " ,d.course_detail_romaji ";
		$query .= " ,d.test_kbn test_kbn    ";
		$query .= " ,date_format(answer.answer_dt,'%Y/%m/%d') AS answer_dt    ";
		$query .= " ,student_mark.result_marks ";
		$query .= " ,total_mark.marks total_marks ";
		
		/* データ多い場合画面表示遅いので修正
		$query .= " FROM T_STUDENT s   ";
		$query .= " INNER JOIN T_COURSE_STUDENT cs    ";
		$query .= " ON s.student_no = cs.student_no    ";
		$query .= " AND s.org_no = cs.org_no     ";
		$query .= " AND cs.del_flg = '0'      ";
		$query .= " INNER JOIN T_COURSE c      ";
		$query .= " ON cs.course_id = c.course_id     ";
		$query .= " AND c.del_flg = '0'     ";
		$query .= " INNER JOIN T_COURSE_ORG co      ";
		$query .= " ON c.course_id = co.course_id      ";
		$query .= " AND s.org_no = co.org_no     ";
		$query .= " AND co.del_flg = '0'     ";
		$query .= " INNER JOIN M_ORGANIZATION m     ";
		$query .= " ON m.org_no =co.org_no    ";
		$query .= " AND m.del_flg = '0'     ";
		$query .= " INNER JOIN T_COURSE_DETAIL cd     ";
		$query .= " ON c.course_id = cd.course_id     ";
		$query .= " AND cd.del_flg = '0'   ";
		$query .= " INNER JOIN T_DETAIL d     ";
		$query .= " ON cd.course_detail_no = d.course_detail_no    ";
		$query .= " AND d.del_flg = '0'    ";

		//問題削除フラグ追加・不要な講師コース詳細条件削除20190201
		$query .= " INNER JOIN T_COURSE_DETAIL_QUESTION cdques ";
		$query .= " ON cd.course_detail_no = cdques.course_detail_no ";
		$query .= " AND cdques.del_flg = '0' ";

		$query .= " LEFT JOIN (  SELECT offer_no       ";
		$query .= " 		,course_id course_id         ";
		$query .= " 		,course_detail_no course_detail_no         ";
		$query .= " 		,student_no        ";
		$query .= " 		,MIN(answer_dt) answer_dt         ";//20190827 - 受講時間取得修正
		$query .= " 		FROM T_4SKILL_ANSWER        ";
		$query .= " 		GROUP BY offer_no,course_id,course_detail_no,student_no      ";
		$query .= " 		) answer  ";
		$query .= " ON c.course_id = answer.course_id  ";
		$query .= " AND cd.course_detail_no = answer.course_detail_no  ";
		$query .= " AND co.offer_no = answer.offer_no  ";
		$query .= " AND s.student_no = answer.student_no  ";
		$query .= " LEFT JOIN (        ";
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
		$query .= " 		GROUP BY skill_answer.offer_no ,skill_answer.student_no ,skill_answer.course_id ";
		$query .= " 		,skill_answer.course_detail_no ,skill_result_detail.rule_no      ";
		$query .= " 		,skill_result_detail.sub_rule_no ,skill_result_detail.rule_detail_no      ";
		$query .= " 	) as a ";
		$query .= " 	GROUP BY a.offer_no ";
		$query .= " 	,a.student_no  ";
		$query .= " 	,a.course_id   ";
		$query .= " 	,a.course_detail_no ";
		$query .= " ) as student_mark    ";
		$query .= " ON s.student_no = student_mark.student_no  ";
		$query .= " AND co.offer_no = student_mark.offer_no  ";
		$query .= " AND co.course_id = student_mark.course_id    ";
		$query .= " AND cd.course_detail_no = student_mark.course_detail_no   ";
		$query .= " LEFT JOIN  (      ";
		$query .= " 			SELECT mark_rule.course_level      ";
		$query .= " 			, mark_rule.test_kbn      ";
		$query .= " 			, course.course_id      ";
		$query .= " 			, course_detail.course_detail_no      ";
		$query .= " 			, SUM(mark_detail.max_marks) marks       ";
		$query .= " 			FROM T_COURSE course ";

		$query .= " 			INNER JOIN T_COURSE_DETAIL course_detail ";
		$query .= " 			ON course.course_id = course_detail.course_id ";
		$query .= " 			AND course.del_flg = '0' "; //20190628-条件追加
		$query .= " 			AND course_detail.del_flg = '0' "; //20190628-条件追加
		$query .= " 			INNER JOIN T_COURSE_DETAIL_QUESTION course_detail_qa ";
		$query .= " 			ON course_detail.course_detail_no = course_detail_qa.course_detail_no ";
		$query .= " 			AND course_detail_qa.del_flg = '0' "; //20190628-条件追加

		$query .= " 			INNER JOIN T_QUESTION ques ";
		$query .= " 			ON course_detail_qa.question_no = ques.question_no ";
		$query .= " 			AND ques.del_flg = '0' "; //20190628-条件追加
		$query .= " 			INNER JOIN  M_MARK_RULE mark_rule ";
		$query .= " 			ON ques.score_pattern = mark_rule.score_pattern ";
		$query .= " 			AND course.course_level = mark_rule.course_level ";
		$query .= " 			AND course.test_kbn = mark_rule.test_kbn ";
		$query .= " 			INNER JOIN  ( ";
		$query .= " 					SELECT  rule_no ";
		$query .= " 							,SUM(max_marks) AS max_marks ";
		$query .= " 					FROM ( ";
		$query .= " 							SELECT rule_no ";
		$query .= " 							,sub_rule_no ";
		$query .= " 							,MAX(marks) AS max_marks ";
		$query .= " 							FROM M_MARK_DETAIL ";
		$query .= " 							WHERE del_flg = '0' ";
		$query .= " 							GROUP BY rule_no,sub_rule_no) AS max ";
		$query .= " 					GROUP BY rule_no ";
		$query .= " 				) mark_detail ";
		$query .= " 			ON mark_rule.rule_no = mark_detail.rule_no ";
		$query .= " 			GROUP BY mark_rule.course_level      ,mark_rule.test_kbn, course.course_id, course_detail.course_detail_no  ";
		$query .= " 		) as total_mark  ";
		$query .= " ON c.course_id = total_mark.course_id  ";
		$query .= " AND cd.course_detail_no = total_mark.course_detail_no ";
		$query .= " AND c.course_level =  total_mark.course_level  ";
		$query .= " AND c.test_kbn =  total_mark.test_kbn ";
		$query .= " LEFT JOIN T_COURSE_DETAIL_STUDENT detail_stu ";
		$query .= " ON co.offer_no = detail_stu.offer_no ";
		$query .= " AND co.course_id = detail_stu.course_id ";
		$query .= " AND cd.course_detail_no = detail_stu.course_detail_no ";
		$query .= " AND co.org_no = detail_stu.org_no ";
		$query .= " AND s.student_no = detail_stu.student_no ";
		$query .= " AND detail_stu.del_flg = '0' ";
		
		*/

		// 2019/09/06 SQL文遅い問題修正
		
		$query .= " FROM ";
		$query .= " 	T_COURSE_DETAIL_STUDENT detail_stu ";
		$query .= " INNER JOIN T_STUDENT s ";
		$query .= " 	ON detail_stu.org_no = s.org_no ";
		$query .= " 	AND detail_stu.student_no = s.student_no ";
		$query .= " 	AND s.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE_STUDENT cs    ";
		$query .= " 	ON s.student_no = cs.student_no      ";
		$query .= " 	AND s.org_no = cs.org_no       ";
		$query .= " 	AND detail_stu.offer_no = cs.offer_no ";
		$query .= " 	AND detail_stu.course_id = cs.course_id ";
		$query .= " 	AND cs.del_flg = '0' ";
		$query .= " INNER JOIN T_COURSE c           ";
		$query .= " 	ON cs.course_id = c.course_id       ";
		$query .= " 	AND c.del_flg = '0'      ";
		$query .= " INNER JOIN T_COURSE_ORG co      ";
		$query .= " 	ON c.course_id = co.course_id       ";
		$query .= " 	AND detail_stu.org_no = co.org_no     ";
		$query .= " 	AND detail_stu.offer_no = co.offer_no   ";
		$query .= " 	AND co.del_flg = '0'   ";
		$query .= " INNER JOIN M_ORGANIZATION m     ";
		$query .= " 	ON detail_stu.org_no = m.org_no     ";
		$query .= " 	AND m.del_flg = '0'      ";
		$query .= " INNER JOIN T_COURSE_DETAIL cd   ";
		$query .= " 	ON detail_stu.course_id = cd.course_id  ";
		$query .= " 	AND detail_stu.course_detail_no = cd.course_detail_no   ";
		$query .= " 	AND cd.del_flg = '0'  ";
		$query .= " INNER JOIN T_DETAIL d      ";
		$query .= " 	ON detail_stu.course_detail_no = d.course_detail_no     ";
		$query .= " 	AND d.del_flg = '0'    ";
		$query .= " LEFT JOIN 	( SELECT offer_no         ";
		$query .= " 					,course_id course_id          ";
		$query .= " 					,course_detail_no course_detail_no           ";
		$query .= " 					,student_no          ";
		$query .= " 					,MIN(answer_dt) answer_dt           ";
		$query .= " 				FROM T_4SKILL_ANSWER         ";
		$query .= " 				WHERE del_flg = '0'         ";
		$query .= " 				GROUP BY offer_no,course_id,course_detail_no,student_no        ";
		$query .= " 			) answer    ";
		$query .= " 	ON detail_stu.course_id = answer.course_id    ";
		$query .= " 	AND detail_stu.course_detail_no = answer.course_detail_no    ";
		$query .= " 	AND detail_stu.offer_no = answer.offer_no  ";
		$query .= " 	AND s.student_no = answer.student_no ";

		$query .= " LEFT JOIN (    SELECT 	a.offer_no ,a.student_no ";
		$query .= " 						,a.course_id,a.course_detail_no ";
		$query .= " 						,SUM(a.marks) as result_marks  ";
		$query .= " 				FROM (  SELECT skill_answer.offer_no   ";
		$query .= " 							,skill_answer.student_no   ";
		$query .= " 							,skill_answer.course_id  ";
		$query .= " 							,skill_answer.course_detail_no   ";
		$query .= " 							,skill_result_detail.rule_no   ";
		$query .= " 							,skill_result_detail.sub_rule_no   ";
		$query .= " 							,skill_result_detail.rule_detail_no  ";
		$query .= " 							,mark_detail.marks   ";
		$query .= " 						FROM T_4SKILL_ANSWER skill_answer  ";
		$query .= " 						LEFT JOIN T_4SKILL_RESULT skill_result   ";
		$query .= " 							ON skill_answer.offer_no = skill_result.offer_no   ";
		$query .= " 							AND skill_answer.student_no = skill_result.student_no   ";
		$query .= " 							AND skill_answer.course_id = skill_result.course_id   ";
		$query .= " 							AND skill_answer.course_detail_no = skill_result.course_detail_no   ";
		$query .= " 						INNER JOIN T_4SKILL_RESULT_DETAIL skill_result_detail  ";
		$query .= " 							ON skill_result.result_no = skill_result_detail.result_no  ";
		$query .= " 						INNER JOIN M_MARK_DETAIL mark_detail   ";
		$query .= " 							ON skill_result_detail.rule_no = mark_detail.rule_no   ";
		$query .= " 							AND skill_result_detail.sub_rule_no = mark_detail.sub_rule_no   ";
		$query .= " 							AND skill_result_detail.rule_detail_no = mark_detail.rule_detail_no   ";
		$query .= " 						WHERE skill_answer.del_flg = '0'         ";
		$query .= " 						AND skill_result.del_flg = '0'         ";
		$query .= " 						GROUP BY skill_answer.offer_no ,skill_answer.student_no ,skill_answer.course_id  ";
		$query .= " 								,skill_answer.course_detail_no ,skill_result.result_no,skill_result_detail.rule_no        ";
		$query .= " 								,skill_result_detail.sub_rule_no ,skill_result_detail.rule_detail_no        ";
		$query .= " 					) as a   ";
		$query .= " 				GROUP BY a.offer_no  	,a.student_no   	,a.course_id    	,a.course_detail_no   ";
		$query .= " 			) as student_mark  ";
		$query .= " 			ON detail_stu.student_no = student_mark.student_no   ";
		$query .= " 			AND detail_stu.offer_no = student_mark.offer_no    ";
		$query .= " 			AND detail_stu.course_id = student_mark.course_id      ";
		$query .= " 			AND detail_stu.course_detail_no = student_mark.course_detail_no   ";
			
		$query .= " LEFT JOIN  (   SELECT mark_rule.course_level       	 ";
		$query .= " 					, mark_rule.test_kbn       	 ";
		$query .= " 					, course.course_id        ";
		$query .= " 					, course_detail.course_detail_no        ";
		$query .= " 					, SUM(mark_detail.max_marks) marks        ";
		$query .= " 				FROM T_COURSE course   ";
		$query .= " 				INNER JOIN T_COURSE_DETAIL course_detail   ";
		$query .= " 					ON course.course_id = course_detail.course_id   ";
		$query .= " 					AND course.del_flg = '0'   ";
		$query .= " 				AND course_detail.del_flg = '0'   ";
		$query .= " 				INNER JOIN T_COURSE_DETAIL_QUESTION course_detail_qa   ";
		$query .= " 					ON course_detail.course_detail_no = course_detail_qa.course_detail_no   ";
		$query .= " 					AND course_detail_qa.del_flg = '0'  ";
		$query .= " 				INNER JOIN T_QUESTION ques   ";
		$query .= " 					ON course_detail_qa.question_no = ques.question_no   ";
		$query .= " 					AND ques.del_flg = '0'   ";
		$query .= " 				INNER JOIN  M_MARK_RULE mark_rule   ";
		$query .= " 					ON ques.score_pattern = mark_rule.score_pattern   ";
		$query .= " 					AND course.course_level = mark_rule.course_level   ";
		$query .= " 					AND course.test_kbn = mark_rule.test_kbn   ";
		$query .= " 				INNER JOIN  (  	SELECT  rule_no   ";
		$query .= " 										,SUM(max_marks) AS max_marks   ";
		$query .= " 								FROM (  SELECT rule_no  							,sub_rule_no   ";
		$query .= " 												,MAX(marks) AS max_marks   ";
		$query .= " 										FROM M_MARK_DETAIL   ";
		$query .= " 										WHERE del_flg = '0'   ";
		$query .= " 										GROUP BY rule_no,sub_rule_no ";
		$query .= " 									) AS max   ";
		$query .= " 								GROUP BY rule_no   ";
		$query .= " 							) mark_detail  	 ";
		$query .= " 				ON mark_rule.rule_no = mark_detail.rule_no   ";
		$query .= " 				GROUP BY mark_rule.course_level      ,mark_rule.test_kbn, course.course_id, course_detail.course_detail_no    ";
		$query .= " 			) as total_mark  ";
		$query .= " 	ON detail_stu.course_id = total_mark.course_id    ";
		$query .= " 	AND detail_stu.course_detail_no = total_mark.course_detail_no   ";
		$query .= " 	AND c.course_level =  total_mark.course_level   ";
		$query .= " 	AND c.test_kbn =  total_mark.test_kbn  ";

		return $query;
	}

	public function createSearchWhere ( $param ){

		$query = " WHERE ";
		$query .= "  '1' = '1' ";
		$query .= " AND detail_stu.del_flg = '0' ";

		if ( $param->answer_flg == 3 ){

			$query .= " AND answer.answer_dt IS NULL ";
		}elseif ( $param->answer_flg == 0 ){

			$query .= " AND answer.answer_dt IS NOT NULL ";
			$query .= " AND student_mark.result_marks IS NULL";
		}elseif ( $param->answer_flg == 1 ){

			$query .= " AND answer.answer_dt IS NOT NULL ";
			$query .= " AND student_mark.result_marks IS NOT NULL";
		}

		if ( ! StringUtil::isEmpty($param->detail_name) ){

			$query .= " AND (d.course_detail_name LIKE :course_detail_name OR d.course_detail_romaji LIKE :course_detail_romaji ) ";
		}

		if ( ! StringUtil::isEmpty($param->org_id) ){

			$query .= " AND m.org_id LIKE :org_id";
		}
		
		if ( ! StringUtil::isEmpty($param->student_name) ) {

			$query .= " AND (s.student_name LIKE :student_name  OR s.student_name_romaji LIKE :student_name_romaji) ";
		}

		// 20190830 - 受講者ログインID追加
		if ( ! StringUtil::isEmpty($param->login_id) ) {

			$query .= " AND s.login_id LIKE :login_id ";
		}	
		
		if ( !StringUtil::isEmpty($param->start_period) ) {
			$query .= " AND detail_stu.end_period >= :start_period ";
		}
		
		if ( !StringUtil::isEmpty($param->end_period) ) {
			$query .= " AND detail_stu.start_period <= :end_period ";
		}

		$query .= " GROUP BY cd.course_id ,co.offer_no,m.org_no,m.org_id,c.course_name,c.course_name_romaji,cd.course_detail_no,s.student_no,s.login_id,s.student_name,cd.disp_no,d.course_detail_name,d.course_detail_romaji,d.test_kbn,answer.answer_dt,total_mark.marks,student_mark.result_marks ";
		
		// 2019/09/05 表示順修正
		//$query .= " ORDER BY c.course_name, d.course_detail_name, s.login_id ";
		$query .= " ORDER BY detail_stu.start_period DESC, s.login_id ";
		return $query;
	}

	/**
	 * パラメータバインド
	 *
	 */
	public function setSearchParam($stmt, $param){

		if ( ! StringUtil::isEmpty($param->detail_name) ){

			$name =  '%'.$param->detail_name.'%';
			$stmt->bindParam(":course_detail_name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":course_detail_romaji", $name, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->org_id) ){

			$org_id =  '%'.$param->org_id.'%';
			$stmt->bindParam(":org_id", $org_id, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->end_period) ){

			$end_period = DateUtil::changeEndDateFormat($param->end_period);
			$stmt->bindParam(":end_period", $end_period, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->start_period) ){

			$start_period = $param->start_period;
			$stmt->bindParam(":start_period", $start_period, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->student_name) ) {

			$sname =  '%'.$param->student_name.'%';
			$stmt->bindParam(":student_name", $sname, PDO::PARAM_STR);
			$stmt->bindParam(":student_name_romaji", $sname, PDO::PARAM_STR);
		}

		// 20190830 - 受講者ログインID追加
		if (! StringUtil::isEmpty($param->login_id)) {
			$login_id=  '%'.$param->login_id.'%';
			$stmt->bindParam(":login_id",$login_id, PDO::PARAM_STR);
		}											  
	}
}