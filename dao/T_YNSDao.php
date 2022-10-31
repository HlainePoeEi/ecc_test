<?php

require_once 'BaseDao.php';
require_once 'dto/T_YNSDto.php';
require_once 'conf/config.php';

class T_YNSDao extends BaseDao
{

    public function saveWord($dto, $pdo)
    {
        return parent::insertWithPdo($dto, $pdo);
    }

    public function getWordLanguage()
    {
        $query = " SELECT ";
        $query .= " category";
        $query .= " ,type";
        $query .= " ,name";
        $query .= " ,name_kana";
        $query .= " FROM ";
        $query .= " M_TYPE ";
        $query .= " WHERE category = '028' ";
        $query .= " AND del_flg = '0' ";
        $query .= " ORDER BY disp_no ASC ";
        $stmt = $this->pdo->prepare($query);
        return parent::getDataList($stmt, get_class(new T_YNSDto()));
    }

    public function getTranslationLanguage()
    {
        $query = " SELECT ";
        $query .= " category";
        $query .= " ,type";
        $query .= " ,name";
        $query .= " ,name_kana";
        $query .= " FROM ";
        $query .= " M_TYPE ";
        $query .= " WHERE category = '029' ";
        $query .= " AND del_flg = '0' ";
        $query .= " ORDER BY disp_no ASC ";
        $stmt = $this->pdo->prepare($query);
        return parent::getDataList($stmt, get_class(new T_YNSDto()));
    }

    public function getNextId()
    {
        return parent::getId('id');
    }

    public function getWordListData($param, $flg)
    {
        $query = $this->createQuery();
        $query .= " WHERE ";
        $query .= " t_yns.word_book_name LIKE :word_book_name ";
        $word_book_name = '%' . $param->search_word . '%';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(

            ":word_book_name",

            $word_book_name,

            PDO::PARAM_STR

        );
        return parent::getDataList($stmt, get_class(new T_YNSDto()));
    }

    public function createQuery()
    {
        $query = " SELECT *";
        $query .= " FROM t_yns";
        return $query;
    }

    public function getWordData($id)
    {
        $query = " SELECT ";
        $query .= " id ";
        $query .= " ,word_book_name";
        $query .= " ,word_lang_type";
        $query .= " ,trans_lang_type";
        $query .= " FROM ";
        $query .= " T_YNS ";
        $query .= " WHERE id = :id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $id, PDO::PARAM_STR);
        return parent::getDataList($stmt, get_class(new T_YNSDto()));
    }

    public function updateWordInfo($dto)
    {
        $query = 'update t_yns
        SET word_book_name = :word_book_name,
            word_lang_type = :word_lang_type,
            trans_lang_type = :trans_lang_type
        WHERE id = :id';

        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":word_book_name", $dto->word_book_name, PDO::PARAM_STR);
        $stmt->bindParam(":word_lang_type", $dto->word_lang_type, PDO::PARAM_STR);
        $stmt->bindParam(":trans_lang_type", $dto->trans_lang_type, PDO::PARAM_STR);
        $stmt->bindParam(":id", $dto->id, PDO::PARAM_STR);
        return parent::update($stmt);
    }

    public function deleteWordInfo($dto)
    {
        $query = " DELETE ";
        $query .= " FROM ";
        $query .= " T_YNS ";
        $query .= " WHERE ";
        $query .= " id = :id ";
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(":id", $dto->id, PDO::PARAM_STR);
        return parent::delete($stmt);
    }

    // text to speech using php by NMZ
    public function getAudio($dto)
    {
        $query = 'SELECT `word_book_name` FROM `t_yns` WHERE id= :id';
        $stmt = $this->pdo->prepare($query);
        $stmt->bindParam(
            ":id",
            $dto->id,
            PDO::PARAM_STR
        );
        $value = parent::getDataList($stmt, get_class(new T_YNSDto()));
        foreach ($value as $product) {
            $txt =  $product->word_book_name;
        }
        $textToTranslate = $txt;
        $textToTranslate = htmlspecialchars($textToTranslate);
        $textToTranslate = rawurlencode($textToTranslate);
        $volume = file_get_contents('https://translate.google.com/translate_tts?ie=UTF-8&client=gtx&q=' . $textToTranslate . '&tl=en-IN');
        $player = "<audio autoplay><source src='data:audio/mpeg;base64," . base64_encode($volume) . "'></audio>";
        return $player;
    }
}
