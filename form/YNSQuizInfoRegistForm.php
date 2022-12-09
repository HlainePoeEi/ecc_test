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
 * クイズ登録FORMクラス
 *
 */
class YNSQuizInfoRegistForm extends BaseForm
{
    public $quiz_id;
    public $name;
    public $content;
    public $audio_name;
    public $remarks;
    public $create_dt;
    public $update_dt;
    public $option1;
    public $option2;
    public $option3;
    public $option4;
    public $correct;









    public $disable_mode;

    public $screen_mode;
    public $cmb_quiz_type;
    public $file_name;
    public $input_audio_file;

    public $audio_del_flg;
    public $audio_chk_del;

    /* 音声ファイルデータ */
    public $audio_data;
    public $audio_file;

    //戻り用
    public $search_quiz_name;
    public $search_long_description;
    public $search_remark;
    public $search_rd_status1;

    public $search_page_qil;
    public $search_page_row_qil;
    public $search_page_order_column_qil;
    public $search_page_order_dir_qil;
}
