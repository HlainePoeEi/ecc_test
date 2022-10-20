<?php

require_once 'BaseForm.php';

class YNSWordRegistForm extends BaseForm
{
    public $id;

    public $word_book_name;

    public $login_id;

    public $translation;

    public $audio_data;

    public $input_audio_file;

    public $audio_file;

    public $word_lang_type;

    public $trans_lang_type;

    public $create_dt;

    public $creater_id;

    public $update_dt;

    public $updater_id;

    public $screen_mode;

    //最大ページ

    public $max_page;

    public $search_word;

    public $search_translation;

    public $search_org_id;

    public $search_page;

    public $search_page_row;

    public $search_page_order_column;

    public $search_page_order_dir;
}
