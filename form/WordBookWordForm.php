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
 * 単語帳単語FORM
 * Mu Lar Sann
 *
 */
class WordBookWordForm extends BaseForm{

	//ログインした人
	public $login_id;
	//管理者number
	public $admin_no;
	//組織number
	public $org_no;
	//単語帳ID
	public $wordbook_id;
	//単語
	public $word;
	//意味
	public $translation;
	//単語ID
	public $word_id;
	//表示順
	public $disp_no;
	//画面モード
	public $screen_mode;
	//組織ID
	public $org_id;
	//組織名
	public $org_name;
	public $org_name_official;
	// 検索名
	public $search_name;
	// 検索組織ID
	public $search_org_id;

	public $checkVal;
	//画面名
	public $screen_name;
	//戻り用
	public $back_flg;
	public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
	//単語帳IDをコピーする
    public $copy_wordbook_id;
	public $copy_org_no;
	//戻るボタンを押す時登録画面へ戻る場合のため
	//タグ
	public $tag;
	//単語帳名
    public $word_book_name;
	//単語言語区分
    public $word_lang_type;
	//訳言語区分
    public $trans_lang_type;
	//状態
    public $status;
	public $entryList;
	public $initialList;
}