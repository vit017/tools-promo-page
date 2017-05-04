<?php


namespace V_Corp\base;

use V_Corp\base\Exception\NotFoundHttpException;
use V_Corp\base\Render;

class Router
{


    private function __construct()
    {

    }

    private function __clone()
    {

    }

    public static function post($url, $fn)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== 'post') {
            return;
        }

        if (str_replace('?'.$_SERVER["QUERY_STRING"], '', $_SERVER['REQUEST_URI']) !== $url) {
            return;
        }

        try {
            if (method_exists($fn[0], $fn[1])) {
                return call_user_func($fn, $url);
            }

            throw new NotFoundHttpException('Bad request', 400);
        } catch (NotFoundHttpException $e) {
            //Render::out(404);
        }
    }


    public static function get($url, $fn)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== 'get') {
            return;
        }

        if (str_replace('?'.$_SERVER["QUERY_STRING"], '', $_SERVER['REQUEST_URI']) !== $url) {
            return;
        }

        try {
            if (method_exists($fn[0], $fn[1])) {
                return call_user_func($fn, $url);
            }

            throw new NotFoundHttpException('Bad request', 400);
        } catch (NotFoundHttpException $e) {
            //Render::out(404);
        }
    }


}