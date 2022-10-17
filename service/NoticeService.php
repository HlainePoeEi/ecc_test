<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'service/BaseService.php';
require_once 'conf/config.php';
require_once 'dao/T_NoticeDao.php';
require_once 'dao/M_LessonDao.php';

class NoticeService extends BaseService {

	/* 条件によるT_お知らせのcountを取得する */
	public function getNoticeListCount($form,$org_no) {
		$noticeDao = new T_NoticeDao($this->pdo );
		return $noticeDao->getNoticeListCount( $form,$org_no );
	}

	/* 条件によるT_お知らせのリストを取得する */
	public function getNoticeListData($form,$org_no) {
		$noticeDao = new T_NoticeDao($this->pdo );
		return $noticeDao->getNoticeSearchList($form,$form->page,$org_no);
	}

	/* お知らせ情報countを取得する */
    public function getNoticeInfoCount($form) {
		$dao = new T_NoticeDao( $this->pdo );
		return $dao->getNoticeInfoCount( $form);
	}

	/* お知らせ情報を取得する */
	public function getNoticeInfoList($form ,$flg) {
		$dao = new T_NoticeDao();
		return $dao->getNoticeInfoList( $form, $flg);
	}

	/* グループ名を取得する */
	public function getGroupNameList($form) {
		$dao = new T_NoticeDao();
		return $dao->getGroupNameList( $form );
	}

	/*条件によるT_アンケートのcountを取得する */
	public function getCountDataByNoticeNo($form) {
		$noticeDao = new T_NoticeDao($this->pdo );
		return $noticeDao->getCountDataByNoticeNo( $form );
	}

	public function getDataByNoticeNo($form) {
		$dao = new T_NoticeDao();
		return $dao->getDataByNoticeNo( $form );
	}

	/* 左のグループ選択リストの設定 */
	public function getNoticeTargetGroupList($form) {
		$dao = new T_NoticeDao();
		return $dao->getNoticeTargetGroupList( $form );
	}

	/* 左のグループ選択リストの設定 */
	public function getLessonTargetGroupList($form) {
		$dao = new M_LessonDao();
		return $dao->getLessonTargetGroupList( $form );
	}

	public function getLessonDataByStartEndDt($start_period,$end_period,$manager_no){
		$dao = new M_LessonDao();
		return $dao->getLessonDataByStartEndDt( $start_period,$end_period,$manager_no);
	}

	public function registData($dto) {
		$dao = new T_NoticeDao($this->pdo);
		return $dao->insert ( $dto );
	}
	public function updateNoticeData($dto){
		$dao = new T_NoticeDao();
		return $dao->updateNoticeData($dto);
	}

	public function deleteNoticeTargetData($form){
		$dao = new T_NoticeDao();
		return $dao->deleteNoticeTargetData($form);
	}
	public function getNextNoticeNo() {
		$dao = new T_NoticeDao($this->pdo);
		return $dao->getNextNoticeNo();
	}
}

?>