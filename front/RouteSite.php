<?php


namespace V_Corp\front;

use V_Corp\base\Route;
use V_Corp\front\controllers\PromoController;
use V_Corp\front\controllers\ProductController;
use V_Corp\front\views\ErrorView;


class RouteSite extends Route
{

    protected static $errorView = ErrorView::class;
    protected $methods = [];

    protected $urls = [
        'get' => [
            '/' => [PromoController::class, 'index'],
            '/promo/([\w-]+)' => [PromoController::class, 'show'],
        ]
    ];

    protected function matches() {
        foreach ($this->methods as $url => $handler) {
            if ($matches = $this->matchUrl($url)) {
                return [$handler, $matches[1]];
            }
        }

        return null;
    }

    public function result($matches) {
        return ['handler' => $matches[0], 'params' => $matches[1]];
    }

}