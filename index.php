<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/functions.php';


use V_Corp\base\App;
use V_Corp\front\RouteSite;


$app = App::instance();

$app->request((new RouteSite())->handle());

$app->terminate();