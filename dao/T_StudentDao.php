<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_StudentDto.php';
require_once 'dto/M_OrganizationDto.php';

/**
 * T_受講者DAOクラス
 */
class T_StudentDao extends BaseDao {

	/**
	 * 複数件データを挿入する
	 *
	 * @param unknown $dto
	 */
	public function insertWithTran($list , $pdo){

		return parent::insertWithTranPdo($list , $pdo);
	}

	/**
	 * シアイテム情報更新処理
	 *
	 * @param $dto
	 */
	public function getNext(){

		return parent::getId("student_no");
	}

	/**
	 * データベースに存在チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($org_no, $login_id){

		$query = " SELECT ";
		$query .= " student.student_no ";
		$query .= " FROM ";
		$query .= " T_STUDENT student ";
		$query .= " WHERE ";
		$query .= " student.org_no = :org_no ";
		$query .= " AND student.login_id = :login_id ";
		$query .= " AND student.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_StudentDto()) );
	}

	/**
	 * 組織管理No・受講者名・受講者ログインIDで存在チェック
	 *
	 * @param count
	 */
	public function getSutdentByNameLoginId($org_no, $login_id, $student_name){

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");
		$query = " SELECT ";
		$query .= " student.student_no ";
		$query .= " FROM ";
		$query .= " T_STUDENT student ";
		$query .= " WHERE ";
		$query .= " student.org_no = :org_no ";
		if ( ! StringUtil::isEmpty($student_name) ){
			$query .= " AND student.student_name = :student_name ";
		}
		$query .= " AND student.login_id = :login_id ";
		$query .= " AND student.del_flg = '0' ";
	//	$query .= " AND student.enroll_dt <= :end_period1 ";
		$query .= " AND student.graduation_dt >= :start_period1 ";
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );
		if ( ! StringUtil::isEmpty($student_name) ){
			$stmt->bindParam ( ":student_name", $student_name, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":start_period1", $sysDate, PDO::PARAM_STR );
	//	$stmt->bindParam ( ":end_period1", $sysDate, PDO::PARAM_STR );

		return parent::getData( $stmt, get_class(new T_StudentDto()) );
	}

	/**
	 * 受講者の有効チェック
	 *
	 * @param count
	 */
	public function checkedValidStudent($org_no, $login_id, $student_name, $start_period, $end_period){

		$query = " SELECT ";
		$query .= " student.student_no ";
		$query .= " FROM ";
		$query .= " T_STUDENT student ";
		$query .= " WHERE ";
		$query .= " student.org_no = :org_no ";
		if ( ! StringUtil::isEmpty($student_name) ){
			$query .= " AND student.student_name = :student_name ";
		}
		$query .= " AND student.login_id = :login_id ";
		$query .= " AND student.enroll_dt <= :end_period1 ";
		$query .= " AND student.graduation_dt >= :start_period1 ";
		$query .= " AND student.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		if ( ! StringUtil::isEmpty($student_name) ){
			$stmt->bindParam ( ":student_name", $student_name, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_period1", $start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period1", $end_period, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_StudentDto()) );
	}
	/**
	 * シアイテム情報更新処理
	 *
	 * @param $dtoリスト
	 */
	public function updateItemInfo($org_no, $dto_list , $pdo){
		$rs=1;
		try {

			for($i=0;$i<count($dto_list);$i++){
				$query = " UPDATE ";
				$query .= " T_STUDENT ";
				$query .= " SET ";
				$query .=" no = :no ";
				$query .= " ,remarks = :remarks ";
				$query .= " ,update_dt = :update_dt ";
				$query .= " ,updater_id = :updater_id ";
				$query .= " WHERE ";
				$query .= " org_no = :org_no ";
				$query .= " AND login_id = :login_id ";
				$query .= " AND del_flg = '0' ";
				$stmt = $pdo->prepare ( $query );
				$dto=$dto_list[$i];
				$stmt->bindParam ( ":no",  $dto->no, PDO::PARAM_STR );
				$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
				$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
				$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
				$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
				$stmt->bindParam ( ":login_id", $dto->login_id, PDO::PARAM_STR );
				$rs=parent::update ( $stmt);
				if($rs != 1){
					break;
				}
			}

		} catch ( Exception $e ) {

			$rs=0;
		}
		return $rs;
	}
	/**
	 * 受講者のデータを取得する
	 *
	 * @param count
	 */
	public function getStudentCsvData($params){

		$query = " SELECT ";
		$query .= " student.student_no ";
		$query .= " ,student.student_name ";
		$query .= " ,student.student_name_romaji ";
		$query .= " ,student.no ";
		$query .= " ,student.sex ";
		$query .= " ,student.login_id ";
		$query .= " ,student.mail_address ";
		$query .= " ,date_format(student.enroll_dt,'%Y/%m/%d') enroll_dt ";
		$query .= " ,date_format(student.graduation_dt,'%Y/%m/%d') graduation_dt ";
		$query .= " ,student.remarks ";
		$query .= " ,date_format(student.create_dt,'%Y/%m/%d') create_dt ";
		$query .= " ,date_format(student.update_dt,'%Y/%m/%d') update_dt ";
		$query .= " FROM T_STUDENT student ";
		$query .= " WHERE student.org_no = :org_no ";
		$query .= "AND student.del_flg = '0' ";

		if ( ! StringUtil::isEmpty($params->start_period_start) ){
			$query .= " AND student.enroll_dt >= :start_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->start_period_end) ){
			$query .= " AND student.enroll_dt <= :start_period_end ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_start) ){
			$query .= " AND student.graduation_dt >= :end_period_start ";
		}
		if ( ! StringUtil::isEmpty($params->end_period_end) ){
			$query .= " AND student.graduation_dt <= :end_period_end ";
		}

		$query .= "ORDER BY student.student_no ASC ";

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

		return parent::getDataList( $stmt, get_class(new T_StudentDto()));
	}

}

?>