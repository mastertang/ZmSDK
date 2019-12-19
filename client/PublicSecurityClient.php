<?php

namespace ZmSDK\src;

/**
 * Class PublicSecurityClient
 * @package ZmSDK\client
 */
class PublicSecurityClient
{
    /**
     * @var string 请求appid
     */
    protected $appId = "";

    /**
     * @var string 请求secret
     */
    protected $appSecret = "";

    /**
     * @var string 请求certSn
     */
    protected $certSn = "";

    /**
     * 设置配置
     *
     * @param $appId
     * @param $appSecret
     * @param $certSn
     * @return $this
     */
    public function setConfig($appId, $appSecret, $certSn)
    {
        $this->appId     = $appId;
        $this->appSecret = $appSecret;
        $this->certSn    = $certSn;
        return $this;
    }

    /**
     * 重置配置参数
     *
     * @return $this
     */
    public function resetConfig()
    {
        $this->appId     = "";
        $this->appSecret = "";
        $this->certSn    = "";
        return $this;
    }

    /**
     * 安全接口请求
     *
     * @param $securityRequestUrl
     * @param $picturePath
     * @param $merchantId
     * @param $name
     * @param $certNo
     * @param string $errorMessage
     * @return bool|mixed
     */
    public function securityRequest(
        $securityRequestUrl,
        $picturePath,
        $merchantId,
        $name,
        $certNo,
        &$errorMessage = "success"
    )
    {
        $publicSecurity = new PublicSecurity();
        $result         = $publicSecurity
            ->apiId($this->appId)
            ->apiSecret($this->appSecret)
            ->certSn($this->certSn)
            ->securityRequestUrl($securityRequestUrl)
            ->merchantId($merchantId)
            ->name($name)
            ->certNo($certNo)
            ->picturePath($picturePath)
            ->securityRequest();
        if ($result === false) {
            $errorMessage = $publicSecurity->errorMessage;
            return false;
        }
        return $publicSecurity;
    }

    /**
     * 查询标签
     *
     * @param $searchTagsUrl
     * @param $merchantId
     * @param $name
     * @param $certNo
     * @param string $errorMessage
     * @return array|bool
     */
    public function searchTags(
        $searchTagsUrl,
        $merchantId,
        $name,
        $certNo,
        &$errorMessage = "success"
    )
    {
        $publicSecurity = new PublicSecurity();
        $result         = $publicSecurity
            ->apiId($this->appId)
            ->apiSecret($this->appSecret)
            ->certSn($this->certSn)
            ->searchTagsUrl($searchTagsUrl)
            ->merchantId($merchantId)
            ->name($name)
            ->certNo($certNo)
            ->searchTags();
        if ($result === false) {
            $errorMessage = $publicSecurity->errorMessage;
            return false;
        }
        return $result;
    }

    /**
     * 新增标签
     *
     * @param $addTagsUrl
     * @param $merchantId
     * @param $name
     * @param $certNo
     * @param $tagCode
     * @param $sourceFrom
     * @param $beforeYears
     * @param $terminal
     * @param $description
     * @param string $errorMessage
     * @return array|bool
     */
    public function addTags(
        $addTagsUrl,
        $merchantId,
        $name,
        $certNo,
        $tagCode,
        $sourceFrom,
        $beforeYears,
        $terminal,
        $description,
        &$errorMessage = "success"
    )
    {
        $publicSecurity = new PublicSecurity();
        $result         = $publicSecurity
            ->apiId($this->appId)
            ->apiSecret($this->appSecret)
            ->certSn($this->certSn)
            ->addTagsUrl($addTagsUrl)
            ->merchantId($merchantId)
            ->name($name)
            ->certNo($certNo)
            ->atTagCode($tagCode)
            ->atSourceFrom($sourceFrom)
            ->atBeforeYears($beforeYears)
            ->atTerminal($terminal)
            ->atDescription($description)
            ->searchTags();
        if ($result === false) {
            $errorMessage = $publicSecurity->errorMessage;
            return false;
        }
        return $result;
    }
}