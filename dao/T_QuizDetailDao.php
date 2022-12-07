<?php

/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'conf/config.php';
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
require_once 'dto/T_YNSQuizDetailDto.php';

class T_QuizDetailDao extends BaseDao
{

	public function getQuizType()
	{
		$query = " SELECT ";
		$query .= " category";
		$query .= " ,type";
		$query .= " ,name";
		$query .= " ,name_kana";
		$query .= " FROM ";
		$query .= " M_TYPE ";
		$query .= " WHERE category = '010' ";
		$query .= " AND del_flg = '0' ";
		$query .= " ORDER BY disp_no ASC ";
		$stmt = $this->pdo->prepare($query);
		return parent::getDataList($stmt, get_class(new T_YNSQuizDetailDto()));
	}

	public function getQuizInfo($id)
	{
		$query = " SELECT ";
		$query .= " quiz_id";
		$query .= " ,name as quiz_name";
		$query .= " FROM ";
		$query .= " T_YNSQUIZ ";
		$query .= " WHERE quiz_id = :id ";
		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":id", $id, PDO::PARAM_STR);
		return parent::getDataList($stmt, get_class(new T_YNSQuizDetailDto()));
	}























	public function getQzItemInfo($org_no, $quiz_info_no)
	{

		$query = $this->getQueryItem();

		$stmt = $this->pdo->prepare($query);

		$this->setQzParamValue($stmt, $org_no, $quiz_info_no);
		return parent::getDataList($stmt, get_class(new T_Quiz_ItemDto()));
	}

	public function getQzItemOptionInfo($org_no, $quiz_info_no)
	{

		$query = $this->getQueryItemOpt();

		$stmt = $this->pdo->prepare($query);

		$this->setQzParamValue($stmt, $org_no, $quiz_info_no);
		return parent::getDataList($stmt, get_class(new T_Quiz_Item_OptionDto()));
	}

	private function getQueryItem()
	{
		$query = 'SELECT DISTINCT';

		$query .= ' qi.quiz_item_no as quiz_item_no, ';
		$query .= ' qi.quiz_type as quiz_type, ';
		$query .= ' qi.description as description, ';
		$query .= ' qi.marks as marks, ';
		$query .= ' qi.explanation as explanation, ';
		$query .= ' qi.remarks as remarks ';
		$query .= 'FROM T_QUIZ_INFO qf';

		$query .= ' LEFT JOIN T_QUIZ_ITEM qi ';
		$query .= ' ON qf.quiz_info_no = qi.quiz_info_no ';

		$query .= ' LEFT JOIN T_QUIZ_ITEM_OPTION qt ';
		$query .= ' ON qf.quiz_info_no = qt.quiz_info_no ';
		$query .= ' AND qi.quiz_item_no = qt.quiz_item_no ';
		$query .= " AND qf.del_flg = '0' ";
		$query .= ' WHERE qf.org_no = :org_no';
		$query .= ' AND qf.quiz_info_no = :quiz_info_no ';
		$query .= " AND  qi.del_flg = '0' AND qt.del_flg = '0' ";
		$query .= ' ORDER BY qi.quiz_item_no';

		return $query;
	}

	private function getQueryItemOpt()
	{
		$query = 'SELECT ';

		$query .= ' qt.quiz_item_no as quiz_item_no, ';
		$query .= ' qt.option_no as option_no, ';
		$query .= ' qt.description as description, ';
		$query .= ' qt.correct_flag as correct_flag ';

		$query .= 'FROM T_QUIZ_INFO qf';

		$query .= ' LEFT JOIN T_QUIZ_ITEM qi ';
		$query .= ' ON qf.quiz_info_no = qi.quiz_info_no ';

		$query .= ' LEFT JOIN T_QUIZ_ITEM_OPTION qt ';
		$query .= ' ON qf.quiz_info_no = qt.quiz_info_no ';
		$query .= ' AND qi.quiz_item_no = qt.quiz_item_no ';
		$query .= " AND qf.del_flg = '0' ";
		$query .= ' WHERE qf.org_no = :org_no';
		$query .= ' AND qf.quiz_info_no = :quiz_info_no ';
		$query .= " AND  qi.del_flg = '0' AND qt.del_flg = '0' ";
		$query .= ' ORDER BY qt.quiz_item_no, qt.option_no ASC ';

		return $query;
	}

	private function setQzParamValue($stmt, $org_no, $quiz_info_no)
	{

		if (!StringUtil::isEmpty($org_no)) {
			$stmt->bindParam(":org_no", $org_no, PDO::PARAM_INT);
		}
		if (!StringUtil::isEmpty($quiz_info_no)) {
			$stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_INT);
		}
	}

	public function deleteQuizItemInfoDetails($org_no, $quiz_info_no)
	{

		$query = 'DELETE qi.*,qt.* ';

		$query .= 'FROM T_QUIZ_INFO qf';

		$query .= ' LEFT JOIN T_QUIZ_ITEM qi ';
		$query .= ' ON qf.quiz_info_no = qi.quiz_info_no ';

		$query .= ' LEFT JOIN T_QUIZ_ITEM_OPTION qt ';
		$query .= ' ON qf.quiz_info_no = qt.quiz_info_no ';
		$query .= ' AND qi.quiz_item_no = qt.quiz_item_no ';

		$query .= ' WHERE';

		if (!StringUtil::isEmpty($org_no)) {
			$query .= ' qf.org_no = :org_no';
		}

		if (!StringUtil::isEmpty($quiz_info_no)) {
			$query .= " AND qf.quiz_info_no = :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare($query);

		if (!StringUtil::isEmpty($org_no)) {
			$stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
		} else {
			$stmt->bindParam(":org_no", NULL, PDO::PARAM_NULL);
		}
		if (!StringUtil::isEmpty($quiz_info_no)) {
			$stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
		} else {
			$stmt->bindParam(":quiz_info_no", NULL, PDO::PARAM_NULL);
		}

		$stmt->execute();
	}

	public function checkExistQInfoNo($org_no, $quiz_info_no)
	{

		$query =  'SELECT';
		$query .= ' count(*)';
		$query .= ' FROM T_YNSQUIZ quiz';

		// $query .= ' LEFT JOIN T_QUIZ_ITEM qi ';
		// $query .= ' ON qf.quiz_info_no = qi.quiz_info_no ';

		// $query .= ' LEFT JOIN T_QUIZ_ITEM_OPTION qt ';
		// $query .= ' ON qf.quiz_info_no = qt.quiz_info_no ';
		// $query .= ' AND qi.quiz_item_no = qt.quiz_item_no ';

		$query .= " WHERE";

		// if (! StringUtil::isEmpty ( $org_no )) {
		// 	$query .= ' qf.org_no = :org_no';
		// }

		if (!StringUtil::isEmpty($quiz_info_no)) {
			$query .= " AND quiz.quiz_id = :quiz_id ";
		}

		$stmt = $this->pdo->prepare($query);

		// if (! StringUtil::isEmpty ($org_no )) {
		// 	$stmt->bindParam ( ":org_no", $org_no, PDO::PARAM_STR );
		// }
		if (!StringUtil::isEmpty($quiz_info_no)) {
			$stmt->bindParam(":quiz_id", $quiz_info_no, PDO::PARAM_STR);
		}

		//LogHelper::logDebug ( "org :".$org_no);

		$stmt->execute();
		return $stmt->fetchColumn();
	}

	public function checkTestedQuiz($org_no, $quiz_info_no)
	{

		$query =  'SELECT';
		$query .= ' count(*)';
		$query .= ' FROM T_TEST_INFO_RESULT res';

		$query .= ' LEFT JOIN T_LESSON_TEST_INFO les ';
		$query .= ' ON res.test_info_no = les.test_info_no ';
		$query .= ' AND res.org_no = les.org_no ';

		$query .= " WHERE";

		if (!StringUtil::isEmpty($org_no)) {
			$query .= ' res.org_no = :org_no';
		}

		if (!StringUtil::isEmpty($quiz_info_no)) {
			$query .= " AND res.quiz_info_no = :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare($query);

		if (!StringUtil::isEmpty($org_no)) {
			$stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
		} else {
			$stmt->bindParam(":org_no", NULL, PDO::PARAM_NULL);
		}
		if (!StringUtil::isEmpty($quiz_info_no)) {
			$stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
		} else {
			$stmt->bindParam(":quiz_info_no", NULL, PDO::PARAM_NULL);
		}
		$stmt->execute();
		return $stmt->fetchColumn();
	}
}
