<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_AdminDto.php';

/**
 * 運用管理者DAOクラス
 */
class T_AdminDao extends BaseDao {

	/**
	 * Login Idを指定してユーザデータを取得する
	 */
	public function getUserData($login_id) {

		$query = " SELECT ";
		$query .= " admin.admin_no admin_no";
		$query .= " ,admin.login_id login_id";
		$query .= " ,admin.admin_name admin_name";
		$query .= " ,admin.romaji_name romaji_name";
		$query .= " ,admin.admin_kbn admin_kbn";
		$query .= " ,admin.password password ";
		$query .= " ,admin.pw_update_dt pw_update_dt";
		$query .= " ,admin.mail_address mail_address";
		$query .= " ,DATE_FORMAT(admin.start_period, '%Y/%m/%d') start_period";
		$query .= " ,DATE_FORMAT(admin.end_period, '%Y/%m/%d') end_period";
		$query .= " FROM ";
		$query .= " T_ADMIN admin";
		$query .= " WHERE";
		$query .= " admin.login_id = :login_id ";
		$query .= " AND admin.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );

		return parent::getData ( $stmt, get_class(new T_AdminDto()) );
	}

	/**
	 * Admin_noを指定してデータを取得する
	 */
	public function getAdminInfo($admin_no) {

		$sysDate = DateUtil::getDate("Y/m/d h:i:s");

		$query = " SELECT ";
		$query .= " admin.admin_no admin_no";
		$query .= " ,admin.login_id login_id";
		$query .= " ,admin.admin_name admin_name";
		$query .= " ,admin.romaji_name romaji_name";
		$query .= " ,admin.admin_kbn admin_kbn";
		$query .= " ,admin.password password ";
		$query .= " ,admin.pw_update_dt pw_update_dt";
		$query .= " ,admin.mail_address mail_address";
		$query .= " ,DATE_FORMAT(admin.start_period, '%Y/%m/%d') start_period";
		$query .= " ,DATE_FORMAT(admin.end_period, '%Y/%m/%d') end_period";
		$query .= " ,remarks ";
		$query .= " FROM ";
		$query .= " T_ADMIN admin";
		$query .= " WHERE";
		$query .= " admin.admin_no = :admin_no ";
		$query .= " AND admin.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":admin_no", $admin_no, PDO::PARAM_STR );

		return parent::getData ( $stmt, get_class(new T_AdminDto()) );
	}

	/**
	 * 運用管理者情報リストを取得する
	 */
	public function getAdminListData($form,$flg) {

		$offset = ($form->page-1) * PAGE_ROW;
		$t_admin_kbn = T_ADMIN_KBN;
		$query = " SELECT ";
		$query .= " admin.admin_no admin_no";
		$query .= " ,admin.login_id login_id";
		$query .= " ,admin.admin_name admin_name";
		$query .= " ,admin.romaji_name romaji_name";
		$query .= " ,admin.admin_kbn admin_kbn";
		$query .= " ,t.name admin_kbn_name";
		$query .= " ,admin.password password ";
		$query .= " ,admin.pw_update_dt pw_update_dt";
		$query .= " ,admin.mail_address mail_address";
		$query .= " ,DATE_FORMAT(admin.start_period, '%Y/%m/%d') start_period";
		$query .= " ,DATE_FORMAT(admin.end_period, '%Y/%m/%d') end_period";
		$query .= " FROM ";
		$query .= " T_ADMIN admin";
		$query .= " INNER JOIN M_TYPE t ";
		$query .= " ON admin.admin_kbn=t.type AND t.category=:t_admin_kbn ";
		$query .= " WHERE";
		$query .= " admin.del_flg = '0' ";
		$query .= " AND admin.start_period <= :end_period ";
		$query .= " AND admin.end_period >= :start_period ";

		if (! StringUtil::isEmpty ( $form->admin_name )){
			$query .= ' AND admin.admin_name LIKE :admin_name ';
			$query .= ' OR admin.romaji_name LIKE :romaji_name ';
		}

		$query .= " ORDER BY admin.admin_name,admin.admin_no ";

		if ( $flg == "1"){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );
		//運用管理者権限
		$stmt->bindParam ( ":t_admin_kbn", $t_admin_kbn, PDO::PARAM_STR );

		if (! StringUtil::isEmpty ( $form->admin_name )){
			$name = '%' . $form->admin_name . '%';
			$stmt->bindParam ( ":admin_name", $name, PDO::PARAM_STR );
			$stmt->bindParam ( ":romaji_name", $name, PDO::PARAM_STR );
		}

		$stmt->bindParam ( ":start_period", $form->start_period, PDO::PARAM_STR );
		$stmt->bindParam ( ":end_period", $form->end_period, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class(new T_AdminDto()) );
	}

	/**
	 * 運用管理者情報を新規登録する
	 */
	public function insertData($dto){

		return parent::insert ( $dto );

	}

	/**
	 * 次の運用管理者番号を取得する
	 */
	public function getNextId(){

		return parent::getId ("admin_no");
	}

	/**
	 * ログインID重複チェック処理
	 *
	 * @param count
	 */
	public function checkExists($login_id){

		$query = " SELECT ";
		$query .= " admin.admin_no admin_no";
		$query .= " FROM ";
		$query .= " T_ADMIN admin";
		$query .= " WHERE";
		$query .= " admin.login_id = :login_id ";
		$query .= " AND admin.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );

		return parent::getDataList( $stmt, get_class(new T_AdminDto()) );
	}

	/**
	 * Ｔ運用管理者データを更新する
	 *
	 * @param $dto
	 * @return string
	 */
	public function updateAdminInfo($dto) {

		$query = "UPDATE ";
		$query .= "T_ADMIN SET ";
		$query .= " login_id = :login_id";
		$query .= " ,admin_name = :admin_name";
		$query .= " ,romaji_name = :romaji_name";
		$query .= " ,admin_kbn = :admin_kbn";
		if (! StringUtil::isEmpty ( $dto->password )){
			$query .= " ,password = :password ";
		}
		if (! StringUtil::isEmpty ( $dto->pw_update_dt )){
			$query .= " ,pw_update_dt = :pw_update_dt ";
		}
		$query .= " ,mail_address = :mail_address ";
		if (! StringUtil::isEmpty ( $dto->start_period )){
			$query .= " ,start_period = :start_period ";
		}
		if (! StringUtil::isEmpty ( $dto->end_period )){
			$query .= " ,end_period = :end_period ";
		}
		$query .= " ,remarks = :remarks ";

		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";

		// WHERE
		$query .= " WHERE ";
		$query .= " admin_no = :admin_no ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":login_id", $dto->login_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":admin_name", $dto->admin_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":romaji_name", $dto->romaji_name, PDO::PARAM_STR );
		$stmt->bindParam ( ":admin_kbn", $dto->admin_kbn, PDO::PARAM_STR );
		if (! StringUtil::isEmpty ( $dto->password )){
			$stmt->bindParam ( ":password", $dto->password, PDO::PARAM_STR );
		}
		if (! StringUtil::isEmpty ( $dto->pw_update_dt )){
			$stmt->bindParam ( ":pw_update_dt", $dto->pw_update_dt, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":mail_address", $dto->mail_address, PDO::PARAM_STR );
		if (! StringUtil::isEmpty ( $dto->start_period )){
			$stmt->bindParam ( ":start_period", $dto->start_period, PDO::PARAM_STR );
		}
	    if (! StringUtil::isEmpty ( $dto->end_period )){
			$stmt->bindParam ( ":end_period", $dto->end_period, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":remarks", $dto->remarks, PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":admin_no", $dto->admin_no, PDO::PARAM_INT );

		LogHelper::logDebug("Admin Info Update: ".$query);
		return parent::update ( $stmt );
	}
	/**
	 * 運用管理者テーブルに運用管理者№が存在しているかをチェックすること
	 */
	public function checkValid($login_id,$adm_no){
		$query = " SELECT ";
		$query .= " adm.login_id ";
		$query .= " ,adm.password ";
		$query .= " FROM ";
		$query .= " T_ADMIN adm ";
		$query .= " WHERE ";
		$query .= " adm.login_id = :login_id ";
		$query .= " AND adm.admin_no= :admin_no ";
		$query .= " AND adm.del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":login_id", $login_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":admin_no",  $adm_no, PDO::PARAM_STR );

		return parent::getData( $stmt, get_class(new T_AdminDto()) );
	}
	/**
	 * 運用管理者テーブルにパスワード変更
	 */
	public function updatePassword($dto){
		$query = " UPDATE ";
		$query .= " T_ADMIN ";
		$query .= " SET";
		$query .= " password  = :password ";
		$query .= " ,update_dt = :update_dt ";
		$query .= " ,updater_id = :updater_id ";

		$query .= " WHERE ";
		$query .= " login_id = :login_id ";
		$query .= " AND admin_no = :admin_no ";
		$query .= " AND del_flg = '0' ";

		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":password", $dto->password,  PDO::PARAM_STR );
		$stmt->bindParam ( ":update_dt", $dto->update_dt,  PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":login_id",  $dto->login_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":admin_no",  $dto->admin_no, PDO::PARAM_STR );

		return parent::update ( $stmt);
	}

}

?>