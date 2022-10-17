<?php

/**
 * 共通ユーティリティクラス
 *
 */
class CommonUtil
{

	/**
	 * 配列のキーとObjのフィールド名を照合し
	 * 配列の値をObjにセットする
	 */
	public static function fetchObject($obj, $arr) {

		$class_vars = get_object_vars($obj);

		foreach ( $arr as $name => $value ) {
			if (array_key_exists ( $name, $class_vars )) {
				// 両端の空白を除去する
				if(is_array($value)){
					$obj->$name = $value;
				} else {
					$obj->$name = trim($value);
				}
			}
		}
	}

	public static function changeTypeSex($sex) {
		if ($sex == '0')
			$sex = "未指摘";
			else if ($sex == '1')
				$sex = "男性";
				else if ($sex == '2')
					$sex = "女性";
					return $sex;
	}

	/*
	 * パスワード暗号化
	 */
	public static function encryptPassword($password) {
		// 変数の初期化
		$res = null;
		$options = array();

		$options = array(
				'salt' => mcrypt_create_iv(22, MCRYPT_DEV_URANDOM),
				'cost' => 12
		);
		$res = password_hash( $password, PASSWORD_BCRYPT, $options);
		LogHelper::logDebug("hashed password".$res);
		return $res;
	}
	/*
	 * HTMLエンティティを文字に変換とエスケープコンマ
	 */
	public static function htmlEntityDecode($result) {
		//エスケープコンマ
		$esc = "escape comma";
		$result=str_replace($esc, ",", $result);
		//HTMLエンティティを文字に変換します  || !preg_match('/^[a-zA-Z\d]*$/',$result)
		if($result==strip_tags($result)){
			$result =html_entity_decode($result);
		}
		return $result;
	}
}

?>