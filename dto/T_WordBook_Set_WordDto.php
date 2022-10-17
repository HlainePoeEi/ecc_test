<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * 単語帳セット単語DTOクラス
 * 
 */
class T_WordBook_Set_WordDto extends BaseDto {

	//組織number
	public $org_no;
	//単語帳ID
	public $wordbook_id;
	//セット番号
	public $set_no;
	//単語ID
	public $word_id;
	//表示順
	public $disp_no;
}
?>