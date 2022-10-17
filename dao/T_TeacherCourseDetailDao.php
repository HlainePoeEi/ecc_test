<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Teacher_Course_DetailDto.php';
require_once 'dto/T_DetailDto.php';

/**
 * T_TeacherCourseDetailDAOクラス
 */
class T_TeacherCourseDetailDao extends BaseDao {

	public function getCourseDetailData($param) {

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;

		$query = "SELECT";
		$query .= " DISTINCT detail.course_detail_no AS course_detail_no";
		$query .= " ,detail.course_detail_name AS course_detail_name";
		$query .= " ,detail.course_detail_romaji AS course_detail_romaji";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category = :test_kbn AND a.type = detail.test_kbn) AS test_kbn";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category = :course_level AND a.type = detail.course_level) AS course_level";
		$query .= " FROM T_DETAIL AS detail";
		$query .= " INNER JOIN M_TYPE AS m_type1";
		$query .= " ON detail.test_kbn = m_type1.type";
		$query .= " INNER JOIN M_TYPE AS m_type2";
		$query .= " ON detail.course_level = m_type2.type";
		$query .= " WHERE m_type1.category = :test_kbn_category";
		$query .= " AND m_type2.category = :course_level_category";
		$query .= " AND detail.status = 1";
		$query .= " AND detail.del_flg = '0' ";

		if ( ! StringUtil::isEmpty($param->search_test_kbn) ) {
			$query .= " AND detail.test_kbn IN (".$param->search_test_kbn.")";
		}

		if ( ! StringUtil::isEmpty($param->search_course_level) ) {
			$query .= " AND detail.course_level IN (".$param->search_course_level.")";
		}
		$query .= " ORDER BY course_detail_no";

		$stmt = $this->pdo->prepare ( $query);

		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);
		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn_category", $test_kbn, PDO::PARAM_STR);
		$stmt->bindParam(":course_level_category", $course_level, PDO::PARAM_STR);

		return parent::getDataList( $stmt, get_class(new T_DetailDto()) );
	}

	public function getCourseDetailRegisterData($teacher_no) {

		$query = "SELECT";
		$query .= " teacher_course_detail.teacher_no";
		$query .= " ,teacher_course_detail.course_detail_no";
		$query .= " FROM T_TEACHER_COURSE_DETAIL teacher_course_detail";
		$query .= " WHERE";
		$query .= " teacher_course_detail.teacher_no = :teacher_no";
		$query .= " AND teacher_course_detail.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query);

		$stmt->bindParam(":teacher_no", $teacher_no, PDO::PARAM_STR);

		return parent::getDataList( $stmt, get_class(new T_Teacher_Course_DetailDto()) );
	}

	public function deleteCourseDetailData($teacher_no , $pdo) {

		$query = "DELETE";
		$query .= " FROM";
		$query .= " T_TEACHER_COURSE_DETAIL";
		$query .= " WHERE";
		$query .= " teacher_no = :teacher_no";

		$stmt = $pdo->prepare ( $query );

		$stmt->bindParam ( ":teacher_no", $teacher_no, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}
}

?>