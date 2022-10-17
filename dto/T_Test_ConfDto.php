<?php
require_once 'BaseDto.php';

/**
 * テスト情報設定DTOクラス
 */
class T_Test_ConfDto extends BaseDto {
	
	// 組織管理№
	public $org_no;
	// テスト管理№
	public $test_no;
	// 編集フラグ
	public $editable_flg;

}

?>