<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * 単語帳単語DTOクラス
 * 
 */
class T_WordBook_WordDto extends BaseDto {

	//組織number
	public $org_no;
	//単語帳ID
	public $wordbook_id;
	//単語
	public $word;
	//意味
	public $translation;
	//単語ID
	public $word_id;
	//表示順
	public $disp_no;
	//登録した人
	public $creater_id;
	//更新した人
	public $updater_id;
	//フィル
	//単語言語
    public $word_lang_type;
	//訳言語
    public $trans_lang_type;
	//備考
    public $remarks;
	//ファイル名
	public $file_name;
}
?>