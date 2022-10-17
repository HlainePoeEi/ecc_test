<?php


require_once 'BaseForm.php';

/**
 * クイズ登録FORMクラス
 *
 */
class WordRegistForm extends BaseForm{

	public $org_no;
	public $org_name;
	public $org_name_official;
	public $org_id;
	public $admin_no;
	public $word_id;
	public $login_id;
	public $word_system_kbn;
	public $word;
	public $translation;
	public $file_name;
	public $audio_data;
	public $input_audio_file;
	public $audio_file;
	public $word_lang_type;
	public $trans_lang_type;
	public $remarks;
	public $del_flg;
	public $create_dt;
	public $creater_id;
	public $update_dt;
	public $updater_id;
	public $screen_mode;
	public $copy_org_no;
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