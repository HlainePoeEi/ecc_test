<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * 問題DTOクラス
 */
class T_QuestionDto extends BaseDto {

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
	// 更新備考
	public $remarks;
	//行番号
	public $rowno;
}

?>