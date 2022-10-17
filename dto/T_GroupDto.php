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
 * グループテーブルDTOクラス
 */
class T_GroupDto extends BaseDto {

	//組織管理№
	public $org_no;
	//グループ管理№
	public $group_no;
	//グループ名
	public $group_name;
	//グループ名ふりがな
	public $group_name_kana;
	//学年管理№
	public $grade_no;
	//利用開始日
	public $start_period;
	//利用終了日
	public $end_period;
	//更新備考
	public $remarks;

}

?>