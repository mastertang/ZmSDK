<?php

namespace ZmSDK\src;

/**
 * Class FaceClient
 * @package ZmSDK\client
 */
class FaceClient
{

    /**
     * @var null socket ip地址
     */
    protected $socketIp = null;

    /**
     * @var null socket 端口
     */
    protected $socketPort = null;

    /**
     * @var null socket 超时
     */
    protected $socketTimeOut = null;

    /**
     * @var null socket 包长度
     */
    protected $socketPackageLength = null;

    /**
     * 设置socket配置参数
     *
     * @param $ip
     * @param $port
     * @param $timeOut
     * @param $packageLength
     * @return $this
     */
    public function setSocketConfig($ip = null, $port = null, $timeOut = null, $packageLength = null)
    {
        $this->socketIp            = filter_var($ip, FILTER_VALIDATE_IP) ? $ip : null;
        $this->socketPort          = is_numeric($port) && $port >= 0 ? (int)$port : null;
        $this->socketTimeOut       = is_numeric($timeOut) && $timeOut >= 0 ? (int)$timeOut : null;
        $this->socketPackageLength = is_numeric($packageLength) && $packageLength >= 0 ? (int)$packageLength : null;;
        return $this;
    }

    /**
     * 重置sokcet配置参数
     *
     * @return $this
     */
    public function resetSocketConfig()
    {
        $this->socketIp            = null;
        $this->socketPort          = null;
        $this->socketTimeOut       = null;
        $this->socketPackageLength = null;
        return $this;
    }

    /**
     * 获取临时文件路径
     *
     * @return bool|string
     */
    public function getTempPicturePath(&$errorMessage)
    {
        $distinguish = new Distinguish();
        $result      = $distinguish->getTempPicturePath();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 保存临时文件
     *
     * @param $pictureName
     * @param string $picturePath
     * @param string $pictureString
     * @param string $errorMessage
     * @param string $pictureSuffix
     * @return bool
     */
    public function saveTempPicture(
        $pictureName,
        $picturePath = "",
        $pictureString = "",
        &$errorMessage = "success",
        $pictureSuffix = ""
    )
    {
        $distinguish = new Distinguish();
        $distinguish->pictureName($pictureName);
        if (!empty($picturePath)) {
            $distinguish->picturePath($picturePath);
        }
        if (!empty($pictureString)) {
            $distinguish->pictureString($pictureString);
        }
        if (!empty($pictureSuffix)) {
            $distinguish->pictureSuffix($pictureSuffix);
        }
        $result = $distinguish->saveTempPicture();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 人脸识别
     *
     * @param $picturePath
     * @param string $errorMessage
     * @return array|bool|mixed|null
     */
    public function faceDelection(
        $picturePath,
        &$errorMessage = "success"
    )
    {
        $distinguish = new Distinguish();
        if ($this->socketIp !== null) $distinguish->socketAddress($this->socketIp);
        if ($this->socketPort !== null) $distinguish->socketPort($this->socketPort);
        if ($this->socketTimeOut !== null) $distinguish->socketTimeOut($this->socketTimeOut);
        if ($this->socketPackageLength !== null) $distinguish->socketPackageLength($this->socketPackageLength);

        $result = $distinguish->picturePath($picturePath)->faceDelection();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 获取人脸特征
     *
     * @param $picturePath
     * @param string $errorMessage
     * @return array|bool|mixed|null
     */
    public function getFacialFeature(
        $picturePath,
        &$errorMessage = "success"
    )
    {
        $distinguish = new Distinguish();
        if ($this->socketIp !== null) $distinguish->socketAddress($this->socketIp);
        if ($this->socketPort !== null) $distinguish->socketPort($this->socketPort);
        if ($this->socketTimeOut !== null) $distinguish->socketTimeOut($this->socketTimeOut);
        if ($this->socketPackageLength !== null) $distinguish->socketPackageLength($this->socketPackageLength);

        $result = $distinguish->picturePath($picturePath)->getFacialFeature();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 特征码比对
     *
     * @param $facialFeature1
     * @param $featureSize1
     * @param $facialFeature2
     * @param $featureSize2
     * @param string $errorMessage
     * @return bool
     */
    public function faceContrastWithFF(
        $facialFeature1,
        $featureSize1,
        $facialFeature2,
        $featureSize2,
        &$errorMessage = ""
    )
    {
        $distinguish = new Distinguish();
        if ($this->socketIp !== null) $distinguish->socketAddress($this->socketIp);
        if ($this->socketPort !== null) $distinguish->socketPort($this->socketPort);
        if ($this->socketTimeOut !== null) $distinguish->socketTimeOut($this->socketTimeOut);
        if ($this->socketPackageLength !== null) $distinguish->socketPackageLength($this->socketPackageLength);

        $result = $distinguish
            ->facialFeatures($facialFeature1, $featureSize1, $facialFeature2, $featureSize2)
            ->faceContrastWithTwoFacialFeature();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 特征码和图片比对
     *
     * @param $facialFeature1
     * @param $featureSize1
     * @param $imagePath
     * @param string $errorMessage
     * @return array|bool|mixed|null
     */
    public function faceContrastWithFP(
        $facialFeature1,
        $featureSize1,
        $imagePath,
        &$errorMessage = ""
    )
    {
        $distinguish = new Distinguish();
        if ($this->socketIp !== null) $distinguish->socketAddress($this->socketIp);
        if ($this->socketPort !== null) $distinguish->socketPort($this->socketPort);
        if ($this->socketTimeOut !== null) $distinguish->socketTimeOut($this->socketTimeOut);
        if ($this->socketPackageLength !== null) $distinguish->socketPackageLength($this->socketPackageLength);

        $result = $distinguish
            ->picturePath($imagePath)
            ->facialFeatures($facialFeature1, $featureSize1)
            ->faceContrastWithFacialFeatureAndPicture();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 负载平衡获取头像特征码
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $lbGetFacialFeatureUrl
     * @param $imageData
     * @param string $errorMessage
     * @return bool|mixed
     */
    public function LBGetFacialFeature(
        $accessKeyId,
        $accessKeySecret,
        $lbGetFacialFeatureUrl,
        $imageData,
        &$errorMessage = ""
    )
    {
        $distinguish = new Distinguish();
        $result      = $distinguish
            ->lbAccessKeyId($accessKeyId)
            ->lbAcessKeySecret($accessKeySecret)
            ->lbGetFacialFeaturesUrl($lbGetFacialFeatureUrl)
            ->pictureString($imageData)
            ->LBGetFacialFeature();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 负载均衡人脸框识别
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $lbFaceDetectionUrl
     * @param $picturePath
     * @param string $errorMessage
     * @return bool|mixed
     */
    public function LBFaceDelection(
        $accessKeyId,
        $accessKeySecret,
        $lbFaceDetectionUrl,
        $picturePath,
        &$errorMessage = ""
    )
    {
        $distinguish = new Distinguish();
        $result      = $distinguish
            ->lbAccessKeyId($accessKeyId)
            ->lbAcessKeySecret($accessKeySecret)
            ->lbFaceDetectionUrl($lbFaceDetectionUrl)
            ->picturePath($picturePath)
            ->LBFaceDetection();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 负载均衡特征码比对
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $lbTwoFacialFeatureContrastUrl
     * @param string $errorMessage
     * @return bool|mixed
     */
    public function LBFaceContrastWithTwoFacialFeature(
        $accessKeyId,
        $accessKeySecret,
        $lbTwoFacialFeatureContrastUrl,
        $facialFeature1,
        $featureSize1,
        $facialFeature2,
        $featureSize2,
        &$errorMessage = ""
    )
    {
        $distinguish = new Distinguish();
        $result      = $distinguish
            ->lbAccessKeyId($accessKeyId)
            ->lbAcessKeySecret($accessKeySecret)
            ->lbTwoFacialFeatureContrastUrl($lbTwoFacialFeatureContrastUrl)
            ->facialFeatures($facialFeature1, $featureSize1, $facialFeature2, $featureSize2)
            ->LBFaceContrastWithFacialFeature();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 负载均衡特征码和图片比对
     *
     * @param $accessKeyId
     * @param $accessKeySecret
     * @param $lbFacialFeatureAndImageContrastUrl
     * @param $facialFeature1
     * @param $featureSize1
     * @param $picturePath
     * @param string $errorMessage
     * @return bool|mixed
     */
    public function LBFaceContrastWithFacialFeatureAndPicture(
        $accessKeyId,
        $accessKeySecret,
        $lbFacialFeatureAndImageContrastUrl,
        $facialFeature1,
        $featureSize1,
        $picturePath,
        &$errorMessage = ""
    )
    {
        $distinguish = new Distinguish();
        $result      = $distinguish
            ->lbAccessKeyId($accessKeyId)
            ->lbAcessKeySecret($accessKeySecret)
            ->lbFacialFeatureAndImageContrastUrl($lbFacialFeatureAndImageContrastUrl)
            ->facialFeatures($facialFeature1, $featureSize1)
            ->picturePath($picturePath)
            ->LBFaceContrastWithFacialFeatureAndPicture();
        if ($result === false) {
            $errorMessage = $distinguish->errorMessage;
            return false;
        }
        return $result;
    }
}