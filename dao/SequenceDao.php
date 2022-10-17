<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  単語帳アプリ
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'util/PDOUtil.php';
require_once 'conf/config.php';
require_once 'dto/SequenceDto.php';
require_once 'helper/TransitionHelper.php';
require_once 'util/StringUtil.php';

/**
 * SequenceDaoクラス
 *
 * @author ECC
 *
 */
class SequenceDao {
	
	public function getSequenceNo($str) {
		
		// 初期化（SysRoot設定）
		$seqPdo = PDOUtil::getPDO();

		// アクションメソッドを実行
		$seqPdo->beginTransaction();

		//　現在の連番取得SQL
		$query = "SELECT current_sequence_num";
		$query .= " ,increment";
		$query .= " FROM T_SEQUENCE ";
		$query .= " WHERE item = :item FOR UPDATE;";
		
		LogHelper::logDebug($query);
		
		$stmt = $seqPdo->prepare($query);
		$stmt->bindParam ( ":item", $str, PDO::PARAM_STR );
		
		$current = $this->getData($stmt, get_class(new SequenceDto()));
		
		$nextId = $current->current_sequence_num + $current->increment ;
		
		LogHelper::logDebug( "next id is " . $nextId);
		
		//　連番の更新
		$sql = "UPDATE T_SEQUENCE";
		$sql .= " set current_sequence_num = :nextId ";
		$sql .= " WHERE item = :item;";
		
		$stmt1 = $seqPdo->prepare($sql);
		
		$stmt1->bindParam ( ":item", $str, PDO::PARAM_STR );
		$stmt1->bindParam ( ":nextId", $nextId, PDO::PARAM_INT );
		
		$stmt1->execute ();

		$seqPdo->commit();
		
		return $nextId;
	}
	
	/**
	 * データを1件取得してDtoのフィールドに値を詰める
	 */
	function getData($stmt, $className) {
		$stmt->execute ();
		$stmt->setFetchMode ( \PDO::FETCH_CLASS, $className );
		return $stmt->fetch ();
	}
}

?>