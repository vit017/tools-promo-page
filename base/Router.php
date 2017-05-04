<?php


namespace V_Corp\base;


use V_Corp\base\exceptions\NotFoundHttpException;

class Router
{

    private function __construct()
    {

    }

    private function __clone()
    {

    }

    protected static function matchUrl($url) {
        $parse_url = parse_url($_SERVER['REQUEST_URI']);
        preg_match('#^'.$url.'$#', $parse_url['path'], $matches);

        return (is_array($matches) && count($matches)) ? $matches : false;
    }

    public static function post($url, $handler)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== 'post') {
            return;
        }

        self::handle($url, $handler);
    }

    public static function get($url, $handler)
    {
        if (strtolower($_SERVER["REQUEST_METHOD"]) !== 'get') {
            return;
        }

        self::handle($url, $handler);
    }

    protected static function handle($url, $handler)
    {
        $matches = self::matchUrl($url);
        if (!$matches) {
            return;
        }

        $handler[1] = $handler[1] ?: ($matches[1] ?: 'index');

        if (method_exists($handler[0], $handler[1])) {
            call_user_func($handler, $matches[1]);
            exit();
        }
    }


}