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
 * 単語帳登録FORMクラス
 * Mu Lar Sann
 */
class WordBookRegistForm extends BaseForm {

    //組織名
    public $org_name;
    public $org_name_official;
    //組織number
    public $org_no;
    //組織ID
    public $org_id;
    //単語帳ID
    public $wordbook_id;
    ///単語登録システム区分
    public $word_system_kbn;
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
    //表示順
    public $disp_no;
    //削除フラグ
    public $del_flg;
    //登録した日
    public $create_dt;
    //登録した人
    public $creater_id;
    //更新した日
    public $update_dt;
    //更新した人
    public $updater_id;
    //ログインしたID
    public $login_id;
	// 画面モード
	public $screen_mode;
	// 検索ページ
	public $search_page;
	// 検索名
	public $search_name;
    // 検索組織ID
    public $search_org_id;
    //単語帳IDをコピーする
    public $copy_wordbook_id;
    public $copy_org_no;
    // 戻り用
	public $back_flg;
    public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
}
?>