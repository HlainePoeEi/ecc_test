<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/M_LessonDto.php';
require_once 'dto/M_SubjectDto.php';
require_once 'dto/M_GradeDto.php';
require_once 'dto/M_Lesson_ManagerDto.php';
require_once 'dto/M_Lesson_Group_StudentDto.php';

/**
 * レッソンDAOクラス
 */
class M_LessonDao extends BaseDao {

	/**
	 * レッスン名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedLessonExistInfo($org_no,$lesson_name) {
		$query = " SELECT ";
		$query .= " lesson_no ";
		$query .= " FROM ";
		$query .= " M_LESSON ";
		$query .= " WHERE org_no = :org_no ";
		$query .= " AND lesson_name LIKE :lesson_name ";
		$query .= " AND del_flg = '0' ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no",  $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_name", $lesson_name, PDO::PARAM_STR );
		$list= parent::getDataList( $stmt, get_class(new M_LessonDto()) );
		return count( $list );
	}

	/**
	 * 学年を取得する
	 *
	 */
	public function getGradetListByName($org_no,$grade_name) {
		$query = " SELECT ";
		$query .= " grade_no ";
		$query .= ", grade_name ";
		$query .= ", disp_no ";
		$query .= ", del_flg ";
		$query .= " FROM M_GRADE ";
		$query .= " WHERE del_flg = '0' ";
		$query .= " AND org_no = :org_no  ";
		$query .= " AND grade_name = :grade_name  ";
		$query .= " ORDER BY disp_no";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":grade_name", $grade_name, PDO::PARAM_STR );
		$list = parent::getDataList ( $stmt, get_class ( new M_GradeDto () ) );
		return $list;
	}

	/**
	 * 教科名を取得する
	 *
	 */
	public function getSubjectListByName($org_no,$subject_name) {
		$query = "SELECT ";
		$query .= " sub.subject_name ";
		$query .= " ,sub.subject_no ";
		$query .= " ,subare.subject_area_name ";
		$query .= " ,subare.subject_area_no ";
		$query .= " FROM M_SUBJECT sub,M_SUBJECT_AREA subare ";
		$query .= " WHERE";
		$query .= " sub.org_no = :org_no ";
		$query .= "  AND sub.subject_name LIKE :subject_name ";
		$query .= " AND sub.del_flg = '0' ";
		$query .= " AND sub.org_no = subare.org_no ";
		$query .= " AND sub.subject_area_no = subare.subject_area_no ";
		$query .= " AND subare.del_flg = '0' ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":subject_name", $subject_name, PDO::PARAM_STR );
		$list = parent::getDataList ( $stmt, get_class ( new M_SubjectDto() ) );
		return $list;
	}

	/**
	 * 教科名により担当者を取得する
	 *
	 */
	public function getManagerListBySubject($org_no,$subject_no,$mLoginIdArr){
		$rs=array();
		$query = "SELECT t.manager_no,t.manager_name ";
		$query .= " FROM T_MANAGER t INNER JOIN ";
		$query .= " ( ";
		$query .= " SELECT tms.manager_no,subject_no ";
		$query .= " FROM  T_MANAGER_SUBJECT_AREA tms ";
		$query .= " INNER JOIN ";
		$query .= "(SELECT sub.subject_no ,subare.subject_area_no ";
		$query .= " FROM M_SUBJECT_AREA subare ";
		$query .= " INNER JOIN M_SUBJECT sub ";
		$query .= " ON subare.org_no = sub.org_no AND subare.subject_area_no = sub.subject_area_no ";
		$query .= " AND sub.org_no =:org_no AND sub.subject_no =:subject_no ";
		$query .= " AND sub.del_flg = '0' AND subare.del_flg = '0' ";
		$query .= " ) a ";
		$query .= " ON tms.subject_area_no = a.subject_area_no AND tms.org_no=:org_no1 AND tms.del_flg='0' ";
		$query .= " ) b ";
		$query .= " ON t.org_no=:org_no2 AND t.manager_no = b.manager_no AND t.login_id LIKE :login_id AND t.del_flg='0' ";
		$stmt = $this->pdo->prepare ( $query );
		foreach($mLoginIdArr as $login_id){
			$stmt->bindParam ( ":org_no", $org_no);
			$stmt->bindParam ( ":subject_no", $subject_no);
			$stmt->bindParam ( ":org_no1", $org_no);
			$stmt->bindParam ( ":org_no2", $org_no);
			$stmt->bindParam ( ":login_id", $login_id);
			$list = parent::getDataList ( $stmt, get_class ( new M_Lesson_ManagerDto() ) );
			if(count($list)<=0){
				$rs=array();
				break;
			}else{
				array_push($rs,$list);
			}
		}
		return $rs;
	}

	/**
	 * レッスン管理№を取得する
	 */
	public function getNextLessonNo() {
		return parent::getId ( "lesson_no" );
	}

	/***
	 * レッスン登録
	 * @param object $student_dto
	 * @param array $lm_dto_arr
	 * @return integer type
	 */
	public function insertData($less_dto,$lm_dto_arr , $pdo){
		$rs=1;
		try {
			
			// レッソンの登録実行
			$rs=parent::insertWithPdo ($less_dto , $pdo);
			if($rs==1){
				// レッソン担当者の登録実行
				if(count($lm_dto_arr)>0){
					$this->bulkInsertWithPdo ($lm_dto_arr , $pdo);
				}
				
			}
		} catch ( Exception $e ) {
			
			$rs=0;
		}
		return $rs;
	}
	/**
	 * データ抽出ためレッスン情報を取得処理
	 * @param $org_no:組織№   
	 * @param $param:画面からのデータ
	 * @return リスト
	 */
	public function getLessonCsvData($org_no,$params) {
		$query = $this->getQueryCsvData($org_no,$params);
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$stmt->bindParam ( ":start_period_start", $params->start_period_start, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$stmt->bindParam ( ":start_period_end", $params->start_period_end, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$stmt->bindParam ( ":end_period_start", $params->end_period_start, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$stmt->bindParam ( ":end_period_end", $params->end_period_end, PDO::PARAM_STR );
		}
		$list = parent::getDataList ( $stmt, get_class ( new M_LessonDto () ) );
		return $list;
	}
	/**
	 * データ抽出ためレッスン情報を取得クエリー
	 * @param $org_no:組織№   
	 * @param $param:画面からのデータ
	 * @return クエリー
	 */
	public function getQueryCsvData($org_no,$params){
		$query  = "";
		$query  .= " SELECT ";
		$query  .= " lesson.lesson_no ";
		$query  .= ",lesson.lesson_name ";
		$query  .= " ,lesson.lesson_name_kana ";
		$query  .= ",grade.grade_name ";
		$query .= ",date_format(lesson.start_period,'%Y/%m/%d') AS start_period ";
		$query .= ",date_format(lesson.end_period,'%Y/%m/%d') AS end_period ";
		$query  .= ",sub.subject_name ";
		$query  .= ",CASE WHEN lesson.status = '1' THEN 'する' ";
		$query  .= "WHEN lesson.status = '0' THEN 'しない' ";
		$query  .= "END AS lesson_status ";
		$query  .= ",lesson.remarks";
		$query  .= ",IFNULL(lesManager.num_manager, 0) AS managerCount ";
		$query  .= ",IFNULL(lesGroup.num_group, 0) AS groupCount ";
		$query  .= ",IFNULL(gp_student.num_student, 0) AS studentCount ";
		$query  .= ",date_format(lesson.create_dt,'%Y/%m/%d') AS create_dt ";
		$query  .= ",date_format(lesson.update_dt,'%Y/%m/%d') AS update_dt ";
		$query  .= "FROM M_LESSON lesson ";
		$query  .= "INNER JOIN M_SUBJECT sub ON ";
		$query  .= "lesson.org_no = sub.org_no ";
		$query  .= "AND lesson.subject_no = sub.subject_no ";
		$query  .= "AND lesson.del_flg = '0' ";
		$query  .= "AND sub.del_flg = '0' ";
		$query  .= "LEFT JOIN M_GRADE grade ";
		$query  .= "ON lesson.org_no = grade.org_no ";
		$query  .= "AND lesson.grade_no = grade.grade_no ";
		$query  .= "AND grade.del_flg = '0' ";
		$query  .= "LEFT JOIN ";
		$query  .= "(SELECT org_no, lesson_no ,del_flg ";
		$query  .= ", COUNT(manager_no) AS num_manager ";
		$query  .= "FROM M_LESSON_MANAGER GROUP BY lesson_no, org_no, del_flg )lesManager ";
		$query  .= "ON lesson.org_no = lesManager.org_no ";
		$query  .= "AND lesson.lesson_no = lesManager.lesson_no ";
		$query  .= "AND lesson.del_flg = '0' ";
		$query  .= "AND lesManager.del_flg = '0' ";
		$query  .= "LEFT JOIN ";
		$query  .= "(SELECT org_no, lesson_no, del_flg ";
		$query  .= ", COUNT(group_no) AS num_group ";
		$query  .= "FROM M_LESSON_TARGET GROUP BY lesson_no, org_no, del_flg )lesGroup ";
		$query  .= "ON lesson.org_no = lesGroup.org_no ";
		$query  .= "AND lesson.lesson_no = lesGroup.lesson_no ";
		$query  .= "AND lesGroup.del_flg = '0' ";
		$query  .= "LEFT JOIN ";
		$query  .= "(SELECT COUNT(gpStu.student_no) AS num_student,lesson_target.lesson_no,gpStu.org_no,gpStu.del_flg ";
		$query  .= "FROM T_GROUP_STUDENT gpStu ";
		$query  .= "LEFT JOIN T_GROUP gp ";
		$query  .= "ON gpStu.org_no = gp.org_no ";
		$query  .= "AND gpStu.group_no = gp.group_no ";
		$query  .= "LEFT JOIN M_LESSON_TARGET lesson_target ";
		$query  .= "ON gp.org_no = lesson_target.org_no ";
		$query  .= "AND gp.group_no = lesson_target.group_no ";
		$query  .= "AND lesson_target.del_flg = '0' ";
		$query  .= "GROUP BY lesson_target.lesson_no,gpStu.org_no,gpStu.del_flg ) gp_student ";
		$query  .= "ON lesson.org_no = gp_student.org_no ";
		$query  .= "AND lesson.lesson_no = gp_student.lesson_no ";
		$query  .= "WHERE lesson.org_no = :org_no ";
		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$query .= " AND lesson.start_period >= :start_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$query .= " AND lesson.start_period <= :start_period_end ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$query .= " AND lesson.end_period >= :end_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$query .= " AND lesson.end_period <= :end_period_end ";
		}
		$query  .= "GROUP BY lesson.lesson_no, lesson.lesson_name, lesson.lesson_name_kana, lesson.start_period, lesson.end_period, sub.subject_name, lesson.status, lesson.remarks, lesson.create_dt, lesson.update_dt, grade.grade_name, lesManager.num_manager, lesGroup.num_group, gp_student.num_student ";
		return $query;
	}

	public function getLessonGroupStudentCsvData($params){

		$query = "SELECT ";
		$query .= "lesson.lesson_no ";
		$query .= ",lesson.lesson_name ";
		$query .= ",grade.grade_name AS gradeName ";
		$query .= ",date_format(lesson.start_period,'%Y/%m/%d') AS lesson_start_period ";
		$query .= ",date_format(lesson.end_period,'%Y/%m/%d') AS lesson_end_period ";
		$query .= ",gp.group_no ";
		$query .= ",gp.group_name ";
		$query .= ", (SELECT grade.grade_name FROM M_GRADE grade where grade.grade_no = gp.grade_no AND grade.org_no = gp.org_no and gp.del_flg='0') AS groupGradeName ";
		$query .= ",date_format(gp.start_period,'%Y/%m/%d') AS gp_start_period ";
		$query .= ",date_format(gp.end_period,'%Y/%m/%d') AS gp_end_period ";
		$query .= ",student.student_no ";
		$query .= ",student.login_id ";
		$query .= ",student.student_name ";
		$query .= ",student.no ";
		$query .= ",student.sex ";
		$query .= ",date_format(student.enroll_dt,'%Y/%m/%d') AS stu_enroll_dt ";
		$query .= ",date_format(student.graduation_dt,'%Y/%m/%d') AS stu_graduation_dt ";
		$query .= "FROM M_LESSON lesson ";
		$query .= "LEFT JOIN M_GRADE grade ";
		$query .= "ON lesson.org_no = grade.org_no ";
		$query .= "AND lesson.grade_no = grade.grade_no ";
		$query .= "AND lesson.del_flg = '0' ";
		$query .= "AND grade.del_flg = '0' ";
		$query .= "LEFT JOIN M_LESSON_TARGET lessonTarget ";
		$query .= "ON lesson.org_no = lessonTarget.org_no ";
		$query .= "AND lesson.lesson_no = lessonTarget.lesson_no ";
		$query .= "AND lessonTarget.del_flg = '0' ";
		$query .= "LEFT JOIN T_GROUP gp ";
		$query .= "ON lessonTarget.org_no = gp.org_no ";
		$query .= "AND lessonTarget.group_no = gp.group_no ";
		$query .= "AND gp.del_flg = '0' ";
		$query .= "LEFT JOIN T_GROUP_STUDENT gpStu ";
		$query .= "ON gp.org_no = gpStu.org_no ";
		$query .= "AND gp.group_no = gpStu.group_no ";
		$query .= "AND gpStu.del_flg = '0' ";
		$query .= "LEFT JOIN T_STUDENT student ";
		$query .= "ON gpStu.org_no = student.org_no ";
		$query .= "AND gpStu.student_no = student.student_no ";
		$query .= "AND student.del_flg = '0' ";
		$query .= "WHERE lesson.org_no = :org_no ";

		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$query .= " AND lesson.start_period >= :start_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$query .= " AND lesson.start_period <= :start_period_end ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$query .= " AND lesson.end_period >= :end_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$query .= " AND lesson.end_period <= :end_period_end ";
		}

		$query .= "ORDER BY lesson.lesson_no ASC ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $params->org_no, PDO::PARAM_STR );

		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$stmt->bindParam ( ":start_period_start", $params->start_period_start, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$stmt->bindParam ( ":start_period_end", $params->start_period_end, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$stmt->bindParam ( ":end_period_start", $params->end_period_start, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$stmt->bindParam ( ":end_period_end", $params->end_period_end, PDO::PARAM_STR );
		}

		return parent::getDataList( $stmt, get_class(new M_Lesson_Group_StudentDto()));
	}


}

?>