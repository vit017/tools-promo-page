<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';



use V_Corp\front\controllers\PromoController;
use V_Corp\base\Router;


Router::get('/promo/(\\w+)', [PromoController::class, 'show']);
Router::get('/', [PromoController::class, 'index']);

//throw new \V_Corp\base\exceptions\NotFoundHttpException('');