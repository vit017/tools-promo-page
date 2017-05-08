<?php


namespace V_Corp\manager;

use V_Corp\base\Route;
use V_Corp\manager\controllers\PromoController;
use V_Corp\manager\controllers\ProductController;
use V_Corp\manager\views\ErrorView;


class RouteManager extends Route
{

    protected static $errorView = ErrorView::class;
    protected $method = [];

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

    protected function matches() {
        foreach ($this->methods as $url => $handler) {
            if ($matches = $this->matchUrl($url)) {
                if (2 === count($handler)) {
                    return ['handler' => $handler];
                }

                return ['handler' => [$handler[0], $matches[1]]];
            }
        }

        return null;
    }

    public function result($matches) {
        return ['handler' => $matches['handler']];
    }

}