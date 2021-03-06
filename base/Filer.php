<?php


namespace V_Corp\base;


class Filer
{

    public static $filePath = '/assets/files';
    public static $smallPath = '/small';

    public static function getPath()
    {
        return self::$filePath;
    }

    public static function setPath($path)
    {
        self::$filePath = $path;
    }

    public static function makeSmall($path, $name, $w, $h)
    {
        $serverPath = $_SERVER['DOCUMENT_ROOT'] . $path;
        $img = self::createImg($serverPath . '/' . $name);
        $small = imagescale($img, $w, $h);
        if (!is_dir($serverPath . self::$smallPath)) {
            mkdir($serverPath . self::$smallPath, 0755, true);
        }

        $name = $w . 'x' . $h. '_' . $name;

        if (self::saveImg($small, $serverPath . self::$smallPath . '/' . $name)) {
            return $path . self::$smallPath . '/' . $name;
        }

        return null;
    }

    public static function getPreview($path, $w, $h)
    {
        $arSize = getimagesize($_SERVER['DOCUMENT_ROOT'] . $path);
        list($width, $height) = [$arSize[0], $arSize[1]];
        $percent_W = ceil($w / $width * 100);
        $h = (int)ceil($height / 100 * $percent_W);
        $arPath = explode('/', $path);
        $name = array_pop($arPath);
        $smallPath = implode('/', $arPath) . self::$smallPath;
        $imgPath = $smallPath . '/' . $w . 'x' . $h. '_' . $name;

        if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/' . $imgPath)) {
            $imgPath = self::makeSmall(implode('/', $arPath), $name, $w, $h);
        }

        return $imgPath;
    }

    public static function saveImg($img, $to)
    {
        $type = pathinfo($to, PATHINFO_EXTENSION);
        switch ($type) {
            case 'jpeg':
            case 'jpg':
                return imagejpeg($img, $to);
                break;
            case 'png':
                return imagepng($img, $to);
                break;
            case 'gif':
                return imagegif($img, $to);
                break;
        }
    }

    public static function createImg($path)
    {
        $type = pathinfo($path, PATHINFO_EXTENSION);
        switch ($type) {
            case 'jpeg':
            case 'jpg':
                return imagecreatefromjpeg($path);
                break;
            case 'png':
                return imagecreatefrompng($path);
                break;
            case 'gif':
                return imagecreatefromgif($path);
                break;
        }
    }

    public static function upload($model, $file)
    {
        $modelClass = end(explode('\\', get_class($model)));
        $path = self::getPath() . '/' . $modelClass;
        $serverPath = $_SERVER['DOCUMENT_ROOT'] . $path;
        if (!is_dir($serverPath)) {
            mkdir($serverPath, 0755, true);
        }

        $name = str2url($file['name']);
        if (move_uploaded_file($file['tmp_name'], $serverPath . '/' . $name)) {
            return $path . '/' . $name;
        }

        return false;
    }


}