<?php

require_once $_SERVER['DOCUMENT_ROOT'].'/functions.php';


use V_Corp\base\Router;
use V_Corp\manager\controllers\Backend;


Router::get('/manager/', [Backend::class, 'index']);
Router::get('/manager/add', [Backend::class, 'add']);
Router::get('/manager/delete', [Backend::class, 'delete']);
Router::get('/manager/update', [Backend::class, 'update']);


Router::post('/manager/update', [Backend::class, 'update']);