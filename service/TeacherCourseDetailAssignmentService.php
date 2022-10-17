<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_TeacherCourseDetailDao.php';
require_once 'service/BaseService.php';

class TeacherCourseDetailAssignmentService extends BaseService{

	public function getCourseDetailData($param){
		// データベース接続
		$dao = new T_TeacherCourseDetailDao();
		return $dao->getCourseDetailData($param);
	}

	public function getCourseDetailRegisterData($teacher_no) {
		// データベース接続
		$dao = new T_TeacherCourseDetailDao();
		return $dao->getCourseDetailRegisterData($teacher_no);
	}

	public function deleteCourseDetailData($teacher_no) {
		// データベース接続
		$dao = new T_TeacherCourseDetailDao( $this->pdo);
		return $dao->deleteCourseDetailData($teacher_no , $this->pdo);
	}

	public function registerTeacherCourseDetailData($dto) {
		// データベース接続
		$dao = new T_TeacherCourseDetailDao( $this->pdo);
		return $dao->insertWithPdo ($dto , $this->pdo);
	}
}
?>