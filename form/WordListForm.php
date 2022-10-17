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
 * 単語一覧Formクラス
 */
class WordListForm extends BaseForm{
	// 組織no
	public $org_no;
	// 組織名
	public $org_name;
	// 組織id
	public $org_id;
	// 管理者No
	public $admin_no;
	//単語id
	public $word_id;
	// ログインID
	public $login_id;
	// ワードシステム
	public $word_system_kbn;
	// 単語名
	public $word;
	//意味
	public $translation;
	// ファイル名
	public $file_name;
	// オーディオデータ
	public $audio_data;
	// 入力オーディオファイル
	public $input_audio_file;
	// オーディオファイル
	public $audio_file;
	// 単語タイプ
	public $word_lang_type;
	// トランスタイプ
	public $trans_lang_type;
	// 備考
	public $remarks;
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
    // スクリーンモード
	public $screen_mode;
    // 戻り用
	public $back_flg;
	public $search_word;
	public $search_translation;
	public $search_org_id;
    public $search_page;
    public $search_page_row;
	public $search_page_order_column;
	public $search_page_order_dir;
	public $search_file_name;
}
?>