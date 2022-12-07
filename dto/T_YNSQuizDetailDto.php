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
class T_YNSQuizDetailDto extends BaseDto
{
    public $item_id;

    public $item_type;

    public $ques;

    public $marks;

    public $quiz_name;

    //ID
    public $id;
    //名前
    public $name;
    // 名前
    public $name_kana;
    //カテゴリー
    public $category;
}
