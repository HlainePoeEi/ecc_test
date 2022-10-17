<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/M_Subject_AreaDto.php';
require_once 'dto/M_Subject_Area_SubjectDto.php';
require_once 'util/DateUtil.php';

/**
 * SubjectAreaDAOクラス
 */
class M_Subject_AreaDao extends BaseDao {


	public function getNext() {

		return parent::getId("subject_area_no");
	}

	/**
	 * 入出庫ヘッダー情報新規登録
	 *
	 * @param unknown $dto
	 */
	public function insertWithTranPdo($list , $pdo){

		return parent::insertWithTranPdo( $list , $pdo);
	}
	/**
	 * 登録画面の初期表示をデータベースから取得する
	 * PG012
	 *
	 */
	public function getSubjectList($org_no){

		$today_date = DateUtil::getDate('Y/m/d');

		$query = " SELECT ";
		$query .= " subject_area_no ";
		$query .= " ,subject_area_name ";
		$query .= " FROM ";

		$query .= " M_SUBJECT_AREA";
		$query .= " WHERE ";

		$query .= " org_no = :org_no ";
		$query .= " AND start_period <= :start_period ";
		$query .= " AND end_period >=  :end_period";
		$query .= " AND del_flg = '0' ";

		$query .= " GROUP BY ";
		$query .= " subject_area_no, subject_area_name  ";
		$query .= " ORDER BY ";
		$query .= " subject_area_no ASC ,subject_area_name ASC ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_period", $today_date, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $today_date, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new M_Subject_AreaDto()) );
	}

	/**
	 * 教科名で教科管理№を取得処理
	 *
	 *
	 */
	public function getSubjectNo( $org_no, $subject_area_name ){

		$query = "SELECT t1.subject_area_no  ";
		$query .= "FROM M_SUBJECT_AREA  AS t1 ";
		$query .= "LEFT JOIN M_SUBJECT_AREA  AS t2 ";
		$query .= "ON t1.subject_area_name = t2.subject_area_name ";
		$query .= "AND t1.org_no = t2.org_no ";
		$query .= "AND t1.subject_area_no > t2.subject_area_no ";
		$query .= "WHERE t2.subject_area_no IS NULL AND t1.subject_area_name IN (".implode(',',$subject_area_name).") ";
		$query .= " AND t1.org_no = :org_no ";
		$query .= " AND t1.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new M_Subject_AreaDto()));
	}

	/**
	 * 同一の組織内で教科名の重複チェック
	 *
	 *
	 */
	public function checkedExistSubjectAreaInfo($org_no, $subject_area_name){

		$query = " SELECT ";
		$query .= "subject_area_name ";

		$query .= " FROM ";
		$query .= " M_SUBJECT_AREA";

		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND subject_area_name = :subject_area_name ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":subject_area_name", $subject_area_name, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new M_Subject_AreaDto()) );
	}

	/**
	 * 教科：科目のデータを取得する
	 */
	public function getSubjectAreaSubjectCsvData($org_no){
		$query = "SELECT ";
		$query .= "subArea.subject_area_no ";
		$query .= ",subArea.subject_area_name ";
		$query .= ",subArea.subject_area_name_kana ";
		$query .= ",date_format(subArea.start_period,'%Y/%m/%d') subArea_start_period ";
		$query .= ",date_format(subArea.end_period,'%Y/%m/%d') subArea_end_period ";
		$query .= ",subArea.disp_no subArea_disp_no ";
		$query .= ",subArea.remarks subArea_remarks ";
		$query .= ",date_format(subArea.create_dt,'%Y/%m/%d') subArea_create_dt ";
		$query .= ",date_format(subArea.update_dt,'%Y/%m/%d') subArea_update_dt ";
		$query .= ",sub.subject_no ";
		$query .= ",sub.subject_name ";
		$query .= ",sub.subject_name_kana ";
		$query .= ",date_format(sub.start_period,'%Y/%m/%d') sub_start_period ";
		$query .= ",date_format(sub.end_period,'%Y/%m/%d') sub_end_period ";
		$query .= ",sub.disp_no sub_disp_no ";
		$query .= ",sub.remarks sub_remarks ";
		$query .= ",date_format(sub.create_dt,'%Y/%m/%d') sub_create_dt ";
		$query .= ",date_format(sub.update_dt,'%Y/%m/%d') sub_update_dt ";
		$query .= "FROM M_SUBJECT_AREA subArea ";
		$query .= "LEFT JOIN M_SUBJECT sub ";
		$query .= "ON subArea.org_no = sub.org_no ";
		$query .= "AND subArea.subject_area_no = sub.subject_area_no ";
		$query .= "AND subArea.del_flg = '0' ";
		$query .= "AND sub.del_flg = '0' ";
		$query .= "WHERE subArea.org_no = :org_no ";
		$query .= "ORDER BY subArea.subject_area_no ASC";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new M_Subject_Area_SubjectDto()));
	}
}

?>
