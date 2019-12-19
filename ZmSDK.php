<?php

namespace ZmSDK;

use ZmSDK\src\FaceClient;
use ZmSDK\src\PublicSecurity;

/**
 * Class ZmSDK
 * @package ZmSDK
 */
class ZmSDK
{
    /**
     * @var null 人脸识别客户端
     */
    public $faceClient = null;

    /**
     * @var null 公共安全客户端
     */
    public $publicSecurityClient = null;

    /**
     * 识别客户端
     *
     * @return null|FaceClient
     */
    public function faceClient()
    {
        if ($this->faceClient instanceof FaceClient) {
            return $this->faceClient;
        }
        $this->faceClient = new FaceClient();
        return $this->faceClient;
    }

    /**
     * 重置faceClient
     *
     * @return $this
     */
    public function resetFaceClient()
    {
        $this->faceClient = null;
        return $this;
    }

    /**
     * 公共安全客户端
     *
     * @return null|PublicSecurity
     */
    public function publicSecurityClient()
    {
        if ($this->publicSecurityClient instanceof PublicSecurity) {
            return $this->publicSecurityClient;
        }
        $this->publicSecurityClient = new PublicSecurity();
        return $this->publicSecurityClient;
    }

    /**
     * 重置PublicSecurity
     *
     * @return $this
     */
    public function resetPublicSecurityClient()
    {
        $this->publicSecurityClient = null;
        return $this;
    }
}