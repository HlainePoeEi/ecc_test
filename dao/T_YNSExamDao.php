<?php
require_once 'BaseDao.php';
require_once 'dto/T_YNSExamDto.php';
require_once 'dto/T_Test_Info_QuizDto.php';
require_once 'dto/T_Quiz_ItemDto.php';
require_once 'dto/T_Quiz_Item_OptionDto.php';
/**
 * T_TestInfoDAOクラス
 */
class T_YNSExamDao extends BaseDao
{
    // public function getTestInfoResultCount($param)
    // {
    //     $query = " SELECT ";
    //     $query .= " distinct test_info.test_info_no test_info_no ";
    //     $query .= " ,test_info.test_info_name test_info_name ";
    //     $query .= " ,test_info.remarks remarks ";
    //     $query .= " ,test_info.status status ";
    //     $query .= " ,date_format(test_info.start_period,'%Y/%m/%d') as start_period ";
    //     $query .= " ,date_format(test_info.end_period,'%Y/%m/%d') as end_period ";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO test_info ";
    //     $query .= " LEFT JOIN T_TEST_INFO_QUIZ as test_info_quiz ";
    //     $query .= " ON test_info.org_no = test_info_quiz.org_no ";
    //     $query .= " AND test_info.test_info_no = test_info_quiz.test_info_no ";
    //     $query .= " WHERE test_info.start_period <= :end_period ";
    //     $query .= " AND test_info.end_period >= :start_period ";
    //     $query .= " AND test_info.org_no = :org_no ";

    //     if (!StringUtil::isEmpty($param->test_info_name)) {
    //         $query .= " AND (test_info.test_info_name LIKE :test_info_name) ";
    //     }

    //     if (!StringUtil::isEmpty($param->remarks)) {
    //         $query .= " AND (test_info.remarks LIKE :remarks ) ";
    //     }

    //     if (!StringUtil::isEmpty($param->status)) {
    //         $query .= " AND test_info.status IN (" . $param->status . ") ";
    //     }

    //     if (!StringUtil::isEmpty($param->updater_id)) {
    //         $query .= " AND (test_info.updater_id=:updater_id ) ";
    //     }

    //     $query .= " AND test_info.del_flg = '0' ";
    //     $query .= " ORDER BY ";
    //     $query .= " test_info_name ASC";
    //     $query .= " ,remarks ASC";

    //     $stmt = $this->pdo->prepare($query);

    //     $stmt->bindParam(":start_period", $param->start_period, PDO::PARAM_STR);
    //     $stmt->bindParam(":end_period", $param->end_period, PDO::PARAM_STR);
    //     $stmt->bindParam(":org_no", $param->org_no, PDO::PARAM_STR);

    //     if (!StringUtil::isEmpty($param->test_info_name)) {

    //         $name = '%' . $param->test_info_name . '%';
    //         $stmt->bindParam(":test_info_name", $name, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($param->remarks)) {

    //         $remarks = '%' . $param->remarks . '%';
    //         $stmt->bindParam(":remarks", $remarks, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($param->updater_id)) {
    //         $stmt->bindParam(":updater_id", $param->updater_id, PDO::PARAM_STR);
    //     }

    //     $list = parent::getDataList($stmt, get_class(new T_Test_InfoDto()));
    //     return count($list);
    // }
    public function getTestInfoListData($param, $flg)
    {
        $offset = ($param->page - 1) * PAGE_ROW;

        $query = " SELECT ";
        $query .= " * ";
        $query .= " FROM ";
        $query .= " t_ynsexam ";
        $query .= " ORDER BY ";
        $query .= " name ASC";
        $query .= " ,remarks ASC";
        $stmt = $this->pdo->prepare($query);

        return parent::getDataList($stmt, get_class(new T_YNSExamDto));
    }

    /*
	 * 登録画面の初期表示をデータベースから取得する
	 */
    // public function getTestInfo($org_no, $test_info_no)
    // {
    //     $query = " SELECT ";
    //     $query .= " test_info.test_info_no test_info_no";
    //     $query .= " ,test_info.org_no org_no";
    //     $query .= " ,test_info.test_info_name test_info_name";
    //     $query .= " ,test_info.long_description long_description";
    //     $query .= " ,test_info.test_time test_time";
    //     $query .= " ,test_info.show_flg show_flg";
    //     $query .= " ,test_info.drill_flg drill_flg";
    //     $query .= " ,test_info.status status";
    //     $query .= " ,date_format(test_info.start_period," . "'%Y/%m/%d') as start_period";
    //     $query .= " ,date_format(test_info.end_period," . "'%Y/%m/%d') as end_period";
    //     $query .= " ,test_info.remarks remarks";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO test_info";
    //     $query .= " WHERE test_info.test_info_no = :test_info_no ";
    //     $query .= " AND test_info.org_no = :org_no ";
    //     $query .= " AND test_info.del_flg = '0' ";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);
    //     LogHelper::logDebug($stmt);
    //     return parent::getDataList($stmt, get_class(new T_Test_InfoDto()));
    // }

    /**
     * シアイテム情報更新処理
     *
     * @param
     *        	$dto
     */
    // public function updateTestInfo($dto, $pdo)
    // {
    //     $query = " UPDATE";
    //     $query .= " T_TEST_INFO";
    //     $query .= " SET";

    //     if (!StringUtil::isEmpty($dto->test_info_name)) {
    //         $query .= " test_info_name  = :test_info_name ";
    //     }

    //     if (!StringUtil::isEmpty($dto->long_description)) {
    //         $query .= " ,long_description  = :long_description ";
    //     }

    //     if (!StringUtil::isEmpty($dto->start_period)) {
    //         $query .= " ,start_period  = :start_period ";
    //     }

    //     if (!StringUtil::isEmpty($dto->end_period)) {
    //         $query .= " ,end_period  = :end_period ";
    //     }

    //     if (!StringUtil::isEmpty($dto->status)) {
    //         $query .= " ,status  = :status ";
    //     }

    //     if (!StringUtil::isEmpty($dto->test_time)) {
    //         $query .= " ,test_time  = :test_time ";
    //     }

    //     if (!StringUtil::isEmpty($dto->show_flg)) {
    //         $query .= " ,show_flg  = :show_flg ";
    //     }

    //     if (!StringUtil::isEmpty($dto->drill_flg)) {
    //         $query .= " ,drill_flg  = :drill_flg ";
    //     }
    //     $query .= " ,remarks  = :remarks ";
    //     $query .= " ,update_dt   = :update_dt ";
    //     $query .= " ,updater_id  = :updater_id ";

    //     $query .= " WHERE ";
    //     $query .= " org_no = :org_no ";
    //     $query .= " AND test_info_no = :test_info_no ";
    //     $query .= " AND del_flg = '0' ";

    //     $stmt = $pdo->prepare($query);

    //     if (!StringUtil::isEmpty($dto->test_info_name)) {
    //         $stmt->bindParam(":test_info_name", $dto->test_info_name, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($dto->long_description)) {
    //         $stmt->bindParam(":long_description", $dto->long_description, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($dto->status)) {
    //         $stmt->bindParam(":status", $dto->status, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($dto->test_time)) {
    //         $stmt->bindParam(":test_time", $dto->test_time, PDO::PARAM_INT);
    //     }

    //     if (!StringUtil::isEmpty($dto->show_flg)) {
    //         $stmt->bindParam(":show_flg", $dto->show_flg, PDO::PARAM_INT);
    //     }

    //     if (!StringUtil::isEmpty($dto->drill_flg)) {
    //         $stmt->bindParam(":drill_flg", $dto->drill_flg, PDO::PARAM_INT);
    //     }
    //     if (!StringUtil::isEmpty($dto->start_period)) {
    //         $stmt->bindParam(":start_period", $dto->start_period, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($dto->end_period)) {
    //         $stmt->bindParam(":end_period", $dto->end_period, PDO::PARAM_STR);
    //     }

    //     $stmt->bindParam(":remarks", $dto->remarks, PDO::PARAM_STR);
    //     $stmt->bindParam(":update_dt", $dto->update_dt, PDO::PARAM_STR);
    //     $stmt->bindParam(":updater_id", $dto->updater_id, PDO::PARAM_STR);

    //     $stmt->bindParam(":org_no", $dto->org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $dto->test_info_no, PDO::PARAM_STR);
    //     return parent::update($stmt);
    // }

    // /**
    //  * シアイテム情報更新処理
    //  *
    //  * @param
    //  *        	$dto
    //  */
    // public function getNextId()
    // {
    //     return parent::getId("test_info_no");
    // }

    // /**
    //  * 入出庫ヘッダー情報新規登録
    //  *
    //  * @param unknown $dto
    //  */
    // public function insertData($dto, $pdo)
    // {
    //     return parent::insertWithPdo($dto, $pdo);
    // }

    // /*
	//  * 登録画面の初期表示をデータベースから取得する
	//  */
    // public function getListQuiz($org_no, $test_info_no)
    // {

    //     $query = " SELECT ";
    //     $query .= " testinfoquiz.quiz_info_no as quiz_info_no";
    //     $query .= " ,testinfoquiz.disp_no as disp_no";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO_QUIZ testinfoquiz";
    //     $query .= " INNER JOIN T_TEST_INFO testinfo";
    //     $query .= " ON testinfoquiz.test_info_no = testinfo.test_info_no ";
    //     $query .= " WHERE testinfo.test_info_no = :test_info_no ";
    //     $query .= " AND testinfo.org_no = :org_no ";
    //     $query .= " AND testinfo.del_flg = '0' ";

    //     $stmt = $this->pdo->prepare($query);

    //     $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

    //     return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    // }

    // // テスト情報プレビュー、クイズリストを取得
    // public function getQuizList($org_no, $test_info_no)
    // {
    //     $query = " SELECT DISTINCT ";
    //     $query .= " testinfo.test_info_name test_info_name ";
    //     $query .= " ,testinfo.org_no org_no";
    //     $query .= " ,testinfo.test_info_no test_info_no ";
    //     $query .= " ,testinfo.long_description test_description ";
    //     $query .= " ,testinfo.test_time test_time ";
    //     $query .= " ,tquizinfo.long_description quiz_description ";
    //     $query .= " ,tquizinfo.quiz_info_no quiz_info_no ";
    //     $query .= " ,tquizinfo.quiz_name quiz_name ";
    //     $query .= " ,tquizinfo.audio_name audio_name ";
    //     $query .= " ,tquizitem.quiz_item_no quiz_item_no ";
    //     $query .= " ,tquizitemoption.option_no option_no ";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO testinfo  ";
    //     $query .= " LEFT JOIN T_TEST_INFO_QUIZ testinfoquiz ";
    //     $query .= " ON testinfo.test_info_no = testinfoquiz.test_info_no ";
    //     $query .= " AND testinfo.org_no = testinfoquiz.org_no ";
    //     $query .= " AND testinfoquiz.del_flg = '0' ";
    //     $query .= " LEFT JOIN T_QUIZ_INFO tquizinfo ";
    //     $query .= " ON testinfoquiz.quiz_info_no = tquizinfo.quiz_info_no ";
    //     $query .= " LEFT JOIN T_QUIZ_ITEM tquizitem ";
    //     $query .= " ON tquizinfo.quiz_info_no = tquizitem.quiz_info_no ";
    //     $query .= " AND tquizitem.del_flg = '0' ";
    //     $query .= " LEFT JOIN T_QUIZ_ITEM_OPTION tquizitemoption ";
    //     $query .= " ON tquizitem.quiz_info_no = tquizitemoption.quiz_info_no ";
    //     $query .= " AND tquizitemoption.del_flg = '0' ";
    //     $query .= " AND tquizitem.quiz_item_no = tquizitemoption.quiz_item_no ";
    //     $query .= " AND testinfoquiz.org_no = tquizinfo.org_no ";
    //     $query .= " AND tquizinfo.del_flg = '0' ";
    //     $query .= " WHERE testinfo.test_info_no = :test_info_no ";
    //     $query .= " AND testinfo.org_no = :org_no ";
    //     $query .= " AND testinfo.del_flg = '0' ";
    //     $query .= " ORDER BY ";
    //     $query .= " tquizinfo.quiz_info_no ASC";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

    //     return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    // }

    // // テスト情報プレビュー、アイテムリストを取得
    // public function getQuizItemList($org_no, $test_info_no)
    // {
    //     $query = " SELECT DISTINCT ";
    //     $query .= " testinfo.test_info_no test_info_no ";
    //     $query .= " ,testinfo.test_time test_time ";
    //     $query .= " ,tquizinfo.quiz_info_no quiz_info_no ";
    //     $query .= " ,tquizitem.quiz_item_no quiz_item_no ";
    //     $query .= " ,tquizitem.description item_description ";
    //     $query .= " ,tquizitemoption.option_no option_no ";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO_QUIZ testinfoquiz ";
    //     $query .= " INNER JOIN T_TEST_INFO testinfo ";
    //     $query .= " ON testinfoquiz.test_info_no = testinfo.test_info_no ";
    //     $query .= " AND testinfo.org_no = testinfoquiz.org_no ";
    //     $query .= " AND testinfoquiz.del_flg = '0' ";
    //     $query .= " INNER JOIN T_QUIZ_INFO tquizinfo ";
    //     $query .= " ON testinfoquiz.quiz_info_no = tquizinfo.quiz_info_no ";
    //     $query .= " INNER JOIN T_QUIZ_ITEM tquizitem ";
    //     $query .= " ON tquizinfo.quiz_info_no = tquizitem.quiz_info_no ";
    //     $query .= " AND tquizitem.del_flg = '0' ";
    //     $query .= " INNER JOIN T_QUIZ_ITEM_OPTION tquizitemoption ";
    //     $query .= " ON tquizitem.quiz_info_no = tquizitemoption.quiz_info_no ";
    //     $query .= " AND tquizitemoption.del_flg = '0' ";
    //     $query .= " AND tquizitem.quiz_item_no = tquizitemoption.quiz_item_no ";
    //     $query .= " AND testinfoquiz.org_no = tquizinfo.org_no ";
    //     $query .= " AND tquizinfo.del_flg = '0' ";
    //     $query .= " WHERE testinfo.test_info_no = :test_info_no ";
    //     $query .= " AND testinfo.org_no = :org_no ";
    //     $query .= " AND testinfo.del_flg = '0' ";
    //     $query .= " ORDER BY ";
    //     $query .= " tquizinfo.quiz_info_no ASC";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

    //     return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    // }

    // // テスト情報プレビュー、オプションリストを取得
    // public function getQuizItemOptionList($org_no, $test_info_no)
    // {
    //     $query = " SELECT DISTINCT ";
    //     $query .= " testinfo.test_info_no test_info_no ";
    //     $query .= " ,tquizinfo.quiz_info_no quiz_info_no ";
    //     $query .= " ,tquizitem.quiz_item_no quiz_item_no ";
    //     $query .= " ,tquizitem.quiz_type quiz_type ";
    //     $query .= " ,tquizitem.description item_description ";
    //     $query .= " ,tquizitemoption.option_no option_no ";
    //     $query .= " ,tquizitemoption.description option_description ";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO_QUIZ testinfoquiz ";
    //     $query .= " INNER JOIN T_TEST_INFO testinfo ";
    //     $query .= " ON testinfoquiz.test_info_no = testinfo.test_info_no ";
    //     $query .= " AND testinfo.org_no = testinfoquiz.org_no ";
    //     $query .= " AND testinfoquiz.del_flg = '0' ";
    //     $query .= " INNER JOIN T_QUIZ_INFO tquizinfo ";
    //     $query .= " ON testinfoquiz.quiz_info_no = tquizinfo.quiz_info_no ";
    //     $query .= " INNER JOIN T_QUIZ_ITEM tquizitem ";
    //     $query .= " ON tquizinfo.quiz_info_no = tquizitem.quiz_info_no ";
    //     $query .= " AND tquizitem.del_flg = '0' ";
    //     $query .= " INNER JOIN T_QUIZ_ITEM_OPTION tquizitemoption ";
    //     $query .= " ON tquizitem.quiz_info_no = tquizitemoption.quiz_info_no ";
    //     $query .= " AND tquizitemoption.del_flg = '0' ";
    //     $query .= " AND tquizitem.quiz_item_no = tquizitemoption.quiz_item_no ";
    //     $query .= " AND testinfoquiz.org_no = tquizinfo.org_no ";
    //     $query .= " AND tquizinfo.del_flg = '0' ";
    //     $query .= " WHERE testinfo.test_info_no = :test_info_no ";
    //     $query .= " AND testinfo.org_no = :org_no ";
    //     $query .= " AND testinfo.del_flg = '0' ";
    //     $query .= " ORDER BY ";
    //     $query .= " tquizinfo.quiz_info_no ASC";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

    //     return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    // }

    // /*
	// *
	// * 試験結果詳細データを取得する
	// *
	// */
    // public function getQuizResultDetailListData($form, $pdo)
    // {

    //     $query = " SELECT lesson.lesson_no lesson_no ";
    //     $query .= " ,lesson.lesson_name lesson_name  ";
    //     $query .= " ,grp.group_no group_no  ";
    //     $query .= " ,grp.group_name group_name  ";
    //     $query .= " ,ttest.test_info_no test_info_no  ";
    //     $query .= " ,ttest.test_info_name test_info_name  ";
    //     $query .= " ,student.login_id login_id  ";
    //     $query .= " ,student.student_no student_no  ";
    //     $query .= " ,student.student_name student_name  ";
    //     $query .= " ,IF(SUM(testResult.ans_option_no) IS NULL,'未受講', '受講済み') ans_kbn ";
    //     $query .= " ,MAX(date_format(testResult.update_dt,'%Y/%m/%d')) answer_dt ";
    //     $query .= " ,GROUP_CONCAT(testResult.correct_flag order by test_quiz.disp_no,testResult.quiz_info_no,testResult.quiz_item_no SEPARATOR ',' ) answer_detail ";
    //     $query .= " ,SUM(testResult.correct_flag*quizItem.marks) totalM ";
    //     $query .= " FROM  M_LESSON lesson  ";
    //     $query .= " INNER JOIN T_LESSON_TEST_INFO as lessontest  ";
    //     $query .= " ON lesson.org_no = lessontest.org_no  ";
    //     $query .= " AND lesson.lesson_no = lessontest.lesson_no  ";
    //     $query .= " AND lessontest.del_flg = '0'  ";
    //     $query .= " LEFT JOIN M_LESSON_TARGET as  mlessontarget  ";
    //     $query .= " ON lesson.org_no = mlessontarget.org_no  ";
    //     $query .= " AND lesson.lesson_no = mlessontarget.lesson_no  ";
    //     $query .= " AND mlessontarget.del_flg = '0'  ";
    //     $query .= " LEFT JOIN T_GROUP as grp  ";
    //     $query .= " ON mlessontarget.org_no = grp.org_no  ";
    //     $query .= " AND mlessontarget.group_no = grp.group_no  ";
    //     $query .= " AND grp.del_flg = '0'  ";
    //     $query .= " LEFT JOIN T_GROUP_STUDENT groupstu  ";
    //     $query .= " ON grp.org_no = groupstu.org_no  ";
    //     $query .= " AND grp.group_no = groupstu.group_no  ";
    //     $query .= " AND groupstu.del_flg = '0'  ";
    //     $query .= " LEFT JOIN T_STUDENT student  ";
    //     $query .= " ON groupstu.org_no=student.org_no  ";
    //     $query .= " AND groupstu.student_no=student.student_no  ";
    //     $query .= " AND student.del_flg = '0'  ";
    //     $query .= " LEFT JOIN T_TEST_INFO as ttest  ";
    //     $query .= " ON lessontest.org_no = ttest.org_no ";
    //     $query .= " AND lessontest.test_info_no = ttest.test_info_no  ";
    //     $query .= " AND ttest.del_flg = '0'  ";
    //     $query .= " LEFT JOIN T_TEST_INFO_QUIZ as test_quiz   ";
    //     $query .= " ON ttest.org_no = test_quiz.org_no  ";
    //     $query .= " AND ttest.test_info_no = test_quiz.test_info_no  ";
    //     $query .= " AND test_quiz.del_flg = '0' ";
    //     $query .= " INNER JOIN T_QUIZ_INFO as quiz   ";
    //     $query .= " ON test_quiz.org_no = quiz.org_no  ";
    //     $query .= " AND test_quiz.quiz_info_no = quiz.quiz_info_no  ";
    //     $query .= " AND quiz.del_flg = '0'  ";
    //     $query .= " INNER JOIN T_QUIZ_ITEM as quizItem  ";
    //     $query .= " ON quiz.quiz_info_no = quizItem.quiz_info_no  ";
    //     $query .= " AND quizItem.del_flg = '0'  ";
    //     $query .= " LEFT JOIN T_TEST_INFO_RESULT testResult  ";
    //     $query .= " ON  test_quiz.org_no  = testResult.org_no  ";
    //     $query .= " AND test_quiz.test_info_no = testResult.test_info_no  ";
    //     $query .= " AND  test_quiz.quiz_info_no  = testResult.quiz_info_no  ";
    //     $query .= " AND groupstu.student_no = testResult.student_no  ";
    //     $query .= " AND quizItem.quiz_item_no =  testResult.quiz_item_no ";
    //     $query .= " AND testResult.del_flg = '0'  ";
    //     $query .= " WHERE lesson.org_no = :org_no ";

    //     if (isset($form->test_info_no) && $form->test_info_no != "") {
    //         $query .= " AND ttest.test_info_no = :test_info_no ";
    //     }
    //     if (isset($form->test_info_name) && $form->test_info_name != "") {
    //         $query .= " AND ttest.test_info_name = :test_info_name ";
    //     }
    //     if (isset($form->lesson_no) && $form->lesson_no != "") {
    //         $query .= " AND lesson.lesson_no = :lesson_no ";
    //     }
    //     if (isset($form->lesson_name) && $form->lesson_name != "") {
    //         $query .= " AND lesson.lesson_name = :lesson_name ";
    //     }
    //     if (isset($form->group_no) && $form->group_no != "") {
    //         $query .= " AND grp.group_no = :group_no ";
    //     }

    //     if (!StringUtil::isEmpty($form->end_period)) {
    //         $query .= " AND ttest.start_period <= :end_period ";
    //         $query .= " AND lesson.start_period <= :end_period1 ";
    //         $query .= " AND grp.start_period <= :end_period2 ";
    //     }

    //     if (!StringUtil::isEmpty($form->start_period)) {
    //         $query .= " AND ttest.end_period >= :start_period ";
    //         $query .= " AND lesson.end_period >= :start_period1 ";
    //         $query .= " AND grp.end_period >= :start_period2 ";
    //     }

    //     $query .= " GROUP BY ttest.test_info_no,ttest.test_info_name,lesson.lesson_no,lesson.lesson_name  ";
    //     $query .= " ,grp.group_no,grp.group_name,student.student_no ,student.login_id,student.no  ";
    //     $query .= " ,student.student_name  ";
    //     $query .= " ORDER BY ttest.test_info_no,lesson.lesson_no,grp.group_no,student.student_no";

    //     $stmt = $pdo->prepare($query);
    //     LogHelper::logDebug("query :" . $query);
    //     $stmt->bindParam(":org_no", $form->org_no, PDO::PARAM_STR);

    //     if (isset($form->test_info_no) && $form->test_info_no != "") {
    //         $stmt->bindParam(":test_info_no", $form->test_info_no, PDO::PARAM_STR);
    //     }
    //     if (isset($form->test_info_name) && $form->test_info_name != "") {
    //         $stmt->bindParam(":test_info_name", $form->test_info_name, PDO::PARAM_STR);
    //     }
    //     if (isset($form->lesson_no) && $form->lesson_no != "") {
    //         $stmt->bindParam(":lesson_no", $form->lesson_no, PDO::PARAM_STR);
    //     }
    //     if (isset($form->lesson_name) && $form->lesson_name != "") {
    //         $stmt->bindParam(":lesson_name", $form->lesson_name, PDO::PARAM_STR);
    //     }
    //     if (isset($form->group_no) && $form->group_no != "") {
    //         $stmt->bindParam(":group_no", $form->group_no, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($form->start_period)) {
    //         $stmt->bindParam(":start_period", $form->start_period, PDO::PARAM_STR);
    //         $stmt->bindParam(":start_period1", $form->start_period, PDO::PARAM_STR);
    //         $stmt->bindParam(":start_period2", $form->start_period, PDO::PARAM_STR);
    //     }

    //     if (!StringUtil::isEmpty($form->end_period)) {
    //         $stmt->bindParam(":end_period", $form->end_period, PDO::PARAM_STR);
    //         $stmt->bindParam(":end_period1", $form->end_period, PDO::PARAM_STR);
    //         $stmt->bindParam(":end_period2", $form->end_period, PDO::PARAM_STR);
    //     }

    //     return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    // }

    // public function getItemList($quiz_info_no)
    // {
    //     $query = " SELECT ";
    //     $query .= " tquizitem.quiz_type quiz_type ";
    //     $query .= " ,tquizitem.description item_description ";
    //     $query .= " ,tquizitem.quiz_info_no quiz_info_no";
    //     $query .= " ,tquizitem.quiz_item_no quiz_item_no";
    //     $query .= " FROM T_QUIZ_ITEM tquizitem ";
    //     $query .= " WHERE tquizitem.quiz_info_no=:quiz_info_no ";
    //     $query .= " AND tquizitem.del_flg='0'";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
    //     return parent::getDataList($stmt, get_class(new T_Quiz_ItemDto()));
    // }

    // public function getOptionList($quiz_item_no, $quiz_info_no)
    // {
    //     $query = " SELECT ";
    //     $query .= " options.option_no option_no ";
    //     $query .= " ,options.description option_description ";
    //     $query .= " ,options.correct_flag correct_flag";
    //     $query .= " ,options.quiz_item_no quiz_item_no";
    //     $query .= " FROM T_QUIZ_ITEM_OPTION options ";
    //     $query .= " WHERE options.quiz_item_no=:quiz_item_no ";
    //     $query .= " AND options.quiz_info_no=:quiz_info_no";
    //     $query .= " AND options.del_flg='0'";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":quiz_item_no", $quiz_item_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":quiz_info_no", $quiz_info_no, PDO::PARAM_STR);
    //     return parent::getDataList($stmt, get_class(new T_Quiz_Item_OptionDto()));
    // }
    // // テストクイズ
    // public function getListQuizForPreview($org_no, $test_info_no)
    // {
    //     $query = " SELECT ";
    //     $query .= " test.test_info_name test_info_name ";
    //     $query .= " ,test.test_time test_time ";
    //     $query .= " ,test.test_info_no test_info_no ";
    //     $query .= " ,quiz.quiz_info_no quiz_info_no ";
    //     $query .= " ,quiz.audio_name audio_name ";
    //     $query .= " ,quiz.quiz_name quiz_name ";
    //     $query .= " ,quiz.long_description quiz_description ";
    //     $query .= " ,test.org_no org_no ";
    //     $query .= " ,test.long_description long_description ";
    //     $query .= " FROM ";
    //     $query .= " T_TEST_INFO_QUIZ testquiz";
    //     $query .= " INNER JOIN T_TEST_INFO test";
    //     $query .= " ON testquiz.test_info_no = test.test_info_no ";
    //     $query .= " AND test.org_no = testquiz.org_no ";
    //     $query .= " AND testquiz.del_flg = '0' ";
    //     $query .= " INNER JOIN T_QUIZ_INFO quiz";
    //     $query .= " ON testquiz.quiz_info_no = quiz.quiz_info_no ";
    //     $query .= " AND testquiz.org_no = quiz.org_no ";
    //     $query .= " AND quiz.del_flg = '0' ";
    //     $query .= " WHERE test.test_info_no = :test_info_no ";
    //     $query .= " AND test.org_no = :org_no ";
    //     $query .= " AND test.del_flg = '0' ";
    //     $query .= " ORDER BY ";
    //     $query .= " testquiz.disp_no ASC";

    //     $stmt = $this->pdo->prepare($query);
    //     $stmt->bindParam(":org_no", $org_no, PDO::PARAM_STR);
    //     $stmt->bindParam(":test_info_no", $test_info_no, PDO::PARAM_STR);

    //     return parent::getDataList($stmt, get_class(new T_Test_Info_QuizDto()));
    // }
}
