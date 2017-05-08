<?php


namespace V_Corp\front;

class Pagination extends \V_Corp\base\Pagination
{

    protected $viewPath = __DIR__ . '/views/pagination';
    protected $view = 'main.php';

    protected $param = 'page';
}