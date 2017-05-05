<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';


use V_Corp\base\App;
use V_Corp\manager\RouteManager;


$app = App::init();

$app->request((new RouteManager())->handle());

$app->terminate();

