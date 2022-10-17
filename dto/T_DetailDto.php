<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDto.php';

/**
 *T詳細DTOクラス
 */
class T_DetailDto extends BaseDto {

	// コース詳細管理№
	public $course_detail_no;
	// コース詳細名
	public $course_detail_name;
	// コース詳細ローマ字
	public $course_detail_romaji;
	// コースレベル
	public $course_level;
	// テスト区分
	public $test_kbn;
	// 状態
	public $status;
	// 利用開始日
	public $start_period;
	// 利用終了日
	public $end_period;
	// 回答音声
	public $answer_audio;
	// 問題説明
	public $qa_description;
	// 内容
	public $description;
	// 問題管理№
	public $question_no;
	// 回答時間
	public $answer_time;
	// 問題パターン
	public $qa_pattern;
	// 音声ファイル名
	public $audio_name;
	// 準備時間
	public $prepare_time;
	// yes音声ファイル
	public $audio_yes;
	// no音声ファイル
	public $audio_no;
	// 模範解答
	public $sample_answer;
	// 描写ポイント
	public $byosha_point;
	// 更新備考
	public $remarks;
	// コースID
	public $course_id;
	// ルール管理№
	public $rule_no;
	// Subルール管理№
	public $sub_rule_no;
	// ルール詳細管理№
	public $rule_detail_no;
	// 結果区分
	public $result_kbn;
	// 結果点数
	public $result_mark;
	// 合計点数
	public $total_marks;
	// コース名
	public $course_name;
	// 受講者管理№
	public $student_no;
	// 返信コメント
	public $reply_comment;
	// サブ内容
	public $sub_description;
	// コメント内容
	public $cmt_description;
	// 回答内容
	public $answer_contents;
	// 結果内容
	public $result_answer;
	// 回答日時
	public $answer_dt;
	//組織名
	public $org_name;
	//ログインID
	public $stu_login_in;
	//氏名
	public $student_name;
}

?>