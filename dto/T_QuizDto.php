<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * テスト問題テーブルDTOクラス
 */
class T_QuizDto extends BaseDto {

	//組織管理№
	public $org_no;
	//クイズ管理№
	public $quiz_no;
	//クイズ名
	public $quiz_name;
	//クイズタイプ
	public $quiz_type;
	//回答時間
	public $answer_time;
	//クイズ内容
	public $quiz_content;
	//画像ファイル名
	public $image_name;
	//音声ファイル名
	public $audio_name;
	//正解1
	public $correct1;
	//正解2
	public $correct2;
	//不正解1
	public $incorrect1;
	//不正解2
	public $incorrect2;
	//不正解3
	public $incorrect3;
	//ヒント
	public $hint;
	//解説
	public $explanation;
	//更新備考
	public $remarks;
}

?>