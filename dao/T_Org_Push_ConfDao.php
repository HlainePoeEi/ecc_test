<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

require_once 'BaseDao.php';

/**
 * 組織情報を更新する
 */
class T_Org_Push_ConfDao extends BaseDao {
	/**
	 * 組織情報を新規登録する
	 */
	public function saveOrgPushConf($dto){

		return parent::insert ( $dto );

	}

    /**
	 * 組織情報を更新する
	 */
	public function updateOrgPushConf($dto){
        $query = " UPDATE ";
        $query .= " T_ORG_PUSH_CONF ";
        $query .= " SET";

        if (!StringUtil::isEmpty($dto->updater_id)){
            $query .= " updater_id  = :updater_id ";
        }

        if (!StringUtil::isEmpty($dto->update_dt)){
            $query .= " ,update_dt  = :update_dt ";
        }

        $query .= " ,push_flg  = :push_flg ";

        $query .= " ,count  = :count ";

        $query .= " WHERE ";
        $query .= " org_no = :org_no ";

        $stmt = $this->pdo->prepare ( $query );
        $stmt->bindParam ( ":org_no",  $dto->org_no, PDO::PARAM_STR );

        if (!StringUtil::isEmpty($dto->updater_id)){
            $stmt->bindParam ( ":updater_id",  $dto->updater_id, PDO::PARAM_STR );
        }

        if (!StringUtil::isEmpty($dto->update_dt)){
            $stmt->bindParam ( ":update_dt",  $dto->update_dt, PDO::PARAM_STR );
        }

        $stmt->bindParam ( ":push_flg",  $dto->push_flg, PDO::PARAM_STR );
        $stmt->bindParam ( ":count",  $dto->count, PDO::PARAM_STR );

        return parent::update ( $stmt );

	}
}

?>