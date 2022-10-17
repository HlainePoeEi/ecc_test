<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'conf/config.php';
require_once 'dto/T_4Skill_AnswerDto.php';

/**
 * 4SkillAnswerDAOクラス
 */
class T_4Skill_AnswerDao extends BaseDao {

	/**
	 * 受講回答情報を削除する・削除フラグを１に変更する
	 */

	public function delStudentAnswer($dto){
		
		$query = "UPDATE ";
		$query .= "T_4SKILL_ANSWER SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE offer_no = :offer_no ";
		$query .= " AND student_no = :student_no ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND course_detail_no = :course_detail_no ";

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->student_no) ){
			$stmt->bindParam ( ":student_no", $dto->student_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_detail_no) ){
			$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return parent::update ( $stmt );
	}
	
	/**
	 * 採点情報を削除する
	 */

	public function del4SkillResultData($dto){
		
		$query = "UPDATE ";
		$query .= "T_4SKILL_RESULT SET del_flg = '1'";
		$query .= " ,updater_id = :updater_id ";
		$query .= " ,update_dt = :update_dt";
		$query .= " WHERE offer_no = :offer_no ";
		$query .= " AND student_no = :student_no ";
		$query .= " AND course_id = :course_id ";
		$query .= " AND course_detail_no = :course_detail_no ";

		$stmt = $this->pdo->prepare ( $query );

		if ( ! StringUtil::isEmpty ( $dto->offer_no ) ){
			$stmt->bindParam ( ":offer_no", $dto->offer_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_id ) ){
			$stmt->bindParam ( ":course_id", $dto->course_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->course_detail_no) ){
			$stmt->bindParam ( ":course_detail_no", $dto->course_detail_no, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->student_no) ){
			$stmt->bindParam ( ":student_no", $dto->student_no, PDO::PARAM_STR );
		}
		
		if ( ! StringUtil::isEmpty ( $dto->updater_id) ){
			$stmt->bindParam ( ":updater_id", $dto->updater_id, PDO::PARAM_STR );
		}

		if ( ! StringUtil::isEmpty ( $dto->update_dt) ){
			$stmt->bindParam ( ":update_dt", $dto->update_dt, PDO::PARAM_STR );
		}

		return $stmt->execute();
	}

}
?>