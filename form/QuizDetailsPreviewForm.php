<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseForm.php';

/**
 *クイズアイテムプラビューFORMクラス
 *
 */
class QuizDetailsPreviewForm extends BaseForm{

	// 組織管理№
	public $org_no;
	// 画面モード
	public $screen_mode;
	// クイズ情報管理№
	public $quiz_info_no;
	//クイズ名
	public $quiz_name;
	//長説明
	public $long_description;
	//クイズ内容
	public $description;

	//検索利用データ
	public $search_page;
	public $search_quiz_name;
	public $search_long_description;
	public $search_remark;
	public $search_rd_status1;
	public $search_org_id;

	// 戻る処理用データ
	public $audio_name;
	public $remarks;
	public $audio_file;
	public $file_name;
	public $input_audio_file;
	public $audio_del_flg;
	public $audio_chk_del;
	public $gamen_name;

	public $search_page_qil;
	public $search_page_row_qil;
	public $search_page_order_column_qil;
	public $search_page_order_dir_qil;
}

?>