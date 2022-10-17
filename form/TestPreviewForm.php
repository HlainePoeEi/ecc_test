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
 * テストプレビューFORMクラス
 *
 */
class TestPreviewForm extends BaseForm{
	//組織管理№
	public $org_no;
	//テスト名
	public $test_name;
	//テスト管理№
	public $test_no;
	//説明
	public $description;
	//クイズ管理№
	public $quiz_no;
	//クイズ内容
	public $quiz_content;
	//画像ファイル名
	public $image_name;
	//音声ファイル名
	public $audio_name;
	//クイズタイプ
	public $quiz_type;
	//ヒント
	public $hint;
	//回答時間
	public $answer_time;
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
	
	//戻り用
	public $back_flg;
	public $search_page;
	public $search_start_period;
	public $search_end_period;
	public $search_test_name;
	public $search_remark;
	public $search_rd_status1;
	public $search_rd_status2;
	public $search_rdstatus;
	public $search_chk_status1;
	public $search_chk_status2;
	public $search_status;
	public $search_org_id;
	
	// TestList Datatable用
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;

}

?>