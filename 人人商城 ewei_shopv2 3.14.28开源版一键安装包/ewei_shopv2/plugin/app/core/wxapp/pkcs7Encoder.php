<?php
class PKCS7Encoder
{
	static public $block_size = 16;

	/**
     * 对需要加密的明文进行填充补位
     * @param $text 需要进行填充补位操作的明文
     * @return 补齐明文字符串
     */
	public function encode($text)
	{
		$block_size = PKCS7Encoder::$block_size;
		$text_length = strlen($text);
		$amount_to_pad = PKCS7Encoder::$block_size - $text_length % PKCS7Encoder::$block_size;

		if ($amount_to_pad == 0) {
			$amount_to_pad = PKCS7Encoder::block_size;
		}

		$pad_chr = chr($amount_to_pad);
		$tmp = '';
		$index = 0;

		while ($index < $amount_to_pad) {
			$tmp .= $pad_chr;
			++$index;
		}

		return $text . $tmp;
	}

	/**
     * 对解密后的明文进行补位删除
     * @param decrypted 解密后的明文
     * @return 删除填充补位后的明文
     */
	public function decode($text)
	{
		$pad = ord(substr($text, -1));
		if ($pad < 1 || 32 < $pad) {
			$pad = 0;
		}

		return substr($text, 0, strlen($text) - $pad);
	}
}

class Prpcrypt
{
	public $key;

	public function Prpcrypt($k)
	{
		$this->key = $k;
	}

	/**
     * 对密文进行解密
     * @param string $aesCipher 需要解密的密文
     * @param string $aesIV 解密的初始向量
     * @return string 解密得到的明文
     */
	public function decrypt($aesCipher, $aesIV)
	{
		try {
			$module = mcrypt_module_open(MCRYPT_RIJNDAEL_128, '', MCRYPT_MODE_CBC, '');
			mcrypt_generic_init($module, $this->key, $aesIV);
			$decrypted = mdecrypt_generic($module, $aesCipher);
			mcrypt_generic_deinit($module);
			mcrypt_module_close($module);
		}
		catch (Exception $e) {
			return array(ErrorCode::$IllegalBuffer, NULL);
		}

		try {
			$pkc_encoder = new PKCS7Encoder();
			$result = $pkc_encoder->decode($decrypted);
		}
		catch (Exception $e) {
			return array(ErrorCode::$IllegalBuffer, NULL);
		}

		return array(0, $result);
	}
}

require_once EWEI_SHOPV2_PLUGIN . 'app/core/wxapp/errorCode.php';

?>
