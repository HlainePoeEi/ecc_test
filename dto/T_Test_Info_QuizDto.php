<?php
/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * やり取りテーブルDTOクラス
 */
class T_Test_Info_QuizDto extends BaseDto {
	public $org_no;
	public $test_info_no;
	public $quiz_info_no;
	public $disp_no;
}

?>