<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_TeacherDto.php';
require_once 'conf/config.php';

class T_TeacherDao extends BaseDao {

	/*
	 * 講師一覧画面のデータを取得する
	 */
	public function getTeacherList( $param , $flg ) {

		$offset = ($param->page-1) * PAGE_ROW;

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");

		$query = $this->createQuery();

		$query .= $this->createSearchWhere($param);

		if ( $flg == "1" ){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}
		$stmt = $this->pdo->prepare ( $query );

		$this->setSearchParam($stmt, $param);

		return parent::getDataList ( $stmt, get_class ( new T_TeacherDto() ) );
	}

	public function createQuery(){

		$query = " SELECT";
		$query .= " teacher.teacher_no as teacher_no";
		$query .= " ,teacher.login_id ";
		$query .= " ,teacher.name ";
		$query .= " ,teacher.nickname ";
		$query .= " ,teacher.display_name ";
		$query .= " ,(SELECT name FROM M_TYPE a WHERE category = :school_kbn AND a.type = teacher.school_kbn) AS school_kbn ";
		$query .= " ,date_format(teacher.start_period,'%Y/%m/%d') AS start_period    ";
		$query .= " ,date_format(teacher.end_period,'%Y/%m/%d') AS end_period    ";
		$query .= " FROM T_TEACHER teacher ";

		return $query;
	}

	public function createSearchWhere ( $param ){

		$query = " WHERE ";
		$query .= "  '1' = '1' ";
		$query .= " AND teacher.del_flg = '0' ";

		if ( ! StringUtil::isEmpty($param->teacher_name) ){

			$query .= " AND (teacher.name LIKE :name OR teacher.nickname LIKE :nickname OR teacher.display_name LIKE :display_name) ";
		}

		if (! StringUtil::isEmpty($param->search_school_kbn) && ($param->search_school_kbn!= '')){
			$query .= " AND (teacher.school_kbn IN (".$param->search_school_kbn."))";
		}

		$query .= " AND teacher.end_period >= :start_period ";
		$query .= " AND teacher.start_period <= :end_period ";
		$query .= " GROUP BY teacher_no, teacher.login_id, teacher.name, teacher.nickname, teacher.display_name, teacher.start_period, teacher.end_period, teacher.school_kbn ";
		$query .= " ORDER BY ";
		$query .= " teacher.login_id ASC";

		return $query;
	}

	/**
	 * パラメータバインド
	 *
	 */
	public function setSearchParam($stmt, $param){

		$school_kbn = SCHOOL_KBN;

		$stmt->bindParam(":school_kbn", $school_kbn, PDO::PARAM_STR);

		if ( ! StringUtil::isEmpty($param->teacher_name) ){

			$name =  '%'.$param->teacher_name.'%';
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":nickname", $name, PDO::PARAM_STR);
			$stmt->bindParam(":display_name", $name, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->end_period) ){

			$end_period = DateUtil::changeEndDateFormat($param->end_period);
			$stmt->bindParam(":end_period", $end_period, PDO::PARAM_STR);
		}

		if ( ! StringUtil::isEmpty($param->start_period) ){

			$start_period = DateUtil::changeEndDateFormat($param->start_period);
			$stmt->bindParam(":start_period", $start_period, PDO::PARAM_STR);
		}
	}

	/**
	 * クイズ名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($login_id) {

		$query = " SELECT ";
		$query .= " teacher.teacher_no";
		$query .= " FROM ";
		$query .= " T_TEACHER teacher";
		$query .= " WHERE";
		$query .= " teacher.login_id = :login_id ";
		$query .= " AND teacher.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_TeacherDto()) );
	}

	/**
	 * 組織管理№より組織情報と組織管理者情報を取得する
	 */
	public function getTeacherInfo($teacher_no) {

		$query = " SELECT ";
		$query .= " teacher.teacher_no teacher_no";
		$query .= " ,teacher.login_id login_id";
		$query .= " ,teacher.name name";
		$query .= " ,teacher.nickname nickname";
		$query .= " ,teacher.display_name display_name";
		$query .= " ,teacher.school_kbn school_kbn";
		$query .= " ,teacher.training_flg training_flg";
		$query .= " ,teacher.start_period start_period";
		$query .= " ,teacher.end_period end_period";
		$query .= " ,teacher.remarks remarks";
		$query .= ' ,date_format(teacher.start_period,'."'%Y/%m/%d') as start_period";
		$query .= ' ,date_format(teacher.end_period,'."'%Y/%m/%d') as end_period";
		$query .= " FROM ";
		$query .= " T_TEACHER teacher";
		$query .= " WHERE";
		$query .= " teacher.teacher_no = :teacher_no ";
		$query .= " AND teacher.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":teacher_no", $teacher_no, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class(new T_TeacherDto()) );
	}

	public function updateTeacherInfo($dto) {

		$query = " UPDATE ";
		$query .= "T_TEACHER SET ";
		// SET
		if (! StringUtil::isEmpty ( $dto->login_id)) {
			$query .= " login_id = :login_id ";
		}
		if (! StringUtil::isEmpty ( $dto->name )) {
			$query .= " ,name = :name";
		}
		if (! StringUtil::isEmpty ( $dto->nickname )) {
			$query .= " ,nickname = :nickname";
		}
		if (! StringUtil::isEmpty ( $dto->display_name)) {
			$query .= " ,display_name = :display_name";
		}
		if (! StringUtil::isEmpty ( $dto->school_kbn )) {
			$query .= " ,school_kbn = :school_kbn";
		}
		if (! StringUtil::isEmpty ( $dto->training_flg)) {
			$query .= " ,training_flg = :training_flg";
		}
		if (! StringUtil::isEmpty ( $dto->password )) {
			$query .= " ,password = :password";
		}
		if (! StringUtil::isEmpty ( $dto->pw_update_dt )) {
			$query .= " ,pw_update_dt = :pw_update_dt";
		}
		if (! StringUtil::isEmpty ( $dto->start_period )) {
			$query .= " ,start_period = :start_period ";
		}
		if (! StringUtil::isEmpty ( $dto->end_period )) {
			$query .= " ,end_period = :end_period ";
		}
		if (! StringUtil::isEmpty ( $dto->remarks)) {
			$query .= " ,remarks = :remarks ";
		}
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		
		// WHERE
		$query .= " WHERE del_flg = '0' ";
		$query .= "AND teacher_no = :teacher_no ";

		$stmt = $this->pdo->prepare ( $query );
		logHelper::logDebug($stmt);

		if (! StringUtil::isEmpty ( $dto->login_id )) {
			$stmt->bindParam ( ":login_id", $dto->login_id, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->name)) {
			$stmt->bindParam ( ":name", $dto->name, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->nickname)) {
			$stmt->bindParam ( ":nickname", $dto->nickname, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->display_name )) {
			$stmt->bindParam ( ":display_name", $dto->display_name, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->school_kbn )) {
			$stmt->bindParam ( ":school_kbn", $dto->school_kbn, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->training_flg)) {
			$stmt->bindParam ( ":training_flg", $dto->training_flg, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->password )) {
			$stmt->bindParam ( ":password", $dto->password, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->pw_update_dt)) {
			$stmt->bindParam ( ":pw_update_dt", $dto->pw_update_dt, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->start_period )) {
			$stmt->bindParam ( ":start_period", $dto->start_period, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->end_period )) {
			$stmt->bindParam ( ":end_period", $dto->end_period, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->remarks)) {
			$stmt->bindParam ( ":remarks", $dto->remarks, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":teacher_no", $dto->teacher_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );

		return parent::update ( $stmt );
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
	 * 次の問題番号を取得処理
	 *
	 * @param $dto
	 */
	public function getNextId() {

		return parent::getId("teacher_no");

	}
}