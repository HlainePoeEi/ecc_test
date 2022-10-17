<?php
/*****************************************************
 *  株式会社ECC
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2017 ECC Co., Ltd
 *
 *****************************************************/
require_once 'BaseDto.php';

/**
 *Tコース組織設定DTOクラス
 */
class T_Course_Org_ConfDto extends BaseDto {

	// 申込管理№
	public $offer_no;
	// 組織管理№
	public $org_no;
	// コースID
	public $course_id;
	// 結果表示フラグ
	public $fb_show_flg;
	// 備考
	public $remarks;

}

?>