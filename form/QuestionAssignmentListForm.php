<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 * 問題割当FORMクラス
 *
 */
class QuestionAssignmentListForm extends BaseForm{

	// 問題管理№
    public $question_no;
    // 問題名
    public $question_name;
    // 問題説明
    public $qa_description;
    // 内容
    public $description;
    // テスト区分
    public $test_kbn;
    // コースレベル
    public $course_level;
    // 問題パターン
    public $qa_pattern;
    // 採点パターン
    public $score_pattern;
    // 音声ファイル名
    public $audio_name;
    // 音声内容
    public $audio_description;
    // 準備時間
    public $prepare_time;
    // 回答時間
    public $answer_time;
    // yes音声ファイル
    public $audio_yes;
    // yes内容
    public $yes_description;
    // no音声ファイル
    public $audio_no;
    // no内容
    public $no_description;
    // 状態
    public $status;
    // 模範解答
    public $sample_answer;
    // 描写ポイント
    public $byosha_point;
    	// コース名ふりがな
	public $course_detail_romaji;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 科目管理№
	public $value;
	// 受講管理No.
	public $student_no;
	// 最大ページ
	public $max_page;
	// コース詳細管理№
	public $course_detail_no;
	// 詳細名
	public $detail_name;
	// コース詳細名
	public $course_detail_name;
	// ログインId
	public $login_id;
	// 合計マーク
	public $total_marks;
	// 点数
	public $score;
	// 回答日時
	public $answer_dt;
	// 回答フラグ
	public $answer_flg;
	//件数
	public $count;
	// 現ページ
	public $page;
	// 戻り用
	public $back_flg;
	// 検索ページ
	public $search_page;
	// 検索利用終了日
	public $search_start_period;
	// 検索利用終了日
	public $search_end_period;
	// 検索状態
	public $search_status;
	// 検索コース詳細
	public $search_course_detail_name;

	public $chk_status1;

	public $chk_status2;

	public $searchList;

	public $rowno;

	public $entryList;

	public $search_test_kbn;

	public $search_course_level;

}

?>