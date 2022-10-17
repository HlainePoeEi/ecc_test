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
 * エクセル登録Formクラス
 *
 */
class ReportListForm extends BaseForm{

    // 組織管理№
    public $org_no;
    public $org_id;
    // レポート管理№
    public $report_no;
    //レポート名
    public $report_name;
    // テストID
    public $test_info_no;
    // テスト名
    public $test_info_name;
    // 現ページ
    public $page;
    // 登録日時
    public $create_dt;
    // 登録者ＩＤ
    public $creater_id;
    // 更新日時
    public $update_dt;
    // 更新者ＩＤ
    public $updater_id;
    //戻り用
	public $back_flg;
	public $search_page;
	public $search_report_name;
    public $search_test_info_name;
    public $search_org_id;
    // Datatable用
	public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
   

}

?>