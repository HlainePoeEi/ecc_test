<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

class T_Menu_SettingDto extends BaseDto {

	//組織ID
	public $org_no;
	// メニューID 取得
	public $menu_id;
	//表示フラグ　0の場合表示、1の場合非表示
	public $show_flg;

}

?>