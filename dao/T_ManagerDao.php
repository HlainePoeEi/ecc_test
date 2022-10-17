<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_ManagerDto.php';
require_once 'dto/T_Manager_SubjectArea_LessonDto.php';

/**
 * 管理者教師DAOクラス
 */
class T_ManagerDao extends BaseDao {

	/**
	 * 組織管理№より組織情報と組織管理者情報を取得する
	 */
	public function getMangerInfo($org_no) {

		$manager_kbn = MAIN_ADMIN_KBN;

		$query = " SELECT ";
		$query .= " org.org_no org_no";
		$query .= " ,org.org_id org_id";
		$query .= " ,org.org_name org_name";
		$query .= " ,org.org_name_kana org_name_kana";
		$query .= " ,org.org_name_official org_name_official";
		$query .= " ,manager.manager_no manager_no";
		$query .= " ,manager.manager_name manager_name";
		$query .= " ,manager.manager_name_kana manager_name_kana";
		$query .= " ,manager.login_id login_id";
		$query .= " ,manager.password password";
		$query .= ' ,date_format(manager.start_period,'."'%Y/%m/%d') as start_period";
		$query .= ' ,date_format(manager.end_period,'."'%Y/%m/%d') as end_period";
		$query .= " ,manager.mail_address mail_address";
		$query .= " ,manager.remarks remarks";
		$query .= " FROM ";
		$query .= " M_ORGANIZATION org";
		$query .= " ,T_MANAGER manager";
		$query .= " WHERE";
		$query .= " manager.org_no = :org_no ";
		$query .= " AND org.del_flg = '0' ";
		$query .= " AND org.org_no = manager.org_no ";
		$query .= " AND manager.manager_kbn = :manager_kbn ";

		$stmt = $this->pdo->prepare ( $query );


		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":manager_kbn", $manager_kbn, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class(new T_ManagerDto()) );
	}

	/**
	 * 管理者情報更新処理
	 *
	 * @param $dto
	 */
	public function updateItemInfo($dto){

		$query = " UPDATE ";
		$query .= " T_MANAGER ";
		$query .= " SET";

		if (!StringUtil::isEmpty($dto->manager_name)){
			$query .= " manager_name  = :manager_name ";
		}

		if (!StringUtil::isEmpty($dto->manager_name_kana)){
			$query .= " ,manager_name_kana  = :manager_name_kana ";
		}

		if (!StringUtil::isEmpty($dto->login_id)){
			$query .= " ,login_id  = :login_id ";
		}

		if (!StringUtil::isEmpty($dto->password)){
			$query .= " ,password  = :password ";
		}

		if (!StringUtil::isEmpty($dto->start_period)){
			$query .= " ,start_period  = :start_period ";
		}

		if (!StringUtil::isEmpty($dto->end_period)){
			$query .= " ,end_period  = :end_period ";
		}

		if (!StringUtil::isEmpty($dto->pw_update_dt)){
			$query .= " ,pw_update_dt  = :pw_update_dt ";
		}

		$query .= " ,mail_address  = :mail_address ";
		$query .= " ,remarks  = :remarks ";
		$query .= " ,update_dt   = :update_dt ";
		$query .= " ,updater_id  = :updater_id ";
		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND manager_no = :manager_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );


		if (!StringUtil::isEmpty($dto->manager_name)){
			$stmt->bindParam ( ":manager_name",  $dto->manager_name, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->login_id)){
			$stmt->bindParam ( ":login_id",  $dto->login_id, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->manager_name_kana)){
			$stmt->bindParam ( ":manager_name_kana",  $dto->manager_name_kana, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->password)){
			$stmt->bindParam ( ":password",  $dto->password, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->start_period)){
			$stmt->bindParam ( ":start_period",  $dto->start_period, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->end_period)){
			$stmt->bindParam ( ":end_period",  $dto->end_period, PDO::PARAM_STR );
		}

		if (!StringUtil::isEmpty($dto->pw_update_dt)){
			$stmt->bindParam ( ":pw_update_dt",  $dto->pw_update_dt, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":mail_address",  $dto->mail_address, PDO::PARAM_STR );
		$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":manager_no",  $dto->manager_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

	/**
	 * 次の管理者IDを取得する
	 *
	 * @param $dto
	 */
	public function getNextId() {

		return parent::getId( "manager_no" );
	}

	/**
	 * 存在チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($org_no, $login_id){

		$limitedDate = DateUtil::getDate("Y/m/d h:i:s");

		$query = " SELECT ";
		$query .= " manager.org_no org_no";
		$query .= " FROM ";
		$query .= " T_MANAGER manager";
		$query .= " WHERE";
		$query .= " manager.org_no = :org_no ";
		$query .= " AND manager.login_id = :login_id ";
		$query .= " AND manager.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );

		$list= parent::getDataList( $stmt, get_class(new T_ManagerDto()) );
		return count($list);
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
	 * データ抽出ため組織管理№より担当者情報を取得する
	 */
	public function getMangerCsvData($org_no) {

		$query = " SELECT ";
		$query .= " manager.manager_no ";
		$query .= " ,manager.manager_name ";
		$query .= " ,manager.manager_name_kana ";
		$query .= " ,manager.login_id ";
		$query .= " ,manager.mail_address ";
		$query .= " ,(SELECT name FROM M_TYPE t ";
		$query .= " WHERE category=:category AND t.type=manager.manager_kbn) AS manager_kbn ";
		$query .= " ,COUNT(managerSubArea.subject_area_no)AS subjectArea ";
		$query .= " ,date_format(manager.start_period,'%Y/%m/%d') as start_period";
		$query .= " ,date_format(manager.end_period,'%Y/%m/%d') as end_period";
		$query .= " ,manager.remarks ";
		$query .= " ,date_format(manager.create_dt,'%Y/%m/%d') as create_dt";
		$query .= " ,date_format(manager.update_dt,'%Y/%m/%d') as update_dt";
		$query .= " FROM ";
		$query .= " T_MANAGER manager ";
		$query .= " LEFT JOIN T_MANAGER_SUBJECT_AREA managerSubArea ";
		$query .= " ON manager.org_no = managerSubArea.org_no ";
		$query .= " AND manager.manager_no = managerSubArea.manager_no ";
		$query .= " AND manager.del_flg = '0' ";
		$query .= " AND managerSubArea.del_flg = '0' ";
		$query .= " INNER JOIN M_ORGANIZATION org ";
		$query .= " ON manager.org_no = org.org_no ";
		$query .= " AND org.del_flg = '0' ";
		$query .= " WHERE ";
		$query .= " manager.org_no = :org_no ";
		$query .= " GROUP BY manager.manager_no, manager.manager_name, manager.manager_name_kana, manager.login_id, manager.manager_kbn, manager.mail_address, manager.start_period, manager.end_period, manager.remarks, manager.create_dt, manager.update_dt ";
		$query .= " ORDER BY ABS(manager.manager_no) ASC ";

		$stmt = $this->pdo->prepare ( $query );
		$category = MANAGER_KBN;
		$stmt->bindParam ( ":category",$category, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class(new T_ManagerDto()) );
	}

	/**
	 * データ抽出ため担当者．教科．レッスン情報を取得処理
	 * @param $org_no:組織№
	 * @param $param:画面からのデータ
	 * @return リスト
	 */
	public function getManagerSubjectLessonCsvData($org_no,$params) {

		//20190514-担当者・科目・レッスンデータ抽出クエリ修正

		$query = " SELECT ";
		$query .= " manager.manager_no ";
		$query .= " ,manager.manager_name ";
		$query .= " ,manager.login_id ";
		$query .= " ,date_format(manager.start_period,'%Y/%m/%d') as manager_start_period ";
		$query .= " ,date_format(manager.end_period,'%Y/%m/%d') as manager_end_period ";
		$query .= " ,subjectArea.subject_area_no ";
		$query .= " ,(CASE
					WHEN subjectArea.subject_area_no = lessonManager.subject_area_no OR lessonManager.lesson_no IS NULL 
					THEN subjectArea.subject_area_name ELSE  ''   END) AS subjectAreaName ";
		$query .= " ,lessonManager.lesson_no ";
		$query .= " ,lessonManager.lesson_name ";
		$query .= " ,date_format(lessonManager.start_period,'%Y/%m/%d') as lesson_start_period ";
		$query .= " ,date_format(lessonManager.end_period,'%Y/%m/%d') as lesson_end_period ";
		$query .= " ,lessonManager.subject_name ";
		$query .= " FROM T_MANAGER manager ";

		$query .= " INNER JOIN M_ORGANIZATION org ";
		$query .= " ON manager.org_no = org.org_no ";
		$query .= " AND org.del_flg = '0' ";

		$query .= " LEFT JOIN T_MANAGER_SUBJECT_AREA managerSubArea ";
		$query .= " ON manager.org_no = managerSubArea.org_no ";
		$query .= " AND manager.manager_no = managerSubArea.manager_no ";
		$query .= " AND managerSubArea.del_flg = '0' ";

		$query .= " LEFT JOIN M_SUBJECT_AREA subjectArea ";
		$query .= " ON managerSubArea.org_no = subjectArea.org_no ";
		$query .= " AND managerSubArea.subject_area_no = subjectArea.subject_area_no ";
		$query .= " AND subjectArea.del_flg = '0' ";

		$query .= " LEFT JOIN M_SUBJECT_AREA subjectArea1 ";
		$query .= " ON managerSubArea.org_no = subjectArea.org_no ";
		$query .= " AND managerSubArea.subject_area_no = subjectArea.subject_area_no ";
		$query .= " AND subjectArea.del_flg = '0' ";

		$query .= " LEFT JOIN ";
		$query .= " (SELECT lessonManager.org_no ";
		$query .= " ,lessonManager.lesson_no ";
		$query .= " ,lesson.lesson_name ";
		$query .= " ,lessonManager.manager_no ";
		$query .= " ,lesson.subject_no ";
		$query .= " ,sub.subject_area_no ";
		$query .= " ,sub.subject_name ";
		$query .= " ,lesson.start_period ";
		$query .= " ,lesson.end_period ";
		$query .= " FROM M_LESSON_MANAGER lessonManager ";
		$query .= " LEFT JOIN M_LESSON lesson ";
		$query .= " ON lessonManager.org_no = lesson.org_no ";
		$query .= " AND lessonManager.lesson_no = lesson.lesson_no ";
		$query .= " AND lesson.del_flg = '0' ";
		$query .= " LEFT JOIN M_SUBJECT sub ";
		$query .= " ON lesson.org_no = sub.org_no ";
		$query .= " AND lesson.subject_no = sub.subject_no ";
		$query .= " AND lesson.del_flg = 0 ) lessonManager ";
		$query .= " ON manager.org_no = lessonManager.org_no ";
		$query .= " AND manager.manager_no = lessonManager.manager_no ";
		$query .= " AND (CASE WHEN subjectArea1.subject_area_no IS NOT NULL THEN  
					lessonManager.subject_area_no = subjectArea1.subject_area_no OR lessonManager.subject_area_no = subjectArea.subject_area_no
					ELSE '' END )";
		$query  .= " WHERE manager.org_no = :org_no ";

		if ( ! StringUtil::isEmpty($params->start_period1) ){
			$query .= " AND manager.start_period >= :start_period1 ";
		}
		if ( ! StringUtil::isEmpty($params->start_period2) ){
			$query .= " AND manager.start_period <= :start_period2 ";
		}
		if ( ! StringUtil::isEmpty($params->end_period1) ){
			$query .= " AND manager.end_period >= :end_period1 ";
		}
		if ( ! StringUtil::isEmpty($params->end_period2) ){
			$query .= " AND manager.end_period <= :end_period2 ";
		}

		$query .= "GROUP BY manager.manager_no, manager.manager_name, manager.login_id, manager_start_period, manager_end_period, subjectArea.subject_area_no, subjectAreaName, lessonManager.lesson_no, lessonManager.lesson_name, lesson_start_period, lesson_end_period, lessonManager.subject_name ";
		$query .= " ORDER BY ABS(manager.manager_no), subjectArea.subject_area_no, lessonManager.lesson_no ASC ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		if ( ! StringUtil::isEmpty($params->start_period1) ){
			$stmt->bindParam ( ":start_period1", $params->start_period1, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->start_period2) ){
			$stmt->bindParam ( ":start_period2", $params->start_period2, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period1) ){
			$stmt->bindParam ( ":end_period1", $params->end_period1, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty($params->end_period2) ){
			$stmt->bindParam ( ":end_period2", $params->end_period2, PDO::PARAM_STR );
		}
		$list = parent::getDataList ( $stmt, get_class ( new T_Manager_SubjectArea_LessonDto() ) );
		return $list;
	}
}
?>