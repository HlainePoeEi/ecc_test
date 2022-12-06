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
 * テスト一覧FORMクラス
 *
 */
class YMHTestInfoListForm extends BaseForm{
    // 組織管理№
    public $org_no;
    // テスト管理№
    public $test_info_no;
    // テスト情報名
    public $test_info_name;
    // 利用開始日
    public $start_period;
    // 利用終了日
    public $end_period;
    // 更新備考
    public $remark;
    // 削除フラグ
    public $del_flg;
    // 登録日時
    public $create_dt;
    // 登録者ＩＤ
    public $creater_id;
    // 更新日時
    public $update_dt;
    // 更新者ＩＤ
    public $updater_id;
    //件数
    public $count;
    
    public $quiz_count;
    public $status;
    public $subject_no;
    public $student_no;
    //戻り用
    public $back_flg;
    //検索ページ
    public $search_page;
    //ページ
    public $page;
    //ページにある行
    public $page_row;
    //ページ順序コラム
    public $page_order_column;
    //ページ順序
    public $page_order_dir;
    //検索ページある行
    public $search_page_row;
    //検索ページ順序コラム
    public $search_page_order_column;
    //検索ページ順序
    public $search_page_order_dir;
    public $page_no;
    //ユーザーの選択に従ってデータを取得するには
    public $subject_info;
    public $answer_dt;
    
    
    
}

?>