<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';



use V_Corp\manager\controllers\PromoController;
use V_Corp\manager\controllers\ProductController;
use V_Corp\base\Router;



Router::get('/manager/', [PromoController::class, 'index']);
Router::get('/manager/promo/(\\w+)', [PromoController::class]);

Router::get('/manager/products', [ProductController::class, 'index']);
Router::get('/manager/product/(\\w+)', [ProductController::class]);


Router::post('/manager/promo/(\\w+)', [PromoController::class]);
Router::post('/manager/product/(\\w+)', [ProductController::class]);
//throw new \V_Corp\base\exceptions\NotFoundHttpException('');