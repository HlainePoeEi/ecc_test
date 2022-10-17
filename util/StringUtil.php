<?php

/**
 * 文字列ユーティリティクラス
 *
 */
class StringUtil
{

	/**
	 * 配列のキーとObjのフィールド名を照合し
	 * 配列の値をObjにセットする
	 */
	public static function isEmpty($var) {

		if(isset($var)){
			if($var === ''){
				return true;
			}else{
				return false;
			}
		}else{
			return true;
		}
	}

}

?>