<?php

namespace ZmSDK\src;

use ZmSDK\common\Common;
use ZmSDK\common\PictureTranfer;

/**
 * Class Distinguish
 * @package ZmSDK\client
 */
class PublicSecurity
{
    /**
     * 成功
     */
    const SR_SUCCESS = 0x1;

    /**
     * 不符合
     */
    const SR_IDENTITY_NOT_MATCH = 0x2;

    /**
     * 参数错误
     */
    const SR_PARAMS_ERROR = 0x3;

    /**
     * 其他错误
     */
    const SR_OTHER_ERROR = 0x4;

    /**
     * @var string 安全请求接口地址
     */
    protected $securityRequestUrl = "";

    /**
     * @var string 查询标签接口地址
     */
    protected $searchTagsUrl = "";

    /**
     * @var string 添加标签接口地址
     */
    protected $addTagsUrl = "";

    /**
     * @var int socket数据包长度
     */
    protected $picturePath = "";

    /**
     * @var string  请求的apiId
     */
    protected $apiId = "";

    /**
     * @var string 请求的apiSecret
     */
    protected $apiSecret = "";

    /**
     * @var string 请求商户id
     */
    protected $merchantId = "";

    /**
     * @var string 请求名称
     */
    protected $name = "";

    /**
     * @var string 请求字符串
     */
    protected $certNo = "";

    /**
     * @var string 图片内容
     */
    protected $pictureString = "";

    /**
     * @var string 请求的certSn
     */
    protected $certSn = "";

    /**
     * @var string 安全请求状态码
     */
    protected $srCode = "";

    /**
     * @var string 安全请求结果类型
     */
    protected $srCodeStatus = "";

    /**
     * @var string 安全请求结果
     */
    protected $srResult = "";

    /**
     * @var string 标签代码
     */
    protected $atTagCode = "";

    /**
     * @var string 标签来源
     */
    protected $atSourceFrom = "";

    /**
     * @var string 标签描述
     */
    protected $atDescription = "";

    /**
     * @var string 标签年份
     */
    protected $atBeforeYears = "0";

    /**
     * @var string 终端
     */
    protected $atTerminal = "";

    /**
     * @var string 错误信息
     */
    public $errorMessage = "";

    /**
     * 获取安全请求结果
     * @return string
     */
    public function srRequestResult()
    {
        return $this->srResult;
    }

    /**
     * 设置标签代码
     *
     * @param $tagCode
     * @return $this
     */
    public function atTagCode($tagCode)
    {
        $this->atTagCode = $tagCode;
        return $this;
    }

    /**
     * 设置来源
     *
     * @param $sourceFrom
     * @return $this
     */
    public function atSourceFrom($sourceFrom)
    {
        $this->atSourceFrom = $sourceFrom;
        return $this;
    }

    /**
     * 设置描述
     *
     * @param $description
     * @return $this
     */
    public function atDescription($description)
    {
        $this->atDescription = $description;
        return $this;
    }

    /**
     * 设置年份
     *
     * @param $beforeYears
     * @return $this
     */
    public function atBeforeYears($beforeYears)
    {
        $this->atBeforeYears = $beforeYears;
        return $this;
    }

    /**
     * 设置终端
     *
     * @param $terminal
     * @return $this
     */
    public function atTerminal($terminal)
    {
        $this->atTerminal = $terminal;
        return $this;
    }

    /**
     * @return string 获取安全请求码
     */
    public function getSrCode()
    {
        return $this->srCode;
    }

    /**
     * @return string 获取安全请求状态
     */
    public function getSrCodeStatus()
    {
        return $this->srCodeStatus;
    }

    /**
     * 设置安全请求地址
     *
     * @param $url
     * @return $this
     */
    public function securityRequestUrl($url)
    {
        $this->securityRequestUrl = $url;
        return $this;
    }

    /**
     * 设置图片路径
     *
     * @param $path
     * @return $this
     */
    public function picturePath($path)
    {
        $this->picturePath = $path;
        return $this;
    }

    /**
     * 设置apiId
     *
     * @param $apiId
     * @return $this
     */
    public function apiId($apiId)
    {
        $this->apiId = $apiId;
        return $this;
    }

    /**
     * 设置商户id
     *
     * @param $merchantId
     * @return $this
     */
    public function merchantId($merchantId)
    {
        $this->merchantId = $merchantId;
        return $this;
    }

    /**
     * 设置名称
     *
     * @param $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * 设置certNo
     *
     * @param $certNo
     * @return $this
     */
    public function certNo($certNo)
    {
        $this->certNo = $certNo;
        return $this;
    }

    /**
     * 设置apiSecret
     *
     * @param $apiSecret
     * @return $this
     */
    public function apiSecret($apiSecret)
    {
        $this->apiSecret = $apiSecret;
        return $this;
    }

    /**
     * 设置certSn
     *
     * @param $certSn
     * @return $this
     */
    public function certSn($certSn)
    {
        $this->certSn = $certSn;
        return $this;
    }

    /**
     * 设置文件内容
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
     * 设置添加标签接口地址
     *
     * @param $url
     * @return $this
     */
    public function addTagsUrl($url)
    {
        $this->addTagsUrl = $url;
        return $this;
    }

    /**
     * 查询标签接口地址
     *
     * @param $url
     * @return $this
     */
    public function searchTagsUrl($url)
    {
        $this->searchTagsUrl = $url;
        return $this;
    }

    /**
     * 安全请求
     *
     * @return bool|mixed
     */
    public function securityRequest()
    {
        $fileSize = filesize($this->picturePath);
        if ($fileSize === false) {
            $this->errorMessage = "图片路径错误或不存在! Path : {$this->picturePath}";
            return false;
        }
        if ($fileSize > 31000) {
            $pictureTranfer = new PictureTranfer();
            $newTempPath    = Common::changeFileName($this->picturePath, uniqid());
            $result         = $pictureTranfer->getPictureInfoByGd(
                $this->picturePath,
                $imageWith,
                $imageHeight
            );
            if ($result === false) {
                $this->errorMessage = $pictureTranfer->errorMessage;
                return false;
            }
            $radio       = $imageWith / $imageHeight;
            $imageWith   = $imageWith >= 150 ? 150 : $imageWith;
            $imageHeight = (int)($imageWith / $radio);
            $result      = $pictureTranfer->resizeImage($this->picturePath, $newTempPath, $imageWith, $imageHeight);
            if ($result === false) {
                $this->errorMessage = $pictureTranfer->errorMessage;
                return false;
            }
            $imageData = base64_encode(file_get_contents($newTempPath));
            if (is_file($newTempPath)) {
                unlink($newTempPath);
            }
        } else {
            $imageData = file_get_contents($this->picturePath);
        }
        $postData = [
            'apiId'            => $this->apiId,
            'requestId'        => Common::createNonceString(32),
            'accessMerchantId' => $this->merchantId,
            'name'             => base64_encode($this->name),
            'certNo'           => base64_encode($this->certNo),
            'imageContent'     => $imageData,
            'certSn'           => base64_encode($this->certSn),
            'timestamp'        => Common::getMillisecond()
        ];
        ksort($postData);
        $valueArray          = array_values($postData);
        $valueString         = implode('', $valueArray);
        $valueString         .= $this->apiSecret;
        $signature           = md5($valueString);
        $postData['apiSign'] = $signature;

        $result = Common::curlRequest(
            $this->securityRequestUrl,
            'POST',
            [],
            json_encode($postData),
            ["Content-type: application/json;charset='utf-8'"],
            5
        );
        if ($result === false) {
            $this->errorMessage = "请求安全接口失败!";
            return false;
        }
        $data = json_decode($result, true);
        if (empty($data) || !is_array($data) || !isset($data['code'])) {
            $this->errorMessage = $result;
            return false;
        }
        $this->srCode = $data['code'];
        $this->securityRequestCode($this->srCode);
        $this->srResult = $data;
        return true;
    }

    /**
     * 查询标签
     *
     * @return array|bool
     */
    public function searchTags()
    {
        $postData            = [
            'apiId'            => $this->apiId,
            'requestId'        => Common::createNonceString(32),
            'accessMerchantId' => $this->merchantId,
            'name'             => base64_encode($this->name),
            'certNo'           => base64_encode($this->certNo),
            'certSn'           => base64_encode($this->certSn),
            'timestamp'        => Common::getMillisecond()
        ];
        $postData['apiSign'] = $this->createSignature($postData);
        $result              = Common::curlRequest(
            $this->searchTagsUrl,
            'POST',
            [],
            json_encode($postData),
            ["Content-type: application/json;charset='utf-8'"],
            5
        );
        if ($result === false) {
            $this->errorMessage = "请求查询标签接口失败!";
            return false;
        }
        $data = json_decode($result, true);
        if (empty($data) || !is_array($data) || !isset($data['code']) || $data['code'] != 200) {
            $this->errorMessage = $result;
            return false;
        }
        return [
            "userId" => $data['object']['userId'],
            "tags"   => $data['object']['tags']
        ];
    }


    /**
     * 新增标签
     *
     * @return bool
     */
    public function addTags()
    {
        $postData            = [
            'apiId'            => $this->apiId,
            'accessMerchantId' => $this->merchantId,
            'faceImage'        => "",
            'name'             => base64_encode($this->name),
            'certNo'           => base64_encode($this->certNo),
            'tagCode'          => $this->atTagCode,
            'sourceFrom'       => $this->atSourceFrom,
            'description'      => $this->atDescription,
            'beforeYears'      => $this->atBeforeYears,
            'creator'          => $this->atTerminal,
        ];
        $postData['apiSign'] = $this->createSignature($postData);
        $result              = Common::curlRequest(
            $this->addTagsUrl,
            'POST',
            [],
            http_build_query($postData),
            ["Content-type: application/x-www-form-urlencoded;charset='utf-8'"],
            5
        );
        if ($result === false) {
            $this->errorMessage = "请求查询标签接口失败!";
            return false;
        }
        $data = json_decode($result, true);
        if (empty($data) || !is_array($data) || !isset($data['code']) || $data['code'] != 200) {
            $this->errorMessage = $result;
            return false;
        }
        return $data;
    }

    /**
     * 检查返回码的状态
     *
     * @param $code
     */
    protected function securityRequestCode($code)
    {
        if (in_array($code, [3014, 3017])) {
            $this->srCodeStatus = self::SR_IDENTITY_NOT_MATCH;
        } else if (in_array($code, [3012, 3013, 3016, 3018, 3020])) {
            $this->srCodeStatus = self::SR_PARAMS_ERROR;
        } else if ($code == 200) {
            $this->srCodeStatus = self::SR_SUCCESS;
        } else {
            $this->srCodeStatus = self::SR_OTHER_ERROR;
        }
    }

    /**
     * 创建签名
     *
     * @param $data
     * @return string
     */
    protected function createSignature($data)
    {
        ksort($data);
        $valueArray  = array_values($data);
        $valueString = implode('', $valueArray);
        $valueString .= $this->apiSecret;
        $signature   = md5($valueString);
        return $signature;
    }
}