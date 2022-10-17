<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

/**
 * 基底DTOクラス
 *
 */
class BaseDto {
 	//削除フラグ
	public $del_flg;
	//登録日時
	public $create_dt;
	//登録者ＩＤ
	public $creater_id;
	//更新日時
	public $update_dt;
	//更新者ＩＤ
	public $updater_id;
}

?>