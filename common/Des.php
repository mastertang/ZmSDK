<?php

namespace ZmSDK\common;

/**
 * Class Des
 * @package ZmSDK\common
 */
class Des
{
    /**
     * Des加密
     *
     * @param $input
     * @return string
     */
    public static function encryptForDES($input,$desKey)
    {
        $data = openssl_encrypt(
            $input,
            'DES-ECB',
            $desKey,
            OPENSSL_RAW_DATA
        );
        $data = base64_encode($data);
        return $data;
    }

    /**
     * Des解密
     *
     * @param $input
     * @return string
     */
    public static function decryptForDES($input,$desKey)
    {
        $data = openssl_decrypt(
            base64_decode($input),
            'DES-ECB',
            $desKey,
            OPENSSL_RAW_DATA
        );
        return $data;
    }

}