<?php


namespace V_Corp\front;

use V_Corp\front\controllers\PromoController;
use V_Corp\front\controllers\ProductController;
use V_Corp\base\Router;


class RouteSite
{

    protected $urls = [
        'get' => [
            '/' => [PromoController::class, 'index'],
            '/promo/(\\w+)' => [PromoController::class, 'show'],
        ]
    ];

    protected function matchUrl($url) {
        $parse_url = parse_url($_SERVER['REQUEST_URI']);
        preg_match('#^'.$url.'$#', $parse_url['path'], $matches);

        return (is_array($matches) && count($matches)) ? $matches : false;
    }


    public function handle()
    {
        $method = strtolower($_SERVER['REQUEST_METHOD']);
        if (!array_key_exists($method, $this->urls)) {
            return null;
        }

        foreach ($this->urls[$method] as $url => $handler) {
            if ($matches = $this->matchUrl($url)) {
                return ['handler' => $handler, 'params' =>$matches[1]];
            }
        }

        return null;
    }

}