<?php

namespace common\lib;

use Yii;
use yii\imagine\Image;
use yii\helpers\FileHelper;

class Imager {
    const IMAGES = "@storage/images";
    const RESIZE = "resize";
    const DS = "/";

    const WIMAGES = "/images";
    const NOTHUMB = "/unknown.png";

    public static function thumbnail($file, $width, $height = 0) {
        //первым делом проверяем, существует ли ориджин. если нет: отдаем nothumb
        //если да, проверяем, есть ли тамнейл. если да: отдаем тамнейл
        //если нет, делаем тамнейл и отдаем

        if(empty($file)) return self::NOTHUMB;

        $file = str_replace("\\", "/", $file);
        $ext = substr(strrchr($file, "."), 1);

        $images = Yii::getAlias(self::IMAGES);

        $originFile = $images . self::DS . $file;
        if(!file_exists($originFile)) return self::NOTHUMB;

        $thumbFile = $images . self::DS . self::RESIZE . self::DS . $file . "_" . $width . "x" . $height . "." .$ext;
        $thumbWeb = env('STORAGE_URL') . self::WIMAGES . self::DS . self::RESIZE . self::DS . $file . "_" . $width . "x" . $height . "." .$ext;
        if(!file_exists($thumbFile)) {
            $thumbPath = substr($thumbFile, 0, strrpos($thumbFile, self::DS));
            if(!file_exists($thumbPath)) FileHelper::createDirectory($thumbPath);

            Image::thumbnail($originFile, $width, $height)->save($thumbFile);
        }

        return $thumbWeb;
    }
}


?>