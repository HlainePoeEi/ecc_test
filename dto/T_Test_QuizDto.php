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
class T_Test_QuizDto extends BaseDto {
	public $org_no;
	public $test_quiz_no;
	public $test_no;
	public $quiz_no;
	public $disp_no;
}

?>