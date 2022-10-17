<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Course_DetailDto.php';
require_once 'dto/T_Course_Detail_StudentDto.php';
require_once 'conf/config.php';

/**
 * T_Course_DetailDAOクラス
 */

class T_Course_DetailDao extends BaseDao {

	public function getDetailListOnCourse($param, $offset){

		$course_level = COURSE_LEVEL_KBN;
		$test_kbn = TEST_KBN;

		$query = " SELECT ";
		$query .= " @rownum:=@rownum+1 as rowno ";
		$query .= " ,c.course_id ";
		$query .= " ,d.course_detail_name ";
		$query .= " ,d.course_detail_romaji ";
		$query .= " ,d.course_detail_no ";
		$query .= " ,d.status ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:course_level AND a.type=d.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:test_kbn AND a.type=d.test_kbn) AS test_kbn ";
		$query .= " ,date_format(d.start_period,'%Y/%m/%d') AS start_period ";
		$query .= " ,date_format(d.end_period,'%Y/%m/%d') AS end_period ";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " ,T_COURSE c ";
		$query .= " LEFT JOIN T_COURSE_DETAIL as cd ";
		$query .= " ON c.course_id = cd.course_id ";
		$query .= " LEFT JOIN T_DETAIL as d ";
		$query .= " ON cd.course_detail_no = d.course_detail_no ";

		$query .= " WHERE c.course_id = :course_id ";

		$query .= " AND c.del_flg = '0' ";
		$query .= " AND d.del_flg = '0' ";
		$query .= " AND cd.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " cd.disp_no ASC ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":course_id", $param->course_id, PDO::PARAM_STR );

		$stmt->bindParam(":course_level", $course_level, PDO::PARAM_STR);
		$stmt->bindParam(":test_kbn", $test_kbn, PDO::PARAM_STR);

		$list= parent::getDataList( $stmt, get_class(new T_Course_DetailDto()) );
		return $list;
	}

	public function getSearchDetailList($param, $offset){

		$tcourse_level = COURSE_LEVEL_KBN;
		$ttest_kbn = TEST_KBN;

		$query = " SELECT DISTINCT ";
		$query .= "@rownum:=@rownum+1 as rowno ";
		$query .= " ,d.course_detail_no ";
		$query .= " ,d.course_detail_name ";
		$query .= " ,d.course_detail_romaji ";
		$query .= " ,d.course_detail_no ";
		$query .= " ,d.status ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:tcourse_level AND a.type=d.course_level) AS course_level ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category=:ttest_kbn AND a.type=d.test_kbn) AS test_kbn ";
		$query .= " ,date_format(d.start_period,'%Y/%m/%d') AS start_period ";
		$query .= " ,date_format(d.end_period,'%Y/%m/%d') AS end_period ";

		$query .= " FROM ";
		$query .= " (SELECT @rownum:=$offset) as dummy ";
		$query .= " , T_DETAIL d ";

		$query .= " WHERE d.del_flg = '0' ";


		if ( ! StringUtil::isEmpty($param->course_detail_name) ) {
			$query .= " AND (d.course_detail_name LIKE :course_detail_name OR d.course_detail_romaji LIKE :course_detail_romaji ) ";
		}

		if ( ! StringUtil::isEmpty($param->course_level) ) {
			$query .= " AND (d.course_level = :course_level ) ";
		}

		if ( ! StringUtil::isEmpty($param->test_kbn) ) {
			$query .= " AND d.test_kbn = :test_kbn  ";
		}

		if ( ! StringUtil::isEmpty($param->rd_status) ) {
			$query .= " AND d.status = :rd_status  ";
		}

		$stmt = $this->pdo->prepare ( $query);

		$stmt->bindParam(":tcourse_level", $tcourse_level, PDO::PARAM_STR);
		$stmt->bindParam(":ttest_kbn", $ttest_kbn, PDO::PARAM_STR);

		if ( ! StringUtil::isEmpty($param->course_detail_name) ) {
			$name = '%'.$param->course_detail_name.'%';
			$stmt->bindParam(":course_detail_name",$name, PDO::PARAM_STR);
			$stmt->bindParam(":course_detail_romaji", $name, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty ( $param->course_level ) ) {
			$stmt->bindParam ( ":course_level", $param->course_level, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $param->test_kbn ) ) {
			$stmt->bindParam ( ":test_kbn", $param->test_kbn, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty($param->rd_status) ) {
			$stmt->bindParam ( ":rd_status",  $param->rd_status, PDO::PARAM_STR );
		}

		$list = parent::getDataList( $stmt, get_class(new T_Course_DetailDto()) );
		return $list;
	}

	public function countExistingDetail($course_id) {

		$query = " SELECT ";
		$query .= " count(course_detail_no) ";
		$query .= " FROM ";
		$query .= " T_COURSE_DETAIL ";
		$query .= " WHERE ";
		$query .= " course_id = :course_id ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );

		$stmt->execute ();
		return $stmt->fetchColumn ();
	}

	public function deleteDetailOnCourse($course_id , $pdo) {

		$query = " DELETE ";
		$query .= " FROM ";
		$query .= " T_COURSE_DETAIL ";
		$query .= " WHERE ";
		$query .= " course_id = :course_id ";
		$stmt = $pdo->prepare ( $query );
		$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );
		$stmt->execute ();
		return;
	}

	public function getCourseDetailListByCourseDetailNo($param){

		$test_kbn = TEST_KBN;
		$course_level = COURSE_LEVEL_KBN;
		$score_pattern = SCORE_PATTERN;

		if ( $param->search_test_kbn_type == 001 ) {
			$pattern = SQA_PATTERN;
		} else {
			$pattern = WQA_PATTERN;
		}

		$query = "SELECT";
		$query .= " DISTINCT course.course_id AS course_id";
		$query .= " ,course.test_kbn AS test_kbn";
		$query .= " ,M_TYPE2.name AS test_kbn_name";
		$query .= " ,M_TYPE1.name AS course_level";
		$query .= " ,course.course_name AS course_name";
		$query .= " ,course.course_name_romaji AS course_name_romaji";
		$query .= " ,detail.course_detail_no AS course_detail_no";
		$query .= " ,detail.course_detail_name AS course_detail_name";
		$query .= " ,detail.course_detail_romaji AS course_detail_romaji";
		$query .= " ,course_detail.disp_no AS disp_no";
		$query .= " ,course.remarks AS remarks";
		$query .= " ,course.create_dt AS date";

		$query .= " FROM T_COURSE AS course";
		$query .= " INNER JOIN T_COURSE_DETAIL AS course_detail";
		$query .= " ON course.course_id = course_detail.course_id";
		$query .= " INNER JOIN T_DETAIL AS detail";
		$query .= " ON course_detail.course_detail_no = detail.course_detail_no";

		$query .= " INNER JOIN M_TYPE AS M_TYPE1";
		$query .= " ON course.course_level = M_TYPE1.type";
		$query .= " INNER JOIN M_TYPE AS M_TYPE2";
		$query .= " ON course.test_kbn = M_TYPE2.type";

		$query .= " WHERE course.course_id = :course_id";
		$query .= " AND M_TYPE1.category = :course_level";
		$query .= " AND M_TYPE2.category = :test_kbn";
		$query .= " AND course.course_level = detail.course_level";
		$query .= " AND course.test_kbn = detail.test_kbn";
		$query .= " AND detail.course_detail_no = :course_detail_no";

		$query .= " AND course.del_flg = 0";
		$query .= " AND course_detail.del_flg = 0";
		$query .= " AND detail.del_flg = 0";
		$query .= " AND M_TYPE1.del_flg = 0";
		$query .= " ORDER BY course_detail.disp_no ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":course_id", $param->search_course_id,  PDO::PARAM_STR );
		$stmt->bindParam ( ":course_level", $course_level,  PDO::PARAM_STR );
		$stmt->bindParam ( ":test_kbn", $test_kbn,  PDO::PARAM_STR );
		$stmt->bindParam ( ":course_detail_no", $param->search_course_detail_no,  PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_Course_DetailDto()) );
	}

}