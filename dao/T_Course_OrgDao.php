<?php
/*****************************************************
 *	株式会社ECC
 *	PHPシステム構築フレームワーク
 *
 *	Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_Course_OrgDto.php';
require_once 'dto/M_OrganizationDto.php';
require_once 'dto/T_CourseDto.php';
require_once 'dto/T_Menu_SettingDto.php';

/**
 * T詳細DAOクラス
 */
class T_Course_OrgDao extends BaseDao {

	/**
	 * コース詳細情報を取得する
	 */
	public function getCourseContractInfo($form) {

		$query = 'SELECT ';
		$query .= ' o.org_no';
		$query .= ' ,o.org_id';
		$query .= ' ,o.org_name';
		$query .= ' ,o.org_name_official';
		$query .= ' ,c.course_id';
		$query .= ' ,c.course_name';
		$query .= ' ,co.offer_no';
		$query .= ' ,co.remarks';
		$query .= ' ,date_format(co.start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(co.end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' FROM T_COURSE_ORG co ';

		$query .= " INNER JOIN T_COURSE c ";
		$query .= " ON c.course_id = co.course_id ";
		$query .= " AND c.del_flg = '0' ";
		$query .= " INNER JOIN M_ORGANIZATION o ";
		$query .= " ON o.org_no = co.org_no ";
		$query .= " AND o.del_flg = '0' ";

		$query .= 'WHERE co.del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $form->se_course_id) ){
			$query .= ' AND co.course_id = :se_course_id ';
		}

		if ( ! StringUtil::isEmpty ( $form->org_no ) ){
			$query .= ' AND co.org_no = :org_no ';
		}

		if ( ! StringUtil::isEmpty ( $form->offer_no ) ){
			$query .= ' AND co.offer_no = :offer_no ';
		}

		$stmt = $this->pdo->prepare ( $query );

		// 該当コースがある場合
		if ( ! StringUtil::isEmpty ( $form->se_course_id) ){
			$course_id = $form->se_course_id;
			$stmt->bindParam ( ":se_course_id", $course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->org_no ) ){
			$org_no = $form->org_no;
			$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $form->offer_no ) ){
			$offer_no = $form->offer_no;
			$stmt->bindParam ( ":offer_no", $offer_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_Course_OrgDto()) );
	}

	public function getOrgName($org_id) {

		$query = 'SELECT ';
		$query .= ' org_no';
		$query .= ' ,org_id';
		$query .= ' ,org_name';
		$query .= ' ,org_name_official';
		$query .= ' FROM M_ORGANIZATION ';
		$query .= 'WHERE del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $org_id ) ){
			$query .= ' AND org_id = :org_id ';
		}

		$stmt = $this->pdo->prepare ( $query );

		// 該当コースがある場合
		if ( ! StringUtil::isEmpty ( $org_id) ){
			$org_id = $org_id;
			$stmt->bindParam ( ":org_id", $org_id, PDO::PARAM_STR );
		}

		return parent::getDataList ( $stmt, get_class ( new M_OrganizationDto()) );
	}

	public function getCourseName($course_id) {

		$sysDate = DateUtil::getDate("Y/m/d h:i:s"); //20190617-検索コースの有効期間チェック追加

		$query = 'SELECT ';
		$query .= ' course_name';
		$query .= ' ,course_id';
		$query .= ' ,course_name_romaji';
		$query .= ' ,course_level';
		$query .= ' ,test_kbn';
		$query .= ' ,status';
		$query .= ' ,date_format(start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' FROM T_COURSE ';
		$query .= ' WHERE del_flg = 0 ';

		//20190617-コース契約登録画面で、コースIDで検索処理でコースのStatusと有効期間チェック追加
		$query .= ' AND status = 1';
		$query .= ' AND end_period >= :sysDate ';

		if ( ! StringUtil::isEmpty ( $course_id ) ){
			$query .= ' AND course_id = :course_id ';
		}

		$stmt = $this->pdo->prepare ( $query );

		// 該当コースがある場合
		if ( ! StringUtil::isEmpty ( $course_id) ){
			$stmt->bindParam ( ":course_id", $course_id, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":sysDate", $sysDate, PDO::PARAM_STR ); //20190617-検索コースの有効期間チェック追加

		return parent::getDataList ( $stmt, get_class ( new T_CourseDto()) );
	}

	/**
	 * コースIDを取得する
	 */
	public function getNextOfferNo() {
		return parent::getId ( "offer_no" );
	}

	public function getCourseOrgInfo($form) {

		$query = 'SELECT ';
		$query .= ' offer_no';
		$query .= ' ,course_id';
		$query .= ' ,org_no';
		$query .= ' ,remarks';
		$query .= ' ,date_format(start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' FROM T_COURSE_ORG ';
		$query .= 'WHERE del_flg = 0 ';

		if ( ! StringUtil::isEmpty ( $form->offer_no ) ){
			$query .= ' AND offer_no = :offer_no ';
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $form->offer_no) ){
			$offer_no = $form->offer_no;
			$stmt->bindParam ( ":offer_no", $offer_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_Course_OrgDto()) );
	}

	/**
	 * コース情報更新
	 */
	public function updateCourseOrgData($dto) {
		$query = "UPDATE ";
		$query .= "T_COURSE_ORG SET remarks = :remarks";
		$query .= " ,start_period = :start_period ";
		$query .= " ,end_period = :end_period ";
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$query .= " AND offer_no = :offer_no ";
		}
		if ( ! StringUtil::isEmpty ( $dto->org_no) ){
			$query .= " AND org_no = :org_no ";
		}
		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$query .= " AND course_id = :course_id ";
		}
		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty ( $dto->org_no ) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}
		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
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

	public function delCourseOrgData($dto) {

		$query = "UPDATE ";
		$query .= "T_COURSE_ORG SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE course_id = :course_id ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND offer_no = :offer_no ";

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no ) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}

	public function checkCourseOrgData($dto) {

		$query = 'SELECT ';
		$query .= ' offer_no';
		$query .= ' ,course_id';
		$query .= ' ,org_no';
		$query .= ' ,remarks';
		$query .= ' ,date_format(start_period,' . "'%Y/%m/%d') as start_period ";
		$query .= ' ,date_format(end_period,' . "'%Y/%m/%d') as end_period ";
		$query .= ' FROM T_COURSE_ORG ';
		$query .= 'WHERE del_flg = 0 ';

		if (! StringUtil::isEmpty( $dto->offer_no) ) {
			$query .= " AND offer_no != :offer_no ";
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no) ){
			$query .= " AND org_no = :org_no ";
		}

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$query .= " AND course_id = :course_id ";
		}

		if ( ! StringUtil::isEmpty ( $dto->start_period) ){
			$query .= " AND start_period = :start_period ";
		}

		if ( ! StringUtil::isEmpty ( $dto->end_period) ){
			$query .= " AND end_period = :end_period ";
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->org_no ) ){
			$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->start_period ) ){
			$stmt->bindParam ( ":start_period", $dto->start_period, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->end_period ) ){
			$stmt->bindParam ( ":end_period", $dto->end_period, PDO::PARAM_STR );
		}

		return parent::getDataList ( $stmt, get_class ( new T_Course_OrgDto()) );
	}
	
	/**
	 * コース組織契約設定データ更新
	 */
	public function updateCourseOrgConfData($dto) {
		
		$query = "UPDATE ";
		$query .= "T_COURSE_ORG_CONF SET fb_show_flg = :fb_show_flg";
		if ( ! StringUtil::isEmpty ( $dto->remarks ) ){
			$query .= " ,remarks = :remarks ";
		}
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";

		$query .= " AND offer_no = :offer_no ";
		$query .= " AND org_no = :org_no ";
		$query .= " AND course_id = :course_id ";
	
		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":fb_show_flg", $dto->fb_show_flg, PDO::PARAM_STR );
		
		if ( ! StringUtil::isEmpty ( $dto->remarks ) ){
			$stmt->bindParam ( ":remarks", $dto->remarks, PDO::PARAM_STR );
		}
		$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );

		return parent::update ( $stmt );
	}
	
	/**
	 * コース組織契約設定データ取得
	 */
	public function getCourseOrgConfInfo($dto) {

		$query = 'SELECT ';
		$query .= ' offer_no';
		$query .= ' ,course_id';
		$query .= ' ,org_no';
		$query .= ' ,fb_show_flg';
		$query .= ' ,remarks';
		$query .= ' FROM T_COURSE_ORG_CONF ';
		$query .= 'WHERE del_flg = 0 ';
		$query .= ' AND offer_no = :offer_no ';
		$query .= ' AND course_id = :course_id ';
		$query .= ' AND org_no = :org_no ';

		$stmt = $this->pdo->prepare ( $query );
		
		$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		$stmt->bindParam ( ":org_no", $dto->org_no, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class ( new T_Course_Org_ConfDto()) );
	}

	/**
	* 非表示するメニューIDを取得
	*/
	public function getMenuSetting($org_no) {
		
		$query = " SELECT ";
		$query .= " type.type type ";
		$query .= " ,type.name name ";
		$query .= " ,type.name_kana name_kana ";
		$query .= " ,setting.show_flg show_flg ";
		$query .= " FROM M_TYPE type";
		$query .= " LEFT JOIN T_MENU_SETTING setting";
		$query .= " ON type.name = setting.menu_id";
		$query .= " AND type.category = '038'";
		$query .= " AND setting.org_no = :org_no ";
		$query .= " AND setting.del_flg = '0' ";
		$query .= " WHERE";
		$query .= " type.category = '038'";
		$query .= " ORDER BY type.disp_no ASC";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );

		return parent::getDataList ( $stmt, get_class(new T_Menu_SettingDto()) );
	}
	
	/**
	* 非表示するメニューIDデータを削除
	*/
	public function delCourseOrgConf($org_no) {
		
		$query = " DELETE ";
		$query .= " FROM T_MENU_SETTING ";
		$query .= " WHERE";
		$query .= " org_no = :org_no";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );

		return parent::update ( $stmt );
	}

}