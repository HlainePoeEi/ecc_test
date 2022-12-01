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
class YNSQuizInfoListForm extends BaseForm
{
    // クイズ管理№
    public $quiz_id;
    // クイズ名
    public $name;
    // 更新備考
    public $remarks;
    //クイズ内容
    public $content;
    public $create_dt;
    public $update_dt;
    //戻り用
    public $search_name;
    public $search_content;
    public $search_remarks;

    public $search_page_qil;
    public $search_page_row_qil;
    public $search_page_order_column_qil;
    public $search_page_order_dir_qil;
}
