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
 * 単語並び替えFormクラス
 */
class WordSortForm extends BaseForm{
	// 管理者No
	public $manager_no;
	// 組織No
	public $org_no;
	// 単語帳ID
	public $wordbook_id;
	// 単語ID
	public $word_id;
	// 表示番号
	public $disp_no;
	// 訳
	public $translation;
	// 単語
	public $word;
	// 単語帳名前
	public $name;
	// ワードソート
	public $wordSort;
	// チェック価値
	public $entryList;
	// Datatable
	public $max_page;
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
	// 戻る場合
	public $back_flg;
	public $search_name;
}