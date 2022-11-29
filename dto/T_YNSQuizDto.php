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
    //クイズ管理№
    public $quiz_id;
    //クイズ名
    public $name;
    //クイズ内容
    public $content;
    //ファイル（音声）
    public $audio_name;
    //更新備考
    public $remarks;
}
