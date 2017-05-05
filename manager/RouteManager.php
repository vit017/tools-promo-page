<?php


namespace V_Corp\manager;

use V_Corp\manager\controllers\PromoController;
use V_Corp\manager\controllers\ProductController;
use V_Corp\base\Router;


class RouteManager
{

    protected $urls = [
        'get' => [
            '/manager/' => [PromoController::class, 'index'],
            '/manager/promo/(\\w+)' => [PromoController::class, 'show'],
            '/manager/products' => [ProductController::class, 'index'],
            '/manager/product/(\\w+)' => [ProductController::class, 'show']
        ],
        'post' => [
            '/manager/promo/(\\w+)' => [PromoController::class, 'show'],
            '/manager/product/(\\w+)' => [ProductController::class, 'show']
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
                return [$handler, array_slice($matches, 1)];
            }
        }

        return null;
    }

}