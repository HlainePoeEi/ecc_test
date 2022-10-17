<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDto.php';
/**
 * 単語DTOクラス
 */
class T_WordDto extends BaseDto {
	//組織No
    public $org_no;
	//管理者No
    public $admin_no;
	//ログインID
    public $login_id;
	//単語ID
    public $word_id;
	//単語kbn
    public $word_system_kbn;
	//単語
    public $word;
	//訳
    public $translation;
	//単語言語
    public $word_lang_type;
	//訳言語
    public $trans_lang_type;
	//備考
    public $remarks;
	//組織名
    public $org_name;
	//ファイル名
    public $file_name;
	//オーディオ名
    public $audio_name;
	//オーディオファイル
    public $audio_file;
	//スクリーンモード
    public $screen_mode;
	//組織名
    public $org_name_official;
	//検索されたオーディオファイル
    public $search_input_audio_file;
	//ID
    public $id;
	//名前
    public $name;
    // 名前
    public $name_kana;
	//カテゴリー
    public $category;
}
?>