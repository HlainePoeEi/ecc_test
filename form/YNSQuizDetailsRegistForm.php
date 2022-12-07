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
 * クイズアイテム設問FORMクラス
 *
 */
class YNSQuizDetailsRegistForm extends BaseForm
{
    public $item_id;

    public $item_type;

    public $ques;

    public $marks;

    public $name;

    public $quiz_id;






    // 画面モード
    public $screen_mode;
    // クイズ情報管理№
    public $quiz_info_no;
    //マック
    public $qz_mark;
    // 説明
    public $qz_des;
    // クイズタイプ
    public $qz_type;
    // クイズ内容
    public $qz_content;
    // 選択1
    public $choice1;
    // 選択2
    public $choice2;
    // 選択3
    public $choice3;
    // 選択4
    public $choice4;
    //穴埋め1
    public $blank1;
    //穴埋め2
    public $blank2;
    // 削除フラグ
    public $date_flg;
    // アイテム登録モード
    public $disable_mode;

    //クイズアイテム情報リスト
    public $arrTypeNameList;
    //選択クイズアイテムリスト
    public $arrTypeNameList1;
    //穴埋めクイズアイテムリスト
    public $arrTypeNameList2;

    //検索利用データ
    public $search_quiz_name;
    public $search_long_description;
    public $search_remark;
    public $search_rd_status1;

    // 戻る処理用データ
    public $quiz_name;
    public $long_description;
    public $audio_name;
    public $remarks;
    public $audio_file;
    public $file_name;
    public $input_audio_file;
    public $audio_del_flg;
    public $audio_chk_del;

    public $search_page_qil;
    public $search_page_row_qil;
    public $search_page_order_column_qil;
    public $search_page_order_dir_qil;
}
