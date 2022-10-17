<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/M_LessonDto.php';
require_once 'dto/M_Lesson_TargetDto.php';

/**
 * レッソン対象DAOクラス
 */
class M_Lesson_TargetDao extends BaseDao {

	/**
	 * レッスン名あるかどうかのチェック処理
	 * @param count
	 */
	public function getLessonListByName($org_no,$lesson_name) {
		$query = " SELECT ";
		$query .= "lesson_no, ";
		$query .= "grade_no ";
		$query .= "FROM ";
		$query .= "M_LESSON ";
		$query .= " WHERE org_no = :org_no ";
		$query .= "AND lesson_name LIKE :lesson_name ";
		$query .= "AND del_flg = '0' ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no",  $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_name", $lesson_name, PDO::PARAM_STR );
		return parent::getDataList( $stmt, get_class(new M_LessonDto()) );
	}

	/**
	 * 条件とページを指定してグループのデータリストを取得する
	 */
	public function getLessonGpSearchList($org_no,$lesson_no,$group_name) {
		$query = " SELECT ";
		$query .= "gp.group_name group_name ";
		$query .= ",gp.group_no group_no ";
		$query .= ",gp.grade_no grade_no ";
		$query .= ",concat(DATE_FORMAT(gp.start_period,'%Y/%m/%d'),'~',DATE_FORMAT(gp.end_period,'%Y/%m/%d')) period ";
		$query .= " FROM ";
		$query .= " M_LESSON lesson ";
		$query .= " INNER JOIN T_GROUP gp ";
		$query .= " ON lesson.org_no=gp.org_no ";
		$query .= " WHERE ";
		$query .= "lesson.org_no = gp.org_no ";
		$query .= "AND lesson.del_flg = '0' ";
		$query .= "AND gp.del_flg = '0' ";
		$query .= " AND ((gp.start_period BETWEEN lesson.start_period AND lesson.end_period ";
		$query .= " OR gp.end_period BETWEEN lesson.start_period AND lesson.end_period) ";
		$query .= " OR (lesson.start_period BETWEEN gp.start_period AND gp.end_period ";//20190425レッスン・グループ有効期間チェック修正
		$query .= " AND lesson.end_period BETWEEN gp.start_period AND gp.end_period)) ";//20190425レッスン・グループ有効期間チェック修正
		$query .= "AND gp.org_no = :org_no ";
		$query .= "AND lesson.lesson_no = :lesson_no ";
		$query .= "AND gp.group_name LIKE :group_name ";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_no", $lesson_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_name", $group_name, PDO::PARAM_STR );
		LogHelper::logDebug("SQL:".$query);
		LogHelper::logDebug("org_no:".$org_no."group_name:".$group_name."lesson_no:".$lesson_no);
		return parent::getDataList( $stmt, get_class(new M_LessonDto()) );
	}

	/***
	 * レッスン登録
	 * @param object $group_dto
	 * @param array $lm_dto_arr
	 * @return integer type
	 */
	public function insertData($resultList , $pdo){
		return parent::insertWithTranPdo($resultList , $pdo);
	}

	
	/**
	 * レッスン・グループテーブルで登録する前、重複チェック処理-20190425修正
	 * Mレッソン対象のデータcount
	 *
	 * @param unknown $form
	 * @return int
	 */
	public function lessonTargetCount($org_no, $lesson_no, $group_no) {
		$query = " SELECT";
		$query .= " lesson_no";
		$query .= " ,group_no";
		$query .= " FROM";
		$query .= " M_LESSON_TARGET";
		$query .= " WHERE";
		$query .= " org_no = :org_no";
		$query .= " AND lesson_no = :lesson_no";
		$query .= " AND group_no = :group_no";
		$query .= " AND del_flg = '0'";
		$stmt = $this->pdo->prepare ( $query );
		$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":lesson_no", $lesson_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":group_no", $group_no, PDO::PARAM_STR );
		LogHelper::logDebug("lessonTargetCount org_no:".$org_no."lessonNo:".$lesson_no."groupNo:".$group_no);
		return parent::getDataList( $stmt, get_class(new M_Lesson_TargetDto()) );
	}

}
?>