<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_Course_StudentDto.php';
require_once 'dto/T_DetailDto.php';
require_once 'dto/T_StudentDto.php';
require_once 'conf/config.php';
require_once 'dto/T_Course_Detail_StudentDto.php';
/**
 * T_Course_StudentDAOクラス
 */

class T_Course_StudentDao extends BaseDao {

	public function getOrganizationData($param){

		$query = "SELECT";
		$query .= " org.org_no as org_no";
		$query .= " ,org.org_name as org_name";
		$query .= " ,org.org_name_official as org_name_official";
		$query .= " ,org.org_id as org_id";
		$query .= " ,course.course_id as course_id";
		$query .= " ,course.course_name as course_name";
		$query .= " ,course.course_name_romaji as  course_name_romaji";
		$query .= " ,date_format(course_org.start_period,'%Y/%m/%d') as start_period";
		$query .= " ,date_format(course_org.end_period,'%Y/%m/%d') as end_period";
		$query .= " FROM T_COURSE_ORG course_org";
		$query .= " INNER JOIN M_ORGANIZATION org";
		$query .= " ON course_org.org_no = org.org_no";
		$query .= " INNER JOIN T_COURSE course";
		$query .= " ON course_org.course_id = course.course_id";
		$query .= " WHERE course_org.offer_no = :offer_no";
		$query .= " AND course_org.org_no = :org_no";
		$query .= " AND course_org.course_id = :course_id";
		$query .= " AND course_org.del_flg=0";
		$query .= " AND org.del_flg=0";
		$query .= " AND course.del_flg=0";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":offer_no", $param->offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $param->course_id, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_Course_StudentDto()) );
	}

	public function getCourseDetailByCourseId($course_id){

		$query = "SELECT";
		$query .= " detail.course_detail_no as course_detail_no";
		$query .= " ,detail.course_detail_name as course_detail_name";
		$query .= " ,detail.course_detail_romaji as course_detail_romaji";
		$query .= " ,date_format(detail.start_period,'%Y/%m/%d') as start_period";
		$query .= " ,date_format(detail.end_period,'%Y/%m/%d') as end_period";
		$query .= " ,GROUP_CONCAT(tdetail.teacher_no) as teacher_no";
		$query .= " ,course_detail.disp_no";
		$query .= " FROM T_COURSE_DETAIL course_detail";
		$query .= " INNER JOIN T_DETAIL detail";
		$query .= " ON detail.course_detail_no = course_detail.course_detail_no";
		
		// 2022/07/05 採点講師取得
		$query .= " LEFT JOIN T_TEACHER_COURSE_DETAIL tdetail";
		$query .= " ON detail.course_detail_no = tdetail.course_detail_no";
		$query .= " AND tdetail.del_flg = 0";
		
		$query .= " WHERE course_detail.course_id = :course_id";
		$query .= " AND course_detail.del_flg = 0";
		$query .= " AND detail.del_flg = 0";
		// 2022/07/05 採点講師取得
		$query .= " GROUP BY course_detail_no,course_detail_name,course_detail_romaji,start_period,end_period,course_detail.disp_no ";
		$query .= " ORDER BY course_detail.disp_no";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_DetailDto()) );
	}

	/**
	 * コース受講者登録処理
	 */
	public function getStudentListByGroupAndLoginId($param){

		$sysDate = DateUtil::getDate("Y/m/d"); //20190614 - グループと受講者の利用期間のチェック

		$query = "SELECT";
		$query .= " DISTINCT student.student_no as student_no";
		$query .= " ,student.student_name as student_name";
		$query .= " ,student.login_id as login_id";
		$query .= " FROM T_STUDENT as student";
		$query .= " LEFT JOIN T_GROUP_STUDENT as group_student";
		$query .= " ON group_student.org_no = student.org_no ";
		$query .= " AND group_student.student_no = student.student_no";
		$query .= " AND student.del_flg = 0";
		$query .= " AND group_student.del_flg = 0";
		$query .= " LEFT JOIN T_GROUP AS groups";
		$query .= " ON groups.org_no = group_student.org_no ";
		$query .= " AND groups.group_no = group_student.group_no";
		$query .= " AND groups.del_flg = '0' ";
		$query .= " WHERE student.org_no = :org_no";

		if (! StringUtil::isEmpty($param->search_login_id)){
			$query .= " AND student.login_id LIKE :login_id";
		}

		if (! StringUtil::isEmpty($param->search_group)){
			$query .= " AND groups.group_name LIKE :group_name";
			$query .= " AND groups.end_period >= :GsysDate "; //20190614 - グループと受講者の利用期間のチェック
		}

		$query .= " AND student.student_no NOT IN ";
		$query .= " (SELECT";
		$query .= " DISTINCT student.student_no as student_no";
		$query .= " FROM T_STUDENT student";
		$query .= " LEFT JOIN T_COURSE_STUDENT course_student";
		$query .= " ON course_student.org_no = student.org_no";
		$query .= " AND course_student.student_no = student.student_no";
		$query .= " AND student.del_flg = 0";
		$query .= " AND course_student.del_flg = 0";
		$query .= " WHERE student.org_no = :student_org_no";
		$query .= " AND course_student.offer_no = :offer_no";
		$query .= " AND course_student.course_id = :course_id";

		if (! StringUtil::isEmpty($param->search_login_id)){
			$query .= " AND student.login_id LIKE :student_login_id";
		}
		$query .= " )";

		//20190614 - グループと受講者の利用期間のチェック
		$query .= " AND student.graduation_dt >= :SsysDate "; //20190614 - グループと受講者の利用期間のチェック

		$query .= " ORDER BY student.login_id";
		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty($param->search_login_id) ){
			$login_id = $param->search_login_id.'%';
			$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );
			$stmt->bindParam ( ":student_login_id", $login_id, PDO::PARAM_STR );
		}

		if (! StringUtil::isEmpty($param->search_group)){
			$group_name = $param->search_group."%";
			$stmt->bindParam ( ":group_name", $group_name, PDO::PARAM_STR );
			$stmt->bindParam ( ":GsysDate", $sysDate, PDO::PARAM_STR ); //20190614 - グループと受講者の利用期間のチェック
		}

		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":offer_no", $param->offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":student_org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $param->course_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":SsysDate", $sysDate, PDO::PARAM_STR ); //20190614 - グループと受講者の利用期間のチェック

		return parent::getDataList( $stmt, get_class(new T_StudentDto()) );
	}

	/**
	 * 組織情報を新規登録する
	 */
	public function saveCourseStudent($dto , $pdo){

		return parent::insertWithPdo ( $dto , $pdo);

	}

	public function delCourseStudentData($dto) {

		$query = "UPDATE ";
		$query .= "T_COURSE_STUDENT SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE offer_no = :offer_no ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND student_no = :student_no; ";


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

		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	public function getCourseStudentData($dto) {

		$query = "SELECT  ";
		$query .= " offer_no ";
		$query .= " ,org_no ";
		$query .= " ,course_id ";
		$query .= " ,student_no ";
		$query .= " FROM T_COURSE_STUDENT ";
		$query .= " WHERE offer_no = :offer_no ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND student_no = :student_no; ";


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

		return parent::getDataList( $stmt, get_class(new T_Course_StudentDto()) );
	}
	
	public function getCourseDetailStudentData($dto) {

		$query = "SELECT  ";
		$query .= " offer_no ";
		$query .= " ,org_no ";
		$query .= " ,course_id ";
		$query .= " ,course_detail_no ";
		$query .= " ,student_no ";
		$query .= " FROM T_COURSE_DETAIL_STUDENT ";
		$query .= " WHERE offer_no = :offer_no ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND course_detail_no = :course_detail_no ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND student_no = :student_no; ";


		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}
		
		if ( ! StringUtil::isEmpty ( $dto->course_detail_no ) ){
			$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no ) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->student_no) ){
			$stmt->bindParam ( ":student_no", $dto->student_no, PDO::PARAM_STR );
		}

		return parent::getDataList( $stmt, get_class(new T_Course_Detail_StudentDto()) );
	}

}