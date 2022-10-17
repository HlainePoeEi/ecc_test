<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/M_GradeDto.php';
require_once 'dto/M_OrganizationDto.php';
require_once 'dto/T_SequenceDto.php';
require_once 'dto/GradeInfoDto.php';
require_once 'conf/config.php';

/**
 * 学年DAOクラス
 */
class M_GradeDao extends BaseDao {

	public function getGradeOrgInfo($form) {

		$query = $this->getQuery ( $form );

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $form->org_no) ){
			$org_no = $form->org_no;
			$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		}

		return parent::getDataList( $stmt, get_class ( new GradeInfoDto()) );
	}

	public function getGradeOrgCount($param) {

		$query = $this->getQuery($param);

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $param->org_no) ){
			$org_no = $param->org_no;
			$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		}

		return parent::getDataList ( $stmt, get_class ( new GradeInfoDto() ) );

	}

	private function getQuery($form) {

		$query = 'SELECT ';
		$query .= ' g.grade_no';
		$query .= ' ,g.grade_name';
		$query .= ' ,g.grade_name_kana';
		$query .= ' ,g.disp_no';
		$query .= ' ,g.remarks';
		$query .= ' ,date_format(g.start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(g.end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' ,o.org_no';
		$query .= ' ,o.org_id';
		$query .= ' ,o.org_name';
		$query .= ' ,o.org_name_kana';
		$query .= ' ,o.org_name_official';

		$query .= ' FROM M_ORGANIZATION o ';
		$query .= " LEFT JOIN M_GRADE g";
		$query .= " ON o.org_no = g.org_no ";
		$query .= " AND o.del_flg = 0 ";

		$query .= 'WHERE 1 = 1 ';
		$query .= " AND g.del_flg = 0 ";

		if ( ! StringUtil::isEmpty ( $form->org_no ) ){
			$query .= ' AND o.org_no = :org_no ';
		}

		$query .= " ORDER BY g.disp_no ";

		return $query;
	}

	/**
	 * 学年IDを取得する
	 */
	public function getNextGradeNo() {
		return parent::getId ( "grade_no" );
	}

	/**
	* 学年情報取得
	*/
	public function getGradeInfo($form) {

		$query = 'SELECT ';
		$query .= ' org_no';
		$query .= ' ,grade_no';
		$query .= ' ,grade_name';
		$query .= ' ,grade_name_kana';
		$query .= ' ,disp_no';
		$query .= ' ,remarks';
		$query .= ' ,date_format(start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' FROM M_GRADE ';
		$query .= 'WHERE del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $form->org_no ) ){
			$query .= ' AND org_no = :org_no ';
		}

		if ( ! StringUtil::isEmpty ( $form->grade_no ) ){
			$query .= ' AND grade_no = :grade_no ';
		}
		$query .= " ORDER BY disp_no ";
		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $form->org_no) ){
			$org_no = $form->org_no;
			$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->grade_no) ){
			$grade_no = $form->grade_no;
			$stmt->bindParam ( ":grade_no", $grade_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new M_GradeDto()) );
	}

	/**
	 * 学年情報更新
	 */
	public function updateGradeData($dto) {

		$query = "UPDATE ";
		$query .= "M_GRADE SET grade_name = :grade_name";
		$query .= " ,grade_name_kana = :grade_name_kana ";
		$query .= " ,disp_no = :disp_no";
		$query .= " ,remarks = :remarks";
		$query .= " ,start_period = :start_period ";
		$query .= " ,end_period = :end_period ";
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";
		$query .= " AND org_no = :org_no ";

		if ( ! StringUtil::isEmpty ( $dto->grade_no ) ){
			$query .= " AND grade_no = :grade_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->grade_no) ){
			$stmt->bindParam ( ":grade_no", $dto->grade_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->grade_name ) ){
			$stmt->bindParam ( ":grade_name", $dto->grade_name, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->grade_name_kana) ){
			$stmt->bindParam ( ":grade_name_kana", $dto->grade_name_kana, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->disp_no ) ){
			$stmt->bindParam ( ":disp_no", $dto->disp_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->remarks ) ){
			$stmt->bindParam ( ":remarks", $dto->remarks, PDO::PARAM_STR );
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

	public function delGradeData($dto) {

		$query = "UPDATE ";
		$query .= "M_GRADE SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE grade_no = :grade_no ";
		$query .= " AND org_no = :org_no ";

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->grade_no ) ){
			$stmt->bindParam ( ":grade_no", $dto->grade_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	public function getNextGradeNoByOrgNo($org_no) {
		$query = 'SELECT ';
		$query .= 'MAX(grade_no) as grade_no';
		$query .= ' FROM M_GRADE ';
		$query .= 'WHERE org_no = :org_no ';

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );

		return parent::getData( $stmt, get_class ( new GradeInfoDto() ) ) ;
	}

	public function getGradeByName($org_no,$grade_name){

		$query = 'SELECT ';
		$query .= 'grade_no as grade_no ';
		$query .= 'FROM M_GRADE ';
		$query .= 'WHERE del_flg = 0 ';
		$query .= 'AND org_no = :org_no ';
		$query .= 'AND grade_name = :grade_name ';

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":grade_name", $grade_name, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class ( new M_GradeDto() ) ) ;
	}
}
?>