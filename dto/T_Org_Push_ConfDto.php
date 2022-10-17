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
 * M組織DTOクラス
 */
class T_Org_Push_ConfDto extends BaseDto{

    //組織管理№
    public $org_no;
    //Pushフラグ
    public $push_flg;
    //送信カウント
    public $count;
}

?>