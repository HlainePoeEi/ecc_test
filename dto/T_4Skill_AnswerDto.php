<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * ４技能の回答情報テーブルDTOクラス
 */
class T_4Skill_AnswerDto extends BaseDto {

	// 申込管理№
	public $offer_no;
	// 受講者管理№
	public $student_no;
	// コースID
	public $course_id;
	// コース詳細管理№
	public $course_detail_no;
	// 問題管理№
	public $question_no;
	// 音声ファイル名
	public $audio_name;
	// 回答フラグ
	public $answer_flg;
	// 回答内容
	public $answer_contents;
	// 回答日時
	public $answer_dt;
}