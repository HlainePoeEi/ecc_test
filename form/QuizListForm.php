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
 * クイズ一覧FORMクラス
 *
 */
class QuizListForm extends BaseForm{
	// 組織管理№
	public $org_no;
	// クイズ管理№
	public $quiz_no;
	// クイズ名
	public $quiz_name;
	// 更新備考
	public $remark;
	//最終担当者のラジオステータス
	public $rd_status1;
	//クイズ内容
	public $quiz_content;
	//タイプ名前
	public $name;
	// 削除フラグ
	public $del_flg;
	// 更新者ID
	public $updater_id;

	//戻り用
	public $search_quiz_name;
	public $search_quiz_content;
	public $search_remark;
	public $search_rd_status1;
	public $search_org_id;
	
	// Datatable用
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;

}

?>
