<?php

namespace ZmSDK\common;

/**
 * Class Common
 * @package ZmSDK\common
 */
class Common
{
    /**
     * 分离base64图片的头和内容
     *
     * @param $base64String
     * @param $body
     * @param $head
     * @return bool
     */
    public static function splitBase64StringHeadAndBody($base64String, &$body, &$head)
    {
        $head = substr($base64String, 0, strpos($base64String, ',') + 1);
        $body = substr($base64String, strpos($base64String, ',') + 1);
        return true;
    }

    /**
     * 修改文件名字
     *
     * @param $filePath
     * @param $newName
     * @param bool $suffix
     * @return string
     */
    public static function changeFileName($filePath, $newName, $suffix = true)
    {
        $oldName = basename($filePath);
        $dir     = substr($filePath, 0, strrpos($filePath, $oldName));
        if ($dir{strlen($dir) - 1} != DIRECTORY_SEPARATOR) {
            $dir .= DIRECTORY_SEPARATOR;
        }
        if ($suffix) {
            $lastPosition = strrpos($oldName, '.');
            if ($lastPosition !== false) {
                $oldSuffix = substr($oldName, $lastPosition);
            } else {
                $oldSuffix = '';
            }
            return $dir . $newName . $oldSuffix;
        } else {
            return $dir . $newName;
        }
    }

    /**
     * 修改文件后缀
     *
     * @param $filePath
     * @param $newSuffix
     * @return bool|string
     */
    public static function changeFileSuffix($filePath, $newSuffix)
    {
        $baseName    = basename($filePath);
        $lastDsIndex = strrpos($filePath, DIRECTORY_SEPARATOR);
        if ($lastDsIndex === false || $lastDsIndex == (strlen($filePath) - 1)) {
            return false;
        }
        $dir        = substr($filePath, 0, $lastDsIndex + 1);
        $pointIndex = strrpos($baseName, '.');
        if ($pointIndex === false) {
            return $dir . $baseName . ".{$newSuffix}";
        } else {
            $baseName = substr($baseName, 0, $pointIndex);
            return $dir . $baseName . ".{$newSuffix}";
        }
    }

    /**
     * 获取毫秒时间戳
     *
     * @return int
     */
    public static function getMillisecond()
    {
        list($msec, $sec) = explode(' ', microtime());
        $msectime = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);
        return $msectimes = (int)substr($msectime, 0, 13);
    }

    /**
     * curl请求
     *
     * @param $host
     * @param $method
     * @param $querys
     * @param $body
     * @param $headers
     * @param int $timeOut
     * @return bool|mixed
     */
    public static function curlRequest($host, $method = "POST", $querys = [], $body = [], $headers = [], $timeOut = 5)
    {
        $url  = self::urlAppend($host, $querys);
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_FAILONERROR, false);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_TIMEOUT, $timeOut);
        if (1 == strpos("$" . $host, "https://")) {
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
        }
        if (strtoupper($method) == 'POST') {
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
        }
        $dataString = curl_exec($curl);
        $errorCode  = curl_errno($curl);
        if (empty($dataString))
            return false;
        else {
            if ($errorCode === 0) {
                return $dataString;
            } else {
                return false;
            }
        }
    }

    /**
     * 生成随机数
     *
     * @param int $length
     * @return string
     */
    public static function createNonceString($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $nonce = '';
        for ($i = 0; $i < $length; $i++) {
            $nonce .= $chars{rand(0, 61)};
        }
        return $nonce;
    }

    /**
     * 地址参数扩展
     *
     * @param $url
     * @param $data
     * @return string
     */
    public static function urlAppend($url, $data)
    {
        if (!is_array($data) || empty($data)) {
            return $url;
        }
        $query = urldecode(http_build_query($data));
        $url   .= (strpos($url, '?') === false) ? "?{$query}" : "&{$query}";
        return $url;
    }
}