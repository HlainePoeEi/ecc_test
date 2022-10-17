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
 * 区分テーブルDTOクラス
 */
class M_typeDto extends BaseDto{
	//カテゴリー
	public $category;
	//区分
	public $type;
	//名前
	public $name;
	//名前フリガナ
	public $name_kana;
	//表示順
	public $disp_no;
}

?>