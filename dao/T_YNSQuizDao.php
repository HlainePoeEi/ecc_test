<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';
require_once 'dto/T_YNSQuizDto.php';

/**
 * T_Quiz_InfoDaoクラス
 */
class T_YNSQuizDao extends BaseDao
{

	public function getQuizResultCount($param)
	{

		$query = " SELECT ";
		$query .= " distinct quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz ";
		$query .= " WHERE quiz.org_no = :org_no ";

		if (!StringUtil::isEmpty($param->quiz_name)) {
			$query .= " AND (quiz.quiz_name LIKE :quiz_name) ";
		}

		if (!StringUtil::isEmpty($param->long_description)) {
			$query .= " AND (quiz.long_description LIKE :long_description ) ";
		}

		if (!StringUtil::isEmpty($param->remark)) {
			$query .= " AND (quiz.remarks LIKE :remark ) ";
		}

		if (!StringUtil::isEmpty($param->updater_id)) {
			$query .= " AND (quiz.updater_id=:updater_id ) ";
		}

		$query .= " AND quiz.del_flg = '0' ";
		$query .= " ORDER BY ";
		$query .= " quiz_name ASC";
		$query .= " ,long_description ASC";

		$stmt = $this->pdo->prepare($query);

		$stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);

		if (!StringUtil::isEmpty($param->quiz_name)) {

			$name = '%' . $param->quiz_name . '%';
			$stmt->bindParam(":quiz_name", $name, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->long_description)) {

			$long_description = '%' . $param->long_description . '%';
			$stmt->bindParam(":long_description", $long_description, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->remark)) {

			$remark = '%' . $param->remark . '%';
			$stmt->bindParam(":remark", $remark, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->updater_id)) {
			$stmt->bindParam(":updater_id", $param->updater_id, PDO::PARAM_STR);
		}

		$list = parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
		logHelper::logDebug("count of quiz list"  . count($list));
		return count($list);
	}

	public function getQuizSearchData($param, $flg)
	{

		$query = " SELECT ";
		$query .= " quiz.name name ";
		$query .= " ,quiz.content content ";
		$query .= " FROM ";
		$query .= " T_YNSQUIZ quiz ";

		if (!StringUtil::isEmpty($param->name) || !StringUtil::isEmpty($param->content) || !StringUtil::isEmpty($param->remarks)) {
			$query .= " WHERE ";
		}

		if (!StringUtil::isEmpty($param->name)) {
			$query .= "	(quiz.name LIKE :name) ";
		} elseif (!StringUtil::isEmpty($param->content) || !StringUtil::isEmpty($param->remarks)) {
			$query .= "	(quiz.name = '') ";
		}

		if (!StringUtil::isEmpty($param->content)) {
			$query .= " OR (quiz.content LIKE :content ) ";
		}

		if (!StringUtil::isEmpty($param->remarks)) {
			$query .= " OR (quiz.remarks LIKE :remarks) ";
		}

		$query .= " ORDER BY ";
		$query .= " name ASC";
		$query .= " ,content ASC";

		LogHelper::logDebug($query);

		$stmt = $this->pdo->prepare($query);

		if (!StringUtil::isEmpty($param->name)) {

			$name = '%' . $param->name . '%';
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->content)) {

			$content = '%' . $param->content . '%';
			$stmt->bindParam(":content", $content, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->remarks)) {

			$remarks = '%' . $param->remarks . '%';
			$stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
		}

		return parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
	}

	public function getQuizListData($param, $flg)
	{

		// $offset = ($param->page - 1) * PAGE_ROW;

		$query = " SELECT ";
		$query .= " * ";
		$query .= " FROM ";
		$query .= " T_YNSQUIZ ";
		$query .= " ORDER BY ";
		$query .= " name ASC";
		$query .= " ,content ASC";

		if ($flg == "1") {
			$query .= " LIMIT " . $offset . " ,  " . PAGE_ROW;
		}

		$stmt = $this->pdo->prepare($query);

		if (!StringUtil::isEmpty($param->name)) {

			$name = '%' . $param->name . '%';
			$stmt->bindParam(":name", $name, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->content)) {

			$content = '%' . $param->content . '%';
			$stmt->bindParam(":content", $content, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($param->remarks)) {

			$remarks = '%' . $param->remarks . '%';
			$stmt->bindParam(":remark", $remarks, PDO::PARAM_STR);
		}

		return parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
	}

	/**
	 * 更新画面のため、データ取得処理
	 *
	 * @param unknown $form
	 * @return string
	 */
	public function getQuizDataByQuizNo($quiz_id)
	{

		$query = " SELECT ";
		$query .= " * ";
		$query .= " FROM ";
		$query .= " t_ynsquiz ";
		$query .= " WHERE quiz_id = :quiz_id ";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":quiz_id",  $quiz_id, PDO::PARAM_STR);
		return parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
	}

	public function saveQuiz($dto)
	{

		return parent::insert($dto);
	}

	public function saveTestQuiz($dto)
	{

		return parent::insert($dto);
	}

	public function getNext()
	{

		return parent::getId("quiz_info_no");
	}

	public function updateQuizInfo($dto)
	{

		$query = " UPDATE ";
		$query .= " t_ynsquiz ";
		$query .= " SET";
		$query .= " name   = :name ";
		$query .= " ,content   = :content ";
		$query .= " ,remarks  = :remarks ";

		if (!StringUtil::isEmpty($dto->audio_name)) {
			$query .= " ,audio_name  =  :audio_name ";
		} else {
			$query .= " ,audio_name  =  '' ";
		}

		if (!StringUtil::isEmpty($dto->update_dt)) {
			$query .= " ,update_dt = :update_dt";
		}

		$query .= " WHERE ";
		$query .= " quiz_id = :quiz_id ";

		$stmt = $this->pdo->prepare($query);

		if (!StringUtil::isEmpty($dto->content)) {
			$stmt->bindParam(":content",  $dto->content, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($dto->audio_name)) {
			$stmt->bindParam(":audio_name",  $dto->audio_name, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($dto->update_dt)) {
			$stmt->bindParam(":update_dt", $dto->update_dt, PDO::PARAM_STR);
		}

		$stmt->bindParam(":name",  $dto->name, PDO::PARAM_STR);
		$stmt->bindParam(":content",  $dto->content, PDO::PARAM_STR);
		$stmt->bindParam(":remarks",  $dto->remarks, PDO::PARAM_STR);
		$stmt->bindParam(":quiz_id",  $dto->quiz_id, PDO::PARAM_STR);

		loghelper::logdebug($query);
		return parent::update($stmt);
	}

	public function deleteQuizInfo($dto)
	{

		$query = " delete ";
		$query .= " from ";
		$query .= " t_ynsquiz ";
		$query .= " WHERE ";
		$query .= " quiz_id = :quiz_id ";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":quiz_id",  $dto->quiz_id, PDO::PARAM_STR);

		return parent::delete($stmt);
	}

	/**
	 * クイズ名重複チェック処理
	 *
	 * @param count
	 */
	public function checkedExistInfo($org_no, $quiz_info_no, $quiz_name)
	{

		$query = " SELECT ";
		$query .= " quiz.quiz_info_no";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz";
		$query .= " WHERE quiz.org_no = :org_no ";
		$query .= " AND quiz.quiz_name = :quiz_name ";
		$query .= " AND quiz.del_flg = '0' ";

		if (!StringUtil::isEmpty($quiz_info_no)) {
			$query .= " AND quiz.quiz_info_no != :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":quiz_name", $quiz_name, PDO::PARAM_STR);

		if (!StringUtil::isEmpty($org_no)) {

			$stmt->bindParam(":org_no",  $org_no, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($quiz_info_no)) {

			$stmt->bindParam(":quiz_info_no",  $quiz_info_no, PDO::PARAM_STR);
		}


		$list = parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
		return count($list);
	}

	public function getQuizDataByQuizNoDisable($quizInfoNo)
	{

		$query .= " SELECT  testquiz.quiz_info_no quiz_info_no   ";
		$query .= " FROM  T_LESSON_TEST_INFO lessontest   ";
		$query .= " INNER JOIN T_TEST_INFO_QUIZ testquiz ";
		$query .= " ON lessontest.org_no = testquiz.org_no ";
		$query .= " AND lessontest.test_info_no = testquiz.test_info_no ";
		$query .= " AND testquiz.del_flg = '0'  ";
		$query .= " WHERE lessontest.org_no = :org_no  ";
		$query .= " AND lessontest.del_flg = '0'  ";
		$query .= " AND testquiz.quiz_info_no = :quiz_info_no ";

		LogHelper::logDebug("
		ByQuizNoDisable Query : " . $query);
		$stmt = $this->pdo->prepare($query);

		$stmt->bindParam(":org_no", $orgNo, PDO::PARAM_STR);
		$stmt->bindParam(":quiz_info_no", $quizInfoNo, PDO::PARAM_STR);

		$list = parent::getDataList($stmt, get_class(new T_YNSQuizDto()));
		LogHelper::logDebug("------------------list------------" . count($list));
		return count($list);
	}


	/**
	 * 更新画面のため、データ取得処理
	 *
	 * @param unknown $form
	 * @return string
	 */
	public function getQuizData($org_no, $quiz_info_no)
	{

		$query = " SELECT ";
		$query .= " quiz.quiz_info_no quiz_info_no ";
		$query .= " ,quiz.quiz_name quiz_name ";
		$query .= " ,quiz.long_description long_description ";
		$query .= " ,quiz.audio_name audio_name ";
		$query .= " ,quiz.remarks remarks ";
		$query .= " FROM ";
		$query .= " T_QUIZ_INFO quiz ";
		$query .= " WHERE quiz.del_flg = '0' ";

		if (!StringUtil::isEmpty($org_no)) {
			$query .= "AND quiz.org_no = :org_no ";
		}

		if (!StringUtil::isEmpty($quiz_info_no)) {
			$query .= "AND quiz.quiz_info_no = :quiz_info_no ";
		}

		$stmt = $this->pdo->prepare($query);


		if (!StringUtil::isEmpty($org_no)) {
			$stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
		}

		if (!StringUtil::isEmpty($quiz_info_no)) {
			$stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
		}

		return parent::getData($stmt, get_class(new T_YNSQuizDto()));
	}
}
