<?php

require_once 'BaseDto.php';
/**
 * 単語履歴DTOクラス
 */
class T_Word_HistoryDto extends BaseDto {
    //組織管理№
    public $org_no;
    //受講者管理№
    public $student_no;
    //単語帳ID
    public $wordbook_id;	
    //単語ID
    public $word_id;
    //単語履歴ID
    public $history_id;
    //覚えたフラグ
    public $learned_flg;
}

?>