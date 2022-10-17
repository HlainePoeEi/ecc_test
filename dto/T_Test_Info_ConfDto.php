<?php
require_once 'BaseDto.php';

/**
 * テスト情報設定DTOクラス
 */
class T_Test_Info_ConfDto extends BaseDto {
	
	// 組織管理№
	public $org_no;
	// テスト管理№
	public $test_info_no;
	// 編集フラグ
	public $editable_flg;

}

?>