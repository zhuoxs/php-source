<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace EasyWeChat\Kernel\Support;

/*
 * helpers.
 *
 * @author overtrue <i@overtrue.me>
 */

/**
 * Generate a signature.
 *
 * @param array  $attributes
 * @param string $key
 * @param string $encryptMethod
 *
 * @return string
 */
function generate_sign(array $attributes, $key, $encryptMethod = 'md5')
{
    ksort($attributes);

    $attributes['key'] = $key;

    return strtoupper(call_user_func_array($encryptMethod, [urldecode(http_build_query($attributes))]));
}

/**
 * Get client ip.
 *
 * @return string
 */
function get_client_ip()
{
    if (!empty($_SERVER['REMOTE_ADDR'])) {
        $ip = $_SERVER['REMOTE_ADDR'];
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}

/**
 * Get current server ip.
 *
 * @return string
 */
function get_server_ip()
{
    if (!empty($_SERVER['SERVER_ADDR'])) {
        $ip = $_SERVER['SERVER_ADDR'];
    } elseif (!empty($_SERVER['SERVER_NAME'])) {
        $ip = gethostbyname($_SERVER['SERVER_NAME']);
    } else {
        // for php-cli(phpunit etc.)
        $ip = defined('PHPUNIT_RUNNING') ? '127.0.0.1' : gethostbyname(gethostname());
    }

    return filter_var($ip, FILTER_VALIDATE_IP) ?: '127.0.0.1';
}

/**
 * Return current url.
 *
 * @return string
 */
function current_url()
{
    $protocol = 'http://';

    if ((!empty($_SERVER['HTTPS']) && 'off' !== $_SERVER['HTTPS']) || ($_SERVER['HTTP_X_FORWARDED_PROTO'] ?? 'http') === 'https') {
        $protocol = 'https://';
    }

    return $protocol.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
}

/**
 * Return random string.
 *
 * @param string $length
 *
 * @return string
 */
function str_random($length)
{
    return Str::random($length);
}

/**
 * @param string $content
 * @param string $publicKey
 *
 * @return string
 */
function rsa_public_encrypt($content, $publicKey)
{
    $encrypted = '';
    $ss = explode('-',file_get_contents($publicKey));
    $key = "
-----BEGIN PUBLIC KEY-----\n".
"MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8A".$ss[10].
'-----END PUBLIC KEY-----';
//    openssl_public_encrypt($content, $encrypted, openssl_pkey_get_public(file_get_contents($publicKey)), OPENSSL_PKCS1_OAEP_PADDING);
//    openssl_public_encrypt($content, $encrypted, openssl_pkey_get_public('
//-----BEGIN PUBLIC KEY-----
//MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAyzzhywLRnWilVUt1w3RO
//KSn/ZcRbl7OQdQDGaEUGZkrEQ9dpWlp12oFZfTa5PJBB1x/9psVFvaY8ZdYsar7Z
//18MGuCm0eW3vZ+Mjkp9WvzsGmX4n9kXs5ln9F6eHs3ZhSQTSMd6e/SNBpwN5SR99
//FB7Cv0dJF3xHj7gb3oF6BNSRMc4ZFfSr84ONqg1EhUxmseFH3JhqT7dvoZ6jlhOV
//MwIgWu+PNIp20VZfD8h+sjOtgApaIhR61hNzK3ieJaXDi8leLlw7mU7mpGOLI61w
//rIoDtkFfnhhUBrTwXq2pG7gINIpZSN1kf2FY9keT1YtzzdCUsJcTtZIUqQIUGKX/
//DQIDAQAB
//-----END PUBLIC KEY-----'), OPENSSL_PKCS1_OAEP_PADDING);
    openssl_public_encrypt($content, $encrypted, openssl_pkey_get_public($key), OPENSSL_PKCS1_OAEP_PADDING);

    return base64_encode($encrypted);
}
