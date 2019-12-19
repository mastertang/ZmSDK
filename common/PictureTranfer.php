<?php

namespace ZmSDK\common;

/**
 * Class PictureTranfer
 * @package ZmSDK\common
 */
class PictureTranfer
{
    /**
     * @var array gd库图片索引列表
     */
    public $gdPictureIndexList = [
        1  => 'GIF',
        2  => 'JPEG',
        3  => 'PNG',
        4  => 'SWF',
        5  => 'PSD',
        6  => 'BMP',
        7  => 'TIFF_II',
        8  => 'TIFF_MM',
        9  => 'JPC',
        10 => 'JP2',
        11 => 'JPX',
        12 => 'JB2',
        13 => 'SWC',
        14 => 'IFF',
        15 => 'WBMP',
        16 => 'XBM',
        17 => 'ICO',
        18 => 'COUNT',
        19 => 'GD',
        20 => 'GD2',
        21 => 'XPM',
        23 => 'JPG'
    ];

    /**
     * @var string 错误信息
     */
    public $errorMessage = "";

    /**
     * 使用gd库获取图片内容
     *
     * @param $picture
     * @param string $width
     * @param string $height
     * @param string $type
     * @param string $attr
     * @param string $bits
     * @param string $channels
     * @param string $mime
     * @return array|bool
     */
    public function getPictureInfoByGd(
        $picture,
        &$width = '',
        &$height = '',
        &$type = '',
        &$attr = '',
        &$bits = '',
        &$channels = '',
        &$mime = ''
    )
    {
        $imageInfo = is_file($picture) ? getimagesize($picture) : getimagesizefromstring($picture);
        if ($imageInfo === false) {
            $this->errorMessage = is_file($picture) ? "Getimagesize Failed!" : "Getimagesizefromstring Failed!";
            return false;
        }
        list($width, $height, $type, $attr) = $imageInfo;
        $bits     = $imageInfo['bits'];
        $channels = $imageInfo['channels'];
        $mime     = $imageInfo['mime'];
        return $imageInfo;
    }

    /**
     * 获取图片后缀
     *
     * @param $picture
     * @return bool|string
     */
    public function getPictureSuffix($picture)
    {
        $imageInfo = is_file($picture) ? getimagesize($picture) : getimagesizefromstring($picture);
        if ($imageInfo === false) {
            $this->errorMessage = is_file($picture) ? "Getimagesize Failed!" : "Getimagesizefromstring Failed!";
            return false;
        }
        return $this->getGDPictureType($imageInfo['mime']);
    }

    /**
     * 根据图片类型索引获取图片后缀类型
     *
     * @param $typeIndex
     * @return bool|string
     */
    public function getGDPictureType($typeIndex)
    {
        if (!isset($this->gdPictureIndexList[$typeIndex])) {
            $this->errorMessage = "不支持当前图片格式:{$typeIndex}";
            return false;
        }
        return strtolower($this->gdPictureIndexList[$typeIndex]);
    }

    /**
     * 根据图片类型获取图片资源
     *
     * @param $picturePath
     * @param $typeIndex
     * @return bool|resource
     */
    public function getGDPictureResource(
        $picturePath,
        $typeIndex
    )
    {
        $suffix = false;
        if (is_int($typeIndex)) {
            $suffix = $this->getGDPictureType($typeIndex);
            if ($suffix === false) {
                return false;
            }
        } elseif (is_string($typeIndex)) {
            if (in_array(strtoupper($typeIndex), array_values($this->gdPictureIndexList))) {
                $suffix = $typeIndex;
            }
            if ($suffix === false) {
                $this->errorMessage = "不支持此图片格式:{$suffix}";
                return false;
            }
        }

        $imageResource = false;
        switch ($suffix) {
            case 'GIF':
                $imageResource = imagecreatefromgif($picturePath);
                break;
            case 'JPG':
            case 'JPEG':
                $imageResource = imagecreatefromjpeg($picturePath);
                break;
            case 'PNG':
                $imageResource = imagecreatefrompng($picturePath);
                break;
            case 'WBMP':
                $imageResource = imagecreatefromwbmp($picturePath);
                break;
            case 'XBM':
                $imageResource = imagecreatefromxbm($picturePath);
                break;
            case 'XPM':
                $imageResource = imagecreatefromxpm($picturePath);
                break;
            case 'STRING':
            default:
                $imageResource = imagecreatefromstring($picturePath);
                break;
        }

        if (is_resource($imageResource)) {
            $this->errorMessage = "创建图片资源失败! Path:{$picturePath}";
            return false;
        }
        return $imageResource;
    }

    /**
     * 根据路径获取图片的类型
     *
     * @param $filePath
     * @return bool|string
     */
    public function getPictureTypeByPath($filePath)
    {
        $suffix = $this->getFileSuffixByPath($filePath);
        if (!in_array(strtoupper($suffix), $this->gdPictureIndexList)) {
            $this->errorMessage = "不支持此路径的图片类型, Path : {$filePath} ";
            return false;
        }
        return $suffix;
    }

    /**
     * 根据路径获取文件的后缀
     *
     * @param $filePath
     * @return bool|string
     */
    public function getFileSuffixByPath($filePath)
    {
        $baseName = basename($filePath);
        $index    = strrpos($baseName, '.');
        if ($index === false) {
            return "";
        }
        return substr($baseName, $index + 1);
    }

    /**
     * 使用gd保存图片
     *
     * @param $typeIndex
     * @param $filePath
     * @param $resource
     * @param $quality
     * @return bool
     */
    public function saveGDPicture(
        $typeIndex,
        $filePath,
        $resource,
        $quality
    )
    {
        $suffix = false;
        if (is_int($typeIndex)) {
            $suffix = $this->getGDPictureType($typeIndex);
            if ($suffix === false) {
                return false;
            }
        } elseif (is_string($typeIndex)) {
            if (in_array(strtoupper($typeIndex), array_values($this->gdPictureIndexList))) {
                $suffix = $typeIndex;
            }
            if ($suffix === false) {
                $this->errorMessage = "不支持此图片格式:{$suffix}";
                return false;
            }
        }
        $result = false;
        switch ($suffix) {
            case 'GIF':
                $result = imagegif($resource, $filePath);
                break;
            case 'PNG':
                $result = imagepng($resource, $filePath, $quality <= 0 ? 9 : $quality);
                break;
            case 'WBMP':
                $result = imagewbmp($resource, $filePath);
                break;
            case 'XBM':
                $result = imagexbm($resource, $filePath);
                break;
            case 'GD':
                $result = imagegd($resource, $filePath);
                break;
            case 'GD2':
                $result = imagegd2($resource, $filePath);
                break;
            case 'XPM':
            case 'COUNT':
            case 'JPG':
            case 'SWF':
            case 'PSD':
            case 'BMP':
            case 'TIFF_II':
            case 'TIFF_MM':
            case 'JPC':
            case 'JP2':
            case 'JPX':
            case 'JB2':
            case 'SWC':
            case 'IFF':
            case 'JPEG':
            case 'ICO':
                $result = imagejpeg($resource, $filePath, $quality <= 0 ? 100 : $quality);
                break;
        }
        imagedestroy($resource);
        if ($result === false) {
            $this->errorMessage = "保存图片失败! Type : {$suffix}";
            return false;
        }
        return $result;
    }

    /**
     * 修改图片尺寸
     *
     * @param $picturePath
     * @param $savePath
     * @param null $reWidth
     * @param null $reHeight
     * @param null $ratio
     * @param int $quality
     * @param null $saveType
     * @param bool $deleteOld
     * @return bool
     */
    public function resizeImage(
        $picturePath,
        $savePath,
        $reWidth = null,
        $reHeight = null,
        $ratio = null,
        $quality = 0,
        $saveType = null,
        $deleteOld = false
    )
    {
        if (($saveSuffix = $this->getPictureTypeByPath($savePath)) === false) return false;
        if (($imageResult = $this->getPictureInfoByGd(
                $picturePath,
                $imageWidth,
                $imageHeight,
                $typeIndex
            )) === false) return false;

        if (($imageResource = $this->getGDPictureResource($picturePath, $typeIndex)) === false) return false;
        $newImageWidth  = $imageWidth;
        $newImageHeight = $imageHeight;
        if (!empty($ratio) && is_float($ratio)) {
            $newImageWidth  *= $ratio;
            $newImageHeight *= $ratio;
        } else {
            if (is_int($reWidth) && $reWidth > 1) {
                $newImageWidth = $reWidth;
            }
            if (is_int($reHeight) && $reHeight > 1) {
                $newImageHeight = $reHeight;
            }
        }
        $newImageResource = imagecreatetruecolor($newImageWidth, $newImageHeight);
        $result           = imagecopyresampled(
            $newImageResource, $imageResource,
            0, 0, 0, 0,
            $newImageWidth, $newImageHeight,
            $imageWidth, $imageHeight
        );
        imagedestroy($imageResource);
        if (!$result) {
            imagedestroy($newImageResource);
            $this->errorMessage = "Imagecopyresampled Failed";
            return false;
        }
        if (is_string($saveType) && !empty($saveType)) {
            if (in_array(strtoupper($saveType), array_values($this->gdPictureIndexList))) {
                $savePath   = str_replace('.' . $saveSuffix, '.' . strtolower($saveType), $savePath);
                $saveSuffix = strtolower($saveType);
            }
        }
        if (($result = $this->saveGDPicture($saveSuffix, $savePath, $newImageResource, $quality)) === false) return false;
        if ($result && $deleteOld) {
            unlink($picturePath);
        }
        return $result;
    }

    /**
     * 裁剪图片
     *
     * @param $picturePath
     * @param $savePath
     * @param $cutWidth
     * @param $cutHeight
     * @param $cutX
     * @param $cutY
     * @param int $quality
     * @param null $saveType
     * @param bool $deleteOld
     * @return bool
     */
    public function cutImage(
        $picturePath,
        $savePath,
        $cutWidth,
        $cutHeight,
        $cutX,
        $cutY,
        $quality = 0,
        $saveType = null,
        $deleteOld = false
    )
    {
        if (($saveSuffix = $this->getPictureTypeByPath($savePath)) === false) return false;
        if (($imageResult = $this->getPictureInfoByGd(
                $picturePath,
                $imageWidth,
                $imageHeight,
                $typeIndex
            )) === false) return false;
        if (($cutX + $cutWidth) > $imageWidth) {
            $cutWidth = $imageWidth - $cutX;
        }
        if (($cutY + $cutHeight) > $imageHeight) {
            $cutHeight = $imageHeight - $cutY;
        }
        if (($imageResource = $this->getGDPictureResource($picturePath, $typeIndex)) === false) return false;
        $newImageResource = imagecreatetruecolor($cutWidth, $cutHeight);
        $result           = imagecopyresampled(
            $newImageResource, $imageResource,
            0, 0, $cutX, $cutY,
            $cutWidth, $cutHeight,
            $cutWidth, $cutHeight
        );
        imagedestroy($imageResource);
        if (!$result) {
            imagedestroy($newImageResource);
            $this->errorMessage = "Imagecopyresampled Failed!";
            return false;
        }
        if (is_string($saveType) && !empty($saveType)) {
            if (in_array(strtoupper($saveType), array_values($this->gdPictureIndexList))) {
                $saveSuffix = strtolower($saveType);
            }
        }
        if (($result = $this->saveGDPicture($saveSuffix, $savePath, $newImageResource, $quality)) === false) return false;
        if ($result && $deleteOld) {
            unlink($picturePath);
        }
        return $result;
    }
}