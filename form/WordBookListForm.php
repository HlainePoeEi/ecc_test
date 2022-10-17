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
 * 単語帳一覧FORMクラス
 * Mu Lar Sann
 *
 */
class WordBookListForm extends BaseForm{
    //単語帳名
    public $name;
    //組織名
    public $org_name;
    //単語帳ID
    public $wordbook_id;
    //削除フラグ
    public $del_flg;
    //組織number
    public $org_no;
    //組織ID
    public $org_id;
    //検索名
    public $search_name;
    //画面モード
    public $screen_mode;
    //検索組織ID
    public $search_org_id;
    public $back_flg;
    // Datatable用
    public $search_page;
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
}
?>
