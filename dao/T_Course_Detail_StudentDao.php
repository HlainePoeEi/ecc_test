<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'conf/config.php';
/**
 * T_Course_Detail_StudentDAOクラス
 */

class T_Course_Detail_StudentDao extends BaseDao {
	/**
	 * 組織情報を新規登録する
	 */
	public function saveCourseDetail($dto , $pdo){

		return parent::insertWithPdo ( $dto , $pdo);

	}
	/**
	 * 受講生コース詳細一覧
	 */
	public function getStudentCourseDetailList($param, $course_detail_no){

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;

		$query = " SELECT DISTINCT";
		$query .= " m_org.org_no ";
		$query .= " ,m_org.org_id ";
		$query .= " ,m_org.org_name ";
		$query .= " ,m_org.org_name_official ";
		$query .= " ,course.course_id ";
		$query .= " ,course.course_name ";
		$query .= " ,course.remarks ";
		$query .= " ,detail.course_detail_name ";
		$query .= " ,detail.course_detail_romaji ";
		$query .= " ,detail.course_detail_no ";
		$query .= " ,course_detail.disp_no ";
		$query .= " ,detail.status ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=detail.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=detail.test_kbn) AS test_kbn ";
		$query .= " ,date_format(course_org.start_period,'%Y/%m/%d') AS start_period ";
		$query .= " ,date_format(course_org.end_period,'%Y/%m/%d') AS end_period ";
		$query .= " ,student.student_no ";
		$query .= " ,student.student_name ";
		$query .= " ,student.student_name_romaji ";
		$query .= " ,student.login_id ";
		$query .= " ,date_format(detail_student.start_period,'%Y/%m/%d') AS stu_course_start_period";
		$query .= " ,date_format(detail_student.end_period,'%Y/%m/%d') AS stu_course_end_period";
		$query .= " ,date_format(skill_answer.answer_dt,'%Y/%m/%d') AS answer_dt ";
		$query .= " ,date_format(skill_result.update_dt,'%Y/%m/%d') AS update_dt";

		$query .= " FROM ";
		$query .= "T_COURSE course ";
		$query .= " LEFT JOIN T_COURSE_ORG as course_org ";
		$query .= " ON course_org.course_id = course.course_id ";
		$query .= " LEFT JOIN M_ORGANIZATION as m_org ";
		$query .= " ON course_org.org_no = m_org.org_no ";
		$query .= " LEFT JOIN T_COURSE_DETAIL as course_detail  ";
		$query .= " ON course.course_id = course_detail.course_id  ";
		$query .= " LEFT JOIN T_DETAIL as detail ";
		$query .= " ON course_detail.course_detail_no = detail.course_detail_no ";
		$query .= " LEFT JOIN T_COURSE_DETAIL_STUDENT as detail_student ";
		$query .= " ON detail_student.offer_no = course_org.offer_no ";
		$query .= " AND detail_student.org_no = m_org.org_no ";
		$query .= " AND detail_student.course_id = course.course_id ";
		$query .= " AND detail_student.course_detail_no = course_detail.course_detail_no ";
		$query .= " LEFT JOIN T_STUDENT as student";
		$query .= " ON detail_student.student_no = student.student_no ";
		$query .= " AND m_org.org_no = student.org_no";

		//20190822-4技能のSpeaking受講する、解答時間の日付
		$query .= " LEFT JOIN ( ";
		$query .= " SELECT answer.offer_no offer_no ";
		$query .= " ,answer.course_id course_id ";
		$query .= " ,answer.course_detail_no course_detail_no ";
		$query .= " ,answer.student_no student_no ";
		$query .= " ,MIN(answer.answer_dt) answer_dt ";//20190827 - 受講時間取得修正
		$query .= " FROM T_COURSE_DETAIL_QUESTION cdques  ";
		$query .= " LEFT JOIN T_4SKILL_ANSWER as answer";
		$query .= " ON answer.course_detail_no = cdques.course_detail_no ";
		$query .= " AND answer.question_no = cdques.question_no ";
		$query .= " AND answer.del_flg = 0 ";
		$query .= " AND cdques.del_flg = 0 ";
		$query .= " GROUP BY offer_no ,course_id ,course_detail_no, student_no ) skill_answer ";
		$query .= " ON skill_answer.offer_no = course_org.offer_no ";
		$query .= " AND skill_answer.student_no = student.student_no ";
		$query .= " AND skill_answer.course_id = course.course_id ";
		$query .= " AND skill_answer.course_detail_no = course_detail.course_detail_no ";

		$query .= " LEFT JOIN T_4SKILL_RESULT as skill_result";
		$query .= " ON skill_result.offer_no = course_org.offer_no ";
		$query .= " AND skill_result.student_no = student.student_no ";
		$query .= " AND skill_result.course_id = course.course_id ";
		$query .= " AND skill_result.course_detail_no = course_detail.course_detail_no ";
		$query .= " AND skill_result.del_flg = 0 ";

		$query .= " WHERE course.course_id = :course_id ";
		if (!StringUtil::isEmpty($course_detail_no)){
			$query .= " AND course_detail.course_detail_no = :course_detail_no ";
		}

		$query .= " AND student.student_no = :student_no ";
		$query .= " AND m_org.org_no = :org_no ";
		$query .= " AND course_org.offer_no = :offer_no ";

		$query .= " AND course.del_flg = '0' ";
		$query .= " AND course_detail.del_flg = '0' ";
		$query .= " AND detail.del_flg = '0' ";
		$query .= " AND detail_student.del_flg = '0' ";
		$query .= " AND m_org.del_flg = '0' ";
		$query .= " GROUP BY ";
		$query .= " org_no,org_id, org_name,org_name_official,course_id,course_name,remarks,course_detail_name,course_detail_romaji,course_detail_no,disp_no,status,course_level,test_kbn,start_period,end_period,student_no,student_name,login_id,stu_course_end_period,stu_course_start_period,answer_dt,update_dt";
		$query .= " ORDER BY ";
		$query .= " course_detail.disp_no ASC ";

		$stmt = $this->pdo->prepare ( $query );
		
		LogHelper::logDebug($query);

		$stmt->bindParam ( ":offer_no", $param->offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $param->course_id, PDO::PARAM_STR );
		if ( ! StringUtil::isEmpty($course_detail_no) ){
			$stmt->bindParam ( ":course_detail_no", $course_detail_no, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":student_no", $param->student_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_level", $course_level, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_kbn", $test_kbn, PDO::PARAM_STR );

		$list= parent::getDataList( $stmt, get_class(new T_Course_Detail_StudentDto()) );
		return $list;
	}

	/**
	 * 受講生コース詳細更新
	 */
	public function updateStudentCoursePeriod($dto) {
		$query = "UPDATE";
		$query .= " T_COURSE_DETAIL_STUDENT";
		$query .= " SET";
		$query .= " start_period = :stu_course_start_period ";
		$query .= " ,end_period = :stu_course_end_period ";
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND offer_no = :offer_no ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND student_no = :student_no ";
		$query .= " AND course_detail_no = :course_detail_no ";
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":student_no", $dto->student_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":stu_course_start_period", $dto->stu_course_start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":stu_course_end_period", $dto->stu_course_end_period, PDO::PARAM_STR );

		return parent::update ( $stmt );
	}

	public function delCourseDetailStudentData($dto) {

		$query = "UPDATE ";
		$query .= "T_COURSE_DETAIL_STUDENT SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE offer_no = :offer_no ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND student_no = :student_no ";
		$query .= " AND course_detail_no = :course_detail_no ";//20190617-削除条件追加

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no ) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->student_no) ){
			$stmt->bindParam ( ":student_no", $dto->student_no, PDO::PARAM_STR );
		}

		//20190617-削除条件追加
		if ( ! StringUtil::isEmpty ( $dto->course_detail_no) ){
			$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}
}
?>