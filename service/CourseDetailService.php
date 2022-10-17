<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'dao/T_Course_DetailDao.php';
require_once 'dao/T_Course_Detail_StudentDao.php';
require_once 'service/BaseService.php';
require_once 'dao/T_4Skill_AnswerDao.php';

class CourseDetailService extends BaseService{

	public function getDetailListOnCourse($form){
		// データベース接続
		$dao = new T_Course_DetailDao();
		$pageno= ($form->page - 1) * PAGE_ROW;
		return $dao-> getDetailListOnCourse($form , ($form->page - 1) * PAGE_ROW);
	}

	public function getSearchDetailList($dto){
		// データベース接続
		$dao = new T_Course_DetailDao();
		return $dao-> getSearchDetailList($dto, 1);
	}

	public function countExistingDetail($course_id) {
		$dao = new T_Course_DetailDao();
		return $dao->countExistingDetail ($course_id);
	}

	public function deleteDetailOnCourse($course_id) {
		// データベース接続
		$dao = new T_Course_DetailDao($this->pdo);
		return $dao->deleteDetailOnCourse($course_id , $this->pdo);
	}

	public function addDetailDataOnCourse($dto) {
		// データベース接続
		$dao = new T_Course_DetailDao( $this->pdo );
		return $dao->insertWithPdo ( $dto , $this->pdo);
	}

	public function getStudentCourseDetailList($dto, $course_detail_no) {
		// データベース接続
		$dao = new T_Course_Detail_StudentDao( $this->pdo );
		return $dao->getStudentCourseDetailList ( $dto, $course_detail_no );
	}

	public function updateStudentCoursePeriod($dto) {
		// データベース接続
		$dao = new T_Course_Detail_StudentDao( $this->pdo );
		return $dao->updateStudentCoursePeriod ( $dto );
	}

	public function getCourseDetailListByCourseDetailNo($param) {
		// データベース接続
		$dao = new T_Course_DetailDao( $this->pdo );
		return $dao->getCourseDetailListByCourseDetailNo( $param );
	}

	public function delCourseDetailStudentData($dto) {

		// データベース接続
		$dao = new T_Course_Detail_StudentDao($this->pdo);

		return $dao->delCourseDetailStudentData( $dto );
	}

	// ４技能受講回答情報を削除する
	public function delStudentAnswerData($dto){

		$dao = new T_4Skill_AnswerDao($this->pdo);
		$rtn = $dao->delStudentAnswer( $dto );
		
		if ( $rtn > 0 ){

			return $dao->del4SkillResultData($dto);
		}else{
			return $rtn;
		}
	}

}