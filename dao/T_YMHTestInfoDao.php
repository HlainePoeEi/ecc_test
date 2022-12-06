<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDao.php';
require_once 'dto/T_YNSExamDto.php';
require_once 'dto/T_Test_Info_QuizDto.php';
// require_once 'dto/T_Test_StateDto.php';
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
// require_once 'dto/T_Test_Info_Result_HistoryDto.php';

/**
 * T_Test_InfoDAOクラス
 */
class T_YMHTestInfoDao extends BaseDao
{
    
    public function getTestResultCount($param)
    {
        $query = " SELECT ";
        $query .= " distinct test.test_info_no test_info_no ";
        $query .= " ,test.test_info_name test_info_name ";
        $query .= " ,test.remarks remarks ";
        $query .= " ,test.status status ";
        $query .= " ,date_format(test.start_period,'%Y/%m/%d') as start_period ";
        $query .= " ,date_format(test.end_period,'%Y/%m/%d') as end_period ";
        $query .= " FROM ";
        $query .= " T_TEST_INFO test ";
        $query .= " LEFT JOIN T_TEST_INFO_QUIZ as test_quiz ";
        $query .= " ON test.org_no = test_quiz.org_no ";
        $query .= " AND test.test_info_no = test_quiz.test_info_no ";
        $query .= " WHERE test.start_period <= :end_period ";
        $query .= " AND test.end_period >= :start_period ";
        $query .= " AND test.org_no = :org_no ";
        
        if (! StringUtil::isEmpty($param->test_name)) {
            $query .= " AND (test.test_info_name LIKE :test_name) ";
        }
        
        if (! StringUtil::isEmpty($param->remark)) {
            $query .= " AND (test.remarks LIKE :remark ) ";
        }
        
        if (! StringUtil::isEmpty($param->status)) {
            $query .= " AND test.status IN (" . $param->status . ") ";
        }
        
        if (! StringUtil::isEmpty($param->updater_id)) {
            $query .= " AND (test.updater_id=:updater_id ) ";
        }
        
        $query .= " AND test.del_flg = '0' ";
        $query .= " ORDER BY ";
        $query .= " test_info_name ASC";
        $query .= " ,remarks ASC";
        
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindParam(":start_period", $param->start_period, PDO::PARAM_STR);
        $stmt->bindParam(":end_period", $param->end_period, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);
        
        if (! StringUtil::isEmpty($param->test_name)) {
            
            $name = '%' . $param->test_name . '%';
            $stmt->bindParam(":test_name", $name, PDO::PARAM_STR);
        }
        
        if (! StringUtil::isEmpty($param->remark)) {
            
            $remark = '%' . $param->remark . '%';
            $stmt->bindParam(":remark", $remark, PDO::PARAM_STR);
        }
        
        if (! StringUtil::isEmpty($param->updater_id)) {
            $stmt->bindParam(":updater_id", $param->updater_id, PDO::PARAM_STR);
        }
        
        $list = parent::getDataList($stmt, get_class(new T_Test_InfoDto()));
        return count($list);
    }
    
    public function getTestListData($param)
    {
        $systemDate = DateUtil::getDate("Y/m/d H:i:s");
        
        $query = "SELECT ";
        $query .= " ttest.test_info_no";
        $query .= " ,ttest.show_flg";
        $query .= " ,ttest.test_info_name";
        $query .= " ,ttest.start_period";
		$query .= " ,MAX(ttest_result.answer_dt) answer_dt";
		$query .= " ,SUM(ttest_result.ans_option_no) ans_option_no";
		$query .= " ,GROUP_CONCAT( DISTINCT mlesson.lesson_name)";
        $query .= " FROM T_STUDENT  tstu";
        $query .= " INNER JOIN T_GROUP_STUDENT tgrpstu";
        $query .= " 	ON tstu.org_no = tgrpstu.org_no";
        $query .= " 	AND tstu.student_no = tgrpstu.student_no";
        $query .= " 	AND tgrpstu.del_flg = '0'";
        $query .= " INNER JOIN M_LESSON_TARGET mlessontar";
        $query .= " ON tgrpstu.org_no = mlessontar.org_no";
        $query .= " 	AND tgrpstu.group_no = mlessontar.group_no";
        $query .= " 	AND mlessontar.del_flg = '0'";
		
		$query .= " INNER JOIN T_GROUP tgroup";
		$query .= " ON tgrpstu.org_no = tgroup.org_no";
		$query .= " AND tgrpstu.group_no = tgroup.group_no";
		$query .= " AND tgroup.del_flg = '0'";
		$query .= " AND :current_time2 BETWEEN tgroup.start_period AND tgroup.end_period";
		
        $query .= "     INNER JOIN M_LESSON mlesson  ";
        $query .= " 	ON mlessontar.org_no = mlesson.org_no";
        $query .= " 	AND mlessontar.lesson_no = mlesson.lesson_no";
        $query .= " 	AND mlesson.del_flg = '0'";
        if (! StringUtil::isEmpty($param->subject_no)) {
            $query .= " AND (mlesson.subject_no = :subject_no )";
        }
        $query .= " 	INNER JOIN T_LESSON_TEST_INFO tlessontest";
        $query .= " 	ON mlesson.org_no = tlessontest.org_no	";
        $query .= " AND mlesson.lesson_no = tlessontest.lesson_no";
        $query .= " AND tlessontest.del_flg = '0'";
        $query .= " INNER JOIN T_TEST_INFO ttest";
        $query .= " ON tlessontest.org_no = ttest.org_no";
        $query .= " AND tlessontest.test_info_no = ttest.test_info_no";
        $query .= " AND ttest.del_flg = '0'";
        $query .= " AND ttest.status = '1'";

		$query .= " LEFT JOIN T_TEST_INFO_RESULT ttest_result";
        $query .= " ON ttest.org_no = ttest_result.org_no";
        $query .= " AND ttest.test_info_no = ttest_result.test_info_no";
		$query .= " AND tstu.student_no = ttest_result.student_no";
        $query .= " AND ttest_result.del_flg = '0'";
		
        $query .= " WHERE tstu.org_no = :org_no";
        $query .= " AND tstu.student_no = :student_no";
		$query .= " AND :current_time BETWEEN ttest.start_period AND ttest.end_period";
		$query .= " AND :system_date BETWEEN mlesson.start_period AND mlesson.end_period ";
        $query .= " GROUP BY ttest.org_no,ttest.test_info_no,ttest.test_info_name ,ttest.start_period,ttest.show_flg";
        $query .= " ORDER BY ttest.start_period DESC";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);
        $stmt->bindParam(":student_no", $param->student_no, PDO::PARAM_STR);
        $stmt->bindParam(":current_time", $systemDate, PDO::PARAM_STR);
		$stmt->bindParam(":system_date", $systemDate, PDO::PARAM_STR);
		$stmt->bindParam(":current_time2", $systemDate, PDO::PARAM_STR);
        
        if (! StringUtil::isEmpty($param->subject_no)) {
            $stmt->bindParam(":subject_no", $param->subject_no, PDO::PARAM_STR);
        }
        return parent::getDataList($stmt, get_class(new T_YMHTestInfoDto()));
    }
    
    // テストクイズ
    public function getListQuiz($org_no, $test_info_no)
    {
        $query = " SELECT ";
        $query .= " test.test_info_name test_info_name ";
        $query .= " ,test.test_time test_time ";
        $query .= " ,test.test_info_no test_info_no ";
        $query .= " ,quiz.quiz_info_no quiz_info_no ";
        $query .= " ,quiz.audio_name audio_name ";
        $query .= " ,quiz.quiz_name quiz_name ";
        $query .= " ,quiz.long_description quiz_description ";
        $query .= " ,test.org_no org_no ";
        $query .= " ,test.long_description long_description ";
        $query .= " FROM ";
        $query .= " T_TEST_INFO_QUIZ testquiz";
        $query .= " INNER JOIN T_TEST_INFO test";
        $query .= " ON testquiz.test_info_no = test.test_info_no ";
        $query .= " AND test.org_no = testquiz.org_no ";
        $query .= " AND testquiz.del_flg = '0' ";
        $query .= " INNER JOIN T_QUIZ_INFO quiz";
        $query .= " ON testquiz.quiz_info_no = quiz.quiz_info_no ";
        $query .= " AND testquiz.org_no = quiz.org_no ";
        $query .= " AND quiz.del_flg = '0' ";
        $query .= " WHERE test.test_info_no = :test_info_no ";
        $query .= " AND test.org_no = :org_no ";
        $query .= " AND test.del_flg = '0' ";
        $query .= " ORDER BY ";
        $query .= " testquiz.disp_no ASC";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);
        
        return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    }
    
    // テストプレビュー
    public function getExamList($form)
    {
        $query = " SELECT ";
        $query .= " exam.* ";
        // $query .= " ,exam.subject_name subject_name ";
        // $query .= " ,exam.org_no org_no ";
        $query .= " FROM ";
        $query .= " T_YNSEXAM exam";
        // $query .= " WHERE exam.org_no = :org_no ";
        // $query .= " AND exam.del_flg = '0' ";
        // $query .= " ORDER BY ";
        // $query .= " exam.disp_no ASC";

        $stmt = $this->pdo->prepare($query);
        // $stmt->bindParam(":org_no", $form->org_no, PDO::PARAM_STR);
        
        return parent::getDataList($stmt, get_class(new T_YNSExamDto()));
    }
    
    /**
     * シアイテム情報更新処理
     *
     * @param
     *            $dto
     */
    public function updateTestInfoResult($dto)
    {
        $query = " UPDATE ";
        $query .= " T_TEST_INFO_RESULT";
        $query .= " SET";
        $query .= " answer_dt = :answer_dt ";
        $query .= " ,update_dt = :update_dt ";
        $query .= " ,updater_id = :updater_id ";
        $query .= " ,correct_flag = :correct_flag ";
        $query .= " ,ans_option_no = :option_no ";
		$query .= " ,answer_text = :ansewer_text ";
        $query .= " WHERE ";
        $query .= " org_no = :org_no ";
        $query .= " AND student_no = :student_no ";
        $query .= " AND test_info_no = :test_no ";
        $query .= " AND quiz_info_no = :quiz_no ";
        $query .= " AND quiz_item_no = :item_no ";
        $query .= " AND del_flg = '0' ";
        
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":answer_dt", $dto->answer_dt, PDO::PARAM_STR);
        $stmt->bindParam(":correct_flag", $dto->correct_flag, PDO::PARAM_STR);
		$stmt->bindParam(":ansewer_text", $dto->answer_text, PDO::PARAM_STR);
        $stmt->bindParam(":update_dt", $dto->update_dt, PDO::PARAM_STR);
        $stmt->bindParam(":updater_id", $dto->updater_id, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $dto->org_no, PDO::PARAM_STR);
        $stmt->bindParam(":student_no", $dto->student_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_no", $dto->test_info_no, PDO::PARAM_STR);
        $stmt->bindParam(":quiz_no", $dto->quiz_info_no, PDO::PARAM_STR);
        $stmt->bindParam(":option_no", $dto->ans_option_no, PDO::PARAM_STR);
        $stmt->bindParam(":item_no", $dto->quiz_item_no, PDO::PARAM_STR);
       
        
        return parent::update($stmt);
    }
    
    /**
     * テスト結果情報新規登録
     *
     * @param  $dto
     */
    public function insertData($dto)
    {
        return parent::insert($dto);
    }
    
    // テスト結果
    public function getTestResultData($form)
    {
        $query = " SELECT ";
        $query .= " test_result.student_no student_no ";
        $query .= " ,test_result.test_info_no test_info_no ";
        $query .= " ,test_result.org_no org_no ";
        $query .= " ,test.test_time test_time ";
        $query .= " ,test.long_description long_description ";
        $query .= " ,test_result.quiz_item_no quiz_item_no ";
        $query .= " ,test_result.quiz_info_no quiz_info_no ";
        $query .= " ,test_result.ans_option_no ans_option_no ";
        $query .= " ,test_result.correct_flag correct_flag ";
        $query .= " ,date_format(test_result.answer_dt,'%Y/%m/%d') as answer_dt ";
        $query .= " FROM ";
        $query .= " T_TEST_INFO_RESULT test_result";
        $query .= " INNER JOIN T_TEST_INFO test";
        $query .= " ON test_result.test_info_no = test.test_info_no ";
        $query .= " AND test_result.org_no = test.org_no ";
        $query .= " AND test.del_flg = '0' ";
        $query .= " INNER JOIN T_TEST_INFO_QUIZ testquiz";
        $query .= " ON test.test_info_no = testquiz.test_info_no ";
		$query .= " AND test.org_no = testquiz.org_no ";
		$query .= " AND test_result.quiz_info_no = testquiz.quiz_info_no ";

        $query .= " WHERE test_result.org_no = :org_no ";
        $query .= " AND test_result.student_no = :student_no ";
        $query .= " AND test_result.test_info_no = :test_info_no ";
        $query .= " AND test_result.del_flg = '0' ";
		
	    $query .= " ORDER BY testquiz.disp_no ASC ";

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":org_no", $form->org_no, PDO::PARAM_STR);
        $stmt->bindParam(":student_no", $form->student_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_info_no", $form->test_info_no, PDO::PARAM_STR);
        
        return parent::getDataList($stmt, get_class(new T_Test_Info_ResultDto()));
    }
    
    public function getItemList($quiz_info_no) {
        $query = " SELECT ";
        $query .= " tquizitem.quiz_type quiz_type ";
        $query .= " ,tquizitem.description item_description ";
        $query .= " ,tquizitem.quiz_info_no quiz_info_no";
        $query .= " ,tquizitem.quiz_item_no quiz_item_no";
        $query .= " FROM T_QUIZ_ITEM tquizitem ";
        $query .= " WHERE tquizitem.quiz_info_no=:quiz_info_no ";
        $query .= " AND tquizitem.del_flg='0'";
   
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
        return parent::getDataList($stmt, get_class(new T_Quiz_ItemDto()));
        
    }
    public function getOptionList($quiz_item_no,$quiz_info_no){
        $query = " SELECT ";
        $query .= " options.option_no option_no ";
        $query .= " ,options.description option_description ";
        $query .= " ,options.correct_flag correct_flag";
		$query .= " ,options.quiz_item_no quiz_item_no";
        $query .= " ,options.quiz_info_no quiz_info_no";
        $query .= " FROM T_QUIZ_ITEM_OPTION options ";
        $query .= " WHERE options.quiz_item_no=:quiz_item_no ";
        $query .= " AND options.quiz_info_no=:quiz_info_no";
        $query .= " AND options.del_flg='0'";
        
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":quiz_item_no", $quiz_item_no, PDO::PARAM_STR);
        $stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
        return parent::getDataList($stmt, get_class(new T_Quiz_Item_OptionDto()));
    }
    public function getItemData($test_no,$org_no){
        $query = " SELECT ";
        $query .= " quiz.quiz_info_no quiz_info_no ";
        $query .= " ,test.test_info_no test_info_no ";
        $query .= " ,item.quiz_item_no quiz_item_no";
        $query .= " ,item.quiz_type quiz_type";
        $query .= " FROM T_TEST_INFO test ";
		$query .= " ,T_TEST_INFO_QUIZ test_quiz ";
        $query .= " ,T_QUIZ_INFO quiz ";
        $query .= " ,T_QUIZ_ITEM item ";
        $query .= " WHERE test.test_info_no=:test_no";
        $query .= " AND test.org_no=:org_no";
        $query .= " AND quiz.quiz_info_no=item.quiz_info_no";
		$query .= " AND quiz.del_flg='0'";
        $query .= " AND item.del_flg='0'";
        $query .= " AND test.del_flg='0'";
		$query .= " AND test_quiz.del_flg='0'";
		$query .= " AND test.org_no = test_quiz.org_no";
		$query .= " AND test.test_info_no = test_quiz.test_info_no";
		$query .= " AND test_quiz.quiz_info_no = quiz.quiz_info_no";
		
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":test_no", $test_no, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);        
        return parent::getDataList($stmt, get_class(new T_Quiz_Item_OptionDto()));
    }
    public function updateShowFlag($org_no,$test_no) {
        $query = " UPDATE ";
        $query .= " T_TEST_INFO ";
        $query .= " SET";
        $query .= " show_flg = 1 ";
        $query .= " WHERE ";
        $query .= " test_info_no = :test_no ";
        $query .= " AND org_no = :org_no ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":test_no", $test_no, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        return parent::update($stmt);
    }
	
	 /**
     * `ans_option_no更新処理
     *
     * @param
     *            $dto
     */
    public function updateAnsOptNo($org_no,$test_info_no,$student_no)
    {
        $query = " UPDATE ";
        $query .= " T_TEST_INFO_RESULT";
        $query .= " SET";
        $query .= " ans_option_no = 0 ";
        $query .= " WHERE ";
        $query .= " org_no = :org_no ";
        $query .= " AND student_no = :student_no ";
        $query .= " AND test_info_no = :test_info_no ";
        $query .= " AND del_flg = '0' ";
        
        $stmt = $this->pdo->prepare($query);
        
        $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
        $stmt->bindParam(":student_no", $student_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

        return parent::update($stmt);
    }

	/**
	 * Menu画面のため、未受講の試験リストを取得する
	 */
    public function getTestListForMenu($org , $student_no , $pdo)
    {
        $systemDate = DateUtil::getDate("Y/m/d H:i:s");
        
        $query = "SELECT ";
        $query .= " ttest.test_info_no";
        $query .= " ,ttest.show_flg";
        $query .= " ,ttest.test_info_name";
        $query .= " ,date_format(mlesson.start_period,'%Y/%m/%d') start_period";
		$query .= " ,date_format(mlesson.end_period,'%Y/%m/%d') end_period";
		$query .= " ,MAX(ttest_result.answer_dt) answer_dt";
		$query .= " ,SUM(ttest_result.ans_option_no) ans_option_no";
		$query .= " ,GROUP_CONCAT( DISTINCT mlesson.lesson_name)";
        $query .= " FROM T_STUDENT  tstu";
        $query .= " INNER JOIN T_GROUP_STUDENT tgrpstu";
        $query .= " 	ON tstu.org_no = tgrpstu.org_no";
        $query .= " 	AND tstu.student_no = tgrpstu.student_no";
        $query .= " 	AND tgrpstu.del_flg = '0'";
        $query .= " INNER JOIN M_LESSON_TARGET mlessontar";
        $query .= " ON tgrpstu.org_no = mlessontar.org_no";
        $query .= " 	AND tgrpstu.group_no = mlessontar.group_no";
        $query .= " 	AND mlessontar.del_flg = '0'";
        $query .= "     INNER JOIN M_LESSON mlesson  ";
        $query .= " 	ON mlessontar.org_no = mlesson.org_no";
        $query .= " 	AND mlessontar.lesson_no = mlesson.lesson_no";
        $query .= " 	AND mlesson.del_flg = '0'";
        $query .= " 	INNER JOIN T_LESSON_TEST_INFO tlessontest";
        $query .= " 	ON mlesson.org_no = tlessontest.org_no	";
        $query .= " AND mlesson.lesson_no = tlessontest.lesson_no";
        $query .= " AND tlessontest.del_flg = '0'";
        $query .= " INNER JOIN T_TEST_INFO ttest";
        $query .= " ON tlessontest.org_no = ttest.org_no";
        $query .= " AND tlessontest.test_info_no = ttest.test_info_no";
        $query .= " AND ttest.del_flg = '0'";
        $query .= " AND ttest.status = '1'";

		$query .= " LEFT JOIN T_TEST_INFO_RESULT ttest_result";
        $query .= " ON ttest.org_no = ttest_result.org_no";
        $query .= " AND ttest.test_info_no = ttest_result.test_info_no";
		$query .= " AND tstu.student_no = ttest_result.student_no";
        $query .= " AND ttest_result.del_flg = '0'";
		
        $query .= " WHERE tstu.org_no = :org_no";
        $query .= " AND tstu.student_no = :student_no";
		 
		$query .= " AND :current_time BETWEEN ttest.start_period AND ttest.end_period";
		$query .= " AND :system_date BETWEEN mlesson.start_period AND mlesson.end_period ";
        $query .= " GROUP BY ttest.org_no,ttest.test_info_no,ttest.test_info_name ,mlesson.start_period,mlesson.end_period,ttest.show_flg";
        $query .= " ORDER BY end_period ASC";

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(":org_no", $org, PDO::PARAM_STR);
        $stmt->bindParam(":student_no", $student_no, PDO::PARAM_STR);
        $stmt->bindParam(":current_time", $systemDate, PDO::PARAM_STR);
		$stmt->bindParam(":system_date", $systemDate, PDO::PARAM_STR);
        
        return parent::getDataList($stmt, get_class(new T_Test_InfoDto()));
    }
    
	
	//テスト回答履歴番号取得
	public function getMaxHistoryNumber($param) {

		$query = " SELECT ";
		$query .= " IFNULL(history_id,0) history_id ";
		$query .= " ,IFNULL(box_no,0) box_no ";
		$query .= " FROM ";
		$query .= " T_TEST_INFO_RESULT_HISTORY ";
		$query .= " WHERE org_no = :org_no ";
		$query .= " AND test_info_no = :test_info_no ";
		$query .= " AND student_no = :student_no ";
		$query .= " AND quiz_info_no = :quiz_info_no ";
		$query .= " AND quiz_item_no = :quiz_item_no ";
		$query .= " ORDER BY history_id DESC LIMIT 1 ";

		$stmt = $this->pdo->prepare ( $query );

		$stmt->bindParam ( ":org_no", $param->org_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":test_info_no", $param->test_info_no , PDO::PARAM_STR );
		$stmt->bindParam ( ":student_no", $param->student_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_info_no", $param->quiz_info_no, PDO::PARAM_STR );
		$stmt->bindParam ( ":quiz_item_no", $param->quiz_item_no, PDO::PARAM_STR );

		return parent::getData( $stmt, get_class(new T_Test_Info_Result_HistoryDto()) );
	}
	
    /**
     * 試験結果履歴データ更新
     *
     * @param
     *            $dto
     */
    public function updateTestInfoResultHistory($dto)
    {
        $query = " UPDATE ";
        $query .= " T_TEST_INFO_RESULT_HISTORY";
        $query .= " SET";
        $query .= " answer_dt = :answer_dt ";
        $query .= " ,update_dt = :update_dt ";
        $query .= " ,updater_id = :updater_id ";
        $query .= " ,correct_flag = :correct_flag ";
        $query .= " ,ans_option_no = :option_no ";
		$query .= " ,answer_text = :ansewer_text ";
		$query .= " ,box_no = :box_no ";
        $query .= " WHERE ";
        $query .= " org_no = :org_no ";
        $query .= " AND student_no = :student_no ";
        $query .= " AND test_info_no = :test_no ";
        $query .= " AND quiz_info_no = :quiz_no ";
        $query .= " AND quiz_item_no = :item_no ";
        $query .= " AND history_id = :history_id ";
        $query .= " AND del_flg = '0' ";
        
        $stmt = $this->pdo->prepare($query);

        $stmt->bindParam(":answer_dt", $dto->answer_dt, PDO::PARAM_STR);
        $stmt->bindParam(":correct_flag", $dto->correct_flag, PDO::PARAM_STR);
		$stmt->bindParam(":ansewer_text", $dto->answer_text, PDO::PARAM_STR);
        $stmt->bindParam(":update_dt", $dto->update_dt, PDO::PARAM_STR);
        $stmt->bindParam(":updater_id", $dto->updater_id, PDO::PARAM_STR);
        $stmt->bindParam(":org_no", $dto->org_no, PDO::PARAM_STR);
        $stmt->bindParam(":student_no", $dto->student_no, PDO::PARAM_STR);
        $stmt->bindParam(":test_no", $dto->test_info_no, PDO::PARAM_STR);
        $stmt->bindParam(":quiz_no", $dto->quiz_info_no, PDO::PARAM_STR);
        $stmt->bindParam(":option_no", $dto->ans_option_no, PDO::PARAM_STR);
        $stmt->bindParam(":item_no", $dto->quiz_item_no, PDO::PARAM_STR);
        $stmt->bindParam(":box_no", $dto->box_no, PDO::PARAM_STR);
        $stmt->bindParam(":history_id", $dto->history_id, PDO::PARAM_STR);
        
        return parent::update($stmt);
    }
	
	/*
	*反復ドリルクイズリスト取得
	*
	*/
	public function getQuizListForDrill($org_no, $student_no){
		
		$query = " SELECT  ";
		$query .= " t_history.org_no ";
		$query .= " , t_history.student_no ";
		$query .= " , t_history.quiz_info_no ";
		$query .= " , t_history.quiz_item_no ";
		$query .= " , t_history.test_info_no ";
		$query .= " , t_test.test_info_name ";
		$query .= " , t_history.box_no ";
		$query .= " , t_history.history_id ";
		
		$query .= " , t_quiz.audio_name audio_name ";
		$query .= " , t_quiz.quiz_name quiz_name ";
		$query .= " , t_quiz.long_description quiz_description ";

		$query .= " FROM T_TEST_INFO_RESULT_HISTORY t_history ";

		$query .= " JOIN T_QUIZ_INFO t_quiz ";
		$query .= " ON t_history.org_no = t_quiz.org_no ";
		$query .= " AND t_history.quiz_info_no = t_quiz.quiz_info_no ";
		$query .= " AND t_quiz.del_flg = '0' ";
		
		$query .= " JOIN T_TEST_INFO t_test ";
		$query .= " ON t_history.org_no = t_test.org_no ";
		$query .= " AND t_history.test_info_no = t_test.test_info_no ";
		$query .= " AND t_test.drill_flg = '1' ";
		$query .= " AND t_test.del_flg = '0' ";

		$query .= " JOIN T_QUIZ_ITEM t_item ";
		$query .= " ON t_history.quiz_info_no = t_item.quiz_info_no ";
		$query .= " AND t_history.quiz_item_no = t_item.quiz_item_no ";
		$query .= " AND t_item.del_flg = '0' ";

		$query .= " WHERE (t_history.org_no  ";
		$query .= " 	, t_history.student_no ";
		$query .= " 	, t_history.quiz_info_no ";
		$query .= " 	, t_history.quiz_item_no ";
		$query .= " 	, t_history.history_id) IN ( ";
		$query .= " 	SELECT org_no  ";
		$query .= " 	, student_no ";
		$query .= " 	, quiz_info_no ";
		$query .= " 	, quiz_item_no ";
		$query .= " 	, MAX(history_id) as history_id ";
		$query .= " 	FROM T_TEST_INFO_RESULT_HISTORY ";
		$query .= " 	WHERE org_no = :org_no1  ";
		$query .= " 	AND student_no = :student_no1 ";
		$query .= " 	GROUP BY org_no , student_no ";
		$query .= " 	,quiz_info_no,quiz_item_no ";

		$query .= " ) ";
		$query .= " AND t_history.org_no = :org_no2  ";
		$query .= " AND t_history.student_no = :student_no2 ";

		$query .= " ORDER BY t_history.box_no , t_history.answer_dt ";
		$query .= " LIMIT " . DRILL_QUIZ_COUNT;
		
		$stmt = $this->pdo->prepare($query);
		
		LogHelper::logDebug($query);

		$stmt->bindParam(":org_no1", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":student_no1", $student_no, PDO::PARAM_STR);
		$stmt->bindParam(":org_no2", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":student_no2", $student_no, PDO::PARAM_STR);
		
		return parent::getDataList( $stmt, get_class(new T_Test_Info_Result_HistoryDto()));
	}
    
	/*
	*反復ドリルクイズリスト取得
	*
	*/
	public function getQuizListForDrillChart2($org_no, $student_no){
		
		$query = " SELECT  ";
		$query .= " t_history.org_no ";
		$query .= " , t_history.student_no ";
		$query .= " , SUM(t_history.correct_flag) correct_flag , count(*) total_cnt ";
		
		$query .= " FROM T_TEST_INFO_RESULT_HISTORY t_history ";

		$query .= " JOIN T_QUIZ_INFO t_quiz ";
		$query .= " ON t_history.org_no = t_quiz.org_no ";
		$query .= " AND t_history.quiz_info_no = t_quiz.quiz_info_no ";
		$query .= " AND t_quiz.del_flg = '0' ";
		
		$query .= " JOIN T_TEST_INFO t_test ";
		$query .= " ON t_history.org_no = t_test.org_no ";
		$query .= " AND t_history.test_info_no = t_test.test_info_no ";
		$query .= " AND t_test.drill_flg = '1' ";
		$query .= " AND t_test.del_flg = '0' ";

		$query .= " JOIN T_QUIZ_ITEM t_item ";
		$query .= " ON t_history.quiz_info_no = t_item.quiz_info_no ";
		$query .= " AND t_history.quiz_item_no = t_item.quiz_item_no ";
		$query .= " AND t_item.del_flg = '0' ";

		$query .= " WHERE (t_history.org_no  ";
		$query .= " 	, t_history.student_no ";
		$query .= " 	, t_history.quiz_info_no ";
		$query .= " 	, t_history.quiz_item_no ";
		$query .= " 	, t_history.history_id) IN ( ";
		$query .= " 	SELECT org_no  ";
		$query .= " 	, student_no ";
		$query .= " 	, quiz_info_no ";
		$query .= " 	, quiz_item_no ";
		$query .= " 	, MAX(history_id) as history_id ";
		$query .= " 	FROM T_TEST_INFO_RESULT_HISTORY ";
		$query .= " 	WHERE org_no = :org_no1  ";
		$query .= " 	AND student_no = :student_no1 ";
		$query .= " 	GROUP BY org_no , student_no ";
		$query .= " 	,quiz_info_no,quiz_item_no ";

		$query .= " ) ";
		$query .= " AND t_history.org_no = :org_no2  ";
		$query .= " AND t_history.student_no = :student_no2 ";

		$query .= " GROUP BY org_no , student_no ORDER BY org_no , student_no ";
		
		$stmt = $this->pdo->prepare($query);
		
		LogHelper::logDebug($query);

		$stmt->bindParam(":org_no1", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":student_no1", $student_no, PDO::PARAM_STR);
		$stmt->bindParam(":org_no2", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":student_no2", $student_no, PDO::PARAM_STR);
		
		return parent::getDataList( $stmt, get_class(new T_Test_Info_Result_HistoryDto()));
	}
	
	/*
	*反復ドリルクイズリスト取得
	*
	*/
	public function getQuizListForDrillChart3($org_no, $student_no){
		
		$query = " SELECT  ";
		$query .= " t_history.org_no  , t_history.student_no ";
		$query .= " ,DATE_FORMAT(t_history.answer_dt, '%Y%m%d') answer_dt ";
		$query .= " , sum(t_history.correct_flag) correct_flag ";
		$query .= " FROM T_TEST_INFO_RESULT_HISTORY t_history   ";
		$query .= " JOIN T_QUIZ_INFO t_quiz   ";
		$query .= " ON t_history.org_no = t_quiz.org_no   ";
		$query .= " AND t_history.quiz_info_no = t_quiz.quiz_info_no   ";
		$query .= " AND t_quiz.del_flg = '0'  ";
		$query .= " JOIN T_TEST_INFO t_test   ";
		$query .= " ON t_history.org_no = t_test.org_no   ";
		$query .= " AND t_history.test_info_no = t_test.test_info_no  ";
		$query .= " AND t_test.drill_flg = '1' ";
		$query .= " AND t_test.del_flg = '0'   ";
		$query .= " JOIN T_QUIZ_ITEM t_item   ";
		$query .= " ON t_history.quiz_info_no = t_item.quiz_info_no   ";
		$query .= " AND t_history.quiz_item_no = t_item.quiz_item_no   ";
		$query .= " AND t_item.del_flg = '0'   ";
		$query .= " WHERE t_history.org_no = :org_no    ";
		$query .= " AND t_history.student_no = :student_no ";
		$query .= " GROUP BY org_no , student_no,DATE_FORMAT(t_history.answer_dt, '%Y%m%d') DESC";
		$query .= " LIMIT 7  ";
		
		$stmt = $this->pdo->prepare($query);
		
		LogHelper::logDebug($query);

		$stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
		$stmt->bindParam(":student_no", $student_no, PDO::PARAM_STR);
		
		return parent::getDataList( $stmt, get_class(new T_Test_Info_Result_HistoryDto()));
	}
	
}

?>