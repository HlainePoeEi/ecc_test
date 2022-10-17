<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * 単語帳DTOクラス
 *
 */
class T_WordBookDto extends BaseDto {
	//組織number
	public $org_no;
    //組織ID
    public $org_id;
    //単語帳ID
    public $wordbook_id;
    ///単語登録システム区分
    public $word_system_kbn;
    //タグ
    public $tag;
    //単語帳名
    public $name;
    //単語言語区分
    public $word_lang_type;
    //訳言語区分
    public $trans_lang_type;
    //状態
    public $status;
    //表示順
    public $disp_no;
    //M区分のカテゴリー名のため
    public $category_name;
    public $category;
    //単語ID
    public $word_id;
    //組織名
    public $org_name;
    public $org_name_official;
}
?>