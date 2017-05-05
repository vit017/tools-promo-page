<?php


namespace V_Corp\base;


class Filer
{

    public static $filePath = '/assets/files';
    public static $smallPath = '/small';
    public static $small_W = 300;
    public static $small_H = 200;


    public static function getPath()
    {
        return self::$filePath;
    }

    public static function setPath($path)
    {
        self::$filePath = $path;
    }

    public static function makeSmall($path, $name)
    {
        $server_path = $_SERVER['DOCUMENT_ROOT'] . $path;
        $img = self::createImg($server_path . '/' . $name);
        $small = imagescale($img, self::$small_W, self::$small_H);
        if (!is_dir($server_path . self::$smallPath)) {
            mkdir($server_path . self::$smallPath, 0755, true);
        }

        if (self::saveImg($small, $server_path . self::$smallPath . '/' . $name)) {
            return $path . self::$smallPath . '/' . $name;
        }

        return null;
    }

    public static function getPreview($path)
    {
        $arPath = explode('/', $path);
        $name = array_pop($arPath);
        $smallPath = implode('/', $arPath) . self::$smallPath;
        $imgPath = $smallPath . '/' . $name;
        
        if (!file_exists($imgPath)) {
            $imgPath = self::makeSmall(implode('/', $arPath), $name);
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
        $path = self::getPath() . '/' . $modelClass . '/' . $model->id;
        $server_path = $_SERVER['DOCUMENT_ROOT'] . $path;
        if (!is_dir($server_path)) {
            mkdir($server_path, 0755, true);
        }

        $name = str2url($file['name']);
        if (move_uploaded_file($file['tmp_name'], $server_path . '/' . $name)) {
            return $path . '/' . $name;
        }

        return false;
    }


}