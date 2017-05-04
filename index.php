<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';



use V_Corp\front\controllers\PromoController;
use V_Corp\base\Router;


Router::get('/', [PromoController::class, 'index']);
Router::get('/promo/(\\w+)', [PromoController::class, 'show']);

//throw new \V_Corp\base\exceptions\NotFoundHttpException('');