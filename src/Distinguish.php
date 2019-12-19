<?php

namespace ZmSDK\src;

use ZmSDK\common\Common;
use ZmSDK\common\Des;
use ZmSDK\common\PictureTranfer;

/**
 * Class Distinguish
 * @package ZmSDK\client
 */
class Distinguish
{
    /**
     * @var string 临时图片文件夹
     */
    protected static $tempPicturePath = "./resource/temp";

    /**
     * @var string 图片名字，保存图片使用
     */
    protected $pictureName = "";

    /**
     * @var string 图片字符串内容
     */
    protected $pictureString = "";

    /**
     * @var string 图片路径
     */
    protected $picturePath = "";

    /**
     * @var string 保存图片后缀
     */
    protected $pictureSuffix = "";

    /**
     * @var array 人脸特征码
     *  [
     *     [特征码, 特征码1的长度],
     *     [特征码2, 特征码2的长度]
     *  ]
     */
    protected $facialFeatures = [];

    /**
     * @var string 负载均衡获取人脸特征接口地址
     */
    protected $lbGetFacialFeaturesUrl = "";

    /**
     * @var string 负载均衡两特征码比对接口地址
     */
    protected $lbTwoFacialFeatureContrastUrl = "";

    /**
     * @var string 负载均衡特征码和图片比对接口地址
     */
    protected $lbFacialFeatureAndImageContrastUrl = "";

    /**
     * @var string 负载均衡人脸识别
     */
    protected $lbFaceDetectionUrl = "";

    /**
     * @var string 负载均衡访问id
     */
    protected $lbAccessKeyId = "";

    /**
     * @var string 负载均衡访问密钥
     */
    protected $lbAccessKeySecret = "";

    /**
     * @var string socket连接ip地址
     */
    protected $socketAddress = "127.0.0.1";

    /**
     * @var string socket连接端口
     */
    protected $socketPort = "6666";

    /**
     * @var int socket超时(单位:秒)
     */
    protected $socketTimeOut = 10;

    /**
     * @var int socket数据包长度
     */
    protected $socketPackageLength = 4096;

    /**
     * @var string 错误信息
     */
    public $errorMessage = "";

    /**
     * socket包长度
     *
     * @param $socketPackageLength
     * @return $this
     */
    public function socketPackageLength($socketPackageLength)
    {
        $this->socketPackageLength = $socketPackageLength;
        return $this;
    }

    /**
     * 设置socket过期
     *
     * @param $timeOut
     * @return $this
     */
    public function socketTimeOut($timeOut)
    {
        $this->socketTimeOut = $timeOut;
        return $this;
    }

    /**
     * 设置socket连接端口
     *
     * @param $port
     * @return $this
     */
    public function socketPort($port)
    {
        $this->socketPort = $port;
        return $this;
    }

    /**
     * 设置socket的地址
     *
     * @param $ip
     * @return $this
     */
    public function socketAddress($ip)
    {
        $this->socketAddress = $ip;
        return $this;
    }

    /**
     * 设置负载均衡访问id
     *
     * @param $keyId
     * @return $this
     */
    public function lbAccessKeyId($keyId)
    {
        $this->lbAccessKeyId = $keyId;
        return $this;
    }

    /**
     * 设置负载均衡访问密钥
     *
     * @param $keySecret
     * @return $this
     */
    public function lbAcessKeySecret($keySecret)
    {
        $this->lbAccessKeySecret = $keySecret;
        return $this;
    }

    /**
     * 设置lbGetFacialFeaturesUrl
     * @param $url
     * @return $this
     */
    public function lbGetFacialFeaturesUrl($url)
    {
        $this->lbGetFacialFeaturesUrl = $url;
        return $this;
    }

    /**
     * 设置lbTwoFacialFeatureContrastUrl
     * @param $url
     * @return $this
     */
    public function lbTwoFacialFeatureContrastUrl($url)
    {
        $this->lbTwoFacialFeatureContrastUrl = $url;
        return $this;
    }

    /**
     * 设置lbFacialFeatureAndImageContrastUrl
     * @param $url
     * @return $this
     */
    public function lbFacialFeatureAndImageContrastUrl($url)
    {
        $this->lbFacialFeatureAndImageContrastUrl = $url;
        return $this;
    }

    /**
     * 设置lbFaceDetectionUrl
     * @param $url
     * @return $this
     */
    public function lbFaceDetectionUrl($url)
    {
        $this->lbFaceDetectionUrl = $url;
        return $this;
    }

    /**
     * 设置图片名字
     *
     * @param $pictureName
     * @return $this
     */
    public function pictureName($pictureName)
    {
        $this->pictureName = $pictureName;
        return $this;
    }

    /**
     * 设置图片内容
     *
     * @param $pictureString
     * @return $this
     */
    public function pictureString($pictureString)
    {
        $this->pictureString = $pictureString;
        return $this;
    }

    /**
     * 设置图片路径地址
     *
     * @param $picturePath
     * @return $this
     */
    public function picturePath($picturePath)
    {
        if (is_file($picturePath)) {
            $this->pictureString = $picturePath;
        }
        return $this;
    }

    /**
     * 设置pictureSuffix
     *
     * @param $pictureSuffix
     * @return $this
     */
    public function pictureSuffix($pictureSuffix)
    {
        $this->pictureSuffix = $pictureSuffix;
        return $this;
    }

    /**
     * 设置人脸特征
     *
     * @param $facialFeature1
     * @param $featureSize1
     * @param string $facialFeature2
     * @param int $featureSize2
     * @return $this
     */
    public function facialFeatures(
        $facialFeature1,
        $featureSize1,
        $facialFeature2 = "",
        $featureSize2 = 0
    )
    {
        $this->facialFeatures = [[$facialFeature1, $featureSize1]];
        if (!empty($facialFeature2) && !empty($featureSize2)) {
            $this->facialFeatures[] = [$facialFeature2, $featureSize2];
        }
        return $this;
    }

    /**
     * 获取临时图片地址
     *
     * @return string
     */
    public function getTempPicturePath()
    {
        if (!is_dir(self::$tempPicturePath)) {
            if (!mkdir(self::$tempPicturePath, 0775, true)) {
                $this->errorMessage = "创建文件夹失败!";
                return false;
            }
        }
        return self::$tempPicturePath;
    }

    /**
     * 保存临时图片
     *
     * @return bool|string
     */
    public function saveTempPicture()
    {
        $pictureTranfer = new PictureTranfer();
        $pictureName    = $this->pictureName;
        $suffix         = $this->pictureSuffix;
        if (empty($this->pictureSuffix)) {
            $suffix = $pictureTranfer->getPictureSuffix(
                !empty($this->pictureString) ? $this->pictureString : $this->picturePath
            );
            if ($suffix === false) {
                $this->errorMessage = $pictureTranfer->errorMessage;
                return false;
            }
        }
        $pictureName = "{$pictureName}.{$suffix}";

        if (($picturePath = $this->getTempPicturePath()) === false) return false;
        $picturePath .= "/{$pictureName}";
        if (($result = $pictureTranfer->getPictureInfoByGd(
                !empty($this->pictureString) ? $this->pictureString : $this->picturePath,
                $imageWidth,
                $imageHeight
            )) === false) {
            $this->errorMessage = $pictureTranfer->errorMessage;
            return false;
        }
        if (file_put_contents(
                $picturePath,
                !empty($this->pictureString) ? $this->pictureString : file_get_contents($this->picturePath)
            ) === false) {
            $this->errorMessage = "保存临时文件失败";
            return false;
        }
        if ($imageWidth % 4 > 0 || $imageHeight % 2 > 0) {
            if ($imageWidth % 4 > 0) {
                $imageWidth += (4 - $imageWidth % 4);
            }
            if ($imageHeight % 2 > 0) {
                $imageHeight += (2 - $imageHeight % 2);
            }
            $result = $pictureTranfer->resizeImage(
                $picturePath,
                $picturePath,
                $imageWidth,
                $imageHeight,
                null,
                100
            );
            if ($result == false) {
                $this->errorMessage = $pictureTranfer->errorMessage;
                if (is_file($picturePath)) {
                    unlink($picturePath);
                }
                return false;
            }
        }
        return $picturePath;
    }

    /**
     * 使用ffmpeg将图片转为yuv
     *
     * @return bool|string
     */
    public function movePictureToYuv()
    {
        $yuvPath = Common::changeFileSuffix($this->picturePath, "yuv");
        $command = "ffmpeg -i " . $this->picturePath . " -pix_fmt yuvj420p " . $yuvPath;
        exec($command, $output, $result);
        if ($result !== 0) {
            $this->errorMessage = "FFmpeg转Yuv失败! Result : {$result}";
            return false;
        }
        return $yuvPath;
    }

    /**
     * 获取人脸特征
     *
     * @return array|bool|mixed|null
     */
    public function getFacialFeature()
    {
        $pictureTranfer = new PictureTranfer();
        if (($result = $pictureTranfer->getPictureInfoByGd(
                $this->picturePath,
                $imageWidth,
                $imageHeight
            )) === false) {
            $this->errorMessage = $pictureTranfer->errorMessage;
            return false;
        }

        $yuvPath = $this->movePictureToYuv();
        if ($yuvPath === false) {
            return false;
        }
        $command       = "0|{$yuvPath}|{$imageWidth}|{$imageHeight}";
        $commandResult = $this->faceSocketServer($command);
        if ($commandResult === false) {
            return false;
        }
        $commandResultData = json_decode($commandResult, true);
        unlink($yuvPath);
        if (!is_array($commandResultData) || empty($commandResultData) || $commandResultData === false) {
            $this->errorMessage = $commandResult;
            return false;
        }
        return $commandResultData;
    }

    /**
     * 人脸识别
     *
     * @return bool|mixed
     */
    public function faceDelection()
    {
        $pictureTranfer = new PictureTranfer();
        if (($result = $pictureTranfer->getPictureInfoByGd(
                $this->picturePath,
                $imageWidth,
                $imageHeight
            )) === false) {
            $this->errorMessage = $pictureTranfer->errorMessage;
            return false;
        }

        $yuvPath = $this->movePictureToYuv();
        if ($yuvPath === false) {
            return false;
        }
        $command       = "1|{$yuvPath}|{$imageWidth}|{$imageHeight}";
        $commandResult = $this->faceSocketServer($command);
        if ($commandResult === false) {
            return false;
        }
        $commandResultData = json_decode($commandResult, true);
        unlink($yuvPath);
        if (!is_array($commandResultData) || empty($commandResultData) || $commandResultData === false) {
            $this->errorMessage = $commandResult;
            return false;
        }
        return $commandResultData;
    }

    /**
     * 两特征值比对
     *
     * @return bool
     */
    public function faceContrastWithTwoFacialFeature()
    {
        if (!isset(
            $this->facialFeatures[0][0],
            $this->facialFeatures[0][1],
            $this->facialFeatures[1][0],
            $this->facialFeatures[1][1]
        )) {
            $this->errorMessage = "比对特征码设置错误!";
            return false;
        }
        $command = implode("|", array_merge(
            [2],
            $this->facialFeatures[0][0],
            $this->facialFeatures[0][1],
            $this->facialFeatures[1][0],
            $this->facialFeatures[1][1]
        ));

        if (strlen($command) <= 2000) {
            $this->errorMessage = "比对特征码设置错误!";
            return false;
        }
        $faceCompareValue = $this->faceSocketServer($command);
        if ($faceCompareValue === false) {
            return false;
        }
        $faceCompareValue = json_decode($faceCompareValue, true);
        if ($faceCompareValue === false || !isset($pictureFeatureResult["compareValue"])) {
            $this->errorMessage = $faceCompareValue;
            return false;
        }
        $pictureFeatureResult["compareValue"] = (float)$faceCompareValue["compareValue"] * 100;
        return $pictureFeatureResult;
    }

    /**
     * 人脸对比,特征码和图片
     *
     * @return array|bool|mixed|null
     */
    public function faceContrastWithFacialFeatureAndPicture()
    {
        $pictureFeatureResult = $this->getFacialFeature();
        if ($pictureFeatureResult === false) {
            return false;
        }
        if (!isset($this->facialFeatures[0][0], $this->facialFeatures[0][1])) {
            $this->errorMessage = "比对特征码设置错误!";
            return false;
        }
        $command = implode("|", [
            "2",
            $this->facialFeatures[0][0],
            $this->facialFeatures[0][1],
            $pictureFeatureResult["feature"],
            $pictureFeatureResult["featureSize"]
        ]);
        if (strlen($command) <= 2000) {
            $this->errorMessage = "比对特征码设置错误!";
            return false;
        }
        $faceCompareValue = self::faceSocketServer($command);
        if ($faceCompareValue === false) {
            return false;
        }
        $faceCompareValue = json_decode($faceCompareValue, true);
        if ($faceCompareValue === false || !isset($pictureFeatureResult["compareValue"])) {
            $this->errorMessage = $faceCompareValue;
            return false;
        }
        $pictureFeatureResult["compareValue"] = (float)$faceCompareValue["compareValue"] * 100;
        return $pictureFeatureResult;
    }

    /**
     * 负载均衡获取人脸特征码
     *
     * @return bool|mixed
     */
    public function LBGetFacialFeature()
    {
        $pictureTranfer = new PictureTranfer();
        if (($pictureTranfer->getPictureInfoByGd($this->pictureString)) === false) {
            $this->errorMessage = $pictureTranfer->errorMessage;
            return false;
        }
        $data                     = [
            "imageData"        => $this->pictureString,
            "key"              => $this->lbAccessKeyId,
            "requestTimeStamp" => Common::getMillisecond(),
        ];
        $signature                = Des::encryptForDES($this->createLBSignature($data), $this->lbAccessKeySecret);
        $data["imageData"]        = Des::encryptForDES($data["imageData"], $this->lbAccessKeySecret);
        $data["requestTimeStamp"] = Des::encryptForDES($data["requestTimeStamp"], $this->lbAccessKeySecret);

        $result = Common::curlRequest(
            $this->lbGetFacialFeaturesUrl,
            "POST",
            [],
            $data,
            ["Accept-signkey:{$signature}"]
        );
        if ($result === false) {
            $this->errorMessage = "请求LB获取特征码失败!";
            return false;
        }
        $responseData = json_decode($result, true);
        if (!is_array($responseData)
            || !isset($responseData["status"], $responseData["message"], $responseData["data"])
            || $responseData["status"] !== 0) {
            $this->errorMessage = $result;
            return false;
        }
        return $responseData["data"];
    }

    /**
     * 负载均衡获取人脸框
     *
     * @return bool|mixed
     */
    public function LBFaceDetection()
    {
        $pictureTranfer = new PictureTranfer();
        if (($pictureTranfer->getPictureInfoByGd($this->pictureString)) === false) {
            $this->errorMessage = $pictureTranfer->errorMessage;
            return false;
        }
        $data                     = [
            "imageData"        => $this->pictureString,
            "key"              => $this->lbAccessKeyId,
            "requestTimeStamp" => Common::getMillisecond(),
        ];
        $signature                = Des::encryptForDES($this->createLBSignature($data), $this->lbAccessKeySecret);
        $data["imageData"]        = Des::encryptForDES($data["imageData"], $this->lbAccessKeySecret);
        $data["requestTimeStamp"] = Des::encryptForDES($data["requestTimeStamp"], $this->lbAccessKeySecret);

        $result = Common::curlRequest(
            $this->lbFaceDetectionUrl,
            "POST",
            [],
            $data,
            ["Accept-signkey:{$signature}"]
        );
        if ($result === false) {
            $this->errorMessage = "请求LB获取人脸框失败!";
            return false;
        }
        $responseData = json_decode($result, true);
        if (!is_array($responseData)
            || !isset($responseData["status"], $responseData["message"], $responseData["data"])
            || $responseData["status"] !== 0) {
            $this->errorMessage = $result;
            return false;
        }
        return $responseData["data"];
    }

    /**
     * 负载均衡人脸特征比对
     *
     * @return bool|mixed
     */
    public function LBFaceContrastWithFacialFeature()
    {
        if (!isset($this->facialFeatures[0][0], $this->facialFeatures[0][1], $this->facialFeatures[1][0], $this->facialFeatures[1][1])
            || empty($this->facialFeatures[0][0])
            || empty($this->facialFeatures[1][0])
            || !is_numeric($this->facialFeatures[0][1])
            || !is_numeric($this->facialFeatures[1][1])) {
            $this->errorMessage = "人脸特征比对数组设置错误!";
            return false;
        }
        $data                     = [
            "facialFeature1"   => $this->facialFeatures[0][0],
            "featureSize1"     => $this->facialFeatures[0][1],
            "facialFeature2"   => $this->facialFeatures[1][0],
            "featureSize2"     => $this->facialFeatures[1][1],
            "key"              => $this->lbAccessKeyId,
            "requestTimeStamp" => Common::getMillisecond(),
        ];
        $signature                = Des::encryptForDES($this->createLBSignature($data), $this->lbAccessKeySecret);
        $data["facialFeature1"]   = Des::encryptForDES($data["facialFeature1"], $this->lbAccessKeySecret);
        $data["featureSize1"]     = Des::encryptForDES($data["featureSize1"], $this->lbAccessKeySecret);
        $data["facialFeature2"]   = Des::encryptForDES($data["facialFeature2"], $this->lbAccessKeySecret);
        $data["featureSize2"]     = Des::encryptForDES($data["featureSize2"], $this->lbAccessKeySecret);
        $data["requestTimeStamp"] = Des::encryptForDES($data["requestTimeStamp"], $this->lbAccessKeySecret);

        $result = Common::curlRequest(
            $this->lbTwoFacialFeatureContrastUrl,
            "POST",
            [],
            $data,
            ["Accept-signkey:{$signature}"]
        );
        if ($result === false) {
            $this->errorMessage = "请求LB特征码比对失败!";
            return false;
        }
        $responseData = json_decode($result, true);
        if (!is_array($responseData)
            || !isset($responseData["status"], $responseData["message"], $responseData["data"])
            || $responseData["status"] !== 0) {
            $this->errorMessage = $result;
            return false;
        }
        return $responseData["data"];
    }

    /**
     * 负载均衡人脸特征和图片比对
     *
     * @return bool|mixed
     */
    public function LBFaceContrastWithFacialFeatureAndPicture()
    {
        if (!isset($this->facialFeatures[0][0], $this->facialFeatures[0][1])
            || empty($this->facialFeatures[0][0])
            || !is_numeric($this->facialFeatures[0][1])) {
            $this->errorMessage = "人脸特征比对数组设置错误!";
            return false;
        }
        $data                     = [
            "facialFeature1"   => $this->facialFeatures[0][0],
            "featureSize1"     => $this->facialFeatures[0][1],
            "imageData"        => $this->pictureString,
            "key"              => $this->lbAccessKeyId,
            "requestTimeStamp" => Common::getMillisecond(),
        ];
        $signature                = Des::encryptForDES($this->createLBSignature($data), $this->lbAccessKeySecret);
        $data["facialFeature1"]   = Des::encryptForDES($data["facialFeature1"], $this->lbAccessKeySecret);
        $data["featureSize1"]     = Des::encryptForDES($data["featureSize1"], $this->lbAccessKeySecret);
        $data["imageData"]        = Des::encryptForDES($data["imageData"], $this->lbAccessKeySecret);
        $data["requestTimeStamp"] = Des::encryptForDES($data["requestTimeStamp"], $this->lbAccessKeySecret);

        $result = Common::curlRequest(
            $this->lbFacialFeatureAndImageContrastUrl,
            "POST",
            [],
            $data,
            ["Accept-signkey:{$signature}"]
        );
        if ($result === false) {
            $this->errorMessage = "请求LB特征码和图片比对失败!";
            return false;
        }
        $responseData = json_decode($result, true);
        if (!is_array($responseData)
            || !isset($responseData["status"], $responseData["message"], $responseData["data"])
            || $responseData["status"] !== 0) {
            $this->errorMessage = $result;
            return false;
        }
        return $responseData["data"];
    }

    /**
     * 创建负载均衡生成签名
     *
     * @param $data
     * @return string
     */
    protected function createLBSignature($data)
    {
        ksort($data);
        $string = "";
        foreach ($data as $key => $value) {
            $string .= "@#%{$key}=$value";
        }
        $string = substr($string, 1);
        return sha1($string);
    }

    /**
     * 人脸识别服务
     *
     * @param $message
     * @return bool|string
     */
    protected function faceSocketServer($message)
    {
        try {
            $timeOut             = $this->socketTimeOut;
            $socketPackageLength = $this->socketPackageLength;
            $socket              = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
            socket_set_option($socket, SOL_SOCKET, SO_RCVTIMEO, array("sec" => 1, "usec" => 0));
            socket_set_option($socket, SOL_SOCKET, SO_SNDTIMEO, array("sec" => 6, "usec" => 0));
            if (socket_connect($socket, $this->socketAddress, $this->socketPort) == false) {
                $this->errorMessage = socket_strerror(socket_last_error());
                return false;
            } else {
                $length = "" . strlen($message);
                $result = socket_write($socket, $length, strlen($length));
                if ($result === false) {
                    $this->errorMessage = socket_strerror(socket_last_error());
                    socket_close($socket);
                    return false;
                }
                $data = socket_read($socket, 7);
                if ($data === false) {
                    $this->errorMessage = socket_strerror(socket_last_error());
                    socket_close($socket);
                    return false;
                }
                if ($data == "success") {
                    if ($length > $socketPackageLength) {
                        $stringArray = str_split($message, $socketPackageLength);
                        foreach ($stringArray as $msg) {
                            $result = socket_write($socket, $msg, strlen($msg));
                            if ($result === false) {
                                $this->errorMessage = socket_strerror(socket_last_error());
                                socket_close($socket);
                                return false;
                            }
                        }
                    } else {
                        $result = socket_write($socket, $message, strlen($message));
                        if ($result === false) {
                            $this->errorMessage = socket_strerror(socket_last_error());
                            socket_close($socket);
                            return false;
                        }
                    }

                    $data = socket_read($socket, $socketPackageLength);
                    if ($data === false) {
                        $this->errorMessage = socket_strerror(socket_last_error());
                        socket_close($socket);
                        return false;
                    }
                    $returnMsgLength = (int)$data;
                    if ($returnMsgLength > 0) {
                        $result = socket_write($socket, "success", 7);
                        if ($result === false) {
                            $this->errorMessage = socket_strerror(socket_last_error());
                            socket_close($socket);
                            return false;
                        }
                        $newString = "";
                        $nowStamp  = time();
                        while (strlen($newString) < $returnMsgLength) {
                            $data = socket_read($socket, $returnMsgLength);
                            if ($data === false) {
                                $this->errorMessage = $newString;
                                $newString          = false;
                                break;
                            }
                            if (strlen($data) > 0) {
                                $newString .= $data;
                            }
                            if ((time() - $nowStamp) > $timeOut) {
                                $this->errorMessage = $newString;
                                $newString          = false;
                                break;
                            }
                        }
                        if ($newString === false) {
                            $this->errorMessage = socket_strerror(socket_last_error());
                            socket_close($socket);
                            return false;
                        }
                        socket_close($socket);
                        return $newString;
                    } else {
                        $this->errorMessage = socket_strerror(socket_last_error());
                        socket_close($socket);
                        return false;
                    }
                } else {
                    $this->errorMessage = socket_strerror(socket_last_error());
                    socket_close($socket);
                    return $data;
                }
            }
        } catch (\Exception $exception) {
            $this->errorMessage = $exception->getMessage();
            socket_close($socket);
            return false;
        }
    }
}