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
 * クイズ登録FORMクラス
 *
 */
class QuizRegistForm extends BaseForm{
	// 組織管理№
	public $org_no;
	// クイズ管理№
	public $quiz_no;
	// クイズ名
	public $quiz_name;
	// 解説
	public $explanation;
	// 更新備考
	public $remarks;
	// 削除フラグ
	public $del_flg;

	// 更新者ID
	public $updater_id;

	// 現ページ
	public $page;
	//最大ページ
	public $max_page;

	public $quiz_content;
	public $correct1;
	public $correct2;
	public $incorrect1;
	public $incorrect2;
	public $incorrect3;
	public $hint;
	public $quiz_type;
	public $answer_time;
	public $audio_file;

	public $screen_mode;
	public $cmb_quiz_type;
	public $chk_status1;
	public $chk_status2;
	public $file_name;
	public $input_audio_file;
	public $quizInfo;
	public $type_name;

	public $img_flg;
	public $audio_del_flg;
	public $audio_chk_del;

	public $choice_correct1;
	public $blank_correct1;

	/* 音声ファイルデータ */
	public $audio_data;

	//戻り用
	public $search_page;
	public $search_quiz_name;
	public $search_quiz_content;
	public $search_remark;
	public $search_rd_status1;
	public $search_org_id;
	
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;


}