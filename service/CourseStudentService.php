<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_Course_StudentDao.php';
require_once 'dao/T_Course_Detail_StudentDao.php';
require_once 'service/BaseService.php';

class CourseStudentService extends BaseService{

	public function getOrganizationData($param){
		// データベース接続
		$dao = new T_Course_StudentDao();
		return $dao->getOrganizationData($param);
	}

	public function getCourseDetailByCourseId($course_id){
		// データベース接続
		$dao = new T_Course_StudentDao();
		return $dao->getCourseDetailByCourseId($course_id);
	}

	public function getStudentListByGroupAndLoginId($param){
		// データベース接続
		$dao = new T_Course_StudentDao();
		return $dao->getStudentListByGroupAndLoginId($param);
	}

	public function registerCourseStudentData($dto){
		// データベース接続
		$dao = new T_Course_StudentDao($this->pdo);
		return $dao->saveCourseStudent($dto , $this->pdo);
	}

	public function registerCoursDetailStudentData($dto){
		// データベース接続
		$dao = new T_Course_Detail_StudentDao( $this->pdo);
		return $dao->saveCourseDetail($dto , $this->pdo);
	}


	public function delCourseStudentData($dto) {

		// データベース接続
		$dao = new T_Course_StudentDao($this->pdo);

		return $dao->delCourseStudentData( $dto );
	}
	
	public function getCourseStudentData($dto){
		
		// データベース接続
		$dao = new T_Course_StudentDao();
		return $dao->getCourseStudentData($dto);
	}
	
	public function getCourseDetailStudentData($dto){
		
		// データベース接続
		$dao = new T_Course_StudentDao();
		return $dao->getCourseDetailStudentData($dto);
	}
}