<?php
/**
 * PHP AES 加减密
 * @author xzh
 * @date 2018/3/22 下午10:08
 */
class AesEncryptUtil
{
    public static $blockSize = 32;
    //your cliend_id
    private $clientId;
    //your aesKey
    private $aesKey;
    /**
     * AesEncryptNewUtilUtil constructor.
     * @param $clientId
     * @param $encodingAesKey
     */
    public function __construct($clientId, $encodingAesKey)
    {
        $this->clientId = $clientId;
        $this->aesKey = base64_decode($encodingAesKey . "=");
    }
    /**
     * 对明文进行加密
     * @param $text
     * @return string
     * @throws Exception
     */
    public function encrypt($text)
    {
        try {
            // 获得16位随机字符串，填充到明文之前
            $random = $this->getRandomStr();;
            $text = $random . pack("N", strlen($text)) . $text . $this->clientId;
            $iv = substr($this->aesKey, 0, 16);
            // 对明文进行补位填充
            $text = $this->encode($text);
            // 加密
            $encrypted = openssl_encrypt($text, 'aes-256-cbc', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
            // 使用BASE64对加密后的字符串进行编码
            return base64_encode($encrypted);
        } catch (Exception $e) {
            throw new Exception("加密失败");
        }
    }
    /**
     * 对密文进行解密
     * @param $encrypted
     * @return bool|string
     * @throws Exception
     */
    public function decrypt($encrypted, $isCheckClientId = true)
    {
        try {
            // 使用BASE64对需要解密的字符串进行解码
            $ciphertextDec = base64_decode($encrypted);
            $iv = substr($this->aesKey, 0, 16);
            // 解密
            $decrypted = openssl_decrypt($ciphertextDec, 'aes-256-cbc', $this->aesKey, OPENSSL_RAW_DATA | OPENSSL_NO_PADDING, $iv);
        } catch (Exception $e) {
            throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
        }
        try {
            // 去除补位字符
            $result = $this->decode($decrypted);
            // 去除16位随机字符串,网络字节序和clientId
            if (strlen($result) < 16) {
                throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
            }
            $content = substr($result, 16, strlen($result));
            $lenList = unpack("N", substr($content, 0, 4));
            $xmlLen = $lenList[1];
            $xmlContent = substr($content, 4, $xmlLen);
            $fromClientId = substr($content, $xmlLen + 4);
        } catch (Exception $e) {
            throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
        }
        if ($isCheckClientId && ($fromClientId != $this->clientId)) {
            throw new Exception('AesEncryptUtil AES解密串非法，小于16位;');
        }
        return $xmlContent;
    }
    /**
     * 对需要加密的明文进行填充补位
     * @param $text
     * @return string
     */
    private function encode($text)
    {
        $textLength = strlen($text);
        //计算需要填充的位数
        $amountToPad = self::$blockSize - ($textLength % self::$blockSize);
        if ($amountToPad == 0) {
            $amountToPad = self::$blockSize;
        }
        //获得补位所用的字符
        $padChr = chr($amountToPad);
        $tmp = "";
        for ($index = 0; $index < $amountToPad; $index++) {
            $tmp .= $padChr;
        }
        return $text . $tmp;
    }
    /**
     * 对解密后的明文进行补位删除
     * @param $text
     * @return bool|string
     */
    private function decode($text)
    {
        $pad = ord(substr($text, -1));
        if ($pad < 1 || $pad > self::$blockSize) {
            $pad = 0;
        }
        return substr($text, 0, (strlen($text) - $pad));
    }
    /**
     * 随机生成16位字符串
     * @return string
     */
    private function getRandomStr()
    {
        $strPol = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz";
        $max = strlen($strPol) - 1;
        $str = "";
        for ($i = 0; $i < 16; $i++) {
            $str .= $strPol[mt_rand(0, $max)];
        }
        return $str;
    }
}
$client_id = '12123';
$aes_key = '1234567890123456789012345678901234567890123';
$dataCoder = new AesEncryptUtil($client_id, $aes_key);
$enData = $dataCoder->encrypt("testdata");
$dataCoder->decrypt($enData);