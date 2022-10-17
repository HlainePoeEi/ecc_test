<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_System_NoticeDto.php';
require_once 'util/DateUtil.php';

class T_System_NoticeDao extends BaseDao {

	/**
	 * お知らせを取得する
	 *
	 */
	 public function getNoticeList() {

		$query = " SELECT ";
		$query .= " sn.system_notice_no ";
		$query .= " ,sn.system_kbn ";
		$query .= " ,sn.description ";
		$query .= " ,DATE_FORMAT(sn.start_period, '%Y/%m/%d') start_period ";
		$query .= " ,sn.end_period ";
		$query .= " ,t.name ";
		$query .= " FROM T_SYSTEM_NOTICE sn";
		$query .= " LEFT JOIN M_TYPE t ";
		$query .= " ON t.type = sn.system_kbn ";
		$query .= " WHERE sn.del_flg = '0' ";
		$query .= " AND t.del_flg = 0 ";
		$query .= " AND :sys_date BETWEEN DATE_FORMAT(sn.start_period, '%Y/%m/%d') AND DATE_FORMAT(sn.end_period, '%Y/%m/%d') ";
		$query .= " AND t.category = :target_kbn ";

		$query .= " ORDER BY sn.system_kbn, start_period DESC ";

		$stmt = $this->pdo->prepare ( $query );

		$sys_date = DateUtil::getDate();
		$target_kbn = TARGET_KBN;

		$stmt->bindParam ( ":sys_date", $sys_date, PDO::PARAM_STR );
		$stmt->bindParam (":target_kbn", $target_kbn, PDO::PARAM_STR);

		return parent::getDataList ( $stmt, get_class ( new T_System_NoticeDto() ) );
	}

	/**
	 * お知らせ設定画面のデータを取得する
	 */
	public function getSystemNoticeData($form , $flg ) {

		$offset = ($form->page-1) * PAGE_ROW;

		$query = $this->getQuery ( $form );

		if ( $flg == "1" ){
			$query .= " LIMIT " . $offset . " , " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare ( $query );

		$target_kbn = TARGET_KBN;
		$stmt->bindParam(":target_kbn", $target_kbn, PDO::PARAM_STR);

		return parent::getDataList( $stmt, get_class ( new T_System_NoticeDto()) );
	}

	private function getQuery($form) {

		$query = " SELECT ";
		$query .= " t.name ";
		$query .= " ,s.system_notice_no ";
		$query .= " ,s.description ";
		$query .= " ,date_format(s.start_period," . "'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(s.end_period," . "'%Y/%m/%d') as end_period ";
		$query .= " ,a.admin_name ";

		$query .= " FROM T_SYSTEM_NOTICE s ";
		$query .= " LEFT JOIN M_TYPE t ";
		$query .= " ON t.type = s.system_kbn ";
		$query .= " AND t.del_flg = 0 ";

		$query .= " LEFT JOIN T_ADMIN a ";
		$query .= " ON a.admin_no = s.updater_id ";
		$query .= " AND a.del_flg = 0 ";

		$query .= " WHERE 1 = 1 ";
		$query .= " AND s.del_flg = 0 ";
		$query .= " AND t.category = :target_kbn ";

		$query .= " ORDER BY s.system_notice_no DESC";

		return $query;
	}

	/**
	 * お知らせ情報取得
	 */
	public function getSystemNoticeInfo($form) {

		$query = " SELECT ";
		$query .= " system_notice_no ";
		$query .= " ,system_kbn ";
		$query .= " ,description ";
		$query .= " ,date_format(start_period," . "'%Y/%m/%d') as start_period ";
		$query .= " ,date_format(end_period," . "'%Y/%m/%d') as end_period ";
		$query .= " FROM T_SYSTEM_NOTICE ";
		$query .= " WHERE del_flg = 0 ";

		if ( ! StringUtil::isEmpty ( $form->system_notice_no) ){
			$query .= " AND system_notice_no = :system_notice_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $form->system_notice_no) ){
			$system_notice_no = $form->system_notice_no;
			$stmt->bindParam ( ":system_notice_no", $system_notice_no, PDO::PARAM_STR );
		}

		return parent::getData ( $stmt, get_class ( new T_System_NoticeDto()) );
	}

	/**
	 * システムお知らせ№を取得する
	 */
	public function getNextSystemNoticeNo() {
		return parent::getId ( "system_notice_no" );
	}

	/**
	 * お知らせ情報更新
	 */
	public function updateSystemNoticeData($dto) {

		$query = " UPDATE ";
		$query .= " T_SYSTEM_NOTICE SET system_kbn = :system_kbn";
		$query .= " ,description = :description ";
		$query .= " ,start_period = :start_period ";
		$query .= " ,end_period = :end_period ";
		$query .= " ,update_dt = :update_dt";
		$query .= " ,updater_id = :updater_id ";
		$query .= " WHERE del_flg = '0' ";

		if ( ! StringUtil::isEmpty ( $dto->system_notice_no ) ){
			$query .= " AND system_notice_no = :system_notice_no ";
		}

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->system_notice_no ) ){
			$stmt->bindParam ( ":system_notice_no", $dto->system_notice_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->system_kbn ) ){
			$stmt->bindParam ( ":system_kbn", $dto->system_kbn, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->description ) ){
			$stmt->bindParam ( ":description", $dto->description, PDO::PARAM_STR );
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
}