<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDto.php';

/**
 * 単語帳一覧DTOクラス
 * Mu Lar Sann
 */

class T_WordBookListDto extends BaseDto {
	//単語帳名
	public $name;
	//組織名
	public $org_name;
	//組織number
	public $org_no;
	//単語帳ID
	public $wordbook_id;
	//組織ID
	public $org_id;
	//削除フラグ
	public $del_flg;
}
?>