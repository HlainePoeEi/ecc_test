<?php

/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  PHPシステム構築フレームワーク
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/
require_once 'conf/config.php';
require_once 'helper/TransitionHelper.php';
require_once 'util/StringUtil.php';
require_once 'dto/T_SequenceDto.php';

/**
 * 基底DAOクラス
 */
class BaseDao
{

	/**
	 * PDOインスタンス
	 */
	protected $pdo;

	/**
	 * コンストラクタ
	 */
	function __construct()
	{

		// PDOのインスタンスを生成する
		$this->pdo = new PDO(DB_CONNECT_STRING, DB_CONNECT_USER, DB_CONNECT_PASSWORD, array(
			PDO::ATTR_EMULATE_PREPARES => false
		));
		$this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	}

	/**
	 * データを1件取得してDtoのフィールドに値を詰める
	 */
	function getData($stmt, $className)
	{
		$stmt->execute();
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $className);

		return $stmt->fetch();
	}

	/**
	 * データを複数取得してDtoのフィールドに値を詰める
	 */
	function getDataList($stmt, $className)
	{
		$stmt->execute();
		$stmt->setFetchMode(\PDO::FETCH_CLASS, $className);

		return $stmt->fetchAll();
	}


	/**
	 * データを1件挿入する
	 */
	function insert($dto)
	{
		$className = get_class($dto);

		$tableName = preg_replace('/' . DTO_CLASS_SUFFIX . '$/', '', $className);
		$tableName = strtoupper($tableName);

		// Dtoのフィールドを取得
		$class_vars = get_class_vars($className);

		$query = "INSERT INTO ";
		$query .= " $tableName (";

		// DTOフィールド名
		$arr_fields = array();
		// DTOフィールドの値
		$arr_vars = array();

		// 値が設定されているフィールドのみを取り出す
		foreach ($class_vars as $key => $value) {
			if (!StringUtil::isEmpty($dto->$key)) {
				$arr_fields[] = $key;
				$arr_vars[] = $dto->$key;
			}
		}
		$query .= implode(",", $arr_fields);

		$query .= " ) VALUES ( ";

		// SQLパラメータを挿入する
		$arr_param = array();
		foreach ($arr_fields as $value) {
			$arr_param[] = ":$value";
		}
		$query .= implode(",", $arr_param);

		$query .= " );";

		LogHelper::logDebug($query);

		$stmt = $this->pdo->prepare($query);

		// SQLパラメータに値をバインドする
		foreach ($arr_fields as $key) {
			$stmt->bindParam(":$key", $dto->$key, PDO::PARAM_STR);
		}

		return $stmt->execute();
	}

	/**
	 * @$resultListはDtoのリスト
	 * データを登録する（トランザクション制御あり）
	 */
	public function insertWithTran($resultList)
	{
		$rs = 1;
		try {
			// トランザクション開始
			$this->pdo->beginTransaction();
			// 登録実行
			if (count($resultList) > 0) {
				$this->bulkInsert($resultList);
			}
			// コミット
			$this->pdo->commit();
		} catch (Exception $e) {
			// ロールバック
			$this->pdo->rollBack();
			$rs = 0;
		}
		return $rs;
	}

	/**
	 * データを更新する（トランザクション制御あり）
	 */
	function updateWithTran($stmt, $dto, $keys)
	{
		try {
			// トランザクション開始
			$this->pdo->beginTransaction();

			// 更新可能かチェック
			if (!$this->checkVersion($dto, $keys)) {
				throw new Exception(E005);
			}

			// 更新実行
			$this->update($stmt);

			// コミット
			$this->pdo->commit();
		} catch (Exception $e) {
			// ロールバック
			$this->pdo->rollBack();
			throw $e;
		}
	}

	/**
	 * データを更新する
	 */
	function update($stmt)
	{
		return $stmt->execute();
	}

	function delete($stmt)
	{
		return $stmt->execute();
	}

	/**
	 * データの更新日時を確認し、更新可能かを判定する
	 */
	function checkVersion($dto, $keys)
	{

		// テーブル名取得
		$className = get_class($dto);
		$tableName = preg_replace('/' . DTO_CLASS_SUFFIX . '$/', '', $className);
		$tablename = strtoupper($tableName);

		// キーでデータを取得するクエリ作成
		$query = " SELECT ";
		$query .= implode(",", $keys);
		$query .= " FROM ";
		$query .= " $tableName ";
		$query .= " WHERE ";
		$arr = array();
		foreach ($keys as $key) {
			$arr[] = "$key = :$key";
		}
		unset($key);
		$query .= implode(" AND ", $arr);

		// パラメータに値を設定
		$stmt = $this->pdo->prepare($query);
		foreach ($keys as $key) {
			$stmt->bindParam(":$key", $dto->$key, PDO::PARAM_STR);
		}

		// 最新データ取得
		$data = $this->getData($stmt, $className);

		// 更新日が変わっている場合は更新不可
		if ($data->update_date == $dto->update_date) {
			return true;
		} else {
			return false;
		}
	}

	/*
	 * 複数件データを挿入する
	 */
	public function bulkInsert($list)
	{

		$className = get_class($list[0]);

		$tableName = preg_replace('/' . DTO_CLASS_SUFFIX . '$/', '', $className);
		$tableName = strtoupper($tableName);

		// Dtoのフィールドを取得
		$class_vars = get_class_vars($className);


		$query = "INSERT INTO ";
		$query .= " $tableName ";

		$query .= "  VALUES  ";

		//DTOのフィールドを取り出す。
		$values = "";
		for ($i = 0; $i < count($list); $i++) {
			$dto = $list[$i];
			// DTOフィールド名
			$arr_fields = array();
			// DTOフィールドの値
			$arr_vars = array();

			//フィールドを取り出す
			foreach ($class_vars as $key => $value) {
				$arr_fields[] = $key;
				$arr_vars[] = $dto->$key;
			}

			// SQLパラメータを挿入する
			$arr_param = array();
			foreach ($arr_fields as $value) {
				$arr_param[] = ":$value" . $i;
			}
			$values .= "(";

			$values .= implode(",", $arr_param);

			$values .= " ),";
		}

		//最後のカンマを削除
		$values = substr($values, 0, -1);
		$query .= $values;
		$stmt = $this->pdo->prepare($query);

		// SQLパラメータに値をバインド
		for ($i = 0; $i < count($list); $i++) {
			$dto = $list[$i];
			foreach ($class_vars as $key => $value) {
				$type = gettype($dto->$key);
				$param = null;
				if ($type == "integer") {
					$param = PDO::PARAM_INT;
				} else if ($type == "string") {
					$param = PDO::PARAM_STR;
				} else if ($type == "NULL") {
					$param = PDO::PARAM_NULL;
				} else {
					$param = PDO::PARAM_STR;
				}
				$stmt->bindValue(":$key" . $i, $dto->$key, $param);
			}
		}
		//LogHelper::logDebug($stmt->queryString);
		$stmt->execute();
	}

	/**
	 *
	 * @param unknown $str
	 */
	public function getId($str)
	{

		$query = " SELECT ";
		$query .= " sequence(:str) as id ;";

		$stmt = $this->pdo->prepare($query);
		$stmt->bindParam(":str", $str, PDO::PARAM_STR);

		LogHelper::logDebug($str);
		return $this->getData($stmt, get_class(new T_SequenceDto()));
	}

	/**
	 * データを削除する
	 */
	/*function delete($stmt) {
		return $stmt->execute ();
	}*/

	/**
	 * データを1件挿入する
	 */
	function insertWithPdo($dto, $pdo)
	{
		$className = get_class($dto);

		$tableName = preg_replace('/' . DTO_CLASS_SUFFIX . '$/', '', $className);
		$tableName = strtoupper($tableName);

		// Dtoのフィールドを取得
		$class_vars = get_class_vars($className);

		$query = "INSERT INTO ";
		$query .= " $tableName (";

		// DTOフィールド名
		$arr_fields = array();
		// DTOフィールドの値
		$arr_vars = array();

		// 値が設定されているフィールドのみを取り出す
		foreach ($class_vars as $key => $value) {
			if (!StringUtil::isEmpty($dto->$key)) {
				$arr_fields[] = $key;
				$arr_vars[] = $dto->$key;
			}
		}
		$query .= implode(",", $arr_fields);

		$query .= " ) VALUES ( ";

		// SQLパラメータを挿入する
		$arr_param = array();
		foreach ($arr_fields as $value) {
			$arr_param[] = ":$value";
		}
		$query .= implode(",", $arr_param);

		$query .= " );";

		LogHelper::logDebug($query);

		$stmt = $pdo->prepare($query);

		// SQLパラメータに値をバインドする
		foreach ($arr_fields as $key) {
			$stmt->bindParam(":$key", $dto->$key, PDO::PARAM_STR);
		}

		return $stmt->execute();
	}

	/*
	 * 複数件データを挿入する
	 */
	public function bulkInsertWithPdo($list, $pdo)
	{

		$className = get_class($list[0]);

		$tableName = preg_replace('/' . DTO_CLASS_SUFFIX . '$/', '', $className);
		$tableName = strtoupper($tableName);

		// Dtoのフィールドを取得
		$class_vars = get_class_vars($className);


		$query = "INSERT INTO ";
		$query .= " $tableName ";

		$query .= "  VALUES  ";

		//DTOのフィールドを取り出す。
		$values = "";
		for ($i = 0; $i < count($list); $i++) {
			$dto = $list[$i];
			// DTOフィールド名
			$arr_fields = array();
			// DTOフィールドの値
			$arr_vars = array();

			//フィールドを取り出す
			foreach ($class_vars as $key => $value) {
				$arr_fields[] = $key;
				$arr_vars[] = $dto->$key;
			}

			// SQLパラメータを挿入する
			$arr_param = array();
			foreach ($arr_fields as $value) {
				$arr_param[] = ":$value" . $i;
			}
			$values .= "(";

			$values .= implode(",", $arr_param);

			$values .= " ),";
		}

		//最後のカンマを削除
		$values = substr($values, 0, -1);
		$query .= $values;
		$stmt = $pdo->prepare($query);

		// SQLパラメータに値をバインド
		for ($i = 0; $i < count($list); $i++) {
			$dto = $list[$i];
			foreach ($class_vars as $key => $value) {
				$type = gettype($dto->$key);
				$param = null;
				if ($type == "integer") {
					$param = PDO::PARAM_INT;
				} else if ($type == "string") {
					$param = PDO::PARAM_STR;
				} else if ($type == "NULL") {
					$param = PDO::PARAM_NULL;
				} else {
					$param = PDO::PARAM_STR;
				}
				$stmt->bindValue(":$key" . $i, $dto->$key, $param);
			}
		}
		//LogHelper::logDebug($stmt->queryString);
		$stmt->execute();
	}

	/**
	 * @$resultListはDtoのリスト
	 * データを登録する（トランザクション制御あり）
	 */
	public function insertWithTranPdo($resultList, $pdo)
	{
		$rs = 1;
		try {
			// 登録実行
			if (count($resultList) > 0) {
				$this->bulkInsertWithPdo($resultList, $pdo);
			}
		} catch (Exception $e) {
			$rs = 0;
		}
		return $rs;
	}
}
