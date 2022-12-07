<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'dao/T_WordDao.php';
require_once 'service/BaseService.php';
/**
 * 単語サービス
 */
class YNSQuizDetailService extends BaseService
{

    public function getQuizType()
    {
        // データベース接続
        $typeDao = new T_QuizDetailDao();
        // 単語言語を取得すること
        return $typeDao->getQuizType();
    }
    public function getQuizInfo($id)
    {
        // データベース接続
        $typeDao = new T_QuizDetailDao();
        // 単語言語を取得すること
        return $typeDao->getQuizInfo($id);
    }























    public function saveWord($dto)
    {
        // データベース接続
        $wordDao = new T_WordDao($this->pdo);
        // 単語を登録する
        return $wordDao->saveWord($dto, $this->pdo);
    }



    public function getWordData($org_no, $word_id)
    {
        // データベース接続
        $dao = new T_WordDao();
        // 単語データを取得すること
        return $dao->getWordData($org_no, $word_id);
    }

    public function updateWordInfo($dto)
    {
        // データベース接続
        $dao = new T_WordDao();
        // 単語データを更新すること
        return $dao->updateWordInfo($dto);
    }

    public function getTranslationLanguage()
    {
        // データベース接続
        $wordDao = new T_WordDao();
        // 訳言語を取得すること
        return $wordDao->getTranslationLanguage();
    }

    public function deleteWordInfo($dto)
    {
        // データベース接続
        $dao = new T_WordDao();
        // Ｔ管理者教師データを更新すること
        return $dao->deleteWordInfo($dto);
    }

    public function getNextId()
    {
        // データベース接続
        $dao = new T_WordDao();
        // Tシーケンステーブルから次の管理者№を取得する
        return $dao->getNextId();
    }

    public function getWordListData($form, $flg)
    {
        // データベース接続
        $dao = new T_WordDao();
        // 単語リストを取得すること
        return $dao->getWordListData($form, $flg);
    }
}
