<?php
/*****************************************************
 *  株式会社ECC 新商品開発プロジェクト
 *  単語帳アプリ
 *
 *  Copyright (c) 2016 ECC Co., Ltd
 *
 *****************************************************/

/**
 * PDOのユーティリティクラス
 *
 * @author ryo.fujitani
 *
 */
class PDOUtil {
	public static function getPDO() {
		// PDOのインスタンスを生成する
		$pdo = new PDO ( DB_CONNECT_STRING, DB_CONNECT_USER, DB_CONNECT_PASSWORD, array (
				PDO::ATTR_EMULATE_PREPARES => false
		) );
		$pdo->setAttribute ( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );

		return $pdo;
	}
}

?>