<?php

/*****************************************************
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDto.php';

/**
 * テスト問題テーブルDTOクラス
 */
class T_YNSQuizDto extends BaseDto
{
    public $quiz_id;
    public $name;
    public $type;
    public $time;
    public $content;
    public $image_name;
    public $audio_name;
    public $correct1;
    public $correct2;
    public $incorrect1;
    public $incorrect2;
    public $incorrect3;
    public $hint;
    public $explanation;
    public $remarks;
}
