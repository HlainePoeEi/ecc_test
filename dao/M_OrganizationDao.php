<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/M_OrganizationDto.php';
require_once 'dto/M_TypeDto.php';

/**
 * 組織管理者DAOクラス
 */
class M_OrganizationDao extends BaseDao {

	/**
	 * 組織一覧画面のデータを取得する
	 */
	public function getOrganizationList( $param , $flg ) {

		$cat_org_kbn = CAT_ORG_KBN;

		$offset = ($param->page-1) * PAGE_ROW;

		$query = " SELECT ";
		$query .= "  distinct org.org_no ";
		$query .= " ,org.org_id ";
		$query .= " ,org.org_name ";
		$query .= " ,org.org_name_kana ";
		$query .= " ,org.org_name_official ";
		$query .= " ,type.name org_kbn ";
		$query .= " ,DATE_FORMAT(org.start_period, '%Y/%m/%d') start_period ";
		$query .= " ,DATE_FORMAT(org.end_period, '%Y/%m/%d') end_period ";
		$query .= " FROM ";
		$query .= " M_ORGANIZATION org ";
		$query .= " LEFT JOIN M_TYPE as type ";
		$query .= " ON org.org_kbn = type.type ";
		$query .= " WHERE type.category = :cat_org_kbn ";
		$query .= " AND org.start_period <= :end_period ";
		$query .= " AND org.end_period >= :start_period ";
		$query .= " AND org.del_flg = '0' ";
		$query .= " AND type.del_flg = '0' ";

		if (! StringUtil::isEmpty($param->org_name)){
			$query .= " AND (org.org_name LIKE :org_name OR org.org_name_kana LIKE :org_name_kana ) ";
		}

		if (! StringUtil::isEmpty($param->status)){
			$query .= " AND org.org_kbn IN (".$param->status.") ";
		}

		$query .= " ORDER BY org.org_no, org.org_id";

		if ( $flg == "1"){
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty($param->org_name) ){

			$name =  '%'.$param->org_name.'%';
			$stmt->bindParam(":org_name", $name, PDO::PARAM_STR);
			$stmt->bindParam(":org_name_kana", $name, PDO::PARAM_STR);
		}
		$stmt->bindParam ( ":cat_org_kbn", $cat_org_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_period",$param->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $param->end_period, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new M_OrganizationDto()) );
	}

	/**
	 * カテゴリーを指定してデータを取得する
	 */
	public function getCategoryInfo($category) {

		$query = " SELECT ";
		$query .= "type.type";
		$query .= ",type.name";
		$query .= " FROM M_TYPE type";
		$query .= " WHERE del_flg = '0' ";

		if (!StringUtil::isEmpty($category)){
			$query .= " AND type.category = :category";
		}

		$query .= " ORDER BY type.type";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":category", $category, PDO::PARAM_STR );
		return parent::getDataList ( $stmt, get_class ( new M_TypeDto() ) );
	}

	/**
	 * org_noを指定してデータを取得する
	 */
	public function getOrgDataByOrgNo($org_no) {

		$query = " SELECT ";
		$query .= " org.org_id org_id";
		$query .= " ,org.org_name ";
		$query .= " ,org.org_name_kana";
		$query .= " ,org.org_name_official ";
		$query .= " ,org.org_kbn ";
		$query .= " ,org.org_type ";
		$query .= " ,org.function_type ";
		$query .= " ,DATE_FORMAT(org.org_start_date, '%Y/%m/%d') org_start_date  ";
		$query .= " ,DATE_FORMAT(org.start_period, '%Y/%m/%d') start_period  ";
		$query .= " ,DATE_FORMAT(org.end_period, '%Y/%m/%d') end_period  ";
		$query .= " ,DATE_FORMAT(org.contract_start_dt, '%Y/%m/%d') contract_start_dt  ";
		$query .= " ,DATE_FORMAT(org.contract_end_dt, '%Y/%m/%d') contract_end_dt  ";
		$query .= " ,org.org_admin";
		$query .= " ,org.phone_no ";
		$query .= " ,org.mail_address ";
		$query .= " ,org.contract_no ";
		$query .= " ,org.manager_name";
		$query .= " ,org.remarks ";
        // Start ADD 20211102 add query  by TienHM
        $query .= " ,t.push_flg ";
        $query .= " ,t.count ";
        //  End  ADD 20211102
		$query .= " FROM M_ORGANIZATION org ";
        // Start ADD 20211102 add query  by TienHM
        $query .= " INNER JOIN T_ORG_PUSH_CONF as t ";
        $query .= " ON org.org_no = t.org_no ";
        // Start ADD 20211102 add query  by TienHM
		$query .= " WHERE org.del_flg = '0' ";
		$query .= " AND org.org_no = :org_no ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class ( new M_OrganizationDto() ) );

	}

	/**
	 * 組織情報更新処理
	 *
	 * @param $dto
	 */
	public function updateOrgInfo($dto){
		$query = " UPDATE ";
		$query .= " M_ORGANIZATION ";
		$query .= " SET";
		$query .= " org_id  = :org_id ";
		$query .= " ,org_name  = :org_name ";
		$query .= " ,org_name_kana  = :org_name_kana ";
		$query .= " ,org_name_official  = :org_name_official ";
		$query .= " ,org_kbn  = :org_kbn ";
		$query .= " ,org_type  = :org_type ";
		$query .= " ,function_type  = :function_type ";
		$query .= " ,org_start_date  = :org_start_date ";
		$query .= " ,start_period  = :start_period ";
		$query .= " ,end_period  = :end_period ";
		$query .= " ,contract_start_dt  = :contract_start_dt ";
		$query .= " ,contract_end_dt  = :contract_end_dt ";
		$query .= " ,org_admin  = :org_admin ";
		$query .= " ,phone_no  = :phone_no ";
		$query .= " ,mail_address  = :mail_address ";
		$query .= " ,contract_no  = :contract_no ";
		$query .= " ,manager_name  = :manager_name ";
		$query .= " ,remarks  = :remarks ";
		$query .= " ,updater_id  = :updater_id ";
		$query .= " ,update_dt  = :update_dt ";
		$query .= " WHERE ";
		$query .= " org_no = :org_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_id",  $dto->org_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_name",  $dto->org_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_name_kana",  $dto->org_name_kana, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_name_official",  $dto->org_name_official, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_kbn",  $dto->org_kbn, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_type",  $dto->org_type, PDO::PARAM_STR );
		$stmt->bindParam ( ":function_type",  $dto->function_type, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_start_date",  $dto->org_start_date, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_period",  $dto->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period",  $dto->end_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":contract_start_dt",  $dto->contract_start_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":contract_end_dt",  $dto->contract_end_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_admin",  $dto->org_admin, PDO::PARAM_STR );
		$stmt->bindParam ( ":phone_no",  $dto->phone_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":mail_address",  $dto->mail_address, PDO::PARAM_STR );
		$stmt->bindParam ( ":contract_no",  $dto->contract_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":manager_name",  $dto->manager_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":remarks",  $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt",  $dto->update_dt, PDO::PARAM_STR );
		return parent::update ( $stmt );

	}

	/**
	 * 次の組織管理№を取得する
	 */
	public function getNextId() {

		return parent::getId( "org_no" );
	}

	/**
	 * 組織情報を新規登録する
	 */
	public function saveOrg($dto){

		return parent::insert ( $dto );

	}

	/**
	 * 組織コード重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($org_no, $org_id) {

		$query = " SELECT ";
		$query .= " org.org_no";
		$query .= " FROM ";
		$query .= " M_ORGANIZATION org";
		$query .= " WHERE org.org_id = :org_id ";
		$query .= " AND org.del_flg = '0' ";

		if (!StringUtil::isEmpty($org_no)){
			$query .= " AND org.org_no != :org_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );

		if (!StringUtil::isEmpty($org_no)){

			$stmt->bindParam ( ":org_no",  $org_no, PDO::PARAM_STR );
		}

		$list= parent::getDataList( $stmt, get_class(new M_OrganizationDto()) );

		return count( $list );
	}

	/**
	 * 組織IDを指定して組織情報を取得する
	 */
	public function getOrgNoByOrgId($org_id) {

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");
		$query = " SELECT ";
		$query .= " org.org_no org_no, ";
		$query .= " org.org_id org_id, ";
		$query .= " org.org_name org_name ";
		$query .= " FROM M_ORGANIZATION org ";
		$query .= " WHERE";
		$query .= " org.org_id = :org_id ";
		$query .= " AND org.start_period <= :end_date1 ";
		$query .= " AND org.end_period >= :start_date1 ";
		$query .= " AND org.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":start_date1", $sysDate, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_date1", $sysDate, PDO::PARAM_STR );

		return parent::getData( $stmt, get_class ( new M_OrganizationDto() ) );

	}
}

?>