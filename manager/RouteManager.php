<?php


namespace V_Corp\manager;

use V_Corp\manager\controllers\PromoController;
use V_Corp\manager\controllers\ProductController;


class RouteManager
{

    protected $urls = [
        'get' => [
            '/manager/' => [PromoController::class, 'index'],
            '/manager/promo/(\\w+)' => [PromoController::class],
            '/manager/products' => [ProductController::class, 'index'],
            '/manager/product/(\\w+)' => [ProductController::class]
        ],
        'post' => [
            '/manager/promo/(\\w+)' => [PromoController::class],
            '/manager/product/(\\w+)' => [ProductController::class]
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
                if (2 === count($handler)) {
                    return ['handler' => $handler];
                }

                return ['handler' => [$handler[0], $matches[1]]];
            }
        }

        return null;
    }

}